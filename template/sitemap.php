<?php
/** XML sitemap generated from config + content. Apache: .htaccess maps /sitemap.xml here. Laravel: use a sitemap route/package. */
require_once __DIR__ . '/includes/bootstrap.php';
header('Content-Type: application/xml; charset=UTF-8');

$entries = [];
$skip = ['404', 'login', 'register', 'blog-post'];
foreach (array_keys(site('routes')) as $name) {
    if (in_array($name, $skip, true)) { continue; }
    $file = SD_ROOT . '/' . site('routes.' . $name);
    $entries[] = [canonical_for($name), is_file($file) ? date('c', filemtime($file)) : null];
}
foreach (content('posts') as $slug => $post) {
    $entries[] = [canonical_for('blog-post', ['post' => $slug]), $post['date']];
}
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($entries as [$loc, $mod]): ?>
  <url><loc><?= htmlspecialchars($loc, ENT_XML1 | ENT_QUOTES, 'UTF-8') ?></loc><?php if ($mod): ?><lastmod><?= e($mod) ?></lastmod><?php endif; ?></url>
<?php endforeach; ?>
</urlset>
