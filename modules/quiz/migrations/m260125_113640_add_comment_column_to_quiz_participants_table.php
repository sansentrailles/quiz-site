<?php

namespace app\modules\quiz\migrations;

use yii\db\Migration;

/**
 * Handles adding comment to table `{{%quiz_participants}}`.
 */
class m260125_113640_add_comment_column_to_quiz_participants_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%quiz_participants}}', 'comment', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%quiz_participants}}', 'comment');
    }
}
