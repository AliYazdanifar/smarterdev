<?php
/** Site footer + sticky mobile CTA. Laravel mapping: <x-footer /> (layouts/partials/footer.blade.php). */
$services = content('services');
$contact  = site('contact');
$social   = site('social', []);
$socialIcons = ['github' => 'bi-github', 'linkedin' => 'bi-linkedin', 'telegram' => 'bi-telegram', 'instagram' => 'bi-instagram', 'x' => 'bi-twitter-x', 'youtube' => 'bi-youtube'];
$placeholder = static fn (string $text) => '<span class="is-placeholder">' . e($text) . '</span>';
?>
<footer class="site-footer">
  <div class="container">
    <div class="row g-4 g-lg-5">
      <div class="col-12 col-lg-4">
        <a class="brand" href="<?= e(route('home')) ?>" aria-label="SmarterDev — صفحه اصلی">
          <?php component('logo-mark'); ?>
          <span class="brand__word">Smarter<b>Dev</b></span>
        </a>
        <p class="footer-about">توسعه نرم‌افزار اختصاصی، ایجنت‌های هوش مصنوعی، اتوماسیون کسب‌وکار و تعمیر پروژه‌های موجود؛ با تمرکز بر راهکاری که واقعاً به فرایند شما می‌خورد.</p>
        <?php if ($social): ?>
          <div class="footer-social">
            <?php foreach ($social as $name => $url): ?>
              <a class="icon-btn" href="<?= e($url) ?>" rel="noopener" target="_blank" aria-label="<?= e(ucfirst($name)) ?>"><i class="bi <?= e($socialIcons[$name] ?? 'bi-link-45deg') ?>" aria-hidden="true"></i></a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <div class="col-6 col-md-4 col-lg-3">
        <h2>خدمات</h2>
        <ul class="footer-list">
          <?php foreach (site('footer_services') as $key): ?>
            <li><a href="<?= e(route($key)) ?>"><?= e($services[$key]['title']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="col-6 col-md-4 col-lg-2">
        <h2>پیمایش</h2>
        <ul class="footer-list">
          <?php foreach (site('nav') as $item): ?>
            <li><a href="<?= e(route($item['route'], [], $item['hash'] ?? '')) ?>"><?= e($item['label']) ?></a></li>
          <?php endforeach; ?>
          <li><a href="<?= e(route('contact')) ?>">تماس</a></li>
          <li><a href="<?= e(route('project-request')) ?>">ثبت درخواست پروژه</a></li>
        </ul>
      </div>

      <div class="col-12 col-md-4 col-lg-3">
        <h2>تماس</h2>
        <ul class="footer-list">
          <li>
            <i class="bi bi-envelope" aria-hidden="true"></i>
            <?= !empty($contact['email']) ? '<a class="ltr" href="mailto:' . e($contact['email']) . '">' . e($contact['email']) . '</a>' : $placeholder('ایمیل — به‌زودی') ?>
          </li>
          <li>
            <i class="bi bi-telephone" aria-hidden="true"></i>
            <?= !empty($contact['phone']) ? '<a href="tel:' . e($contact['phone']) . '">' . e($contact['phone']) . '</a>' : $placeholder('شماره تماس — به‌زودی') ?>
          </li>
          <li>
            <i class="bi bi-send" aria-hidden="true"></i>
            <?= !empty($contact['telegram']) ? '<a href="' . e($contact['telegram']) . '" rel="noopener" target="_blank">پیام‌رسان</a>' : $placeholder('پیام‌رسان — به‌زودی') ?>
          </li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <span>© <?= e(fa_num(date('Y'))) ?> SmarterDev — همهٔ حقوق محفوظ است.</span>
      <span><a href="<?= e(route('privacy')) ?>">حریم خصوصی</a></span>
    </div>
  </div>
</footer>

<?php if ($page['mobile_cta']): ?>
<div class="mobile-cta d-lg-none" data-mobile-cta>
  <a class="btn-sd btn-sd--primary btn-sd--block" href="<?= e(route('project-request')) ?>">ثبت درخواست پروژه <i class="bi bi-arrow-left" aria-hidden="true"></i></a>
</div>
<?php endif; ?>
