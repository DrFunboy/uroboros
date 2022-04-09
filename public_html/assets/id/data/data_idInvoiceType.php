<?php

$w->leftJoin('idSInvType');
$w->leftJoin('idStatus', 'idSt', "idSt.alias = idSInvType.stype AND idSt.tbl = 'idSchedule'");
$select[] = "GROUP_CONCAT(idSt.name SEPARATOR', ') as stype";
$w->groupby('idInvoiceType.id');
