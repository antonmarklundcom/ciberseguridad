<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/form-handler.php';
$errors=$errors??[]; $old=$old??[];
if ($old === [] && is_string($_GET['servicio'] ?? null)) {
    $service = $_GET['servicio'];
    if (isset(site_pages()['servicios/' . $service])) {
        $page = 'servicios/' . $service;
        $old['disparador'] = match ($service) {
            'backup-recuperacion', 'preparacion-recuperacion-ransomware', 'preparacion-respuesta-incidentes' => 'backup',
            'seguridad-microsoft-365-google-workspace', 'revision-seguridad-nube', 'seguridad-red-endpoints' => 'cuentas',
            'capacitacion-phishing' => 'capacitacion',
            'iso-27001', 'asesoria-pci-dss', 'proteccion-datos-personales', 'politicas-gobernanza-seguridad' => 'cumplimiento',
            'ciso-externo', 'monitoreo-gestionado-soc' => 'continuo',
            'pentesting-autorizado' => 'cuestionario',
            default => 'diagnostico',
        };
    }
}
$value=static fn(string $key): string => e($old[$key]??'');
$attrs=static fn(string $key): string => isset($errors[$key])?' aria-invalid="true" aria-describedby="err-'.e($key).'"':'';
$error=static fn(string $key): string => isset($errors[$key])?'<p class="field-error" id="err-'.e($key).'">'.e($errors[$key]).'</p>':'';
$choices=[
 'rubro'=>['comercio'=>'Comercio / importadora','servicios'=>'Servicios profesionales','ecommerce'=>'Tienda online','salud'=>'Clínica / consultorio','contable'=>'Estudio contable','industria'=>'Industria','financiero'=>'Cooperativa / financiero','educacion'=>'Educación','ong'=>'ONG / asociación','otro'=>'Otro'],
 'empleados'=>['1-9'=>'1 a 9 personas','10-24'=>'10 a 24','25-49'=>'25 a 49','50-99'=>'50 a 99','100-249'=>'100 a 249','250+'=>'250 o más'],
 'disparador'=>['diagnostico'=>'No sé por dónde empezar','cuentas'=>'Cuentas y correo','backup'=>'Backup y continuidad','capacitacion'=>'Capacitación del equipo','cuestionario'=>'Un cliente pide pruebas o un cuestionario','cumplimiento'=>'Cumplimiento / políticas','continuo'=>'Acompañamiento continuo','contacto'=>'Consulta general / editorial / privacidad']
];
$labels=['rubro'=>'Tipo de empresa','empleados'=>'Tamaño del equipo','disparador'=>'¿Qué querés resolver?'];
?>
<?php if (!cfg('lead_enabled')): ?>
<div class="empty-state" id="formulario"><h2>El canal de solicitudes está en preparación</h2><p>Mientras se confirma quién recibe las solicitudes, podés consultar el alcance de cada servicio y preparar tus preguntas.</p><a class="button" href="/servicios/">Comparar servicios ↗</a><?php if (cfg('contact_email')): ?><p><a href="mailto:<?= e(cfg('contact_email')) ?>">Contactar a la plataforma</a></p><?php endif; ?></div>
<?php else: ?>
<form class="lead-form" id="formulario" method="post" action="/enviar/">
<input type="hidden" name="form_type" value="orientacion"><input type="hidden" name="page" value="<?= e($page??'encontra-un-proveedor') ?>"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="ts" value="<?= time() ?>">
<div class="hp" aria-hidden="true"><input name="website" tabindex="-1" autocomplete="off" aria-label="Dejá vacío"></div>
<?php if ($errors): ?><div class="form-errors" role="alert" tabindex="-1"><p>Revisá los campos marcados. Tu solicitud todavía no se envió.</p><?php if(isset($errors['form'])): ?><p><?= e($errors['form']) ?></p><?php endif; ?></div><?php endif; ?>
<p class="form-note">Los campos con * son obligatorios.</p>
<?php foreach($labels as $key=>$label): ?><div class="field"><label for="<?= e($key) ?>"><?= e($label) ?> *</label><select id="<?= e($key) ?>" name="<?= e($key) ?>" required<?= $attrs($key) ?>><option value="">Elegí una opción</option><?php foreach($choices[$key] as $id=>$text): ?><option value="<?= e($id) ?>"<?= ($old[$key]??'')===$id?' selected':'' ?>><?= e($text) ?></option><?php endforeach; ?></select><?= $error($key) ?></div><?php endforeach; ?>
<div class="field-row"><div class="field"><label for="nombre">Nombre *</label><input id="nombre" name="nombre" required minlength="2" maxlength="100" autocomplete="name" value="<?= $value('nombre') ?>"<?= $attrs('nombre') ?>><?= $error('nombre') ?></div><div class="field"><label for="telefono">Teléfono / WhatsApp *</label><input id="telefono" name="telefono" type="tel" required maxlength="30" autocomplete="tel" inputmode="tel" pattern="[0-9 +().\-]{6,30}" placeholder="0981 123 456" value="<?= $value('telefono') ?>"<?= $attrs('telefono') ?>><?= $error('telefono') ?></div></div>
<div class="field"><label for="email">Correo laboral (opcional)</label><input id="email" name="email" type="email" maxlength="254" autocomplete="email" value="<?= $value('email') ?>"<?= $attrs('email') ?>><?= $error('email') ?></div>
<div class="field"><label class="consent" for="consent"><input id="consent" name="consent" type="checkbox" value="1" required<?= ($old['consent']??'')==='1'?' checked':'' ?><?= $attrs('consent') ?>><span>Acepto el uso de estos datos para responder esta solicitud según la <a href="/privacidad/">política de privacidad</a>.</span></label><?= $error('consent') ?></div>
<button class="button" type="submit">Enviar solicitud <span aria-hidden="true">↗</span></button><p class="form-note">Recibe: <?= e(cfg('practitioner')) ?>, responsable de la plataforma. El envío no garantiza respuesta inmediata ni disponibilidad de un proveedor. No compartimos tu contacto con un especialista sin acordarlo con vos.</p>
</form>
<?php endif; ?>
