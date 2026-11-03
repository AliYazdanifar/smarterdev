<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageController extends Controller
{
    public function home(): View
    {
        $services = sd_content('services');
        $projects = sd_content('projects');
        $faqs = $this->homeFaqs();
        $page = sd_page([
            'title' => 'SmarterDev | نرم‌افزار اختصاصی، ایجنت هوش مصنوعی و اتوماسیون',
            'raw_title' => true,
            'description' => 'توسعهٔ نرم‌افزار اختصاصی، ساخت ایجنت هوش مصنوعی، اتوماسیون کسب‌وکار و تعمیر پروژه‌های موجود. نیازتان را ثبت کنید تا بهترین مسیر اجرا را بررسی کنیم.',
            'route' => 'home',
            'css' => ['pages/home.css'],
            'body_class' => 'page-home',
            'schema' => [faq_schema($faqs)],
        ]);

        return view('shop.pages.home', compact('page', 'services', 'projects', 'faqs'));
    }

    public function services(): View
    {
        $services = sd_content('services');
        $page = sd_page([
            'title' => 'خدمات توسعه نرم‌افزار، هوش مصنوعی و اتوماسیون',
            'description' => 'فهرست خدمات SmarterDev: نرم‌افزار اختصاصی، ایجنت هوش مصنوعی، اتوماسیون کسب‌وکار، تعمیر پروژه، API، بک‌اند، وب‌سایت و مشاوره فنی.',
            'route' => 'services',
            'css' => ['pages/inner.css'],
            'breadcrumbs' => [['خدمات', null]],
        ]);

        return view('shop.pages.services', compact('page', 'services'));
    }

    public function service(string $serviceKey): View
    {
        $all = sd_content('services');
        if (! isset($all[$serviceKey])) {
            throw new NotFoundHttpException;
        }
        $svc = $all[$serviceKey];
        $ctaUrl = route('project-request', ['category' => $svc['category']]);
        $page = sd_page([
            'title' => $svc['meta_title'],
            'description' => $svc['meta_desc'],
            'route' => $serviceKey,
            'css' => ['pages/inner.css'],
            'body_class' => 'page-service',
            'breadcrumbs' => [['خدمات', 'services'], [$svc['title'], null]],
            'schema' => [
                [
                    '@context' => 'https://schema.org', '@type' => 'Service',
                    'name' => $svc['title'], 'description' => $svc['meta_desc'],
                    'url' => canonical_for($serviceKey), 'areaServed' => 'IR',
                    'provider' => ['@type' => 'ProfessionalService', 'name' => site('name'), 'url' => abs_url('')],
                ],
                faq_schema($svc['faqs']),
            ],
        ]);

        return view('shop.pages.service', compact('page', 'serviceKey', 'svc', 'all', 'ctaUrl'));
    }

    public function about(): View
    {
        $f = site('founder');
        $schema = [];
        if (! empty($f['name'])) {
            $schema[] = ['@context' => 'https://schema.org', '@type' => 'Person', 'name' => $f['name'], 'jobTitle' => 'توسعه‌دهندهٔ نرم‌افزار', 'worksFor' => ['@type' => 'Organization', 'name' => site('name'), 'url' => abs_url('')]];
        }
        $page = sd_page([
            'title' => 'درباره SmarterDev و بنیان‌گذار آن',
            'description' => 'آشنایی با SmarterDev و توسعه‌دهندهٔ پشت آن؛ تمرکز بر بک‌اند، PHP و لارavel، API، نرم‌افزار اختصاصی و اتوماسیون عملی با هوش مصنوعی.',
            'route' => 'about',
            'css' => ['pages/inner.css'],
            'breadcrumbs' => [['درباره', null]],
            'schema' => $schema,
        ]);

        return view('shop.pages.about', compact('page'));
    }

    public function portfolio(): View
    {
        $projects = sd_content('projects');
        $page = sd_page([
            'title' => 'نمونه‌کارها و مطالعات موردی',
            'description' => 'نمونه‌های مفهومی از راهکارهای SmarterDev: دستیار پشتیبانی هوشمند، داشبورد اتوماسیون، اپلیکیشن سفارش با لارavel و دستیار پردازش اسناد.',
            'route' => 'portfolio',
            'css' => ['pages/inner.css'],
            'breadcrumbs' => [['نمونه‌کارها', null]],
        ]);

        return view('shop.pages.portfolio', compact('page', 'projects'));
    }

    public function blog(): View
    {
        $posts = sd_content('posts');
        $page = sd_page([
            'title' => 'مقالات و یادداشت‌های فنی',
            'description' => 'یادداشت‌هایی دربارهٔ ایجنت‌های هوش مصنوعی، اتوماسیون کسب‌وکار، تعمیر و نگهداری نرم‌افزار و تصمیم‌های فنی برای صاحبان کسب‌وکار.',
            'route' => 'blog',
            'css' => ['pages/inner.css'],
            'breadcrumbs' => [['مقالات', null]],
        ]);

        return view('shop.pages.blog', compact('page', 'posts'));
    }

    public function blogPost(string $slug): View
    {
        $posts = sd_content('posts');
        if (! isset($posts[$slug])) {
            throw new NotFoundHttpException;
        }
        $post = $posts[$slug];
        $page = sd_page([
            'title' => $post['title'],
            'description' => $post['meta_desc'],
            'route' => 'blog-post',
            'route_query' => ['slug' => $slug],
            'og_type' => 'article',
            'css' => ['pages/inner.css'],
            'breadcrumbs' => [['مقالات', 'blog'], [$post['title'], null]],
            'schema' => [[
                '@context' => 'https://schema.org', '@type' => 'Article',
                'headline' => $post['title'], 'description' => $post['meta_desc'], 'inLanguage' => 'fa-IR',
                'datePublished' => $post['date'], 'dateModified' => $post['date'],
                'mainEntityOfPage' => canonical_for('blog-post', ['slug' => $slug]),
                'author' => ['@type' => 'Organization', 'name' => site('name'), 'url' => abs_url('')],
                'publisher' => ['@type' => 'Organization', 'name' => site('name'), 'url' => abs_url('')],
            ]],
        ]);

        return view('shop.pages.blog-post', compact('page', 'post', 'slug'));
    }

    public function contact(): View
    {
        $page = sd_page([
            'title' => 'تماس با SmarterDev',
            'description' => 'راه‌های ارتباط با SmarterDev برای پرسش دربارهٔ پروژه‌های نرم‌افزار، هوش مصنوعی و اتوماسیون. برای درخواست مشخص، فرم ثبت پروژه را تکمیل کنید.',
            'route' => 'contact',
            'css' => ['pages/inner.css', 'pages/wizard.css'],
            'js' => ['forms.js'],
            'breadcrumbs' => [['تماس', null]],
        ]);

        return view('shop.pages.contact', compact('page'));
    }

    public function projectRequest(Request $request): View
    {
        $entered = false;
        $wizard = config('project_request');
        $page = sd_page([
            'title' => 'ثبت درخواست پروژه',
            'description' => 'درخواست پروژهٔ نرم‌افزار، ایجنت هوش مصنوعی، اتوماسیون یا تعمیر پروژه را در چند مرحلهٔ ساده ثبت کنید تا نیاز شما بررسی شود.',
            'route' => 'project-request',
            'css' => ['pages/wizard.css'],
            'js' => ['auth.js', 'project-request-auth.js', 'wizard.js'],
            'body_class' => 'page-wizard',
            'mobile_cta' => false,
            'breadcrumbs' => [['ثبت درخواست پروژه', null]],
        ]);

        return view('shop.pages.project-request', compact('page', 'entered', 'wizard'));
    }

    public function login(): View
    {
        $page = sd_page([
            'title' => 'ورود به حساب کاربری',
            'description' => 'ورود به حساب کاربری SmarterDev برای پیگیری درخواست‌های پروژه.',
            'route' => 'login',
            'css' => ['pages/wizard.css'],
            'js' => [],
            'noindex' => true,
            'mobile_cta' => false,
            'breadcrumbs' => [['ورود به حساب کاربری', null]],
        ]);

        return view('shop.pages.login', compact('page'));
    }

    public function register(): View
    {
        $page = sd_page([
            'title' => 'ایجاد حساب کاربری',
            'description' => 'ایجاد حساب کاربری در SmarterDev برای ثبت و پیگیری درخواست پروژه.',
            'route' => 'register',
            'css' => ['pages/wizard.css'],
            'js' => [],
            'noindex' => true,
            'mobile_cta' => false,
            'breadcrumbs' => [['ایجاد حساب کاربری', null]],
        ]);

        return view('shop.pages.register', compact('page'));
    }

    public function privacy(): View
    {
        $page = sd_page([
            'title' => 'سیاست حریم خصوصی',
            'description' => 'سیاست حریم خصوصی SmarterDev: چه اطلاعاتی جمع‌آوری می‌شود، چگونه استفاده می‌شود و چگونه می‌توانید با ما در این باره تماس بگیرید.',
            'route' => 'privacy',
            'css' => ['pages/inner.css'],
            'breadcrumbs' => [['حریم خصوصی', null]],
        ]);

        return view('shop.pages.privacy', compact('page'));
    }

    public function notFound(): Response
    {
        $page = sd_page([
            'title' => 'صفحه پیدا نشد',
            'description' => 'صفحهٔ مورد نظر شما پیدا نشد. از لینک‌های زیر برای بازگشت به صفحهٔ اصلی یا مشاهدهٔ خدمات استفاده کنید.',
            'route' => '404',
            'css' => ['pages/inner.css'],
            'noindex' => true,
            'mobile_cta' => false,
        ]);

        return response()->view('shop.pages.not-found', compact('page'), 404);
    }

    /** @return list<array{0: string, 1: string}> */
    private function homeFaqs(): array
    {
        return [
            ['چه نوع پروژه‌هایی را می‌توانید انجام دهید؟', 'نرم‌افزار و پنل‌های اختصاصی، ایجنت‌های هوش مصنوعی، اتوماسیون و یکپارچه‌سازی سیستم‌ها، API، وب‌سایت و فروشگاه اینترنتی و همچنین تعمیر و توسعهٔ پروژه‌های موجود. اگر نیازتان در این دسته‌ها نمی‌گنجد، در فرم درخواست گزینهٔ «سایر موارد» را انتخاب کنید تا بررسی کنیم.'],
            ['آیا پروژه‌های نیمه‌کاره یا خراب را قبول می‌کنید؟', 'بله، پس از یک بررسی فنی. ابتدا وضعیت کد، دسترسی‌ها و مشکل را ارزیابی می‌کنیم و سپس گزینه‌های پیش رو (تعمیر، تکمیل یا بازسازی تدریجی) را همراه با زمان و هزینهٔ تخمینی توضیح می‌دهیم. پیش از بررسی نمی‌توان قول قطعی داد.'],
            ['برای ساخت ایجنت هوش مصنوعی چه اطلاعاتی لازم است؟', 'توضیح فرایندی که می‌خواهید خودکار شود، نمونه‌ای از ورودی‌ها و خروجی‌های مطلوب و فهرست ابزارها یا سیستم‌هایی که ایجنت باید با آن‌ها کار کند. اگر هنوز همه را مشخص نکرده‌اید، در بررسی اولیه کمکتان می‌کنیم.'],
            ['هزینهٔ اجرای پروژه چگونه مشخص می‌شود؟', 'هزینه بر اساس دامنهٔ کار، پیچیدگی فنی، زمان‌بندی و میزان یکپارچه‌سازی تعیین می‌شود. پس از بررسی درخواست، یک پیشنهاد روشن همراه با دامنهٔ کار ارائه می‌شود و تنها پس از توافق، کار آغاز می‌شود.'],
            ['آیا امکان همکاری روی پروژه‌های موجود وجود دارد؟', 'بله. می‌توانیم روی سیستم فعلی شما کار کنیم؛ از رفع خطا و بهینه‌سازی تا افزودن قابلیت جدید یا اتصال هوش مصنوعی و API.'],
            ['پس از ثبت درخواست چه اتفاقی می‌افتد؟', 'درخواست شما بررسی می‌شود، در صورت نیاز سؤال‌های تکمیلی پرسیده می‌شود و پس از آن پیشنهاد راهکار همراه با برآورد زمان و هزینه ارائه می‌شود.'],
            ['آیا پیش از شروع کار برآورد زمانی و مالی ارائه می‌شود؟', 'بله. پیش از شروع، دامنهٔ کار، زمان‌بندی تخمینی و هزینه با شما بررسی می‌شود تا بدون ابهام تصمیم بگیرید. برآورد نهایی پس از شناخت کامل نیازمندی‌ها قطعی می‌شود.'],
        ];
    }
}
