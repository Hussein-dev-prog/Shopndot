<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\Supplier;
use common\models\Category;

class Product extends ActiveRecord
{
    public $imageFile;

    public static function tableName()
    {
        return 'products';
    }

    public function rules()
    {
        return [
            [['supplier_id', 'category_id', 'name', 'description', 'price', 'status', 'quantity'], 'required'],
            [['supplier_id', 'category_id', 'status'], 'integer'],
            [['name', 'description'], 'string'],
            [['image'], 'string', 'max' => 255],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            ['supplier_id', 'exist', 'targetClass' => Supplier::class, 'targetAttribute' => 'id'],
            ['category_id', 'exist', 'targetClass' => Category::class, 'targetAttribute' => 'id'],
            ['imageFile', 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, png'],

        ];
    }

    public function getSupplier()
    {
        return $this->hasOne(Supplier::class, ['id' => 'supplier_id']);
    }


    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public static function findById($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findAllBySupplier($supplier_id)
    {
        return static::findAll(['supplier_id' => $supplier_id]);
    }
    public function getOrders()
    {
        return $this->hasMany(OrderItem::class, ['product_id' => 'id']);
    }
    public function getWishlists()
    {
        return $this->hasMany(WishlistItem::class, ['product_id' => 'id']);
    }
    public function getCartItems()
    {
        return $this->hasOne(CartItem::class, ['product_id' => 'id']);
    }


    public function userWishlist($user)
    {
        return $this->getWishlists()->where(['customer_id' => $user->id])->one();
    }

    public function userCartItem($user)
    {
        $cart = Cart::findOne(['customer_id' => $user->id]);
        if ($cart) {
            return $this->getCartItems()->where(['cart_id' => $cart->id])->one();
        }
        return null;
    }
}
