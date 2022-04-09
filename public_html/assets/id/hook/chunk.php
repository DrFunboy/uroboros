<?php

$rqData = $_REQUEST;
$rqData['rq'] = '/'.implode('/', $rq);
switch ($rq[1]) {
    case 'html':
        $rqData['HTMLBlock'] = json_encode( getClubConfig($rq[2].'HTMLBlock') );
        break;
}

$chunkFile = __DIR__."/chunk/{$rq[1]}.html";
if (file_exists($chunkFile)) {
    $chunkHtml = file_get_contents($chunkFile);
    $wModule = array(
        'tbl' => 'idModule',
        'cls' => $rqData['rq'],
    );
    foreach(getClubStatus($wModule, null, 'cfg') as $module) {
        $chunkHtml .= $module['cfg'];
    }
} else {
    $chunkHtml = getClubConfig($rq[1].'HTMLBlock');
}

echo empty($chunkHtml)? '' : clubTmpl($chunkHtml, $rqData);

$seconds_to_cache = 3600*24*4; // 4 дней
$ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
header("Expires: $ts");
header("Pragma: cache");
header("Cache-Control: max-age=$seconds_to_cache");