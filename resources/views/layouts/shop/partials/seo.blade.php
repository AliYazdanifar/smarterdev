@php
    $seoTitle = $page['full_title'];
    $seoDesc = $page['description'];
    $seoUrl = $page['canonical'];
    $ogImage = abs_url(site('og_image'));
    $robots = ! empty($page['noindex']) ? 'noindex, follow' : 'index, follow, max-image-preview:large';

    $graph = [
        [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => site('name'),
            'url' => abs_url(''),
            'inLanguage' => 'fa-IR',
        ],
        [
            '@context' => 'https://schema.org',
            '@type' => 'ProfessionalService',
            'name' => site('name'),
            'url' => abs_url(''),
            'description' => site('description'),
            'areaServed' => 'IR',
            'knowsLanguage' => 'fa',
            'serviceType' => ['توسعه نرم‌افزار اختصاصی', 'ساخت ایجنت هوش مصنوعی', 'اتوماسیون کسب‌وکار', 'تعمیر و نگهداری نرم‌افزار'],
        ],
    ];
    if (! empty($page['breadcrumbs'])) {
        $items = [['label' => 'خانه', 'route' => 'home']];
        foreach ($page['breadcrumbs'] as $crumb) {
            $items[] = ['label' => $crumb[0], 'route' => $crumb[1] ?? null, 'query' => $crumb[2] ?? []];
        }
        $list = [];
        foreach ($items as $i => $it) {
            $entry = ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $it['label']];
            $entry['item'] = $it['route'] ? canonical_for($it['route'], $it['query'] ?? []) : $seoUrl;
            $list[] = $entry;
        }
        $graph[] = ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $list];
    }
    foreach (($page['schema'] ?? []) as $extra) {
        $graph[] = $extra;
    }
    if ($page['route'] !== 'home') {
        $graph = array_slice($graph, 2);
        if (($page['route'] ?? '') !== '404') {
            array_unshift($graph, [
                '@context' => 'https://schema.org', '@type' => 'WebSite', 'name' => site('name'), 'url' => abs_url(''), 'inLanguage' => 'fa-IR',
            ]);
        }
    }
@endphp
<meta name="description" content="{{ $seoDesc }}">
<meta name="robots" content="{{ $robots }}">
<link rel="canonical" href="{{ $seoUrl }}">
<meta property="og:locale" content="fa_IR">
<meta property="og:site_name" content="{{ site('name') }}">
<meta property="og:type" content="{{ $page['og_type'] ?? 'website' }}">
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:description" content="{{ $seoDesc }}">
<meta property="og:url" content="{{ $seoUrl }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoTitle }}">
<meta name="twitter:description" content="{{ $seoDesc }}">
<meta name="twitter:image" content="{{ $ogImage }}">
@foreach ($graph as $node)
<script type="application/ld+json">
{!! json_ld($node) !!}
</script>
@endforeach
