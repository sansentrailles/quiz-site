
<section class="faq-section">
    <h2 class="section-title">
        <i class="fas fa-question-circle"></i> Часто задаваемые вопросы
    </h2>
    
    <div class="faq-container">
        <?php foreach ($faqItems as $item) { ?>
            <div class="faq-item" onclick="toggleFaq(this)">
                <div class="faq-question">
                    <span><?=  $item->question ?></span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <?= $item->answer ?>
                </div>
            </div>
        <?php } ?>
    </div>
</section>