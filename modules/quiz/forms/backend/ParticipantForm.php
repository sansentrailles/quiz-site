<?php

declare(strict_types=1);

namespace app\modules\quiz\forms\backend;

use app\modules\quiz\models\Participant;
use app\modules\quiz\models\Quiz;
use app\modules\quiz\models\Team;
use app\modules\quiz\models\traits\ParticipantAttributeLabelsTrait;
use yii\base\Model;

class ParticipantForm extends Model
{
    use ParticipantAttributeLabelsTrait;

    public $id;
    public $quiz_id;
    public $team_id;
    public $persons;
    public $points;
    public $place;
    private $participant;

    public function __construct(?Participant $participant = null, $config = [])
    {
        $this->participant = $participant;
        parent::__construct($config);
    }

    public function init(): void
    {
        if (!$this->participant) {
            return;
        }

        $this->id      = $this->participant->id;
        $this->quiz_id = $this->participant->quiz_id;
        $this->team_id = $this->participant->team_id;
        $this->persons = $this->participant->persons;
        $this->place   = $this->participant->place;
        $this->points  = $this->participant->points;
    }

    public function rules()
    {
        return [
            [['points'], 'double'],
            [['place'], 'integer'],
            [['points'], 'default', 'value' => 0],
            [['place'], 'default', 'value' => 0],
            [['persons'], 'integer', 'min' => 1, 'max' => 10],
            [['quiz_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Quiz::class,
                'targetAttribute' => ['quiz_id' => 'id']
            ],
            [['team_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Team::class,
                'targetAttribute' => ['team_id' => 'id']
            ],
            [['team_id'],
                'unique',
                'targetClass' => Participant::class,
                'filter' => function ($query) {
                    // Ограничиваем проверку только участниками текущего квиза
                    $query->andWhere(['quiz_id' => $this->quiz_id]);

                    // Исключаем текущую запись при обновлении
                    if ($this->id) {
                        $query->andWhere('id <> :id', [':id' => $this->id]);
                    }
                },
                'message' => 'Команда уже в списке участников'
            ],
        ];
    }

    public function isAttributeChanged($attr)
    {
        if ($this->participant) {
            return $this->participant->isAttributeChanged($attr);
        }

        return false;
    }

    public function getIsNewRecord()
    {
        if ($this->participant) {
            return false;
        }

        return true;
    }

    public function setQuiz($quizId)
    {
        $this->quiz_id = $quizId;
    }
}
