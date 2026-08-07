<?php
declare(strict_types=1);

/**
 * /servicios/respuesta-a-incidentes — BUILD-SPEC-PAGES.md §3. MODE A, overrides
 * the shared service template entirely.
 *
 * Hard constraints: no hero image, no scroll reveal (no data-reveal anywhere
 * on this page), no card-motif images, no P9 statement section. Phone is the
 * largest element after H1. First content block is defensive advice, not
 * marketing. WhatsApp + tel: co-primary. No FAQ — "a person in a crisis does
 * not read an accordion."
 *
 * ⚠️ The 24/7 line ships as written per BUILD-SPEC.md §12 item 1 — this is a
 * launch-blocking assumption. If nobody genuinely answers at 02:00 on a
 * Sunday, swap it (here and in public_html/index.php §06) for:
 * "Respondemos en horario laboral y devolvemos las llamadas fuera de horario."
 */

require_once dirname(__DIR__, 2) . '/src/render.php';

layout_open([
    'title'       => 'Respuesta a incidentes de seguridad | Paraguay',
    'description' => '¿Ransomware, cuenta tomada o fraude en curso? Contención, análisis, recuperación e informe de cierre. Escribinos o llamanos ahora.',
    'path'        => '/servicios/respuesta-a-incidentes',
    'mode'        => 'a',
    'wa_slug'     => 'incidente',
    'jsonld'      => [
        service_jsonld('Respuesta a incidentes de seguridad'),
        breadcrumb_jsonld([['Inicio', '/'], ['Servicios', ''], ['Respuesta a incidentes', '']]),
    ],
]);
?>
<main id="main">

  <!-- 01 · Hero -->
  <section class="hero" style="padding-block:var(--s-16)">
    <div class="wrap">
      <span class="eyebrow" style="color:var(--danger)">RESPUESTA A INCIDENTES</span>
      <h1>¿Tenés un incidente en curso?</h1>
      <div class="btn-row">
        <a class="btn btn--danger" style="font-size:var(--t-1);min-height:60px;padding-inline:var(--s-8)" href="<?= htmlspecialchars(wa_url('incidente', 'necesitamos ayuda urgente')) ?>" data-ev="whatsapp_click" data-ev-loc="incidente"><?= wa_glyph() ?> Escribinos por WhatsApp</a>
        <a class="btn btn--ghost" style="font-size:var(--t-1);min-height:60px;padding-inline:var(--s-8);border:2px solid var(--danger);color:var(--danger)" href="<?= htmlspecialchars(tel_href()) ?>" data-ev="call_click" data-ev-loc="incidente">+595 995 628862</a>
      </div>
      <p><strong>Si sospechás que tu correo o tu teléfono están comprometidos, llamanos desde otro dispositivo.</strong></p>
      <small>⚠️ Atendemos incidentes las 24 horas, todos los días.</small>
    </div>
  </section>

  <!-- 02 · Qué hacer ahora mismo · P3, four card--accent -->
  <section>
    <div class="wrap">
      <h2>Qué hacer ahora mismo, antes de que lleguemos.</h2>
      <div class="p3-grid" data-count="4" style="margin-top:var(--s-8)">
        <div class="card card--accent" style="border-top-color:var(--danger)">
          <h3>Desconectá de la red, no apagues</h3>
          <p>Sacá el cable de red o el wifi de los equipos afectados, pero <strong>no los apagues</strong>. Apagar borra evidencia que está solo en memoria y que sirve para entender por dónde entraron.</p>
        </div>
        <div class="card card--accent" style="border-top-color:var(--danger)">
          <h3>No borres nada</h3>
          <p>Ni archivos raros, ni correos, ni registros, ni la nota del atacante. Aunque moleste verlo. Todo eso es lo que después permite reconstruir qué pasó y responderle al cliente que pregunta.</p>
        </div>
        <div class="card card--accent" style="border-top-color:var(--danger)">
          <h3>No pagues todavía</h3>
          <p>Pagar no garantiza recuperar los datos, y hay decisiones legales y de seguro que conviene tomar informado y no a las tres de la mañana. Hablemos primero.</p>
        </div>
        <div class="card card--accent" style="border-top-color:var(--danger)">
          <h3>Anotá lo que viste y cuándo</h3>
          <p>Qué apareció en pantalla, a qué hora, quién lo notó primero, qué se hizo después. Escribilo en papel o en un teléfono que no esté involucrado. Esa línea de tiempo vale muchísimo.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- 03 · Qué hacemos · P4 -->
  <section>
    <div class="wrap p4">
      <div class="p4-heading">
        <span class="eyebrow">EL TRABAJO</span>
        <h2>Contener primero, entender después, reconstruir al final.</h2>
      </div>
      <div class="p4-body" style="display:flex;flex-direction:column;gap:var(--s-6)">
        <div><h3>Contención</h3><p>Cortar el acceso del atacante y frenar la propagación. Aislamiento de equipos, corte de sesiones activas, rotación de credenciales y cierre de las vías de entrada que ya identificamos.</p></div>
        <div><h3>Análisis</h3><p>Por dónde entraron, hasta dónde llegaron, qué datos tocaron y desde cuándo estaban adentro. Esa última pregunta es casi siempre la más incómoda y la más importante.</p></div>
        <div><h3>Recuperación</h3><p>Restauración ordenada y verificada, en un orden que no vuelva a exponer lo mismo. Restaurar rápido sobre una vulnerabilidad abierta es cómo se sufre el mismo ataque dos veces en una semana.</p></div>
        <div><h3>Cierre</h3><p>Informe con la línea de tiempo, el alcance, qué se hizo y qué queda por hacer. Sirve para el seguro, para el cliente que pregunta y para la decisión de si corresponde notificar.</p></div>
      </div>
    </div>
  </section>

  <!-- 04 · Las primeras 48 horas · P5 -->
  <section>
    <div class="wrap">
      <h2>Las primeras 48 horas.</h2>
      <div class="p5-rail" style="--rail-count:4;margin-top:var(--s-12)">
        <div class="p5-step"><span class="step-num">1</span><h3>Primeras 2 horas · Contacto y contención inicial</h3><p>Entendemos qué está pasando, te damos instrucciones concretas por teléfono mientras nos organizamos, y frenamos lo que se pueda frenar de inmediato.</p></div>
        <div class="p5-step"><span class="step-num">2</span><h3>Primeras 24 horas · Alcance</h3><p>Determinamos qué sistemas y qué datos están involucrados, y si el atacante sigue adentro.</p></div>
        <div class="p5-step"><span class="step-num">3</span><h3>48 horas · Plan de recuperación</h3><p>Un plan escrito con el orden de restauración y qué hay que corregir antes de volver a poner cada cosa en línea.</p></div>
        <div class="p5-step"><span class="step-num">4</span><h3>Después · Cierre y endurecimiento</h3><p>Informe final y las correcciones que evitan la repetición. Muchos incidentes son el segundo ataque por la misma puerta.</p></div>
      </div>
    </div>
  </section>

  <!-- 05 · Después del incidente · P4 -->
  <section>
    <div class="wrap p4">
      <div class="p4-heading">
        <h2>Lo que sigue.</h2>
      </div>
      <div class="p4-body">
        <p>Cuando la urgencia baja, queda la parte que evita la próxima: cerrar la vía de entrada, revisar si esa misma debilidad existe en otro lado, y dejar por escrito qué hacer si vuelve a pasar.</p>
        <p>Eso normalmente continúa como una <a href="/servicios/auditoria-de-seguridad">auditoría de seguridad</a>, y si ya trabajamos juntos en el incidente descontamos el relevamiento que ya hicimos.</p>
      </div>
    </div>
  </section>

  <!-- 06 · Contacto · P1 mirrored, Mode A CTAs repeated -->
  <section id="contacto">
    <div class="wrap p1 p1--mirrored">
      <div>
        <span class="eyebrow" style="color:var(--danger)">CONTACTO</span>
        <h2>Escribinos o llamanos ahora.</h2>
        <div class="btn-row">
          <a class="btn btn--danger" href="<?= htmlspecialchars(wa_url('incidente', 'necesitamos ayuda urgente')) ?>" data-ev="whatsapp_click" data-ev-loc="incidente"><?= wa_glyph() ?> Escribinos por WhatsApp</a>
          <a class="btn btn--ghost" style="border-color:var(--danger);color:var(--danger)" href="<?= htmlspecialchars(tel_href()) ?>" data-ev="call_click" data-ev-loc="incidente">+595 995 628862</a>
        </div>
      </div>
      <div>
        <p>Contanos brevemente y te respondemos ahora.</p>
        <?php
        $form_type = 'contacto';
        $page      = 'servicios/respuesta-a-incidentes';
        $errors    = [];
        $old       = [];
        require dirname(__DIR__, 2) . '/src/partials/lead-form.php';
        ?>
      </div>
    </div>
  </section>

</main>
<?php
layout_close(['mode' => 'a', 'wa_slug' => 'incidente']);
