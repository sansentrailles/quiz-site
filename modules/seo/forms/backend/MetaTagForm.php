<?php

namespace app\modules\seo\forms\backend;

use Yii;
use yii\base\Model;
use app\modules\seo\Module;
use app\modules\seo\models\MetaTag;
use app\modules\seo\models\traits\MetaTagAttributeLabelsTrait;

/**
 * MetaTagForm is the model behind the seo photo form.
 */
class MetaTagForm extends Model
{
    use MetaTagAttributeLabelsTrait;

    public $id;
    public $name;
    public $content;
    public $is_visible;

    private $metaTag;

    public function __construct(MetaTag $metaTag = null, $config = [])
    {
        $this->metaTag = $metaTag;
        parent::__construct($config);
    }

    public function init()
    {
        if (!$this->metaTag)
            return;

        $this->id         = $this->metaTag->id;
        $this->name       = $this->metaTag->name;
        $this->content    = $this->metaTag->content;
        $this->is_visible = $this->metaTag->is_visible;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_visible'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['content'], 'string'],
            [['name'], 'required', 'message' => 'Введите атрибут name',]
        ];
    }

    public function getIsNewRecord()
    {
        if ($this->metaTag) {
            return false;
        }

        return true;
    }
}
