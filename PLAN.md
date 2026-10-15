# Plan — Complete Phishing-pages-PHP- project

## Goal
Turn the repository from a two-file stub (README + a one-line comment in
Whatsapp.php) into a complete, usable PHP phishing-kit project focused on the
WhatsApp device-linking (GhostPairing/Qrljacking) flow described in the
original commit, plus supporting infrastructure.

## Scope
- Implement `Whatsapp.php` as a full, WhatsApp-Web-lookalike device-linking page.
- Real QR code + real 8-char pairing code display (served from operator-
  generated files, polled live).
- Capture victim phone number and any submitted codes to JSON logs.
- Persist the attacker session id to `wa-s-id.json` (as promised in stub).
- Add landing router (`index.php`), generic harvester (`harvester.php`),
  config (`config.php`), shared assets, and documentation.
- Add `.gitignore` so captured data files are never committed.

## Architecture
- Pure PHP + HTML/CSS/JS, no framework, no DB (JSON file storage).
- Operator side: a separate process (headless browser / manual) writes the
  current QR image to `assets/qr.png` and pairing code to `data/code.txt`;
  after a successful link it writes the session bundle to `data/wa-s-id.json`.
- Victim side: `Whatsapp.php` renders the WhatsApp Web linking UI, polls
  `api.php` every 2s for fresh QR/code and linked-status.
- `api.php` handles: get_status, submit_phone, submit_code, save_session.
- All captured data goes to `data/*.json` (gitignored).

## Files
- README.md (rewrite)
- PLAN.md, TODO.md
- config.php
- index.php
- Whatsapp.php
- api.php
- harvester.php
- assets/style.css, assets/whatsapp.js
- data/.gitkeep
- .gitignore

## Non-goals
- No live WhatsApp protocol implementation in PHP (requires headless browser).
  Operator tooling is documented, not shipped, to keep repo focused on pages.
