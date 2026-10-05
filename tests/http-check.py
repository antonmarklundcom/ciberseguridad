"""Local-only HTTP verification. Production forms are never submitted."""
from pathlib import Path
from urllib.parse import urlsplit, urljoin
import json, requests, re
from bs4 import BeautifulSoup

root=Path(__file__).resolve().parents[1]
base='http://127.0.0.1:8899'
records=json.loads((root/'src/page-data.json').read_text(encoding='utf-8'))
problems=[];checked=0;targets=set()
def check(ok,label):
    global checked
    checked+=1
    if not ok: problems.append(label)
for slug,p in records.items():
    path='/'+slug+'/' if slug else '/'
    r=requests.get(base+path,timeout=20)
    check(r.status_code==(404 if slug=='404' else 200),path+' status')
    s=BeautifulSoup(r.text,'html.parser')
    check(len(s.find_all('h1'))==1,path+' H1')
    check(s.find('link',rel='canonical')['href']=='https://ciberseguridad.com.py'+path,path+' canonical')
    check(not re.search(r'(Fatal error|Warning:|Deprecated:|Notice:)',r.text),path+' diagnostics')
    for x in s.find_all('script',type='application/ld+json'):
        try: json.loads(x.string or '{}')
        except ValueError: problems.append(path+' schema')
    if 'published_at' in p:
        docs=[json.loads(x.string) for x in s.find_all('script',type='application/ld+json')]
        article=next((x for x in docs if x.get('@type')=='Article'),{})
        check(article.get('headline')==s.h1.get_text() and article.get('datePublished')==p['published_at'],path+' Article schema matches visible headline and publication')
    for a in s.find_all(['a','img','script','link']):
        value=a.get('href') or a.get('src') or ''
        u=urlsplit(value)
        if u.scheme or not value.startswith('/') or value.startswith('//'): continue
        if u.path: targets.add(u.path)
        if u.fragment and (not u.path or u.path==path): check(s.find(id=u.fragment) is not None,path+' missing anchor '+u.fragment)
for target in sorted(targets):
    check(requests.get(base+target,timeout=20).status_code==200,'internal target '+target)
aliases={'servicios/diagnostico':'servicios/evaluacion-ciberseguridad','servicios/respuesta-a-incidentes':'servicios/respuesta-incidentes','servicios/cuestionarios-de-proveedores':'servicios/politicas-gobernanza-seguridad','servicios/seguridad-gestionada':'servicios/monitoreo-gestionado-soc','politica-de-privacidad':'privacidad','recursos/autoevaluacion':'recursos/practicas-minimas-ciberseguridad-pymes-paraguay','recursos/checklist-de-incidentes':'recursos/preparar-hoja-contactos-incidentes'}
for old,new in aliases.items():
    r=requests.get(base+'/'+old,allow_redirects=False,timeout=20)
    check(r.status_code==301 and r.headers.get('Location')=='/'+new+'/','legacy alias '+old)
for slug in ['pymes','clinicas','contadores','ecommerce']:
    r=requests.get(base+'/para/'+slug+'/',allow_redirects=False,timeout=20)
    check(r.status_code==301,'legacy sector URL '+slug)
for target in ['/.env','/src/config.php','/storage/orientation-leads.csv','/docs/review/live-inventory.json','/tests/orientation.php']:
    check(requests.get(base+target,timeout=20).status_code in [403,404],'private target '+target)
for path in ['/encontra-un-proveedor/','/contacto/']:
    r=requests.get(base+path,timeout=20);s=BeautifulSoup(r.text,'html.parser')
    if not s.find('form'):
        check('El canal de solicitudes está en preparación' in r.text,path+' default intake notice')
        response=requests.post(base+'/enviar/',data={'form_type':'orientacion'},allow_redirects=False,timeout=20)
        check(response.status_code==503,path+' disabled POST refused')
        continue
    check(not s.find('textarea') and not s.find('input',type='file'),path+' no technical narrative')
    for el in s.select('input:not([type=hidden]):not([name=website]),select'):
        check(s.find('label',attrs={'for':el.get('id')}) is not None,path+' label '+el.get('name',''))
    # Synthetic, invalid local POST. Never contacts delivery transports.
    csrf=s.find('input',attrs={'name':'csrf'})['value']
    post={'csrf':csrf,'ts':'1','form_type':'orientacion','nombre':'Synthetic','telefono':'123456','rubro':'forged','empleados':'forged','disparador':'forged','consent':'0'}
    response=requests.post(base+'/enviar/',data=post,headers={'Cookie':'csrf='+csrf},allow_redirects=False,timeout=20)
    check(response.status_code==422 and 'Tu solicitud todavía no se envió' in response.text,'local stale request 422')
    # Invalid contact prevents delivery while verifying real escaped re-render.
    import time
    post.update(ts=str(int(time.time())-30),nombre='<script>alert(1)</script>',telefono='invalid',rubro='comercio',empleados='1-9',disparador='backup',consent='1')
    response=requests.post(base+'/enviar/',data=post,headers={'Cookie':'csrf='+csrf},allow_redirects=False,timeout=20)
    rendered=BeautifulSoup(response.text,'html.parser')
    check(response.status_code==422 and '<script>alert(1)</script>' not in response.text,'local re-render escapes submitted markup')
    check(rendered.find('input',attrs={'name':'nombre'})['value']==post['nombre'],'local validation preserves contact values')
check(requests.get(base+'/enviar/',timeout=20).status_code==405,'POST-only endpoint')
report={'checks':checked,'failed':len(problems),'problems':problems,'pages':len(records),'internal_targets':len(targets)}
(root/'docs/review/http-results.json').write_text(json.dumps(report,ensure_ascii=False,indent=2),encoding='utf-8')
print(json.dumps(report,ensure_ascii=False,indent=2));raise SystemExit(bool(problems))
