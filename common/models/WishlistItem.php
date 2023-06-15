<?php

namespace common\models;

use PhpParser\Node\Expr\FuncCall;
use Yii;
use yii\base\StaticInstanceInterface;

/**
 * This is the model class for table "wishlist_items".
 *
 * @property int $id
 * @property int $customer_id
 * @property int $product_id
 *
 * @property Customer $customer
 * @property Product $product
 */
class WishlistItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wishlist_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'product_id'], 'required'],
            [['customer_id', 'product_id'], 'integer'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::class, 'targetAttribute' => ['customer_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'product_id' => 'Product ID',
        ];
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public static function findCustomerItems($customer_id)
    {
        return static::findAll(['customer_id' => $customer_id]);
    }
    public static function findById($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function exists($customer_id, $product_id)
    {
        $item = static::findOne(['product_id' => $product_id, 'customer_id' => $customer_id]);
        if ($item) {
            return true;
        } else {
            return false;
        }
    }
}
