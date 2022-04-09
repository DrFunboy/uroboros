<?php
$hook_name = 'eq.paykeeper';

if (!empty($json)) {
    $json['paym'][] = array(
        'name' => $hook_name,
        'label' => 'Банковская карта (онлайн)',
    );
    if (!empty($paydata)) {
        $api_url = $paydata['url'];
        
        $idPay->save();
        $id_pay = $idPay->get('id');

        $paydata = array(
            'user_result_callback' => $paydata['backUrl'],
            //'sum' => $paydata['total'],
            'sum' => number_format($paydata['total'], 2, ".", ""),
            'clientid' => $json['id'],
            'orderid' => $id_pay,
            'service_name' => $paydata['paytext'],
            'client_email' => $paydata['email'],
        );
        
        $paydata['payUrl'] = $api_url;
        //$paydata['debug'] = true; // если не редиректит, покажет
    }
}

if (empty($modx) & !empty($_REQUEST['orderid'])) {
    $hook_order = $_REQUEST['orderid'];
    require_once('eq.include.php');
    
    $id = $_POST['id'];
    $sum = number_format($_POST['sum'], 2, ".", "");
    $key = $_POST['key'];
 
    if ($key != md5($id.$sum.$_POST['clientid'].$hook_order.$paydata['secret'])) {
        exit("Error! Hash mismatch");
    } else {
        $idPay->fromArray(array(
            'payd' => 1,
            'numpay' => $id,
            'sumbank' => $sum,
            'datepay' => date('c'),
            'code1c' => $key,
            'info' => "{$_POST['card_number']}\n{$_POST['service_name']}",
        ));
        $idPay->save();
        echo "OK ".md5($id.$paydata['secret']);
    }
}