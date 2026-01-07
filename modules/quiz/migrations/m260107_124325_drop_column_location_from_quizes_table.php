<?php

namespace app\modules\quiz\migrations;

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%column_location_from_quizes}}`.
 */
class m260107_124325_drop_column_location_from_quizes_table extends Migration
{
    const TABLE_NAME = '{{%quizes}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn(self::TABLE_NAME, 'location');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn(self::TABLE_NAME, 'location', $this->string());
    }
}
