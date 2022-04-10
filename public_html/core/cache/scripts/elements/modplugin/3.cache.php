<?php  return 'define(\'CRM_PATH\', MODX_ASSETS_PATH.\'id/\');
define(\'CRM_URL\', MODX_ASSETS_URL.\'id/\');
define(\'CRM_FILES\', MODX_BASE_PATH.\'files/\');

define(\'CRMTOOLS_PATH\', MODX_ASSETS_PATH.\'clubtools/\');
define(\'CRMTOOLS_URL\', MODX_ASSETS_URL.\'clubtools/\');
define(\'CRM_LOGS\', MODX_ASSETS_PATH.\'scrm_log/\');

//$modx->loadClass(\'modResource\'); // здесь потому что при сохранении в mgr 
/*$modx->map[\'modResource\'][\'fields\'][\'club_id\'] = 0;
$modx->map[\'modResource\'][\'fieldMeta\'][\'club_id\'] = array(
	\'dbtype\' => \'int\',
	\'phptype\' => \'integer\',
	\'null\' => false,
	\'default\' => 0,
);*/

if ($modx->context->key == \'web\') {
    include_once(CRM_PATH.\'club_func.php\');
    
    /*$www = $modx->cacheManager->get("www");
    if (empty($www)) {
        $www = array();
        foreach ($modx->getIterator(\'modUserGroup\', array(\'name:LIKE\' => \'www_%\')) as $gr) {
            $www[$gr->get(\'description\')] = str_replace(\'www_\', \'\', $gr->get(\'name\'));
        }
        $modx->cacheManager->set("www", $www, 604800*4); //4*7 дней
    }*/
    
    define(\'CRM_PREFIX\', \'ur_\');
    
    $userID = clubUser();
    if (!empty($userID)) {
        $userGroups = $modx->user->getUserGroupNames();
    } else {
        $userGroups = array();
    }
    
    $modx->addPackage(\'idDB\', CRM_PATH.\'start/model/\', CRM_PREFIX);

    $cache_path = CRM_PREFIX.\'/clubConfig/init\';
    $club_opts = $modx->cacheManager->get($cache_path);
    if (empty($club_opts)) {
        $club_opts = clubConfig(\'club_modules,https\', 0, 1);

        $club_opts[\'club_modules\'] = empty($club_opts[\'club_modules\'])? array() : explode(\',\', $club_opts[\'club_modules\']);
        array_unshift($club_opts[\'club_modules\'], \'clubStuff\', CRM_PREFIX);
        $club_opts[\'crm_url\'] = CRM_URL;
        $club_opts[\'crmtools_url\'] = CRMTOOLS_URL;
        $modx->cacheManager->set($cache_path, $club_opts, 86400*3); // 3 дней
    }
    
    $club_opts[\'club_name\'] = $modx->getOption(\'site_name\');
    $club_opts[\'scrm_ugroups\'] = $userGroups;
    $club_opts[\'scrm_grhash\'] = empty($userGroups)? \'empty\' : cacheHash($userGroups);
    $club_opts[\'vers\'] = $modx->getOption(\'vers\');
    $club_opts[\'scrm_prugv\'] = cacheHash(array(CRM_PREFIX, $userID, $club_opts[\'scrm_grhash\'], $club_opts[\'vers\']));
    
    foreach($club_opts as $okey => $oval) {
        $modx->setOption($okey, $oval);
    }
    $club_opts[\'site_url\'] = $modx->getOption(\'site_url\');
    $modx->setPlaceholders($club_opts, \'+\');
    
    $rq = explode(\'/\', $_REQUEST[\'q\']);
    
    $hooks = array(
        \'hook\' => "hook/{$rq[1]}.php",
        \'pay\' => \'hook/pay.php\',
        \'paycb\' => \'hook/pay.php\',
        \'js\' => \'hook/js.php\',
        \'data\' => \'club_data.php\',
        \'chunk\' => \'hook/chunk.php\',
        \'setup\' => \'setup/hook.php\',
    );
    $hook_file = $hooks[ $rq[0] ];
    if (!empty($hook_file)) {
        foreach (glob(\'{\'.implode(\',\', [CRMTOOLS_PATH, CRM_PATH]).\'}\'.$hook_file, GLOB_BRACE) as $hf) {
            include_once($hf);
            if (!empty($json)) echo( json_encode($json, JSON_UNESCAPED_UNICODE) );
            die;
        }
        /*if (file_exists(CRMTOOLS_PATH.$hook_file)){
            include_once(CRMTOOLS_PATH.$hook_file);
            die;
        } elseif (file_exists(CRM_PATH.$hook_file)){
            include_once(CRM_PATH.$hook_file);
            die;
        }*/
    }
}
return;
';