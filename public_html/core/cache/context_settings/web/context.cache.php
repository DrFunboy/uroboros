<?php  return array (
  'config' => 
  array (
  ),
  'aliasMap' => 
  array (
    'index.html' => 1,
    'dashboard.html' => 3,
    'reestr.html' => 4,
    'adm/' => 5,
    'login/' => 7,
    'projects/' => 12,
    'adm/opts.html' => 2,
    'adm/users.html' => 6,
    'adm/util.html' => 9,
    'adm/import.html' => 10,
    'login/forgotpassword.html' => 8,
    'login/agreement.html' => 11,
    'projects/widget/' => 13,
  ),
  'resourceMap' => 
  array (
    0 => 
    array (
      0 => 1,
      1 => 3,
      2 => 4,
      3 => 5,
      4 => 7,
      5 => 12,
    ),
    5 => 
    array (
      0 => 2,
      1 => 6,
      2 => 9,
      3 => 10,
    ),
    7 => 
    array (
      0 => 8,
      1 => 11,
    ),
    12 => 
    array (
      0 => 13,
    ),
  ),
  'webLinkMap' => 
  array (
    5 => '/',
    7 => '/',
  ),
  'eventMap' => 
  array (
    'OnChunkFormPrerender' => 
    array (
      1 => '1',
    ),
    'OnDocFormPrerender' => 
    array (
      1 => '1',
    ),
    'OnFileCreateFormPrerender' => 
    array (
      1 => '1',
    ),
    'OnFileEditFormPrerender' => 
    array (
      1 => '1',
    ),
    'OnLoadWebDocument' => 
    array (
      6 => '6',
    ),
    'OnMODXInit' => 
    array (
      2 => '2',
      3 => '3',
    ),
    'OnPluginFormPrerender' => 
    array (
      1 => '1',
    ),
    'OnRichTextEditorRegister' => 
    array (
      1 => '1',
    ),
    'OnSiteRefresh' => 
    array (
      2 => '2',
    ),
    'OnSnipFormPrerender' => 
    array (
      1 => '1',
    ),
    'OnTempFormPrerender' => 
    array (
      1 => '1',
    ),
    'OnTVInputRenderList' => 
    array (
      1 => '1',
    ),
    'OnWebLogin' => 
    array (
      5 => '5',
    ),
    'OnWebPagePrerender' => 
    array (
      2 => '2',
    ),
  ),
  'pluginCache' => 
  array (
    1 => 
    array (
      'id' => '1',
      'source' => '0',
      'property_preprocess' => '0',
      'name' => 'Ace',
      'description' => 'Ace code editor plugin for MODx Revolution',
      'editor_type' => '0',
      'category' => '0',
      'cache_type' => '0',
      'plugincode' => '/**
 * Ace Source Editor Plugin
 *
 * Events: OnManagerPageBeforeRender, OnRichTextEditorRegister, OnSnipFormPrerender,
 * OnTempFormPrerender, OnChunkFormPrerender, OnPluginFormPrerender,
 * OnFileCreateFormPrerender, OnFileEditFormPrerender, OnDocFormPrerender
 *
 * @author Danil Kostin <danya.postfactum(at)gmail.com>
 *
 * @package ace
 *
 * @var array $scriptProperties
 * @var Ace $ace
 */
if ($modx->event->name == \'OnRichTextEditorRegister\') {
    $modx->event->output(\'Ace\');
    return;
}

if ($modx->getOption(\'which_element_editor\', null, \'Ace\') !== \'Ace\') {
    return;
}

$corePath = $modx->getOption(\'ace.core_path\', null, $modx->getOption(\'core_path\').\'components/ace/\');
$ace = $modx->getService(\'ace\', \'Ace\', $corePath.\'model/ace/\');
$ace->initialize();

$extensionMap = array(
    \'tpl\'   => \'text/x-smarty\',
    \'htm\'   => \'text/html\',
    \'html\'  => \'text/html\',
    \'css\'   => \'text/css\',
    \'scss\'  => \'text/x-scss\',
    \'less\'  => \'text/x-less\',
    \'svg\'   => \'image/svg+xml\',
    \'xml\'   => \'application/xml\',
    \'xsl\'   => \'application/xml\',
    \'js\'    => \'application/javascript\',
    \'json\'  => \'application/json\',
    \'php\'   => \'application/x-php\',
    \'sql\'   => \'text/x-sql\',
    \'md\'    => \'text/x-markdown\',
    \'txt\'   => \'text/plain\',
    \'twig\'  => \'text/x-twig\'
);

// Define default mime for html elements(templates, chunks and html resources)
$html_elements_mime=$modx->getOption(\'ace.html_elements_mime\',null,false);
if(!$html_elements_mime){
    // this may deprecated in future because components may set ace.html_elements_mime option now
    switch (true) {
        case $modx->getOption(\'twiggy_class\'):
            $html_elements_mime = \'text/x-twig\';
            break;
        case $modx->getOption(\'pdotools_fenom_parser\'):
            $html_elements_mime = \'text/x-smarty\';
            break;
        default:
            $html_elements_mime = \'text/html\';
    }
}

// Defines wether we should highlight modx tags
$modxTags = false;
switch ($modx->event->name) {
    case \'OnSnipFormPrerender\':
        $field = \'modx-snippet-snippet\';
        $mimeType = \'application/x-php\';
        break;
    case \'OnTempFormPrerender\':
        $field = \'modx-template-content\';
        $modxTags = true;
        $mimeType = $html_elements_mime;
        break;
    case \'OnChunkFormPrerender\':
        $field = \'modx-chunk-snippet\';
        if ($modx->controller->chunk && $modx->controller->chunk->isStatic()) {
            $extension = pathinfo($modx->controller->chunk->name, PATHINFO_EXTENSION);
            if(!$extension||!isset($extensionMap[$extension])){
                $extension = pathinfo($modx->controller->chunk->getSourceFile(), PATHINFO_EXTENSION);
            }
            $mimeType = isset($extensionMap[$extension]) ? $extensionMap[$extension] : \'text/plain\';
        } else {
            $mimeType = $html_elements_mime;
        }
        $modxTags = true;
        break;
    case \'OnPluginFormPrerender\':
        $field = \'modx-plugin-plugincode\';
        $mimeType = \'application/x-php\';
        break;
    case \'OnFileCreateFormPrerender\':
        $field = \'modx-file-content\';
        $mimeType = \'text/plain\';
        break;
    case \'OnFileEditFormPrerender\':
        $field = \'modx-file-content\';
        $extension = pathinfo($scriptProperties[\'file\'], PATHINFO_EXTENSION);
        $mimeType = isset($extensionMap[$extension])
            ? $extensionMap[$extension]
            : (\'@FILE:\'.pathinfo($scriptProperties[\'file\'], PATHINFO_BASENAME));
        $modxTags = $extension == \'tpl\';
        break;
    case \'OnDocFormPrerender\':
        if (!$modx->controller->resourceArray) {
            return;
        }
        $field = \'ta\';
        $mimeType = $modx->getObject(\'modContentType\', $modx->controller->resourceArray[\'content_type\'])->get(\'mime_type\');

        if($mimeType == \'text/html\')$mimeType = $html_elements_mime;

        if ($modx->getOption(\'use_editor\')){
            $richText = $modx->controller->resourceArray[\'richtext\'];
            $classKey = $modx->controller->resourceArray[\'class_key\'];
            if ($richText || in_array($classKey, array(\'modStaticResource\',\'modSymLink\',\'modWebLink\',\'modXMLRPCResource\'))) {
                $field = false;
            }
        }
        $modxTags = true;
        break;
    case \'OnTVInputRenderList\':
        $modx->event->output($corePath . \'elements/tv/input/\');
        break;
    default:
        return;
}

$modxTags = (int) $modxTags;
$script = \'\';
if ($field) {
    $script .= "MODx.ux.Ace.replaceComponent(\'$field\', \'$mimeType\', $modxTags);";
}

if ($modx->event->name == \'OnDocFormPrerender\' && !$modx->getOption(\'use_editor\')) {
    $script .= "MODx.ux.Ace.replaceTextAreas(Ext.query(\'.modx-richtext\'));";
}

if ($script) {
    $modx->controller->addHtml(\'<script>Ext.onReady(function() {\' . $script . \'});</script>\');
}',
      'locked' => '0',
      'properties' => NULL,
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => 'ace/elements/plugins/ace.plugin.php',
    ),
    2 => 
    array (
      'id' => '2',
      'source' => '1',
      'property_preprocess' => '0',
      'name' => 'pdoTools',
      'description' => '',
      'editor_type' => '0',
      'category' => '2',
      'cache_type' => '0',
      'plugincode' => '/** @var modX $modx */
switch ($modx->event->name) {

    case \'OnMODXInit\':
        $fqn = $modx->getOption(\'pdoTools.class\', null, \'pdotools.pdotools\', true);
        $path = $modx->getOption(\'pdotools_class_path\', null, MODX_CORE_PATH . \'components/pdotools/model/\', true);
        $modx->loadClass($fqn, $path, false, true);

        $fqn = $modx->getOption(\'pdoFetch.class\', null, \'pdotools.pdofetch\', true);
        $path = $modx->getOption(\'pdofetch_class_path\', null, MODX_CORE_PATH . \'components/pdotools/model/\', true);
        $modx->loadClass($fqn, $path, false, true);
        break;

    case \'OnSiteRefresh\':
        /** @var pdoTools $pdoTools */
        if ($pdoTools = $modx->getService(\'pdoTools\')) {
            if ($pdoTools->clearFileCache()) {
                $modx->log(modX::LOG_LEVEL_INFO, $modx->lexicon(\'refresh_default\') . \': pdoTools\');
            }
        }
        break;

    case \'OnWebPagePrerender\':
        $parser = $modx->getParser();
        if ($parser instanceof pdoParser) {
            foreach ($parser->pdoTools->ignores as $key => $val) {
                $modx->resource->_output = str_replace($key, $val, $modx->resource->_output);
            }
        }
        break;
}',
      'locked' => '0',
      'properties' => NULL,
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => 'core/components/pdotools/elements/plugins/plugin.pdotools.php',
    ),
    3 => 
    array (
      'id' => '3',
      'source' => '0',
      'property_preprocess' => '0',
      'name' => 'clubPackage',
      'description' => '',
      'editor_type' => '0',
      'category' => '1',
      'cache_type' => '0',
      'plugincode' => 'define(\'CRM_PATH\', MODX_ASSETS_PATH.\'id/\');
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
}',
      'locked' => '0',
      'properties' => 'a:0:{}',
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => '',
    ),
    5 => 
    array (
      'id' => '5',
      'source' => '1',
      'property_preprocess' => '0',
      'name' => 'afterLogin',
      'description' => '',
      'editor_type' => '0',
      'category' => '0',
      'cache_type' => '0',
      'plugincode' => '$ugroups = $user->getUserGroupNames();
$_SESSION[\'club_groups\'] = implode(\';\', $ugroups);
$_SESSION[\'scrm_thislogin\'] = date(\'c\');

if (in_array(\'idAdmin\', $ugroups)) $_SESSION[\'club_admin\'] = 1;
if (in_array(\'idManager\', $ugroups)) $_SESSION[\'club_manager\'] = 1;
$_SESSION[\'club_debug\'] = $user->isMember(\'Administrator\');

if (($userprofile = $user->getOne(\'Profile\')) !== null) {
    $_SESSION[\'user_fullname\'] = $userprofile->get(\'fullname\');
    $_SESSION[\'club_cityname\'] = $userprofile->get(\'city\');
    /*$modx->loadClass(\'idExtid\');
    $modx->map[\'idExtid\'][\'aggregates\'][\'idCity\'] = array (
        \'class\' => \'idCity\',
        \'local\' => \'extid\',
        \'foreign\' => \'id\',
        \'cardinality\' => \'one\',
        \'owner\' => \'foreign\',
    );
    
    $idUser_city = getClubExtId(array(
        \'parent\' => $user->get(\'id\'),
    ), \'idUser_city\', true, \'idCity\');

    if (!empty($idUser_city)){
        $_SESSION[\'club_city\'] = $idUser_city->idCity->get(\'id\');
        $_SESSION[\'club_cityname\'] = $idUser_city->idCity->get(\'name\');
    }*/
}

$returnUrl = $modx->getOption(\'returnUrl\', $scriptProperties, $_POST[\'returnUrl\']);
//$returnUrl = $modx->getOption(\'returnUrl\', $_POST, $returnUrl);

//$modx->log(modX::LOG_LEVEL_ERROR, "afterLogin: $returnUrl; url:".$_SERVER[\'HTTP_HOST\'].$_SERVER[\'REQUEST_URI\'].\'; user:\'.$user->get(\'id\'));

if (empty($returnUrl)) {
    $modx->runSnippet(\'loginWay\', array(
        \'user\' => $user,
    ));
}',
      'locked' => '0',
      'properties' => 'a:0:{}',
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => '',
    ),
    6 => 
    array (
      'id' => '6',
      'source' => '1',
      'property_preprocess' => '0',
      'name' => 'clubScripts',
      'description' => '',
      'editor_type' => '0',
      'category' => '0',
      'cache_type' => '0',
      'plugincode' => '$res = $modx->resource;
$start = \'\'; $bottom = \'\'; $app = array(
    \'club_id\' => $res->get(\'club_id\'),
    \'club_city\' => $_SESSION[\'club_city\'],
);
if (defined(\'CRM_PREFIX\') && !empty($res->get(\'template\'))) {
    //$modx->log(modX::LOG_LEVEL_ERROR,"Log2 ".json_encode($res->toArray(), JSON_UNESCAPED_UNICODE));

    $cfg = clubConfig(\'StartupHTMLBlock,BottomHTMLBlock\'); //grid_rows
    $start = $cfg[\'StartupHTMLBlock\'];
    $bottom = $cfg[\'BottomHTMLBlock\'];
    //$app[\'res\'] = $res->toArray(\'\',false,false,true);
    //$app[\'res\'][\'content\'] = null;

    $userID = clubUser();
    $app[\'ugroups\'] = $ugroups = $modx->getOption(\'scrm_ugroups\');
    if (!empty($ugroups)){
        $app[\'is_crew\'] = isCrew();
    }
    /*$users_scripts = array();
    foreach($clubStatus as $cs) {
        if ($cs[\'tbl\'] != \'idPermission\') continue;
        if (!empty($cs[\'extended\'][\'crew\'])) $users_scripts[] = $cs[\'alias\'];
    }
    
    $is_crew = !empty(array_intersect($ugroups, $users_scripts));
    if ($is_crew) {
        $start .= "<script>
            var club_city = \'{$_SESSION[\'club_city\']}\',
            grid_rows = \'{$cfg[\'grid_rows\']}\';
            dataUrl = \'".CRM_URL."id_data.php\';
            editUrl = \'/hook/dbedit\';
        </script>";
    }*/
    
    $club_modules = $modx->getOption(\'club_modules\');
    $clubStatus = getClubStatus(array(
        \'tbl\' => \'idModule\',
        \'cls:IN\' => $club_modules,
    )); //idPermission
    
    //$bottom .= \'111\'.json_encode($club_modules);

    $load_modules = array();
    $pathReplace1 = array(\'{crm}\',\'{modules}\',\'{vers}\',\'{user}\', \'{prugv}\');
    $pathReplace2 = array(
        CRM_URL,
        \'/handlers/modules/\',
        \'v=\'.$modx->getOption(\'vers\'),
        $userID,
        $modx->getOption(\'scrm_prugv\'),
    );
    
    foreach($clubStatus as $rowMod) {
        if ($rowMod[\'tbl\'] != \'idModule\') continue;
        $ext = $rowMod[\'extended\'];
        //if (!in_array($rowMod[\'cls\'], $club_modules)) continue;
        if (!empty($ext[\'group\'])) {
            if (empty($ugroups)) continue;
            $check_groups = array_merge(array(\'all\'), $ugroups);
            if (empty(array_intersect(explode(\',\', $ext[\'group\']), $check_groups))) continue;
        }
        if (!empty($ext[\'club_id\']) && !in_array($app[\'club_id\'], explode(\',\', $ext[\'club_id\']))) continue;
        if (!empty($ext[\'script\'])) {
            $bottom .= \'<script src="\'. str_replace($pathReplace1, $pathReplace2, $ext[\'script\']) .\'"></script>\';
        }
        if (!empty($ext[\'load\'])) {
            $load_modules[] = str_replace($pathReplace1, $pathReplace2, $ext[\'load\']);
        }
    }
    if (!empty($load_modules)) {
        $bottom .= \'<script>$(function(){SCRM.loadSeries(\'.json_encode($load_modules).\');});</script>\';
    }

    foreach (glob(CRM_START.\'load.php\', GLOB_BRACE) as $data_handler) require($data_handler);
}

$modx->setPlaceholders(array(
    \'StartupHTMLBlock\' => \'<script>$.extend(SCRM.app, \'. json_encode($app) .\');</script>\'.PHP_EOL.$start,
    \'BottomHTMLBlock\' => $bottom,
));',
      'locked' => '0',
      'properties' => 'a:0:{}',
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => '',
    ),
  ),
  'policies' => 
  array (
    'modAccessContext' => 
    array (
      'web' => 
      array (
        0 => 
        array (
          'principal' => 0,
          'authority' => 9999,
          'policy' => 
          array (
            'load' => true,
          ),
        ),
        1 => 
        array (
          'principal' => 1,
          'authority' => 0,
          'policy' => 
          array (
            'about' => true,
            'access_permissions' => true,
            'actions' => true,
            'change_password' => true,
            'change_profile' => true,
            'charsets' => true,
            'class_map' => true,
            'components' => true,
            'content_types' => true,
            'countries' => true,
            'create' => true,
            'credits' => true,
            'customize_forms' => true,
            'dashboards' => true,
            'database' => true,
            'database_truncate' => true,
            'delete_category' => true,
            'delete_chunk' => true,
            'delete_context' => true,
            'delete_document' => true,
            'delete_weblink' => true,
            'delete_symlink' => true,
            'delete_static_resource' => true,
            'delete_eventlog' => true,
            'delete_plugin' => true,
            'delete_propertyset' => true,
            'delete_role' => true,
            'delete_snippet' => true,
            'delete_template' => true,
            'delete_tv' => true,
            'delete_user' => true,
            'directory_chmod' => true,
            'directory_create' => true,
            'directory_list' => true,
            'directory_remove' => true,
            'directory_update' => true,
            'edit_category' => true,
            'edit_chunk' => true,
            'edit_context' => true,
            'edit_document' => true,
            'edit_weblink' => true,
            'edit_symlink' => true,
            'edit_static_resource' => true,
            'edit_locked' => true,
            'edit_plugin' => true,
            'edit_propertyset' => true,
            'edit_role' => true,
            'edit_snippet' => true,
            'edit_template' => true,
            'edit_tv' => true,
            'edit_user' => true,
            'element_tree' => true,
            'empty_cache' => true,
            'error_log_erase' => true,
            'error_log_view' => true,
            'events' => true,
            'export_static' => true,
            'file_create' => true,
            'file_list' => true,
            'file_manager' => true,
            'file_remove' => true,
            'file_tree' => true,
            'file_update' => true,
            'file_upload' => true,
            'file_unpack' => true,
            'file_view' => true,
            'flush_sessions' => true,
            'frames' => true,
            'help' => true,
            'home' => true,
            'import_static' => true,
            'languages' => true,
            'lexicons' => true,
            'list' => true,
            'load' => true,
            'logout' => true,
            'logs' => true,
            'menus' => true,
            'menu_reports' => true,
            'menu_security' => true,
            'menu_site' => true,
            'menu_support' => true,
            'menu_system' => true,
            'menu_tools' => true,
            'menu_user' => true,
            'messages' => true,
            'namespaces' => true,
            'new_category' => true,
            'new_chunk' => true,
            'new_context' => true,
            'new_document' => true,
            'new_document_in_root' => true,
            'new_plugin' => true,
            'new_propertyset' => true,
            'new_role' => true,
            'new_snippet' => true,
            'new_static_resource' => true,
            'new_symlink' => true,
            'new_template' => true,
            'new_tv' => true,
            'new_user' => true,
            'new_weblink' => true,
            'packages' => true,
            'policy_delete' => true,
            'policy_edit' => true,
            'policy_new' => true,
            'policy_save' => true,
            'policy_template_delete' => true,
            'policy_template_edit' => true,
            'policy_template_new' => true,
            'policy_template_save' => true,
            'policy_template_view' => true,
            'policy_view' => true,
            'property_sets' => true,
            'providers' => true,
            'publish_document' => true,
            'purge_deleted' => true,
            'remove' => true,
            'remove_locks' => true,
            'resource_duplicate' => true,
            'resourcegroup_delete' => true,
            'resourcegroup_edit' => true,
            'resourcegroup_new' => true,
            'resourcegroup_resource_edit' => true,
            'resourcegroup_resource_list' => true,
            'resourcegroup_save' => true,
            'resourcegroup_view' => true,
            'resource_quick_create' => true,
            'resource_quick_update' => true,
            'resource_tree' => true,
            'save' => true,
            'save_category' => true,
            'save_chunk' => true,
            'save_context' => true,
            'save_document' => true,
            'save_plugin' => true,
            'save_propertyset' => true,
            'save_role' => true,
            'save_snippet' => true,
            'save_template' => true,
            'save_tv' => true,
            'save_user' => true,
            'search' => true,
            'set_sudo' => true,
            'settings' => true,
            'sources' => true,
            'source_delete' => true,
            'source_edit' => true,
            'source_save' => true,
            'source_view' => true,
            'steal_locks' => true,
            'tree_show_element_ids' => true,
            'tree_show_resource_ids' => true,
            'undelete_document' => true,
            'unlock_element_properties' => true,
            'unpublish_document' => true,
            'usergroup_delete' => true,
            'usergroup_edit' => true,
            'usergroup_new' => true,
            'usergroup_save' => true,
            'usergroup_user_edit' => true,
            'usergroup_user_list' => true,
            'usergroup_view' => true,
            'view' => true,
            'view_category' => true,
            'view_chunk' => true,
            'view_context' => true,
            'view_document' => true,
            'view_element' => true,
            'view_eventlog' => true,
            'view_offline' => true,
            'view_plugin' => true,
            'view_propertyset' => true,
            'view_role' => true,
            'view_snippet' => true,
            'view_sysinfo' => true,
            'view_template' => true,
            'view_tv' => true,
            'view_unpublished' => true,
            'view_user' => true,
            'workspaces' => true,
          ),
        ),
        2 => 
        array (
          'principal' => 2,
          'authority' => 9999,
          'policy' => 
          array (
            'load' => true,
            'list' => true,
            'view' => true,
            'save' => true,
            'remove' => true,
            'copy' => true,
            'view_unpublished' => true,
          ),
        ),
      ),
    ),
  ),
);