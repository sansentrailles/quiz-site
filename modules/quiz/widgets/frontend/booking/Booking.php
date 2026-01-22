<?php

namespace app\modules\quiz\widgets\frontend\booking;

use Yii;
use yii\base\Widget;
use app\modules\quiz\forms\frontend\QuizBookingForm;

class Booking extends Widget
{
    public $action;
    public $title;
    public $template;
    public $quizId;

    public function run()
    {
        $model = new QuizBookingForm();
        $model->setQuiz($this->quizId);

        $this->template ??= 'default';

        return $this->render($this->template, [
            'model' => $model,
            'action' => $this->action,
        ]);
    }

}
