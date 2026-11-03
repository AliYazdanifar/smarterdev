<?php
/** Custom 404. Laravel mapping: resources/views/errors/404.blade.php */
require_once __DIR__ . '/includes/bootstrap.php';
http_response_code(404);
$page = [
    'title'       => 'صفحه پیدا نشد',
    'description' => 'صفحهٔ مورد نظر شما پیدا نشد. از لینک‌های زیر برای بازگشت به صفحهٔ اصلی یا مشاهدهٔ خدمات استفاده کنید.',
    'route'       => '404',
    'css'         => ['pages/inner.css'],
    'noindex'     => true,
    'mobile_cta'  => false,
];
require_once __DIR__ . '/includes/head.php';
require_once __DIR__ . '/includes/header.php';
?>
<main id="main">
  <div class="container nf">
    <div class="nf__code" aria-hidden="true">404</div>
    <h1 class="h2">صفحه‌ای که دنبالش بودید پیدا نشد</h1>
    <p>ممکن است نشانی تغییر کرده یا اشتباه تایپ شده باشد. از یکی از مسیرهای زیر ادامه دهید.</p>
    <div class="d-flex flex-wrap gap-3 justify-content-center">
      <a class="btn-sd btn-sd--primary" href="<?= e(route('home')) ?>">بازگشت به صفحهٔ اصلی</a>
      <a class="btn-sd btn-sd--ghost" href="<?= e(route('services')) ?>">مشاهدهٔ خدمات</a>
      <a class="btn-sd btn-sd--ghost" href="<?= e(route('contact')) ?>">تماس</a>
    </div>
  </div>
</main>
<?php
require_once __DIR__ . '/includes/footer.php';
require_once __DIR__ . '/includes/scripts.php';
