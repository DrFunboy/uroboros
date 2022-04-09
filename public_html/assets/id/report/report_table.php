<?php
require_once('../id_init.php');

$mode = $modx->getOption('mode', $_REQUEST, '');

$details = false;
    
function cmp($a, $b) { 
    return strnatcmp($a["name"], $b["name"]); 
}

$wsch = array(
    "sch.planfact" => 1,
    "sch.datestart BETWEEN '$d1' AND '$d2'",
    //"sch.datestart:>=" => $d1,
    //"sch.datestart:<=" => $d2,
    "idClub.city" => $_SESSION['club_city'],
);

$select = array(
    "sch.*",
    "idClub.name as clubname",
    "idTrainer.name as trainername",
    //"idSport.name as sportname",
    "idSport.shortname as ssportname",
    "idLevel.name as levelname",
    "idSquad.name as squadname",
    //"DATE_FORMAT(datestart, '%Y-%m-%d') as ymd",
    //"DATE_FORMAT(datestart, '%H:%i') as d_s",
    //"DATE_FORMAT(datestart, '%w') as d_w",
);

$wSchedule = $modx->newQuery('idSchedule', $wsch);
$wSchedule->setClassAlias('sch');
$wSchedule->innerJoin('idSquad');
$wSchedule->innerJoin('idLevel', 'idLevel', 'idLevel.id = idSquad.lvl');
$wSchedule->innerJoin('idClub'); //, 'idClub', 'idClub.id = idSquad.club'
$wSchedule->innerJoin('idTrainer');
$wSchedule->innerJoin('idSport');

if ($mode == 'tbl_byday'){
    $wSchedule->where(array(
        'sch.trainer' => $_REQUEST['trainer'],
        'sch.squad' => $_REQUEST['squad'],
    ));
    array_push($select,
        "DATE_FORMAT(datestart, '%d.%m') as d_m",
        "idLesson.sportsmen",
        "idLesson.status",
        "sp.name"
    );
    $wSchedule->innerJoin('idLesson');
    $wSchedule->innerJoin('idSportsmen', 'sp', 'sp.id = idLesson.sportsmen');
    $wSchedule->sortby("datestart", "asc");
    
    $details = true;
} else {
    $wSchedule->innerJoin('idLesson'); //leftJoin
    
    array_push($select,
        "SUM(IF(idLesson.`status` = 'y', 1, 0)) as sum_y",
        "SUM(IF(idLesson.`status` = 'n', 1, 0)) as sum_n",
        "SUM(IF(idLesson.`status` = 't', 1, 0)) as sum_t"
    );
    $wSchedule->groupby("sch.id");
    $wSchedule->sortby("trainername", "asc");
    $wSchedule->sortby("clubname", "asc");
    $wSchedule->sortby("levelname", "asc");
    $wSchedule->sortby("squadname", "asc");
}

$wSchedule->select($select);
$qSchedule = $wSchedule->prepare();
if ($_SESSION['club_debug']) $json["sql"] = $wSchedule->toSQL();
$qSchedule->execute();
if ($details){
    $dates = array(); $sp = array(); $status = array();
    while($row = $qSchedule->fetch(PDO::FETCH_ASSOC)){
        $sch = $row['id'];
        if (empty($dates["$sch"])) $dates["$sch"] = array(
            "id" => $sch,
            "d_m" => $row['d_m'],
            "ssportname" => $row['ssportname'],
        );
        $dates["$sch"]["status"][ $row['status'] ] += 1;
        $sportsmen = $row['sportsmen'];
        if (empty($sp["$sportsmen"])) $sp["$sportsmen"] = array(
            "sportsmen" => $sportsmen,
            "name" => $row['name'],
        );
        $sp["$sportsmen"]["status"][ $row['status'] ] += 1;
        $json["idLesson"]["sch{$sch}_{$sportsmen}"] = $row;
        $status[ $row['status'] ] += 1;
    }
    $json["dates"] = array_values($dates);
    if (!empty($sp)) usort($sp, "cmp");
    $json["sp"] = array_values($sp);
    $json["status"] = $status;
} else {
    $idSquad = array(); $idTrainer = array();
    while($row = $qSchedule->fetch(PDO::FETCH_ASSOC)){
        $json["debug"][] = $row;
        $trainerid = $row['trainer'];
        $squadid = $row['squad'];
        
        if (!array_key_exists("$trainerid", $idTrainer)) {
            $idTrainer["$trainerid"] = array(
                "id" => $trainerid,
                "name" => $row['trainername'],
                "cnt" => 0,
            );
        }
        $idTrainer["$trainerid"]["cnt"] += 1;
        $idTrainer["$trainerid"]["squad"]["$squadid"] += 1;
        $idTrainer["$trainerid"]["sum_y"] += $row['sum_y'];
        $idTrainer["$trainerid"]["sum_n"] += $row['sum_n'];
        $idTrainer["$trainerid"]["sum_t"] += $row['sum_t'];
        
        $squadname = "{$row['levelname']}, {$row['squadname']} ({$row['clubname']})";
        if (!array_key_exists($squadname, $idSquad)) {
            $idSquad[ $row['squad'] ] = array(
                "name" => $squadname,
                "id" => $row['squad'],
            );
        }
        $idSquad[ $row['squad'] ]["trainer"]["$trainerid"] += 1;
    }
    
    //if (!empty($idSquad)) usort($idSquad, "cmp");
    //$json["idSquad"] = array_values($idSquad);
    
    //if (!empty($idTrainer)) usort($idTrainer, "cmp");
    //$json["idTrainer"] = array_values($idTrainer);
    $json["idSquad"] = $idSquad;
    $json["idTrainer"] = $idTrainer;
}

echo json_encode($json, JSON_UNESCAPED_UNICODE);