<?php

namespace app\modules\quiz\migrations;

use yii\db\Migration;

/**
 * Handles adding contact_column_name to table `{{%quiz_participants}}`.
 */
class m260125_163406_add_contact_column_name_column_to_quiz_participants_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%quiz_participants}}', 'name', $this->string());
        $this->addColumn('{{%quiz_participants}}', 'contact', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%quiz_participants}}', 'name');
        $this->dropColumn('{{%quiz_participants}}', 'contact');
    }
}
