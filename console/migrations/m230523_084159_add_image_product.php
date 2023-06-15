<?php

use yii\db\Migration;

/**
 * Class m230523_084159_add_image_product
 */
class m230523_084159_add_image_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('products', 'image', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('products', 'image');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230523_084159_add_image_product cannot be reverted.\n";

        return false;
    }
    */
}
