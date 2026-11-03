<?php
/**
 * Shared template for every service page. A page file only sets $service_key and requires this file.
 * Content: content/services.php. Laravel mapping: one route /services/{slug} + resources/views/pages/service.blade.php.
 */
require_once __DIR__ . '/bootstrap.php';

$all = content('services');
$svc = $all[$service_key];
$ctaUrl = route('project-request', ['category' => $svc['category']]);

$page = [
    'title'       => $svc['meta_title'],
    'description' => $svc['meta_desc'],
    'route'       => $service_key,
    'css'         => ['pages/inner.css'],
    'body_class'  => 'page-service',
    'breadcrumbs' => [['خدمات', 'services'], [$svc['title'], null]],
    'schema'      => [
        [
            '@context' => 'https://schema.org', '@type' => 'Service',
            'name' => $svc['title'], 'description' => $svc['meta_desc'],
            'url' => canonical_for($service_key), 'areaServed' => 'IR',
            'provider' => ['@type' => 'ProfessionalService', 'name' => site('name'), 'url' => abs_url('')],
        ],
        faq_schema($svc['faqs']),
    ],
];

require_once __DIR__ . '/head.php';
require_once __DIR__ . '/header.php';
?>
<main id="main">

  <section class="page-hero dot-grid">
    <div class="container">
      <?php component('breadcrumb', ['page' => $page]); ?>
      <div class="svc-hero">
        <div>
          <span class="eyebrow"><?= e($svc['title']) ?></span>
          <h1><?= e($svc['h1']) ?></h1>
          <p class="page-hero__lead"><?= e($svc['lead']) ?></p>
          <div class="d-flex flex-wrap gap-3 mt-4">
            <a class="btn-sd btn-sd--primary" href="<?= e($ctaUrl) ?>">ثبت درخواست برای این خدمت <i class="bi bi-arrow-left" aria-hidden="true"></i></a>
            <a class="btn-sd btn-sd--ghost" href="<?= e(route('services')) ?>">سایر خدمات</a>
          </div>
        </div>
        <aside class="svc-aside" aria-labelledby="who-title">
          <span class="icon-tile" aria-hidden="true"><i class="bi <?= e($svc['icon']) ?>"></i></span>
          <h2 id="who-title">این خدمت برای چه کسانی است؟</h2>
          <ul class="check-list mt-3">
            <?php foreach ($svc['for_whom'] as $w): ?><li><?= e($w) ?></li><?php endforeach; ?>
          </ul>
        </aside>
      </div>
    </div>
  </section>

  <section class="section" aria-labelledby="deliv-title">
    <div class="container">
      <div class="section-head">
        <span class="eyebrow">روش کار</span>
        <h2 id="deliv-title">در این خدمت چه چیزی دریافت می‌کنید؟</h2>
      </div>
      <div class="row g-3 g-lg-4">
        <?php foreach ($svc['deliverables'] as $n => $d): ?>
          <div class="col-12 col-md-6 col-lg-3">
            <div class="deliv reveal" data-delay="<?= e($n * 0.07) ?>">
              <span class="deliv__n"><?= e(fa_num(str_pad((string) ($n + 1), 2, '0', STR_PAD_LEFT))) ?></span>
              <h3><?= e($d[0]) ?></h3>
              <p><?= e($d[1]) ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="section section--alt" aria-labelledby="scen-title">
    <div class="container">
      <div class="section-head">
        <span class="eyebrow">سناریوهای رایج</span>
        <h2 id="scen-title">نمونه‌هایی از مسائلی که با این خدمت حل می‌شوند</h2>
      </div>
      <div class="row g-3">
        <?php foreach ($svc['scenarios'] as $s): ?>
          <div class="col-12 col-md-6"><div class="scenario reveal"><i class="bi bi-arrow-return-left" aria-hidden="true"></i><span><?= e($s) ?></span></div></div>
        <?php endforeach; ?>
      </div>
      <div class="notice notice--info mt-4">
        <i class="bi bi-info-circle" aria-hidden="true"></i>
        <p>دامنه، زمان و هزینهٔ هر پروژه پس از بررسی فنی و توافق مشخص می‌شود. پیش از آن، نتیجه یا زمان‌بندی قطعی تضمین نمی‌شود.</p>
      </div>
    </div>
  </section>

  <section class="section" aria-labelledby="proc-title">
    <div class="container">
      <div class="section-head">
        <span class="eyebrow">مسیر همکاری</span>
        <h2 id="proc-title">از درخواست تا اجرا چگونه پیش می‌رود؟</h2>
      </div>
      <?php component('process-steps'); ?>
    </div>
  </section>

  <section class="section section--alt" aria-labelledby="faq-title">
    <div class="container">
      <div class="row g-5">
        <div class="col-12 col-lg-4">
          <span class="eyebrow">پرسش‌های متداول</span>
          <h2 id="faq-title">دربارهٔ <?= e($svc['title']) ?></h2>
        </div>
        <div class="col-12 col-lg-8">
          <div class="faq" data-faq>
            <?php foreach ($svc['faqs'] as $n => $faq) { component('faq-item', ['faq' => $faq, 'id' => $service_key . '-' . ($n + 1)]); } ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="section" aria-labelledby="rel-title">
    <div class="container">
      <h2 id="rel-title" class="h4 mb-4">خدمات مرتبط</h2>
      <div class="row g-3 mb-5">
        <?php foreach ($svc['related'] as $rk): ?>
          <div class="col-12 col-md-4"><a class="related-link" href="<?= e(route($rk)) ?>"><span><?= e($all[$rk]['title']) ?></span><i class="bi bi-arrow-left" aria-hidden="true"></i></a></div>
        <?php endforeach; ?>
      </div>
      <?php component('cta-band', [
          'title' => 'درخواست خود را برای «' . $svc['title'] . '» ثبت کنید',
          'text'  => 'نیازتان را توضیح دهید تا مسیر مناسب برای اجرا یا بهبود آن را بررسی کنیم.',
          'label' => 'ثبت درخواست پروژه',
          'href'  => $ctaUrl,
      ]); ?>
    </div>
  </section>
</main>
<?php
require_once __DIR__ . '/footer.php';
require_once __DIR__ . '/scripts.php';
