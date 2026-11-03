(function () {
    const SHORT_TEXT = 'short_text';
    const TRUE_FALSE = 'true_false';

    function reindexOptions(container) {
        const items = container.querySelectorAll('.quiz-option-item');
        items.forEach((item, index) => {
            item.querySelectorAll('[name]').forEach((input) => {
                input.name = input.name.replace(/options\[\d+]/, 'options[' + index + ']');
            });
        });
    }

    function addOption(container, template, data) {
        const html = template.innerHTML.replace(/__INDEX__/g, String(container.children.length));
        const wrapper = document.createElement('div');
        wrapper.innerHTML = html.trim();
        const item = wrapper.firstElementChild;
        container.appendChild(item);

        if (data) {
            const idInput = item.querySelector('.option-id');
            const labelInput = item.querySelector('.option-label');
            const correctInput = item.querySelector('.option-correct');
            if (idInput && data.id) {
                idInput.value = data.id;
            }
            if (labelInput && data.label) {
                labelInput.value = data.label;
            }
            if (correctInput && data.is_correct) {
                correctInput.checked = true;
            }
        }

        item.querySelector('.remove-quiz-option')?.addEventListener('click', function () {
            item.remove();
            reindexOptions(container);
        });

        reindexOptions(container);
    }

    function toggleOptionsSection(typeSelect, optionsSection) {
        const isShortText = typeSelect.value === SHORT_TEXT;
        optionsSection.style.display = isShortText ? 'none' : '';
    }

    function seedTrueFalseIfNeeded(typeSelect, container, template) {
        if (typeSelect.value !== TRUE_FALSE || container.children.length > 0) {
            return;
        }
        addOption(container, template, { label: 'درست', is_correct: true });
        addOption(container, template, { label: 'نادرست', is_correct: false });
    }

    window.initPlacementQuizQuestionForm = function (config) {
        const {
            typeSelect,
            optionsSection,
            optionsContainer,
            optionTemplate,
            addOptionButton,
            addAttachmentButton,
            attachmentInputs,
            initialOptions = [],
        } = config;

        toggleOptionsSection(typeSelect, optionsSection);

        if (initialOptions.length > 0) {
            initialOptions.forEach((option) => addOption(optionsContainer, optionTemplate, option));
        } else {
            seedTrueFalseIfNeeded(typeSelect, optionsContainer, optionTemplate);
            if (optionsContainer.children.length === 0) {
                addOption(optionsContainer, optionTemplate, null);
                addOption(optionsContainer, optionTemplate, null);
            }
        }

        typeSelect.addEventListener('change', function () {
            toggleOptionsSection(typeSelect, optionsSection);
            if (typeSelect.value === TRUE_FALSE && optionsContainer.children.length === 0) {
                seedTrueFalseIfNeeded(typeSelect, optionsContainer, optionTemplate);
            }
        });

        addOptionButton.addEventListener('click', function () {
            addOption(optionsContainer, optionTemplate, null);
        });

        addAttachmentButton.addEventListener('click', function () {
            const input = document.createElement('input');
            input.type = 'file';
            input.name = 'attachments[]';
            input.className = 'form-control attachment-input';
            attachmentInputs.appendChild(input);
        });
    };
})();
