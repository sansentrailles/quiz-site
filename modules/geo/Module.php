<?php

declare(strict_types=1);

namespace app\modules\geo;

use Yii;

/**
 * geo module definition class.
 */
class Module extends Yii\base\Module
{
    public $controllerNamespace = 'app\modules\geo\controllers';

    public function init(): void
    {
        parent::init();

        // custom initialization code goes here
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/geo/' . $category, $message, $params, $language);
    }
}
