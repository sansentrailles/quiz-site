<?php

declare(strict_types=1);

$buckets = require __DIR__ . '/inner/_buckets.php';

return [
    'siteName' => 'sitename.ru',
    'adminEmail' => 'admin@example.com',
    'adminLabel' => 'sitename',
    'rf_akey' => md5('key_phrase_for_app' . 'kPswuf7a2j^a22228t0l1-nwUghbaGV@jJKJHLJTyre'),
    'layouts' => [
        'backend' => '@app/views/admin/layouts',
        'frontend' => '//frontend/main',
    ],
    'buckets' => $buckets,
];
