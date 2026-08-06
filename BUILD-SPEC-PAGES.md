# BUILD-SPEC-PAGES.md — ciberseguridad.com.py

Interior pages. Read `BUILD-SPEC.md` first — tokens, shell, conversion model,
form contract, image plan, placeholder list and QA gate all live there and are
not repeated here.

All copy in this file is **verbatim**. Voseo throughout. `lang="es-PY"`.

---

## 0. Shared service-page template

Every `/servicios/*` page uses this section order and these patterns, except
`/servicios/respuesta-a-incidentes`, which overrides it (§3).

| # | Section | Pattern |
|---|---|---|
| 01 | Hero — eyebrow, H1, ingress, CTAs | **P1** split 7/5 |
| 02 | La situación — the reader's problem in their words | **P2** offset stack |
| 03 | Qué incluye — the scope | **P3** staggered-weight grid |
| 04 | Qué recibís — the deliverable | **P4** editorial two-column |
| 05 | Cómo trabajamos — timeline for this service | **P5** numbered rail |
| 06 | Statement CTA | **P9** oversized statement |
| 07 | Preguntas frecuentes | **P4**, `<details>` on hairlines |
| 08 | Contacto corto | **P1** mirrored 5/7 |

Constraint check for this template: P4 at 04 and 07 are non-adjacent (P5, P9
between). One full-bleed = 06. One overlap = the `card--raised` CTA panel in 06
crossing into 07. One oversized statement = 06. Card variants: `card--accent`
×3 in 03, `card--hair` ×3 in 04, `card--ink` ×1 in 06 — three variants, none
above 4. ✓

**Every service page carries `Service` JSON-LD:**

```json
{"@context":"https://schema.org","@type":"Service",
 "serviceType":"{per page}",
 "provider":{"@type":"ProfessionalService","name":"Ciberseguridad.com.py","url":"https://ciberseguridad.com.py"},
 "areaServed":{"@type":"Country","name":"Paraguay"},
 "availableChannel":{"@type":"ServiceChannel","serviceUrl":"https://ciberseguridad.com.py/contacto"}}
```

Plus `BreadcrumbList` (`Inicio › Servicios › {página}`) and `FAQPage` from §07.
**No `priceRange`** while no prices are published.

Mode B CTA hierarchy on all of these: **"Agendá una llamada"** primary,
WhatsApp secondary. Standard closing section 08, verbatim on every service page:

> `.eyebrow` — **SIGUIENTE PASO**
> `<h2>` — Media hora para saber si esto es lo que necesitás.
> Contanos la situación. Si no somos las personas indicadas, te lo decimos en la
> primera llamada y te orientamos hacia quien sí lo sea.
> [ **Agendá una llamada** ] [ Escribinos por WhatsApp ]

---

## 1. `/servicios/auditoria-de-seguridad`

**Primary keyword:** `auditoría de seguridad informática`
**WhatsApp `{slug}`:** `auditoria` · **`source`:** `cyber:servicios/auditoria-de-seguridad`

```
Title:       Auditoría de seguridad informática para empresas | Paraguay
Description: Revisamos accesos, equipos, backups, correo, red y proveedores. Informe con hallazgos priorizados y plan de remediación. Alcance y precio fijo.
```

**01 · Hero** — img `auditoria-de-seguridad-informatica`

> `.eyebrow` — **AUDITORÍA DE SEGURIDAD**
> `<h1>` — **Auditoría de seguridad informática para tu empresa.**
> Una revisión completa de cómo está parada tu empresa, hecha desde afuera y
> con la pregunta que tu proveedor de IT no se hace: ¿por dónde entraría alguien
> hoy?
> Termina en un informe que podés llevar a una reunión de directorio y en un
> plan que tu equipo de sistemas puede ejecutar el lunes.
> [ **Agendá una llamada** ] [ Escribinos por WhatsApp ]

**02 · La situación** — P2 offset stack

> `<h2>` — Nadie miró nunca esto desde afuera.
> Tenés soporte de IT, tenés antivirus, tenés backups configurados. Y aun así,
> si alguien te preguntara hoy cuáles son los tres riesgos más grandes de tu
> empresa y en qué orden conviene resolverlos, no tendrías una respuesta
> escrita.
> Eso no es negligencia. Es que mantener los sistemas andando y evaluar cómo se
> rompen son dos trabajos distintos, y casi nadie tiene tiempo para el segundo.

**03 · Qué incluye** — P3, `card--accent` ×3 + hairline list

> `.eyebrow` — **ALCANCE**
> `<h2>` — Qué miramos, concretamente.

| Card | Título | Cuerpo |
|---|---|---|
| 1 (span-2) | **Identidades y accesos** | Quién tiene acceso a qué, qué pasa cuando alguien se va de la empresa, dónde falta segundo factor, cuántas cuentas de administrador hay realmente y cuántas se usan. Es el punto de entrada más común y casi siempre el más desordenado. |
| 2 | **Copias de seguridad** | No si existen: si se restauran. Probamos una restauración real y medimos cuánto tarda. Un backup que nunca se restauró es una hipótesis, no un respaldo. |
| 3 | **Correo y fraude de facturas** | Configuración de SPF, DKIM y DMARC, y qué tan fácil es hacerse pasar por tu dominio. El fraude de cambio de cuenta bancaria es la pérdida real más frecuente en empresas de este tamaño en Paraguay. |

Below the cards, a hairline list:

> **También revisamos:** equipos y estaciones de trabajo · segmentación de la red
> interna · proveedores y terceros con acceso a tus sistemas · exposición de
> servicios publicados a internet · preparación ante incidentes (qué pasa,
> literalmente, si mañana no arranca nada).

**04 · Qué recibís** — P4, `card--hair` ×3

> `.eyebrow` — **ENTREGABLE**
> `<h2>` — Un informe que se puede usar.

> **Informe ejecutivo** — Entre cuatro y seis páginas, sin jerga, escrito para
> alguien que decide presupuesto. Qué encontramos, qué significa para el
> negocio, qué conviene hacer primero.
>
> **Detalle técnico con hallazgos priorizados** — Cada hallazgo con su riesgo
> real, no con una etiqueta genérica de "crítico". Un hallazgo crítico en un
> sistema que nadie usa no es crítico, y lo decimos así.
>
> **Plan de remediación con responsables y plazos** — Escrito para que tu
> proveedor de IT lo ejecute sin necesitar que se lo traduzcamos. Si algo
> requiere inversión, lo separamos de lo que es solo configuración.

**05 · Cómo trabajamos**

**01 · Conversación inicial — 30 minutos, sin costo**
> Entendemos el tamaño, los sistemas y qué te preocupa.

**02 · Propuesta con alcance y precio fijo — 2 a 3 días hábiles**
> Qué se revisa, qué no, cuánto dura y cuánto cuesta.

**03 · Relevamiento — 1 a 2 semanas según el tamaño**
> Entrevistas cortas con tu gente y revisión técnica. Ocupamos poco tiempo de
> tu equipo: normalmente entre dos y cuatro horas en total.

**04 · Entrega y reunión de cierre**
> Te presentamos los hallazgos, respondemos preguntas y dejamos el plan por
> escrito. Quedamos disponibles para las dudas que aparezcan cuando empiecen a
> corregir.

