<?php

namespace app\modules\quiz\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quiz_label_refs}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%quizes}}`
 * - `{{%quiz_labels}}`
 */
class m260106_175557_create_quiz_label_refs_table extends Migration
{
    const TABLE_NAME = '{{%quiz_label_refs}}';
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
            'label_id' => $this->integer(),
        ], $tableOptions);

        // creates index for column `quiz_id`
        $this->createIndex(
            '{{%idx-quiz_label_refs-quiz_id}}',
            '{{%quiz_label_refs}}',
            'quiz_id'
        );

        // add foreign key for table `{{%quizes}}`
        $this->addForeignKey(
            '{{%fk-quiz_label_refs-quiz_id}}',
            '{{%quiz_label_refs}}',
            'quiz_id',
            '{{%quizes}}',
            'id',
            'CASCADE'
        );

        // creates index for column `label_id`
        $this->createIndex(
            '{{%idx-quiz_label_refs-label_id}}',
            '{{%quiz_label_refs}}',
            'label_id'
        );

        // add foreign key for table `{{%quiz_labels}}`
        $this->addForeignKey(
            '{{%fk-quiz_label_refs-label_id}}',
            '{{%quiz_label_refs}}',
            'label_id',
            '{{%quiz_labels}}',
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
            '{{%fk-quiz_label_refs-quiz_id}}',
            '{{%quiz_label_refs}}'
        );

        // drops index for column `quiz_id`
        $this->dropIndex(
            '{{%idx-quiz_label_refs-quiz_id}}',
            '{{%quiz_label_refs}}'
        );

        // drops foreign key for table `{{%quiz_labels}}`
        $this->dropForeignKey(
            '{{%fk-quiz_label_refs-label_id}}',
            '{{%quiz_label_refs}}'
        );

        // drops index for column `label_id`
        $this->dropIndex(
            '{{%idx-quiz_label_refs-label_id}}',
            '{{%quiz_label_refs}}'
        );

        $this->dropTable(self::TABLE_NAME);
    }
}
