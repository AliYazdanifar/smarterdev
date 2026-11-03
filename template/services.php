<?php
/** Services overview. Laravel mapping: pages/services.blade.php */
require_once __DIR__ . '/includes/bootstrap.php';
$services = content('services');

$page = [
    'title'       => 'خدمات توسعه نرم‌افزار، هوش مصنوعی و اتوماسیون',
    'description' => 'فهرست خدمات SmarterDev: نرم‌افزار اختصاصی، ایجنت هوش مصنوعی، اتوماسیون کسب‌وکار، تعمیر پروژه، API، بک‌اند، وب‌سایت و مشاوره فنی.',
    'route'       => 'services',
    'css'         => ['pages/inner.css'],
    'breadcrumbs' => [['خدمات', null]],
];
require_once __DIR__ . '/includes/head.php';
require_once __DIR__ . '/includes/header.php';

component('page-hero', [
    'page' => $page, 'eyebrow' => 'خدمات',
    'h1'   => 'خدمات توسعه نرم‌افزار، هوش مصنوعی و اتوماسیون',
    'lead' => 'از ساخت نرم‌افزار اختصاصی و ایجنت‌های هوش مصنوعی تا تعمیر پروژه‌های موجود و بازسازی معماری؛ هر خدمت با تمرکز بر نتیجهٔ کسب‌وکاری تعریف شده است.',
    'actions' => [['ثبت درخواست پروژه', route('project-request')]],
]);
?>
<main id="main">
  <section class="section">
    <div class="container">
      <h2 class="visually-hidden">فهرست خدمات</h2>
      <div class="row g-4">
        <?php $i = 0; foreach ($services as $key => $svc): ?>
          <div class="col-12 col-md-6 col-lg-4"><?php component('service-card', ['key' => $key, 'svc' => $svc, 'delay' => ($i++ % 3) * 0.08]); ?></div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <section class="section section--alt" aria-labelledby="pick-title">
    <div class="container">
      <div class="section-head"><h2 id="pick-title">مطمئن نیستید کدام خدمت مناسب شماست؟</h2>
        <p>مشکل یا هدفتان را در فرم درخواست توضیح دهید. در بررسی اولیه مشخص می‌کنیم کدام مسیر برای شما منطقی‌تر است؛ حتی اگر بخشی از آن نیاز به مشاوره داشته باشد.</p></div>
      <?php component('cta-band', ['title' => 'نیازتان را توضیح دهید، مسیر را با هم پیدا می‌کنیم', 'text' => 'ثبت درخواست چند دقیقه بیشتر زمان نمی‌برد و هیچ تعهدی ایجاد نمی‌کند.', 'label' => 'ثبت درخواست پروژه', 'href' => route('project-request')]); ?>
    </div>
  </section>
</main>
<?php
require_once __DIR__ . '/includes/footer.php';
require_once __DIR__ . '/includes/scripts.php';
