<?php

namespace app\modules\seo\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%scripts}}`.
 */
class m260209_191155_create_scripts_table extends Migration
{
    const TABLE_NAME = '{{%scripts}}';
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
            'code' => $this->text(),
            'place' => $this->smallInteger(),
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
