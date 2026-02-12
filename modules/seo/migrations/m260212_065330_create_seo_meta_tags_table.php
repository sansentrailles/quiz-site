<?php

namespace app\modules\seo\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%seo_meta_tags}}`.
 */
class m260212_065330_create_seo_meta_tags_table extends Migration
{
    const TABLE_NAME = '{{%seo_meta_tags}}';
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
            'name' => $this->string(),
            'content' => $this->text(),
            'is_visible' => $this->boolean()->defaultValue(false),
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
