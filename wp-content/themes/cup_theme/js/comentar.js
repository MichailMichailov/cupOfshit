document.addEventListener('DOMContentLoaded', function () {
    const items = document.querySelectorAll('.id_report_post_item');

    items.forEach(item => {
        item.style.position = 'relative'; // Нужно для абсолютного позиционирования overlay

        item.addEventListener('mouseenter', () => {
            const overlay = document.createElement('div');
            overlay.classList.add('overlay-comment');
            const text = item.querySelector('.tooltip-text')
            if (!text || text.innerHTML.trim().length==0) return;
            overlay.textContent = text.innerHTML;
            overlay.dataset.overlay = 'true'; // чтобы было проще находить

            item.appendChild(overlay);
        });

        item.addEventListener('mouseleave', () => {
            const overlay = item.querySelector('[data-overlay="true"]');
            if (overlay) {
                overlay.remove();
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const elements = document.querySelectorAll('.f.fac.gap8.list_item');

    elements.forEach(el => {
        el.style.position = 'relative';

        el.addEventListener('mouseenter', () => {
            const rect = el.getBoundingClientRect();
            const windowHeight = window.innerHeight;
            const windowWidth = window.innerWidth;

            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip-comment';
            const text = el.querySelector('.tooltip-text')
            if (!text || text.innerHTML.trim().length==0) return;
            tooltip.textContent = text.innerHTML;
            const isTopHalf = (rect.top + rect.bottom) / 2 < windowHeight / 2;
            tooltip.classList.add(isTopHalf ? 'bottom' : 'top');
            tooltip.dataset.tooltip = 'true';

            document.body.appendChild(tooltip);

            const tooltipHeight = tooltip.offsetHeight;
            const tooltipWidth = tooltip.offsetWidth;

            const top = isTopHalf
                ? rect.bottom + window.scrollY + 10
                : rect.top + window.scrollY - tooltipHeight - 10;

            let left = rect.left + window.scrollX + (rect.width - tooltipWidth) / 2;

            // Ограничиваем позицию по ширине окна
            const padding = 8; // небольшой отступ от края
            if (left < padding) {
                left = padding;
            } else if (left + tooltipWidth > windowWidth - padding) {
                left = windowWidth - tooltipWidth - padding;
            }

            tooltip.style.top = `${top}px`;
            tooltip.style.left = `${left}px`;
        });


        el.addEventListener('mouseleave', () => {
            document.querySelectorAll('[data-tooltip="true"]').forEach(tip => tip.remove());
        });
    });
});