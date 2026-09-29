<?php
declare(strict_types=1);

/**
 * Page registry: the single source for titles, descriptions, nav, sitemap and
 * breadcrumbs. SEO_ARCHITECTURE.md §4. Title <= 60, description 120-155
 * (enforced by tests/seo-check.php).
 *
 * 'wa' is the WhatsApp prefill and always names the page's service
 * (docs/CONVENTIONS.md §3).
 */

function site_pages(): array
{
    return [
        '' => [
            'title' => 'Empresa de Ciberseguridad Paraguay | Ciberseguridad.com.py',
            'desc'  => 'Seguridad informática para empresas paraguayas. Diagnóstico, respuesta a incidentes y acompañamiento continuo. Escribinos por WhatsApp.',
            'label' => 'Inicio', 'group' => 'root', 'index' => true, 'prio' => '1.0',
            'wa'    => 'Hola, quiero hablar sobre la seguridad informática de mi empresa',
        ],
        'servicios/diagnostico' => [
            'title' => 'Auditoría de Seguridad Informática para Empresas | Paraguay',
            'desc'  => 'Evaluamos la seguridad de tu empresa y te entregamos un informe con prioridades claras y precio fijo. Pedí tu diagnóstico por WhatsApp.',
            'label' => 'Diagnóstico de seguridad', 'group' => 'servicios', 'index' => true, 'prio' => '0.9',
            'wa'    => 'Hola, quiero un diagnóstico de seguridad informática para mi empresa',
        ],
        'servicios/respuesta-a-incidentes' => [
            'title' => 'Respuesta a Incidentes y Ransomware | Paraguay',
            'desc'  => '¿Te atacaron? Qué hacer ahora mismo y cómo te ayudamos a contener, investigar y recuperar lo que sea posible. Llamanos y te orientamos.',
            'label' => 'Respuesta a incidentes', 'group' => 'servicios', 'index' => true, 'prio' => '1.0',
            'wa'    => 'Hola, tuvimos un incidente de seguridad en mi empresa y necesito ayuda',
        ],
        'servicios/cuestionarios-de-proveedores' => [
            'title' => 'Cuestionarios de Seguridad para Proveedores | Paraguay',
            'desc'  => '¿Un cliente te pidió completar un cuestionario de seguridad? Te ayudamos a responderlo con evidencia y a cerrar las brechas.',
            'label' => 'Cuestionarios de proveedores', 'group' => 'servicios', 'index' => true, 'prio' => '0.9',
            'wa'    => 'Hola, un cliente nos pidió un cuestionario de seguridad y necesito ayuda para responderlo',
        ],
        'servicios/seguridad-gestionada' => [
            'title' => 'Seguridad Informática Gestionada para Empresas | Paraguay',
            'desc'  => 'Acompañamiento mensual: parches, prueba de restauración de backups, revisión de accesos y capacitación. Consultá el alcance por WhatsApp.',
            'label' => 'Seguridad gestionada', 'group' => 'servicios', 'index' => true, 'prio' => '0.8',
            'wa'    => 'Hola, quiero consultar por el acompañamiento mensual de seguridad',
        ],
        'para/clinicas' => [
            'title' => 'Seguridad Informática para Clínicas y Consultorios',
            'desc'  => 'Cuidá las historias clínicas y la continuidad de la atención. Diagnóstico de seguridad pensado para clínicas y consultorios.',
            'label' => 'Clínicas y consultorios', 'group' => 'para', 'index' => true, 'prio' => '0.7',
            'wa'    => 'Hola, tengo una clínica y quiero un diagnóstico de seguridad informática',
        ],
        'para/contadores' => [
            'title' => 'Seguridad Informática para Estudios Contables | Paraguay',
            'desc'  => 'Los datos de tus clientes son tu reputación profesional. Diagnóstico de seguridad y acompañamiento para estudios contables.',
            'label' => 'Estudios contables', 'group' => 'para', 'index' => true, 'prio' => '0.7',
            'wa'    => 'Hola, tengo un estudio contable y quiero un diagnóstico de seguridad informática',
        ],
        'para/ecommerce' => [
            'title' => 'Seguridad para Tiendas Online en Paraguay',
            'desc'  => 'Cuidá tu checkout, tu panel de administración y los datos de tus clientes. Diagnóstico de seguridad pensado para tiendas online.',
            'label' => 'Tiendas online', 'group' => 'para', 'index' => true, 'prio' => '0.7',
            'wa'    => 'Hola, tengo una tienda online y quiero un diagnóstico de seguridad',
        ],
        'para/pymes' => [
            'title' => 'Ciberseguridad para PYMES en Paraguay | Guía y Servicios',
            'desc'  => 'Qué necesita realmente una empresa pequeña o mediana, sin humo y sin gastar de más. Empezá con la autoevaluación gratuita.',
            'label' => 'PYMES', 'group' => 'para', 'index' => true, 'prio' => '0.7',
            'wa'    => 'Hola, tengo una pyme y quiero saber por dónde empezar con la seguridad informática',
        ],
        'recursos' => [
            'title' => 'Recursos Gratuitos de Seguridad Informática | Paraguay',
            'desc'  => 'Herramientas gratuitas para empresas: autoevaluación de seguridad y checklist de incidentes. Sin escanear nada ni pedirte accesos.',
            'label' => 'Recursos', 'group' => 'root', 'index' => true, 'prio' => '0.6',
            'wa'    => 'Hola, vi los recursos del sitio y quiero hablar de seguridad informática',
        ],
        'recursos/autoevaluacion' => [
            'title' => 'Autoevaluación de Seguridad Informática | Gratis, 5 minutos',
            'desc'  => 'Respondé 20 preguntas sobre tu empresa y mirá tu nivel de exposición por área. Resultado completo, sin dejar datos. No es una auditoría.',
            'label' => 'Autoevaluación', 'group' => 'recursos', 'index' => true, 'prio' => '0.7',
            'wa'    => 'Hola, hice la autoevaluación de seguridad y quiero conversar sobre el resultado',
        ],
        'recursos/checklist-de-incidentes' => [
            'title' => 'Qué Hacer si Hackean tu Empresa | Checklist Imprimible',
            'desc'  => 'Pasos defensivos para las primeras horas de un incidente, según el tipo de ataque, y una hoja de contactos para imprimir y tener a mano.',
            'label' => 'Checklist de incidentes', 'group' => 'recursos', 'index' => true, 'prio' => '0.7',
            'wa'    => 'Hola, estoy usando el checklist de incidentes y necesito ayuda',
        ],
        'nosotros' => [
            'title' => 'Quiénes Somos y Cómo Trabajamos | Ciberseguridad.com.py',
            'desc'  => 'Cómo trabajamos, qué no hacemos y por qué no publicamos nombres de clientes. Alcance por escrito, precio fijo y confidencialidad.',
            'label' => 'Nosotros', 'group' => 'root', 'index' => true, 'prio' => '0.5',
            'wa'    => 'Hola, quiero conocer más sobre cómo trabajan',
        ],
        'contacto' => [
            'title' => 'Contacto | Ciberseguridad.com.py',
            'desc'  => 'Escribinos por WhatsApp, llamanos o dejá tu consulta en el formulario. Respondemos en el día hábil. No compartas contraseñas por acá.',
            'label' => 'Contacto', 'group' => 'root', 'index' => true, 'prio' => '0.6',
            'wa'    => 'Hola, quiero hacer una consulta sobre seguridad informática',
        ],
        'gracias' => [
            'title' => 'Consulta recibida | Ciberseguridad.com.py',
            'desc'  => 'Recibimos tu consulta. Te respondemos en el día hábil, y si es urgente podés escribirnos por WhatsApp para ir más rápido.',
            'label' => 'Gracias', 'group' => 'hidden', 'index' => false, 'prio' => '0.0',
            'wa'    => 'Hola, acabo de enviar el formulario del sitio',
        ],
        'politica-de-privacidad' => [
            'title' => 'Política de Privacidad | Ciberseguridad.com.py',
            'desc'  => 'Qué datos recolectamos cuando nos escribís, para qué los usamos, quién los recibe, cuánto tiempo los guardamos y cómo pedir su borrado.',
            'label' => 'Política de privacidad', 'group' => 'legal', 'index' => true, 'prio' => '0.3',
            'wa'    => 'Hola, tengo una consulta sobre mis datos personales',
        ],
        'terminos' => [
            'title' => 'Términos de Uso | Ciberseguridad.com.py',
            'desc'  => 'Condiciones de uso del sitio y de sus herramientas gratuitas: alcance, límites de responsabilidad y qué no hacemos sin autorización.',
            'label' => 'Términos de uso', 'group' => 'legal', 'index' => true, 'prio' => '0.3',
            'wa'    => 'Hola, tengo una consulta sobre los términos del sitio',
        ],
        '404' => [
            'title' => 'Página no encontrada | Ciberseguridad.com.py',
            'desc'  => 'No encontramos esa página. Acá tenés los servicios principales de Ciberseguridad.com.py y la forma más rápida de escribirnos por WhatsApp.',
            'label' => 'No encontrada', 'group' => 'hidden', 'index' => false, 'prio' => '0.0',
            'wa'    => 'Hola, quiero hacer una consulta sobre seguridad informática',
        ],
    ];
}

function site_page(string $slug): array
{
    $pages = site_pages();
    if (!isset($pages[$slug])) {
        throw new InvalidArgumentException('Unknown page: ' . $slug);
    }
    return $pages[$slug] + ['slug' => $slug];
}

/** Path for a slug: '' => '/', 'nosotros' => '/nosotros'. */
function page_path(string $slug): string
{
    return '/' . $slug;
}
