<?php
declare(strict_types=1);

/** Editorial relationships only; no provider availability or delivery promise. */
function buyer_journeys(): array
{
    static $data;
    return $data ??= json_decode((string) file_get_contents(__DIR__ . '/buyer-journey.json'), true, 512, JSON_THROW_ON_ERROR);
}

function orientation_service(string $slug): string
{
    if (str_starts_with($slug, 'servicios/')) return substr($slug, 10);
    if (str_starts_with($slug, 'recursos/')) {
        return match (substr($slug, 9)) {
            'preparar-hoja-contactos-incidentes' => 'preparacion-respuesta-incidentes',
            'preguntas-antes-contratar-pentest' => 'pentesting-autorizado',
            'autorizacion-alcance-pruebas-seguridad' => 'pentesting-autorizado',
            'checklist-pruebas-recuperacion-backup' => 'backup-recuperacion',
            'que-significa-certificacion-iso-27001' => 'iso-27001',
            'reportar-correo-sospechoso-seguro' => 'capacitacion-phishing',
            'practicas-minimas-ciberseguridad-pymes-paraguay' => 'evaluacion-ciberseguridad',
            default => '',
        };
    }
    return '';
}

function orientation_path(string $slug): string
{
    $service = orientation_service($slug);
    return '/encontra-un-proveedor/' . ($service !== '' ? '?servicio=' . rawurlencode($service) : '');
}

/** Insert contextual links inside the article, not in global navigation. */
function buyer_context(string $slug): string
{
    $all = buyer_journeys();
    if (str_starts_with($slug, 'servicios/') && isset($all[substr($slug, 10)])) {
        $data = $all[substr($slug, 10)];
        $out = '<section class="buyer-context"><h2>Cómo comparar una propuesta</h2><p class="eyebrow">' . e($data['goal']) . '</p>'
            . '<p>Ejemplo orientativo para conversar con el proveedor; no es un paquete disponible ni una promesa de la plataforma.</p>'
            . '<dl class="buyer-example"><div><dt>Resultado a acordar</dt><dd>' . e($data['deliverable']) . '</dd></div>'
            . '<div><dt>Cómo comprobarlo</dt><dd>' . e($data['acceptance']) . '</dd></div></dl>'
            . '<h3>Prepará la conversación</h3><ul>';
        foreach ($data['guides'] as $guide) {
            $p = site_page('recursos/' . $guide);
            $out .= '<li><a href="' . e(page_path($p['slug'])) . '">' . e($p['label']) . '</a></li>';
        }
        return $out . '</ul><p><a href="/encontra-un-proveedor/#preparar-cotizacion">Usá la ficha para comparar cotizaciones →</a></p></section>';
    }
    if (str_starts_with($slug, 'recursos/')) {
        $guide = substr($slug, 9);
        $out = '<section class="buyer-context"><h2>Servicios relacionados con esta guía</h2><p>Compará el alcance antes de pedir una cotización. La disponibilidad se confirma con cada proveedor.</p><ul>';
        foreach ($all as $service => $data) {
            if (!in_array($guide, $data['guides'], true)) continue;
            $p = site_page('servicios/' . $service);
            $out .= '<li><a href="' . e(page_path($p['slug'])) . '">' . e($p['label']) . '</a></li>';
        }
        return $out . '</ul></section>';
    }
    return '';
}
