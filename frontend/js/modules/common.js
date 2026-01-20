// frontend/js/modules/common.js

// Экспортируем функцию инициализации
export function initCommon() {
    // Логика для FAQ
    const firstFaq = document.querySelector('.faq-item');
    if (firstFaq) {
        firstFaq.classList.add('active');
    }

    // Навешиваем клики на FAQ items (делегирование или прямой перебор)
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
        // Предполагаем, что у вас есть кнопка или заголовок внутри, на который нужно кликать.
        // Если вы кликали на весь item, оставим так, но лучше уточнить селектор кнопки.
        item.addEventListener('click', function() {
            // // Закрываем другие (опционально)
            // faqItems.forEach(i => {
            //     if (i !== this) i.classList.remove('active');
            // });
            this.classList.toggle('active');
        });
    });

    // Плавная прокрутка
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            if (href !== '#' && href.startsWith('#')) {
                e.preventDefault();
                const targetId = href.substring(1);
                const targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
}