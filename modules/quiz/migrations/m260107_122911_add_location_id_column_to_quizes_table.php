<?php

namespace app\modules\quiz\migrations;

use yii\db\Migration;

/**
 * Handles adding location_id to table `{{%quizes}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%quiz_locations}}`
 */
class m260107_122911_add_location_id_column_to_quizes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%quizes}}', 'location_id', $this->integer());

        // creates index for column `location_id`
        $this->createIndex(
            '{{%idx-quizes-location_id}}',
            '{{%quizes}}',
            'location_id'
        );

        // add foreign key for table `{{%quiz_locations}}`
        $this->addForeignKey(
            '{{%fk-quizes-location_id}}',
            '{{%quizes}}',
            'location_id',
            '{{%quiz_locations}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%quiz_locations}}`
        $this->dropForeignKey(
            '{{%fk-quizes-location_id}}',
            '{{%quizes}}'
        );

        // drops index for column `location_id`
        $this->dropIndex(
            '{{%idx-quizes-location_id}}',
            '{{%quizes}}'
        );

        $this->dropColumn('{{%quizes}}', 'location_id');
    }
}
