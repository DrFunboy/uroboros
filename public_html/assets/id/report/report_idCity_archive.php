<?php

$ugroups = $modx->user->getUserGroupNames();
$club_admin = in_array('idAdmin', $ugroups);

if ($table == 'idClub') {
    require_once('period6m.php');
    $w->innerJoin('idSquad', 'idSquad', 'idSquad.club = idClub.id');
    $w->innerJoin('idSportsmen', 'idSportsmen', 'idSportsmen.squad = idSquad.id');
    $select = array(
        "DATE_FORMAT(idChanges.created, '%m') as month_ch",
        'YEAR(idChanges.created) as year_ch',
    );
    /*foreach ($period as $pk => $per) {
        $d_str = "(idChanges.created BETWEEN '{$per['d1']}' AND '{$per['d2']}')";
        
        //$select[] = "COUNT(DISTINCT CASE WHEN $d_str THEN idLesson.sportsmen END) as sportsmen_{$pk}";
        $select[] = "COUNT(DISTINCT IF(idChanges.newvalue = 'Архив' AND $d_str, idSportsmen.id, null)) as sportsmen_arc_{$pk}";
        $select[] = "COUNT(DISTINCT IF(idChanges.newvalue = 'new' AND $d_str, idSportsmen.id, null)) as sportsmen_new_{$pk}";
        $select[] = "COUNT(DISTINCT IF(idChanges.oldvalue = 'Архив' AND $d_str, idSportsmen.id, null)) as sportsmen_back_{$pk}";        
    }*/
    $select[] = "SUM(IF(idChanges.newvalue = 'Архив', 1, 0)) as cnt_arc";
    $select[] = "COUNT(DISTINCT IF(idChanges.newvalue = 'Архив', idSportsmen.id, null)) as sportsmen_arc";
    
    $select[] = "SUM(IF(idChanges.newvalue = 'new', 1, 0)) as cnt_new";
    $select[] = "COUNT(DISTINCT IF(idChanges.newvalue = 'new', idSportsmen.id, null)) as sportsmen_new";
    
    $select[] = "SUM(IF(idChanges.oldvalue = 'Архив', 1, 0)) as cnt_back";
    $select[] = "COUNT(DISTINCT IF(idChanges.oldvalue = 'Архив', idSportsmen.id, null)) as sportsmen_back";
    array_push($groupby, 'MONTH(idChanges.created)');
}

if ($table == 'idCity') {
    if (!$club_admin){
        $where['idCity.id'] = $_SESSION['club_city'];
    }
    $select = array(
        'idCity.id',
        'idCity.name',
    );
    $w->innerJoin('idSportsmen');
    
    $select[] = "SUM(IF(idChanges.newvalue = 'Архив', 1, 0)) as cnt_arc";
    $select[] = "COUNT(DISTINCT IF(idChanges.newvalue = 'Архив', idSportsmen.id, null)) as sportsmen_arc";
    
    $select[] = "SUM(IF(idChanges.newvalue = 'new', 1, 0)) as cnt_new";
    $select[] = "COUNT(DISTINCT IF(idChanges.newvalue = 'new', idSportsmen.id, null)) as sportsmen_new";
    
    $select[] = "SUM(IF(idChanges.oldvalue = 'Архив', 1, 0)) as cnt_back";
    $select[] = "COUNT(DISTINCT IF(idChanges.oldvalue = 'Архив', idSportsmen.id, null)) as sportsmen_back";

    $groupby[] = 'idCity.id';
    
    $totals = ", SUM(`cnt_arc`) as `cnt_arc`, SUM(`cnt_sportsmen`) as `cnt_sportsmen`";
}

$w->innerJoin('idChanges', 'idChanges', "idChanges.sportsmen = idSportsmen.id AND (idChanges.created BETWEEN '{$d1}' AND '{$d2}') AND idChanges.chfield = 'status'");

if ($table == 'idSportsmen') {
    if ($club_admin) unset($where['city']);
    
    //$rq['sql'] = 1;
    $select[] = "COUNT(idSportsmen.id) as add_cnt";
    $groupby[] = 'idSportsmen.id';
}


/* --------------------------- /// --------------------------------- */
/*
$period = array();
$d1 = new DateTime('first day of this month');
for ($i = 0; $i < 6; $i++) {
    $d2 = clone $d1;
    $d2->modify("+1 month -1 day");
    $period[$i] = array(
        "name" => strftime("%m.%Y", $d1->getTimestamp()),
        "d1" => $d1->format("Y-m-d 00:00:00"),
        "d2" => $d2->format("Y-m-d 23:59:59"),
    );
    $d1->modify("-1 month");
}
$json['period'] = $period;
$d2 = $period[0]['d2'];
$d1 = end($period)['d1'];

if ($rq['_rtype'] == 'idSchedule') {
    $join = "(sch.datestart BETWEEN '$d1' AND '$d2')";
    
    $select = array(
        //"inv.typeinvoice",
        //"idInvoiceType.name as invoicetype",
        "COUNT(DISTINCT sch.id) as cnt_schedule",
    );
    
    $w->innerJoin('idLesson');
    $w->innerJoin('idSchedule', 'sch', 'sch.id = idLesson.schedule');
    //$w->leftJoin('idInvoicePay', 'ip', "ip.idinvoice = inv.id");
    
    //$w->groupby('inv.typeinvoice');
    
    foreach ($period as $pk => $per) {
        $d_str = "(sch.datestart BETWEEN '{$per['d1']}' AND '{$per['d2']}' AND idLesson.`status`='y')";
        //$select[] = "SUM(IF({$d_str}, inv.`sum`, 0)) as inv_{$pk}";
        $select[] = "COUNT(DISTINCT CASE WHEN $d_str THEN idLesson.sportsmen END) as sportsmen_{$pk}";
    }
    
} else {
    
    $join = "(inv.sportsmen = idSportsmen.id) AND (inv.dateinvoice BETWEEN '$d1' AND '$d2')";
    
    $select = array(
        "inv.typeinvoice",
        "idInvoiceType.name as invoicetype",
        "SUM(inv.sum) as inv_sum",
    );
    
    $w->innerJoin('idInvoice', 'inv', $join);
    $w->innerJoin('idInvoiceType', 'idInvoiceType', 'idInvoiceType.id = inv.typeinvoice');
    //$w->leftJoin('idInvoicePay', 'ip', "ip.idinvoice = inv.id");
    
    array_push($groupby, 'inv.typeinvoice');
    
    foreach ($period as $pk => $per) {
        $d_str = "(inv.dateinvoice BETWEEN '{$per['d1']}' AND '{$per['d2']}')";
        $select[] = "SUM(IF({$d_str}, inv.`sum`, 0)) as inv_{$pk}";
        $select[] = "COUNT(DISTINCT CASE WHEN $d_str THEN inv.sportsmen END) as sportsmen_{$pk}";
    }
}






