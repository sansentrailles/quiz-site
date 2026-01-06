<?php

declare(strict_types=1);

return [
    'quizImage' => [
        'baseSubPath' => 'images/quizes/image',
        'fileSubDirTemplate' => '{^name}{^^name}/{^^^name}{^^^^name}',
    ],

    'settingFile' => [
        'baseSubPath' => 'settings',
        'fileSubDirTemplate' => '{^name}{^^name}/{^^^name}{^^^^name}',
    ],
/**
 * Template config for upload files.
 *
 * 'templateIcon' => [
 *    'baseSubPath' => 'images/template/image',
 *    'fileSubDirTemplate' => '{^name}{^^name}/{^^^name}{^^^^name}',
 *],
 *
 *'templateFile' => [
 *    'baseSubPath' => 'files/template/file',
 *    'fileSubDirTemplate' => '{^name}{^^name}/{^^^name}{^^^^name}',
 *],
 */
];
