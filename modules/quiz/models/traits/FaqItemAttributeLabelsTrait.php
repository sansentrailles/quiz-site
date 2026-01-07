<?php

declare(strict_types=1);

namespace app\modules\quiz\models\traits;

use app\modules\quiz\Module;

trait FaqItemAttributeLabelsTrait
{
    public function attributeLabels()
    {
        return [
            'id'         => Module::t('common', 'ID'),
            'question'   => Module::t('common', 'QUIZ_FAQ_ITEM_QUESTION'),
            'answer'     => Module::t('common', 'QUIZ_FAQ_ITEM_ANSWER'),
            'isVisible'  => Module::t('common', 'IS_VISIBLE'),
            'is_visible' => Module::t('common', 'IS_VISIBLE'),
            'ord'        => Module::t('common', 'ORDER'),
            'created_at' => Module::t('common', 'CREATED_AT'),
            'updated_at' => Module::t('common', 'UPDATED_AT'),
        ];
    }
}
