<?php

declare(strict_types=1);

namespace app\modules\quiz\forms\backend;

use app\custom\files\BaseImageFile;
use app\custom\traits\common\form\UploadFilesTrait;
use app\modules\quiz\models\Label;
use app\modules\quiz\models\traits\LabelAttributeLabelsTrait;
use yii\base\Model;
use yii\behaviors\SluggableBehavior;

class LabelForm extends Model
{
    use LabelAttributeLabelsTrait;

    public $id;
    public $title;
    private $label;

    public function __construct(?Label $label = null, $config = [])
    {
        $this->label = $label;
        parent::__construct($config);
    }

    public function init(): void
    {
        if (!$this->label) {
            return;
        }

        $this->id         = $this->label->id;
        $this->title      = $this->label->title;
    }

    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
            [['title'], 'required', 'message' => 'Введите название'],
        ];
    }

    public function isAttributeChanged($attr)
    {
        if ($this->label) {
            return $this->label->isAttributeChanged($attr);
        }

        return false;
    }

    public function getIsNewRecord()
    {
        if ($this->label) {
            return false;
        }

        return true;
    }
}
