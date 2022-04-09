<?php

if ($oper=='add' && empty($data['alias'])) {
    $data['alias'] = uniqid();
}

