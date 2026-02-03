<?php

declare(strict_types=1);

namespace app\modules\quiz\forms\frontend;

use app\modules\quiz\models\QuizBooking;
use app\modules\quiz\models\Quiz;
use app\modules\quiz\models\traits\QuizBookingAttributeLabelsTrait;
use yii\base\Model;
use app\custom\traits\common\general\ClassNameTrait;

class QuizBookingForm extends Model
{
    use QuizBookingAttributeLabelsTrait;
    use ClassNameTrait;

    public $id;
    public $quizId;
    public $name;
    public $teamName;
    public $contact;
    public $persons;
    public $holiday;
    public $isSingle;
    public $isOpened;
    public $isAccept;
    private $quizBooking;

    public function __construct(?QuizBooking $quizBooking = null, $config = [])
    {
        $this->quizBooking = $quizBooking;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['isSingle', 'isOpened'], 'integer'],
            [['name', 'teamName', 'contact'], 'string'],
            [['name'], 'required', 'message' => 'Введите имя'],
            [['contact'], 'required', 'message' => 'Укажите контакт для связи'],
            // [['teamName'], 'required', 'message' => 'Введите название команды'],
            [['teamName'], 'required', 'message' => 'Введите название команды', 'when' => function($model) {
                // Валидируем как обязательное, только если isSingle НЕ выбрано (равно 0 или null)
                return !$model->isSingle;
            }],
            [['holiday'], 'string', 'max' => 100],
            [['persons'], 'integer', 'min' => 1, 'max' => 10],
            [['quizId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Quiz::class,
                'targetAttribute' => ['quizId' => 'id']
            ],
            [['isAccept'], 'required', 'requiredValue' => 1, 'message' => 'Необходимо принять условия политики'],
        ];
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
        $this->quizId = $quizId;
    }

    public function attributeLabels()
    {
        return [
            'teamName' => 'Название команды <span>*</span>',
            'name'     => 'Имя <span>*</span>',
            'contact'  => 'Контакт для связи (Телефон или Telegram)',
            'persons'  => 'Количество участников <span>*</span>',
            'holiday'  => 'ДР или другой праздничный повод',
            'isSingle' => 'Я один (готов присоединиться к команде)',
            'isOpened' => 'Готовы принимать новых участников в команду',
            'isAccept' => 'Согласен с условиями <a href="/policy">политики конфиденциальности</a>',
        ];
    }

    public function attributeHints()
    {
        return [
            'teamName' => '<span>*</span>',
            'name'     => '<span>*</span>',
        ];
    }
}
