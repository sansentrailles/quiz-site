<?php

namespace app\modules\seo\models\traits;

use app\modules\seo\Module;

trait MetaTagAttributeLabelsTrait
{
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => Module::t('common', 'ID'),
            'name'       => Module::t('common', 'META_TAG_NAME'),
            'content'    => Module::t('common', 'META_TAG_CONTENT'),
            'is_visible' => Module::t('common', 'IS_VISIBLE'),
            'ord'        => Module::t('common', 'ORDER'),
            'created_at' => Module::t('common', 'CREATED_AT'),
            'updated_at' => Module::t('common', 'UPDATED_AT'),
        ];
    }
}
