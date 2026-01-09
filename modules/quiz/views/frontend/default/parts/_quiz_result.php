<?php

$places = [
    1 => 'fa-trophy',
    2 => 'fa-trophy',
    3 => 'fa-trophy',
    // 2 => 'fa-medal',
    // 3 => 'fa-award',
];

?>

<div class="quiz-results">
    <div class="results-header">
        <h2 class="results-title">
            <i class="fas fa-trophy"></i> Результаты команд
        </h2>
        <p class="results-subtitle">Команды отсортированы по убыванию баллов. Показаны результаты всех <?= count($participants) ?> команд-участниц.</p>
    </div>
    
    <table class="results-table">
        <thead>
            <tr>
                <th style="width: 70px;">Место</th>
                <th>Название команды</th>
                <th style="width: 100px;">Баллы</th>
                <th style="width: 70px;">Награда</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($participants as $participant) {
                $place = $participant->place;
            ?>
                <tr<?php if ($place <=3) { ?> class="podium-row"<?php } ?>>
                    <td class="place-cell<?php if($place <= 3) { ?> place-<?= $place ?><?php } ?>"><?= $participant->place ?></td>
                    <td class="team-cell"><?= $participant->team->title ?></td>
                    <td class="score-cell"><?= $participant->points ?></td>
                    <td class="award-cell">
                        <?php if(isset($places[$participant->place])) { ?>
                            <i class="fas <?= $places[$participant->place] ?> place-<?= $place ?>"></i>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
