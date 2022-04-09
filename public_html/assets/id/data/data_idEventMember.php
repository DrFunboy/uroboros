<?php
$w->innerJoin('idSportsmen');
$w->innerJoin('idEventCategory');

array_push($select,
    'idSportsmen.name as sportsmen_name',
    'idSportsmen.gender',
    //'idSportsmen.saldo',
    //'idSportsmen.contact',
    //'idSportsmen.tel',
    'idSportsmen.key',
    'idEventCategory.name'
);

if (!empty($d1)&&!empty($d2)) {
    $w->innerJoin('idEvent');
    $select[] = 'idEvent.name as event_name';
    $where['idEvent.datestart:>='] = $d1;
    $where['idEvent.dateend:<='] = $d2;
}

if (empty($sidx)) {
    $w->sortby('CAST(team as unsigned)');
    $w->sortby('sportsmen_name');
}