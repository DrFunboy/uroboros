<?php
if (!empty($json)) {
    $json['paym'][] = array(
        'name' => 'invoice',
        'label' => 'Квитанция в банк',
    );
    if (!empty($paydata)) {    
        $paydata['html'] = $modx->getChunk('tpl_invoice');
    }
}