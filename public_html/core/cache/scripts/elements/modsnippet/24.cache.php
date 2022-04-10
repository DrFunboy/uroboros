<?php  return '$data = ($data)? : $_REQUEST;
$oper = $modx->getOption(\'oper\', $data, \'add\');
$table = $data[\'table\'];
//$modx->log(modX::LOG_LEVEL_ERROR, json_encode($data, JSON_UNESCAPED_UNICODE));
if (empty($data["id"])) {
    if (!empty($row)) {
        $data["id"] = $row->get(\'id\');
    } else {
        $data["id"] = \'\';
    }
}
$ids = array_filter(explode(\',\', $data["id"]));
$out = array(
    \'user_id\' => $userID = $modx->getLoginUserID(),
);

if (empty($table) || ($oper !== \'add\' && empty($ids)) ){ // || empty($userID)
    $out[\'error\'] = \'Error: empty important param\';
} else {
    $flds = $modx->getFieldMeta($table);

    unset($data["author"]);
    unset($data["edited"]);
    unset($data["editedby"]);

    $data_path = CRM_PATH."edit/{$table}_{modify,$oper}*_";
    foreach (glob($data_path."before.php", GLOB_BRACE) as $data_handler) {
        require($data_handler);
    }
    
    $out = array_merge($out, array(
        \'table\' => $table,
        \'oper\' => $oper,
    ));

    if (!empty($row)) {
        $ids = array($row->get(\'id\'));
    }
    
    unset($flds["id"]);
    unset($flds["created"]);

    if ($oper=="add" || $oper=="edit") {
        $e_array = array();
        
        if ($oper=="add") {
            $data[\'author\'] = $userID;
            if (empty($data[\'city\']) && !empty($_SESSION[\'club_city\'])) $data[\'city\'] = $_SESSION[\'club_city\'];
        } else {
            $data[\'edited\'] = date(\'c\');
            $data[\'editedby\'] = $userID;
        }
        
        foreach (array_keys($flds) as $_f) {
            if (isset($data[$_f])) {
                if ($data[$_f]===\'\' && in_array($flds[$_f][\'dbtype\'], [\'timestamp\',\'datetime\',\'date\',\'smallint\']) && $flds[$_f][\'null\'] == 1 ) {
                    $e_array[$_f] = null;
                } elseif ($flds[$_f][\'phptype\']==\'json\') {
                    $e_ext = $data[$_f];
                    if (!empty($e_ext) && gettype($e_ext)==\'string\') $e_ext = json_decode($e_ext, true);
                    $e_array[$_f] = (empty($e_ext))? null : $e_ext;
                    //array_merge(array(), json_decode($data[$_f], true)); //Работает только так
                } elseif ($flds[$_f][\'phptype\']==\'string\') {
                    $e_array[$_f] = trim($data[$_f]);
                    if ($_f == \'email\') {
                        $e_array[$_f] = $email = strtolower($e_array[$_f]);
                    }
                } else {
                    $e_array[$_f] = $data[$_f];
                }
            }
        }
        
        if ($oper=="add") {
            $mfield = $data[\'addmulti\'];
            foreach (explode(\',\', $data[$mfield]) as $mvalue) {
                if (!empty($mfield)) $e_array[$mfield] = $mvalue;
                if (($row = $modx->newObject($table, $e_array)) != null) {
                    $row->save();
                    $ids[] = $row->get(\'id\');
                }
            }
        } elseif (sizeof($ids) == 1) { //редактируется один элемент
            if (empty($row)) $row = $modx->getObject($table, $ids[0]);
            if (!empty($row)) {
                $old_data = $row->toArray();
                $row->fromArray($e_array);
                $row->save();
            }
        } else {
            $out[\'result\'] = $modx->updateCollection($table, $e_array, array("id:IN" => $ids));
        }
        
        $out[\'data\'] = $e_array;
    } // END add or edit
    
    if ( $oper == "del" ) {
        if (empty($del_rows)) $del_rows = $modx->getIterator($table, array(\'id:IN\' => $ids));
        foreach ($del_rows as $del_row) {
            $del_row->remove();
        }
        //$modx->removeCollection($table, array("id:IN" => $ids));
    }
    
    $out[\'ids\'] = $ids;
    $out[\'id\'] = implode(\',\', $ids);

    foreach (glob($data_path."after.php", GLOB_BRACE) as $data_handler) {
        require($data_handler);
    }
    
    if (!empty($row)) {
        $modx->setPlaceholder($modx->getOption(\'placeholder\', $scriptProperties, \'dbeditRow\'), $row);
        $out[\'row\'] = $row->toArray();
    }
}

return json_encode($out, JSON_UNESCAPED_UNICODE);
return;
';