**06 · Statement CTA**

> `.statement` — **Preferís enterarte vos antes que enterarte por un tercero.**
> [ **Agendá una llamada** ]

**07 · FAQ**

**¿Interrumpe la operación?**
> No. Una auditoría es revisión y entrevistas, no pruebas de ataque. Si querés
> que intentemos entrar de verdad, eso es pentesting y se contrata aparte.

**¿Cuánto tiempo le tenemos que dedicar?**
> Entre dos y cuatro horas repartidas del lado de tu equipo, casi todo en
> entrevistas cortas y en darnos accesos de solo lectura.

**¿Necesitan acceso a nuestros sistemas?**
> Accesos de solo lectura, los mínimos necesarios, documentados en la propuesta
> y revocados al terminar. No pedimos contraseñas de usuarios.

**¿Sirve para responder un cuestionario de un cliente?**
> Sirve como base, pero si eso es lo que necesitás mirá directamente
> cumplimiento, que está armado para ese caso puntual.

---

## 2. `/servicios/pentesting`

**Primary keyword:** `pentesting` · **WhatsApp `{slug}`:** `pentesting`
**`source`:** `cyber:servicios/pentesting`

```
Title:       Pentesting en Paraguay | Pruebas de penetración con autorización
Description: Pruebas de penetración sobre tu aplicación, sitio o red interna. Alcance y autorización por escrito, hallazgos con prueba de concepto y reprueba incluida.
```

**01 · Hero** — img `pentesting-pruebas-de-penetracion`

> `.eyebrow` — **PENTESTING**
> `<h1>` — **Pentesting: que alguien lo intente en serio, con tu permiso.**
> Pruebas de penetración sobre tu aplicación, tu sitio o tu red interna, con
> alcance cerrado y autorización escrita antes de tocar nada.
> Cada hallazgo llega con su prueba de concepto, su impacto explicado en
> términos de negocio, y una reprueba sin costo cuando lo corrijas.
> [ **Agendá una llamada** ] [ Escribinos por WhatsApp ]

**02 · La situación** — P2

> `<h2>` — Un escáner automático no es una prueba de penetración.
> Hay herramientas que corren solas y devuelven doscientas alertas, la mayoría
> falsas y ninguna encadenada. Sirven, pero no responden la pregunta que
> importa: ¿alguien con tiempo y ganas puede llegar hasta los datos?
> Eso requiere que una persona encadene tres cosas menores en una grande, que
> es exactamente lo que hace un atacante real y lo que ninguna herramienta hace
> sola.

**03 · Qué incluye** — P3

| Card | Título | Cuerpo |
|---|---|---|
| 1 (span-2) | **Aplicaciones web y APIs** | Autenticación y manejo de sesiones, control de acceso entre usuarios y entre empresas, inyecciones, lógica de negocio, y qué pasa cuando un usuario común pide algo que no le corresponde. |
| 2 | **Red interna** | Qué alcanza alguien que ya está adentro: un empleado, una notebook comprometida, un visitante en la red de invitados. Segmentación, movimiento lateral, escalada de privilegios. |
| 3 | **Perímetro externo** | Qué se ve de tu empresa desde internet: servicios publicados, paneles administrativos expuestos, credenciales filtradas de tu dominio en brechas públicas de terceros. |

**04 · Qué recibís** — P4

> **Informe con prueba de concepto por hallazgo** — Los pasos exactos para
> reproducirlo. Sin eso, un equipo de desarrollo no puede corregir con
> confianza y termina discutiendo si el hallazgo era real.
>
> **Impacto explicado en términos de negocio** — Qué dato queda expuesto y qué
> significa. "Un usuario cualquiera puede ver las facturas de otro cliente" es
> accionable; una etiqueta de severidad sola, no.
>
> **Reprueba incluida** — Cuando corrijas, volvemos a probar los mismos
> hallazgos y actualizamos el informe. Sin costo adicional, dentro de los 90
> días de la entrega.

**05 · Cómo trabajamos**

**01 · Alcance y autorización — antes de todo**
> Definimos exactamente qué sistemas entran, en qué ventana horaria y con qué
> límites. Firmás una autorización escrita. **Sin ese documento no empezamos**,
> y si el sistema es de un tercero necesitamos también su autorización.

**02 · Propuesta con precio fijo — 2 a 3 días hábiles**

**03 · Ejecución — 1 a 3 semanas según el alcance**
> Con un canal abierto durante toda la prueba. Si encontramos algo grave a
> mitad de camino, te avisamos ese mismo día en vez de esperar al informe.

**04 · Entrega, reunión técnica y reprueba**

**06 · Statement CTA**

> `.statement` — **Mejor que lo encuentre alguien que te lo va a contar.**
> [ **Agendá una llamada** ]

**07 · FAQ**

**¿Puede romper algo?**
> Trabajamos para que no, y acordamos de antemano qué pruebas quedan fuera. Si
> tenés un sistema delicado, lo probamos en un ambiente de pruebas o en una
> ventana horaria coordinada.

**¿Necesitan credenciales?**
> Depende del alcance. Sin credenciales vemos lo que ve un desconocido; con
> credenciales de usuario común vemos lo que puede hacer un empleado o un
> cliente, que suele ser más revelador. Lo habitual es combinar ambos.

**¿Hacen pruebas sin autorización del dueño del sistema?**
> Nunca. Si el sistema es de un proveedor, necesitamos su autorización escrita
> además de la tuya. Probar sin autorización es un delito en Paraguay bajo la
> Ley 4439/2011 y no lo hacemos bajo ninguna circunstancia.

**¿Nos entregan las herramientas o los exploits?**
> Entregamos la prueba de concepto necesaria para reproducir y corregir el
> hallazgo. No entregamos ni desarrollamos herramientas ofensivas para uso
> general.

---

## 3. `/servicios/respuesta-a-incidentes` — **MODE A, overrides §0**

**Primary keyword:** `respuesta a incidentes`
**WhatsApp `{slug}`:** `incidente` · **`source`:** `cyber:servicios/respuesta-a-incidentes`

```
Title:       Respuesta a incidentes de seguridad | Paraguay
Description: ¿Ransomware, cuenta tomada o fraude en curso? Contención, análisis, recuperación e informe de cierre. Escribinos o llamanos ahora.
```

### Hard constraints for this page only

- **The fastest page on the site.** No hero image, no scroll reveal, no motion
  of any kind, no `card-motif` images. Inline critical CSS covers the whole
  above-the-fold.
- Phone number is the largest element after the H1, as a `tel:` link.
- **The first content block is not marketing** — it is the immediate defensive
  advice. This establishes competence faster than any claim can.
- Mode A CTAs: WhatsApp and `tel:` co-primary, equal weight, side by side.
- Sticky mobile bar: WhatsApp 50% / Llamar 50%, background `--danger` `#B3261E`.
- `--danger` is used on this page and nowhere else on the site.
- Section pattern list: 01 P1 · 02 P3 (the four steps) · 03 P4 · 04 P5 · 05 P4 ·
  06 P1 mirrored. No P9 statement section — this page does not do expensive
  moments.

**01 · Hero**

