/* Local-only mega menu integration checks; external requests always blocked. */
const {chromium}=require('playwright');
const {mkdirSync}=require('node:fs');
const {join}=require('node:path');
const origin=new URL(process.argv[2]||'http://127.0.0.1:8899');
if(!['127.0.0.1','localhost'].includes(origin.hostname)||origin.protocol!=='http:')throw Error('Loopback only');
const out=process.env.BROWSER_ARTIFACTS;if(out)mkdirSync(out,{recursive:true});
let n=0;const check=(ok,label)=>{if(!ok)throw Error(label);n++;};
(async()=>{
 const browser=await chromium.launch({headless:true,...(process.env.BROWSER_EXECUTABLE?{executablePath:process.env.BROWSER_EXECUTABLE}:{}),args:['--disable-background-networking','--disable-component-update','--no-first-run','--host-resolver-rules=MAP * ~NOTFOUND, EXCLUDE 127.0.0.1']});
 try{
  for(const js of [true,false]){
   const c=await browser.newContext({javaScriptEnabled:js,reducedMotion:'reduce'});
   await c.route('**/*',r=>new URL(r.request().url()).origin===origin.origin?r.continue():r.abort());
   const p=await c.newPage();const errors=[];p.on('pageerror',e=>errors.push(e.message));
   for(const width of [320,390,768,1151,1200,1440]){
    await p.setViewportSize({width,height:900});
    await p.goto(origin.origin+'/',{waitUntil:'networkidle'});
    check(await p.evaluate(()=>document.documentElement.scrollWidth<=innerWidth+1),'Closed header no overflow '+width+' JS='+js);
    if(js && width<=1150){
     await p.locator('.nav-toggle').click();
     check(await p.locator('#services-menu summary').evaluate(e=>e===document.activeElement),'Mobile opening focuses services disclosure '+width);
    }
    await p.locator('#services-menu summary').press('Enter');
    check(await p.locator('#services-menu').getAttribute('open')!==null,'Enter opens native services '+width+' JS='+js);
    check(await p.locator('.mega-group a').count()===17,'All17 links rendered '+width);
    check(await p.locator('.mega-group a').first().isVisible(),'Service links visible '+width);
    check(await p.evaluate(()=>document.documentElement.scrollWidth<=innerWidth+1),'Open menu no overflow '+width+' JS='+js);
    if(out && [390,1440].includes(width))await p.screenshot({path:join(out,'menu-'+width+'-js-'+js+'.png'),fullPage:false});
    if(js){
     await p.locator('.mega-group a').first().focus();
     await p.keyboard.press('Escape');
     check(await p.locator('#services-menu').getAttribute('open')===null,'Escape closes services '+width);
     check(await p.locator('#services-menu summary').evaluate(e=>e===document.activeElement),'Escape restores disclosure focus '+width);
     if(width<=1150){
      check(await p.locator('.nav-toggle').getAttribute('aria-expanded')==='true','First Escape retains mobile nav '+width);
      await p.keyboard.press('Escape');
      check(await p.locator('.nav-toggle').getAttribute('aria-expanded')==='false','Second Escape closes mobile nav '+width);
      await p.locator('.nav-toggle').click();
     }
     await p.locator('#services-menu summary').click();
     await p.locator('.mega-intro a').focus();await p.keyboard.press('Tab');
     check(await p.locator('.mega-group a').first().evaluate(e=>e===document.activeElement),'Tab reaches service links '+width);
     // Focus can leave the disclosure normally; this closes only the disclosure.
     await p.locator('.header-incident').focus();
     check(await p.locator('#services-menu').getAttribute('open')===null,'Focus outside dismisses disclosure '+width);
     await p.locator('#services-menu summary').click();
     await p.locator('.site-header .brand').click();
     check(await p.locator('#services-menu').getAttribute('open')===null,'Outside click dismisses '+width);
     if(width<=1150)await p.locator('.nav-toggle').click();
     await p.locator('#services-menu summary').click();
    }
    await p.locator('.mega-group a[href="/servicios/backup-recuperacion/"]').click();
    check(p.url()===origin.origin+'/servicios/backup-recuperacion/','Native service navigation '+width+' JS='+js);
    if(js && width<=1150)await p.locator('.nav-toggle').click();
    await p.locator('#services-menu summary').click();
    check(await p.locator('.mega-group a[aria-current=page]').getAttribute('href')==='/servicios/backup-recuperacion/','Current service marked '+width);
   }
   check(errors.length===0,'No JS errors');
   await c.close();
  }
  console.log('PASS: '+n+' mega-menu browser checks, desktop/mobile/keyboard/noJS; external traffic blocked.');
 }finally{await browser.close();}
})().catch(e=>{console.error(e);process.exitCode=1;});
