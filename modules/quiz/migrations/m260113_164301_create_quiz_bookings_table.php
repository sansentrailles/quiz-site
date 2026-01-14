<?php

namespace app\modules\quiz\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quiz_bookings}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%quizes}}`
 */
class m260113_164301_create_quiz_bookings_table extends Migration
{
    const TABLE_NAME = '{{%quiz_bookings}}';
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
            'quiz_id' => $this->integer(),
            'name' => $this->string(),
            'team_name' => $this->string(),
            'contact' => $this->string(),
            'persons' => $this->smallInteger(),
            'holiday' => $this->string(),
            'is_single' => $this->boolean()->defaultValue(false),
            'is_opened' => $this->boolean()->defaultValue(false),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        // creates index for column `quiz_id`
        $this->createIndex(
            '{{%idx-quiz_bookings-quiz_id}}',
            '{{%quiz_bookings}}',
            'quiz_id'
        );

        // add foreign key for table `{{%quizes}}`
        $this->addForeignKey(
            '{{%fk-quiz_bookings-quiz_id}}',
            '{{%quiz_bookings}}',
            'quiz_id',
            '{{%quizes}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%quizes}}`
        $this->dropForeignKey(
            '{{%fk-quiz_bookings-quiz_id}}',
            '{{%quiz_bookings}}'
        );

        // drops index for column `quiz_id`
        $this->dropIndex(
            '{{%idx-quiz_bookings-quiz_id}}',
            '{{%quiz_bookings}}'
        );

        $this->dropTable(self::TABLE_NAME);
    }
}