> `.eyebrow` — **RESPUESTA A INCIDENTES**
> `<h1>` — **¿Tenés un incidente en curso?**
>
> [ **Escribinos por WhatsApp** ] [ **+595 995 628862** ]
>
> **Si sospechás que tu correo o tu teléfono están comprometidos, llamanos
> desde otro dispositivo.**
>
> `small` — ⚠️ Atendemos incidentes las 24 horas, todos los días.
> ⚠️ *(If 24/7 is not literally true, replace with: «Respondemos en horario
> laboral y devolvemos las llamadas fuera de horario.» — see `BUILD-SPEC.md` §12.)*

**02 · Qué hacer ahora mismo** — P3, four `card--accent`

> `<h2>` — Qué hacer ahora mismo, antes de que lleguemos.

| # | Título | Cuerpo |
|---|---|---|
| 1 | **Desconectá de la red, no apagues** | Sacá el cable de red o el wifi de los equipos afectados, pero **no los apagues**. Apagar borra evidencia que está solo en memoria y que sirve para entender por dónde entraron. |
| 2 | **No borres nada** | Ni archivos raros, ni correos, ni registros, ni la nota del atacante. Aunque moleste verlo. Todo eso es lo que después permite reconstruir qué pasó y responderle al cliente que pregunta. |
| 3 | **No pagues todavía** | Pagar no garantiza recuperar los datos, y hay decisiones legales y de seguro que conviene tomar informado y no a las tres de la mañana. Hablemos primero. |
| 4 | **Anotá lo que viste y cuándo** | Qué apareció en pantalla, a qué hora, quién lo notó primero, qué se hizo después. Escribilo en papel o en un teléfono que no esté involucrado. Esa línea de tiempo vale muchísimo. |

**03 · Qué hacemos** — P4

> `.eyebrow` — **EL TRABAJO**
> `<h2>` — Contener primero, entender después, reconstruir al final.

> **Contención** — Cortar el acceso del atacante y frenar la propagación.
> Aislamiento de equipos, corte de sesiones activas, rotación de credenciales
> y cierre de las vías de entrada que ya identificamos.
>
> **Análisis** — Por dónde entraron, hasta dónde llegaron, qué datos tocaron y
> desde cuándo estaban adentro. Esa última pregunta es casi siempre la más
> incómoda y la más importante.
>
> **Recuperación** — Restauración ordenada y verificada, en un orden que no
> vuelva a exponer lo mismo. Restaurar rápido sobre una vulnerabilidad abierta
> es cómo se sufre el mismo ataque dos veces en una semana.
>
> **Cierre** — Informe con la línea de tiempo, el alcance, qué se hizo y qué
> queda por hacer. Sirve para el seguro, para el cliente que pregunta y para
> la decisión de si corresponde notificar.

**04 · Las primeras 48 horas** — P5 numbered rail

**Primeras 2 horas · Contacto y contención inicial**
> Entendemos qué está pasando, te damos instrucciones concretas por teléfono
> mientras nos organizamos, y frenamos lo que se pueda frenar de inmediato.

**Primeras 24 horas · Alcance**
> Determinamos qué sistemas y qué datos están involucrados, y si el atacante
> sigue adentro.

**48 horas · Plan de recuperación**
> Un plan escrito con el orden de restauración y qué hay que corregir antes de
> volver a poner cada cosa en línea.

**Después · Cierre y endurecimiento**
> Informe final y las correcciones que evitan la repetición. Muchos incidentes
> son el segundo ataque por la misma puerta.

**05 · Después del incidente** — P4

> `<h2>` — Lo que sigue.
> Cuando la urgencia baja, queda la parte que evita la próxima: cerrar la vía
> de entrada, revisar si esa misma debilidad existe en otro lado, y dejar por
> escrito qué hacer si vuelve a pasar.
> Eso normalmente continúa como una auditoría de seguridad, y si ya trabajamos
> juntos en el incidente descontamos el relevamiento que ya hicimos.

**06 · Contacto** — P1 mirrored, Mode A CTAs repeated.

**FAQ** — none on this page. A person in a crisis does not read an accordion.
`FAQPage` schema is omitted here.

---

## 4. `/servicios/cumplimiento`

**Primary keyword:** `iso 27001 paraguay`
**WhatsApp `{slug}`:** `cumplimiento` · **`source`:** `cyber:servicios/cumplimiento`

```
Title:       Cumplimiento en seguridad de la información | ISO 27001 y cuestionarios | Paraguay
Description: Análisis de brechas contra el marco que te piden, plan de remediación, carpeta de evidencias y acompañamiento en cuestionarios de clientes y Ley 6534/2020.
```

**01 · Hero** — img `cumplimiento-y-cuestionarios-de-seguridad`

> `.eyebrow` — **CUMPLIMIENTO**
> `<h1>` — **Cumplimiento en seguridad: que te alcance el sí.**
> Un cliente, un banco, una casa matriz o un seguro te está pidiendo demostrar
> controles de seguridad, y no alcanza con decir que los tenés: hay que
> mostrarlos.
> Hacemos el análisis de brechas contra el marco que te están pidiendo, el plan
> para cerrarlas y la carpeta de evidencias que respalda cada respuesta.
> [ **Agendá una llamada** ] [ Escribinos por WhatsApp ]

**02 · La situación** — P2

> `<h2>` — Te llegó una planilla con doscientas preguntas.
> Y una fecha límite. Y varias de esas preguntas usan términos que nadie en la
> empresa había leído antes.
> Lo que casi todos hacen primero es tratar de contestarla rápido para sacársela
> de encima, y ahí aparecen los dos errores caros: responder que sí a algo que
> no se tiene, o responder que no y suponer que ahí se terminó la conversación.

**03 · Qué incluye** — P3

| Card | Título | Cuerpo |
|---|---|---|
| 1 (span-2) | **Análisis de brechas contra el marco que te piden** | ISO/IEC 27001, el cuestionario propio del cliente, los requisitos de un banco o lo que exija tu casa matriz. Comparamos control por control lo que la empresa tiene hoy contra lo que se está pidiendo, y marcamos dónde estás parado en cada punto. |
| 2 | **Carpeta de evidencias** | Políticas, registros, capturas y procedimientos que respaldan cada respuesta. Sin evidencia, un "sí" en una planilla es una afirmación que la primera revisión seria desarma. |
| 3 | **Ley 6534/2020 de protección de datos** | Qué significa en la práctica para una empresa que guarda datos de clientes o pacientes en Paraguay, y qué conviene tener documentado. |

**04 · Qué recibís** — P4

> **La planilla completada, con su respaldo** — Cada respuesta con la evidencia
> que la sostiene y con la referencia a dónde está guardada.
>
> **Plan de remediación con plazos** — Para todo lo que hoy es un no. Con
> esfuerzo estimado y orden sugerido, separando lo que se resuelve configurando
> de lo que requiere inversión.
>
> **Acompañamiento en la ronda de repreguntas** — Casi siempre hay una segunda
> vuelta con aclaraciones. Es donde se cae la mitad de los procesos y donde más
> sirve tener a alguien que ya vio veinte de estas.

**05 · Cómo trabajamos** — standard three steps, plus:

**04 · Ronda de repreguntas**
> Cuando el cliente o el banco vuelve con aclaraciones, las respondemos con vos.
> Está incluido: no es un trabajo aparte.

