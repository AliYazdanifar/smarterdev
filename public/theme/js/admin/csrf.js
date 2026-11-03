(function () {
    var meta = document.querySelector('meta[name="csrf-token"]');
    if (!meta || !meta.content) {
        return;
    }

    if (window.jQuery) {
        window.jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': meta.content,
                'X-Requested-With': 'XMLHttpRequest',
            },
        });
    }

    // Back/forward cache can restore a page with a stale CSRF token after login/logout.
    window.addEventListener('pageshow', function (event) {
        if (event.persisted) {
            window.location.reload();
        }
    });
})();
