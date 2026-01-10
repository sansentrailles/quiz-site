<div class="stats-cards">
    <?php if ($stats['teamsCount']) { ?>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3><?= $stats['teamsCount'] ?></h3>
                <p>Всего команд</p>
            </div>
        </div>
    <?php } ?>

    <?php if (isset($stats['expiredQuizesCount'])) { ?>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-gamepad"></i>
            </div>
            <div class="stat-info">
                <h3><?= $stats['expiredQuizesCount'] ?></h3>
                <p>Проведено квизов</p>
            </div>
        </div>
    <?php } ?>
    
    <?php if (isset($stats['monthQuizes'])) { ?>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-info">
                <h3><?= $stats['monthQuizes'] ?></h3>
                <p>Квизов в этом месяце</p>
            </div>
        </div>
    <?php } ?>
    
    <?php if (isset($stats['totalPoints'])) { ?>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-info">
                <h3><?= number_format($stats['totalPoints'], 0, ' ', '') ?></h3>
                <p>Всего набрано баллов</p>
            </div>
        </div>
    <?php } ?>
</div>