**06 · Statement CTA**

> `.statement` — **Un «no» documentado con un plan casi nunca te descalifica. Un «sí» sin respaldo, sí.**
> Esta es la parte que casi nadie sabe, y es la que más cambia el resultado.
> [ **Agendá una llamada** ]

**07 · FAQ**

**¿Ustedes certifican ISO 27001?**
> No, y desconfiá de quien te diga que sí: certificar es atribución exclusiva de
> un organismo de certificación acreditado, y quien te prepara no puede
> certificarte. Nosotros te preparamos para esa auditoría y te acompañamos
> durante el proceso.

**¿Qué pasa si la respuesta a una pregunta es «no»?**
> Se responde que no, con un plan de remediación fechado al lado. La mayoría de
> los programas de proveedores acepta una brecha conocida con un plan creíble;
> lo que no aceptan es descubrir después que la respuesta era falsa. Ahí no
> perdés el contrato: perdés la relación.

**Tenemos poco tiempo. ¿Se puede en dos semanas?**
> A veces sí, según el tamaño y qué documentación exista. Decinos la fecha
> límite en la primera llamada y te decimos con franqueza si llegamos.

**¿Esto es lo mismo que una auditoría de seguridad?**
> No. La auditoría responde «cómo estamos». Cumplimiento responde «cómo
> demostramos que estamos, en el formato que nos están pidiendo». Muchas veces
> conviene la auditoría primero, y te lo decimos si es tu caso.

---

## 5. `/servicios/capacitacion`

**Primary keyword:** `capacitación en ciberseguridad`
**WhatsApp `{slug}`:** `capacitacion` · **`source`:** `cyber:servicios/capacitacion`

```
Title:       Capacitación en ciberseguridad para empresas | Paraguay
Description: Formación práctica para el equipo que toca los datos: fraude de facturas, phishing, cuentas de la empresa y WhatsApp. Presencial en Gran Asunción o remoto.
```

**01 · Hero** — img `capacitacion-en-ciberseguridad-para-empresas`

> `.eyebrow` — **CAPACITACIÓN**
> `<h1>` — **Capacitación en ciberseguridad para tu equipo.**
> No una charla genérica sobre contraseñas. Formación sobre los engaños que
> están llegando ahora mismo a empresas paraguayas, con ejemplos reales del
> rubro de quien escucha.
> Presencial en Gran Asunción o remoto, en sesiones de 90 minutos que la gente
> puede tomar sin frenar el día entero.
> [ **Agendá una llamada** ] [ Escribinos por WhatsApp ]

**02 · La situación** — P2

> `<h2>` — La mayoría de las pérdidas no empiezan con una vulnerabilidad técnica.
> Empiezan con un correo bien escrito que llega en un momento ocupado, y con
> alguien de administración que hace exactamente su trabajo: pagar una factura.
> Ese caso no lo resuelve un firewall. Lo resuelve que la persona sepa que ese
> pedido existe, que sepa cómo se ve, y que tenga permiso explícito de la
> empresa para frenar y verificar sin sentir que está molestando.

**03 · Qué incluye** — P3

| Card | Título | Cuerpo |
|---|---|---|
| 1 (span-2) | **Fraude de cambio de cuenta bancaria** | El más caro y el más frecuente en empresas paraguayas de este tamaño. Cómo llega, por qué es convincente, y el procedimiento de verificación que lo corta: llamar al número que ya tenías, nunca al que viene en el correo. |
| 2 | **Phishing y cuentas tomadas** | Cómo reconocer un pedido de credenciales, qué hacer cuando ya se hizo clic, y por qué el segundo factor es la diferencia entre un susto y un incidente. Incluye WhatsApp, que es donde más pasa acá. |
| 3 | **Higiene de cuentas de la empresa** | Gestores de contraseñas, segundo factor, qué pasa con los accesos cuando alguien se va, y por qué la cuenta compartida de administración es un problema de todos. |

Below the cards:

> **Formatos:** sesión general para todo el personal (90 minutos) · sesión
> específica para administración y finanzas, que es donde pega el fraude de
> facturas (90 minutos) · sesión para dirección sobre decisiones y presupuesto
> (60 minutos).

**04 · Qué recibís** — P4

> **Material de referencia en español** — Una guía corta que queda en la
> empresa, para quien entre después de la capacitación.
>
> **Procedimiento de verificación de pagos por escrito** — El entregable más
> útil de todos: un procedimiento de una carilla, aprobado por la dirección, que
> le da a la gente de administración permiso explícito para frenar un pago y
> verificarlo.
>
> **Simulación de phishing, opcional** — Un envío controlado y acordado con la
> dirección, con el resultado agregado. **Sin exponer ni sancionar a nadie
> individualmente** — si se usa para señalar personas, la próxima vez nadie
> reporta nada y estás peor que antes.

**05 · Cómo trabajamos**

**01 · Conversación inicial — 30 minutos, sin costo**
> Qué rubro, cuánta gente, qué pasó antes si pasó algo.

**02 · Adaptación del contenido**
> Ajustamos los ejemplos al rubro y a los sistemas que la empresa usa de verdad.

**03 · Las sesiones**
> Presencial en Gran Asunción o remoto, en los horarios que menos molesten.

**04 · Material y procedimiento entregados**

**06 · Statement CTA**

> `.statement` — **Tu gente no es el eslabón débil. Es el único que puede frenar el pago.**
> [ **Agendá una llamada** ]

**07 · FAQ**

**¿Cuánta gente puede participar?**
> Hasta 25 personas por sesión para que sea conversada. Si son más, hacemos
> varias tandas.

**¿Es presencial o remoto?**
> Las dos. Presencial funciona mejor y en Gran Asunción es lo habitual; remoto
> permite juntar sucursales.

**¿Sirve para cumplir con un requisito de un cliente?**
> Sí. Muchos cuestionarios de proveedores piden capacitación periódica
> documentada, y dejamos constancia de asistencia y contenido para esa carpeta.

**¿Hacen simulación de phishing sin avisarle a nadie?**
> A la gente no, a la dirección siempre. Y el resultado se informa agregado,
> nunca por persona.

---

## 6. `/para/clinicas`

**Primary keyword:** `seguridad informática para clínicas`
**WhatsApp `{slug}`:** `clinicas` · **`source`:** `cyber:para/clinicas`

```
Title:       Seguridad informática para clínicas y consultorios | Paraguay
Description: Historias clínicas, agenda y facturación en la misma red que el equipamiento de imágenes. Auditoría, respuesta a incidentes y cumplimiento para el sector salud.
```

Pattern list: 01 P1 · 02 P2 · 03 P4 · 04 P3 · 05 P9 · 06 P1 mirrored.

**01 · Hero**

> `.eyebrow` — **PARA CLÍNICAS Y CONSULTORIOS**
> `<h1>` — **Seguridad informática para clínicas y consultorios.**
> Cuando una clínica se detiene, no se detiene un sistema: se detiene la
> atención. Los pacientes ya están en la sala y la agenda del día no espera a
> que se resuelva un problema informático.
> [ **Agendá una llamada** ] [ Escribinos por WhatsApp ]

**02 · La amenaza real** — P2

