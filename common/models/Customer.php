<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "customers".
 *
 * @property int|null $id
 * @property string $firstname
 * @property string $lastname
 *
 * @property Cart[] $carts
 * @property User $id0
 * @property Order[] $orders
 * @property WishlistItem[] $wishlistItems
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['firstname', 'lastname'], 'required'],
            [['firstname', 'lastname'], 'string', 'max' => 255],
            [['firstname'], 'unique'],
            [['lastname'], 'unique'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
        ];
    }

    /**
     * Gets query for [[Carts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::class, ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Id0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(User::class, ['id' => 'id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[WishlistItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWishlistItems()
    {
        return $this->hasMany(WishlistItem::class, ['customer_id' => 'id']);
    }

    public static function primaryKey()
    {
        return ['id'];
    }


    public static function findById($id)
    {
        return static::findOne(['id' => $id]);
    }
}
