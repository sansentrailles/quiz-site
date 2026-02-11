<?php

namespace app\modules\seo\forms\backend;

use Yii;
use yii\base\Model;
use app\modules\seo\Module;
use app\modules\seo\models\Metric;
use app\modules\seo\models\traits\MetricAttributeLabelsTrait;

/**
 * MetricForm is the model behind the seo photo form.
 */
class MetricForm extends Model
{
    use MetricAttributeLabelsTrait;

    public $id;
    public $title;
    public $code;
    public $place;
    public $is_visible;

    private $metric;

    public function __construct(Metric $metric = null, $config = [])
    {
        $this->metric = $metric;
        parent::__construct($config);
    }

    public function init()
    {
        if (!$this->metric)
            return;

        $this->id         = $this->metric->id;
        $this->title      = $this->metric->title;
        $this->code       = $this->metric->code;
        $this->place      = $this->metric->place;
        $this->is_visible = $this->metric->is_visible;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_visible'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['code'], 'string'],
            [['place'], 'in', 'range' => array_keys(Metric::getPlaces())],
            [['place'], 'required', 'message' => 'Укажите расположение кода',]
        ];
    }

    public function getIsNewRecord()
    {
        if ($this->metric) {
            return false;
        }

        return true;
    }
}
