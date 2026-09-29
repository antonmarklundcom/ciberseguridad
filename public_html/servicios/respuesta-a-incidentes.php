<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/src/render.php';

/*
 * Incident page: overrides the shared template (SERVICE_PAGE_PLAN.md §2).
 * No images, no reveal, no motion, no site.js. The danger colour is used for
 * the phone CTA here and nowhere else. No recovery outcome is promised.
 */
$availability = (string) cfg('incident_availability');

page_start('servicios/respuesta-a-incidentes');
?>
<section class="hero">
  <div class="wrap narrow">
    <h1>Respuesta a incidentes de seguridad</h1>
    <p class="phone-xl"><a href="<?= e(tel_href()) ?>" data-track="phone"><?= e(cfg('phone_display')) ?></a></p>
    <p><a class="btn btn--danger" href="<?= e(tel_href()) ?>" data-track="phone">Llamanos ahora</a></p>
    <p>También por <a href="<?= e(wa(current_page()['wa'])) ?>" data-track="whatsapp">WhatsApp</a>.</p>
    <div class="callout callout--warn"><p><strong>Si sospechás que tu correo o tu teléfono están comprometidos, llamanos desde otro dispositivo.</strong></p></div>
  </div>
</section>

<section class="section section--alt">
  <div class="wrap narrow prose">
    <h2>Qué hacer ahora mismo</h2>
    <p>Son pasos defensivos. Podés hacerlos antes de llamarnos y no empeoran nada.</p>
    <ol>
      <li><strong>Desconectá de la red los equipos afectados, pero no los apagues.</strong> La memoria puede guardar evidencia que se pierde al apagar. Sacá el cable de red o desactivá el wifi.</li>
      <li><strong>No borres nada</strong>, tampoco la nota de rescate ni los correos sospechosos. Después no se pueden recuperar como prueba.</li>
      <li><strong>No pagues antes de entender la situación.</strong> Pagar no asegura que recuperes tus archivos y puede volver a tu empresa un blanco fácil.</li>
      <li><strong>Cambiá las contraseñas críticas desde un dispositivo que sepas que está limpio</strong>, empezando por el correo y la banca.</li>
      <li><strong>Anotá qué viste y a qué hora</strong>, a medida que pasa. Esa cronología ordena toda la investigación.</li>
      <li><strong>Si se movió dinero, llamá al banco ya.</strong> La ventana para frenar una transferencia se mide en horas.</li>
    </ol>
    <p class="note">También podés imprimir nuestro <a href="/recursos/checklist-de-incidentes">checklist de incidentes</a> según el tipo de ataque, para tenerlo a mano.</p>
  </div>
</section>

<section class="section">
  <div class="wrap narrow prose">
    <h2>Cómo te ayudamos</h2>
    <ul class="checks">
      <li><strong>Contención.</strong> Cortar el avance: aislar equipos, cerrar accesos y cuentas comprometidas.</li>
      <li><strong>Investigación.</strong> Reconstruir qué pasó, por dónde entraron y qué se vio afectado.</li>
      <li><strong>Recuperación.</strong> Restaurar servicios desde las copias que estén sanas y recuperar lo que sea técnicamente posible.</li>
      <li><strong>Informe.</strong> Un documento escrito con lo ocurrido, el impacto y lo que hay que cambiar.</li>
    </ul>
    <div class="callout">
      <p><strong>Qué no prometemos.</strong> No podemos asegurar que tus archivos cifrados se recuperen: muchas veces no se puede. Te explicamos el proceso y las opciones reales en cada etapa, no el resultado.</p>
    </div>

    <h2>Las primeras 48 horas</h2>
    <p>Así suele ser el arranque de un trabajo de este tipo. Los tiempos dependen de cada caso.</p>
    <ol>
      <li><strong>Primera llamada.</strong> Entendemos qué pasó, qué está afectado y qué ya hiciste. Te indicamos qué preservar.</li>
      <li><strong>Primeras horas.</strong> Acordamos el alcance por escrito, con tu autorización para trabajar sobre tus sistemas, y empezamos la contención.</li>
      <li><strong>Primer día.</strong> Identificamos las cuentas y equipos comprometidos y decidimos el orden de recuperación con vos.</li>
      <li><strong>Segundo día.</strong> Restauración por etapas, cambio de credenciales y un primer resumen de lo que sabemos y lo que todavía no.</li>
    </ol>

    <h2>Después del incidente</h2>
    <p>Si nada cambia, muchas organizaciones vuelven a ser afectadas por la misma brecha. Por eso el cierre natural es un <a href="/servicios/diagnostico">diagnóstico de seguridad</a> que revise las áreas que fallaron, y, si querés seguimiento, la <a href="/servicios/seguridad-gestionada">seguridad gestionada</a>.</p>

    <h2>Disponibilidad y costos</h2>
    <p><?= e($availability) ?></p>
    <?= price_block('incidentes', 'Acordamos el alcance y el precio por escrito antes de trabajar sobre tus sistemas. No facturamos horas abiertas sin que lo hayas aprobado.') ?>
  </div>
</section>

<section class="section section--dark">
  <div class="wrap narrow">
    <h2>Llamanos</h2>
    <p class="phone-xl"><a href="<?= e(tel_href()) ?>" data-track="phone"><?= e(cfg('phone_display')) ?></a></p>
  </div>
</section>
<?php
page_end([
    'schema' => [service_ld('servicios/respuesta-a-incidentes', 'Respuesta a incidentes de seguridad', 'Contención, investigación y recuperación tras un incidente de seguridad, con informe posterior. No garantiza la recuperación de archivos.')],
    'minimal' => true,
    'sticky' => 'tel',
    'body_class' => 'page-incident',
    'service' => 'respuesta-a-incidentes',
]);
