<?php

namespace app\modules\quiz\migrations;

use yii\db\Migration;

/**
 * Handles adding items to table `{{%quizes}}`.
 */
class m260107_111815_add_items_column_to_quizes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%quizes}}', 'items', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%quizes}}', 'items');
    }
}
