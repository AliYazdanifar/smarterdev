<?php
/** Visible breadcrumb trail (structured data is emitted by seo.php). Uses $page['breadcrumbs']. */
if (empty($page['breadcrumbs'])) { return; }
$trail = array_merge([['خانه', 'home']], $page['breadcrumbs']);
?>
<nav class="crumbs" aria-label="مسیر صفحه">
  <ol>
    <?php foreach ($trail as $i => $crumb): $last = $i === count($trail) - 1; ?>
      <?php if ($last || empty($crumb[1])): ?>
        <li><span aria-current="page"><?= e($crumb[0]) ?></span></li>
      <?php else: ?>
        <li><a href="<?= e(route($crumb[1], $crumb[2] ?? [])) ?>"><?= e($crumb[0]) ?></a></li>
      <?php endif; ?>
    <?php endforeach; ?>
  </ol>
</nav>
