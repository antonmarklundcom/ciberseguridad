<?php
declare(strict_types=1);

/**
 * Self-assessment content. Single source: the page renders these into the HTML
 * (with data-* attributes) and assets/js/autoevaluacion.js scores from the DOM.
 * SAFE_SECURITY_TOOL_IDEAS.md §2.1. All questions are declarative, multiple
 * choice, no free text. Nothing here contacts any host.
 *
 * Each option carries points 0..3. weight 2 = backups, MFA and BEC process.
 */

const ASSESS_DOMAINS = [
    'backups'      => 'Copias de seguridad',
    'accesos'      => 'Identidad y accesos',
    'correo'       => 'Correo y fraude',
    'dispositivos' => 'Dispositivos',
    'terceros'     => 'Terceros',
    'personas'     => 'Personas',
    'preparacion'  => 'Preparación',
];

/** What to look at first, per domain. General guidance; no outcome promised. */
const ASSESS_ADVICE = [
    'backups'      => 'Probá restaurar una copia real esta semana y verificá que exista al menos una copia que no se pueda borrar desde la red principal.',
    'accesos'      => 'Activá el segundo factor en el correo y en los accesos de administración, y revisá quién sigue teniendo acceso sin necesitarlo.',
    'correo'       => 'Definí que cualquier cambio de cuenta bancaria se confirme por otro canal, con una segunda persona, antes de pagar.',
    'dispositivos' => 'Activá las actualizaciones automáticas y revisá quién tiene permisos de administrador en las computadoras.',
    'terceros'     => 'Hacé una lista de los proveedores con acceso a tus sistemas y de qué acceso tiene cada uno.',
    'personas'     => 'Acordá con el equipo a quién avisar ante un mensaje sospechoso y hacé una charla corta sobre fraude por WhatsApp y correo.',
    'preparacion'  => 'Escribí y compartí una lista de a quién llamar si mañana no arranca ningún sistema. Podés usar la hoja de contactos del checklist.',
];

