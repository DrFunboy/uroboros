<?php
unset($flds['saldo']);
$clubConfig = clubConfig('idSportsmen_main,Gender_main,idSportsmen_arc');
$idSportsmen_arc = explode(',', $clubConfig['idSportsmen_arc']);

if ($oper == 'add') {
    if (empty($data['key'])) $data['key'] = generateUUID();
    // CREATE TRIGGER `id_sportsmen_bi` BEFORE INSERT ON `id_sportsmen` FOR EACH ROW SET new.key = uuid()
    if (empty($data['city']) && !empty($data['squad'])) {
        $idSquad = $modx->getObjectGraph('idSquad', '{"idClub":{}}', $data['squad']);
        if (!empty($idSquad)) $data['city'] = $idSquad->getOne('idClub')->get('city');
    }
    
    //$modx->loadClass('idSportsmen');
    $modx->map['idSportsmen']['fields']['status'] = $clubConfig['idSportsmen_main'];
    $modx->map['idSportsmen']['fields']['gender'] = $clubConfig['Gender_main'];
}
// TODO: перенести обработчик группы и города в After. Если будет обозначена группа - то добавить ее в основную. Если пустой город, то найти основную группу и если ее нет, то из сессии, иначе = 0

// если поля входят в список активизировать запоминание изменений
if ($oper == 'edit') {
    $ch_fields = array();
    foreach($flds as $f_name => $f_val) {
        if (!empty($f_val['club_log'])) $ch_fields[] = $f_name;
    }

    $ch_fields = array_intersect(array_keys($data), $ch_fields);
    if (!empty($ch_fields)) {
        foreach($modx->getIterator($table, array('id:IN' => $ids)) as $r) {
            $old = $r->toArray();
            foreach($ch_fields as $chf) {
                if ($old[$chf]!=$data[$chf]) {
                    $ch_insert = array(
                        'sportsmen' => $old['id'],
                        'chfield' => $chf,
                        'author' => $userID,
                        'oldvalue' => $old[$chf],
                        'newvalue' => $data[$chf],
                        'info' => $data['change_info']? :'',
                    );
                    $ch = $modx->newObject('idChanges', $ch_insert);
                    $ch->save();
                }
            }
        }
    }


   if (isset($data['squad']) && empty($data['ignore_squad'])) {
        // Архивирует основную группу если поменялась или все группы если спортсмен отправился в Архив
        $wsp = $modx->newQuery('idSportsmen', array(
            'squad:!=' => $data['squad'],
            'id:IN' => $ids,
        ));
        $wsp->innerJoin('idSportsmenSquad', 'ssq',
            '(ssq.sportsmen = idSportsmen.id AND ssq.squad = idSportsmen.squad AND ssq.dateend IS NULL)');
        $wsp->select(array('ssq.id'));
        $wsp->prepare();
        //$sql_ssq = $wsp->toSQL();
        $ssq_update = array(
            "id IN (SELECT * FROM ({$wsp->toSQL()}) AS tbl)",
        );
    }
    
    if (in_array($data['status'], $idSportsmen_arc)) { //TODO: Заменить видимо потому что русское название
        $ssq_update = array(
            'sportsmen:IN' => $ids,
            'dateend' => null,
        );
    }
    
    if (!empty($ssq_update)) {
        $modx->updateCollection('idSportsmenSquad', array(
            'published' => null,
            'dateend' => date('c'),
            'editedby' => $userID,
        ), $ssq_update);
    }
} // End oper = edit


if ($oper == 'del') {
    $del_rows = $modx->getIterator($table, array(
        'id:IN' => $ids,
        'status:IN' => $idSportsmen_arc, // TODO: Заменить русский
    ));
}
