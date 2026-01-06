<?php

declare(strict_types=1);

namespace app\modules\quiz;

use Yii;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $app->i18n->translations['modules/quiz/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@app/modules/quiz/messages',
            'fileMap' => [
                'modules/quiz/common' => 'common.php',
                'modules/quiz/frontend' => 'frontend.php',
            ],
        ];

    }
}
