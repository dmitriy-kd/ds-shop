<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sales}}`.
 */
class m200717_193248_create_sales_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sales}}', [
            'id' => $this->primaryKey(),
            'products' => $this->string(),
            'quantityProducts' => $this->string()->notNull(),
            'priceProducts' => $this->string()->notNull(),
            'amount' => $this->integer()->notNull(),
            'dateSale' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%sales}}');
    }
}
