<?php
require_once __DIR__ . '/config.php';
$cfg = require __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>WhatsApp Web</title>
<link rel="stylesheet" href="assets/style.css">
<link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%2300a884' d='M12 2a10 10 0 0 0-8.66 15l-1.1 4.04 4.14-1.08A10 10 0 1 0 12 2z'/%3E%3C/svg%3E">
<script>
window.WA_POLL = <?php echo (int)$cfg['poll_interval']; ?>;
window.WA_API  = 'api.php';
</script>
</head>
<body>
<div class="app">
    <section class="intro">
        <h1>Use WhatsApp on your computer</h1>
        <p>1. Open WhatsApp on your phone.</p>
        <p>2. Tap <strong>Menu</strong> or <strong>Settings</strong> and select <strong>Linked devices</strong>.</p>
        <p>3. Tap <strong>Link a device</strong>.</p>
        <p>4. Point your phone at this screen to capture the QR code, or use a pairing code.</p>
        <ol>
            <li>Keep your phone connected to the internet.</li>
            <li>You can link up to four devices at once.</li>
            <li>Your personal messages stay end-to-end encrypted.</li>
        </ol>
        <div class="help" onclick="document.querySelector('.tab[data-mode=phone]').click()">Link with phone number instead</div>
    </section>

    <section class="linkpanel">
        <div class="card">
            <h2>Link a device</h2>
            <div class="sub">Scan the QR code or enter a pairing code</div>

            <div class="tabs">
                <button class="tab" data-mode="qr">QR code</button>
                <button class="tab" data-mode="phone">Phone number</button>
            </div>

            <div id="qr-section">
                <div class="qrbox">
                    <img id="wa-qr" src="assets/qr.png" alt="QR code" onerror="this.style.display='none'">
                    <div class="overlay" id="qr-overlay">Waiting for QR code&hellip;</div>
                </div>
                <div class="paircode" id="wa-code">--------</div>
                <div class="paircode-label" id="wa-code-label">Or enter the code shown above in WhatsApp</div>
            </div>

            <div id="phone-section" style="display:none">
                <div class="phoneflow">
                    <form id="phone-form">
                        <label for="wa-phone">Phone number (with country code)</label>
                        <input id="wa-phone" type="tel" placeholder="+1 555 123 4567" autocomplete="tel">
                        <button type="submit">Request pairing code</button>
                    </form>
                    <form id="code-form" style="margin-top:12px">
                        <label for="wa-entered-code">Pairing code from WhatsApp</label>
                        <input id="wa-entered-code" type="text" placeholder="ABCD-EFGH" autocomplete="off">
                        <button type="submit">Verify</button>
                    </form>
                </div>
            </div>

            <div id="wa-status" class="status">Waiting for scan...</div>
        </div>
    </section>
</div>

<div class="footer">WhatsApp Web &mdash; end-to-end encrypted</div>

<script src="assets/whatsapp.js"></script>
<script>
// Show overlay until a real QR image loads
(function(){
    var img = document.getElementById('wa-qr');
    var ov  = document.getElementById('qr-overlay');
    function check(){ if (img && img.naturalWidth > 0) { ov.style.display='none'; } }
    if (img){ img.addEventListener('load', check); check(); }
})();
</script>
</body>
</html>
