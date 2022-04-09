<?php
if ($table=='idSportsmen') {
    if (!empty($where['cnt_trainer'])) {
        $w->innerJoin('idChanges', 'idChanges', "idChanges.sportsmen = idSportsmen.id AND (idChanges.created BETWEEN '{$d1}' AND '{$d2}') AND idChanges.chfield = 'trainer' AND idChanges.oldvalue=".$where['cnt_trainer']);
        unset($where['cnt_trainer']);
    }
    
    if (!empty($where['idTrainer.id'])) {
        $w->innerJoin('idChanges', 'idChanges', "idChanges.sportsmen = idSportsmen.id AND (idChanges.created BETWEEN '{$d1}' AND '{$d2}') AND idChanges.chfield = 'status' AND idChanges.newvalue = 'Архив'");
    }
} else {
    $where['idTrainer.city'] = $_SESSION['club_city'];
    $idChanges = $modx->getTableName('idChanges');
    $idSportsmen = $modx->getTableName('idSportsmen');
    
    $w->select(array(
        "idTrainer.id",
        "idTrainer.name",
    
        "(SELECT COUNT(*) FROM {$idChanges} as idChanges WHERE (idChanges.created BETWEEN '{$d1}' AND '{$d2}') AND idChanges.chfield = 'trainer' AND idChanges.oldvalue = idTrainer.id) as cnt_trainer",
        
        "(SELECT COUNT(*) FROM {$idSportsmen} as idSportsmen INNER JOIN {$idChanges} as c2 ON (c2.sportsmen = idSportsmen.id AND c2.created BETWEEN '{$d1}' AND '{$d2}') WHERE idSportsmen.trainer = idTrainer.id  AND c2.chfield = 'status' AND c2.newvalue = 'Архив') as cnt_arc",
    ));
    
    $w->sortby("idTrainer.name");
    $w->having("cnt_trainer > 0 OR cnt_arc > 0");
}