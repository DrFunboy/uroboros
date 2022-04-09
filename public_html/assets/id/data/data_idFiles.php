<?php
$tableadd = $_REQUEST['tableadd'];
if (!empty($tableadd)) {
    if ($tableadd=='idSportsmen') {
        $w->innerJoin($tableadd, $tableadd, "{$tableadd}.key = idFiles.uid");
        $select[] = "{$tableadd}.name as sportsmen_name";
        $select[] = "{$tableadd}.id as sportsmen_id";
    }
}