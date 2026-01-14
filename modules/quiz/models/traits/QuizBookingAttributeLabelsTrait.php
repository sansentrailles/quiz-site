<?php

declare(strict_types=1);

namespace app\modules\quiz\models\traits;

use app\modules\quiz\Module;

trait QuizBookingAttributeLabelsTrait
{
    public function attributeLabels()
    {
        return [
            'id'         => Module::t('common', 'ID'),
            'quiz_id'    => Module::t('common', 'QUIZ_BOOKING_QUIZ_ID'),
            'name'       => Module::t('common', 'QUIZ_BOOKING_NAME'),
            'contact'    => Module::t('common', 'QUIZ_BOOKING_CONTACT'),
            'team_name'  => Module::t('common', 'QUIZ_BOOKING_TEAM_NAME'),
            'persons'    => Module::t('common', 'QUIZ_BOOKING_PERSONS'),
            'holiday'    => Module::t('common', 'QUIZ_BOOKING_HOLIDAY'),
            'is_single'  => Module::t('common', 'QUIZ_BOOKING_IS_SINGLE'),
            'is_opened'  => Module::t('common', 'QUIZ_BOOKING_IS_OPENED'),
            'created_at' => Module::t('common', 'CREATED_AT'),
            'updated_at' => Module::t('common', 'UPDATED_AT'),
        ];
    }
}
