$ids = $modx->getOption('ids', $scriptProperties, $_REQUEST["ids"]);
$key = $modx->getOption('key', $scriptProperties, $_REQUEST["key"]);
$where = array();
$json = array();

if (!empty($ids)) {
    $where["id:IN"] = explode(',', $ids);
} elseif (!empty($key)) {
    $where["key"] = $key;
}

if (!empty($where)){
    $stmt = $modx->newQuery('idSportsmen', $where)->select(array('idSportsmen.*','id'))->prepare();
    $stmt->execute();
    $json = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $modx->setPlaceholder('sportsmens', $json);
}

return json_encode($json, JSON_UNESCAPED_UNICODE);