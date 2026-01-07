<?php

declare(strict_types=1);

namespace app\modules\quiz\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use app\custom\interfaces\annotations\Sortable;
use app\custom\traits\models\VisibilityTrait;
use app\custom\traits\models\SortableTrait;
use app\modules\quiz\forms\backend\FaqItemForm as Form;
use app\modules\quiz\models\traits\FaqItemAttributeLabelsTrait;

/**
 * This is the model class for table "quiz_faq_items".
 *
 * @property int $id
 * @property string $answer
 * @property string $question
 * @property int $is_visible
 * @property int $created_at
 * @property int $updated_at
 */
class FaqItem extends ActiveRecord implements Sortable
{
    use FaqItemAttributeLabelsTrait;
    use VisibilityTrait;
    use SortableTrait;

    public const STATUS_INVISIBLE = 0;
    public const STATUS_VISIBLE = 1;

    public static function tableName()
    {
        return 'quiz_faq_items';
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
        $this->question   = $form->question;
        $this->answer     = $form->answer;
        $this->is_visible = $form->is_visible;
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
