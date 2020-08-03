<?php

use yii\db\Migration;

/**
 * Class m200718_085013_drop_table_products_leftovers
 */
class m200718_085013_drop_table_products_leftovers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->dropTable('{{%products_leftovers}}');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('{{%products_leftovers}}', [
            'id' => $this->primaryKey(),
            'productId' => $this->integer()->notNull(),
            'leftovers' => $this->integer()
        ]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200718_085013_drop_table_products_leftovers cannot be reverted.\n";

        return false;
    }
    */
}
