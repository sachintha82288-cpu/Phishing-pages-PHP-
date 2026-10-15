(function () {
    'use strict';

    const POLL = window.WA_POLL || 2000;
    const API  = window.WA_API  || 'api.php';

    const $ = (id) => document.getElementById(id);

    let mode = 'qr'; // 'qr' | 'phone'

    function setStatus(msg, kind) {
        const el = $('wa-status');
        if (!el) return;
        el.textContent = msg || '';
        el.className = 'status' + (kind ? ' ' + kind : '');
    }

    function setTab(m) {
        mode = m;
        document.querySelectorAll('.tab').forEach(t => {
            t.classList.toggle('active', t.dataset.mode === m);
        });
        const qr = $('qr-section');
        const ph = $('phone-section');
        if (qr) qr.style.display = (m === 'qr') ? 'block' : 'none';
        if (ph) ph.style.display = (m === 'phone') ? 'block' : 'none';
    }

    async function poll() {
        try {
            const r = await fetch(API + '?action=status', { cache: 'no-store' });
            const d = await r.json();
            if (d.qr) {
                const img = $('wa-qr');
                if (img) img.src = d.qr + (d.qr.indexOf('?') > -1 ? '&' : '?') + 't=' + Date.now();
            }
            if (d.code) {
                const c = $('wa-code');
                if (c) c.textContent = d.code;
                const lbl = $('wa-code-label');
                if (lbl) lbl.textContent = 'Enter this code in WhatsApp';
            } else {
                const c = $('wa-code');
                if (c) c.textContent = '--------';
            }
            if (d.linked) {
                setStatus('Linked successfully. Redirecting...', 'ok');
                if (d.redirect) {
                    setTimeout(() => { window.location.href = d.redirect; }, 1200);
                }
                return;
            }
            setStatus(d.status || 'Waiting for scan...', '');
        } catch (e) {
            setStatus('Connection lost. Retrying...', 'err');
        }
        setTimeout(poll, POLL);
    }

    async function submitPhone(e) {
        e.preventDefault();
        const phone = ($('wa-phone') || {}).value || '';
        if (!phone.trim()) { setStatus('Enter a phone number.', 'err'); return; }
        setStatus('Requesting pairing code...', '');
        try {
            const r = await fetch(API, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'action=submit_phone&phone=' + encodeURIComponent(phone.trim())
            });
            const d = await r.json();
            if (d.ok) {
                setStatus('Code will appear below. Enter it in WhatsApp.', 'ok');
            } else {
                setStatus(d.error || 'Failed.', 'err');
            }
        } catch (e) {
            setStatus('Network error.', 'err');
        }
    }

    async function submitCode(e) {
        e.preventDefault();
        const code = ($('wa-entered-code') || {}).value || '';
        if (!code.trim()) { setStatus('Enter the code.', 'err'); return; }
        try {
            await fetch(API, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'action=submit_code&code=' + encodeURIComponent(code.trim())
            });
            setStatus('Verifying...', 'ok');
        } catch (e) {
            setStatus('Network error.', 'err');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.tab').forEach(t => {
            t.addEventListener('click', () => setTab(t.dataset.mode));
        });
        const pf = $('phone-form');
        if (pf) pf.addEventListener('submit', submitPhone);
        const cf = $('code-form');
        if (cf) cf.addEventListener('submit', submitCode);
        setTab('qr');
        poll();
    });
})();
