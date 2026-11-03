<?php
/** Contact page. The form is a static demo (no submission). Laravel mapping: ContactController@store + @csrf. */
require_once __DIR__ . '/includes/bootstrap.php';
$c = site('contact');
$page = [
    'title'       => 'تماس با SmarterDev',
    'description' => 'راه‌های ارتباط با SmarterDev برای پرسش دربارهٔ پروژه‌های نرم‌افزار، هوش مصنوعی و اتوماسیون. برای درخواست مشخص، فرم ثبت پروژه را تکمیل کنید.',
    'route'       => 'contact',
    'css'         => ['pages/inner.css', 'pages/wizard.css'],
    'js'          => ['forms.js'],
    'breadcrumbs' => [['تماس', null]],
];
$req = '<span class="req" aria-hidden="true">*</span><span class="visually-hidden">(الزامی)</span>';
require_once __DIR__ . '/includes/head.php';
require_once __DIR__ . '/includes/header.php';
component('page-hero', ['page' => $page, 'eyebrow' => 'تماس', 'h1' => 'با ما در تماس باشید',
    'lead' => 'برای پرسش‌های کلی می‌توانید پیام بگذارید. اگر پروژه یا مشکل مشخصی دارید، ثبت درخواست پروژه سریع‌ترین مسیر برای بررسی دقیق است.',
    'actions' => [['ثبت درخواست پروژه', route('project-request')]]]);

$item = static function (string $icon, string $title, ?string $value, ?string $href = null, bool $ltr = false): void { ?>
  <div class="contact-item"><span class="icon-tile icon-tile--cyan" aria-hidden="true"><i class="bi <?= e($icon) ?>"></i></span>
    <div><h3><?= e($title) ?></h3>
      <?php if ($value): ?><?= $href ? '<a class="' . ($ltr ? 'ltr' : '') . '" href="' . e($href) . '">' . e($value) . '</a>' : '<p>' . e($value) . '</p>' ?>
      <?php else: ?><p class="is-placeholder">به‌زودی اضافه می‌شود</p><?php endif; ?>
    </div></div>
<?php };
?>
<main id="main">
  <section class="section"><div class="container">
    <div class="row g-4 g-lg-5">
      <div class="col-12 col-lg-5"><h2 class="visually-hidden">اطلاعات تماس</h2><div class="d-grid gap-3">
        <?php $item('bi-envelope', 'ایمیل', $c['email'] ?? null, !empty($c['email']) ? 'mailto:' . $c['email'] : null, true); ?>
        <?php $item('bi-telephone', 'تلفن', $c['phone'] ?? null, !empty($c['phone']) ? 'tel:' . $c['phone'] : null, true); ?>
        <?php $item('bi-send', 'پیام‌رسان', !empty($c['telegram']) ? 'ارسال پیام' : null, $c['telegram'] ?? null); ?>
        <?php $item('bi-clock', 'ساعات پاسخ‌گویی', $c['hours'] ?? null); ?>
        <?php $item('bi-geo-alt', 'نشانی', $c['address'] ?? null); ?>
        <p class="sd-hint">اطلاعات تماس در <span class="mono">config/site.php</span> تنظیم می‌شود.</p>
      </div></div>

      <div class="col-12 col-lg-7">
        <div class="surface">
          <h2 class="h4 mb-3">ارسال پیام</h2>
          <div class="notice mb-4"><i class="bi bi-exclamation-triangle" aria-hidden="true"></i><p><strong>نسخهٔ نمایشی:</strong> این فرم فقط اعتبارسنجی می‌شود و پیامی ارسال نخواهد شد.</p></div>
          <form action="#" method="post" novalidate data-demo-form>
            <div class="sd-field"><label class="sd-label" for="c-name">نام <?= $req ?></label>
              <input class="sd-input" id="c-name" name="name" type="text" autocomplete="name" required aria-describedby="c-name-error"><p class="field-error" id="c-name-error" hidden></p></div>
            <div class="sd-field"><label class="sd-label" for="c-contact">ایمیل یا شماره موبایل <?= $req ?></label>
              <input class="sd-input ltr" id="c-contact" name="contact" type="text" dir="ltr" autocomplete="email" required data-kind="contact" aria-describedby="c-contact-error"><p class="field-error" id="c-contact-error" hidden></p></div>
            <div class="sd-field"><label class="sd-label" for="c-msg">پیام <?= $req ?></label>
              <textarea class="sd-input" id="c-msg" name="message" rows="5" required data-min="10" aria-describedby="c-msg-error"></textarea><p class="field-error" id="c-msg-error" hidden></p></div>
            <button class="btn-sd btn-sd--primary" type="submit">ارسال پیام <i class="bi bi-arrow-left" aria-hidden="true"></i></button>
          </form>
          <div class="demo-success notice notice--info" data-demo-success hidden role="status">
            <i class="bi bi-info-circle" aria-hidden="true"></i>
            <p tabindex="-1" data-focus-target><strong>اعتبارسنجی موفق بود، اما این نسخهٔ نمایشی است.</strong> پیام شما ارسال یا ذخیره نشد.</p>
          </div>
        </div>
      </div>
    </div>
  </div></section>
</main>
<?php
require_once __DIR__ . '/includes/footer.php';
require_once __DIR__ . '/includes/scripts.php';
