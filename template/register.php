<?php
/**
 * ایجاد حساب کاربری — STATIC PROTOTYPE: no authentication happens, no credentials are sent or stored.
 * Laravel mapping: Fortify/Breeze view + redirect()->intended(route('project-request')).
 */
require_once __DIR__ . '/includes/bootstrap.php';
$mode = 'register';
$page = [
    'title'       => 'ایجاد حساب کاربری',
    'description' => 'صفحهٔ نمایشی ایجاد حساب کاربری در SmarterDev برای ثبت و پیگیری درخواست پروژه.',
    'route'       => 'register',
    'css'         => ['pages/wizard.css'],
    'js'          => ['forms.js'],
    'noindex'     => true,
    'mobile_cta'  => false,
    'breadcrumbs' => [['ایجاد حساب کاربری', null]],
];
$req = '<span class="req" aria-hidden="true">*</span><span class="visually-hidden">(الزامی)</span>';
require_once __DIR__ . '/includes/head.php';
require_once __DIR__ . '/includes/header.php';
?>
<main id="main">
  <div class="wiz-shell"><div class="container"><div class="auth-wrap">
    <div class="wiz-card">
      <h1>ایجاد حساب کاربری</h1>
      <p>با یک حساب کاربری می‌توانید درخواست‌های خود را ثبت و پیگیری کنید.</p>
      <div class="notice my-4"><i class="bi bi-exclamation-triangle" aria-hidden="true"></i><p><strong>نسخهٔ نمایشی:</strong> این صفحه ورود یا حساب واقعی ایجاد نمی‌کند. فقط ظاهر و اعتبارسنجی فرم را نشان می‌دهد.</p></div>
      <form action="#" method="post" novalidate data-demo-form>
        <div class="sd-field"><label class="sd-label" for="r-name">نام و نام خانوادگی <?= $req ?></label>
          <input class="sd-input" id="r-name" name="name" type="text" autocomplete="name" required aria-describedby="r-name-error"><p class="field-error" id="r-name-error" hidden></p></div>
        <div class="sd-field"><label class="sd-label" for="r-id">ایمیل یا شماره موبایل <?= $req ?></label>
          <input class="sd-input ltr" id="r-id" name="identifier" type="text" dir="ltr" autocomplete="username" required data-kind="contact" aria-describedby="r-id-error"><p class="field-error" id="r-id-error" hidden></p></div>
        <div class="sd-field"><label class="sd-label" for="r-pass">گذرواژه <?= $req ?></label>
          <input class="sd-input ltr" id="r-pass" name="password" type="password" dir="ltr" autocomplete="new-password" required data-min="8" aria-describedby="r-pass-hint r-pass-error"><p class="sd-hint" id="r-pass-hint">حداقل ۸ نویسه.</p><p class="field-error" id="r-pass-error" hidden></p></div>
        <div class="sd-field"><label class="sd-label" for="r-pass2">تکرار گذرواژه <?= $req ?></label>
          <input class="sd-input ltr" id="r-pass2" name="password_confirmation" type="password" dir="ltr" autocomplete="new-password" required data-match="#r-pass" aria-describedby="r-pass2-error"><p class="field-error" id="r-pass2-error" hidden></p></div>
        <div class="sd-field"><label class="sd-check" for="r-consent"><input type="checkbox" id="r-consent" data-consent aria-describedby="r-consent-error"><span>با <a href="<?= e(route('privacy')) ?>" target="_blank" rel="noopener">سیاست حریم خصوصی</a> موافقم. <?= $req ?></span></label><p class="field-error" id="r-consent-error" hidden></p></div>
        <button class="btn-sd btn-sd--primary btn-sd--block" type="submit">ایجاد حساب <i class="bi bi-person-plus" aria-hidden="true"></i></button>
      </form>
      <div class="demo-success notice notice--info" data-demo-success hidden role="status">
        <i class="bi bi-info-circle" aria-hidden="true"></i>
        <div><p tabindex="-1" data-focus-target><strong>اعتبارسنجی موفق بود؛ حسابی ساخته نشد.</strong></p>
          <a class="btn-sd btn-sd--primary btn-sd--sm mt-2" href="<?= e(route('project-request', ['entry' => 'demo'])) ?>">ادامه به ثبت درخواست (نمایشی)</a></div>
      </div>
      <p class="auth-alt">حساب دارید؟ <a href="<?= e(route('login')) ?>">ورود</a></p>
    </div>
  </div></div></div>
</main>
<?php
require_once __DIR__ . '/includes/footer.php';
require_once __DIR__ . '/includes/scripts.php';
