<section class="booking-section" id="booking-form-container">
    <h2><i class="fas fa-edit"></i> Регистрация на квиз</h2>

    <?= $this->render('_form', [
        'model' => $model,
        'action' => $action,
    ]) ?>
    
</section>

