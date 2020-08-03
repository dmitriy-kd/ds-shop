<?php

use yii\db\Migration;

/**
 * Class m200725_185047_alter_table_orders_add_column_amount
 */
class m200725_185047_alter_table_orders_add_column_amount extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('{{%orders}}', 'amount', $this->integer());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%orders}}', 'amount');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200725_185047_alter_table_orders_add_column_amount cannot be reverted.\n";

        return false;
    }
    */
}
