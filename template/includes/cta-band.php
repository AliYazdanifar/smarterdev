<?php
/** Closing CTA band. Vars: $title, $text, $label, $href, $secondary (optional [label, href]). Blade: <x-cta-band /> */
$secondary = $secondary ?? null;
?>
<div class="cta-band reveal">
  <span class="cta-band__node cta-band__node--1" aria-hidden="true"></span>
  <span class="cta-band__node cta-band__node--2" aria-hidden="true"></span>
  <span class="cta-band__node cta-band__node--3" aria-hidden="true"></span>
  <h2><?= e($title) ?></h2>
  <p><?= e($text) ?></p>
  <div class="cta-band__actions">
    <a class="btn-sd btn-sd--primary" href="<?= e($href) ?>"><?= e($label) ?> <i class="bi bi-arrow-left" aria-hidden="true"></i></a>
    <?php if ($secondary): ?><a class="btn-sd btn-sd--ghost" href="<?= e($secondary[1]) ?>"><?= e($secondary[0]) ?></a><?php endif; ?>
  </div>
</div>
