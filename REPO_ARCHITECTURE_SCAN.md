# Repository architecture scan

## High-level overview
- `dev/`: Vue 3 + Vuetify admin SPA source.
- `html/`: built static assets from `dev/` (Vite output).
- `api/`: PHP JSON API with custom router and Medoo-style DB wrapper.
- `pages/`: two PHP-rendered public sites (`smartelectricsolution`, `elevatorcity`) that read from the same DB and render sections.

## Main modules
- Admin SPA: routing, auth/login, CRUD pages for main/about/services/projects/faq/params.
- API bootstrap + router + helpers + per-resource route files.
- Public sites: template components and site-specific config (`user_id` hardcoded).

## Entry points
- Frontend build output entry: `html/index.html` loading `/app/index.js`.
- Frontend source entry: `dev/src/main.js`.
- API entry: `api/index.php`.
- Public site entries: `pages/*/index.php`.
- No CLI or cron entry points found in repo.

## Database layer
- `Db_class\Db_classs` (Medoo-like abstraction) is used in API and public sites.
- API expects `api/system/config.php` for DB connection/bootstrap (required but missing in repo).
- Public sites each initialize DB directly in `pages/*/system/config.php` and query content tables.

## Risks / smells (observed)
- Missing tracked `api/system/config.php` means repo is not runnable as-is.
- Hardcoded DB credentials/user IDs in public site config files.
- Authentication uses salted MD5 and long-lived cookie token without secure flags.
- SQL string interpolation in helper pagination/search builder.
- Inconsistent API usage in frontend (e.g., params page posts to `main`; gallery uses unsupported `http.delete`).
- `dev/node_modules` is committed (very large repo footprint).
