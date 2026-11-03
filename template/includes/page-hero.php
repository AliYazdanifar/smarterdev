<?php
/** Inner-page hero. Vars: $eyebrow, $h1, $lead, $actions (optional list of [label, href, style]). Uses $page for breadcrumbs. */
$actions = $actions ?? [];
?>
<section class="page-hero dot-grid">
  <div class="container">
    <?php component('breadcrumb', ['page' => $page]); ?>
    <div class="page-hero__inner">
      <?php if (!empty($eyebrow)): ?><span class="eyebrow"><?= e($eyebrow) ?></span><?php endif; ?>
      <h1><?= e($h1) ?></h1>
      <?php if (!empty($lead)): ?><p class="page-hero__lead"><?= e($lead) ?></p><?php endif; ?>
      <?php if ($actions): ?>
        <div class="d-flex flex-wrap gap-3 mt-4">
          <?php foreach ($actions as $a): ?>
            <a class="btn-sd btn-sd--<?= e($a[2] ?? 'primary') ?>" href="<?= e($a[1]) ?>"><?= e($a[0]) ?><?= ($a[2] ?? 'primary') === 'primary' ? ' <i class="bi bi-arrow-left" aria-hidden="true"></i>' : '' ?></a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
