<?php declare(strict_types=1);

use app\custom\helpers\RouteHelper;
use app\modules\user\Module as UserModule;
use app\modules\quiz\Module as QuizModule;
use app\modules\settings\Module as SettingsModule;
use app\modules\seo\Module as SeoModule;

?>

<aside class="main-sidebar">

    <section class="sidebar">

        <?php echo dmstr\widgets\Menu::widget(
            [
                'options' => [
                    'class' => 'sidebar-menu',
                    'data-widget' => 'tree',
                ],
                'items' => [
                    // ['label' => AdminModule::t('common', 'ADMIN_SECTIONS') . ' ' . Yii::$app->name, 'options' => ['class' => 'header']],

                    [
                        'label' => UserModule::t('common', 'ADMIN_USERS'),
                        'icon' => 'users',
                        'url' => '#',
                        'active'=> RouteHelper::isModule('user'),
                        // 'visible' => Yii::$app->user->can('dev'),
                        'items' => [
                            [
                                'label' => UserModule::t('common', 'USER_LIST'),
                                'icon' => 'list-ol',
                                'url' => ['/admin/user/'],
                                'active'=> RouteHelper::isRoute('user/default/index'),
                            ],

                            [
                                'label' => UserModule::t('common', 'PERMISSIONS'),
                                'icon' => 'key',
                                'url' => ['/admin/user/permissions'],
                                'active'=> RouteHelper::isRoute('user/permissions/index'),
                            ],

                            [
                                'label' => UserModule::t('common', 'ROLES'),
                                'icon' => 'user-secret',
                                'url' => ['/admin/user/roles'],
                                'active'=> RouteHelper::isRoute('user/roles/index'),
                            ],
                        ],
                    ],

                    [
                        'label' => QuizModule::t('common', 'QUIZES'),
                        'icon' => 'question',
                        'url' => '#',
                        'active'=> RouteHelper::isModule('quiz'),
                        'items' => [
                            [
                                'label' => QuizModule::t('common', 'QUIZ_LIST'),
                                'icon' => 'bars',
                                'url' => ['/admin/quiz/quizes'],
                                'active'=> RouteHelper::isRoute('quiz/quizes'),
                            ],
                            [
                                'label' => QuizModule::t('common', 'QUIZ_LABELS'),
                                'icon' => 'tag',
                                'url' => ['/admin/quiz/labels'],
                                'active'=> RouteHelper::isRoute('quiz/labels'),
                            ],
                            [
                                'label' => QuizModule::t('common', 'QUIZ_LOCATIONS'),
                                'icon' => 'map-marker',
                                'url' => ['/admin/quiz/locations'],
                                'active'=> RouteHelper::isRoute('quiz/locations'),
                            ],
                            [
                                'label' => QuizModule::t('common', 'QUIZ_FAQ_ITEMS'),
                                'icon' => 'question',
                                'url' => ['/admin/quiz/faq-items'],
                                'active'=> RouteHelper::isRoute('quiz/faq-items'),
                            ],
                            [
                                'label' => QuizModule::t('common', 'QUIZ_TEAMS'),
                                'icon' => 'users',
                                'url' => ['/admin/quiz/teams'],
                                'active'=> RouteHelper::isRoute('quiz/teams'),
                            ],
                        ],
                    ],

                    [
                        'label' => SeoModule::t('common', 'SEO'),
                        'icon' => 'code',
                        'url' => '#',
                        'active'=> RouteHelper::isModule('seo'),
                        'items' => [
                            [
                                'label' => SeoModule::t('common', 'METRICS'),
                                'icon' => 'code',
                                'url' => ['/admin/seo/metrics'],
                                'active'=> RouteHelper::isRoute('seo/metrics/index'),
                            ],

                            [
                                'label' => SeoModule::t('common', 'META_TAGS'),
                                'icon' => 'code',
                                'url' => ['/admin/seo/metas'],
                                'active'=> RouteHelper::isRoute('seo/metas/index'),
                            ],
                        ],
                    ],

                    [
                        'label' => SettingsModule::t('common', 'SETTINGS'),
                        'icon' => 'gears',
                        'url' => '#',
                        'active'=> RouteHelper::isModule('settings'),
                        'items' => [
                            [
                                'label' => SettingsModule::t('common', 'SETTING_GROUPS'),
                                'icon' => 'bars',
                                'url' => ['/admin/settings/groups'],
                                'active'=> RouteHelper::isRoute('settings/groups'),
                                // 'visible' => Yii::$app->user->can('dev'),
                            ],
                            [
                                'label' => SettingsModule::t('common', 'SETTINGS'),
                                'icon' => 'gear',
                                'url' => ['/admin/settings'],
                                'active'=> RouteHelper::isRoute('settings'),
                            ],
                        ],
                    ],
                ],
            ]
        ); ?>

    </section>

</aside>
