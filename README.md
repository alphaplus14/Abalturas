# Abalturas Theme

Tema personalizado de **WordPress** y **WooCommerce** para [Abalturas](https://abalturas.com.co) — empresa B2B colombiana especializada en equipos de protección contra caídas y soluciones para trabajo en alturas.

Diseño industrial y profesional con identidad de marca **azul `#1a365d`** y **naranja `#f56523`**, construido en PHP y **Tailwind CSS**.

---

## Requisitos

| Requisito | Versión recomendada |
|-----------|---------------------|
| WordPress | 6.x |
| WooCommerce | 8.x+ |
| PHP | 8.0+ |
| Node.js | 18+ (solo para compilar CSS) |

---

## Instalación

1. Copia la carpeta del tema en `wp-content/themes/abalturas/`.
2. Activa el tema en **Apariencia → Temas**.
3. Instala y activa **WooCommerce**.
4. Compila los estilos Tailwind (ver sección [Desarrollo](#desarrollo)).
5. Configura las páginas de WooCommerce (tienda, carrito, checkout, mi cuenta).

---

## Desarrollo

```bash
# Instalar dependencias
npm ci

# Compilar Tailwind (producción)
npm run build:css

# Modo watch (desarrollo)
npm run watch:css
```

El build genera `assets/css/tailwind.min.css` a partir de `assets/css/tailwind-input.css`.  
Las clases se escanean en `*.php`, `template-parts/`, `woocommerce/` e `inc/` (ver `tailwind.config.js`).

---

## Estructura del proyecto

```
abalturas/
├── assets/
│   ├── css/          # Tailwind compilado + estilos por módulo (cart, shop, checkout…)
│   ├── js/           # Scripts del tema (carrito, búsqueda, checkout Colombia)
│   └── data/         # JSON de ciudades/departamentos Colombia
├── inc/              # Lógica PHP modular
├── page-templates/   # Plantillas de página corporativas
├── template-parts/   # Partials reutilizables (header, home, servicios…)
├── woocommerce/      # Overrides de plantillas WooCommerce
├── functions.php
├── style.css         # Metadatos del tema + variables CSS de marca
├── tailwind.config.js
└── package.json
```

---

## Funcionalidades principales

### E-commerce (WooCommerce)

- **Catálogo y ficha de producto** — loop de tienda, paginación, galería y tabs personalizados.
- **Carrito premium** — diseño B2B, envío a cotizar, mini-carrito en header.
- **Checkout Colombia** — selector dependiente Departamento → Ciudad (Blocks + checkout clásico).
- **Pedido recibido** — página de confirmación rediseñada (`thankyou.php` + detalle del pedido).
- **Búsqueda predictiva** — AJAX en header con resultados en vivo.
- **Sin existencias** — productos agotados ocultos en el front (admin sin cambios).
- **Importación Alpen** — módulo para catálogo externo (`inc/alpen-catalog-import.php`).

### Sitio corporativo

- Home con secciones industriales (hero, certificaciones, productos destacados, CTAs).
- Páginas: Servicios, Sobre nosotros, Normativa Res. 4272, Política de datos, Términos.
- Footer con banner CTA y enlaces WhatsApp (asesoría técnica / comercial).
- Normativa y contenido legal en plantillas dedicadas.

---

## Módulos (`inc/`)

| Archivo | Descripción |
|---------|-------------|
| `woocommerce-cart.php` | Carrito, mini-carrito, envío a cotizar |
| `woocommerce-colombia-cities.php` | Departamentos y ciudades en checkout |
| `woocommerce-live-search.php` | Búsqueda AJAX de productos |
| `woocommerce-thankyou.php` | Helpers y assets de pedido recibido |
| `woocommerce-hide-out-of-stock.php` | Ocultar productos agotados en front |
| `woocommerce-product-info.php` | Información extra en ficha de producto |
| `alpen-catalog-import.php` | Importación de catálogo Alpen |

---

## Colombia — ciudades en checkout

Los datos de ciudades por departamento están en:

```
assets/data/colombia-cities-by-state.json
```

Para regenerar el JSON desde la fuente:

```bash
php assets/data/build-colombia-cities-by-state.php
```

---

## Colores de marca (Tailwind)

| Token | Hex | Uso |
|-------|-----|-----|
| `industrial` | `#1A365D` | Títulos, navegación, encabezados |
| `safety` | `#F56523` | CTAs, acentos, totales |
| `carbon` | `#2D3748` | Texto secundario |
| `charcoal` | `#1A202C` | Texto principal |
| `mist` | `#F7FAFC` | Fondos claros |

---

## Plantillas WooCommerce sobrescritas

Incluye overrides en `woocommerce/` para carrito, tienda, ficha de producto, checkout (thank you) y detalle de pedido.  
Tras actualizar WooCommerce, revisa si hay cambios en las plantillas originales del plugin.

---

## Licencia

Proyecto privado — © Abalturas. Todos los derechos reservados.
