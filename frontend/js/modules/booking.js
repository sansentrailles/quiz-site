export function initBooking() {
    const modal = document.getElementById('signupModal');
    const openBtn = document.getElementById('openSignupModal');
    const closeBtn = document.getElementById('closeModal');
    const form = document.getElementById('quizForm');
    const submitBtn = document.getElementById('submitBtn');
    const toast = document.getElementById('successToast');

    // Открытие модального окна
    openBtn.addEventListener('click', () => {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden'; // Блокировка прокрутки фона
    });

    // Закрытие модального окна
    const closeModal = () => {
        modal.style.display = 'none';
        document.body.style.overflow = '';
        clearErrors();
    };

    closeBtn.addEventListener('click', closeModal);

    // Закрытие по клику на фон
    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Очистка ошибок
    function clearErrors() {
        const inputs = form.querySelectorAll('input, select');
        const errorMessages = form.querySelectorAll('.error-message');
        
        inputs.forEach(input => input.classList.remove('error'));
        errorMessages.forEach(msg => {
            msg.style.display = 'none';
            msg.querySelector('span').textContent = '';
        });
    }

    // Отображение ошибки под конкретным полем
    function showFieldError(fieldId, message) {
        const input = document.getElementById(fieldId);
        const errorContainer = document.getElementById(`error-${fieldId}`);
        
        if (input && errorContainer) {
            input.classList.add('error');
            errorContainer.querySelector('span').textContent = message;
            errorContainer.style.display = 'flex';
        }
    }

    // Показать уведомление об успехе
    function showToast() {
        toast.classList.add('toast--show');
        setTimeout(() => {
            toast.classList.remove('toast--show');
        }, 4000);
    }

    // Обработка отправки формы
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        // Очистка предыдущих ошибок
        clearErrors();

        // Сбор данных
        const formData = {
            name: document.getElementById('name').value.trim(),
            teamName: document.getElementById('teamName').value.trim(),
            contact: document.getElementById('contact').value.trim(),
            quantity: document.getElementById('quantity').value,
            occasion: document.getElementById('occasion').value.trim(),
            flags: {
                joinTeam: document.getElementById('joinTeam').checked,
                solo: document.getElementById('solo').checked
            }
        };

        // Блокировка кнопки
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Отправка...';
        submitBtn.disabled = true;

        try {
            // Имитация запроса к серверу (Mock API)
            const response = await mockApiSubmit(formData);
            
            if (response.success) {
                // Успех
                closeModal();
                showToast();
                form.reset();
            } else if (response.errors) {
                // Ошибка валидации от сервера
                // Проходим по объекту ошибок и выводим их
                for (const [field, message] of Object.entries(response.errors)) {
                    showFieldError(field, message);
                }
            }
        } catch (error) {
            console.error(error);
            alert('Произошла системная ошибка. Попробуйте позже.');
        } finally {
            // Разблокировка кнопки
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
        }
    });
}

/**
 * Функция-имитатор API запроса
 * Возвращает Promise с ответом сервера
 */
function mockApiSubmit(data) {
    return new Promise((resolve) => {
        setTimeout(() => {
            console.log("Отправка данных на сервер:", data);

            // ЛОГИКА ТЕСТИРОВАНИЯ ОШИБОК:
            // 1. Если контакт содержит слово "ошибка", возвращаем ошибку валидации для контакта
            // 2. Если имя короче 3 символов, ошибка для имени
            // 3. Иначе успех

            const errors = {};

            if (data.contact.length < 5) {
                errors.contact = 'Контакт слишком короткий';
            }

            if (data.contact.includes('error')) {
                errors.contact = 'Некорректный формат номера';
            }

            if (data.name.length < 2) {
                errors.name = 'Введите настоящее имя';
            }

            // Если есть ошибки, возвращаем failure
            if (Object.keys(errors).length > 0) {
                resolve({
                    success: false,
                    errors: errors
                });
            } else {
                // Иначе успех
                resolve({
                    success: true,
                    message: 'Заявка успешно создана'
                });
            }
        }, 1000); // Задержка 1 секунда
    });
}