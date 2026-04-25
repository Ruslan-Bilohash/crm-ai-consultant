<?php
// /ai/crm/counter.php

$file = 'counter.txt';
$ipFile = 'ips.txt';

// Створюємо файли, якщо їх немає
if (!file_exists($file))  file_put_contents($file, "0|0");
if (!file_exists($ipFile)) file_put_contents($ipFile, "");

$data = file_get_contents($file);
list($total, $unique) = explode('|', $data);
$total = (int)$total;
$unique = (int)$unique;

$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

// Додаємо IP, якщо його ще немає сьогодні
$ips = file($ipFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
if (!in_array($ip, $ips)) {
    $unique++;
    file_put_contents($ipFile, $ip . PHP_EOL, FILE_APPEND);
}

$total++;

// Зберігаємо
file_put_contents($file, "$total|$unique");

echo json_encode([
    'total'  => $total,
    'unique' => $unique
]);
?>