<?php

declare(strict_types=1);

namespace app\modules\quiz\models;

use yii\db\ActiveRecord;
use app\custom\files\BaseImageFile;
use yii\behaviors\TimestampBehavior;
use app\custom\traits\models\VisibilityTrait;
use app\custom\interfaces\annotations\Fileable;
use app\modules\quiz\forms\backend\LocationForm as Form;
use app\modules\quiz\models\traits\LocationAttributeLabelsTrait;
use yii\helpers\Url;

/**
 * This is the model class for table "quiz_locations".
 *
 * @property int $id
 * @property string $title
 * @property string $desc
 * @property string $address
 * @property string $workmode
 * @property string $longitude
 * @property string $latutude
  * @property int $created_at
 * @property int $updated_at
 */
class Location extends ActiveRecord
{
    use LocationAttributeLabelsTrait;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public static function tableName()
    {
        return 'quiz_locations';
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
        $this->title     = $form->title;
        $this->address   = $form->address;
        $this->desc      = $form->desc;
        $this->latitude  = $form->latitude;
        $this->longitude = $form->longitude;
        $this->workmode  = $form->workmode;
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
