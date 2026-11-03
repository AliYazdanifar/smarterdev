<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Config;

/** Read smarterdev config with dot notation. */
function site(string $key, mixed $default = null): mixed
{
    return Config::get('smarterdev.'.$key, $default);
}

/** Static content arrays from the template prototype. */
function sd_content(string $name): array
{
    static $cache = [];

    return $cache[$name] ??= require base_path('template/content/'.$name.'.php');
}

/** Internal URL with optional query string and hash fragment. */
function sd_url(string $name, array $query = [], string $hash = ''): string
{
    $url = route($name, $query);

    return $hash !== '' ? $url.'#'.$hash : $url;
}

/** Absolute site URL for a path segment. */
function abs_url(string $path = ''): string
{
    return rtrim(config('app.url'), '/').'/'.ltrim($path, '/');
}

/** Canonical URL for a named route. */
function canonical_for(string $name, array $params = []): string
{
    if ($name === 'home') {
        return abs_url('');
    }

    return route($name, $params, absolute: true);
}

/** Persian digits for numbers rendered in views. */
function fa_num(mixed $n): string
{
    return strtr((string) $n, ['0' => '۰', '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴', '5' => '۵', '6' => '۶', '7' => '۷', '8' => '۸', '9' => '۹']);
}

/** JSON-LD helper: safe for embedding inside a script tag. */
function json_ld(array $data): string
{
    return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_PRETTY_PRINT);
}

/** FAQPage structured data from [[question, answer], ...]. */
function faq_schema(array $faqs): array
{
    return [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array_map(static fn ($f) => [
            '@type' => 'Question',
            'name' => $f[0],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]],
        ], $faqs),
    ];
}

/** Default page meta merged with overrides (see template/includes/head.php). */
function sd_page(array $overrides = []): array
{
    $page = array_merge([
        'title' => site('name'),
        'description' => site('description'),
        'route' => 'home',
        'route_query' => [],
        'raw_title' => false,
        'css' => [],
        'js' => [],
        'body_class' => '',
        'breadcrumbs' => [],
        'schema' => [],
        'noindex' => false,
        'mobile_cta' => true,
    ], $overrides);

    $page['full_title'] = $page['raw_title'] ? $page['title'] : $page['title'].' | '.site('name');
    $page['canonical'] = canonical_for($page['route'], $page['route_query']);

    return $page;
}

/** Service route slug from content key (service-custom-development → custom-development). */
function service_slug(string $serviceKey): string
{
    return str_starts_with($serviceKey, 'service-')
        ? substr($serviceKey, strlen('service-'))
        : $serviceKey;
}
