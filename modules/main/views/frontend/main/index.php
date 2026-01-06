<?= $this->render('parts/_top') ?>

<!-- Список квизов -->
<section id="quiz-list">
    <h2 style="font-size: 1.8rem; color: var(--dark); margin-bottom: 30px; display: flex; align-items: center; gap: 12px;">
        <i class="fas fa-gamepad"></i> Предстоящие квизы
    </h2>

    <div class="quiz-list">
        <?php foreach ($quizes as $item) { ?>
            <?=  $this->render('parts/_quiz_item', [
                'quiz' => $item,
            ]) ?>
        <?php } ?>

        <!-- Квиз 2 -->
        <div class="quiz-card">
            <div class="quiz-badge">Музыкальный</div>
            <img src="https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Рок-энциклопедия" class="quiz-image">
            <div class="quiz-content">
                <div class="quiz-header">
                    <h3 class="quiz-title">Рок-энциклопедия: От битлов до наших дней</h3>
                    <span class="quiz-category">Музыка</span>
                </div>
                
                <div class="quiz-details">
                    <div class="detail-item">
                        <i class="far fa-calendar-alt"></i>
                        <span>16 октября, ср в 19:30</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Паб 'Гитара', пр. Музыкальный, 42</span>
                    </div>
                    <p style="margin-top: 10px; color: #666;">Викторина для настоящих ценителей рок-музыки. От классического рока до современных альтернативных групп.</p>
                </div>
                
                <div class="participants">
                    <div style="flex-grow: 1;">
                        <div class="participants-count">28/40 участников</div>
                        <div class="progress-bar">
                            <div class="progress" style="width: 70%"></div>
                        </div>
                    </div>
                    <div style="font-weight: 600; color: var(--success);">
                        12 мест
                    </div>
                </div>
                
                <div class="quiz-footer">
                    <div class="quiz-price">250 руб.</div>
                    <div class="quiz-actions">
                        <button class="btn-details" onclick="showQuizDetails(2)"><i class="fas fa-chevron-right"></i></button>
                        <button class="btn-signup" onclick="openSignupModal(2)">Записаться</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Квиз 3 -->
        <div class="quiz-card">
            <div class="quiz-badge">С призами</div>
            <img src="https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Научный бар" class="quiz-image">
            <div class="quiz-content">
                <div class="quiz-header">
                    <h3 class="quiz-title">Научный бар: Открытия, изменившие мир</h3>
                    <span class="quiz-category">Наука и технологии</span>
                </div>
                
                <div class="quiz-details">
                    <div class="detail-item">
                        <i class="far fa-calendar-alt"></i>
                        <span>17 октября, чт в 21:00</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Научный паб 'Эйнштейн', ул. Академическая, 7</span>
                    </div>
                    <p style="margin-top: 10px; color: #666;">Интеллектуальная битва на научные темы. Физика, химия, биология и новейшие технологии.</p>
                </div>
                
                <div class="participants">
                    <div style="flex-grow: 1;">
                        <div class="participants-count">35/50 участников</div>
                        <div class="progress-bar">
                            <div class="progress" style="width: 70%"></div>
                        </div>
                    </div>
                    <div style="font-weight: 600; color: var(--success);">
                        15 мест
                    </div>
                </div>
                
                <div class="quiz-footer">
                    <div class="quiz-price">500 руб.</div>
                    <div class="quiz-actions">
                        <button class="btn-details" onclick="showQuizDetails(3)"><i class="fas fa-chevron-right"></i></button>
                        <button class="btn-signup" onclick="openSignupModal(3)">Записаться</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Квиз 4 -->
        <div class="quiz-card">
            <div class="quiz-badge">Новый</div>
            <img src="https://images.unsplash.com/photo-1589652717521-10c0d092dea9?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Исторический детектив" class="quiz-image">
            <div class="quiz-content">
                <div class="quiz-header">
                    <h3 class="quiz-title">Исторический детектив: Тайны древних цивилизаций</h3>
                    <span class="quiz-category">История</span>
                </div>
                
                <div class="quiz-details">
                    <div class="detail-item">
                        <i class="far fa-calendar-alt"></i>
                        <span>18 октября, пт в 20:00</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Бар 'Архив', ул. Историческая, 33</span>
                    </div>
                    <p style="margin-top: 10px; color: #666;">Раскройте исторические тайны в нашей викторине. От древних цивилизаций до новейшей истории.</p>
                </div>
                
                <div class="participants">
                    <div style="flex-grow: 1;">
                        <div class="participants-count">18/30 участников</div>
                        <div class="progress-bar">
                            <div class="progress" style="width: 60%"></div>
                        </div>
                    </div>
                    <div style="font-weight: 600; color: var(--success);">
                        12 мест
                    </div>
                </div>
                
                <div class="quiz-footer">
                    <div class="quiz-price">400 руб.</div>
                    <div class="quiz-actions">
                        <button class="btn-details" onclick="showQuizDetails(4)"><i class="fas fa-chevron-right"></i></button>
                        <button class="btn-signup" onclick="openSignupModal(4)">Записаться</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Квиз 5 -->
        <div class="quiz-card">
            <div class="quiz-badge">Популярный</div>
            <img src="https://images.unsplash.com/photo-1461896836934-ffe607ba8211?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Спортивный баттл" class="quiz-image">
            <div class="quiz-content">
                <div class="quiz-header">
                    <h3 class="quiz-title">Спортивный баттл: Чемпионы и рекорды</h3>
                    <span class="quiz-category">Спорт</span>
                </div>
                
                <div class="quiz-details">
                    <div class="detail-item">
                        <i class="far fa-calendar-alt"></i>
                        <span>19 октября, сб в 19:00</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Спорт-бар 'Чемпион', ул. Стадионная, 12</span>
                    </div>
                    <p style="margin-top: 10px; color: #666;">Проверь свои знания в мире спорта. Футбол, хоккей, баскетбол и Олимпийские игры.</p>
                </div>
                
                <div class="participants">
                    <div style="flex-grow: 1;">
                        <div class="participants-count">55/80 участников</div>
                        <div class="progress-bar">
                            <div class="progress" style="width: 69%"></div>
                        </div>
                    </div>
                    <div style="font-weight: 600; color: var(--success);">
                        25 мест
                    </div>
                </div>
                
                <div class="quiz-footer">
                    <div class="quiz-price">250 руб.</div>
                    <div class="quiz-actions">
                        <button class="btn-details" onclick="showQuizDetails(5)"><i class="fas fa-chevron-right"></i></button>
                        <button class="btn-signup" onclick="openSignupModal(5)">Записаться</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Квиз 6 -->
        <div class="quiz-card">
            <div class="quiz-badge">С призами</div>
            <img src="https://images.unsplash.com/photo-1550745165-9bc0b252726f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Игровая вселенная" class="quiz-image">
            <div class="quiz-content">
                <div class="quiz-header">
                    <h3 class="quiz-title">Игровая вселенная: От пикселей до виртуальной реальности</h3>
                    <span class="quiz-category">Игры</span>
                </div>
                
                <div class="quiz-details">
                    <div class="detail-item">
                        <i class="far fa-calendar-alt"></i>
                        <span>20 октября, вс в 21:30</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Кибер-бар 'Пиксель', пр. Виртуальный, 8</span>
                    </div>
                    <p style="margin-top: 10px; color: #666;">Викторина по видеоиграм и гейм-культуре. От ретроклассики до современных блокбастеров.</p>
                </div>
                
                <div class="participants">
                    <div style="flex-grow: 1;">
                        <div class="participants-count">48/60 участников</div>
                        <div class="progress-bar">
                            <div class="progress" style="width: 80%"></div>
                        </div>
                    </div>
                    <div style="font-weight: 600; color: var(--success);">
                        12 мест
                    </div>
                </div>
                
                <div class="quiz-footer">
                    <div class="quiz-price">350 руб.</div>
                    <div class="quiz-actions">
                        <button class="btn-details" onclick="showQuizDetails(6)"><i class="fas fa-chevron-right"></i></button>
                        <button class="btn-signup" onclick="openSignupModal(6)">Записаться</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php //=  $this->render("parts/_reivews") ?>