<?php
/**
 * Optional router for the PHP built-in server:  php -S localhost:8000 router.php
 * - serves existing files as-is
 * - maps /sitemap.xml to sitemap.php
 * - renders the custom 404 page for unknown paths
 * Not needed on Apache/Nginx (see .htaccess). Not used by Laravel.
 */
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . $path;

if ($path === '/sitemap.xml') { require __DIR__ . '/sitemap.php'; return true; }
if ($path === '/' ) { require __DIR__ . '/index.php'; return true; }
if (is_file($file)) { return false; }      // let the server serve the static file / .php page
http_response_code(404);
require __DIR__ . '/404.php';
return true;
