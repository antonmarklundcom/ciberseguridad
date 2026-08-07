<?php
declare(strict_types=1);

/**
 * /preguntas-frecuentes — BUILD-SPEC-PAGES.md §13.
 * Carries FAQPage JSON-LD for all questions on this page. The 5 home-page
 * questions are deliberately not repeated here — duplicate FAQPage entries
 * across pages compete with each other.
 */

require_once dirname(__DIR__) . '/src/render.php';

$groups = [
    'Sobre el trabajo' => [
        ['¿En qué se diferencia una auditoría de un pentesting?', 'La auditoría revisa cómo está organizada la seguridad: accesos, respaldos, configuración, procesos. El pentesting intenta entrar de verdad, con autorización, para demostrar qué es explotable en la práctica. La auditoría cubre más superficie; el pentesting va más profundo en menos cosas. Si nunca hiciste ninguna de las dos, casi siempre conviene empezar por la auditoría.'],
        ['¿Cuánto tarda un trabajo típico?', 'Una auditoría, entre una y dos semanas de relevamiento según el tamaño. Un pentesting, entre una y tres semanas. Un trabajo de cumplimiento depende del marco y de qué documentación exista. La propuesta siempre lleva el plazo por escrito.'],
        ['¿Interrumpe la operación de la empresa?', 'Una auditoría no. Un pentesting se coordina en ventanas horarias acordadas y, si hay sistemas delicados, se prueba en ambiente de pruebas.'],
        ['¿Trabajan con nuestro proveedor de IT o lo reemplazan?', 'Trabajamos con él. Los hallazgos se entregan escritos para que su equipo los ejecute. No hacemos soporte ni administración de sistemas.'],
    ],
    'Sobre el alcance y el precio' => [
        ['¿Por qué no publican precios?', 'Porque el precio depende del tamaño y del alcance, y una cifra suelta en una tabla no te sirve para decidir. Lo que sí garantizamos es precio fijo por escrito antes de empezar. En /precios explicamos exactamente cómo se determina.'],
        ['¿La primera conversación tiene costo?', 'No, y tampoco la propuesta.'],
        ['¿Atienden fuera de Asunción?', 'Sí. La mayor parte del trabajo es remota. En Gran Asunción también vamos presencialmente cuando hace falta, y fuera del Gran Asunción lo coordinamos según el caso: escribinos y te confirmamos.'],
    ],
    'Sobre la confidencialidad' => [
        ['¿Firman acuerdo de confidencialidad?', 'Siempre, antes de empezar, aunque no lo pidas.'],
        ['¿Qué hacen con la información que recolectan?', 'Los informes se entregan cifrados por un canal acordado. Los datos del trabajo se eliminan al cierre según lo acordado por escrito, y solo conservamos lo mínimo para responder consultas durante el período de acompañamiento.'],
        ['¿Publican casos o nombres de clientes?', 'No publicamos nombres. Con permiso previo por escrito podemos compartir un caso anonimizado, y las referencias las coordinamos directamente.'],
    ],
];

$allFaqs = array_merge(...array_values($groups));

layout_open([
    'title'       => 'Preguntas frecuentes | Ciberseguridad para empresas en Paraguay',
    'description' => 'Cuánto cuesta, cuánto tarda, si interrumpe la operación, qué pasa con la confidencialidad y en qué se diferencia una auditoría de un pentesting.',
    'path'        => '/preguntas-frecuentes',
    'mode'        => 'b',
    'wa_slug'     => 'faq',
    'jsonld'      => [
        breadcrumb_jsonld([['Inicio', '/'], ['Preguntas frecuentes', '']]),
        faq_jsonld($allFaqs),
    ],
]);
?>
<main id="main">

  <section class="hero">
    <div class="wrap">
      <span class="eyebrow">PREGUNTAS FRECUENTES</span>
      <h1>Antes de escribirnos.</h1>
    </div>
  </section>

<?php foreach ($groups as $groupTitle => $faqs): ?>
  <section>
    <div class="wrap p4">
      <div class="p4-heading">
        <h2><?= htmlspecialchars($groupTitle) ?></h2>
      </div>
      <div class="faq-list p4-body">
<?php foreach ($faqs as $f): ?>
        <details>
          <summary><?= htmlspecialchars($f[0]) ?></summary>
          <p><?= htmlspecialchars($f[1]) ?></p>
        </details>
<?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endforeach; ?>

  <?php service_closing_cta('faq', 'preguntas-frecuentes'); ?>

</main>
<?php
layout_close(['mode' => 'b', 'wa_slug' => 'faq']);
