<?php

$totals = ", SUM(`sum`) as `sum`, AVG(`sum`) as `avrg`";
if (!empty($d1)&&!empty($d2)) {
    $w->leftJoin('idSportsmen');
    $w->leftJoin('idTrainer', 'idTrainer', 'idTrainer.id = idSportsmen.trainer');
    $where[] = array(
        'idSportsmen.city' => $_SESSION['club_city'],
        'OR:sportsmen:=' => 0,
    );
    
    $where["datepay:>="] = $d1;
    $where["datepay:<="] = $d2;
    
    $select[] = "idSportsmen.name";
    $select[] = "idSportsmen.key as sportsmen_key";
    $select[] = "idTrainer.name as trainer_name";
    
    $w->leftJoin('idInvoicePay','ip', 'ip.idpay = idPay.id');
    $select[] = "SUM(IFNULL(ip.sum, 0)) as spent";
    $select[] = "idPay.sum - SUM(IFNULL(ip.sum, 0)) as rest";
    $groupby[] = 'idPay.id';
    $totals .= ", SUM(`spent`) as `spent`, SUM(`rest`) as `rest`";
    
    $fields['spent']['phptype'] = 'float';
    $fields['rest']['phptype'] = 'float';

    if (isset($where['idPay.code1c'])) {
        if ($where['idPay.code1c']=='bank') {
            $where['idPay.code1c:!='] = '';
            unset($where['idPay.code1c']);
        } else $where['idPay.code1c'] = '';
    }
}
