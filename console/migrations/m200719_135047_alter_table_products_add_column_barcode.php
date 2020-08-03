<?php

use yii\db\Migration;

/**
 * Class m200719_135047_alter_table_products_add_column_barcode
 */
class m200719_135047_alter_table_products_add_column_barcode extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('{{%products}}', 'barcode', $this->integer());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%products}}', 'barcode');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200719_135047_alter_table_products_add_column_barcode cannot be reverted.\n";

        return false;
    }
    */
}
