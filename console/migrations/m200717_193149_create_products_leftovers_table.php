<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products_leftovers}}`.
 */
class m200717_193149_create_products_leftovers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%products_leftovers}}', [
            'id' => $this->primaryKey(),
            'productId' => $this->integer()->notNull(),
            'leftovers' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%products_leftovers}}');
    }
}
