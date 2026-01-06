<?php

declare(strict_types=1);

namespace app\modules\quiz\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "project_work_refs".
 *
 * @property int $quiz_id
 * @property int $label_id
 *
 * @property Quiz $quiz
 * @property Label $label
 */
class QuizLabel extends ActiveRecord
{
    public static function tableName()
    {
        return 'quiz_label_refs';
    }

    /**
     * @return ActiveQuery
     */
    public function getQuiz()
    {
        return $this->hasOne(Quiz::class, ['id' => 'quiz_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getLabel()
    {
        return $this->hasOne(Label::class, ['id' => 'label_id']);
    }

    public static function createByPrimaryKey($quiz_id, $label_id)
    {
        $ref = new self();

        $ref->quiz_id = $quiz_id;
        $ref->label_id = $label_id;

        return $ref;
    }
}
