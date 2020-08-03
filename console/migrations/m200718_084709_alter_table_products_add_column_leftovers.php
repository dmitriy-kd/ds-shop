<?php

use yii\db\Migration;

/**
 * Class m200718_084709_alter_table_products_add_column_leftovers
 */
class m200718_084709_alter_table_products_add_column_leftovers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('{{%products}}', 'leftovers', $this->integer());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        
        $this->dropColumn('{{%products}}', 'leftovers');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200718_084709_alter_table_products_add_column_leftovers cannot be reverted.\n";

        return false;
    }
    */
}
