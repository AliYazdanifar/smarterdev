(function () {
    'use strict';

    function escapeHtml(value) {
        return String(value == null ? '' : value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function initAssignRoot(root) {
        var searchUrl = root.getAttribute('data-search-url');
        var modalSelector = root.getAttribute('data-modal') || '#assignSurveyFormModal';
        var modalEl = document.querySelector(modalSelector);
        if (!modalEl) {
            return;
        }

        var input = modalEl.querySelector('[data-survey-search]');
        var results = modalEl.querySelector('[data-survey-results]');
        var hiddenId = modalEl.querySelector('[name="survey_form_id"]');
        var selectedLabel = modalEl.querySelector('[data-survey-selected]');
        var numbersBox = modalEl.querySelector('[data-session-numbers]');
        var timer = null;

        function render(items) {
            if (!results) {
                return;
            }

            if (!items.length) {
                results.innerHTML = '<div class="list-group-item text-muted">فرمی یافت نشد.</div>';
                return;
            }

            results.innerHTML = items.map(function (form) {
                var selected = hiddenId && String(hiddenId.value) === String(form.id) ? ' active' : '';
                var meta = (form.questions_count || 0) + ' سوال';
                if (form.weight) {
                    meta += ' / وزن ' + form.weight;
                }

                return '<button type="button" class="list-group-item list-group-item-action' + selected + '"'
                    + ' data-form-id="' + form.id + '"'
                    + ' data-form-name="' + escapeHtml(form.name) + '">'
                    + '<div class="fw-bold">' + escapeHtml(form.name) + '</div>'
                    + '<div class="small text-muted">' + escapeHtml(form.description || meta) + '</div>'
                    + '</button>';
            }).join('');
        }

        function load(query) {
            if (!searchUrl) {
                return;
            }

            fetch(searchUrl + '?search=' + encodeURIComponent(query || ''), {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                credentials: 'same-origin',
            })
                .then(function (response) { return response.json(); })
                .then(function (json) { render(json.data || []); })
                .catch(function () {
                    if (results) {
                        results.innerHTML = '<div class="list-group-item text-danger">خطا در دریافت فرم‌ها.</div>';
                    }
                });
        }

        function syncScope() {
            if (!numbersBox) {
                return;
            }

            var selected = modalEl.querySelector('[data-session-scope]:checked');
            var show = selected && selected.value === 'selected';
            numbersBox.classList.toggle('d-none', !show);
        }

        if (input) {
            input.addEventListener('input', function () {
                clearTimeout(timer);
                timer = setTimeout(function () {
                    load(input.value.trim());
                }, 300);
            });
        }

        if (results) {
            results.addEventListener('click', function (event) {
                var button = event.target.closest('[data-form-id]');
                if (!button || !hiddenId) {
                    return;
                }

                hiddenId.value = button.getAttribute('data-form-id');
                if (selectedLabel) {
                    selectedLabel.textContent = button.getAttribute('data-form-name') || ('فرم #' + hiddenId.value);
                }

                results.querySelectorAll('[data-form-id]').forEach(function (el) {
                    el.classList.toggle('active', el === button);
                });
            });
        }

        modalEl.querySelectorAll('[data-session-scope]').forEach(function (radio) {
            radio.addEventListener('change', syncScope);
        });

        var selectAll = modalEl.querySelector('[data-select-all-sessions]');
        if (selectAll && numbersBox) {
            selectAll.addEventListener('click', function () {
                numbersBox.querySelectorAll('input[type="checkbox"]').forEach(function (box) {
                    box.checked = true;
                });
            });
        }

        modalEl.addEventListener('shown.bs.modal', function () {
            load(input ? input.value.trim() : '');
            syncScope();
            if (input) {
                input.focus();
            }
        });

        if (modalEl.querySelector('.alert-danger')) {
            var Modal = window.bootstrap && window.bootstrap.Modal;
            if (Modal) {
                Modal.getOrCreateInstance(modalEl).show();
            }
        }

        syncScope();
    }

    document.querySelectorAll('[data-survey-assign-root]').forEach(initAssignRoot);
})();
