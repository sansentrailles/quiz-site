<?php

declare(strict_types=1);

$params =  require __DIR__ . '/../params.php';
require __DIR__ . '/_layout.php';

return [
    'admin' => [
        'class' => 'app\modules\admin\Module',
        'layout' => $layoutBackend,
        'controllerNamespace' => 'app\modules\admin\controllers\backend',
        'viewPath' => '@app/modules/admin/views/backend',
        'layout' => $layoutBackend,

        'modules' => [
            'main' => [
                'class' => 'app\modules\main\Module',
                'controllerNamespace' => 'app\modules\main\controllers\backend',
                'viewPath' => '@app/modules/main/views/backend',
                'layout' => $layoutBackend,
            ],

            'user' => [
                'class' => 'app\modules\user\Module',
                'controllerNamespace' => 'app\modules\user\controllers\backend',
                'viewPath' => '@app/modules/user/views/backend',
                'layout' => $layoutBackend,
            ],

            'settings' => [
                'class' => 'app\modules\settings\Module',
                'controllerNamespace' => 'app\modules\settings\controllers\backend',
                'viewPath' => '@app/modules/settings/views/backend',
                'layout' => $layoutBackend,
            ],

            'quiz' => [
                'class' => 'app\modules\quiz\Module',
                'controllerNamespace' => 'app\modules\quiz\controllers\backend',
                'viewPath' => '@app/modules/quiz/views/backend',
                'layout' => $layoutBackend,
            ],

            'seo' => [
                'class' => 'app\modules\seo\Module',
                'controllerNamespace' => 'app\modules\seo\controllers\backend',
                'viewPath' => '@app/modules/seo/views/backend',
                'layout' => $layoutBackend,
            ],

            'geo' => [
                'class' => 'app\modules\geo\Module',
                'controllerNamespace' => 'app\modules\geo\controllers\backend',
                'viewPath' => '@app/modules/geo/views/backend',
                'layout' => $layoutBackend,
            ],

            // 'guide' => [
            //     'class' => 'app\modules\guide\Module',
            //     'controllerNamespace' => 'app\modules\guide\controllers\backend',
            //     'viewPath' => '@app/modules/guide/views/backend',
            //     'layout' => $layoutBackend,
            // ],
        ],
    ],

    'main' => [
        'class' => 'app\modules\main\Module',
        'controllerNamespace' => 'app\modules\main\controllers\frontend',
        'viewPath' => '@app/modules/main/views/frontend',
        'layout' => $layoutFrontend,
    ],

    'user' => [
        'class' => 'app\modules\user\Module',
        'controllerNamespace' => 'app\modules\user\controllers\frontend',
        'viewPath' => '@app/modules/user/views/frontend',
        'layout' => $layoutFrontend,
    ],
    
    'quiz' => [
        'class' => 'app\modules\quiz\Module',
        'controllerNamespace' => 'app\modules\quiz\controllers\frontend',
        'viewPath' => '@app/modules/quiz/views/frontend',
        'layout' => $layoutFrontend,
    ],

    'geo' => [
        'class' => 'app\modules\geo\Module',
        'controllerNamespace' => 'app\modules\geo\controllers\frontend',
        'viewPath' => '@app/modules/geo/views/frontend',
        'layout' => $layoutFrontend,
    ],
];
