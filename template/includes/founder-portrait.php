<?php
/** Founder portrait: uses public/assets/images/founder.(jpg|jpeg|webp|png) if present, otherwise a labelled placeholder. */
$portrait = null;
foreach (['jpg', 'jpeg', 'webp', 'png'] as $ext) {
    if (is_file(SD_ROOT . '/public/assets/images/founder.' . $ext)) { $portrait = 'images/founder.' . $ext; break; }
}
?>
<div class="founder__frame">
  <?php if ($portrait): ?>
    <img class="founder__img" src="<?= e(asset($portrait)) ?>" width="640" height="800" loading="lazy" decoding="async" alt="تصویر بنیان‌گذار SmarterDev">
  <?php else: ?>
    <div class="founder__placeholder" role="img" aria-label="جای تصویر بنیان‌گذار">
      <svg viewBox="0 0 64 64" fill="none" aria-hidden="true"><circle cx="32" cy="23" r="11" stroke="currentColor" stroke-width="2.4"/><path d="M10 56c2-12 11-18 22-18s20 6 22 18" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/></svg>
      <small>تصویر بنیان‌گذار را در این مسیر قرار دهید:<br><code>public/assets/images/founder.jpg</code></small>
    </div>
  <?php endif; ?>
</div>
