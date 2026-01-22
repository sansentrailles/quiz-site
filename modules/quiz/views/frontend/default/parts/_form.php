<section class="booking-section" id="bookingForm">
    <h2><i class="fas fa-edit"></i> Регистрация на квиз</h2>
    
    <form class="booking-form" id="quizForm" novalidate>
        <div class="form-group">
            <label for="name">Имя <span>*</span></label>
            <input type="text" id="name" name="name" placeholder="Ваше имя" required>
            <span class="form-error-message" id="error-name"><i class="fas fa-exclamation-circle"></i> <span>Текст ошибки</span></span>
        </div>

        <div class="form-group">
            <label for="teamName">Название команды</label>
            <input type="text" id="teamName" name="teamName" placeholder="Например: Киноманы">
            <span class="form-error-message" id="error-teamName"><i class="fas fa-exclamation-circle"></i> <span>Текст ошибки</span></span>
        </div>

        <div class="form-group">
            <label for="contact">Контакт для связи (Телефон или Telegram) <span>*</span></label>
            <input type="text" id="contact" name="contact" placeholder="+7 (999) 000-00-00" required>
            <span class="form-error-message" id="error-contact"><i class="fas fa-exclamation-circle"></i> <span>Текст ошибки</span></span>
        </div>

        <div class="form-group">
            <label for="quantity">Количество участников <span>*</span></label>
            <select id="quantity" name="quantity" required>
                <option value="" disabled selected>Выберите количество участников</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
            </select>
            <span class="form-error-message" id="error-quantity"><i class="fas fa-exclamation-circle"></i> <span>Текст ошибки</span></span>
        </div>

        <div class="form-group">
            <label for="occasion">ДР или другой праздничный повод</label>
            <input type="text" id="occasion" name="occasion" placeholder="Например: День рождения Васи">
            <span class="form-error-message" id="error-occasion"><i class="fas fa-exclamation-circle"></i> <span>Текст ошибки</span></span>
        </div>

        <div class="checkbox-group">
            <label class="checkbox-label">
                <input type="checkbox" id="joinTeam" name="flags" value="join_team">
                Готовы принимать новых участников в команду
            </label>
            <label class="checkbox-label">
                <input type="checkbox" id="solo" name="flags" value="solo">
                Я один (без команды), готов присоединиться к команде
            </label>
        </div>

        <div class="checkbox-group">
            <label class="checkbox-label">
                <input type="checkbox" id="isAgree" name="flags" value="is_agree">
                Согласен с условиями <a href="policy.html">политики конфиденциальности</a>
            </label>
        </div>
        
        <button type="submit" class="btn-signup" id="submitBtn">
            <i class="fas fa-paper-plane"></i> Отправить заявку
        </button>
    </form>
</section>