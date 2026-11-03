<?php
/**
 * SmarterDev — central site configuration.
 * Laravel mapping: config/smarterdev.php + named routes (see README-BLADE.md).
 */
return [
    'name'        => 'SmarterDev',
    'tagline'     => 'توسعه نرم‌افزار، هوش مصنوعی و اتوماسیون',
    'description' => 'SmarterDev راهکارهای نرم‌افزار اختصاصی، ایجنت هوش مصنوعی، اتوماسیون کسب‌وکار و تعمیر پروژه‌های نرم‌افزاری را متناسب با نیاز واقعی شما طراحی و اجرا می‌کند.',

    // Production domain (used for canonical, Open Graph, sitemap, JSON-LD).
    'site_url'    => 'https://smarterdev.ir',
    // Prefix for internal links when the site is served from a sub-folder (e.g. '/smarterdev/', with trailing slash). Keep '/' for domain root.
    'base_path'   => '/',
    'assets_path' => 'public/assets/',
    'og_image'    => 'public/assets/images/og-default.png',
    'theme_color' => '#080B12',

    // Contact details. null = not provided yet -> a visible placeholder is rendered.
    'contact' => [
        'email'    => null,   // e.g. 'hello@smarterdev.ir'
        'phone'    => null,   // e.g. '۰۹۱۲۰۰۰۰۰۰۰'
        'telegram' => null,   // e.g. 'https://t.me/username'
        'address'  => null,
        'hours'    => null,
    ],

    // Social links: only real URLs. Empty array = nothing is rendered.
    // 'github' => 'https://github.com/...', 'linkedin' => '...', 'telegram' => '...'
    'social' => [],

    // Founder profile — only provided facts. null name = placeholder hint is shown.
    // Portrait: drop a file at public/assets/images/founder.jpg (also .jpeg/.webp/.png are detected).
    'founder' => [
        'name'  => null,
        'role'  => 'بنیان‌گذار SmarterDev · توسعه‌دهندهٔ نرم‌افزار',
        'bio'   => [
            'من پشت SmarterDev هستم؛ توسعه‌دهنده‌ای که تمرکزش روی بک‌اند، PHP و لاراول، APIها، نرم‌افزار اختصاصی و اتوماسیون عملی با هوش مصنوعی است.',
            'باور دارم نرم‌افزار خوب از فهمیدن مسئله شروع می‌شود، نه از انتخاب فناوری. برای همین هر پروژه را با یک گفت‌وگوی روشن دربارهٔ نیاز واقعی، محدودیت‌ها و معیار موفقیت شروع می‌کنم.',
        ],
        'focus' => ['بک‌اند با PHP و لاراول', 'طراحی و اتصال API', 'نرم‌افزار اختصاصی و MVP', 'اتوماسیون عملی با هوش مصنوعی'],
    ],

    // Route name => file. In Laravel replace with route('name').
    'routes' => [
        'home'                         => 'index.php',
        'services'                     => 'services.php',
        'service-custom-development'   => 'service-custom-development.php',
        'service-ai-agents'            => 'service-ai-agents.php',
        'service-automation'           => 'service-automation.php',
        'service-software-repair'      => 'service-software-repair.php',
        'service-api'                  => 'service-api.php',
        'service-backend'              => 'service-backend.php',
        'service-ai-integration'       => 'service-ai-integration.php',
        'service-web'                  => 'service-web.php',
        'service-consulting'           => 'service-consulting.php',
        'about'                        => 'about.php',
        'portfolio'                    => 'portfolio.php',
        'blog'                         => 'blog.php',
        'blog-post'                    => 'blog-post.php',
        'contact'                      => 'contact.php',
        'project-request'              => 'project-request.php',
        'login'                        => 'login.php',
        'register'                     => 'register.php',
        'privacy'                      => 'privacy.php',
        '404'                          => '404.php',
    ],

    // Main navigation. 'route' + optional 'hash'.
    'nav' => [
        ['label' => 'خدمات',          'route' => 'services', 'icon' => 'bi-grid-1x2'],
        ['label' => 'فرایند کار',     'route' => 'home', 'hash' => 'process', 'icon' => 'bi-diagram-2'],
        ['label' => 'نمونه‌کارها',    'route' => 'portfolio', 'icon' => 'bi-kanban'],
        ['label' => 'درباره',         'route' => 'about', 'icon' => 'bi-person-badge'],
        ['label' => 'مقالات',         'route' => 'blog', 'icon' => 'bi-journal-text'],
    ],

    // Footer service shortcuts (route names).
    'footer_services' => [
        'service-custom-development', 'service-ai-agents', 'service-automation',
        'service-software-repair', 'service-api', 'service-consulting',
    ],
];
