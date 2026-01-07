<?php

declare(strict_types=1);

namespace app\modules\quiz\models\traits;

use app\modules\quiz\Module;

trait QuizAttributeLabelsTrait
{
    public function attributeLabels()
    {
        return [
            'id'         => Module::t('common', 'ID'),
            'title'      => Module::t('common', 'QUIZ_TITLE'),
            'price'      => Module::t('common', 'QUIZ_PRICE'),
            'desc'       => Module::t('common', 'QUIZ_DESC'),
            'text'       => Module::t('common', 'QUIZ_TEXT'),
            'location'   => Module::t('common', 'QUIZ_LOCATION'),
            'items'      => Module::t('common', 'QUIZ_ITEMS'),
            'date'       => Module::t('common', 'QUIZ_DATE'),
            'time'       => Module::t('common', 'QUIZ_TIME'),
            'labels'     => Module::t('common', 'QUIZ_LABELS'),
            'image'      => Module::t('common', 'QUIZ_IMAGE'),
            'imageFile'  => Module::t('common', 'QUIZ_IMAGE'),
            'isVisible'  => Module::t('common', 'IS_VISIBLE'),
            'is_visible' => Module::t('common', 'IS_VISIBLE'),
            'ord'        => Module::t('common', 'ORDER'),
            'created_at' => Module::t('common', 'CREATED_AT'),
            'updated_at' => Module::t('common', 'UPDATED_AT'),
        ];
    }
}
