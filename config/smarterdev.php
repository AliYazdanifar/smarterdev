<?php

/**
 * SmarterDev public site configuration (static shop front).
 *
 * @see template/config/site.php
 */
return [
    'name' => 'SmarterDev',
    'tagline' => 'توسعه نرم‌افزار، هوش مصنوعی و اتوماسیون',
    'description' => 'SmarterDev راهکارهای نرم‌افزار اختصاصی، ایجنت هوش مصنوعی، اتوماسیون کسب‌وکار و تعمیر پروژه‌های نرم‌افزاری را متناسب با نیاز واقعی شما طراحی و اجرا می‌کند.',

    'og_image' => 'assets/images/og-default.png',
    'theme_color' => '#080B12',

    'contact' => [
        'email' => null,
        'phone' => null,
        'telegram' => null,
        'address' => null,
        'hours' => null,
    ],

    'social' => [],

    'founder' => [
        'name' => null,
        'role' => 'بنیان‌گذار SmarterDev · توسعه‌دهندهٔ نرم‌افزار',
        'bio' => [
            'من پشت SmarterDev هستم؛ توسعه‌دهنده‌ای که تمرکزش روی بک‌اند، PHP و لارavel، APIها، نرم‌افزار اختصاصی و اتوماسیون عملی با هوش مصنوعی است.',
            'باور دارم نرم‌افزار خوب از فهمیدن مسئله شروع می‌شود، نه از انتخاب فناوری. برای همین هر پروژه را با یک گفت‌وگوی روشن دربارهٔ نیاز واقعی، محدودیت‌ها و معیار موفقیت شروع می‌کنم.',
        ],
        'focus' => ['بک‌اند با PHP و لارavel', 'طراحی و اتصال API', 'نرم‌افزار اختصاصی و MVP', 'اتوماسیون عملی با هوش مصنوعی'],
    ],

    'nav' => [
        ['label' => 'خدمات', 'route' => 'services', 'icon' => 'bi-grid-1x2'],
        ['label' => 'فرایند کار', 'route' => 'home', 'hash' => 'process', 'icon' => 'bi-diagram-2'],
        ['label' => 'نمونه‌کارها', 'route' => 'portfolio', 'icon' => 'bi-kanban'],
        ['label' => 'درباره', 'route' => 'about', 'icon' => 'bi-person-badge'],
        ['label' => 'مقالات', 'route' => 'blog', 'icon' => 'bi-journal-text'],
    ],

    'footer_services' => [
        'service-custom-development',
        'service-ai-agents',
        'service-automation',
        'service-software-repair',
        'service-api',
        'service-consulting',
    ],
];
