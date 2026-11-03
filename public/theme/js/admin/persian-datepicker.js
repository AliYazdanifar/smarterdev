(function ($) {
    'use strict';

    function initPersianDatepicker($input) {
        if ($input.data('persian-datepicker-initialized')) {
            return;
        }

        var plugin = $.fn.persianDatepicker || $.fn.pDatepicker;
        if (typeof plugin !== 'function') {
            return;
        }

        var withTime = String($input.data('time')) === '1';

        var displayFormat = withTime ? 'YYYY/MM/DD HH:mm' : 'YYYY/MM/DD';

        $input.persianDatepicker({
            format: displayFormat,
            formatter: function (unix) {
                return new persianDate(unix).toLocale('en').format(displayFormat);
            },
            initialValue: $input.val() !== '',
            initialValueType: 'persian',
            autoClose: true,
            altField: null,
            observer: true,
            persianDigit: false,
            calendarType: 'persian',
            timePicker: {
                enabled: withTime,
                second: {
                    enabled: false,
                },
            },
            toolbox: {
                calendarSwitch: {
                    enabled: false,
                },
            },
            calendar: {
                persian: {
                    locale: 'fa',
                    leapYearMode: 'algorithmic',
                },
            },
        });

        $input.data('persian-datepicker-initialized', true);
    }

    $(function () {
        $('.js-persian-datepicker').each(function () {
            initPersianDatepicker($(this));
        });
    });

    window.initAdminPersianDatepicker = initPersianDatepicker;
})(jQuery);
