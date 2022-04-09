//$shop_config = $modx->runSnippet('clubConfig', array('name' => 'shop_config'));
//if (!empty($shop_config)) $json['shop_config'] = json_decode($shop_config, true);

$orderPack = $modx->getObject('idOrderPack', $_REQUEST['order']);
$paym = $modx->getOption('paym', $scriptProperties, $_REQUEST['paym']);

if (!empty($paym) && !empty($orderPack)) {
    $json = $orderPack->toArray();

    $paydata = $modx->runSnippet('clubConfig', array(
        'name' => $paym,
        //'decode' => true,
    ));
    $paydata = (empty($paydata))? array() : json_decode($paydata, true);
    $paydata['id_pay'] = $json['id'];
    //$json['pd'] = $paydata;
    
    //$userID = $modx->getLoginUserID();
    //if (!empty($userID)) {
        $Profile = $modx->user->getOne('Profile')->toArray();
        $paydata['email'] = $Profile['email'];
    //}

    $site_url = $modx->getOption('site_url');
    $paydata['backUrl'] = $site_url ."/shop/myorders.html";
    
    if (empty($paydata['tmpl'])) $paydata['tmpl'] = 'Оплата Заказа [[+id]]';
    $paydata['paytext'] = clubTmpl($paydata['tmpl'], $json);

    $woi = $modx->newQuery('idOrderItems', array('oi.orderpack' => $json['id']));
    $woi->setClassAlias('oi');
    $woi->innerJoin('idShopItem');
    $woi->select($modx->getSelectColumns('idOrderItems', 'oi'));
    $woi->select(array(
        'idShopItem.name as name',
    ));
    $woi->sortby('name', 'asc');
    $stmt = $woi->prepare();
    //$json['idOrderItems'] = $modx->getSelectColumns('idOrderItems', );
    //$json['sql33'] = $woi->toSQL();
    $stmt->execute();
    $paydata['items'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $paym_file = MODX_ASSETS_PATH. 'id/hook/' .$paym. '.php';
    if (file_exists($paym_file)) require($paym_file);
    
    $json['paydata'] =  $paydata;
}

return json_encode($json, JSON_UNESCAPED_UNICODE);