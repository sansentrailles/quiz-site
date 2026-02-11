<?php

namespace app\modules\seo\models\traits;

use app\modules\seo\Module;

trait MetricAttributeLabelsTrait
{
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('common', 'ID'),
            'title' => Module::t('common', 'METRIC_TITLE'),
            'code' => Module::t('common', 'METRIC_CODE'),
            'place' => Module::t('common', 'METRIC_PLACE'),
            'is_visible' => Module::t('common', 'IS_VISIBLE'),
            'ord' => Module::t('common', 'ORDER'),
            'created_at' => Module::t('common', 'CREATED_AT'),
            'updated_at' => Module::t('common', 'UPDATED_AT'),
        ];
    }
}
