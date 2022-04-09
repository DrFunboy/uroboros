<?php

if ($oper=='edit' && isset($data['published'])) {
    if (empty($data['published'])) {
        $wsp = $modx->newQuery('idSportsmen', array(
            'ssq.id:IN' => $ids,
        ));
        $wsp->innerJoin('idSportsmenSquad', 'ssq',
            '(ssq.sportsmen = idSportsmen.id AND ssq.squad = idSportsmen.squad)');
        $wsp->select(array('ssq.sportsmen'));
        $wsp->prepare();

        $modx->updateCollection('idSportsmen', array(
            'squad' => 0,
        ), array(
            "id IN (SELECT * FROM ({$wsp->toSQL()}) AS tbl)",
        ));
        
        $data['dateend'] = date('c');
    } else {
        $data['dateend'] = '';
    }
}