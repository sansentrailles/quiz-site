<?php

declare(strict_types=1);

namespace app\modules\quiz\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use app\custom\traits\models\VisibilityTrait;
use app\modules\quiz\forms\backend\LabelForm as Form;
use app\modules\quiz\models\traits\LabelAttributeLabelsTrait;

/**
 * This is the model class for table "quiz_labels".
 *
 * @property int $id
 * @property string $title
 * @property string $url
 * @property string $desc
 * @property string $location
 * @property string $text
 * @property string $image
 * @property string $time
 * @property int $price
 * @property int $date
 * @property int $is_visible
 * @property int $created_at
 * @property int $updated_at
 */
class Label extends ActiveRecord
{
    use LabelAttributeLabelsTrait;

    public static function tableName()
    {
        return 'quiz_labels';
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
        $this->title      = $form->title;
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
}