> `<h2>` — El problema no es solo el dato: es la continuidad.
> El ransomware en salud es frecuente en la región por una razón simple y poco
> agradable: es el rubro donde más probable es que se pague, porque la
> alternativa es suspender atención.
> Y hay una particularidad técnica que hace a las clínicas más vulnerables que
> a una oficina del mismo tamaño: el equipamiento médico. Un equipo de imágenes
> corre con el software con el que vino, suele estar fuera de garantía de
> actualización, y casi siempre está en la misma red plana que la computadora
> de recepción. No se puede simplemente actualizar. **Se puede separar**, y eso
> es la mitad del trabajo.

**03 · Qué está en juego** — P4

> **Historias clínicas** — Es la categoría de dato más sensible que existe y no
> se puede cambiar como se cambia una tarjeta. Una filtración no se revierte.
>
> **Agenda y facturación** — Si se caen, la clínica no factura ni atiende. La
> pérdida no es el rescate: es el día perdido, y el segundo día.
>
> **Equipamiento de imágenes y laboratorio** — Sistemas viejos que no se pueden
> actualizar y que suelen estar donde no deberían estar dentro de la red.
>
> **La obligación de confidencialidad** — El deber sobre los datos del paciente
> no desaparece porque el problema haya sido informático. Sigue siendo tuyo.

**04 · Qué hacemos en una clínica** — P3

| Card | Título | Cuerpo |
|---|---|---|
| 1 (span-2) | **Separar la red** | El equipamiento médico y los sistemas administrativos dejan de verse entre sí. Es la medida con mejor relación entre costo y efecto en este rubro, y casi nunca está hecha. |
| 2 | **Probar la restauración** | No revisamos si el backup existe: restauramos una historia clínica de prueba y medimos cuánto tarda. Ese número es tu tiempo real de recuperación, y suele sorprender. |
| 3 | **Accesos por rol** | Recepción, enfermería, profesionales y administración no necesitan ver lo mismo. Y cuando alguien deja la clínica, el acceso se va con la persona. |

**05 · Statement CTA**

> `.statement` — **La agenda de mañana no espera a que se resuelva.**
> [ **Agendá una llamada** ]

**06 · Contacto corto** — standard §0 block.

---

## 7. `/para/contadores`

**Primary keyword:** `seguridad informática para estudios contables`
**WhatsApp `{slug}`:** `contadores` · **`source`:** `cyber:para/contadores`

```
Title:       Seguridad informática para estudios contables | Paraguay
Description: Concentrás los datos financieros de decenas de clientes. Protección de accesos, credenciales de la SET, correo y respaldo para estudios contables en Paraguay.
```

**01 · Hero**

> `.eyebrow` — **PARA ESTUDIOS CONTABLES**
> `<h1>` — **Seguridad informática para estudios contables.**
> Guardás en una sola oficina los datos financieros de decenas de empresas.
> Para un atacante, eso no es un estudio contable: es el atajo a todos tus
> clientes al mismo tiempo.
> [ **Agendá una llamada** ] [ Escribinos por WhatsApp ]

**02 · La amenaza real** — P2

> `<h2>` — Sos un objetivo concentrado, y por eso valés más.
> Atacar a cincuenta empresas cuesta cincuenta veces más que atacar a quien
> tiene acceso a las cincuenta. Los estudios contables son, por diseño, ese
> punto de concentración.
> Se suma la estacionalidad: en época de cierres y vencimientos llega mucho
> correo con adjuntos, de remitentes que cambian, con urgencia real, y a nadie
> le sobra tiempo para dudar de un archivo. Es la ventana perfecta y los
> atacantes la conocen igual que vos.

**03 · Qué está en juego** — P4

> **La credencial del portal de la SET** — Un único punto de falla con
> consecuencias inmediatas y visibles para tus clientes. Merece segundo factor y
> merece no estar anotada en un archivo compartido.
>
> **Los datos financieros de tus clientes** — Facturación, nómina, saldos,
> estructura societaria. Información que sirve tanto para el fraude directo como
> para preparar un engaño creíble contra tu cliente.
>
> **Tu responsabilidad profesional** — Si los datos de un cliente se filtran
> desde tu estudio, el problema no es técnico. Es de tu relación con ese cliente
> y de tu reputación en un mercado donde todos se conocen.
>
> **La continuidad en fecha de vencimiento** — Un incidente en la semana
> equivocada no es un inconveniente: es un incumplimiento en cadena.

**04 · Qué hacemos en un estudio** — P3

| Card | Título | Cuerpo |
|---|---|---|
| 1 (span-2) | **Ordenar credenciales y accesos** | Gestor de contraseñas, segundo factor en todo lo que lo permita, y el fin de la credencial compartida por WhatsApp. Es poco glamoroso y es lo que más reduce el riesgo real en este rubro. |
| 2 | **Endurecer el correo** | SPF, DKIM y DMARC bien configurados para que no sea trivial hacerse pasar por tu dominio ante tus propios clientes. |
| 3 | **Respaldo probado y separado** | Copias que un ransomware no pueda alcanzar desde la red, con una restauración probada de verdad y no supuesta. |

**05 · Statement CTA**

> `.statement` — **Tus clientes te confiaron sus números. Esa confianza es el producto.**
> [ **Agendá una llamada** ]

**06 · Contacto corto** — standard.

---

## 8. `/para/ecommerce`

**Primary keyword:** `seguridad para tiendas online`
**WhatsApp `{slug}`:** `ecommerce` · **`source`:** `cyber:para/ecommerce`

```
Title:       Seguridad para tiendas online y ecommerce | Paraguay
Description: Checkout, panel de administración y datos de clientes. Pentesting, auditoría y respuesta a incidentes para tiendas online paraguayas.
```

**01 · Hero**

> `.eyebrow` — **PARA TIENDAS ONLINE**
> `<h1>` — **Seguridad para tiendas online.**
> Tu tienda tiene que estar abierta y tiene que parecer confiable en el momento
> exacto en que alguien va a poner los datos de su tarjeta. Las dos cosas se
> pierden juntas y se recuperan por separado.
> [ **Agendá una llamada** ] [ Escribinos por WhatsApp ]

**02 · La amenaza real** — P2

> `<h2>` — Lo que más duele no se nota.
> Una tienda caída se ve enseguida y se arregla. Un código malicioso inyectado
> en la página de pago no se ve: la tienda funciona normal, las ventas entran,
> y en paralelo los datos de cada tarjeta se copian a un servidor ajeno.
> Ese tipo de ataque suele descubrirse meses después, y casi nunca lo descubre
> el dueño de la tienda: lo descubre el banco o la procesadora, llamando. Para
> ese momento el problema ya no es técnico, es contractual.

**03 · Qué está en juego** — P4

> **El checkout** — Cada script de terceros que corre en la página de pago
> (chat, analítica, remarketing) es una vía de entrada más, y suele estar ahí
> porque alguien lo agregó rápido hace dos años.
>
> **El panel de administración** — Si alguien entra ahí, puede cambiar precios,
> ver pedidos, exportar clientes o modificar el checkout sin tocar el servidor.
>
> **Los datos de tus clientes** — Nombres, direcciones, teléfonos, historial de
> compras. Sirven para fraude dirigido contra tus propios compradores, usando tu
> nombre.
>
> **Tu relación con la procesadora de pagos** — Un incidente de datos de tarjeta
> pone en riesgo la posibilidad de seguir cobrando, que es la parte que
> realmente cierra tiendas.

