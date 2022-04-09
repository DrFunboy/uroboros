<?php

$fids = array();
foreach ($json['rows'] as $n => $talk){
    $fids['idTalk'.$talk['id']] = $n;
}
foreach($modx->getIterator('idFiles', array(
    'key:IN' => array_keys($fids),
)) as $file) {
    $n = $fids[$file->get('key')];
    if (!empty($n)) {
        $fname = $file->get('filetype').'/'.$file->get('key').'.'.$file->get('fileext');
        $json['rows'][$n]['attach'] = $fname;
    }
}
$json['fids'] = $fids;
