// Dependency-free unit checks; no browser/network/provider calls.
const test = require('node:test');
const assert = require('node:assert/strict');
const {readFileSync} = require('node:fs');
const {join} = require('node:path');
const {runInNewContext} = require('node:vm');
const source=readFileSync(join(__dirname,'../public_html/assets/js/analytics.js'),'utf8');
function setup({id='G-TEST',page='encontra-un-proveedor',service='backup-recuperacion'}={}) {
  const events={}, fields={}, created=[];
  const form={addEventListener:(k,f)=>fields[k]=f,checkValidity:()=>true};
  const body={getAttribute:k=>({'data-page':page,'data-service':service}[k]||null)};
  const document={currentScript:{getAttribute:()=>id},body,head:{appendChild:s=>created.push(s)},
    createElement:()=>({}),addEventListener:(k,f)=>events[k]=f,querySelectorAll:()=>[form]};
  const window={};
  runInNewContext(source,{document,window,location:{origin:'https://example.invalid',pathname:'/untrusted-path',search:'?email=PRIVATE&token=SECRET',href:'https://example.invalid/?SECRET'},Date,Array});
  return {window,events,fields,form,created, calls:()=>Array.from(window.dataLayer||[],x=>Array.from(x))};
}
test('GA remains completely off when absent or malformed',()=>{
  for(const id of ['',null,'G-X<script>']) { const x=setup({id}); assert.equal(x.calls().length,0);assert.equal(x.created.length,0); }
});
test('page URL/referrer exclude query, raw pathname and contact data',()=>{
  const x=setup();const text=JSON.stringify(x.calls());
  assert(!/PRIVATE|SECRET|untrusted-path/.test(text));
  const cfg=x.calls().find(c=>c[0]==='config')[2];
  assert.equal(cfg.page_location,'https://example.invalid/encontra-un-proveedor/');
  assert.equal(cfg.page_referrer,'');assert.equal(cfg.send_page_view,false);
  assert.equal(x.calls().filter(c=>c[1]==='page_view').length,1);
});
test('click records current service without reading destination or fields',()=>{
  const x=setup();
  for(const href of ['/encontra-un-proveedor/?servicio=backup-recuperacion','tel:+595000000','https://wa.me/595000000']) {
    x.events.click({target:{closest:()=>({getAttribute:()=>href})}});
  }
  const intent=x.calls().filter(c=>c[0]==='event').slice(1);
  assert.deepEqual(intent.map(c=>c[1]),['orientation_click','phone_click','whatsapp_click']);
  assert(!JSON.stringify(intent).includes('595000000'));
  assert(intent.every(c=>c[2].service==='backup-recuperacion'));
});
test('form start is one-time and ignores hidden/honeypot fields',()=>{
  const x=setup();
  x.fields.input({target:{tagName:'INPUT',type:'hidden',name:'csrf',value:'SECRET'}});
  x.fields.change({target:{tagName:'INPUT',type:'text',name:'website',value:'SECRET'}});
  for(let i=0;i<2;i++)x.fields.input({target:{tagName:'INPUT',type:'text',name:'nombre',value:'PRIVATE'}});
  assert.equal(x.calls().filter(c=>c[1]==='orientation_start').length,1);
  assert(!/SECRET|PRIVATE/.test(JSON.stringify(x.calls())));
});
test('prevented/invalid submissions never count; valid event is intent only',()=>{
  const x=setup();x.fields.submit({defaultPrevented:true});
  x.form.checkValidity=()=>false;x.fields.submit({defaultPrevented:false});
  assert.equal(x.calls().filter(c=>c[1]==='orientation_submit').length,0);
  x.form.checkValidity=()=>true;x.fields.submit({defaultPrevented:false});
  assert.equal(x.calls().filter(c=>c[1]==='orientation_submit').length,1);
  assert.equal(x.calls().find(c=>c[1]==='orientation_submit')[2].form_type,'orientacion');
  assert.equal(x.calls().filter(c=>c[1]==='generate_lead').length,0);
});
test('direct/reloaded thank-you and legacy assessment never become conversions',()=>{
  for(let i=0;i<2;i++) {
    const x=setup({page:'gracias',service:''});
    assert.deepEqual(x.calls().filter(c=>c[0]==='event').map(c=>c[1]),['page_view']);
  }
});
test('malformed DOM page context refuses tracking',()=>{
  assert.equal(setup({page:'bad?token=SECRET'}).calls().length,0);
});
