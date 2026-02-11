<?php

namespace app\modules\seo\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\seo\models\traits\MetaTagAttributeLabelsTrait;
use app\modules\seo\forms\backend\MetaTagForm as Form;
use app\custom\traits\common\general\ClassNameTrait;
use app\custom\traits\models\VisibilityTrait;
use app\custom\traits\models\SortableTrait;

/**
 * This is the model class for table "seo_meta_tags".
 *
 * @property integer $id
 * @property string $name
 * @property string $content
 * @property integer $is_visible
 * @property integer $created_at
 * @property integer $updated_at
 *
 */
class MetaTag extends \yii\db\ActiveRecord
{
    use MetaTagAttributeLabelsTrait;
    use VisibilityTrait;

    const STATUS_INVISIBLE = 0;
    const STATUS_VISIBLE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seo_meta_tags';
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
        $model = new MetaTag();

        $model->name       = $form->name;
        $model->content    = $form->content;
        $model->is_visible = $form->is_visible;

        return $model;
    }

    public function edit(Form $form)
    {
        $this->name       = $form->name;
        $this->content    = $form->content;
        $this->is_visible = $form->is_visible;
    }

}
