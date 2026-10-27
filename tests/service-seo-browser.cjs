/* Focused local SEO/content checks; no external requests or new dependencies. */
const {chromium}=require('playwright');
const {readFileSync,mkdirSync,writeFileSync}=require('node:fs');
const {join}=require('node:path');
const origin=new URL(process.argv[2]||'http://127.0.0.1:18992');
if(!['127.0.0.1','localhost'].includes(origin.hostname)||origin.protocol!=='http:')throw Error('Loopback only');
const registry=JSON.parse(readFileSync(join(__dirname,'../src/page-data.json'),'utf8'));
const services=Object.keys(registry).filter(s=>s.startsWith('servicios/'));
const out=process.env.BROWSER_ARTIFACTS;if(out)mkdirSync(out,{recursive:true});
const checks=[],errors=[];const check=(ok,label)=>{checks.push({ok:!!ok,label});if(!ok)throw Error(label);};
(async()=>{
 const browser=await chromium.launch({headless:true,...(process.env.BROWSER_EXECUTABLE?{executablePath:process.env.BROWSER_EXECUTABLE}:{}),args:['--disable-background-networking','--disable-component-update','--no-first-run','--host-resolver-rules=MAP * ~NOTFOUND, EXCLUDE 127.0.0.1']});
 try{
  const c=await browser.newContext({viewport:{width:390,height:844},reducedMotion:'reduce'});
  await c.route('**/*',r=>new URL(r.request().url()).origin===origin.origin?r.continue():r.abort());
  const p=await c.newPage();p.on('pageerror',e=>errors.push(e.message));
  for(const slug of services){
   const response=await p.goto(origin.origin+'/'+slug+'/',{waitUntil:'networkidle'});
   check(response.status()===200,slug+' status');
   check(await p.title()===registry[slug].title,slug+' title');
   check(await p.locator('meta[name=description]').getAttribute('content')===registry[slug].desc,slug+' description');
   check(await p.locator('link[rel=canonical]').getAttribute('href')==='https://ciberseguridad.com.py/'+slug+'/',slug+' canonical');
   check(await p.locator('h1').count()===1,slug+' H1');
   check(await p.locator('article .service-editorial').count()===1,slug+' server-rendered content');
   check(await p.locator('.service-editorial h3').count()===4,slug+' process and three FAQs');
   check(await p.locator('.service-editorial ol li').count()===3,slug+' buying steps');
   check(await p.evaluate(()=>document.documentElement.scrollWidth<=innerWidth+1),slug+' mobile overflow');
   check(await p.locator('main .hero-actions .button').getAttribute('href')==='/encontra-un-proveedor/?servicio='+slug.split('/')[1],slug+' original CTA context');
  }
  for(const width of [390,1440]){
   await p.setViewportSize({width,height:900});
   for(const slug of ['servicios/pentesting-autorizado','servicios/seguridad-microsoft-365-google-workspace','servicios/proteccion-datos-personales','proveedores']){
    await p.goto(origin.origin+'/'+slug+'/',{waitUntil:'networkidle'});
    check(await p.evaluate(()=>document.documentElement.scrollWidth<=innerWidth+1),slug+' layout '+width);
    if(out)await p.screenshot({path:join(out,slug.replace('/','-')+'-'+width+'.png'),fullPage:true});
   }
  }
  await p.goto(origin.origin+'/proveedores/');
  await p.locator('main .hero-actions .button').click();
  check(p.url()===origin.origin+'/encontra-un-proveedor/#preparar-cotizacion','Provider guide reaches private self-service brief');
  const bare=await browser.newContext({javaScriptEnabled:false,viewport:{width:390,height:844},reducedMotion:'reduce'});
  await bare.route('**/*',r=>new URL(r.request().url()).origin===origin.origin?r.continue():r.abort());
  const q=await bare.newPage();
  for(const slug of ['servicios/pentesting-autorizado','servicios/proteccion-datos-personales']){
   await q.goto(origin.origin+'/'+slug+'/',{waitUntil:'networkidle'});
   check(await q.locator('.service-editorial').isVisible(),slug+' noJS content');
   check(await q.locator('.service-editorial h3').count()===4,slug+' noJS FAQ answers present');
  }
  await bare.close();
  check(errors.length===0,'No page errors');
  console.log('PASS: '+checks.length+' service SEO browser checks; all17 at390px, four representative desktop/mobile pages and noJS; external traffic blocked.');
 }finally{
  if(out)writeFileSync(join(out,'service-seo-browser.json'),JSON.stringify({checks,errors,externalTrafficBlocked:true},null,2));
  await browser.close();
 }
})().catch(e=>{console.error(e);process.exitCode=1;});
