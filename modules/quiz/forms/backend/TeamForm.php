<?php

declare(strict_types=1);

namespace app\modules\quiz\forms\backend;

use app\modules\quiz\models\Team;
use app\modules\quiz\models\traits\TeamAttributeLabelsTrait;
use yii\base\Model;

class TeamForm extends Model
{
    use TeamAttributeLabelsTrait;

    public $id;
    public $title;
    private $team;

    public function __construct(?Team $team = null, $config = [])
    {
        $this->team = $team;
        parent::__construct($config);
    }

    public function init(): void
    {
        if (!$this->team) {
            return;
        }

        $this->id    = $this->team->id;
        $this->title = $this->team->title;
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
        if ($this->team) {
            return $this->team->isAttributeChanged($attr);
        }

        return false;
    }

    public function getIsNewRecord()
    {
        if ($this->team) {
            return false;
        }

        return true;
    }
}
