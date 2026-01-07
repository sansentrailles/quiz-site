<?php

declare(strict_types=1);

namespace app\modules\quiz\forms\backend;

use app\custom\files\BaseImageFile;
use app\custom\traits\common\form\UploadFilesTrait;
use app\modules\quiz\models\Quiz;
use app\modules\quiz\models\Location;
use app\modules\quiz\models\traits\QuizAttributeLabelsTrait;
use yii\base\Model;
use yii\behaviors\SluggableBehavior;

class QuizForm extends Model
{
    use QuizAttributeLabelsTrait;
    use UploadFilesTrait;

    public $id;
    public $location_id;
    public $title;
    public $url;
    public $desc;
    public $text;
    public $date;
    public $price;
    public $time;
    public $items;
    public $is_visible;
    public $image;
    public $imageFile;
    public $quizImage;
    private $_labels = [];

    private $quiz;

    public function __construct(?Quiz $quiz = null, $config = [])
    {
        $this->quizImage = new BaseImageFile(Quiz::BUCKET_NAME_IMAGE);

        $this->quiz = $quiz;
        parent::__construct($config);
    }

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'slugAttribute' => 'url',
                // 'ensureUnique' => true,
            ],
        ];
    }

    public function init(): void
    {
        if (!$this->quiz) {
            return;
        }

        $this->id          = $this->quiz->id;
        $this->title       = $this->quiz->title;
        $this->location_id = $this->quiz->location_id;
        $this->url         = $this->quiz->url;
        $this->desc        = $this->quiz->desc;
        $this->date        = $this->quiz->date ? date('d.m.Y', $this->quiz->date): '';
        $this->time        = $this->quiz->time;
        $this->image       = $this->quiz->image;
        $this->text        = $this->quiz->text;
        $this->price       = $this->quiz->price;
        $this->items       = $this->quiz->items;
        $this->is_visible  = $this->quiz->is_visible;
    }

    public function rules()
    {
        return [
            [['is_visible', 'price'], 'integer'],
            [['title', 'time'], 'string', 'max' => 255],
            [['desc', 'text'], 'string'],
            [['items'], 'string'],
            [['title'], 'required', 'message' => 'Введите название'],
            [['url'], 'filter', 'filter' => 'trim'],
            ['url', 'filter', 'filter' => static function ($value) {
                $value = mb_strtolower($value);
                $value = trim($value);
                $value = str_replace(' ', '-', $value);
                return preg_replace('/[^a-zA-Z0-9-]/', '', $value);
            }],
            [['url'], 'unique', 'targetClass' => Quiz::class, 'filter' => function ($query) {
                if ($this->id) {
                    $query->andWhere('id <> :id', [':id' => $this->id]);
                }
            }],
            [['date'], 'string'],
            [['location_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Location::class,
                'targetAttribute' => ['location_id' => 'id']
            ],
            [['imageFile'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
            ['labels', 'safe'],
        ];
    }

    public function isAttributeChanged($attr)
    {
        if ($this->quiz) {
            return $this->quiz->isAttributeChanged($attr);
        }

        return false;
    }

    public function getIsNewRecord()
    {
        if ($this->quiz) {
            return false;
        }

        return true;
    }

    public function getUploadOptions()
    {
        return [
            'imageFile' => [
                'image' => [
                    'transform' => [
                        $this->quizImage->save(),
                    ],
                ],
            ],
        ];
    }

    public function getImagePath()
    {
        return $this->quiz->imagePath;
    }

    public function getLabels()
    {
        if (!empty($this->_labels)) {
            return $this->_labels;
        }

        if ($this->quiz) {
            // BaseHtml::getAttributeValue is looking for index resides in []
            // in this case it wiil be ''
            // because the attribute name is labels[]
            return ['' => $this->quiz->labelIds];
        }

        return [];
    }

    public function setLabels($value): void
    {
        $this->_labels = $value;
    }
}
