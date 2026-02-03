import { showToast } from './toast';

export function initBooking() {
    const form = document.getElementById('quizBookingForm');
    const submitBtn = form.querySelector('button[type="submit"]');
    const isSingleCheckbox = document.querySelector('[data-single-checkbox]');
    const teamNameInput = document.querySelector('[data-team-name]');

    // Обработка отправки формы
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Очистка предыдущих ошибок
        clearErrors();

        const url = form.action;
        const formName = form.dataset.name;

        // Собираем данные формы в объект
        //FormData автоматически берет значения из полей с атрибутом "name"
        const formData = new FormData(form);
        // const data = Object.fromEntries(formData.entries());


        // Блокировка кнопки
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Отправка...';
        submitBtn.disabled = true;

        try {
            // 2. Отправляем запрос на сервер
            const response = await fetch(url, {
                method: 'POST',
                body: formData,
                // body: JSON.stringify(data),
                credentials: 'same-origin'
            });
            
            const result = await response.json();

            if (response.ok && result.success) {
                showToast('Заявка принята!', 'Мы свяжемся с вами перед игрой для подтверждения');
                form.reset();
            } else if (result.errors) {
                // Ошибка валидации от сервера
                // Проходим по объекту ошибок и выводим их
                for (const [field, message] of Object.entries(result.errors)) {
                    // console.log(field, message.join("\n"));
                    showFieldError(formName, field, message.join("\n"));
                }
            }
        } catch (error) {
            console.error(error);
        } finally {
            // Разблокировка кнопки
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
        }
    });

    // Очистка ошибок
    function clearErrors() {
        const inputs = form.querySelectorAll('input, select');
        const errorMessages = form.querySelectorAll('.form-error-message');

        inputs.forEach(input => input.classList.remove('error'));
        errorMessages.forEach(msg => {
            msg.style.display = 'none';
            msg.querySelector('span').textContent = '';
        });
    }

    // Отображение ошибки под конкретным полем
    function showFieldError(formName, fieldId, message) {
        const input = document.getElementById(fieldId);
        const errorContainer = document.getElementById(`${fieldId}-error`);

        if (input && errorContainer) {
            input.classList.add('error');
            errorContainer.querySelector('span').textContent = message;
            errorContainer.style.display = 'flex';
        }
    }

    isSingleCheckbox.addEventListener('change', () => {
        teamNameInput.disabled = isSingleCheckbox.checked;
    });
}

