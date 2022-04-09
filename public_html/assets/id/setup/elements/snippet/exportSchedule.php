$trainer = $modx->getOption('trainer', $scriptProperties, $_REQUEST['trainer']);
$club = $modx->getOption('club', $scriptProperties, $_REQUEST['club']);
$weeks = $modx->getOption('weeks', $scriptProperties, $modx->getOption('weeks', $_REQUEST, 4));

$wsch = array(
    "sch.planfact" => 0,
    //'idTrainer.name' => '_',
    array(
        "sch.repeat" => 1,
        array(
            "OR:sch.repeat:=" => 0,
            "sch.datestart > NOW()",
        ),
    ),
);
if (!empty($trainer)) {
    $wsch[] = array(
        'idTrainer.id' => $trainer,
        "OR:idTrainer.name:=" => $trainer,
    );
}

if (!empty($club)) {
    $wsch[] = array(
        'idTrainer.id' => $club,
        "OR:idTrainer.name:=" => $club,
    );
}


$json = array(
    'rows' => array()    
);

$wSchedule = $modx->newQuery('idSchedule', $wsch);
$wSchedule->setClassAlias('sch');
$wSchedule->innerJoin('idTrainer');
$wSchedule->select(array(
    'datestart',
    'trainer',
    'idTrainer.city as city',
    'club',
    'repeat',
));

$stmt = $wSchedule->prepare(); //$json['sql'] = $wSchedule->toSQL();
$stmt->execute();
$now= new DateTime();
while($r = $stmt->fetch(PDO::FETCH_ASSOC)){
    if ($r['repeat']==0) {
        $json["rows"][] = $r;
    } else {
        $rd = new DateTime($r['datestart']);
        $day = $rd->format("l");
        $thisday = new DateTime($day.' this week '.$rd->format('H:i:00'));
        if ($thisday < $now) $thisday = new DateTime($day.' next week '.$rd->format('H:i:00'));
        for ($i = 0; $i <= $weeks; $i++) {
            $r['datestart'] = $thisday->format('Y-m-d H:i:s');
            $json["rows"][] = $r;
            $thisday->modify('+1 week');
        }
    }
}

function cmp($a, $b) { 
    return strnatcmp($a["datestart"], $b["datestart"]); 
}
usort($json["rows"], "cmp");

return json_encode($json, JSON_UNESCAPED_UNICODE);