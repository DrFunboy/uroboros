<?php

if ($thumb_filetype) {
    if (empty($thumb_size)) $thumb_size = 'thumb';
    include_once(CRM_PATH.'club_thumb.php');
    foreach($json['rows'] as $n => $v) {
        $fn = explode(',', $v[$thumb_filetype])[0];
        if (!empty($fn)) $fn = "{$thumb_filetype}/{$fn}";
        $json['rows'][$n]['thumb'] = getClubThumb($fn, $thumb_size, $v['gender']);
    }
}