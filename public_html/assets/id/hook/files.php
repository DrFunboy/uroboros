<?php

if (!defined('SCRMBUCKET')) define('SCRMBUCKET', 'scrm');

$uid = $modx->getOption('uid', $scriptProperties, $_REQUEST['uid']);
$filter = $modx->getOption('filter', $scriptProperties, $_REQUEST['filter']);
$cls = $modx->getOption('cls', $scriptProperties, $_REQUEST['cls']);
$thumb = $modx->getOption('thumb', $scriptProperties, $_REQUEST['thumb']);

$fullperm = array(
    'idAdmin' => 'list,add,edit,modify',
    'idManager' => 'list,add,edit', // Может перенести в настройки
);

$ugroups = $modx->getOption('scrm_ugroups');
$ugroups[] = 'all';
$filetypes = array();
foreach (getClubStatus('idFileType') as $fkey => $fval) {
    if (!empty($cls) && $fval['cls'] != $cls) continue;
    
    $fval['extended'] = $ft_ext = array_merge($fullperm, (array)$fval['extended']); // Добавляет в каждый тип полные разрешения
    $user_perms = array_intersect($ugroups, array_keys($ft_ext)); // смотрит какие разрешения пересекаются с файлом
    if (empty($user_perms)) continue;

    $perm = array();
    foreach($user_perms as $uperm) {
        foreach(explode(',', $ft_ext[$uperm]) as $p) {
            $perm[] = $p;
        }
    }
    if (empty($perm)) continue;

    $fval['permis'] = array_values(array_unique($perm));
    $fval['thumb'] = $ft_ext['thumb'];
    $filetypes[ $fval['alias'] ] = $fval;
}

$json = array(
    'postData' => array(
        'fid' => $modx->getOption('fid', $scriptProperties, $_REQUEST['fid'])?: $uid,
        'uid' => $uid,
        'filter' => $filter,
        'cls' => $cls,
        'thumb' => $thumb,
    ),
    'rows' => array(),
    'error' => '',
    'filetypes' => $filetypes,
);