**04 · Qué hacemos en una tienda** — P3

| Card | Título | Cuerpo |
|---|---|---|
| 1 (span-2) | **Pentesting sobre el checkout y el panel** | Con autorización escrita y en ambiente coordinado. Control de acceso entre usuarios, manipulación de precios y cantidades, y qué puede hacer un cliente común que no debería poder hacer. |
| 2 | **Inventario de scripts de terceros** | Qué se está cargando en la página de pago, quién lo puso, si sigue haciendo falta. Casi siempre sobra algo, y lo que sobra es riesgo gratis. |
| 3 | **Accesos del panel y de los proveedores** | Segundo factor obligatorio, cuentas nominales en vez de una compartida, y revocación cuando termina la relación con una agencia o un desarrollador. |

**05 · Statement CTA**

> `.statement` — **La tienda abierta es la mitad. La otra mitad es que el pago siga siendo confiable.**
> [ **Agendá una llamada** ]

**06 · Contacto corto** — standard.

---

## 9. `/para/pymes` — router page

**Primary keyword:** `ciberseguridad para pymes`
**WhatsApp `{slug}`:** `pymes` · **`source`:** `cyber:para/pymes`

```
Title:       Ciberseguridad para PYMES en Paraguay
Description: Tenés soporte de IT pero no función de seguridad. Por dónde empezar, qué se resuelve configurando y qué requiere inversión. Guía honesta y sin humo.
```

This page routes. **It does not try to do everything** — that is its whole job.

Pattern list: 01 P1 · 02 P4 · 03 P3 (router) · 04 P5 · 05 P9 · 06 P1 mirrored.

**01 · Hero**

> `.eyebrow` — **PARA PYMES**
> `<h1>` — **Ciberseguridad para PYMES paraguayas.**
> Tenés entre quince y doscientos empleados, tenés alguien que se ocupa de la
> informática, y no tenés a nadie cuyo trabajo sea la seguridad. Eso no es una
> falla de gestión: es lo normal a este tamaño.
> [ **Agendá una llamada** ] [ Escribinos por WhatsApp ]

**02 · Soporte de IT y seguridad no son lo mismo** — P4

> `<h2>` — Son dos trabajos distintos.
> Tu proveedor de IT mantiene los sistemas funcionando. Se lo mide por eso, y
> normalmente lo hace bien. La seguridad se mide por lo contrario: por cómo se
> rompe algo que hoy funciona, y qué pasa después.
> Un proveedor de IT excelente puede tener la red entera en un solo segmento y
> los backups en un disco que el ransomware alcanza, y no es un descuido: es
> que nadie le pidió nunca ese trabajo, ni se lo pagó.
> No venimos a reemplazar a tu proveedor. Los hallazgos se los entregamos a
> ellos, escritos para que los puedan ejecutar.

**03 · ¿Por dónde empezar?** — P3 router, `card--accent` ×3

| Card | Título | Cuerpo | CTA |
|---|---|---|---|
| 1 | **Si no pasó nada todavía** | Empezá por saber cómo estás parado. Un diagnóstico ordenado vale más que comprar herramientas sueltas por recomendación. | Auditoría de seguridad → |
| 2 | **Si un cliente te está pidiendo algo** | Necesitás demostrar controles en un formato específico y con fecha límite. Es un trabajo distinto al diagnóstico. | Cumplimiento → |
| 3 | **Si ya pasó algo** | No leas más: escribinos o llamanos. | Respuesta a incidentes → |

**04 · Lo que sirve en casi todas las PYMES** — P5 numbered rail

> `<h2>` — Cuatro cosas que sirven casi siempre.
> Ninguna es cara. Ninguna es glamorosa. Juntas eliminan la mayoría de los
> incidentes que vemos en empresas de este tamaño.

**01 · Segundo factor en el correo y en los sistemas críticos**
> La medida individual con mejor relación entre esfuerzo y resultado que existe.

**02 · Copias de seguridad que se restauran de verdad**
> Probadas, no supuestas, y donde el ransomware no llegue desde la red.

**03 · Un procedimiento escrito para verificar cambios de cuenta bancaria**
> Una carilla firmada por la dirección. Corta el fraude más caro del rubro.

**04 · Quitar accesos cuando alguien se va**
> Sencillo de decir, casi nunca hecho de forma completa.

**05 · Statement CTA**

> `.statement` — **No hace falta hacer todo. Hace falta saber qué hacer primero.**
> [ **Agendá una llamada** ]

**06 · Contacto corto** — standard.

---

## 10. `/precios` — «Cómo cotizamos»

**Primary keyword:** `cuánto cuesta una auditoría de seguridad`
**WhatsApp `{slug}`:** `precios` · **`source`:** `cyber:precios`

⚠️ Ships with **no published amounts** — see `BUILD-SPEC.md` §12 item 5. This
page is a scoping and billing explainer, and it is deliberately more useful than
a price list. If bands are later approved, they insert as a table after §03; no
other change is needed.

```
Title:       Cómo cotizamos | Alcance y precio fijo por escrito
Description: Cómo se determina el precio de una auditoría, un pentesting o un trabajo de cumplimiento, y por qué trabajamos con precio fijo en vez de hora abierta.
```

Pattern list: 01 P1 · 02 P4 · 03 P3 · 04 P5 · 05 P9 · 06 P1 mirrored.

**01 · Hero**

> `.eyebrow` — **CÓMO COTIZAMOS**
> `<h1>` — **Alcance y precio fijo, por escrito, antes de empezar.**
> No publicamos una lista de precios porque una auditoría de una empresa de
> veinte personas y una de doscientas no se parecen en nada, y un número
> inventado en una tabla no te ayuda a decidir.
> Lo que sí podemos decirte de antemano es exactamente cómo se determina, para
> que sepas qué esperar antes de la primera llamada.

**02 · Por qué precio fijo y no por hora** — P4

> `<h2>` — La hora abierta te traslada a vos todo el riesgo.
> Si facturamos por hora, cada complicación que aparece la pagás vos, y no
> tenés forma de saber al firmar cuánto va a terminar costando. Cotizando
> cerrado, ese riesgo es nuestro, que es de quien tiene la experiencia para
> estimarlo.
> También hace la conversación más honesta: si a mitad del trabajo aparece algo
> que está fuera del alcance, te lo decimos y decidís vos si lo agregamos, en
> vez de descubrirlo en la factura.

**03 · Qué determina el precio** — P3

| Card | Título | Cuerpo |
|---|---|---|
| 1 (span-2) | **El tamaño y la cantidad de sistemas** | Cuántas personas, cuántas sedes, cuántos sistemas propios, si hay desarrollo interno. Es lo que más pesa, y se puede estimar bastante bien en la primera conversación. |
| 2 | **La profundidad** | Un diagnóstico de superficie y una revisión a fondo con pruebas técnicas son trabajos distintos. Muchas veces conviene empezar por el primero. |
| 3 | **El plazo** | Si hay una fecha límite externa que obliga a comprimir el trabajo, eso tiene un costo y te lo decimos de frente en vez de esconderlo. |

