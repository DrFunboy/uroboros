//if ($modx->event->name != 'OnPageNotFound') {return false;}
// echo json_encode($json, JSON_UNESCAPED_UNICODE);
//if (defined('CLUB_FORWARD')) return false;
//define('CLUB_FORWARD', 1);

$rq = explode('/', $_REQUEST['q']);
if ($rq[0]=='qr.html') {
    if (!$qr = $modx->findResource('qr/')) return false; // если нет раздела выход
    $modx->sendForward($qr);
} elseif ($rq[0]=='hook') {
    $hook_file = "hook/{$rq[1]}.php";
    if (file_exists(CRMTOOLS_PATH.$hook_file)){
        include_once(CRMTOOLS_PATH.$hook_file);
        die;
    } elseif (file_exists(CRM_PATH.$hook_file)){
        include_once(CRM_PATH.$hook_file);
        die;
    }
}