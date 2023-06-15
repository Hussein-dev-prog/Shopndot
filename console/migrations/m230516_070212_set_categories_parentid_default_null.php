<?php

use yii\db\Migration;

/**
 * Class m230516_070212_set_categories_parentid_default_null
 */
class m230516_070212_set_categories_parentid_default_null extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('categories','parent_id',$this->integer()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230516_070212_set_categories_parentid_default_null cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230516_070212_set_categories_parentid_default_null cannot be reverted.\n";

        return false;
    }
    */
}