**04 · Qué está siempre incluido** — P5 rail

**01 · La conversación inicial de 30 minutos**
> Sin costo, sin compromiso, y sin que termine en una propuesta si vemos que no
> hace falta.

**02 · La propuesta**
> Escrita, con alcance explícito, exclusiones explícitas, plazo y precio. No se
> cobra.

**03 · La reunión de cierre**
> Presentamos los hallazgos y respondemos preguntas del equipo.

**04 · Las dudas posteriores**
> Durante los 90 días siguientes a la entrega, las consultas sobre el informe
> están incluidas. No te vamos a facturar por explicar lo que escribimos.

**05 · Statement CTA**

> `.statement` — **Vas a saber cuánto cuesta antes de decidir. Esa es la idea.**
> [ **Agendá una llamada** ]

**06 · Contacto corto** — standard.

---

## 11. `/nosotros`

**WhatsApp `{slug}`:** `nosotros` · **`source`:** `cyber:nosotros`

⚠️ Ships in the **unnamed form below**, which is complete and honest as written —
no `[COMPLETAR]`, no empty team grid, no generated portrait. When a real name and
a real photograph are supplied, the named block in §11.1 inserts after section 01
and nothing else changes.

```
Title:       Quiénes somos | Ciberseguridad.com.py
Description: Cómo trabajamos, qué no hacemos y por qué no publicamos nombres de clientes. Consultoría de seguridad informática para empresas en Paraguay.
```

Pattern list: 01 P1 · 02 P4 · 03 P3 · 04 P4 · 05 P9 · 06 P1 mirrored.

**01 · Hero**

> `.eyebrow` — **QUIÉNES SOMOS**
> `<h1>` — **Una consultora de seguridad, no una agencia de marketing.**
> Trabajamos con empresas paraguayas de entre quince y doscientas cincuenta
> personas que guardan datos que le importan a alguien más, y que tienen soporte
> informático pero no una función de seguridad.

**02 · Cómo trabajamos** — P4

> `<h2>` — Sin miedo como argumento de venta.
> En este rubro es fácil vender asustando, y es la forma más rápida de que un
> cliente compre algo que no necesita. No usamos estadísticas sin fuente, no
> hablamos de empresas que cierran a los seis meses, y no prometemos seguridad:
> nadie puede.
> Lo que sí prometemos es concreto: alcance cerrado, precio fijo por escrito, un
> informe que se entiende, y decirte cuando algo no hace falta. Varias veces la
> primera llamada termina con «esto no lo necesitás todavía», y esa llamada es
> tan útil como la que termina en una propuesta.

**03 · Lo que no hacemos** — P3, `card--accent` ×3

| Card | Título | Cuerpo |
|---|---|---|
| 1 (span-2) | **No hacemos servicios ofensivos** | Nada de desarrollo de herramientas de ataque, ni acceso a sistemas de terceros, ni recuperación de cuentas ajenas, ni «investigación» sobre personas. Si nos lo pedís, la respuesta es no y ahí termina la conversación. |
| 2 | **No escaneamos sin autorización** | Ninguna prueba se ejecuta sin autorización escrita del dueño del sistema. Si el sistema es de un proveedor, también necesitamos la suya. En Paraguay eso es delito bajo la Ley 4439/2011. |
| 3 | **No publicamos nombres de clientes** | Quién contrató seguridad y cuándo es información sensible, y publicarla es contradecir el servicio. Por eso no vas a ver logos acá. Si necesitás referencias, las coordinamos con permiso previo. |

**04 · Confidencialidad** — P4

> `<h2>` — Qué pasa con lo que vemos.
> En un trabajo de seguridad vemos cómo funciona la empresa por dentro, y a
> veces vemos cosas incómodas. Firmamos acuerdo de confidencialidad antes de
> empezar, siempre, incluso cuando el cliente no lo pide.
> Los informes se entregan cifrados y por un canal acordado, no por correo
> común. Los datos del trabajo se eliminan al cierre según lo que hayamos
> acordado por escrito, y la única copia que conservamos es la mínima que
> necesitamos para responder consultas durante el período de acompañamiento.

**05 · Statement CTA**

> `.statement` — **Preferimos una conversación honesta antes que un contrato rápido.**
> [ **Agendá una llamada** ]

**06 · Contacto corto** — standard.

### 11.1 Named-practitioner block — insert when supplied

⚠️ Do **not** build this until a real name, real background and a **real
photograph** exist. Never a generated face. Never an invented certification.

> `.eyebrow` — **QUIÉN ESTÁ DETRÁS**
> `<h2>` — {Nombre completo}
> `card--raised` panel, P1 split with the real photograph 5 cols right.
> {2–3 párrafos de trayectoria real}
> {Certificaciones realmente obtenidas, con año — o el bloque se omite entero}

---

## 12. `/contacto`

**WhatsApp `{slug}`:** `contacto` · **`source`:** `cyber:contacto`

```
Title:       Contacto | Ciberseguridad.com.py
Description: Escribinos por WhatsApp, llamanos o agendá una llamada de 30 minutos sin costo. Respondemos en el día hábil.
```

Pattern list: 01 P1 (channels 5 / form 7) · 02 P8 ribbon · 03 P4.

**01 · Contacto**

Left column — identical to home §12 left, plus:

> **Horarios de atención** — Lunes a viernes, de 8:00 a 18:00.
> ⚠️ Incidentes en curso: ver `/servicios/respuesta-a-incidentes`.

Right column — the form per `BUILD-SPEC.md` §10, with `#agendar` anchor.
Intro line above the fields:

> Contanos brevemente tu situación y te respondemos en el día hábil. Si preferís
> hablar antes de escribir, escribinos por WhatsApp.

Line beside the submit button (required — states who receives the data):

> Los datos que envíes los recibimos únicamente nosotros y los usamos para
> responder tu consulta. No los compartimos con terceros. Leé la política de
> privacidad.

**02 · Franja** — P8 ribbon, `--ink`, `.grain`:

> **Respondemos en el día hábil** · **Primera conversación de 30 minutos sin costo**
> · **Acuerdo de confidencialidad antes de empezar**

**03 · Qué pasa después** — P4

> `<h2>` — Qué pasa después de que escribís.
> Te respondemos por el canal que elegiste, normalmente el mismo día hábil.
> Coordinamos una llamada de 30 minutos, sin costo, donde nos contás la
> situación y te decimos con franqueza si somos las personas indicadas.
> Si lo somos, te mandamos una propuesta con alcance y precio fijo en dos o tres
> días hábiles. Si no lo somos, te lo decimos y te orientamos hacia quien sí.

**No street address. No map. No embedded booking widget.**

---

## 13. `/preguntas-frecuentes`

**WhatsApp `{slug}`:** `faq` · **`source`:** `cyber:preguntas-frecuentes`

```
Title:       Preguntas frecuentes | Ciberseguridad para empresas en Paraguay
Description: Cuánto cuesta, cuánto tarda, si interrumpe la operación, qué pasa con la confidencialidad y en qué se diferencia una auditoría de un pentesting.
```

Pattern: P4 throughout, `<details>` on hairline rules, grouped under three H2s.
Carries `FAQPage` JSON-LD for **all** questions on this page. The five home-page
questions are **not** repeated here — duplicate `FAQPage` entries across pages
compete with each other.

