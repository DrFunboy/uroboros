<?php

include_once(CRM_PATH. 'phplib/qr/qrlib.php');
include_once(CRM_PATH. 'club_thumb.php');

$url = $modx->getOption('site_url') . 'qr?key=';

$cnt = count($data['rows']);
$Doc->cloneBlock('anketa', $cnt, true, true);

$rn = 1; $keys = array();
foreach($data['rows'] as $n => $row) {
    $keys[ $row['key'] ] = array($rn, $row['gender'], '');
    foreach ($row as $key => $val) {
        if ($key == 'birth' && !empty($val)) {
            $val = (new DateTime($val))->format('d.m.Y');
        }
        if ($key!= 'photo') $Doc->setValue($key.'#'.$rn, $val, 1);
    }
    
    $temp_png = tempnam(sys_get_temp_dir(), 'QRcode').'.png';
    $temp[] = $temp_png;
    QRcode::png($url.$row['key'], $temp_png, QR_ECLEVEL_L, 3, 0); // size, margin
    $Doc->setImageValue("qr#$rn", $temp_png);

    $pb = ($rn == $cnt)? '' : '<w:p><w:r><w:br w:type="page"/></w:r></w:p>';
    $Doc->setValue("pageBr#$rn", $pb, 1);
    
    $rn++;
}

$w = $modx->newQuery('idFiles', array(
    'uid:IN' => array_keys($keys),
    'filetype' => 'photo',
));
foreach($modx->getIterator('idFiles', $w) as $key => $file) {
    $f = $file->toArray();
    if (!empty($keys[ $f['uid'] ])) $keys[ $f['uid'] ][2] = $f;
}

foreach($keys as $row) {
    $photo = getClubThumb($row[2], 'thumb', $row[1]);
    $Doc->setImageValue('photo#'.$row[0], MODX_BASE_PATH.$photo);
}
