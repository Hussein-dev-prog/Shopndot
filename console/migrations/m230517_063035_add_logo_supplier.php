<?php

use yii\db\Migration;

/**
 * Class m230517_063035_add_logo_supplier
 */
class m230517_063035_add_logo_supplier extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('suppliers', 'logo', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('suppliers', 'logo');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230517_063035_add_logo_supplier cannot be reverted.\n";

        return false;
    }
    */
}
