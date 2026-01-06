<?php

namespace app\modules\quiz\migrations;

use yii\db\Migration;

/**
 * Handles adding price to table `{{%quizes}}`.
 */
class m260106_170713_add_price_column_to_quizes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%quizes}}', 'price', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%quizes}}', 'price');
    }
}