if (!empty($uid)) {
    if (!empty($thumb)) include_once(CRM_PATH.'club_thumb.php');

    $oper = $_REQUEST['oper'];
    $newCloud = array();
    
    if (!empty($oper)) {
        require_once(CRM_PATH.'club_cloud.php');
        
        $filetype = $modx->getOption('filetype', $_REQUEST, 'file', true);

        if ($oper=='del'){
            $delFile = $modx->getObject('idFiles', array(
                'key' => $_REQUEST['fkey'],
            ));
            if (!empty($delFile)) $filetype = $delFile->get('filetype');
        }

        if ($oper=='modify') {
            $delFile = $modx->getObject('idFiles', array(
                'uid' => $uid,
                'filetype' => $filetype,
            ));
        }
        
        $oper_ft = $filetypes[ $filetype ];
        $oper_permis = empty($oper_ft)? [ ] : $oper_ft['permis'];
        
        if (!empty($delFile) && !empty(array_intersect(['edit','modify'], $oper_permis))){
            $del_id = clubDelFile($delFile, $s3Client);
            if (!$del_id) {
                $json['error'] = "Error deleting file {$delFile->name};";
            } else {
                $delFile->remove();
            }
        }


        if (in_array($oper, ['add','modify']) && !empty($_FILES) && in_array($oper, $oper_permis)) {
            $json['debug'] = $_FILES;
            foreach($_FILES as $file) {
                //$modx->log(modX::LOG_LEVEL_ERROR, json_encode($file, JSON_UNESCAPED_UNICODE) );
                $path = pathinfo($file["name"]);
                $extension = strtolower($path['extension']);
                if ($extension == 'php') die('PHP upload');
                
                $filekey = uniqid(substr(CRM_PREFIX, 0, 5), true);
                $filePath = "{$filetype}/{$filekey}.{$extension}";
                $idFile = $modx->newObject('idFiles', array(
                    'uid' => $uid,
                    'key' => $filekey,
                    'fileext' => $extension,
                    'filetype' => $filetype,
                    'author' => $modx->getLoginUserID(),
                    'name' => $modx->getOption('filename', $_REQUEST, $path['filename'], true),
                ));
                
                if (!is_null($s3Client) && !$oper_ft['extended']['nocloud']) {
                    //$fileBody = file_get_contents($file['tmp_name']);
                    if (clubPutFile($file['tmp_name'], $filePath, $s3Client)) {
                        $idFile->set('incloud', 1);
                        $idFile->save();
                        $newCloud[$filekey] = true;
                    } else {
                        $json['error'] .= "Error uploading file {$filePath};";
                    }
                } else {
                    $dir = CRM_FILES.$filetype.'/';
                    $filePath = CRM_FILES.$filePath;
                    if (!is_dir($dir) && !mkdir($dir, 0755, true)){
                        $json['error'] .= "Error creating folder {$dir}";
                    } elseif (move_uploaded_file($file['tmp_name'], $filePath)) {
                        $idFile->save();
                        if ($uid=='logoClub') {
                            setClubConfig('club_logo', getClubThumb($idFile->toArray(), 'logo'));
                        }
                    } else {
                        $json['error'] .= "Error uploading file {$filePath};";
                    }
                }
            }
        }
    } // if oper

    $w = array(
        'filetype:IN' => array_keys($filetypes),
    );
    clubWhereIN($w, $uid, 'uid');
    if (!empty($filter)) $w['filetype'] = $filter; //TODO: Возможно исправить

    $wq = $modx->newQuery('idFiles', $w);
    $wq->leftJoin('idStatus', 'ft', "(ft.alias = idFiles.filetype AND ft.tbl = 'idFileType' AND ft.published=1)");
    $wq->select(array(
        'idFiles.*',
        'ft.name as filetype_name',
    ));
    
    foreach ($modx->getIterator('idFiles', $wq) as $idF => $idFile) {
        $rowFile = $idFile->toArray();
        $ft = $filetypes[ $rowFile['filetype'] ];
        //if (empty($ft)) continue; // перенесено в SQL
        $ft_permis = $ft['permis'];
        if (empty($ft_permis) || !in_array('list', $ft_permis)) continue;
        $rowFile['permis'] = $ft_permis;
        
        $rowFile['filepath'] = clubFileUrl($rowFile);
        if (!empty($thumb) && !empty($ft['thumb'])) {
            foreach($ft['thumb'] as $size) {
                if ($rowFile['incloud']) {
                    $rowFile[ $size ] = clubFileUrl($rowFile, $size);
                } else {
                    $rowFile[ $size ] = getClubThumb($rowFile, $size); //$json['gender']
                }
            }
            //getClubThumb($photo['file'], 'thumb', $json['gender']);
        }
        $rowFile['newCloud'] = $newCloud[ $rowFile['key'] ];
        $json['rows'][] = $rowFile;
    }
}

if ($rq[2] == 'cron') {
    ignore_user_abort(true);
    set_time_limit(0);
    
    setClubConfig('filecloud', 1);

    require_once(CRM_PATH.'club_cloud.php');
    if (empty($s3Client)) dieJSON('Can`t connect to S3');

    $cloud_ft = array();
    foreach($filetypes as $ft_key => $ft) {
        if (!$ft['extended']['nocloud']) $cloud_ft[] = $ft_key;
    }
    $json = array(
        'filecnt' => 0,
        'cloud_ft' => $cloud_ft,
    );

    $query = $modx->newQuery('idFiles', array(
        'incloud' => 0,
        'filetype:IN' => $cloud_ft,
    ));
    $query->limit(200);
    foreach ($modx->getIterator('idFiles', $query) as $file) {
        $filePath = "{$file->filetype}/{$file->key}.{$file->fileext}";
        if (clubPutFile(CRM_FILES.$filePath, $filePath, $s3Client)) {
            $file->set('incloud', 1);
            if ($file->save() == true) {
               unlink(CRM_FILES.$filePath);
               $json['filecnt']++;
            }
        }
    }
}
