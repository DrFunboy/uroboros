<?php
// Всех пользователей добавляет в группу www_id
foreach($modx->getCollection('modUser') as $u) {
    $u->joinGroup('www_chess', 'Member', 110);
}