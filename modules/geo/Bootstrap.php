<?php

declare(strict_types=1);

namespace app\modules\geo;

use Yii;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $app->i18n->translations['modules/geo/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@app/modules/geo/messages',
            'fileMap' => [
                'modules/geo/common' => 'common.php',
                'modules/geo/frontend' => 'frontend.php',
            ],
        ];

    }
}
