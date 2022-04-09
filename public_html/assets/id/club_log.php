<?php
function club_log($data, $log_name = 'noname', $encode = true) {
    if (defined('CRM_PREFIX')) $log_name = CRM_PREFIX.$log_name;
    $log_path = __DIR__ . "/../club_log/{$log_name}/";
    if (!file_exists($log_path)) mkdir($log_path, 0755, true );
    if ($encode) $data = json_encode($data, JSON_UNESCAPED_UNICODE); //JSON_INVALID_UTF8_IGNORE
    file_put_contents($log_path. date('Y-m-d_H-i-s').uniqid() .'.txt', $data);
}