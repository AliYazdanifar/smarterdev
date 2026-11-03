<?php
/**
 * Blog article template. Usage: blog-post.php?post=<slug>  (data: content/posts.php).
 * Laravel mapping: Route::get('/blog/{post:slug}') + pages/blog/show.blade.php
 */
require_once __DIR__ . '/includes/bootstrap.php';
$posts = content('posts');
$slug  = $_GET['post'] ?? array_key_first($posts);
if (!isset($posts[$slug])) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}
$post = $posts[$slug];
$query = ['post' => $slug];

$page = [
    'title'       => $post['title'],
    'description' => $post['meta_desc'],
    'route'       => 'blog-post',
    'route_query' => $query,
    'og_type'     => 'article',
    'css'         => ['pages/inner.css'],
    'breadcrumbs' => [['مقالات', 'blog'], [$post['title'], null]],
    'schema'      => [[
        '@context' => 'https://schema.org', '@type' => 'Article',
        'headline' => $post['title'], 'description' => $post['meta_desc'], 'inLanguage' => 'fa-IR',
        'datePublished' => $post['date'], 'dateModified' => $post['date'],
        'mainEntityOfPage' => canonical_for('blog-post', $query),
        'author'    => ['@type' => 'Organization', 'name' => site('name'), 'url' => abs_url('')],
        'publisher' => ['@type' => 'Organization', 'name' => site('name'), 'url' => abs_url('')],
    ]],
];
require_once __DIR__ . '/includes/head.php';
require_once __DIR__ . '/includes/header.php';
?>
<main id="main">
  <section class="page-hero dot-grid"><div class="container">
    <?php component('breadcrumb', ['page' => $page]); ?>
    <div class="page-hero__inner">
      <div class="post-meta mb-3"><span class="chip"><?= e($post['category']) ?></span><span><i class="bi bi-clock" aria-hidden="true"></i> <?= e($post['read']) ?></span><time datetime="<?= e($post['date']) ?>"><?= e(fa_num($post['date'])) ?></time></div>
      <h1><?= e($post['title']) ?></h1>
      <p class="page-hero__lead"><?= e($post['excerpt']) ?></p>
    </div>
  </div></section>

  <section class="section"><div class="container">
    <div class="article-layout">
      <article class="prose">
        <?php foreach ($post['body'] as $block): ?>
          <?php if (!empty($block['h2'])): ?><h2><?= e($block['h2']) ?></h2><?php endif; ?>
          <?php foreach (($block['p'] ?? []) as $p): ?><p><?= e($p) ?></p><?php endforeach; ?>
          <?php if (!empty($block['ul'])): ?><ul><?php foreach ($block['ul'] as $li): ?><li><?= e($li) ?></li><?php endforeach; ?></ul><?php endif; ?>
          <?php if (!empty($block['ol'])): ?><ol><?php foreach ($block['ol'] as $li): ?><li><?= e($li) ?></li><?php endforeach; ?></ol><?php endif; ?>
        <?php endforeach; ?>
      </article>
      <aside class="article-aside" aria-labelledby="aside-title">
        <div class="surface">
          <h2 id="aside-title">پروژه‌ای در همین زمینه دارید؟</h2>
          <p class="small">نیازتان را توضیح دهید تا امکان‌سنجی و مسیر اجرا را بررسی کنیم.</p>
          <a class="btn-sd btn-sd--primary btn-sd--block btn-sd--sm" href="<?= e(route('project-request', ['category' => $post['cta']['category']])) ?>"><?= e($post['cta']['label']) ?></a>
        </div>
      </aside>
    </div>
    <p class="mt-5"><a class="link-arrow" href="<?= e(route('blog')) ?>"><i class="bi bi-arrow-right" aria-hidden="true"></i> بازگشت به مقالات</a></p>
  </div></section>
</main>
<?php
require_once __DIR__ . '/includes/footer.php';
require_once __DIR__ . '/includes/scripts.php';
