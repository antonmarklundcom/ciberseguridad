"""Read-only public-page inventory. Never submits a form or scans a host."""
from pathlib import Path
from urllib.parse import urlsplit
import concurrent.futures, json, requests, xml.etree.ElementTree as ET
from bs4 import BeautifulSoup

root = Path(__file__).resolve().parents[1]
out = root / 'docs/review/live'
out.mkdir(parents=True, exist_ok=True)
base = 'https://ciberseguridad.com.py'
for name in ['robots.txt', 'sitemap.xml']:
    r = requests.get(base + '/' + name, timeout=30)
    r.raise_for_status()
    (out / name).write_text(r.text, encoding='utf-8')
urls = [x.text for x in ET.fromstring((out/'sitemap.xml').read_text(encoding='utf-8')).iter() if x.tag.endswith('}loc')]
urls = list(dict.fromkeys(urls + [base+'/contacto/',base+'/privacidad/',base+'/encontra-un-proveedor/']))
def inspect(url):
    assert urlsplit(url).hostname == 'ciberseguridad.com.py'
    r = requests.get(url, timeout=30)
    s = BeautifulSoup(r.text, 'html.parser')
    slug = urlsplit(url).path.strip('/')
    main = s.find('main')
    if main:
        for f in main.find_all('form'): f.decompose()
        for x in main.select('script,style'): x.decompose()
        for x in main.select('[style]'): del x['style']
        path = out / ((slug or 'home') + '.html')
        path.parent.mkdir(parents=True,exist_ok=True)
        path.write_text(str(main),encoding='utf-8')
    canonical = s.find('link',rel='canonical')
    desc = s.find('meta',attrs={'name':'description'})
    robots = s.find('meta',attrs={'name':'robots'})
    return {'path':urlsplit(url).path,'url':url,'final_url':r.url,'status':r.status_code,'title':s.title.get_text() if s.title else '',
      'description':desc.get('content','') if desc else '', 'h1':[h.get_text(' ',strip=True) for h in s.find_all('h1')],
      'canonical':canonical.get('href','') if canonical else '', 'robots':robots.get('content','') if robots else '',
      'schema':[json.loads(x.string or '{}') for x in s.find_all('script',type='application/ld+json')],
      'links':list(dict.fromkeys(a.get('href','') for a in s.find_all('a'))),
      'headers':{k:v for k,v in r.headers.items() if k.lower() in ['content-security-policy','strict-transport-security','x-content-type-options','x-powered-by','cache-control']}}
with concurrent.futures.ThreadPoolExecutor(max_workers=4) as pool:
    records = list(pool.map(inspect,urls))
(root/'docs/review/live-inventory.json').write_text(json.dumps(records,ensure_ascii=False,indent=2),encoding='utf-8')
print(json.dumps([{'path':r['path'],'status':r['status'],'title':r['title']} for r in records],ensure_ascii=False,indent=2))
