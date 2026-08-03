(function () {
    'use strict';

    function toggleContactFAQ(question) {
        const currentItem = question.closest('.faq-item');
        const currentAnswer = currentItem ? currentItem.querySelector('.faq-answer') : null;
        if (!currentItem || !currentAnswer) return;

        const shouldOpen = question.getAttribute('aria-expanded') !== 'true';

        document.querySelectorAll('#page-contact .faq-item').forEach((item) => {
            const itemQuestion = item.querySelector('.faq-question');
            const itemAnswer = item.querySelector('.faq-answer');
            const itemIcon = itemQuestion ? itemQuestion.querySelector('span') : null;

            if (itemQuestion) itemQuestion.setAttribute('aria-expanded', 'false');
            if (itemIcon) itemIcon.textContent = '+';
            if (itemAnswer) {
                itemAnswer.style.display = 'none';
                itemAnswer.style.maxHeight = '0';
            }
        });

        if (shouldOpen) {
            const icon = question.querySelector('span');
            question.setAttribute('aria-expanded', 'true');
            if (icon) icon.textContent = '−';
            currentAnswer.style.display = 'block';
            currentAnswer.style.maxHeight = currentAnswer.scrollHeight + 'px';
        }
    }

    document.addEventListener('click', function (event) {
        if (!(event.target instanceof Element)) return;
        const question = event.target.closest('#page-contact .faq-question');
        if (!question) return;
        event.preventDefault();
        event.stopImmediatePropagation();
        toggleContactFAQ(question);
    }, true);

    document.addEventListener('keydown', function (event) {
        if (!(event.target instanceof Element)) return;
        const question = event.target.closest('#page-contact .faq-question');
        if (!question || (event.key !== 'Enter' && event.key !== ' ')) return;
        event.preventDefault();
        event.stopImmediatePropagation();
        toggleContactFAQ(question);
    }, true);
}());
