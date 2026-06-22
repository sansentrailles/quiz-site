<?php

declare(strict_types=1);

namespace app\modules\geo\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use app\custom\traits\models\VisibilityTrait;
use app\modules\geo\forms\backend\RouteForm as Form;
use app\modules\geo\models\traits\RouteAttributeLabelsTrait;

/**
 * This is the model class for table "geo_routes".
 *
 * @property int $id
 * @property string $title
 * @property int $created_at
 * @property int $updated_at
 */
class Route extends ActiveRecord
{
    use RouteAttributeLabelsTrait;
    use VisibilityTrait;

    public const STATUS_INVISIBLE = 0;
    public const STATUS_VISIBLE = 1;

    public static function tableName()
    {
        return 'geo_routes';
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
        $this->title = $form->title;
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

    public function getPoints()
    {
        return $this->hasMany(Point::class, ['route_id' => 'id']);
    }

    public function getVisiblePoints()
    {
        return $this->getPoints()
            ->andWhere(['is_visible' => Point::STATUS_VISIBLE])
            ->orderBy(['ord' => SORT_ASC]);
    }

    public function fields()
    {
        return [
            'title',
            'points' => static fn ($model) => $model->visiblePoints,
        ];
    }
}
