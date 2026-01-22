export function initQuiz() {
    const bookingFormContainer = document.getElementById('booking-form-container');
    const bookingBtn = document.getElementById('showBookingFormBtn');

    bookingBtn.addEventListener('click', () => {
        bookingFormContainer.scrollIntoView({ 
            behavior: 'smooth',
            block: 'start'
        });
        
        // Добавляем небольшой отступ сверху для лучшего визуального восприятия
        setTimeout(() => {
            window.scrollBy(0, -100);
        }, 500);
    });

}