<?php

declare(strict_types=1);

namespace app\modules\quiz;

use Yii;

/**
 * quiz module definition class.
 */
class Module extends Yii\base\Module
{
    public $controllerNamespace = 'app\modules\quiz\controllers';

    public function init(): void
    {
        parent::init();

        // custom initialization code goes here
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/quiz/' . $category, $message, $params, $language);
    }
}
