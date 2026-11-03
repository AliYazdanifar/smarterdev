<?php
/** Service card. Vars: $key (route name), $svc (array from content/services.php), $delay (optional). Blade: <x-service-card :service="$svc" /> */
$delay = $delay ?? 0;
?>
<article class="svc-card reveal"<?= $delay ? ' data-delay="' . e($delay) . '"' : '' ?>>
  <span class="icon-tile" aria-hidden="true"><i class="bi <?= e($svc['icon']) ?>"></i></span>
  <h3><?= e($svc['title']) ?></h3>
  <p><?= e($svc['short']) ?></p>
  <ul class="check-list">
    <?php foreach ($svc['caps'] as $cap): ?><li><?= e($cap) ?></li><?php endforeach; ?>
  </ul>
  <a class="link-arrow svc-card__more stretched-link" href="<?= e(route($key)) ?>">بررسی این خدمت <i class="bi bi-arrow-left" aria-hidden="true"></i><span class="visually-hidden">: <?= e($svc['title']) ?></span></a>
</article>
