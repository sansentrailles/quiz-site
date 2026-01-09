<?php

namespace app\modules\quiz\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quiz_participants}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%quizes}}`
 * - `{{%quiz_teams}}`
 */
class m260108_204956_create_quiz_participants_table extends Migration
{
    const TABLE_NAME = '{{%quiz_participants}}';
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
            'team_id' => $this->integer(),
            'persons' => $this->integer(),
            'points' => $this->decimal()->defaultValue(0),
            'place' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        // creates index for column `quiz_id`
        $this->createIndex(
            '{{%idx-quiz_participants-quiz_id}}',
            '{{%quiz_participants}}',
            'quiz_id'
        );

        // add foreign key for table `{{%quizes}}`
        $this->addForeignKey(
            '{{%fk-quiz_participants-quiz_id}}',
            '{{%quiz_participants}}',
            'quiz_id',
            '{{%quizes}}',
            'id',
            'CASCADE'
        );

        // creates index for column `team_id`
        $this->createIndex(
            '{{%idx-quiz_participants-team_id}}',
            '{{%quiz_participants}}',
            'team_id'
        );

        // add foreign key for table `{{%quiz_teams}}`
        $this->addForeignKey(
            '{{%fk-quiz_participants-team_id}}',
            '{{%quiz_participants}}',
            'team_id',
            '{{%quiz_teams}}',
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
            '{{%fk-quiz_participants-quiz_id}}',
            '{{%quiz_participants}}'
        );

        // drops index for column `quiz_id`
        $this->dropIndex(
            '{{%idx-quiz_participants-quiz_id}}',
            '{{%quiz_participants}}'
        );

        // drops foreign key for table `{{%quiz_teams}}`
        $this->dropForeignKey(
            '{{%fk-quiz_participants-team_id}}',
            '{{%quiz_participants}}'
        );

        // drops index for column `team_id`
        $this->dropIndex(
            '{{%idx-quiz_participants-team_id}}',
            '{{%quiz_participants}}'
        );

        $this->dropTable(self::TABLE_NAME);
    }
}
