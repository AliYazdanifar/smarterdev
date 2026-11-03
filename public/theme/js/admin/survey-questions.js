(function (window) {
    'use strict';

    function replaceIndex(root, index) {
        root.querySelectorAll('[name]').forEach(function (el) {
            el.name = el.name.split('__INDEX__').join(String(index));
        });
    }

    function updateAverage(container) {
        var maxInputs = container.querySelectorAll('.question-max-score');
        var sum = 0;
        var count = 0;

        maxInputs.forEach(function (input) {
            var value = parseFloat(input.value);
            if (!isNaN(value)) {
                sum += value;
                count += 1;
            }
        });

        var el = document.getElementById('survey-form-max-score');
        if (el) {
            el.textContent = count ? String(Math.round((sum / count) * 100) / 100) : '—';
        }
    }

    function renumber(container) {
        container.querySelectorAll('.survey-question-item').forEach(function (card, index) {
            var numberEl = card.querySelector('.question-number');
            if (numberEl) {
                numberEl.textContent = String(index + 1);
            }
        });
        updateAverage(container);
    }

    function fillCard(card, data) {
        if (!data) {
            return;
        }

        var idInput = card.querySelector('.question-id');
        var titleInput = card.querySelector('.question-title');
        var minInput = card.querySelector('.question-min-score');
        var maxInput = card.querySelector('.question-max-score');

        if (idInput) {
            idInput.value = data.id || '';
        }
        if (titleInput) {
            titleInput.value = data.title || '';
        }
        if (minInput && data.min_score !== undefined && data.min_score !== null) {
            minInput.value = data.min_score;
        }
        if (maxInput && data.max_score !== undefined && data.max_score !== null) {
            maxInput.value = data.max_score;
        }
    }

    window.initSurveyQuestions = function (options) {
        var container = options.container;
        var template = options.template;
        var addButton = options.addButton;
        var initial = options.initialQuestions || [];
        var nextIndex = 0;

        function bindCard(card) {
            var remove = card.querySelector('.remove-survey-question');
            if (remove) {
                remove.addEventListener('click', function () {
                    if (container.querySelectorAll('.survey-question-item').length <= 1) {
                        return;
                    }
                    card.remove();
                    renumber(container);
                });
            }

            ['question-min-score', 'question-max-score'].forEach(function (className) {
                var input = card.querySelector('.' + className);
                if (input) {
                    input.addEventListener('input', function () {
                        updateAverage(container);
                    });
                }
            });
        }

        function addQuestion(data) {
            var node = template.content.cloneNode(true);
            var card = node.querySelector('.survey-question-item');
            replaceIndex(card, nextIndex);
            nextIndex += 1;
            container.appendChild(card);
            fillCard(card, data);
            bindCard(card);
            renumber(container);
        }

        addButton.addEventListener('click', function () {
            addQuestion(null);
        });

        if (initial.length) {
            initial.forEach(function (item) {
                addQuestion(item);
            });
        } else {
            addQuestion(null);
        }
    };
})(window);
