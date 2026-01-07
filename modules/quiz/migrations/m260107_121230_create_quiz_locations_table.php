<?php

namespace app\modules\quiz\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quiz_locations}}`.
 */
class m260107_121230_create_quiz_locations_table extends Migration
{
    const TABLE_NAME = '{{%quiz_locations}}';
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
            'desc' => $this->text(),
            'address' => $this->string(),
            'workmode' => $this->text(),
            'longitude' => $this->string(),
            'latitude' => $this->string(),
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
