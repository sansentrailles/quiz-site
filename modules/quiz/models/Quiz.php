<?php

declare(strict_types=1);

namespace app\modules\quiz\models;

use yii\db\ActiveRecord;
use app\custom\files\BaseImageFile;
use yii\behaviors\TimestampBehavior;
use app\custom\traits\models\VisibilityTrait;
use app\custom\interfaces\annotations\Fileable;
use app\modules\quiz\forms\backend\QuizForm as Form;
use app\modules\quiz\models\traits\QuizAttributeLabelsTrait;
use yii\helpers\Url;

enum QuizStatus: int
{
    case INVISIBLE = 0;
    case VISIBLE = 1;
}

/**
 * This is the model class for table "quizes".
 *
 * @property int $id
 * @property int $location_id
 * @property string $title
 * @property string $url
 * @property string $desc
 * @property string $text
 * @property string $image
 * @property string $time
 * @property string $items
 * @property int $price
 * @property int $date
 * @property int $is_visible
 * @property int $created_at
 * @property int $updated_at
 */
class Quiz extends ActiveRecord implements Fileable
{
    use QuizAttributeLabelsTrait;
    use VisibilityTrait;

    public const STATUS_INVISIBLE = 0;
    public const STATUS_VISIBLE = 1;

    public const BUCKET_NAME_IMAGE = 'quizImage';

    private $imageFile;

    public function __construct($config = [])
    {
        $this->imageFile = new BaseImageFile(self::BUCKET_NAME_IMAGE);

        parent::__construct($config);
    }

    public static function tableName()
    {
        return 'quizes';
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
        $this->title       = $form->title;
        $this->url         = $form->url;
        $this->price       = $form->price;
        $this->desc        = $form->desc;
        $this->text        = $form->text;
        $this->time        = $form->time;
        $this->image       = $form->image;
        $this->items       = $form->items;
        $this->location_id = $form->location_id;
        $this->is_visible  = $form->is_visible;
        
        // Преобразование даты в timestamp если это строка
        if (is_string($form->date)) {
            $this->date = strtotime($form->date);
        } else {
            $this->date = $form->date;
        }
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

    public function getImageFiles()
    {
        $files = [];
        if ($this->image) {
            $files[] = [
                'bucket' => $this->imageFile->getBucket(),
                'file' => $this->image,
            ];
        }
        return $files;
    }


    public function getNestedFiles(): array
    {
        $files = [];
        $files = array_merge($files, $this->getImageFiles());
        return $files;
    }

    public function getImagePath()
    {
        if ($this->image) {
            return $this->imageFile->getPath($this->image);
        }

        return null;
    }

    public function getLabels()
    {
        return $this->hasMany(Label::class, ['id' => 'label_id'])
            ->viaTable('quiz_label_refs', ['quiz_id' => 'id'])
            ->orderBy('title');
    }

    public function getLabelIds(): array
    {
        return array_map(static fn ($label) => $label->id, $this->labels);
    }

    public function getLink()
    {
        return Url::to(['/quiz/default/view', 'url' => $this->url]);
    }

    public function getItemsList()
    {
        return explode("\n", $this->items);
    }

    public function getLocation()
    {
        return $this->hasOne(Location::class, ['id' => 'location_id']);
    }

    public function GetisExpired()
    {
        // Если дата квиза меньше текущего времени, значит квиз уже прошел
        return $this->date < time();
    }

    public function getParticipants()
    {
        return $this->hasMany(Participant::class, ['quiz_id' => 'id'])
            ->orderBy([Participant::tableName().'.place' => SORT_ASC]);
    }
}
