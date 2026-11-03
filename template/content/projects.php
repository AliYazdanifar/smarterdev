<?php
/**
 * Portfolio entries. ALL ENTRIES BELOW ARE CONCEPTUAL DEMONSTRATIONS (fictional names, no real client).
 * To publish a real case study: set 'demo' => false, replace the text, add 'client' / 'result' if verified.
 * Laravel mapping: App\Models\Project, @foreach($projects as $project) → <x-project-card :project="$project" />
 */
return [
    [
        'demo' => true, 'name' => 'پشتیبان‌یار', 'category' => 'ایجنت هوش مصنوعی', 'icon' => 'bi-chat-dots',
        'problem'  => 'تیم پشتیبانی بخش زیادی از زمانش را صرف پاسخ به پرسش‌های تکراری و مرتب‌کردن پیام‌ها می‌کند.',
        'solution' => 'دستیاری که پیام‌ها را دسته‌بندی می‌کند، از پایگاه دانش پاسخ پیشنهادی می‌سازد و موارد پیچیده را همراه با خلاصهٔ مکالمه به اپراتور می‌سپارد.',
        'tech' => ['LLM', 'RAG', 'Webhook', 'Laravel'],
    ],
    [
        'demo' => true, 'name' => 'جریان‌نگار', 'category' => 'اتوماسیون کسب‌وکار', 'icon' => 'bi-diagram-3',
        'problem'  => 'داده بین فرم‌ها، CRM و ایمیل دستی جابه‌جا می‌شود و کسی از وضعیت واقعی فرایند مطمئن نیست.',
        'solution' => 'داشبوردی که اتصال سیستم‌ها را نشان می‌دهد، اجرای هر گردش‌کار را ثبت می‌کند و خطاها را بلافاصله گزارش می‌دهد.',
        'tech' => ['REST API', 'Queue', 'Webhook', 'Laravel'],
    ],
    [
        'demo' => true, 'name' => 'سفارش‌یار', 'category' => 'نرم‌افزار اختصاصی', 'icon' => 'bi-box-seam',
        'problem'  => 'سفارش‌ها در فایل‌های اکسل و پیام‌رسان‌ها پراکنده است و پیگیری وضعیت هر سفارش دشوار است.',
        'solution' => 'اپلیکیشنی با نقش‌های کاربری، وضعیت سفارش، اعلان و گزارش‌گیری که با فرایند همان کسب‌وکار هم‌شکل شده است.',
        'tech' => ['Laravel', 'MySQL', 'Queue', 'Bootstrap'],
    ],
    [
        'demo' => true, 'name' => 'سندخوان', 'category' => 'پردازش اسناد', 'icon' => 'bi-file-earmark-text',
        'problem'  => 'اطلاعات فاکتورها و فرم‌ها دستی وارد سیستم می‌شود و هم زمان‌بر است هم دچار خطای انسانی.',
        'solution' => 'سیستمی که فیلدهای کلیدی را از سند استخراج و اعتبارسنجی می‌کند و موارد مشکوک را برای تأیید انسانی نشان می‌دهد.',
        'tech' => ['OCR', 'LLM', 'REST API', 'PHP'],
    ],
];
