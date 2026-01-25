<?php

namespace app\modules\quiz\migrations;

use yii\db\Migration;

/**
 * Handles adding is_opened to table `{{%quiz_participants}}`.
 */
class m260122_150211_add_is_opened_column_to_quiz_participants_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%quiz_participants}}', 'is_opened', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%quiz_participants}}', 'is_opened');
    }
}
