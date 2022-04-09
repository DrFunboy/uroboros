<?php

$chfield = $_REQUEST['field'];
$chvalue = $_REQUEST['_rowid'];

$join = "(idChanges.sportsmen = idSportsmen.id) AND (idChanges.created BETWEEN '$d1' AND '$d2')";

if ($table == 'idChanges') {
    $where['idSportsmen.city'] = $_SESSION['club_city'];
    $w->innerJoin('idSportsmen', 'idSportsmen', $join);
    $select = array(
        "Count(idChanges.id) as cnt",
        "Count(DISTINCT idChanges.sportsmen) as cntsportsmen",
    );
    
    if (!empty($chfield)) {
        $select[] = "idChanges.newvalue";
        $w->groupby("idChanges.newvalue");
        $w->where(array(
            'idChanges.chfield' => $chfield,
        ));
    } else {
        $select[] = "idChanges.chfield";
        $w->groupby("idChanges.chfield"); 
    }
    
}

if ($table == 'idSportsmen') {
    $w->innerJoin('idChanges', 'idChanges', $join);
    $w->groupby('idSportsmen.id');
    $select[] = "count(idChanges.id) as add_cnt";
    $totals = ", SUM(`add_cnt`) as `add_cnt`";
}
