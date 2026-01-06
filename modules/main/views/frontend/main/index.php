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
    </div>
</section>

<?php //=  $this->render("parts/_reivews") ?>