<?php

declare(strict_types=1);

namespace app\modules\geo\models\traits;

use app\modules\geo\Module;

trait PointAttributeLabelsTrait
{
    public function attributeLabels()
    {
        return [
            'id'         => Module::t('common', 'ID'),
            'title'      => Module::t('common', 'GEO_POINT_TITLE'),
            'longitude'  => Module::t('common', 'GEO_POINT_LONGITUDE'),
            'latitude'   => Module::t('common', 'GEO_POINT_LATITUDE'),
            'is_visible' => Module::t('common', 'IS_VISIBLE'),
            'created_at' => Module::t('common', 'CREATED_AT'),
            'updated_at' => Module::t('common', 'UPDATED_AT'),
            'ord'        => Module::t('common', 'ORDER'),
        ];
    }
}
