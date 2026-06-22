<?php

namespace app\modules\geo\assets;

use yii\web\AssetBundle;


class MapAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/geo/assets/';

    public $css = [

    ];

    public $js = [
        '//api-maps.yandex.ru/2.1/?apikey=58f61641-0027-42b9-992f-d44aad687fc3&lang=ru_RU',
        'js/map.js',
    ];
    public $depends = [
    ];
}
