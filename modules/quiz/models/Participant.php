<?php

declare(strict_types=1);

namespace app\modules\quiz\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use app\modules\quiz\forms\backend\ParticipantForm as Form;
use app\modules\quiz\models\traits\ParticipantAttributeLabelsTrait;
use yii\helpers\Url;

/**
 * This is the model class for table "quiz_participants".
 *
 * @property int $id
 * @property int $quiz_id
 * @property int $team_id
 * @property int $persons
 * @property float $points
 * @property int $is_opened
 * @property string $comment
 * @property string $name
 * @property string $contact
 * @property int $place
 * @property int $created_at
 * @property int $updated_at
 */
class Participant extends ActiveRecord
{
    use ParticipantAttributeLabelsTrait;

    public static function tableName()
    {
        return 'quiz_participants';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * Создание новой модели викторины из формы
     *
     * @param Form $form Форма данных
     * @return self Созданная модель
     */
    public static function add(Form $form): self
    {
        $model = new self();
        $model->loadFromForm($form);
        return $model;
    }

    /**
     * Загрузка данных из формы в модель
     *
     * @param Form $form Форма данных
     * @return void
     */
    private function loadFromForm(Form $form): void
    {
        $this->quiz_id   = $form->quiz_id;
        $this->team_id   = $form->team_id;
        $this->persons   = $form->persons;
        $this->points    = $form->points;
        $this->place     = $form->place;
        $this->is_opened = $form->is_opened;
        $this->comment   = $form->comment;
        $this->name      = $form->name;
        $this->contact   = $form->contact;
    }

    /**
     * Обновление модели из формы
     *
     * @param Form $form Форма данных
     * @return void
     */
    public function edit(Form $form): void
    {
        $this->loadFromForm($form);
    }

    public function getQuiz()
    {
        return $this->hasOne(Quiz::class, ['id' => 'quiz_id']);
    }

    public function getTeam()
    {
        return $this->hasOne(Team::class, ['id' => 'team_id']);
    }
}
