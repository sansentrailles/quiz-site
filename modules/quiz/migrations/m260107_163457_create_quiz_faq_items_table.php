<?php

namespace app\modules\quiz\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quiz_faq_items}}`.
 */
class m260107_163457_create_quiz_faq_items_table extends Migration
{
    const TABLE_NAME = '{{%quiz_faq_items}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'question' => $this->text(),
            'answer' => $this->text(),
            'is_visible' => $this->boolean()->defaultValue(false),
            'ord' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
