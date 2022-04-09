$file = $modx->getOption('file', $scriptProperties, '');
$local_path = MODX_ASSETS_PATH.'clubtools/tmpl/'.CRM_PREFIX;
//city
if (!empty($_SESSION['club_city'])) {
    $file_city = $local_path.$_SESSION['club_city'].'/'.$file;
    if (file_exists($file_city)) return $file_city;
}
// local
$file_local = $local_path.'/'.$file;
if (file_exists($file_local)) return $file_local;

return MODX_ASSETS_PATH.'id/tmpl/'.$file;