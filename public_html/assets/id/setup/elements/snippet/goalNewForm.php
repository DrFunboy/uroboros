$data = array();
if (!empty($_REQUEST['contact'])) $data['contact'] = $_REQUEST['contact'];
if (!empty($_REQUEST['email'])) $data['email'] = $_REQUEST['email'];
if (!empty($_REQUEST['tel'])) $data['tel'] = $_REQUEST['tel'];

if (!empty($hook)){
    $idStatus = $modx->getObject('idStatus', array(
        'tbl' => 'idGoal',
        'ismain' => 1,
    ));
    $data = array_merge($data, $hook->getValues());
    $data['oper'] = 'add';
    $data['table'] = 'idGoal';
    //$data['info'] = $_REQUEST['key']; // отладка
    if (!empty($_REQUEST['key'])) $data['key'] = $_REQUEST['key'];
    if (!empty($idStatus)) $data['status'] = $idStatus->get('id');
    
    $dbedit_out = $modx->runSnippet('dbedit', array(
        'data' => $data,
    ));
} else {
    $ref = $_SERVER['HTTP_REFERER'];
    $purl = parse_url($ref);
    $modx->setPlaceholders(array(
        'contact' => implode(' | ', $data),
        'ref' => $purl['scheme']. '://' .$purl['host']. '/login/profile.html',
    ), 'goal.');
}


return (!empty($hook))? true : "";