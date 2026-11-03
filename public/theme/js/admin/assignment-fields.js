(function (window) {
    'use strict';

    function replaceIndex(root, index) {
        root.querySelectorAll('[name]').forEach(function (el) {
            el.name = el.name.split('__INDEX__').join(String(index));
        });
    }

    function toggleSettings(card, type, settingMap) {
        var keys = settingMap[type] || [];

        card.querySelectorAll('[data-setting]').forEach(function (el) {
            var setting = el.getAttribute('data-setting');
            var visible = keys.indexOf(setting) !== -1;
            el.classList.toggle('d-none', !visible);

            if (!visible) {
                el.querySelectorAll('input, select, textarea').forEach(function (input) {
                    input.disabled = true;
                });
            } else {
                el.querySelectorAll('input, select, textarea').forEach(function (input) {
                    input.disabled = false;
                });
            }
        });
    }

    function renumber(container) {
        container.querySelectorAll('.assignment-field-item').forEach(function (card, index) {
            var numberEl = card.querySelector('.field-number');
            if (numberEl) {
                numberEl.textContent = String(index + 1);
            }
        });
    }

    function fillCard(card, field) {
        if (!field) {
            return;
        }

        var settings = field.settings || {};
        var idInput = card.querySelector('.field-id');
        var typeInput = card.querySelector('.field-type');
        var labelInput = card.querySelector('.field-label');
        var nameInput = card.querySelector('.field-name');
        var requiredInput = card.querySelector('.field-required');

        if (idInput) {
            idInput.value = field.id || '';
        }
        if (typeInput && field.type) {
            typeInput.value = field.type;
        }
        if (labelInput) {
            labelInput.value = field.label || '';
        }
        if (nameInput) {
            nameInput.value = field.name || '';
        }
        if (requiredInput) {
            requiredInput.checked = field.is_required === true || field.is_required === 1 || field.is_required === '1';
        }

        var map = {
            '.field-placeholder': settings.placeholder,
            '.field-min-length': settings.min_length,
            '.field-max-length': settings.max_length,
            '.field-min': settings.min,
            '.field-max': settings.max,
            '.field-extensions': settings.allowed_extensions,
            '.field-max-size': settings.max_size_mb,
        };

        Object.keys(map).forEach(function (selector) {
            var input = card.querySelector(selector);
            if (input && map[selector] !== undefined && map[selector] !== null) {
                input.value = map[selector];
            }
        });
    }

    window.initAssignmentFields = function (options) {
        var container = options.container;
        var template = options.template;
        var addButton = options.addButton;
        var settingMap = options.settingMap || {};
        var initialFields = Array.isArray(options.initialFields) ? options.initialFields : [];
        var nextIndex = 0;

        if (!container || !template) {
            return;
        }

        function addField(field) {
            var fragment = template.content.cloneNode(true);
            var card = fragment.querySelector('.assignment-field-item');
            if (!card) {
                return;
            }

            replaceIndex(card, nextIndex);
            nextIndex += 1;

            var typeSelect = card.querySelector('.field-type');
            if (typeSelect) {
                typeSelect.addEventListener('change', function () {
                    toggleSettings(card, typeSelect.value, settingMap);
                });
            }

            var removeBtn = card.querySelector('.remove-assignment-field');
            if (removeBtn) {
                removeBtn.addEventListener('click', function () {
                    card.remove();
                    renumber(container);
                });
            }

            fillCard(card, field);
            toggleSettings(card, (typeSelect && typeSelect.value) || '', settingMap);
            container.appendChild(card);
            renumber(container);
        }

        if (addButton) {
            addButton.addEventListener('click', function () {
                addField(null);
            });
        }

        if (initialFields.length) {
            initialFields.forEach(function (field) {
                addField(field);
            });
        }
    };
})(window);
