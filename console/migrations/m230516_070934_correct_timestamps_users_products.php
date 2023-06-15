<?php

use yii\db\Migration;

/**
 * Class m230516_070934_correct_timestamps_users_products
 */
class m230516_070934_correct_timestamps_users_products extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('products','created_at',$this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'));
        $this->alterColumn('products','updated_at',$this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'));
        $this->alterColumn('users','created_at',$this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'));
        $this->alterColumn('users','updated_at',$this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('products','created_at',$this->integer()->notNull());
        $this->alterColumn('products','updated_at',$this->integer()->notNull());
        $this->alterColumn('users','created_at',$this->integer()->notNull());
        $this->alterColumn('users','updated_at',$this->integer()->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230516_070934_correct_timestamps_users_products cannot be reverted.\n";

        return false;
    }
    */
}
