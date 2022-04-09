<?php
$hook_name = 'eq.ibox';

if (!empty($json)) {
    $json['paym'][] = array(
        'name' => $hook_name,
        'label' => 'Visa/Mastercard (ИнвойсБокс)',
    );
    if (!empty($paydata)) {
        $api_url = 'https://go.invoicebox.ru/module_inbox_auto.u';
        
        if (empty($paydata['id_pay']) && !empty($idPay)) {
            $idPay->save();
            $paydata['id_pay'] = $idPay->get('id');
        }
        
        $pd = array(
            //'itransfer_testmode' => 1,
            'itransfer_url_return' => $paydata['backUrl'],
            'itransfer_url_returnsuccess' => $paydata['backUrl'],
            'itransfer_person_email' => $paydata['email'],
            'itransfer_person_name' => $json['name'],
            'itransfer_body_type' => 'PRIVATE',
            'itransfer_order_description' => $paydata['paytext'],
            'itransfer_order_currency_ident' => 'RUB',
            'itransfer_order_id' => $paydata['id_pay'],
            'itransfer_participant_ident' => $paydata['participant'],
            'itransfer_participant_id' => $paydata['shop'],
        );
        
        if (empty($paydata['items'])) $paydata['items'] = array(
            array(
                'name' => $paydata['paytext'],
                'amount' => 1,
                'price' => $paydata['total'],
                'total' => $paydata['total'],
            ),
        );
        
        $total = 0; $n = 1;
        foreach($paydata['items'] as $pi) {
            $pd["itransfer_item{$n}_name"] = $pi['name'];
            $pd["itransfer_item{$n}_quantity"] = $pi['amount'];
            $pd["itransfer_item{$n}_measure"] = '.';
            $pd["itransfer_item{$n}_price"] = $pi['price'];
            $pd["itransfer_item{$n}_vatrate"] = '-';
            $pd["itransfer_item{$n}_vat"] = 0;
            $total += $pi['total'];
            $n++;
        }
        
        $pd['itransfer_order_amount'] = $total;
        $pd['itransfer_participant_sign'] = md5("{$paydata['shop']}{$paydata['id_pay']}{$total}RUB{$paydata['key']}");

        $modx->sendRedirect( $api_url . "?" . http_build_query($pd) );
        
        $pd['payUrl'] = $api_url;
        $pd['debug'] = true;
        $paydata = $pd;
    }
}

if (empty($modx) && !empty($_REQUEST['sign'])) {
    $hook_order = $_REQUEST['participantOrderId'];
    require_once('eq.include.php');

    $idPay->fromArray(array(
        'payd' => 1,
        'sum' => $_REQUEST['amount']*1,
        'datepay' => $_REQUEST['time'],
        'code1c' => $_REQUEST['ucode'],
    ));
    $idPay->save();
    echo "OK";
}