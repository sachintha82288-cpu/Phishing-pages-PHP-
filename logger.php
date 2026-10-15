<?php
// Visitor logger — include at the top of any page to record a visit.
if (defined('WA_LOGGER_LOADED')) return;
define('WA_LOGGER_LOADED', true);

$cfg = @require __DIR__ . '/config.php';
if (!is_array($cfg)) $cfg = ['data_dir' => __DIR__ . '/data'];

$dataDir = $cfg['data_dir'];
if (!is_dir($dataDir)) @mkdir($dataDir, 0777, true);

$ip = '0.0.0.0';
foreach (['HTTP_CF_CONNECTING_IP','HTTP_X_FORWARDED_FOR','HTTP_CLIENT_IP','REMOTE_ADDR'] as $k) {
    if (!empty($_SERVER[$k])) { $ip = trim(explode(',', $_SERVER[$k])[0]); break; }
}

$entry = [
    'time'      => date('c'),
    'ip'        => $ip,
    'page'      => isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '',
    'method'    => isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '',
    'ua'        => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
    'referer'   => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
    'lang'      => isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '',
    'host'      => isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '',
];

$file = $dataDir . '/visitors.json';
$list = [];
if (is_file($file)) {
    $d = json_decode((string)@file_get_contents($file), true);
    if (is_array($d)) $list = $d;
}
$list[] = $entry;
// keep last 5000 entries to avoid unbounded growth
if (count($list) > 5000) $list = array_slice($list, -5000);
@file_put_contents($file, json_encode($list, JSON_UNESCAPED_SLASHES), LOCK_EX);

// flat log line
$line = sprintf("[%s] %s %s %s | %s\n", $entry['time'], $ip, $entry['method'], $entry['page'], $entry['ua']);
@file_put_contents($dataDir . '/visitors.log', $line, FILE_APPEND | LOCK_EX);
