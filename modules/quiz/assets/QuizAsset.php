<?php

namespace app\modules\quiz\assets;

use yii\web\AssetBundle;


class QuizAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/quiz/assets/';

    public $css = [

    ];

    public $js = [
        '//api-maps.yandex.ru/2.1/?apikey=58f61641-0027-42b9-992f-d44aad687fc3&lang=ru_RU',
        // '//api-maps.yandex.ru/2.1/?lang=ru_RU',
        'js/map.js',
    ];
    public $depends = [
    ];
}
