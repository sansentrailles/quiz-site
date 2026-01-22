export function showToast(title, message) {
    // Получаем элемент тоста (лучше один раз кэшировать, но для простоты — здесь)
    const toast = document.getElementById('successToast');
    
    // Обновляем заголовок и текст
    const titleEl = toast.querySelector('.toast-content h4');
    const messageEl = toast.querySelector('.toast-content p');
    
    if (titleEl) titleEl.textContent = title;
    if (messageEl) messageEl.textContent = message;

    // Показываем тост
    toast.classList.add('toast--show');

    // Скрываем через 4 секунды
    setTimeout(() => {
        toast.classList.remove('toast--show');
    }, 4000);
}