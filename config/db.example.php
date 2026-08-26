<?php

declare(strict_types=1);

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=db;dbname=yii2db', // 'host=db' - это имя сервиса в docker-compose!
    'username' => 'yii2user',
    'password' => 'yii2password',
    'charset' => 'utf8',
];
