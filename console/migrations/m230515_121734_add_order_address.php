<?php

use Symfony\Component\Console\Input\StringInput;
use yii\db\Migration;

/**
 * Class m230515_121734_add_order_address
 */
class m230515_121734_add_order_address extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('orders','country',$this->string(255)->notNull());
        $this->addColumn('orders','city',$this->string(255)->notNull());
        $this->addColumn('orders','street',$this->string(255)->notNull());
        $this->addColumn('orders','location',$this->decimal(10,7));

        // set status column default value
        $this->alterColumn('orders','status', $this->integer()->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('order','country');
        $this->dropColumn('order','city');
        $this->dropColumn('order','street');
        $this->dropColumn('order','location');
    }

   
}
