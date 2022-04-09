//if ($modx->event->name != 'OnPageNotFound') {return false;}
// echo json_encode($json, JSON_UNESCAPED_UNICODE);
//if (defined('CLUB_FORWARD')) return false;
//define('CLUB_FORWARD', 1);

$rq = explode('/', $_REQUEST['q']);
if ($rq[0]=='qr.html') {
    if (!$qr = $modx->findResource('qr/')) return false; // если нет раздела выход
    $modx->sendForward($qr);
}