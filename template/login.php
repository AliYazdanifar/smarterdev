<?php
/**
 * ورود به حساب کاربری — STATIC PROTOTYPE: no authentication happens, no credentials are sent or stored.
 * Laravel mapping: Fortify/Breeze view + redirect()->intended(route('project-request')).
 */
require_once __DIR__ . '/includes/bootstrap.php';
$mode = 'login';
$page = [
    'title'       => 'ورود به حساب کاربری',
    'description' => 'صفحهٔ نمایشی ورود به حساب کاربری SmarterDev برای پیگیری درخواست‌های پروژه.',
    'route'       => 'login',
    'css'         => ['pages/wizard.css'],
    'js'          => ['forms.js'],
    'noindex'     => true,
    'mobile_cta'  => false,
    'breadcrumbs' => [['ورود به حساب کاربری', null]],
];
$req = '<span class="req" aria-hidden="true">*</span><span class="visually-hidden">(الزامی)</span>';
require_once __DIR__ . '/includes/head.php';
require_once __DIR__ . '/includes/header.php';
?>
<main id="main">
  <div class="wiz-shell"><div class="container"><div class="auth-wrap">
    <div class="wiz-card">
      <h1>ورود به حساب کاربری</h1>
      <p>برای ثبت و پیگیری درخواست پروژه وارد شوید.</p>
      <div class="notice my-4"><i class="bi bi-exclamation-triangle" aria-hidden="true"></i><p><strong>نسخهٔ نمایشی:</strong> این صفحه ورود یا حساب واقعی ایجاد نمی‌کند. فقط ظاهر و اعتبارسنجی فرم را نشان می‌دهد.</p></div>
      <form action="#" method="post" novalidate data-demo-form>
        <div class="sd-field"><label class="sd-label" for="a-id">ایمیل یا شماره موبایل <?= $req ?></label>
          <input class="sd-input ltr" id="a-id" name="identifier" type="text" dir="ltr" autocomplete="username" required data-kind="contact" aria-describedby="a-id-error"><p class="field-error" id="a-id-error" hidden></p></div>
        <div class="sd-field"><label class="sd-label" for="a-pass">گذرواژه <?= $req ?></label>
          <input class="sd-input ltr" id="a-pass" name="password" type="password" dir="ltr" autocomplete="current-password" required aria-describedby="a-pass-error"><p class="field-error" id="a-pass-error" hidden></p></div>
        <button class="btn-sd btn-sd--primary btn-sd--block" type="submit">ورود <i class="bi bi-box-arrow-in-left" aria-hidden="true"></i></button>
      </form>
      <div class="demo-success notice notice--info" data-demo-success hidden role="status">
        <i class="bi bi-info-circle" aria-hidden="true"></i>
        <div><p tabindex="-1" data-focus-target><strong>اعتبارسنجی موفق بود؛ ورود واقعی انجام نشد.</strong></p>
          <a class="btn-sd btn-sd--primary btn-sd--sm mt-2" href="<?= e(route('project-request', ['entry' => 'demo'])) ?>">ادامه به ثبت درخواست (نمایشی)</a></div>
      </div>
      <p class="auth-alt">حساب ندارید؟ <a href="<?= e(route('register')) ?>">ایجاد حساب کاربری</a></p>
    </div>
  </div></div></div>
</main>
<?php
require_once __DIR__ . '/includes/footer.php';
require_once __DIR__ . '/includes/scripts.php';
