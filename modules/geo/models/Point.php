<?php

declare(strict_types=1);

namespace app\modules\geo\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use app\custom\interfaces\annotations\Sortable;
use app\custom\traits\models\VisibilityTrait;
use app\custom\traits\models\SortableTrait;
use app\modules\geo\forms\backend\PointForm as Form;
use app\modules\geo\models\traits\PointAttributeLabelsTrait;

/**
 * This is the model class for table "geo_points".
 *
 * @property int $id
 * @property int $route_id
 * @property string $title
 * @property float $longitude
 * @property float $latitude
 * @property int $created_at
 * @property int $updated_at
 */
class Point extends ActiveRecord implements Sortable
{
    use PointAttributeLabelsTrait;
    use VisibilityTrait;
    use SortableTrait;

    public const STATUS_INVISIBLE = 0;
    public const STATUS_VISIBLE = 1;

    public static function tableName()
    {
        return 'geo_points';
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
        $this->route_id = $form->route_id;
        $this->title = $form->title;
        $this->longitude = $form->longitude;
        $this->latitude = $form->latitude;
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

    public function getRoute()
    {
        return $this->hasOne(Route::class, ['id' => 'route_id']);
    }

    public function fields()
    {
        return [
            'title',
            'longitude',
            'latitude',
        ];
    }
}
