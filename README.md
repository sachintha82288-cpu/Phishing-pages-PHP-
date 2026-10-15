# Phishing-pages-PHP-

A collection of phishing page templates built in PHP. Currently ships the
WhatsApp Web device-linking (GhostPairing / Qrljacking) flow.

> For educational and experimental purposes only. Do not use this in a way
> that harms anyone.

## Structure

```
.
├── index.php          # Landing router listing available pages
├── Whatsapp.php       # WhatsApp Web device-linking phishing page
├── Facebook.php       # Facebook login
├── Google.php         # Google sign in
├── Instagram.php      # Instagram login
├── Microsoft.php      # Microsoft sign in
├── Netflix.php        # Netflix sign in
├── api.php            # JSON API (status, capture endpoints)
├── harvester.php      # Generic credential harvester
├── config.php         # Paths, redirect URL, polling interval
├── assets/
│   ├── style.css      # WhatsApp Web lookalike styling
│   └── whatsapp.js    # Polling + phone/code flow
├── data/              # Captured data (gitignored)
├── admin.php          # Admin dashboard (password protected)
├── logger.php         # Visitor logger (IP, UA, referrer)
└── PLAN.md / TODO.md  # Project plan and task list
```

## Admin panel

Open `admin.php` and log in with the password in `config.php`
(`admin_password`, default `admin123` — change it). The panel lets you
view/clear captured data, set the pairing code, upload a QR image, and
store a session bundle.

## Setup

1. Point a web server (Apache/Nginx + PHP 7.4+) at the project root.
2. Make sure the `data/` directory is writable by the web server:
   `chmod 777 data/`
3. Open `index.php` in a browser.

## WhatsApp device-linking flow

The page mimics WhatsApp Web's "Link a device" screen and shows a real QR
code plus an 8-character pairing code. The operator is responsible for
producing those artifacts from a real WhatsApp Web session:

1. Run a headless browser (Selenium/Puppeteer) that opens
   `https://web.whatsapp.com` and waits on the linking screen.
2. Copy the rendered QR code image to `assets/qr.png`.
3. Copy the pairing code to `data/code.txt`.
4. When a victim scans/links, extract the session bundle (WAToken1,
   WAToken2, WASecretBundle, WABrowserId, ...) and POST it to
   `api.php?action=save_session` (JSON body) or write it directly to
   `data/wa-s-id.json`.

`api.php?action=status` is polled every 2 seconds by the victim page and
reports whether `data/wa-s-id.json` exists; once it does, the victim is
redirected to `redirect_url` (see `config.php`).

Captured phone numbers and entered codes are stored in
`data/wa-phones.json` and `data/wa-captures.json`. Generic form posts go
to `data/harvest.log` / `data/harvest.log.json`.

## Operator helper (optional)

A minimal Node.js helper that drives a headless Chromium session and
writes `assets/qr.png` / `data/code.txt` / `data/wa-s-id.json` can be
added under `tools/`. It is intentionally not shipped here to keep the
repository focused on the PHP pages.

## Disclaimer

Provided for educational and experimental purposes only.
