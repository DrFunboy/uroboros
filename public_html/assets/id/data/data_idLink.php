<?php
$tableadd = $_REQUEST['tableadd'];
if (!empty($tableadd)) {
    $w->leftJoin($tableadd, 'lnk', "lnk.id = idLink.id2");
    $select[] = 'lnk.name as lnk_name';
}