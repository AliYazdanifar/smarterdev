<?php
/** Blog listing. Posts: content/posts.php. Laravel mapping: pages/blog/index.blade.php (paginated). */
require_once __DIR__ . '/includes/bootstrap.php';
$posts = content('posts');
$page = [
    'title'       => 'مقالات و یادداشت‌های فنی',
    'description' => 'یادداشت‌هایی دربارهٔ ایجنت‌های هوش مصنوعی، اتوماسیون کسب‌وکار، تعمیر و نگهداری نرم‌افزار و تصمیم‌های فنی برای صاحبان کسب‌وکار.',
    'route'       => 'blog',
    'css'         => ['pages/inner.css'],
    'breadcrumbs' => [['مقالات', null]],
];
require_once __DIR__ . '/includes/head.php';
require_once __DIR__ . '/includes/header.php';
component('page-hero', ['page' => $page, 'eyebrow' => 'مقالات', 'h1' => 'مقالات و یادداشت‌های فنی',
    'lead' => 'راهنماهای کوتاه و کاربردی برای تصمیم‌گیری دربارهٔ نرم‌افزار، هوش مصنوعی و اتوماسیون؛ بدون اصطلاحات غیرضروری.']);
?>
<main id="main">
  <section class="section" aria-label="فهرست مقالات"><div class="container">
    <div class="row g-4">
      <?php foreach ($posts as $slug => $post): ?>
        <div class="col-12 col-md-6 col-lg-4">
          <article class="post-card reveal">
            <div class="post-meta"><span class="chip"><?= e($post['category']) ?></span><span><i class="bi bi-clock" aria-hidden="true"></i> <?= e($post['read']) ?></span></div>
            <h2><a class="stretched-link" href="<?= e(route('blog-post', ['post' => $slug])) ?>"><?= e($post['title']) ?></a></h2>
            <p><?= e($post['excerpt']) ?></p>
          </article>
        </div>
      <?php endforeach; ?>
    </div>
  </div></section>
</main>
<?php
require_once __DIR__ . '/includes/footer.php';
require_once __DIR__ . '/includes/scripts.php';
