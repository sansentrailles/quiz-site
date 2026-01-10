<?php

use app\custom\widgets\frontend\pager\CustomPager;

$pagination = $provider->getPagination();

$currentPageItems = count($provider->getModels());

$pageSize = $pagination->pageSize;
$totalCount = $provider->getTotalCount();

?>

<div class="rating-table-footer">
    <div class="table-info">
        Показано <?= $currentPageItems ?> из <?= $totalCount ?> команд
    </div>

    <?= CustomPager::widget([
        'pagination' => $provider->pagination,
        'options' => [
            'class' => 'pagination',
        ],
        'linkOptions' => [
            'class' => 'pagination-link',
            'aria-label' => function($page, $class, $disabled, $active) {
                if ($active) {
                    return 'Текущая страница ' . ($page + 1);
                }
                return 'Страница ' . ($page + 1);
            }
        ],
        'prevPageLabel' => '<i class="fas fa-chevron-left"></i>',
        'nextPageLabel' => '<i class="fas fa-chevron-right"></i>',
        'prevPageCssClass' => '',
        'nextPageCssClass' => '',
    ]) ?>

</div>

