# Blade migration map

| Static file | Laravel equivalent |
|---|---|
| `includes/head.php` + `seo.php` | `layouts/app.blade.php` `<head>` + `<x-seo :title :description :route :schema />` |
| `includes/header.php` / `footer.php` | `layouts/partials/header.blade.php` / `footer.blade.php` (or `<x-header/>`) |
| `includes/scripts.php` | `@stack('scripts')` at the end of the layout |
| `includes/breadcrumb.php`, `page-hero.php`, `cta-band.php`, `process-steps.php` | Blade components `<x-breadcrumb/>`, `<x-page-hero/>`, `<x-cta-band/>`, `<x-process-steps/>` |
| `includes/service-card.php`, `project-card.php`, `faq-item.php` | `<x-service-card :service>`, `<x-project-card :project>`, `<x-faq-item>` |
| `includes/service-detail.php` + `service-*.php` | one `ServiceController@show` + `pages/service.blade.php`, route `/services/{slug}` |
| `*.php` pages | `resources/views/pages/*.blade.php` extending `layouts.app` |
| `public/assets/` | `public/assets/` unchanged (use `asset('assets/...')`) |
| `config/site.php` | `config/smarterdev.php` + `config('app.url')` for the domain |
| `config/wizard.php` | `config/project_request.php` |
| `content/services.php`, `projects.php`, `posts.php` | `Service`, `Project`, `Post` Eloquent models (seed from these arrays) |

## Helpers
`route('name')` (helpers.php in `includes/bootstrap.php`) → Laravel `route('name')`. Route names already match the keys in `config/site.php` → `routes`.
`e($x)` → `{{ $x }}` · `component('x', [...])` → `<x-x ... />` · `asset('css/x.css')` → `asset('assets/css/x.css')`.

## Dynamic candidates
- Homepage services grid → `@foreach(Service::all() ...)`; projects grid → `@foreach(Project::published() ...)`.
- Homepage/service FAQs → `Faq` model (polymorphic to page/service); FAQPage JSON-LD is already generated from the same data.
- Blog list → paginated `Post` query; `blog-post.php?post=slug` → `/blog/{post:slug}`; Article JSON-LD is in the template.
- Sitemap: `sitemap.php` → a route/command that iterates the same models.

## Forms and flows
- **Login / Register** (`login.php`, `register.php`, `data-demo-form`) → Fortify/Breeze views; add `@csrf`, server errors via `$errors`. After login `redirect()->intended(route('project-request'))`.
- **Auth gate** in `project-request.php` (`?entry=demo`) → `auth` middleware on the route; delete the gate markup.
- **Wizard** (`#project-wizard`, `wizard.js`) → POST `ProjectRequestController@store` with a `StoreProjectRequest` FormRequest. Field names are already the request keys: `category, title, description, outcome, url, start_type, ui_design, tools_connect, tools_list, assets[], symptom, api_services, focus, budget, timeline, urgency, attachment[], contact_method, notes, consent`. Conditional blocks (`.wiz-cond[data-cats]`) map to `Rule::requiredIf(category in …)`. Keep `wizard.js` for UX, but server validation is authoritative; the attachment input needs real upload handling (size/type limits, storage).
- **Contact form** (`contact.php`) → `ContactController@store` (+ `@csrf`, rate limiting, honeypot).
- Persian error messages in `forms.js` / `wizard.js` → `lang/fa/validation.php`.

## SEO to keep server-rendered
Titles, descriptions, canonicals, Open Graph, JSON-LD (WebSite, ProfessionalService, BreadcrumbList, Service, FAQPage, Article, Person), FAQ answers and all copy are rendered in PHP, so they remain in the HTML Laravel sends. The accordion uses `.js` gating so answers stay visible without JavaScript.
