<?php
/**
 * Project request: auth gate + 6-step wizard (static prototype).
 * - The wizard is client-side only (public/assets/js/wizard.js). NOTHING is sent or stored.
 * - Gate: "?entry=demo" simulates "already signed in". Laravel: replace with `auth` middleware + redirect()->intended().
 * - Options come from config/wizard.php. Laravel: FormRequest rules + @foreach over config('project_request.*').
 */
require_once __DIR__ . '/includes/bootstrap.php';
$W = require __DIR__ . '/config/wizard.php';

$entered = ($_GET['entry'] ?? '') === 'demo';

$page = [
    'title'       => 'ثبت درخواست پروژه',
    'description' => 'درخواست پروژهٔ نرم‌افزار، ایجنت هوش مصنوعی، اتوماسیون یا تعمیر پروژه را در چند مرحلهٔ ساده ثبت کنید تا نیاز شما بررسی شود.',
    'route'       => 'project-request',
    'css'         => ['pages/wizard.css'],
    'js'          => ['wizard.js'],
    'body_class'  => 'page-wizard',
    'mobile_cta'  => false,
    'breadcrumbs' => [['ثبت درخواست پروژه', null]],
];

$gateTag = $entered ? 'h2' : 'h1';
$wizTag  = $entered ? 'h1' : 'h2';
$stepLabels = ['دسته‌بندی', 'توضیح پروژه', 'محدوده', 'بودجه و زمان', 'اطلاعات تکمیلی', 'بررسی نهایی'];

/** Render a selectable choice (radio/checkbox) card. */
$choice = static function (string $name, string $value, string $title, string $hint = '', string $type = 'radio', string $icon = '', bool $card = false): string {
    $id = $name . '-' . $value;
    return '<label class="choice' . ($card ? ' choice--card' : '') . '" for="' . e($id) . '">'
        . '<input class="choice__input" type="' . e($type) . '" name="' . e($name) . '" id="' . e($id) . '" value="' . e($value) . '">'
        . '<span class="choice__body">'
        . ($icon ? '<span class="icon-tile" aria-hidden="true"><i class="bi ' . e($icon) . '"></i></span>' : '')
        . '<span class="choice__text"><span class="choice__title">' . e($title) . '</span>'
        . ($hint ? '<span class="choice__hint">' . e($hint) . '</span>' : '') . '</span></span></label>';
};
/** Error paragraph for a field/group id. */
$err = static fn (string $id): string => '<p class="field-error" id="' . e($id) . '-error" hidden></p>';
$req = '<span class="req" aria-hidden="true">*</span><span class="visually-hidden">(الزامی)</span>';
$opt = '<span class="opt">(اختیاری)</span>';

