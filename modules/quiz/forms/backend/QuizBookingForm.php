<?php

declare(strict_types=1);

namespace app\modules\quiz\forms\backend;

use app\modules\quiz\models\QuizBooking;
use app\modules\quiz\models\Quiz;
use app\modules\quiz\models\traits\QuizBookingAttributeLabelsTrait;
use yii\base\Model;

class QuizBookingForm extends Model
{
    use QuizBookingAttributeLabelsTrait;

    public $id;
    public $quiz_id;
    public $name;
    public $team_name;
    public $contact;
    public $persons;
    public $holiday;
    public $is_single;
    public $is_opened;
    public $place;
    private $quizBooking;

    public function __construct(?QuizBooking $quizBooking = null, $config = [])
    {
        $this->quizBooking = $quizBooking;
        parent::__construct($config);
    }

    public function init(): void
    {
        if (!$this->quizBooking) {
            return;
        }

        $this->id        = $this->quizBooking->id;
        $this->quiz_id   = $this->quizBooking->quiz_id;
        $this->team_name = $this->quizBooking->team_name;
        $this->name      = $this->quizBooking->name;
        $this->holiday   = $this->quizBooking->holiday;
        $this->contact   = $this->quizBooking->contact;
        $this->persons   = $this->quizBooking->persons;
        $this->is_single = $this->quizBooking->is_single;
        $this->is_opened = $this->quizBooking->is_opened;
    }

    public function rules()
    {
        return [
            [['is_single', 'is_opened'], 'integer'],
            [['name', 'team_name', 'contact', 'holiday'], 'string'],
            [['persons'], 'integer', 'min' => 1, 'max' => 10],
            [['quiz_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Quiz::class,
                'targetAttribute' => ['quiz_id' => 'id']
            ],
        ];
    }

    public function isAttributeChanged($attr)
    {
        if ($this->quizBooking) {
            return $this->quizBooking->isAttributeChanged($attr);
        }

        return false;
    }

    public function getIsNewRecord()
    {
        if ($this->quizBooking) {
            return false;
        }

        return true;
    }

    public function setQuiz($quizId)
    {
        $this->quiz_id = $quizId;
    }
}
