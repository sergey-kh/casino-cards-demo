# Casino Cards Demo Plugin

Custom WordPress plugin that fetches casino data from an external service (Cartable) and renders predefined casino cards as Gutenberg blocks. Also includes a `casino` Custom Post Type (CPT) with a plugin fallback template that can be overridden in a theme/child theme.

> **Note (Demo scope):** This plugin is a **concept / architecture demo** and wasn’t fully tested.

---

## Requirements

- **PHP:** 8.0+
- **WordPress:** 5.6+ (Block Editor / Gutenberg “v2” supported)

### For developers
- **Composer:** required for PSR-4 autoload and manage libraries
- **Node.js + npm:** required only if you need to rebuild styles/js and blocks assets

## Installation

### Option 1 — GitHub (development)
1. Download/clone into: `wp-content/plugins/casino-cards-demo/`
2. Run `composer install` in the plugin directory
3. Activate in **Plugins → Installed Plugins**

### Option 2 — ZIP upload (ready-to-use)
1. Go to **Plugins → Add New → Upload Plugin**
2. Upload the ZIP
3. Click **Install Now → Activate**

---

## Configuration (API credentials)

1. Go to **Settings → Casino Cards**
2. Set **Cartable API Username** and **Cartable API Password**
3. Click **Save Changes**

---

## Usage

### Gutenberg blocks
1. Open a page/post
2. In Gutenberg, find the **Casino Cards Plugin** block category and add a **Statistics Card** or **Bonus Card**
3. Select a casino
4. Publish/update

Blocks correspond to the Figma card elements (bonus card, statistics card). The editor shows a preview.

### Casino CPT
The plugin registers a `casino` post type intended as a foundation for future development:
- create a Casino post
- implement output in a theme/child theme using the plugin’s API/provider layer (recommended)

---

## Customization

### Gutenberg Block overrides values (optional)
All Casino fields can be overridden per-block in the inspector panel: **Block sidebar → Overrides (optional)**.

### Override the Casino CPT template in a theme/child theme

Plugin fallback:
- `wp-content/plugins/casino-cards-demo/templates/casino/single-casino.php`

Theme override (takes precedence):
- `wp-content/themes/<your-theme>/casino-cards-demo/single-casino.php`
- `wp-content/themes/<your-theme>/single-casino.php`

### Hooks
- `casino_cards_demo_http_client_timeout` — HTTP timeout for API requests (seconds).<br>
  **Default:** `30`

- `casino_cards_demo_api_cache_ttl` — API cache TTL (seconds).<br>
  **Default:** `86400` (24 hours)

- `casino_cards_demo_api_cache_stale_after` — Stale-while-revalidate cache (seconds).
  When cache is older than this value, the plugin may trigger a refresh while still serving cached data.<br>
  **Default:** `43200` (12 hours)

---

## Impact Analysis

### Performance (page load / Core Web Vitals)

The plugin minimizes API calls via **data-level caching** and a **stale-while-revalidate** approach.
Rare delays can still happen when:
- traffic is low (revalidation happens less frequently), or
- a **full-page HTML cache** (CDN/WP cache plugins) serves cached markup longer than the data TTL.

Mitigation options:
- scheduled refresh/pre-warm during low-traffic hours (WP-Cron / real cron)
- admin cache purge (“Clear cache”)
- adjust data TTL vs page-cache TTL
- **skeleton + AJAX hydration**: render instantly and fetch data asynchronously (best when page cache is aggressive)

### Plugin conflicts (themes / plugins)

Low risk due to namespaced CSS. Main realistic conflicts:
- another plugin registers the same block name / CPT slug
- the same plugin slug / text domain is reused

Mitigation:
- keep unique plugin slug, block names, CPT slug
- keep CSS strongly namespaced under a single root class

### Security

- admin access is protected by capabilities (`manage_options`)
- output is escaped; inputs are sanitized
- API credentials are not exposed in markup/JS/REST
- nonces are required for any privileged AJAX/REST actions (e.g., rest-api endpoint)

### Cache impact (multi-layer caching)

Common layers:
- WordPress object cache (Redis/Memcached)
- transients in DB (no object cache)
- full-page cache / CDN (Cloudflare, WP Rocket, etc.)

Potential issues:
- full-page cache can keep HTML longer than API/data cache TTL (“stale” UI)

Mitigation options:
- explicit invalidation (admin button, CLI command)
- if the block must update more frequently than page cache: **use skeleton + load block via AJAX** and/or configure cache-busting rules for that endpoint
- optional scheduled pre-warm to avoid cold-cache hits (during low-traffic hours)

---

## Developer Guidelines

### Standards & architecture
- PSR-4 autoloading via Composer, PSR-12 style
- OOP, SOLID-oriented separation: transport (HTTP client) → API client → provider/adapter → DTOs → Factory → rendering
- designed to support multiple APIs consistently (Adapters + DTOs, Factory for provider selection)
- Webpack is used for bundling plugin JS/CSS (editor + frontend)

### Structure
- `src/` — PHP classes (plugin core)
- `templates/` — templates (CPT, SSR Gutenberg block)
- `assets/src/` — block source (JS/CSS)
- `assets/dist/` — built assets

### Local development
- PHP deps: `composer install`
- build/watch assets: `npm install` then `npm run start` (watch) or `npm run build` (prod)

### Extending the plugin (short checklist)
- **New API provider:** implement provider/adapter returning standardized DTOs; keep transport reusable; keep endpoint details in provider-specific client
- **New block:** add in `/src/Gutenberg/` (php), `/assets/src/blocks/` (js)

---
## License

Copyright (c) 2026 Serhii Barsukov. All Rights Reserved. Provided for review purposes only.