<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/src/render.php';

/*
 * Incident checklist. Defensive guidance only: contain, preserve, notify,
 * recover. Every path ends at /servicios/respuesta-a-incidentes. All paths are
 * in the HTML so the page works without JS; checklist.js only filters them.
 */
$paths = [
    'ransomware' => ['Archivos cifrados o nota de rescate', [
        'Desconectá de la red los equipos afectados, pero no los apagues: la memoria puede guardar evidencia.',
        'No borres nada, tampoco la nota de rescate.',
        'Desconectá también las copias de seguridad conectadas a la red, para que no se cifren.',
        'No pagues antes de entender la situación: pagar no asegura recuperar los archivos.',
        'Cambiá las contraseñas críticas desde un dispositivo que sepas que está limpio.',
        'Anotá qué viste y a qué hora, a medida que pasa.',
        'Avisá a tu proveedor de IT y a quien decide en la empresa.',
    ]],
    'cuenta' => ['Una cuenta de correo o de redes fue tomada', [
        'Cambiá la contraseña desde un dispositivo limpio y cerrá todas las sesiones abiertas.',
        'Activá el segundo factor en esa cuenta si no lo tenía.',
        'Revisá las reglas de reenvío y los dispositivos conectados: los atacantes suelen dejar un reenvío automático.',
        'Avisá a tus contactos, por otro canal, que ignoren mensajes recientes de esa cuenta.',
        'Si la cuenta se usaba para recuperar otras (banco, redes), cambiá también esas claves.',
        'Anotá qué viste y a qué hora.',
        'Si la cuenta era de WhatsApp, pedí la recuperación desde la aplicación y avisá a tus contactos por otro medio.',
    ]],
    'datos' => ['Se filtraron datos de clientes o de la empresa', [
        'Cortá el acceso por el que se filtraron: cuenta, permiso, enlace compartido o equipo.',
        'No borres registros ni archivos: se necesitan para saber qué salió.',
        'Anotá qué datos pueden estar afectados, de cuántas personas y desde cuándo.',
        'Cambiá las credenciales relacionadas desde un dispositivo limpio.',
        'Definí quién decide y quién comunica. Evitá mensajes improvisados a clientes.',
        'Consultá con un abogado sobre avisos y obligaciones antes de comunicar.',
        'Guardá una cronología escrita.',
    ]],
    'transferencia' => ['Se hizo una transferencia fraudulenta', [
        'Llamá al banco ahora, por teléfono. La ventana para frenar una transferencia se mide en horas.',
        'Pedí que intenten frenar o recuperar el pago y que bloqueen la cuenta de destino si es posible.',
        'No respondas al correo del supuesto proveedor ni le avises de que descubriste el fraude.',
        'Guardá los correos originales, con sus encabezados, y capturas del pedido de cambio de cuenta.',
        'Cambiá la contraseña del correo de quien recibió el pedido, desde un dispositivo limpio.',
        'Revisá si se cambiaron reglas o reenvíos en las cuentas de correo.',
        'Presentá la denuncia correspondiente y consultá qué exige tu banco.',
    ]],
    'nose' => ['No sé qué pasó, pero algo anda mal', [
        'Anotá qué notaste, a qué hora y en qué equipos o cuentas.',
        'Si un equipo se comporta raro, desconectalo de la red sin apagarlo.',
        'No borres ni reinstales nada todavía.',
        'Cambiá las contraseñas del correo y de la banca desde un dispositivo que sepas limpio.',
        'Avisá a tu proveedor de IT y a quien decide en la empresa.',
        'Ante cualquier duda de dinero movido, llamá al banco.',
    ]],
];

page_start('recursos/checklist-de-incidentes');
echo breadcrumbs('recursos/checklist-de-incidentes');
?>
<section class="hero">
  <div class="wrap narrow">
    <p class="eyebrow">Herramienta gratuita</p>
    <h1>Qué hacer si hackean tu empresa: checklist de incidentes</h1>
    <p class="lead">Pasos defensivos para las primeras horas, según lo que pasó. Elegí tu caso, seguí la lista e imprimila si te sirve.</p>
    <div class="callout">
      <p><strong>Es orientación general, no un reemplazo de un profesional.</strong> Si sospechás que tu correo o tu teléfono están comprometidos, llamanos desde otro dispositivo: <a href="<?= e(tel_href()) ?>" data-track="phone"><?= e(cfg('phone_display')) ?></a>.</p>
    </div>
  </div>
</section>

<section class="section section--alt print-list">
  <div class="wrap narrow">
    <h2>¿Qué pasó?</h2>
    <div class="path-pick" id="path-pick">
<?php foreach ($paths as $id => [$title, $steps]): ?>
      <a href="#<?= e($id) ?>" data-path="<?= e($id) ?>"><?= e($title) ?></a>
<?php endforeach; ?>
    </div>
    <p class="no-print"><button type="button" class="btn btn--ghost js-only" id="btn-print-list" hidden>Imprimir esta lista</button></p>
  </div>
</section>

<section class="section print-list">
  <div class="wrap narrow">
<?php foreach ($paths as $id => [$title, $steps]): ?>
    <div class="path" id="<?= e($id) ?>">
      <h2><?= e($title) ?></h2>
      <ol>
<?php foreach ($steps as $s): ?>
        <li><?= e($s) ?></li>
<?php endforeach; ?>
      </ol>
      <p><strong>Siguiente paso:</strong> <a href="/servicios/respuesta-a-incidentes">Respuesta a incidentes</a> · llamanos al <a href="<?= e(tel_href()) ?>" data-track="phone"><?= e(cfg('phone_display')) ?></a>.</p>
    </div>
<?php endforeach; ?>
    <p class="note">Esta lista es general y defensiva. No promete que se recuperen archivos ni que se evite un daño: cada caso necesita un análisis propio.</p>
  </div>
</section>

<section class="section section--alt print-sheet" id="hoja">
  <div class="wrap narrow">
    <h2>Hoja de contactos: completala antes de necesitarla</h2>
    <p>Imprimila, completala y dejala a la vista. Cuando algo pasa, nadie tiene la cabeza para buscar teléfonos.</p>
    <p class="no-print"><button type="button" class="btn btn--ghost" id="btn-print-sheet" hidden>Imprimir la hoja de contactos</button></p>
    <div class="table-wrap">
      <table class="contact-sheet">
        <tbody>
<?php foreach (['Proveedor de IT', 'Banco: línea de fraude', 'Quien decide en la empresa', 'Segunda persona que decide', 'Aseguradora (si tenés póliza)', 'Abogado', 'Proveedor de hosting o dominio', 'Ciberseguridad.com.py'] as $row): ?>
          <tr><td><?= e($row) ?></td><td><?= $row === 'Ciberseguridad.com.py' ? e(cfg('phone_display')) : '' ?></td></tr>
<?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <p class="note">Guardá una copia impresa y otra fuera de tus sistemas: si no arrancan, no vas a poder abrirla.</p>
  </div>
</section>
<?php
page_end([
    'schema' => [webapp_ld('recursos/checklist-de-incidentes', 'Checklist de incidentes de seguridad', 'Pasos defensivos para las primeras horas de un incidente, por tipo de ataque, con hoja de contactos imprimible.')],
    'scripts' => ['/assets/js/checklist.js'],
    'service' => 'checklist-incidentes',
]);
