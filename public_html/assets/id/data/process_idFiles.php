<?php
foreach($json['rows'] as $n => $v) {
    $path = CRM_FILES."{$v['filetype']}/{$v['key']}.{$v['fileext']}";
    $json['rows'][$n]['file_exists'] = file_exists($path);
    //$json['rows'][$n]['path'] = $path;
}