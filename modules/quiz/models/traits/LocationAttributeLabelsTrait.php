<?php

declare(strict_types=1);

namespace app\modules\quiz\models\traits;

use app\modules\quiz\Module;

trait LocationAttributeLabelsTrait
{
    public function attributeLabels()
    {
        return [
            'id'         => Module::t('common', 'ID'),
            'title'      => Module::t('common', 'QUIZ_LOCATION_TITLE'),
            'desc'       => Module::t('common', 'QUIZ_LOCATION_DESC'),
            'address'    => Module::t('common', 'QUIZ_LOCATION_ADDRESS'),
            'longitude'  => Module::t('common', 'QUIZ_LOCATION_LONGITUDE'),
            'latitude'   => Module::t('common', 'QUIZ_LOCATION_LATITUDE'),
            'workmode'   => Module::t('common', 'QUIZ_LOCATION_WORKMODE'),
            'created_at' => Module::t('common', 'CREATED_AT'),
            'updated_at' => Module::t('common', 'UPDATED_AT'),
        ];
    }
}
