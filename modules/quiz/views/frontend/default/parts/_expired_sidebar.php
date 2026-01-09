<div class="completion-card">
    <div class="completion-icon">
        <i class="fas fa-flag-checkered"></i>
    </div>
    
    <h2 class="completion-title">Квиз завершен</h2>
    
    <p class="completion-text">
        Это интеллектуальное соревнование уже состоялось. Благодарим всех участников за интересную игру!
    </p>
    
    <?php if(!is_null($stats)) { ?>
        <div class="completion-stats">
            <h3><i class="fas fa-chart-line"></i> Статистика квиза</h3>
            <div class="stats-grid">
                <div class="stat-box">
                    <div class="stat-value"><?= $stats['teams_count'] ?></div>
                    <div class="stat-label">команд</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value"><?= $stats['total_persons'] ?></div>
                    <div class="stat-label">участников</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value"><?= $stats['max_points'] ?></div>
                    <div class="stat-label">макс. балл</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value"><?= $stats['min_points'] ?></div>
                    <div class="stat-label">мин балл</div>
                </div>
            </div>
        </div>
    <?php } ?>
    
    <?php /*
    <p style="margin-top: 15px; color: var(--gray); font-size: 0.9rem;">
        <i class="fas fa-info-circle"></i> Следующий квиз по этой теме планируется в ноябре 2023 года
    </p>
    */ ?>
</div>
