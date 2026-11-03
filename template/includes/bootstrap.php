<?php
/**
 * Loads configuration and helper functions. Included once at the top of every page.
 * Laravel mapping: AppServiceProvider + helpers / Blade directives.
 */
declare(strict_types=1);

if (!defined('SD_ROOT')) {
    define('SD_ROOT', dirname(__DIR__));
}

$SITE = require SD_ROOT . '/config/site.php';

/** Escape output. Laravel: {{ $value }} */
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Read a config value with dot notation: site('contact.email'). */
function site(string $key, $default = null)
{
    global $SITE;
    $value = $SITE;
    foreach (explode('.', $key) as $part) {
        if (!is_array($value) || !array_key_exists($part, $value)) {
            return $default;
        }
        $value = $value[$part];
    }
    return $value;
}

/** Internal URL by route name. Laravel: route('name', $params) */
function route(string $name, array $query = [], string $hash = ''): string
{
    $file = site('routes.' . $name, site('routes.404'));
    $url  = site('base_path', '') . $file;
    if ($query) {
        $url .= '?' . http_build_query($query);
    }
    return $url . ($hash !== '' ? '#' . $hash : '');
}

/** Asset URL. Laravel: asset('assets/...') */
function asset(string $path): string
{
    return site('base_path', '') . site('assets_path') . ltrim($path, '/');
}

/** Absolute URL for canonical / Open Graph / sitemap. */
function abs_url(string $path = ''): string
{
    return rtrim(site('site_url'), '/') . '/' . ltrim($path, '/');
}

/** Canonical URL for a route name (the homepage canonicalises to "/"). */
function canonical_for(string $name, array $query = []): string
{
    if ($name === 'home') {
        return abs_url('');
    }
    return abs_url(route($name, $query));
}

/** Render a reusable component from includes/. Laravel: <x-component :vars /> */
function component(string $name, array $vars = []): void
{
    extract($vars, EXTR_SKIP);
    require SD_ROOT . '/includes/' . $name . '.php';
}

/** Load a content array from content/. */
function content(string $name): array
{
    static $cache = [];
    return $cache[$name] ??= require SD_ROOT . '/content/' . $name . '.php';
}

/** Persian digits for numbers rendered by PHP. */
function fa_num($n): string
{
    return strtr((string) $n, ['0' => '۰', '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴', '5' => '۵', '6' => '۶', '7' => '۷', '8' => '۸', '9' => '۹']);
}

/** JSON-LD helper: safe for embedding inside a <script> tag. */
function json_ld(array $data): string
{
    return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_PRETTY_PRINT);
}

/** FAQPage structured data from [[question, answer], ...]. */
function faq_schema(array $faqs): array
{
    return [
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'mainEntity' => array_map(static fn ($f) => [
            '@type' => 'Question',
            'name'  => $f[0],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]],
        ], $faqs),
    ];
}
