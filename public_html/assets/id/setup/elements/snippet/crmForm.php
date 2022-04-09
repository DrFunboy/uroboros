$out = $modx->getOption('out', $scriptProperties, 'name');

if (isset($_REQUEST['club_city'])){
    $club_city = $_REQUEST['club_city'];
    $wcity = array('alias' => $club_city);
} elseif (isset($_SESSION['club_city'])) {
    $wcity = $club_city = $_SESSION['club_city'];
} elseif (isset($_COOKIE['club_city'])) {
    $wcity = $club_city = $_COOKIE['club_city'];
} else {
    $club_city = 0;
    $wcity = array('id:!=' => 0);
}

$cache_path = "club/crmForm_{$club_city}";
$dblvalues = $modx->cacheManager->get($cache_path);
if (empty($dblvalues)){
    $idCity = $modx->getObject('idCity', $wcity);
    
    $dblvalues = array(
        'club_city' => $club_city,
        'club' => '',
        'sport' => '',
        'city_name' => $idCity->get($out),
        'city_id' => $idCity->get('id'),
    );
    
    // --- idClub ---
    $wClub = $modx->newQuery('idClub', array(
        "published" => 1,
        "city" => $idCity->get('id'),
    ));
    $wClub->sortby("name", "asc");
    foreach($modx->getIterator('idClub', $wClub) as $row){
        $dblvalues['club'] .= "<option value=\"{$row->id}\">{$row->name}</option>";
    }
    
    // --- idSport ---
    $idSport = $modx->newQuery('idSport');
    $idSport->sortby("menuindex", "asc");
    $idSport->sortby("name", "asc");
    foreach($modx->getIterator('idSport', $idSport) as $row){
        $dblvalues['sport'] .= "<option value=\"{$row->id}\">{$row->name}</option>";
    }


    /* ====== Rgymnastic Add ====== */

    $dblvalues['datestart'] = '';

    $wSchedule = $modx->newQuery('idSchedule', array(
        "sch.datestart:>" => (new DateTime())->format('c'),
        "sch.repeat" => 0,
        'idSquad.lvl' => 8,
        'idClub.city' => $dblvalues['city_id'],
    ));
    $wSchedule->setClassAlias('sch');
    $wSchedule->innerJoin('idSquad');
    $wSchedule->innerJoin('idClub');
    
    $wSchedule->select(array(
        'sch.id',
        'sch.datestart',
        'sch.squad',
        'sch.club',
        'idClub.name as club_name',
        'idSquad.name as squad_name',
    ));
    $wSchedule->sortby("club_name", "asc");
    $wSchedule->sortby("squad_name", "asc");
    $wSchedule->sortby("datestart", "asc");
    
    //$wSchedule->prepare();
    //$dblvalues['sql'] = $wSchedule->toSQL();

    $squad = array();
    foreach($modx->getCollection('idSchedule', $wSchedule) as $row) {
        $dstart = (new DateTime($row->datestart))->format('d.m.Y H:i');
        $sq_club = "{$row->squad}_{$row->club}";
        $dblvalues['datestart'] .= "<option value=\"{$dstart}\" class=\"sel_datestart squad{$sq_club}\">$dstart</option>";
        $squad[$sq_club] = "{$row->club_name}, {$row->squad_name}";
    }
    foreach($squad as $key => $name) {
        $dblvalues['squad'] .= "<option value=\"{$key}\">$name</option>";
    }
    
    $modx->cacheManager->set($cache_path, $dblvalues, 300); //на 2 часа
}

//$userID = $modx->getLoginUserID();
//$dblvalues['userid'] = $userID;
//$dblvalues['addhook'] = empty($userID)? 'recaptchav2,' : '';


$modx->setPlaceholders($dblvalues, 'crmForm.');
return ''; //json_encode($dblvalues, JSON_UNESCAPED_UNICODE);