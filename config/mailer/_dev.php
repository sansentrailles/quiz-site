<?php

declare(strict_types=1);

use yii\symfonymailer\Mailer;

return [
    'class' => Mailer::class,
    'useFileTransport' => false,
    'viewPath' => '@app/custom/templates/mail',
];
