<?php

namespace app\modules\seo\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\seo\models\traits\MetricAttributeLabelsTrait;
use app\modules\seo\forms\backend\MetricForm as Form;
use app\custom\interfaces\annotations\Sortable;
use app\custom\traits\models\VisibilityTrait;
use app\custom\traits\models\SortableTrait;

/**
 * This is the model class for table "scripts".
 *
 * @property integer $id
 * @property string $title
 * @property string $code
 * @property integer $place
 * @property integer $is_visible
 * @property integer $ord
 * @property integer $created_at
 * @property integer $updated_at
 *
 */
class Metric extends \yii\db\ActiveRecord implements Sortable
{
    use MetricAttributeLabelsTrait;
    use VisibilityTrait;
    use SortableTrait;

    const STATUS_INVISIBLE = 0;
    const STATUS_VISIBLE = 1;

    const PLACE_HEAD = 1;
    const PLACE_BODY = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'scripts';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public static function add(Form $form)
    {
        $model = new Metric();

        $model->title      = $form->title;
        $model->code       = $form->code;
        $model->place      = $form->place;
        $model->is_visible = $form->is_visible;

        return $model;
    }

    public function edit(Form $form)
    {
        $this->title      = $form->title;
        $this->code       = $form->code;
        $this->place      = $form->place;
        $this->is_visible = $form->is_visible;
    }

    public static function getPlaces()
    {
        return [
            self::PLACE_BODY => 'внутри body',
            self::PLACE_HEAD => 'внутри head',
        ];
    }
}
