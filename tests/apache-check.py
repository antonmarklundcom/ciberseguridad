"""Local Apache checks for both supported document roots; no external POSTs."""
from pathlib import Path
import json
import requests

root = Path(__file__).resolve().parents[1]
records = json.loads((root / 'src/page-data.json').read_text(encoding='utf-8'))
checks = 0
failures = []

def check(ok, label):
    global checks
    checks += 1
    if not ok:
        failures.append(label)

for port in [8900, 8901]:
    base = f'http://127.0.0.1:{port}'
    headers = {'X-Forwarded-Proto': 'https'}
    for slug in records:
        path = '/' + slug + '/' if slug else '/'
        r = requests.get(base + path, headers=headers, allow_redirects=False, timeout=20)
        check(r.status_code == (404 if slug == '404' else 200), f'{port} page {path}: {r.status_code}')
        for name in ['Content-Security-Policy', 'X-Content-Type-Options', 'Strict-Transport-Security', 'Referrer-Policy', 'X-Frame-Options']:
            check(name in r.headers, f'{port} {path} {name}')
        check('X-Powered-By' not in r.headers, f'{port} {path} no PHP header')
    for path, dest in [('/servicios', '/servicios/'), ('/contacto.php', '/contacto/'), ('/index.php', '/'), ('/recursos/autoevaluacion/', '/recursos/practicas-minimas-ciberseguridad-pymes-paraguay/'), ('/para/pymes/', '/recursos/practicas-minimas-ciberseguridad-pymes-paraguay/')]:
        r = requests.get(base + path, headers=headers, allow_redirects=False, timeout=20)
        check(r.status_code == 301 and r.headers.get('Location', '').endswith(dest), f'{port} redirect {path}: {r.headers.get("Location")}')
    for path in ['/.env', '/.git/config', '/src/config.php', '/storage/orientation-leads.csv', '/docs/review/live-inventory.json', '/tests/run.php', '/tools/audit-live.py', '/public_html/index.php', '/unknown-page/']:
        r = requests.get(base + path, headers=headers, allow_redirects=False, timeout=20)
        check(r.status_code in [403, 404], f'{port} denied {path}: {r.status_code}')
    r = requests.get(base + '/.well-known/security.txt', headers=headers, timeout=20)
    check(r.status_code == 200 and 'Policy:' in r.text, f'{port} security.txt')
    r = requests.get(base + '/assets/img/continuity-1024.webp', headers=headers, timeout=20)
    check(r.status_code == 200 and 'max-age=86400' in r.headers.get('Cache-Control', ''), f'{port} asset cache')
    r = requests.get(base + '/enviar/', headers=headers, timeout=20)
    check(r.status_code == 405, f'{port} POST-only endpoint')
    r = requests.get(base + '/servicios/', allow_redirects=False, timeout=20)
    check(r.status_code == 301 and r.headers.get('Location') == 'https://ciberseguridad.com.py/servicios/', f'{port} HTTPS redirect')
    r = requests.get(base + '/servicios/', headers=headers | {'Host': 'www.ciberseguridad.com.py'}, allow_redirects=False, timeout=20)
    check(r.status_code == 301 and r.headers.get('Location') == 'https://ciberseguridad.com.py/servicios/', f'{port} www redirect')

report = {'server': 'Apache 2.4.69 + mod_fcgid / PHP 8.5.11', 'modes': ['repo root', 'public_html'], 'checks': checks, 'failed': len(failures), 'failures': failures, 'TLS': 'Local HTTP with X-Forwarded-Proto=https; no live TLS scan'}
(root / 'docs/review/apache-results.json').write_text(json.dumps(report, indent=2), encoding='utf-8')
print(json.dumps(report, indent=2))
raise SystemExit(bool(failures))
