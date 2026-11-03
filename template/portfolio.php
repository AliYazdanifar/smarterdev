<?php
/** Portfolio / case studies. Entries: content/projects.php. Laravel mapping: pages/portfolio.blade.php */
require_once __DIR__ . '/includes/bootstrap.php';
$projects = content('projects');
$page = [
    'title'       => 'نمونه‌کارها و مطالعات موردی',
    'description' => 'نمونه‌های مفهومی از راهکارهای SmarterDev: دستیار پشتیبانی هوشمند، داشبورد اتوماسیون، اپلیکیشن سفارش با لاراول و دستیار پردازش اسناد.',
    'route'       => 'portfolio',
    'css'         => ['pages/inner.css'],
    'breadcrumbs' => [['نمونه‌کارها', null]],
];
require_once __DIR__ . '/includes/head.php';
require_once __DIR__ . '/includes/header.php';
component('page-hero', ['page' => $page, 'eyebrow' => 'نمونه‌کارها', 'h1' => 'نمونه‌کارها و مطالعات موردی',
    'lead' => 'در این بخش نمونه‌هایی مفهومی از نوع مسائل و راهکارها را می‌بینید. مطالعات موردی واقعی، پس از دریافت رضایت مشتریان، جایگزین این نمونه‌ها می‌شود.']);
?>
<main id="main">
  <section class="section"><div class="container">
    <h2 class="visually-hidden">فهرست نمونه‌ها</h2>
    <div class="notice mb-5"><i class="bi bi-lightbulb" aria-hidden="true"></i><p><strong>شفاف‌سازی:</strong> همهٔ موارد زیر «نمونهٔ مفهومی» با نام‌های فرضی‌اند و پروژهٔ تحویل‌شده به مشتری یا نتیجهٔ واقعی نیستند.</p></div>
    <div class="row g-4">
      <?php foreach ($projects as $n => $project): ?>
        <div class="col-12 col-md-6"><?php component('project-card', ['project' => $project, 'delay' => $n % 2 * 0.08]); ?></div>
      <?php endforeach; ?>
    </div>
  </div></section>
  <section class="section section--alt"><div class="container">
    <?php component('cta-band', ['title' => 'پروژهٔ شما می‌تواند نمونهٔ بعدی باشد', 'text' => 'مسئله‌تان را توضیح دهید تا بررسی کنیم کدام راهکار برایش مناسب است.', 'label' => 'ثبت درخواست پروژه', 'href' => route('project-request')]); ?>
  </div></section>
</main>
<?php
require_once __DIR__ . '/includes/footer.php';
require_once __DIR__ . '/includes/scripts.php';
