<?php

declare(strict_types=1);

namespace app\modules\quiz\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use app\modules\quiz\forms\backend\QuizBookingForm as Form;
use app\modules\quiz\models\traits\QuizBookingAttributeLabelsTrait;
use yii\helpers\Url;

/**
 * This is the model class for table "quiz_bookings".
 *
 * @property int $id
 * @property int $quiz_id
 * @property string $name
 * @property string $contact
 * @property string $team_name
 * @property int $persons
 * @property string $holiday
 * @property int $is_single
 * @property int $is_opened
 * @property int $created_at
 * @property int $updated_at
 */
class QuizBooking extends ActiveRecord
{
    use QuizBookingAttributeLabelsTrait;

    public static function tableName()
    {
        return 'quiz_bookings';
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
        $this->name      = $form->name;
        $this->contact   = $form->contact;
        $this->team_name = $form->team_name;
        $this->persons   = $form->persons;
        $this->holiday   = $form->holiday;
        $this->is_single = $form->is_single;
        $this->is_opened = $form->is_opened;
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
}
