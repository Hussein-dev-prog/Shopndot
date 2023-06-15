<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        //users
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'phone' => $this->string(255)->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'type' => $this->string()->notNull()->defaultValue('customer'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ], $tableOptions);

        //customers
        $this->createTable('{{%customers}}', [
            'id' => $this->integer(),
            'firstname' => $this->string()->notNull(),
            'lastname' => $this->string()->notNull()
        ]);
        $this->addForeignKey('FK_customer_id', '{{%customers}}', 'id', '{{%users}}', 'id');

        //suppliers
        $this->createTable('{{%suppliers}}', [
            'id' => $this->integer(),
            'name' => $this->string()->notNull(),
        ]);
        $this->addForeignKey('FK_supplier_id', '{{%suppliers}}', 'id', '{{%users}}', 'id');

        //admin
        $this->createTable('{{%admins}}', [
            'id' => $this->integer(),
            'firstname' => $this->string()->notNull(),
            'lastname' => $this->string()->notNull()
        ]);
        $this->addForeignKey('FK_admin_id', '{{%admins}}', 'id', '{{%users}}', 'id');

        //addresses
        $this->createTable('{{%addresses}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'country' => $this->string(255)->notNull(),
            'city' => $this->string(255)->notNull(),
            'street' => $this->string(255)->notNull(),
            'location' => $this->decimal(10, 7)
        ]);
        $this->addForeignKey(
            'fk-addresses-user_id',
            '{{%addresses}}',
            'user_id',
            '{{%users}}',
            'id'
        );

        //categories
        $this->createTable('{{%categories}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'parent_id' => $this->integer(),
        ]);
        $this->addForeignKey('fk_parentid', '{{%categories}}', 'parent_id', '{{%categories}}', 'id');

        //products
        $this->createTable('{{%products}}', [
            'id' => $this->primaryKey(),
            'supplier_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'price' => $this->decimal(10, 2)->notNull(),
            'image' => $this->string(2000),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey('fk_products_supplier', '{{%products}}', 'supplier_id', '{{%suppliers}}', 'id');
        $this->addForeignKey('fk_products_category', '{{%products}}', 'category_id', '{{%categories}}', 'id');

        //socials
        $this->createTable('{{%socials}}', [
            'id' => $this->primaryKey(),
            'supplier_id' => $this->integer()->notNull(),
            'provider' => $this->string()->notNull(),
            'link' => $this->string()->notNull(),
        ]);
        $this->addForeignKey(
            '{{%fk-socials-supplier_id}}',
            '{{%socials}}',
            'supplier_id',
            '{{%suppliers}}',
            'id'
        );

        //carts
        $this->createTable('{{%carts}}', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey('fk-carts-customer_id', '{{%carts}}', 'customer_id', '{{%customers}}', 'id');

        //cart items
        $this->createTable('{{%cart_items}}', [
            'cart_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'quantity' => $this->integer()->notNull(),
        ]);
        $this->addPrimaryKey('pk-cart_items', '{{%cart_items}}', ['cart_id', 'product_id']);
        $this->addForeignKey('fk-cart_items-cart_id', '{{%cart_items}}', 'cart_id', '{{%carts}}', 'id');
        $this->addForeignKey('fk-cart_items-product_id', '{{%cart_items}}', 'product_id', '{{%products}}', 'id');

        //orders
        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'total_cost' => $this->decimal(10, 2)->notNull(),
        ]);
        $this->addForeignKey('fk-orders-customer_id', '{{%orders}}', 'customer_id', '{{%customers}}', 'id');

        //order items
        $this->createTable('{{%order_items}}', [
            'order_id' => $this->integer()->notNull(),
            'product_name' => $this->string()->notNull(),
            'quantity' => $this->integer()->notNull(),
            'price' => $this->decimal(10, 2)->notNull(),
        ]);
        $this->addForeignKey('fk-order_items-order_id', '{{%order_items}}', 'order_id', '{{%orders}}', 'id');

        //wishlist
        $this->createTable('{{%wishlist_items}}', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey(
            'fk-wishlist-customerid',
            '{{%wishlist_items}}',
            'customer_id',
            '{{%customers}}',
            'id'
        );
        $this->addForeignKey(
            'fk-wishlist-productid',
            '{{%wishlist_items}}',
            'product_id',
            '{{%products}}',
            'id'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-carts-customer_id', '{{%carts}}');
        $this->dropForeignKey('{{%fk-socials-supplier_id}}', '{{%socials}}');
        $this->dropForeignKey('fk_parentid', '{{%categories}}');
        $this->dropForeignKey('fk_products_supplier', '{{%products}}');
        $this->dropForeignKey('fk_products_category', '{{%products}}');
        $this->dropForeignKey('fk-addresses-user_id', '{{%addresses}}');
        $this->dropForeignKey('FK_admin_id', '{{%admins}}');
        $this->dropForeignKey('FK_supplier_id', '{{%suppliers}}');
        $this->dropForeignKey('FK_customer_id', '{{%customers}}');

        $this->dropTable('{{%socials}}');
        $this->dropTable('{{%carts}}');
        $this->dropTable('{{%cart_items}}');
        $this->dropTable('{{%categories}}');
        $this->dropTable('{{%products}}');
        $this->dropTable('{{%addresses}}');
        $this->dropTable('{{%admins}}');
        $this->dropTable('{{%suppliers}}');
        $this->dropTable('{{%customers}}');
        $this->dropTable('{{%users}}');
    }
}