/** @return array<int,array{id:string,domain:string,weight:int,q:string,opts:array<int,array{0:int,1:string}>}> */
function assess_questions(): array
{
    $freq = static fn (string $never, string $old, string $year, string $recent): array
        => [[0, $never], [1, $old], [2, $year], [3, $recent]];

    return [
        ['id' => 'q1', 'domain' => 'backups', 'weight' => 2, 'q' => '¿Cuándo fue la última vez que restauraron una copia de seguridad para verificar que funciona?',
            'opts' => $freq('Nunca, o no lo sé', 'Hace más de un año', 'En el último año', 'En los últimos tres meses')],
        ['id' => 'q2', 'domain' => 'backups', 'weight' => 2, 'q' => '¿Existe al menos una copia que no se pueda borrar ni cifrar desde la red principal?',
            'opts' => [[0, 'No, o no lo sé'], [1, 'Hay una copia externa, pero no sé si está aislada'], [2, 'Sí, una copia fuera de la red'], [3, 'Sí, fuera de la red y con protección contra borrado']]],
        ['id' => 'q3', 'domain' => 'backups', 'weight' => 1, 'q' => '¿Saben qué sistemas y datos son críticos y que están incluidos en las copias?',
            'opts' => [[0, 'No lo hemos definido'], [1, 'Lo sabemos de forma informal'], [2, 'Está definido, pero no verificado'], [3, 'Está definido y verificado']]],

        ['id' => 'q4', 'domain' => 'accesos', 'weight' => 2, 'q' => '¿Usan segundo factor de autenticación en el correo corporativo?',
            'opts' => [[0, 'No'], [1, 'Solo algunas personas'], [2, 'La mayoría'], [3, 'Todas las cuentas']]],
        ['id' => 'q5', 'domain' => 'accesos', 'weight' => 2, 'q' => '¿Usan segundo factor en accesos de administración, banca en línea y sistemas críticos?',
            'opts' => [[0, 'No'], [1, 'En alguno de ellos'], [2, 'En la mayoría'], [3, 'En todos']]],
        ['id' => 'q6', 'domain' => 'accesos', 'weight' => 1, 'q' => 'Cuando alguien deja la empresa, ¿se dan de baja sus accesos?',
            'opts' => [[0, 'No hay un proceso'], [1, 'Se hace cuando alguien se acuerda'], [2, 'Se hace, pero no está escrito'], [3, 'Hay un proceso escrito que se cumple']]],
        ['id' => 'q7', 'domain' => 'accesos', 'weight' => 1, 'q' => '¿Cada persona usa su propia cuenta, o se comparten usuarios y contraseñas?',
            'opts' => [[0, 'Se comparten en varios sistemas'], [1, 'Se comparten en algunos'], [2, 'Casi todo es individual'], [3, 'Todo es individual y con gestor de contraseñas']]],

        ['id' => 'q8', 'domain' => 'correo', 'weight' => 2, 'q' => 'Si un proveedor les escribe pidiendo cambiar su cuenta bancaria, ¿qué proceso siguen?',
            'opts' => [[0, 'Lo cambiamos si el correo parece legítimo'], [1, 'Depende de quién lo reciba'], [2, 'Llamamos al proveedor para confirmar'], [3, 'Confirmamos por un canal conocido y lo aprueba una segunda persona']]],
        ['id' => 'q9', 'domain' => 'correo', 'weight' => 1, 'q' => '¿Tu dominio de correo tiene configurados SPF, DKIM y DMARC?',
            'opts' => [[0, 'No lo sé'], [1, 'Sé que hay alguno, no cuál'], [2, 'Sí, en modo de monitoreo'], [3, 'Sí, con política de rechazo']]],
        ['id' => 'q10', 'domain' => 'correo', 'weight' => 1, 'q' => '¿Los pagos importantes requieren la aprobación de más de una persona?',
            'opts' => [[0, 'No'], [1, 'A veces'], [2, 'Sí, por costumbre'], [3, 'Sí, es una regla escrita']]],

        ['id' => 'q11', 'domain' => 'dispositivos', 'weight' => 1, 'q' => '¿Todas las computadoras reciben actualizaciones automáticas?',
            'opts' => [[0, 'No, o no lo sé'], [1, 'Algunas'], [2, 'La mayoría'], [3, 'Todas, y lo verificamos']]],
        ['id' => 'q12', 'domain' => 'dispositivos', 'weight' => 1, 'q' => '¿Los equipos tienen protección activa y disco cifrado (sobre todo las notebooks)?',
            'opts' => [[0, 'No lo sé'], [1, 'Solo protección básica'], [2, 'Protección en todas, cifrado en algunas'], [3, 'Protección y cifrado en todas']]],
        ['id' => 'q13', 'domain' => 'dispositivos', 'weight' => 1, 'q' => '¿Cuántas personas trabajan con permisos de administrador en su computadora?',
            'opts' => [[0, 'Casi todas'], [1, 'Muchas'], [2, 'Pocas'], [3, 'Solo quien administra los sistemas']]],

        ['id' => 't1', 'domain' => 'terceros', 'weight' => 1, 'q' => '¿Saben qué proveedores tienen acceso a sus sistemas?',
            'opts' => [[0, 'No lo sabemos'], [1, 'Sabemos de algunos'], [2, 'Tenemos una lista, sin revisar'], [3, 'Tenemos una lista revisada periódicamente']]],
        ['id' => 't2', 'domain' => 'terceros', 'weight' => 1, 'q' => 'El acceso remoto de proveedores a sus sistemas, ¿está controlado?',
            'opts' => [[0, 'No lo sé'], [1, 'Comparten la misma clave'], [2, 'Cada uno tiene su acceso'], [3, 'Cada uno tiene su acceso, con segundo factor y baja al terminar']]],

        ['id' => 'p1', 'domain' => 'personas', 'weight' => 1, 'q' => '¿Cuándo fue la última capacitación sobre fraude y phishing?',
            'opts' => $freq('Nunca', 'Hace más de un año', 'En el último año', 'En los últimos seis meses')],
        ['id' => 'p2', 'domain' => 'personas', 'weight' => 1, 'q' => '¿Las personas saben a quién avisar cuando reciben un mensaje sospechoso?',
            'opts' => [[0, 'No'], [1, 'Algunas'], [2, 'La mayoría'], [3, 'Todas y lo han hecho']]],

        ['id' => 'r1', 'domain' => 'preparacion', 'weight' => 1, 'q' => '¿Existe una lista escrita de a quién llamar si mañana no arranca ningún sistema?',
            'opts' => [[0, 'No'], [1, 'Está en la cabeza de una persona'], [2, 'Existe, pero está desactualizada'], [3, 'Existe, está actualizada y se comparte']]],
        ['id' => 'r2', 'domain' => 'preparacion', 'weight' => 1, 'q' => '¿Hay un plan escrito de qué hacer y quién decide ante un incidente?',
            'opts' => [[0, 'No'], [1, 'Hay ideas generales'], [2, 'Hay un plan escrito'], [3, 'Hay un plan escrito que se ensayó']]],
        ['id' => 'r3', 'domain' => 'preparacion', 'weight' => 1, 'q' => '¿Saben cuánto tiempo podría estar la empresa sin sus sistemas antes de un daño serio?',
            'opts' => [[0, 'No lo hemos pensado'], [1, 'Tenemos una idea'], [2, 'Lo estimamos'], [3, 'Lo estimamos y planificamos en base a eso']]],
    ];
}
