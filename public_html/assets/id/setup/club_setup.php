<?php
ignore_user_abort(true);
set_time_limit(0);

define('MODX_API_MODE', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/config.core.php');
require_once(MODX_CORE_PATH.'model/modx/modx.class.php');
$modx = new modX();
$modx->initialize('web');

if (!defined('CRM_PATH')) define('CRM_PATH', MODX_ASSETS_PATH.'id/');

//error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
$site_url = $modx->getOption('site_url');

$club_key = empty($_REQUEST['key'])? $modx->getOption('club_key') : $_REQUEST['key'];
if (empty($club_key)) die('Empty key. Exit');

$emp_uid = empty($modx->user) || !$modx->user->hasSessionContext('web');
if ($emp_uid) {
    $modx->user = $modx->getObject('modUser', 1);
    $modx->user->addSessionContext('web');
    $modx->invokeEvent('OnWebLogin',array(
        'user' => $modx->user,
        'returnUrl' => '/', // чтобы не перебрасывал автоматом
    ));
    echo '<h6 style="color:red;">Не залогинен</h6>';
}

$manager = $modx->getManager();
$clubid_query = $modx->query("SELECT TABLE_NAME, COLUMN_NAME FROM INFORMATION_SCHEMA.`COLUMNS`
WHERE TABLE_NAME = '{$modx->getTableName('modResource')}' AND COLUMN_NAME = 'club_id'");
if (empty( $clubid_query->fetchAll(PDO::FETCH_ASSOC) )) {
    $manager->addField('modResource', 'club_id');
}

$club_modules = $modx->getOption('club_modules'); //, 'clubShop'
if (gettype($club_modules)=='string') $club_modules = explode(',', $club_modules);
$club_modules = array_unique(array_merge($club_modules, array('clubStuff','clubLogin', 'clubModules')));
echo "Модули";
print_r($club_modules);

$club_post = array(
    'key' => $club_key,
    'mode' => $modx->getOption('mode', $_REQUEST, 'file,res,db'),
);
$mode = explode(',', $club_post['mode']);

$ch = curl_init('https://w.sportcrm.club/assets/clubtools/getupdate.php');
curl_setopt($ch, CURLOPT_HEADER, 0);

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $club_post);
        
if (in_array('file', $mode)) {
    $club_file = CRM_PATH . '../club.zip';
    $dest_file = @fopen($club_file, 'w');

    curl_setopt($ch, CURLOPT_FILE, $dest_file);
    curl_exec($ch);
    fclose($dest_file);
    
    if (filesize($club_file) > 0) {
        if ($zipClass = $modx->loadClass('compression.xPDOZip', XPDO_CORE_PATH, true, true)) {
            if ($zipStuff = new $zipClass($modx, $club_file)) {
                $result = $zipStuff->unpack(CRM_PATH);
                echo("Unpack club - " . sizeof($result));
            }
        }
    } else {
        echo("Error. FileSize {$club_file} = 0");
    }
} else {
    curl_exec($ch);
}
curl_close($ch);

$data = unserialize( file_get_contents(dirname(__FILE__) . '/clubStuff.txt') );

// Включение файлов db, res и т.д.
foreach($mode as $mode_item) {
    $mode_file = dirname(__FILE__) .'/club_setup_'. $mode_item .'.php';
    if (file_exists($mode_file)) {
        include_once($mode_file);
        $modx->reloadConfig();
    }
}

if (in_array('dbcheck', $mode)) {
    $schema_path = CRM_PATH."setup/clubStuff.xml";
    
    $schema = new DOMDocument();
    $schema->load($schema_path);
    $root = $schema->documentElement;
    $objectIdx = 0;
    while ($object = $root->childNodes->item($objectIdx++)) {
        if (strtolower($object->nodeName !== 'object')) continue;
        $className = $object->getAttribute('class');
        if (!empty($className)) {
        
            $idx = 0;
            while ($node = $object->childNodes->item($idx++)) {
                if (strtolower($node->nodeName === 'composite')) {
                    $name = $node->getAttribute('class');
                    $field = $node->getAttribute('foreign');
                    echo "<br>$name - $className<br>";
                    $ww = $modx->newQuery($name, array("{$name}.{$field}:!=" => 0));
                    $ww->leftJoin($className);
                    $ww->select("{$name}.id, COUNT({$className}.id) as cnt");
                    $ww->groupby("{$name}.id");
                    $ww->having("cnt<1");
                    foreach($modx->getCollection($name,$ww) as $key => $row){
                        echo $row->get('id').' - '.$row->get('cnt').'<br>';
                        //if ($name == 'idInvoiceLesson') 
                        $row->remove();
                    }
                    //if (!empty($name)) $manager->addIndex($className, $name);
                }
            }
        }
    }
}

echo "<br>Установка завершена<p><a href=\"{$site_url}\">Перейти на сайт</a></p>";
echo '<p><a href="/assets/id/setup/scripts/club_city.php" target="_blank">Город пользователя</a></p>
<p><a href="/assets/id/setup/scripts/shop_move.php" target="_blank">Магазин</a></p>
<p><a href="/assets/id/setup/scripts/move_photo.php" target="_blank">Фотографии. Переместить</a></p>
<p><a href="/assets/id/setup/scripts/cabinet_iduser.php" target="_blank">Кабинет спортсмена / Тренера</a></p>
<p><a href="/assets/id/setup/scripts/squadSportsmen.php" target="_blank">Группы</a></p>';

if ($emp_uid) {
    $modx->user->removeSessionContext('web');
    echo '<h6 style="color:red;">Разлогинен</h6>';
}

$ch = curl_init($site_url.'hook/wsendstat');
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_TIMEOUT, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_exec($ch);  
curl_close($ch);
