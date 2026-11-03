# SmarterDev.ir — static PHP prototype

Premium RTL (Persian) website template: PHP includes + Bootstrap 5.3 (RTL) + vanilla JS.
No database, no backend, no build step. Built to be migrated to Laravel Blade later (see `README-BLADE.md`).

## Run locally
```bash
php -S localhost:8000 router.php     # PHP 8.1+ (mbstring recommended)
# open http://localhost:8000/
```
`router.php` is only a dev helper (serves `/sitemap.xml`, renders the custom 404). On Apache, `.htaccess` does the same.

## Structure
```
index.php, services.php, service-*.php (9), about.php, portfolio.php, blog.php, blog-post.php,
contact.php, project-request.php, login.php, register.php, privacy.php, 404.php, sitemap.php
config/      site.php (brand, domain, routes, nav, contact, founder) · wizard.php (wizard options)
content/     services.php · projects.php · posts.php   (all page copy as data)
includes/    head · header · footer · scripts · seo · breadcrumb · page-hero · service-detail
             service-card · project-card · faq-item · process-steps · cta-band · founder-* · hero-visual
public/assets/  css/ (tokens, layout, components, pages/*) · js/ · fonts/ · images/ · icons/ · vendor/
```
Vendored (no CDN): Bootstrap 5.3.3 RTL, Bootstrap Icons 1.11.3, Vazirmatn variable font (OFL). Licenses are included next to each.

## Common tasks
- **Founder portrait** — put `public/assets/images/founder.jpg` (`.jpeg/.webp/.png` also detected, 4:5 ratio, ~640×800). Until then a labelled placeholder is shown. Name/bio/role: `config/site.php` → `founder`.
- **Contact details / social links** — `config/site.php` → `contact`, `social`. Empty values render a «به‌زودی» placeholder; social icons appear only for URLs you provide.
- **Domain** — `config/site.php` → `site_url` (canonical, Open Graph, JSON-LD, sitemap) and `robots.txt` (Sitemap line). Sub-folder hosting → `base_path` (e.g. `/smarterdev/`).
- **Add a service page** — add an entry to `content/services.php`, add its route to `config/site.php` → `routes`, create `service-xyz.php` (3 lines, copy any existing one and change `$service_key`). It automatically appears on the homepage, services page and sitemap.
- **Add a blog post** — add an item to `content/posts.php` (unique slug, title, meta_desc, body blocks). URL: `blog-post.php?post=<slug>`; listing and sitemap update automatically.
- **Replace demo portfolio items** — `content/projects.php`; set `'demo' => false` when an item is a real, approved case study.
- **Wizard options (categories, budgets in تومان, timelines…)** — `config/wizard.php`.
- **Theme** — dark by default; choice saved in `localStorage` (`sd-theme`). To follow the OS on first visit set `FOLLOW_SYSTEM_WHEN_NO_SAVED_CHOICE = true` in `public/assets/js/theme-init.js`.

## Static-prototype limitations (by design)
- Login/register/contact/wizard forms are **client-side only**. Nothing is sent or stored; each shows a clear "demo" message. `project-request.php?entry=demo` simulates "signed in" and is **not** authentication.
- File attachment is a placeholder (file names are listed, nothing is uploaded).
- Blog/portfolio content is sample copy for review; portfolio items are labelled «نمونهٔ مفهومی» (fictional). The privacy page is a draft needing legal review.
- Contact details are placeholders; no phone/email/social accounts were invented.
- `og-default.png` is a generated placeholder image — replace with your brand artwork if desired.

## Verification performed (in this build environment)
PHP 8.3 `php -l` on every PHP file · crawl of all 24 URLs (HTTP status, exactly one H1, heading order, unique titles/descriptions, valid JSON-LD, no duplicate ids, no inline `style`/`on*` attributes, every internal link and asset resolves) · sitemap well-formedness · headless-Chromium tests: theme toggle + persistence, mobile drawer (open/Esc/overlay/scroll-lock), FAQ, the complete wizard flow (validation, conditional questions, back-navigation state, review/edit, consent, demo confirmation, no network POST), login/register validation, and no horizontal overflow on 16 pages at 320/375/768/1024/1440 px. Screenshots were reviewed for the homepage (dark/light), a service page and the wizard.
**Not tested:** real devices/Safari/Firefox, screen-reader sessions, Lighthouse/Core Web Vitals, Apache `.htaccess` behaviour, PHP versions other than 8.3.
