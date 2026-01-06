<?php

namespace app\modules\quiz\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quizes}}`.
 */
class m260105_182210_create_quizes_table extends Migration
{
    const TABLE_NAME = '{{%quizes}}';
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
            'title' => $this->string(),
            'url' => $this->string(),
            'image' => $this->string(),
            'text' => $this->text(),
            'desc' => $this->text(),
            'location' => $this->string(),
            'date' => $this->integer(),
            'time' => $this->string(),
            'is_visible' => $this->integer()->defaultValue(false),
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
