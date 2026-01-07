<?php

declare(strict_types=1);

namespace app\modules\quiz\forms\backend;

use app\modules\quiz\models\FaqItem;
use app\modules\quiz\models\traits\FaqItemAttributeLabelsTrait;
use yii\base\Model;

class FaqItemForm extends Model
{
    use FaqItemAttributeLabelsTrait;

    public $id;
    public $question;
    public $answer;
    public $is_visible;
    private $faqItem;

    public function __construct(?FaqItem $faqItem = null, $config = [])
    {
        $this->faqItem = $faqItem;
        parent::__construct($config);
    }

    public function init(): void
    {
        if (!$this->faqItem) {
            return;
        }

        $this->id         = $this->faqItem->id;
        $this->question   = $this->faqItem->question;
        $this->answer     = $this->faqItem->answer;
        $this->is_visible = $this->faqItem->is_visible;
    }

    public function rules()
    {
        return [
            [['is_visible'], 'integer'],
            [['question', 'answer'], 'string'],
            [['question'], 'required', 'message' => 'Введите вопрос'],
            [['answer'], 'required', 'message' => 'Введите ответ'],
        ];
    }

    public function isAttributeChanged($attr)
    {
        if ($this->faqItem) {
            return $this->faqItem->isAttributeChanged($attr);
        }

        return false;
    }

    public function getIsNewRecord()
    {
        if ($this->faqItem) {
            return false;
        }

        return true;
    }
}
