/* Local browser release checks. Requires an existing Playwright installation.
   No requests outside the supplied loopback origin are allowed. */
const {chromium}=require('playwright');
const {readFileSync,mkdirSync,writeFileSync}=require('node:fs');
const {join,resolve}=require('node:path');
const base=process.argv[2]||'http://127.0.0.1:8899';
const origin=new URL(base);
if (!['127.0.0.1','localhost'].includes(origin.hostname)||origin.protocol!=='http:') throw Error('Loopback HTTP only');
const paths=JSON.parse(readFileSync(join(__dirname,'published-urls.json'),'utf8'));
const out=process.env.BROWSER_ARTIFACTS;
if(out)mkdirSync(out,{recursive:true});
const checks=[],errors=[];
const check=(ok,label)=>{checks.push({label,ok:!!ok});if(!ok)throw Error(label);};
(async()=>{
 const browser=await chromium.launch({headless:true,...(process.env.BROWSER_EXECUTABLE?{executablePath:process.env.BROWSER_EXECUTABLE}:{}),args:['--disable-background-networking','--disable-component-update','--no-first-run','--host-resolver-rules=MAP * ~NOTFOUND, EXCLUDE 127.0.0.1, EXCLUDE localhost']});
 const context=await browser.newContext({viewport:{width:390,height:844},reducedMotion:'reduce'});
 await context.route('**/*',route=>new URL(route.request().url()).origin===origin.origin?route.continue():route.abort());
 const page=await context.newPage();page.on('pageerror',e=>errors.push(e.message));
 try{
  for(const width of (process.argv.includes('--forms-only')?[]:[390,320,1440])) {
   await page.setViewportSize({width,height:900});
   for(const path of paths){
    const response=await page.goto(origin.origin+path,{waitUntil:'networkidle'});
    check(response.status()===200,path+' HTTP200 @'+width);
    check(await page.locator('h1').count()===1,path+' H1 @'+width);
    check(await page.locator('link[rel=canonical]').getAttribute('href')==='https://ciberseguridad.com.py'+path,path+' canonical @'+width);
    check(await page.evaluate(()=>document.documentElement.scrollWidth<=innerWidth+1),path+' no document overflow @'+width);
    if(/^\/(servicios|recursos)\/[^/]+\/$/.test(path))check(await page.locator('article .buyer-context').count()===1,path+' contextual resources @'+width);
   }
  }
  if(!process.argv.includes('--forms-only')){
   const aliases={
    '/servicios/diagnostico/':'/servicios/evaluacion-ciberseguridad/',
    '/servicios/respuesta-a-incidentes/':'/servicios/respuesta-incidentes/',
    '/servicios/cuestionarios-de-proveedores/':'/servicios/politicas-gobernanza-seguridad/',
    '/servicios/seguridad-gestionada/':'/servicios/monitoreo-gestionado-soc/',
    '/politica-de-privacidad/':'/privacidad/',
    '/recursos/autoevaluacion/':'/recursos/practicas-minimas-ciberseguridad-pymes-paraguay/',
    '/recursos/checklist-de-incidentes/':'/recursos/preparar-hoja-contactos-incidentes/'};
   for(const [path,dest] of Object.entries(aliases)){
    const response=await context.request.get(origin.origin+path,{maxRedirects:0});
    check(response.status()===301 && response.headers().location===dest,path+' legacy redirect preserved');
   }
   for(const path of ['/.env','/.git/config','/src/config.php','/storage/orientation-leads.csv','/tests/run.php','/unknown-page/']){
    const response=await context.request.get(origin.origin+path,{maxRedirects:0});
    check([403,404].includes(response.status()),path+' private/unknown route denied');
   }
   const method=await context.request.get(origin.origin+'/enviar/',{maxRedirects:0});
   check(method.status()===405,'Form endpoint refuses GET');
   const disabled=await context.request.post(origin.origin+'/enviar/',{form:{form_type:'orientacion'},maxRedirects:0});
   check(disabled.status()===503,'Disabled intake refuses POST');
  }
  await page.setViewportSize({width:390,height:844});
  await page.goto(origin.origin+'/recursos/checklist-pruebas-recuperacion-backup/');
  await page.locator('main .hero-actions .button').click();
  check(page.url().endsWith('?servicio=backup-recuperacion'),'Guide CTA keeps backup context');
  check(await page.locator('body').getAttribute('data-service')==='backup-recuperacion','Form analytics context matches');
  await page.goto(origin.origin+'/');
  check(await page.locator('video[src]').count()===0,'Reduced motion never loads remote video');
  await page.locator('.nav-toggle').click();
  check(await page.locator('.nav-toggle').getAttribute('aria-expanded')==='true','Mobile menu opens');
  await page.keyboard.press('Escape');
  check(await page.locator('.nav-toggle').getAttribute('aria-expanded')==='false','Escape closes menu');
  check(await page.locator('.nav-toggle').evaluate(e=>document.activeElement===e),'Escape returns focus');
  await page.goto(origin.origin+'/encontra-un-proveedor/');
  check(await page.locator('#preparar-cotizacion').count()===1,'Buying brief available');
  await page.emulateMedia({media:'print'});
  check(await page.locator('.site-header').isHidden(),'Print hides navigation');
  check(await page.locator('.buying-brief').isVisible(),'Print keeps buying brief');
  if(out)await page.pdf({path:join(out,'buying-brief.pdf'),format:'A4',printBackground:true});
  await page.emulateMedia({media:'screen'});
  for(const [path,name] of [['/','home-mobile'],['/servicios/backup-recuperacion/','service-mobile'],['/recursos/checklist-pruebas-recuperacion-backup/','guide-mobile'],['/encontra-un-proveedor/','orientation-mobile']]){
   await page.goto(origin.origin+path,{waitUntil:'networkidle'});
   if(out)await page.screenshot({path:join(out,name+'.png'),fullPage:true});
  }
  const nojs=await browser.newContext({javaScriptEnabled:false,viewport:{width:320,height:800},reducedMotion:'reduce'});
  await nojs.route('**/*',route=>new URL(route.request().url()).origin===origin.origin?route.continue():route.abort());
  const plain=await nojs.newPage();
  for(const path of ['/','/servicios/','/recursos/checklist-pruebas-recuperacion-backup/','/encontra-un-proveedor/']){
   await plain.goto(origin.origin+path,{waitUntil:'networkidle'});
   check(await plain.evaluate(()=>document.documentElement.scrollWidth<=innerWidth+1),path+' noJS no overflow');
   check(await plain.locator('#services-menu summary').isVisible(),path+' noJS nav available');
   check(await plain.locator('main').innerText().then(x=>x.length>100),path+' noJS content available');
  }
  await nojs.close();
  if(process.argv.includes('--synthetic-forms')){
   const response=await page.goto(origin.origin+'/encontra-un-proveedor/?servicio=backup-recuperacion');
   check(response.headers()['x-synthetic-delivery']==='1','Forms only run on synthetic-delivery fixture');
   check(await page.locator('#disparador').inputValue()==='backup','Backup need is preselected');
   await page.selectOption('#rubro','comercio');await page.selectOption('#empleados','1-9');
   await page.fill('#nombre','Synthetic browser enquiry');
   await page.fill('#telefono','not-a-phone'); await page.locator('#email').focus();
   check(await page.locator('#telefono').getAttribute('aria-invalid')==='true','Invalid phone has accessible error state');
   check((await page.locator('#err-telefono').innerText()).includes('formato'),'Phone format error explains correction');
   await page.fill('#telefono','0981 000 000'); await page.locator('#email').focus();
   check(await page.locator('#telefono').getAttribute('aria-invalid')===null,'Corrected phone clears error');
   await page.fill('#email','synthetic@example.invalid');await page.check('#consent');
   check(await page.evaluate(()=>Array.from(window.dataLayer||[]).filter(c=>c[1]==='orientation_start').length)===1,'Browser form start is counted once');
   check(!await page.evaluate(()=>/Synthetic browser enquiry|synthetic@example.invalid|0981 000 000/.test(JSON.stringify(window.dataLayer||[]))),'Browser events exclude form values');
   await page.evaluate(()=>document.querySelector('[name=ts]').value=String(Math.floor(Date.now()/1000)-30));
   await Promise.all([page.waitForURL('**/gracias/'),page.locator('form button[type=submit]').click()]);
   check(await page.locator('h1').innerText()==='Tu solicitud quedó registrada.','Synthetic form acknowledged');
   check(!await page.evaluate(()=>Array.from(window.dataLayer||[]).some(c=>c[1]==='generate_lead')),'Thank-you does not report a false conversion');
   await page.goBack();
   check(await page.locator('form button[type=submit]').isEnabled(),'Back navigation restores submit control');
   // A no-JS form remains submittable with the same server validation.
   const bare=await browser.newContext({javaScriptEnabled:false,viewport:{width:390,height:844}});
   await bare.route('**/*',route=>new URL(route.request().url()).origin===origin.origin?route.continue():route.abort());
   const p=await bare.newPage();await p.goto(origin.origin+'/encontra-un-proveedor/?servicio=iso-27001');
   check(await p.locator('#disparador').inputValue()==='cumplimiento','NoJS service prefill');
   await p.selectOption('#rubro','servicios');await p.selectOption('#empleados','10-24');await p.fill('#nombre','Synthetic noJS enquiry');await p.fill('#telefono','0981 000 001');await p.locator('#consent').press('Space'); check(await p.locator('#consent').isChecked(),'NoJS keyboard consent control');
   await new Promise(r=>setTimeout(r,3100));
   await Promise.all([p.waitForURL('**/gracias/'),p.locator('form button[type=submit]').press('Enter')]);
   check(await p.locator('h1').innerText()==='Tu solicitud quedó registrada.','NoJS synthetic form acknowledged');
   await bare.close();
  }
  check(errors.length===0,'No browser JavaScript errors: '+errors.join(';'));
  console.log('PASS: '+checks.length+' local browser checks; '+(process.argv.includes('--forms-only')?'synthetic forms and keyboard/noJS flows':'all 39 URLs at 320,390,1440px')+'; external traffic blocked.');
 }finally{
  if(out)writeFileSync(join(out,'browser-verification.json'),JSON.stringify({base:origin.origin,checks,errors,externalTrafficBlocked:true},null,2));
  await browser.close();
 }
})().catch(e=>{console.error(e);process.exitCode=1;});
