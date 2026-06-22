<?php

namespace app\modules\geo\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%geo_points}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%geo_routes}}`
 */
class m260619_085138_create_geo_points_table extends Migration
{
    const TABLE_NAME = '{{%geo_points}}';
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
            'route_id' => $this->integer(),
            'title' => $this->string(),
            'longitude' => $this->decimal(11, 8)->notNull(),
            'latitude' => $this->decimal(11, 8)->notNull(),
            'is_visible' => $this->boolean()->defaultValue(false),
            'ord' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        // creates index for column `route_id`
        $this->createIndex(
            '{{%idx-geo_points-route_id}}',
            '{{%geo_points}}',
            'route_id'
        );

        // add foreign key for table `{{%geo_routes}}`
        $this->addForeignKey(
            '{{%fk-geo_points-route_id}}',
            '{{%geo_points}}',
            'route_id',
            '{{%geo_routes}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%geo_routes}}`
        $this->dropForeignKey(
            '{{%fk-geo_points-route_id}}',
            '{{%geo_points}}'
        );

        // drops index for column `route_id`
        $this->dropIndex(
            '{{%idx-geo_points-route_id}}',
            '{{%geo_points}}'
        );

        $this->dropTable(self::TABLE_NAME);
    }
}
