if (!empty($unauth)) define('CLUB_UNAUTH', true);

$rq = array_merge($_REQUEST, $scriptProperties);
//$rq['table'] = $modx->getOption('table', $scriptProperties, $rq['table']);
require_once(MODX_ASSETS_PATH.'id/id_data.php');