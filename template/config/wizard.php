<?php
/**
 * Project-request wizard options. Edit here; the markup is rendered from this file.
 * Laravel mapping: config/project_request.php + FormRequest rules (see README-BLADE.md).
 * Budget ranges are the *client's* budget brackets, not SmarterDev price lists.
 */
return [
    'categories' => [
        'software'   => ['label' => 'توسعه نرم‌افزار',            'icon' => 'bi-code-slash',      'hint' => 'اپلیکیشن، پلتفرم، MVP یا پنل مدیریت'],
        'ai-agent'   => ['label' => 'ایجنت هوش مصنوعی',          'icon' => 'bi-robot',           'hint' => 'دستیار هوشمند، RAG، فراخوانی ابزار'],
        'automation' => ['label' => 'اتوماسیون کسب‌وکار',        'icon' => 'bi-diagram-3',       'hint' => 'حذف کارهای تکراری و اتصال ابزارها'],
        'repair'     => ['label' => 'تعمیر یا توسعه پروژه موجود', 'icon' => 'bi-tools',           'hint' => 'رفع خطا، کندی، پروژه نیمه‌کاره یا به‌ارث‌رسیده'],
        'api'        => ['label' => 'API و یکپارچه‌سازی',          'icon' => 'bi-plug',            'hint' => 'طراحی API و اتصال سرویس‌ها'],
        'consulting' => ['label' => 'مشاوره فنی',                  'icon' => 'bi-clipboard-data',  'hint' => 'ممیزی فنی و بازبینی معماری'],
        'other'      => ['label' => 'سایر موارد',                  'icon' => 'bi-three-dots',      'hint' => 'نیازی که در دسته‌های بالا نمی‌گنجد'],
    ],

    // Budget brackets (تومان). Edit freely.
    'budgets' => [
        'unsure' => 'هنوز مطمئن نیستم',
        'b1'     => 'تا ۱۰ میلیون تومان',
        'b2'     => '۱۰ تا ۳۰ میلیون تومان',
        'b3'     => '۳۰ تا ۸۰ میلیون تومان',
        'b4'     => '۸۰ تا ۲۰۰ میلیون تومان',
        'b5'     => 'بیش از ۲۰۰ میلیون تومان',
    ],

    'timelines' => [
        't1' => 'کمتر از ۲ هفته',
        't2' => 'حدود ۱ ماه',
        't3' => '۲ تا ۳ ماه',
        't4' => 'بیش از ۳ ماه',
        't0' => 'زمان‌بندی انعطاف‌پذیر است',
    ],

    'urgency' => [
        'low'    => ['label' => 'عادی',          'hint' => 'برنامه‌ریزی بلندمدت'],
        'medium' => ['label' => 'مهم',           'hint' => 'در چند هفته آینده'],
        'high'   => ['label' => 'فوری',          'hint' => 'کسب‌وکار تحت تأثیر است'],
    ],

    'contact_methods' => [
        'phone'    => 'تماس تلفنی',
        'messenger'=> 'پیام‌رسان',
        'email'    => 'ایمیل',
    ],
];
