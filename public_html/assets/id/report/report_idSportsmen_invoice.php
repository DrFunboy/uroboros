<?php

$rowid = $rq['rowid'];
$join = "(inv.sportsmen = idSportsmen.id) AND (inv.dateinvoice BETWEEN '$d1' AND '$d2')";

if (empty($rowid)) {
    $rq['rows'] = 1001;
    
    $w->where($where);
    $w->select(array(
        "inv.id",
        "inv.typeinvoice",
        "inv.sportsmen",
        "inv.sum",
        "IFNULL(SUM(ip.sum), 0) as ip_sum",
    ));
    
    $w->innerJoin('idInvoice', 'inv', $join);
    $w->leftJoin('idInvoicePay', 'ip', "ip.idinvoice = inv.id");
    $w->groupby('inv.id'); 
    $w->prepare();
    $sql_inv = $w->toSQL();
    //$json['debug_inv'] = $sql_inv;
    
    $w = $modx->newQuery('idInvoiceType');
    $w->query['from']['joins'][] = array(
        "type" => "JOIN",
        "table" => "({$sql_inv})",
        "alias" => "_ip",
        "conditions" => array(
            new xPDOQueryCondition(array(
                "sql" => "idInvoiceType.id = _ip.typeinvoice",
            )),
        ),
    );
    
    $select = array(
        '_ip.typeinvoice',
        'idInvoiceType.`name` AS typeinvoice_name',
        'SUM(_ip.sum) as total',
        'COUNT(_ip.id) as cnt',
        'COUNT(DISTINCT _ip.sportsmen) as cnt_sportsmen',
        'SUM(_ip.ip_sum) as totalpay',
        'COUNT(IF(_ip.ip_sum=_ip.sum OR _ip.sum=0, 1, NULL)) as cntpay',
    );
    $where = array();
    $sidx = array('typeinvoice_name asc');
    $groupby = array('idInvoiceType.id');
    
} else {
    $join .= " AND (inv.typeinvoice ={$rowid})";
    if ($_REQUEST['mode'] == 'leftJoin') {
        $w->leftJoin('idInvoice', 'inv', $join);
    } else {
        $w->innerJoin('idInvoice', 'inv', $join);
    }
    $select[] = "IFNULL(sum(inv.`sum`), 0) as invoiced";
    $select[] = "count(inv.id) as add_cnt";
    $idInvoicePay = $modx->getTableName('idInvoicePay');
    $select[] = "SUM((SELECT IFNULL(SUM(ip.`sum`),0) FROM {$idInvoicePay} ip WHERE ip.idinvoice = inv.id)) as payed";
    $select[] = "GROUP_CONCAT(DISTINCT inv.`info` SEPARATOR ';\n') as add_info";
    if ($_REQUEST['having']=='debts') $w->having('invoiced-payed > 0');
    $w->groupby('idSportsmen.id');
    $totals = ", SUM(`saldo`) as `saldo`, SUM(`invoiced`) as `invoiced`, SUM(`payed`) as `payed`, SUM(`add_cnt`) as `add_cnt`";
}