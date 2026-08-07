<?php
/**
 * B4 — lead form partial.
 *
 * Spec: PHP_FORM_SPEC.md §2.
 *
 * Parameters (set before including):
 *   string $form_type  'contacto' | 'autoevaluacion'
 *   string $page       slug of the originating page, e.g. 'servicios/diagnostico'
 *   array  $errors     field => message, from a failed validation pass
 *   array  $old        field => submitted value, to preserve input
 *
 * Assessment submissions additionally expect JavaScript to populate the
 * hidden score/banda/dominios inputs before submit.
 */

declare(strict_types=1);

$form_type = $form_type ?? 'contacto';
$page      = $page ?? '';
$errors    = $errors ?? [];
$old       = $old ?? [];

/** Escape for HTML text and attribute contexts. */
$e = static fn (?string $v): string
    => htmlspecialchars((string) $v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

/** Previously submitted value, or ''. */
$v = static fn (string $k): string => $e($old[$k] ?? '');

/** Renders the error paragraph and returns the id for aria-describedby. */
$err = static function (string $k) use ($errors, $e): string {
    return isset($errors[$k]) ? 'err-' . $e($k) : '';
};

$selected = static fn (string $k, string $val, array $old): string
    => (($old[$k] ?? '') === $val) ? ' selected' : '';

$empleadosLabels = [
    '1-9'     => '1 a 9',
    '10-24'   => '10 a 24',
    '25-49'   => '25 a 49',
    '50-99'   => '50 a 99',
    '100-249' => '100 a 249',
    '250+'    => '250 o más',
];

$rubroLabels = [
    'salud'      => 'Salud (clínica, consultorio, laboratorio)',
    'contable'   => 'Estudio contable',
    'ecommerce'  => 'Tienda online / ecommerce',
    'financiero' => 'Financiero / cooperativa',
    'industria'  => 'Industria',
    'comercio'   => 'Comercio / importadora',
    'servicios'  => 'Servicios',
    'educacion'  => 'Educación',
    'ong'        => 'ONG / fundación',
    'otro'       => 'Otro',
];

$disparadorLabels = [
    'incidente'    => 'Tuvimos un incidente',
    'cuestionario' => 'Un cliente nos pidió un cuestionario de seguridad',
    'diagnostico'  => 'Queremos saber cómo estamos',
    'pentesting'   => 'Queremos una prueba de penetración',
    'cumplimiento' => 'Tenemos una obligación que cumplir',
    'capacitacion' => 'Queremos capacitar al equipo',
    'otro'         => 'Otra cosa',
];

$preferenciaLabels = [
    'whatsapp' => 'Prefiero WhatsApp',
    'llamada'  => 'Prefiero que me llamen',
    'email'    => 'Prefiero correo',
];
?>
<form method="POST" action="/enviar" novalidate class="lead-form">
  <input type="hidden" name="form_type" value="<?= $e($form_type) ?>">
  <input type="hidden" name="page" value="<?= $e($page) ?>">
  <input type="hidden" name="ts" value="<?= time() ?>">
  <input type="hidden" name="csrf" value="<?= $e(csrf_token()) ?>">

<?php if ($form_type === 'autoevaluacion'): ?>
  <!-- Populated by assets/js/autoevaluacion.js before submit. -->
  <input type="hidden" name="score" value="">
  <input type="hidden" name="banda" value="">
  <input type="hidden" name="dominios" value="">
<?php endif; ?>

  <!-- honeypot: never remove, never make it look tempting to a human -->
  <input name="website" tabindex="-1" autocomplete="off" aria-hidden="true"
         style="position:absolute;left:-9999px">

<?php if ($errors !== []): ?>
  <div class="form-errors" role="alert" tabindex="-1">
    <p>Revisá los campos marcados y volvé a enviar.</p>
  </div>
<?php endif; ?>

  <div class="field">
    <label for="nombre">Nombre <span aria-hidden="true">*</span></label>
    <input id="nombre" name="nombre" type="text" required
           autocomplete="name" maxlength="100" value="<?= $v('nombre') ?>"
           <?= isset($errors['nombre']) ? 'aria-invalid="true" aria-describedby="' . $err('nombre') . '"' : '' ?>>
<?php if (isset($errors['nombre'])): ?>
    <p class="field-error" id="err-nombre"><?= $e($errors['nombre']) ?></p>
<?php endif; ?>
  </div>

  <div class="field">
    <label for="telefono">Teléfono / WhatsApp <span aria-hidden="true">*</span></label>
    <input id="telefono" name="telefono" type="tel" required
           autocomplete="tel" inputmode="tel" maxlength="30"
           placeholder="0981 123 456" value="<?= $v('telefono') ?>"
           <?= isset($errors['telefono']) ? 'aria-invalid="true" aria-describedby="' . $err('telefono') . '"' : '' ?>>
<?php if (isset($errors['telefono'])): ?>
    <p class="field-error" id="err-telefono"><?= $e($errors['telefono']) ?></p>
<?php endif; ?>
  </div>

  <div class="field">
    <label for="preferencia_de_contacto">¿Cómo preferís que te contactemos? <span aria-hidden="true">*</span></label>
    <select id="preferencia_de_contacto" name="preferencia_de_contacto" required
            <?= isset($errors['preferencia_de_contacto']) ? 'aria-invalid="true" aria-describedby="' . $err('preferencia_de_contacto') . '"' : '' ?>>
      <option value="">Elegí una opción</option>
<?php foreach ($preferenciaLabels as $val => $label): ?>
      <option value="<?= $e($val) ?>"<?= $selected('preferencia_de_contacto', $val, $old) ?>><?= $e($label) ?></option>
<?php endforeach; ?>
    </select>
<?php if (isset($errors['preferencia_de_contacto'])): ?>
    <p class="field-error" id="err-preferencia_de_contacto"><?= $e($errors['preferencia_de_contacto']) ?></p>
<?php endif; ?>
  </div>

  <div class="field">
    <label for="email">Correo</label>
    <input id="email" name="email" type="email"
           autocomplete="email" maxlength="320" value="<?= $v('email') ?>"
           <?= isset($errors['email']) ? 'aria-invalid="true" aria-describedby="' . $err('email') . '"' : '' ?>>
<?php if (isset($errors['email'])): ?>
    <p class="field-error" id="err-email"><?= $e($errors['email']) ?></p>
<?php endif; ?>
  </div>

  <div class="field">
    <label for="empresa">Empresa</label>
    <input id="empresa" name="empresa" type="text"
           autocomplete="organization" maxlength="120" value="<?= $v('empresa') ?>"
           <?= isset($errors['empresa']) ? 'aria-invalid="true" aria-describedby="' . $err('empresa') . '"' : '' ?>>
<?php if (isset($errors['empresa'])): ?>
    <p class="field-error" id="err-empresa"><?= $e($errors['empresa']) ?></p>
<?php endif; ?>
  </div>

  <div class="field">
    <label for="empleados">Cantidad de empleados <span aria-hidden="true">*</span></label>
    <select id="empleados" name="empleados" required
            <?= isset($errors['empleados']) ? 'aria-invalid="true" aria-describedby="' . $err('empleados') . '"' : '' ?>>
      <option value="">Elegí una opción</option>
<?php foreach ($empleadosLabels as $val => $label): ?>
      <option value="<?= $e($val) ?>"<?= $selected('empleados', $val, $old) ?>><?= $e($label) ?></option>
<?php endforeach; ?>
    </select>
<?php if (isset($errors['empleados'])): ?>
    <p class="field-error" id="err-empleados"><?= $e($errors['empleados']) ?></p>
<?php endif; ?>
  </div>

  <div class="field">
    <label for="rubro">Rubro <span aria-hidden="true">*</span></label>
    <select id="rubro" name="rubro" required
            <?= isset($errors['rubro']) ? 'aria-invalid="true" aria-describedby="' . $err('rubro') . '"' : '' ?>>
      <option value="">Elegí una opción</option>
<?php foreach ($rubroLabels as $val => $label): ?>
      <option value="<?= $e($val) ?>"<?= $selected('rubro', $val, $old) ?>><?= $e($label) ?></option>
<?php endforeach; ?>
    </select>
<?php if (isset($errors['rubro'])): ?>
    <p class="field-error" id="err-rubro"><?= $e($errors['rubro']) ?></p>
<?php endif; ?>
  </div>

  <div class="field">
    <label for="disparador">¿Qué te trae por acá? <span aria-hidden="true">*</span></label>
    <select id="disparador" name="disparador" required
            <?= isset($errors['disparador']) ? 'aria-invalid="true" aria-describedby="' . $err('disparador') . '"' : '' ?>>
      <option value="">Elegí una opción</option>
<?php foreach ($disparadorLabels as $val => $label): ?>
      <option value="<?= $e($val) ?>"<?= $selected('disparador', $val, $old) ?>><?= $e($label) ?></option>
<?php endforeach; ?>
    </select>
<?php if (isset($errors['disparador'])): ?>
    <p class="field-error" id="err-disparador"><?= $e($errors['disparador']) ?></p>
<?php endif; ?>
  </div>

<?php if ($form_type === 'contacto'): ?>
  <div class="field">
    <label for="mensaje">Contanos brevemente</label>
    <textarea id="mensaje" name="mensaje" rows="4" maxlength="2000"
              <?= isset($errors['mensaje']) ? 'aria-invalid="true" aria-describedby="err-mensaje"' : 'aria-describedby="hint-mensaje"' ?>><?= $v('mensaje') ?></textarea>
    <p class="hint" id="hint-mensaje">No incluyas contraseñas ni detalles técnicos sensibles —
       eso lo conversamos por un canal seguro.</p>
<?php if (isset($errors['mensaje'])): ?>
    <p class="field-error" id="err-mensaje"><?= $e($errors['mensaje']) ?></p>
<?php endif; ?>
  </div>
<?php endif; ?>

  <button type="submit">Enviar consulta</button>

  <p class="form-note">
    <!-- TODO(content): replace with the real practitioner name (Phase 0). -->
    Recibe tu consulta [Nombre real], directamente. Respondemos en el día hábil.
    Tus datos no se comparten con terceros.
    <a href="/politica-de-privacidad">Política de privacidad</a>.
  </p>
</form>
