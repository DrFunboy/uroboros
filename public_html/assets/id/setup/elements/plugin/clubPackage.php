define('CRM_PATH', MODX_ASSETS_PATH.'id/');
define('CRM_URL', MODX_ASSETS_URL.'id/');
define('CRM_FILES', MODX_BASE_PATH.'files/');

define('CRMTOOLS_PATH', MODX_ASSETS_PATH.'clubtools/');
define('CRMTOOLS_URL', MODX_ASSETS_URL.'clubtools/');
define('CRM_LOGS', MODX_ASSETS_PATH.'scrm_log/');

//$modx->loadClass('modResource'); // здесь потому что при сохранении в mgr 
$modx->map['modResource']['fields']['club_id'] = 0;
$modx->map['modResource']['fieldMeta']['club_id'] = array(
	'dbtype' => 'int',
	'phptype' => 'integer',
	'null' => false,
	'default' => 0,
);

if ($modx->context->key == 'web') {
    include_once(CRM_PATH.'club_func.php');
    
    include(CRMTOOLS_PATH.'start/wprefix.php');

    $http_host = strtolower($_SERVER['HTTP_HOST']);
    /*$www = $modx->cacheManager->get("www");
    if (empty($www)) {
        $www = array();
        foreach ($modx->getIterator('modUserGroup', array('name:LIKE' => 'www_%')) as $gr) {
            $www[$gr->get('description')] = str_replace('www_', '', $gr->get('name'));
        }
        $modx->cacheManager->set("www", $www, 604800*4); //4*7 дней
    }*/
    
    $prefix = empty($www[$http_host])? 'id' : $www[$http_host]['prefix'];
    define('CRM_PREFIX', $prefix.'_');
    
    $userID = clubUser();
    if (!empty($userID)) {
        $userGroups = $modx->user->getUserGroupNames();
        if ((sizeof($www) > 1) && !in_array('Administrator', $userGroups) && !in_array('www_'.$prefix, $userGroups)) {
            $modx->user->endSession();
            $modx->sendRedirect('/');
        }
    } else {
        $userGroups = array();
    }

    $modx->addPackage('idDB', CRM_PATH.'start/model/', CRM_PREFIX);

    $cache_path = CRM_PREFIX.'/clubConfig/init';
    $club_opts = $modx->cacheManager->get($cache_path);
    if (empty($club_opts)) {
        $club_opts = clubConfig('site_name,site_fullname,club_key,club_logo,club_modules,https', 0, 1);
        if (!$club_opts['club_logo']) {
            $club_opts['club_logo'] = CRM_URL.'images/sportcrm_logo.png';
        }
        /*$logoFl = $modx->getObject('idFiles', array('uid' => 'logoClub'));
        $logoFl = empty($logoFl)? 'empty' : "{$logoFl->get('filetype')}/{$logoFl->get('key')}.{$logoFl->get('fileext')}";
        include_once(CRM_PATH.'club_thumb.php');
        $club_opts['club_logo'] = getClubThumb($logoFl, 'logo', 'crm');*/

        $club_opts['club_modules'] = empty($club_opts['club_modules'])? array() : explode(',', $club_opts['club_modules']);
        array_unshift($club_opts['club_modules'], 'clubStuff', CRM_PREFIX);
        $club_opts['crm_url'] = CRM_URL;
        $club_opts['crmtools_url'] = CRMTOOLS_URL;
        $modx->cacheManager->set($cache_path, $club_opts, 86400*3); // 3 дней
    }

    if (!empty($club_opts['https'])) {
        $isHttps = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        || (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] === 'https')
        || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
        if (!$isHttps) {
            $modx->sendRedirect('https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], array(
                'responseCode' => 'HTTP/1.1 301 Moved Permanently')
            );
        } else {
            //$modx->setOption('site_url', 'https://'.$_SERVER['HTTP_HOST']);
            $modx->setOption('server_protocol', 'https');
        }
    }
    
    $club_opts['club_name'] = $club_opts['site_name'];
    $club_opts['scrm_ugroups'] = $userGroups;
    $club_opts['scrm_grhash'] = empty($userGroups)? 'empty' : cacheHash($userGroups);
    $club_opts['vers'] = $modx->getOption('vers');
    $club_opts['scrm_prugv'] = cacheHash(array(CRM_PREFIX, $userID, $_SESSION['scrm_thislogin'], $club_opts['vers']));
    
    foreach($club_opts as $okey => $oval) {
        $modx->setOption($okey, $oval);
    }
    $club_opts['site_url'] = $modx->getOption('site_url');
    $modx->setPlaceholders($club_opts, '+');
    
    $rq = explode('/', $_REQUEST['q']);
    
    $club_modules = implode(',', $club_opts['club_modules']);
    define('CRM_START', MODX_ASSETS_PATH.'{clubtools,id}/start/{'. $club_modules .'}_');
    foreach (glob(CRM_START.'init.php', GLOB_BRACE) as $data_handler) require($data_handler);

    $hooks = array(
        'hook' => "hook/{$rq[1]}.php",
        'pay' => 'hook/pay.php',
        'paycb' => 'hook/pay.php',
        'js' => 'hook/js.php',
        'data' => 'club_data.php',
        'chunk' => 'hook/chunk.php',
        'setup' => 'setup/hook.php',
    );
    $hook_file = $hooks[ $rq[0] ];
    if (!empty($hook_file)) {
        foreach (glob('{'.implode(',', [CRMTOOLS_PATH, CRM_PATH]).'}'.$hook_file, GLOB_BRACE) as $hf) {
            include_once($hf);
            if (!empty($json)) {
                echo json_encode($json, JSON_UNESCAPED_UNICODE);
            }
            die;
        }
    }
}