**Sobre el trabajo**

**¿En qué se diferencia una auditoría de un pentesting?**
> La auditoría revisa cómo está organizada la seguridad: accesos, respaldos,
> configuración, procesos. El pentesting intenta entrar de verdad, con
> autorización, para demostrar qué es explotable en la práctica. La auditoría
> cubre más superficie; el pentesting va más profundo en menos cosas. Si nunca
> hiciste ninguna de las dos, casi siempre conviene empezar por la auditoría.

**¿Cuánto tarda un trabajo típico?**
> Una auditoría, entre una y dos semanas de relevamiento según el tamaño. Un
> pentesting, entre una y tres semanas. Un trabajo de cumplimiento depende del
> marco y de qué documentación exista. La propuesta siempre lleva el plazo por
> escrito.

**¿Interrumpe la operación de la empresa?**
> Una auditoría no. Un pentesting se coordina en ventanas horarias acordadas y,
> si hay sistemas delicados, se prueba en ambiente de pruebas.

**¿Trabajan con nuestro proveedor de IT o lo reemplazan?**
> Trabajamos con él. Los hallazgos se entregan escritos para que su equipo los
> ejecute. No hacemos soporte ni administración de sistemas.

**Sobre el alcance y el precio**

**¿Por qué no publican precios?**
> Porque el precio depende del tamaño y del alcance, y una cifra suelta en una
> tabla no te sirve para decidir. Lo que sí garantizamos es precio fijo por
> escrito antes de empezar. En `/precios` explicamos exactamente cómo se
> determina.

**¿La primera conversación tiene costo?**
> No, y tampoco la propuesta.

**¿Atienden fuera de Asunción?**
> Sí. La mayor parte del trabajo es remota. En Gran Asunción también vamos
> presencialmente cuando hace falta, y fuera del Gran Asunción lo coordinamos
> según el caso: escribinos y te confirmamos.

**Sobre la confidencialidad**

**¿Firman acuerdo de confidencialidad?**
> Siempre, antes de empezar, aunque no lo pidas.

**¿Qué hacen con la información que recolectan?**
> Los informes se entregan cifrados por un canal acordado. Los datos del trabajo
> se eliminan al cierre según lo acordado por escrito, y solo conservamos lo
> mínimo para responder consultas durante el período de acompañamiento.

**¿Publican casos o nombres de clientes?**
> No publicamos nombres. Con permiso previo por escrito podemos compartir un
> caso anonimizado, y las referencias las coordinamos directamente.

---

## 14. `/guias/` — hub + first guide

### 14.1 `/guias/` hub

```
Title:       Guías | Ciberseguridad para empresas en Paraguay
Description: Material práctico sobre seguridad informática para empresas paraguayas, escrito para quien tiene que tomar la decisión.
```

Simple P4 layout: heading left, article list right on hairline rules. Ships with
the one guide below — **a hub with one real article is fine; a hub padded with
stubs is not.**

### 14.2 `/guias/responder-un-cuestionario-de-seguridad`

**Primary keyword:** `cuestionario de seguridad para proveedores`
**WhatsApp `{slug}`:** `guia-cuestionario` · **`source`:** `cyber:guias/responder-un-cuestionario-de-seguridad`

```
Title:       Cómo responder un cuestionario de seguridad de un cliente | Guía
Description: Qué hacer cuando un cliente o un banco te manda una planilla de seguridad con fecha límite: cómo leerla, cómo responder un «no», y qué evidencia hace falta.
```

Long-form article, single column, measure 65ch, `Article` JSON-LD, one
`card--raised` CTA panel at 60% depth routing to `/servicios/cumplimiento`.

Section headings, verbatim, in order:

1. **Primero: no la contestes todavía**
2. **Quién te la mandó y por qué importa** — banco, casa matriz, cliente
   multinacional o seguro piden cosas distintas y aceptan cosas distintas
3. **Leé las preguntas agrupándolas, no en orden**
4. **Las tres respuestas posibles: sí, no, y no aplica**
5. **Cómo responder un «no» sin perder el contrato** — the piece's core, and the
   single most useful paragraph on the whole site
6. **Qué es la evidencia y por qué un «sí» sin respaldo es peor que un «no»**
7. **La ronda de repreguntas, que es donde se cae la mitad**
8. **Qué conviene tener listo antes del próximo**

⚠️ **Full prose for this article is a separate content turn** — it is a
1,200–1,600 word piece, it is the one asset here that is genuinely editorial
rather than structural, and padding it out inside a build spec would produce a
worse article than writing it on its own. Ship the site without it and add it as
its own commit; nothing else on the site depends on it.

⚠️ **The second guide is not specified**, deliberately: its topic comes from the
informational tail of the Google Keyword Planner export (`STEP0_RECON.md` §a),
which does not exist yet. Choosing a topic before seeing that data would be
inventing demand. Build it when the export is in hand.

---

## 15. Utility pages

### `/gracias`

`<meta name="robots" content="noindex,nofollow">` — permanently, not just
pre-launch. Fires the `form_submit` conversion event.

> `<h1>` — **Recibimos tu consulta.**
> Te respondemos por el canal que elegiste, normalmente dentro del día hábil.
> Si es urgente y preferís no esperar, escribinos por WhatsApp ahora.
> [ Escribinos por WhatsApp ]
> Mientras tanto, quizá te sirva leer cómo cotizamos o las preguntas frecuentes.

### `/404`

> `<h1>` — **Esta página no existe.**
> Puede que el enlace esté viejo o que la dirección tenga un error de tipeo.
> [ Ir al inicio ] [ Ver servicios ] [ Contacto ]

### `/politica-de-privacidad` and `/terminos`

⚠️ **Not drafted here.** These carry legal effect under Ley 6534/2020 and should
be reviewed by a lawyer rather than generated. Build the pages, the routes, the
footer links and the cookie-consent banner (nothing pre-ticked); leave the body
copy to be supplied. The privacy policy must at minimum state what the form
collects, who receives it, that it is sent to a CRM, how long it is kept, and
how to request deletion.

The site must not launch with either page empty — this is on the launch gate in
`BUILD-SPEC.md` §14.

---

## 16. Sitemap and internal linking

`sitemap.xml` contains exactly these 16 URLs. `/gracias` and `/404` are excluded.

```
/
/servicios/auditoria-de-seguridad
/servicios/pentesting
/servicios/respuesta-a-incidentes
/servicios/cumplimiento
/servicios/capacitacion
/para/clinicas
/para/contadores
/para/ecommerce
/para/pymes
/precios
/nosotros
/contacto
/preguntas-frecuentes
/guias/
/guias/responder-un-cuestionario-de-seguridad
```

**One primary keyword per page. No two pages target the same term.**

Internal linking rules:
- Every `/para/*` page links to at least two `/servicios/*` pages, chosen by
  what that sector actually buys — never all five as a list.
- Every `/servicios/*` page links to `/precios` and to `/contacto`.
- `/para/pymes` is the only page that links to all four other vertical pages.
- `/servicios/cumplimiento` links to the guide; the guide links back.
- `/servicios/respuesta-a-incidentes` links **out** to nothing above the fold.
  A person in a crisis gets two buttons, not a navigation exercise.
