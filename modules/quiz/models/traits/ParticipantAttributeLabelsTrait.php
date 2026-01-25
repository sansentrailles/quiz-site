<?php

declare(strict_types=1);

namespace app\modules\quiz\models\traits;

use app\modules\quiz\Module;

trait ParticipantAttributeLabelsTrait
{
    public function attributeLabels()
    {
        return [
            'id'         => Module::t('common', 'ID'),
            'quiz_id'    => Module::t('common', 'QUIZ_PARTICIPANT_QUIZ_ID'),
            'team_id'    => Module::t('common', 'QUIZ_PARTICIPANT_TEAM_ID'),
            'persons'    => Module::t('common', 'QUIZ_PARTICIPANT_PERSONS'),
            'points'     => Module::t('common', 'QUIZ_PARTICIPANT_POINTS'),
            'place'      => Module::t('common', 'QUIZ_PARTICIPANT_PLACE'),
            'is_opened'  => Module::t('common', 'QUIZ_PARTICIPANT_IS_OPENED'),
            'comment'    => Module::t('common', 'QUIZ_PARTICIPANT_COMMENT'),
            'name'       => Module::t('common', 'QUIZ_PARTICIPANT_NAME'),
            'contact'    => Module::t('common', 'QUIZ_PARTICIPANT_CONTACT'),
            'created_at' => Module::t('common', 'CREATED_AT'),
            'updated_at' => Module::t('common', 'UPDATED_AT'),
        ];
    }
}
