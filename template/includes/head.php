<?php
/**
 * Opens the document: <!DOCTYPE> … <body>. Required first by every page.
 * Page metadata comes from the $page array defined by the page itself.
 * Laravel mapping: layouts/app.blade.php <head> + @stack('styles').
 */
require_once __DIR__ . '/bootstrap.php';

$page = array_merge([
    'title'       => site('name'),
    'description' => site('description'),
    'route'       => 'home',
    'route_query' => [],
    'raw_title'   => false,   // true = do not append "| SmarterDev"
    'css'         => [],      // page-specific stylesheets relative to assets/css/
    'js'          => [],      // page-specific scripts relative to assets/js/
    'body_class'  => '',
    'breadcrumbs' => [],      // [[label, route|null, query], ...]
    'schema'      => [],      // extra JSON-LD nodes
    'noindex'     => false,
    'mobile_cta'  => true,
], $page ?? []);

$page['full_title'] = $page['raw_title'] ? $page['title'] : $page['title'] . ' | ' . site('name');
$page['canonical']  = canonical_for($page['route'], $page['route_query']);
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl" data-bs-theme="dark" data-theme="dark">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="<?= e(site('theme_color')) ?>">
<title><?= e($page['full_title']) ?></title>
<script src="<?= e(asset('js/theme-init.js')) ?>"></script>
<?php component('seo', ['page' => $page]); ?>
<link rel="icon" href="<?= e(asset('icons/favicon.svg')) ?>" type="image/svg+xml">
<link rel="preload" href="<?= e(asset('fonts/Vazirmatn-Variable.woff2')) ?>" as="font" type="font/woff2" crossorigin>
<!-- Dependencies are vendored locally: Bootstrap 5.3.3 (RTL build), Bootstrap Icons 1.11.3, Vazirmatn (OFL). -->
<link rel="stylesheet" href="<?= e(asset('vendor/bootstrap/bootstrap.rtl.min.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('vendor/bootstrap-icons/bootstrap-icons.min.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('css/tokens.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('css/layout.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('css/components.css')) ?>">
<?php foreach ($page['css'] as $css): ?>
<link rel="stylesheet" href="<?= e(asset('css/' . $css)) ?>">
<?php endforeach; ?>
</head>
<body class="<?= e($page['body_class']) ?>">
