(function ($) {
    'use strict';

    function initUserMultiSelect($element) {
        if ($element.data('user-multi-select-initialized')) {
            return;
        }

        $element.select2({
            dir: 'rtl',
            width: '100%',
            placeholder: $element.data('placeholder') || 'جستجوی کاربر...',
            allowClear: true,
            closeOnSelect: false,
            ajax: {
                url: $element.data('search-url'),
                dataType: 'json',
                delay: 300,
                data: function (params) {
                    return {
                        q: params.term || '',
                        page: params.page || 1,
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.data || [],
                        pagination: {
                            more: data.meta && data.meta.has_more,
                        },
                    };
                },
                cache: true,
            },
            language: {
                noResults: function () {
                    return 'کاربری یافت نشد';
                },
                searching: function () {
                    return 'در حال جستجو...';
                },
                loadingMore: function () {
                    return 'بارگذاری بیشتر...';
                },
            },
        });

        $element.data('user-multi-select-initialized', true);
    }

    $(function () {
        $('.admin-user-multi-select').each(function () {
            initUserMultiSelect($(this));
        });
    });

    window.initAdminUserMultiSelect = initUserMultiSelect;
})(jQuery);