require_once __DIR__ . '/includes/head.php';
require_once __DIR__ . '/includes/header.php';
?>
<main id="main">
<div class="wiz-shell">
  <div class="container wiz-container">

    <!-- Step 0 · Authentication gate (prototype) -->
    <section class="gate surface" data-gate aria-labelledby="gate-title"<?= $entered ? ' hidden' : '' ?>>
      <span class="gate__icon" aria-hidden="true"><i class="bi bi-person-lock"></i></span>
      <<?= $gateTag ?> id="gate-title" class="h2">ثبت درخواست پروژه</<?= $gateTag ?>>
      <p>برای پیگیری وضعیت پروژه و گفت‌وگو دربارهٔ آن، به یک حساب کاربری نیاز دارید. پس از ورود، دوباره به فرم درخواست برمی‌گردید.</p>
      <ul class="check-list gate__benefits">
        <li>پیگیری وضعیت درخواست</li>
        <li>گفت‌وگو و ارسال اطلاعات تکمیلی</li>
        <li>دسترسی به تاریخچهٔ درخواست‌ها</li>
      </ul>
      <div class="gate__actions">
        <a class="btn-sd btn-sd--primary" href="<?= e(route('login', ['next' => 'project-request'])) ?>">ورود <i class="bi bi-box-arrow-in-left" aria-hidden="true"></i></a>
        <a class="btn-sd btn-sd--ghost" href="<?= e(route('register', ['next' => 'project-request'])) ?>">ایجاد حساب کاربری</a>
      </div>
      <div class="notice mt-4 text-start">
        <i class="bi bi-exclamation-triangle" aria-hidden="true"></i>
        <p><strong>نسخهٔ نمایشی:</strong> ورود و ثبت‌نام در این پیش‌نمایش استاتیک واقعی نیست. برای دیدن فرم می‌توانید به‌صورت نمایشی ادامه دهید.
          <a href="<?= e(route('project-request', ['entry' => 'demo'])) ?>">ادامه در حالت نمایشی</a></p>
      </div>
    </section>

    <!-- Wizard -->
    <section data-wizard-root aria-labelledby="wiz-title"<?= $entered ? '' : ' hidden' ?>>
      <div class="wiz-top">
        <div>
          <<?= $wizTag ?> id="wiz-title" class="h3 mb-1">ثبت درخواست پروژه</<?= $wizTag ?>>
          <p class="mb-0 small">در چند قدم کوتاه، نیازتان را توضیح دهید.</p>
        </div>
        <a class="btn-sd btn-sd--ghost btn-sd--sm" href="<?= e(route('home')) ?>"><i class="bi bi-x-lg" aria-hidden="true"></i>انصراف</a>
      </div>

      <div class="notice mb-4">
        <i class="bi bi-exclamation-triangle" aria-hidden="true"></i>
        <p><strong>حالت نمایشی:</strong> این فرم فقط در مرورگر شما کار می‌کند. هیچ اطلاعاتی ارسال، ذخیره یا ثبت نمی‌شود.</p>
      </div>

      <div class="wiz-card">
        <div class="wiz-progress" data-progress>
          <div class="wiz-progress__meta"><span>مرحلهٔ <strong data-cur>۱</strong> از <?= e(fa_num(count($stepLabels))) ?></span><span data-step-label><?= e($stepLabels[0]) ?></span></div>
          <div class="wiz-bar" role="progressbar" aria-label="پیشرفت فرم" aria-valuemin="1" aria-valuemax="<?= count($stepLabels) ?>" aria-valuenow="1"><span class="wiz-bar__fill"></span></div>
          <ol class="wiz-dots" aria-hidden="true">
            <?php foreach ($stepLabels as $i => $l): ?><li><span class="n"><span><?= e(fa_num($i + 1)) ?></span></span><?= e($l) ?></li><?php endforeach; ?>
          </ol>
        </div>

        <p class="visually-hidden" role="status" aria-live="polite" data-live></p>

        <form id="project-wizard" action="#" method="post" novalidate data-demo-only>
          <div class="notice wiz-error-summary" role="alert" data-error-summary hidden><i class="bi bi-exclamation-circle" aria-hidden="true"></i><p>لطفاً موارد مشخص‌شده را تکمیل کنید.</p></div>

          <!-- 1 · Category -->
          <section class="wiz-step" data-step data-label="<?= e($stepLabels[0]) ?>" aria-labelledby="s1-title">
            <div class="wiz-step__head"><h2 id="s1-title" tabindex="-1">پروژه شما در کدام دسته قرار می‌گیرد؟</h2><p>نزدیک‌ترین گزینه را انتخاب کنید؛ جزئیات را در مراحل بعد مشخص می‌کنیم.</p></div>
            <fieldset class="wiz-group" data-field data-label="دسته‌بندی" data-required-group="category" aria-describedby="category-error">
              <legend class="visually-hidden">دستهٔ پروژه <?= $req ?></legend>
              <div class="wiz-grid wiz-grid--cat">
                <?php foreach ($W['categories'] as $key => $c) { echo $choice('category', $key, $c['label'], $c['hint'], 'radio', $c['icon'], true); } ?>
              </div>
              <?= $err('category') ?>
            </fieldset>
          </section>

          <!-- 2 · Describe -->
          <section class="wiz-step" data-step data-label="<?= e($stepLabels[1]) ?>" aria-labelledby="s2-title" hidden>
            <div class="wiz-step__head"><h2 id="s2-title" tabindex="-1">پروژه را توضیح دهید</h2><p>لازم نیست فنی بنویسید؛ مسئله یا هدف را ساده توضیح دهید.</p></div>
            <div class="sd-field" data-field data-label="عنوان پروژه">
              <label class="sd-label" for="title">عنوان پروژه <?= $req ?></label>
              <input class="sd-input" id="title" name="title" type="text" autocomplete="off" required data-required data-min="5" aria-describedby="title-hint title-error" placeholder="مثلاً: دستیار پاسخ‌گویی به پرسش‌های مشتریان">
              <p class="sd-hint" id="title-hint">یک جملهٔ کوتاه که موضوع پروژه را روشن کند.</p><?= $err('title') ?>
            </div>
            <div class="sd-field" data-field data-label="مسئله یا نیاز کسب‌وکار">
              <label class="sd-label" for="description">مسئله یا نیاز کسب‌وکار <?= $req ?></label>
              <textarea class="sd-input" id="description" name="description" rows="5" required data-required data-min="30" aria-describedby="description-hint description-error"></textarea>
              <p class="sd-hint" id="description-hint">مثال: پیام‌های مشتریان از چند کانال می‌آید و تیم آن‌ها را به‌صورت دستی دسته‌بندی می‌کند.</p><?= $err('description') ?>
            </div>
            <div class="sd-field" data-field data-label="نتیجهٔ مورد انتظار">
              <label class="sd-label" for="outcome">نتیجهٔ مورد انتظار <?= $req ?></label>
              <textarea class="sd-input" id="outcome" name="outcome" rows="3" required data-required data-min="10" aria-describedby="outcome-hint outcome-error"></textarea>
              <p class="sd-hint" id="outcome-hint">مثال: پیام‌ها خودکار دسته‌بندی شوند و موارد فوری به مسئول مربوط ارجاع شود.</p><?= $err('outcome') ?>
            </div>
            <div class="sd-field" data-field data-label="نشانی وب‌سایت یا اپلیکیشن فعلی">
              <label class="sd-label" for="url">نشانی وب‌سایت یا اپلیکیشن فعلی <?= $opt ?></label>
              <input class="sd-input ltr" id="url" name="url" type="text" inputmode="url" dir="ltr" data-kind="url" aria-describedby="url-error" placeholder="example.com">
              <?= $err('url') ?>
            </div>
          </section>

          <!-- 3 · Scope (conditional) -->
          <section class="wiz-step" data-step data-label="<?= e($stepLabels[2]) ?>" aria-labelledby="s3-title" hidden>
            <div class="wiz-step__head"><h2 id="s3-title" tabindex="-1">محدوده و نیازمندی‌ها</h2><p>فقط سؤال‌هایی که به دستهٔ انتخابی شما مربوط‌اند نمایش داده می‌شوند.</p></div>

            <div class="wiz-cond" data-cats="software,ai-agent,automation,repair,api">
              <fieldset class="wiz-group" data-field data-label="شروع پروژه" data-required-group="start_type" aria-describedby="start_type-error">
                <legend>آیا پروژه از صفر شروع می‌شود یا سیستم موجودی دارید؟ <?= $req ?></legend>
                <div class="wiz-grid wiz-grid--3">
                  <?= $choice('start_type', 'scratch', 'از صفر') ?><?= $choice('start_type', 'existing', 'سیستم موجود دارم') ?><?= $choice('start_type', 'unsure', 'مطمئن نیستم') ?>
                </div><?= $err('start_type') ?>
              </fieldset>
            </div>

            <div class="wiz-cond" data-cats="software,other">
              <fieldset class="wiz-group" data-field data-label="طراحی رابط کاربری" data-required-group="ui_design" aria-describedby="ui_design-error">
                <legend>آیا طراحی رابط کاربری هم لازم است؟ <?= $req ?></legend>
                <div class="wiz-grid wiz-grid--3">
                  <?= $choice('ui_design', 'yes', 'بله، لازم است') ?><?= $choice('ui_design', 'no', 'خیر، طرح آماده دارم') ?><?= $choice('ui_design', 'unsure', 'نیاز به مشورت دارم') ?>
                </div><?= $err('ui_design') ?>
              </fieldset>
            </div>

            <div class="wiz-cond" data-cats="ai-agent,automation">
              <fieldset class="wiz-group" data-field data-label="اتصال به سرویس‌ها و ابزارها" data-required-group="tools_connect" aria-describedby="tools_connect-error">
                <legend>آیا هوش مصنوعی باید به سرویس‌ها یا ابزارهای دیگری متصل شود؟ <?= $req ?></legend>
                <div class="wiz-grid wiz-grid--3">
                  <?= $choice('tools_connect', 'yes', 'بله') ?><?= $choice('tools_connect', 'no', 'خیر') ?><?= $choice('tools_connect', 'unsure', 'هنوز مطمئن نیستم') ?>
                </div><?= $err('tools_connect') ?>
              </fieldset>
              <div class="sd-field" data-field data-label="ابزارها و سیستم‌های مرتبط">
                <label class="sd-label" for="tools_list">کدام ابزارها یا سیستم‌ها؟ <?= $opt ?></label>
                <input class="sd-input" id="tools_list" name="tools_list" type="text" placeholder="مثلاً: CRM، ایمیل، پیام‌رسان، پایگاه داده">
              </div>
            </div>

            <div class="wiz-cond" data-cats="repair,api,consulting">
              <fieldset class="wiz-group" data-field data-label="دسترسی‌های موجود">
                <legend>کدام موارد در اختیار شماست؟ <?= $opt ?></legend>
                <div class="wiz-grid wiz-grid--2">
                  <?= $choice('assets', 'code', 'کد منبع', '', 'checkbox') ?><?= $choice('assets', 'docs', 'مستندات', '', 'checkbox') ?>
                  <?= $choice('assets', 'server', 'دسترسی به سرور یا هاست', '', 'checkbox') ?><?= $choice('assets', 'none', 'هنوز هیچ‌کدام', '', 'checkbox') ?>
                </div>
              </fieldset>
            </div>

            <div class="wiz-cond" data-cats="repair">
              <div class="sd-field" data-field data-label="نشانه یا خطای مشاهده‌شده">
                <label class="sd-label" for="symptom">چه خطا یا نشانه‌ای مشاهده می‌کنید؟ <?= $opt ?></label>
                <textarea class="sd-input" id="symptom" name="symptom" rows="3" aria-describedby="symptom-hint"></textarea>
                <p class="sd-hint" id="symptom-hint">مثال: پس از بروزرسانی، صفحهٔ سفارش‌ها خطای ۵۰۰ می‌دهد.</p>
              </div>
            </div>

            <div class="wiz-cond" data-cats="api">
              <div class="sd-field" data-field data-label="سرویس‌ها یا APIهای درگیر">
                <label class="sd-label" for="api_services">کدام سرویس‌ها یا APIها درگیر هستند؟ <?= $opt ?></label>
                <input class="sd-input" id="api_services" name="api_services" type="text" placeholder="مثلاً: درگاه پرداخت، سرویس پیامک، ERP">
              </div>
            </div>

            <div class="wiz-cond" data-cats="consulting">
              <div class="sd-field" data-field data-label="تمرکز بررسی">
                <label class="sd-label" for="focus">تمرکز اصلی بررسی <?= $opt ?></label>
                <select class="sd-input" id="focus" name="focus">
                  <option value="">انتخاب کنید</option>
                  <option value="architecture">بازبینی معماری</option>
                  <option value="performance">کندی و عملکرد</option>
                  <option value="security">امنیت و وابستگی‌ها</option>
                  <option value="modernization">نوسازی سیستم قدیمی</option>
                  <option value="other">سایر</option>
                </select>
              </div>
            </div>

            <div class="wiz-cond" data-cats="other"><p class="wiz-empty">برای این دسته سؤال تکمیلی خاصی نداریم. اگر توضیح بیشتری لازم است، در مرحلهٔ «اطلاعات تکمیلی» بنویسید.</p></div>
          </section>

          <!-- 4 · Budget & timeline -->
          <section class="wiz-step" data-step data-label="<?= e($stepLabels[3]) ?>" aria-labelledby="s4-title" hidden>
            <div class="wiz-step__head"><h2 id="s4-title" tabindex="-1">بودجه و زمان‌بندی</h2><p>یک برآورد تقریبی کافی است. این مقادیر تعهدآور نیستند و فقط به بررسی دقیق‌تر کمک می‌کنند.</p></div>
            <fieldset class="wiz-group" data-field data-label="بازهٔ تقریبی بودجه" data-required-group="budget" aria-describedby="budget-error">
              <legend>بازهٔ تقریبی بودجه (تومان) <?= $req ?></legend>
              <div class="wiz-grid wiz-grid--2"><?php foreach ($W['budgets'] as $k => $label) { echo $choice('budget', $k, $label); } ?></div><?= $err('budget') ?>
            </fieldset>
            <fieldset class="wiz-group" data-field data-label="زمان مطلوب تکمیل" data-required-group="timeline" aria-describedby="timeline-error">
              <legend>زمان مطلوب تکمیل <?= $req ?></legend>
              <div class="wiz-grid wiz-grid--2"><?php foreach ($W['timelines'] as $k => $label) { echo $choice('timeline', $k, $label); } ?></div><?= $err('timeline') ?>
            </fieldset>
            <fieldset class="wiz-group" data-field data-label="میزان فوریت" data-required-group="urgency" aria-describedby="urgency-error">
              <legend>میزان فوریت <?= $req ?></legend>
              <div class="wiz-grid wiz-grid--3"><?php foreach ($W['urgency'] as $k => $u) { echo $choice('urgency', $k, $u['label'], $u['hint']); } ?></div><?= $err('urgency') ?>
            </fieldset>
          </section>

          <!-- 5 · Extras -->
          <section class="wiz-step" data-step data-label="<?= e($stepLabels[4]) ?>" aria-labelledby="s5-title" hidden>
            <div class="wiz-step__head"><h2 id="s5-title" tabindex="-1">اطلاعات تکمیلی</h2><p>هر چیزی که به درک بهتر پروژه کمک می‌کند.</p></div>
            <div class="sd-field" data-field data-label="پیوست">
              <span class="sd-label" id="attach-label">پیوست <?= $opt ?></span>
              <label class="attach position-relative" for="attachment">
                <i class="bi bi-paperclip" aria-hidden="true"></i>
                <span>انتخاب فایل (تصویر، سند یا مستندات)</span>
                <input id="attachment" name="attachment" type="file" multiple aria-describedby="attach-hint">
              </label>
              <ul class="attach__list" data-attach-list aria-live="polite"></ul>
              <p class="sd-hint" id="attach-hint">نمایشی: فایل‌ها بارگذاری یا ذخیره نمی‌شوند. در نسخهٔ نهایی بارگذاری امن فعال خواهد شد.</p>
            </div>
            <fieldset class="wiz-group" data-field data-label="روش ترجیحی ارتباط" data-required-group="contact_method" aria-describedby="contact_method-error">
              <legend>روش ترجیحی ارتباط <?= $req ?></legend>
              <div class="wiz-grid wiz-grid--3"><?php foreach ($W['contact_methods'] as $k => $label) { echo $choice('contact_method', $k, $label); } ?></div><?= $err('contact_method') ?>
            </fieldset>
            <div class="sd-field" data-field data-label="توضیحات بیشتر">
              <label class="sd-label" for="notes">توضیحات بیشتر <?= $opt ?></label>
              <textarea class="sd-input" id="notes" name="notes" rows="4"></textarea>
            </div>
          </section>

          <!-- 6 · Review -->
          <section class="wiz-step" data-step data-label="<?= e($stepLabels[5]) ?>" aria-labelledby="s6-title" hidden>
            <div class="wiz-step__head"><h2 id="s6-title" tabindex="-1">بررسی و تکمیل درخواست</h2><p>اطلاعات را مرور کنید. برای تغییر هر بخش، روی «ویرایش» بزنید.</p></div>
            <div class="review" data-review></div>
            <div class="sd-field mt-4" data-field>
              <label class="sd-check" for="consent"><input type="checkbox" id="consent" name="consent" data-consent-required aria-describedby="consent-error"><span>اطلاعات واردشده را بررسی کرده‌ام و با <a href="<?= e(route('privacy')) ?>" target="_blank" rel="noopener">سیاست حریم خصوصی</a> موافقم. <?= $req ?></span></label>
              <?= $err('consent') ?>
            </div>
          </section>

          <div class="wiz-nav">
            <button type="button" class="btn-sd btn-sd--ghost" data-prev hidden><i class="bi bi-arrow-right" aria-hidden="true"></i>مرحلهٔ قبل</button>
            <button type="button" class="btn-sd btn-sd--primary" data-next>مرحلهٔ بعد <i class="bi bi-arrow-left" aria-hidden="true"></i></button>
            <button type="submit" class="btn-sd btn-sd--primary" data-submit hidden>تکمیل درخواست <i class="bi bi-check2" aria-hidden="true"></i></button>
          </div>
        </form>

        <!-- Demo confirmation (never claims a real submission) -->
        <div class="wiz-done" data-done hidden role="status">
          <span class="wiz-done__icon" aria-hidden="true"><i class="bi bi-info-circle"></i></span>
          <h2 tabindex="-1" data-done-title>پایان نمایش آزمایشی فرم</h2>
          <p class="mx-auto wiz-done__text">این یک نمونهٔ استاتیک است؛ <strong>درخواست شما ثبت یا ارسال نشد</strong> و هیچ داده‌ای ذخیره نشده است. در نسخهٔ نهایی، این مرحله درخواست را روی سرور ثبت و برای بررسی ارسال می‌کند.</p>
          <div class="d-flex flex-wrap gap-3 justify-content-center mt-4">
            <button type="button" class="btn-sd btn-sd--ghost" data-back-to-review><i class="bi bi-pencil" aria-hidden="true"></i>بازگشت و ویرایش</button>
            <a class="btn-sd btn-sd--primary" href="<?= e(route('home')) ?>">بازگشت به صفحهٔ اصلی</a>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
</main>
<?php
require_once __DIR__ . '/includes/footer.php';
require_once __DIR__ . '/includes/scripts.php';
