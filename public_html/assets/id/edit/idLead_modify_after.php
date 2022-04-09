<?php

if (!empty($row)) {
    $new_status = $row->get('status');
    if ($oper=='edit' && !empty($old_data) && $old_data['status'] != $new_status) {
        $makeMsg = true;
        
        $idStatus = getClubStatusAlias('idLead', $new_status);
        if (!empty($idStatus)) {
            $ext = $idStatus['extended'];

            if (!empty($ext) && !empty($ext['idSportsmen'])) {
                $dataSportsmen = array(
                    'oper' => 'add',
                    'table' => 'idSportsmen',
                );
                
                $ldata = $row->toArray();
                if (!empty($ldata['sportsmen']) && empty($idSportsmen)) $idSportsmen = $modx->getObject('idSportsmen', $ldata['sportsmen']);
                if (!empty($idSportsmen)) {
                    $dataSportsmen['oper'] = 'edit';
                    $dataSportsmen['id'] = $idSportsmen->get('id');
                    $ldata = array_intersect_key($ldata, $data); // Только изменения
                }

                // Добавление в массив непустых незапрещенных колонок
                foreach($ldata as $k => $val)
                    if (!empty($val) && !in_array($k, ['id','status','key']))
                        $dataSportsmen[$k] = $ldata[$k];

                $out['idSportsmen'] = $modx->runSnippet('dbedit', array(
                    'data' => array_merge($dataSportsmen, $ext['idSportsmen']),
                    'placeholder' => 'extRow',
                    'row' => empty($idSportsmen)? null : $idSportsmen,
                ));
                $extRow = $modx->getPlaceholder('extRow');
                if (!empty($extRow) && !empty($extRow->get('id'))){
                    $row->set('sportsmen', $extRow->get('id'));
                    $row->save();
                }
            }
        }
    }
    
    /*if (!empty($data['ext_data']) && !empty($data['ext_data']['table'])) {
        $ldata = $row->toArray();
        foreach($ldata as $k => $val)
            if(empty($val) || in_array($k, ['id','status','key']))
                unset($ldata[$k]);
        //unset($ldata['id'], $ldata['status'], $ldata['key']);
        $modx->runSnippet('dbedit', array(
            'data' => array_merge($ldata, $data['ext_data']),
            'placeholder' => 'extRow',
        ));
        $extRow = $modx->getPlaceholder('extRow');
        if ($data['ext_data']['table']=='idSportsmen' && !empty($extRow) && !empty($extRow->get('id'))){
            $row->set('sportsmen', $extRow->get('id'));
            $row->save();
        }
    }*/
    
    if ($oper=='add' || $makeMsg) {
        $data['idClub'] = '';
        if (!empty($row->get('club'))) {
            $leadClub = $modx->getObjectGraph('idClub', '{"idCity":{}}', $row->get('club'));
            $data['idClub'] = $leadClub->toArray('', false, false, true);
        }
        $modx->runSnippet('makeMsg', array(
            'handler' => "idLead_".$new_status,
            'data' => array_merge($data, $row->toArray()),
        ));
    }
}