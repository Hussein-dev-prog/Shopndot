<?php

namespace customer\controllers;

use common\models\Address;
use common\models\Cart;
use common\models\CartItem;
use common\models\Customer;
use common\models\Order;
use common\models\OrderItem;
use common\models\Product;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class OrderController extends Controller
{
    public function behaviors()
    {
        return
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['index'],
                    'rules' => [
                        [
                            'actions' => ['index'],
                            'allow' => true,
                            'roles' => ['@'],
                        ]
                    ]
                ]
            ];
    }
    public function actionIndex()
    {
    }

    public function actionCreate()
    {
        $req = Yii::$app->request->post();
        // var_dump($req);
        // die;
        $customer_id = $req['customer_id'];
        $order_items_names = explode(',', $req['order_items_names']);
        $order_items_prices = explode(',', $req['order_items_prices']);
        $total = $req['total'];
        $qty = explode(',', $req['quantities']);
        $address = explode(',', $req['address']);
        $cart_id = $req['cart_id'];
        $supplier_id  = $req['supplier_id'];
        //create order
        $neworder = new Order();
        $neworder->customer_id = $customer_id;
        $neworder->total_cost = $total;
        $neworder->status = 0;
        $neworder->country = $address[0];
        $neworder->city = $address[1];
        $neworder->street = $address[2];
        $neworder->location = $address[3];
        if ($neworder->save()) {
            Yii::$app->session->setFlash('success', 'Order placed successfully!');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to place Order: ' . implode(', ', $neworder->getFirstErrors()));
        }

        // clear cart
        if (CartItem::deleteItemsByCartId($cart_id)) {
            Yii::$app->session->setFlash('success', 'cart cleared successfully!');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to clear cart: ');
        }
        // create order_items
        // Create order_items
        foreach ($order_items_names as $key => $order_item) {
            $neworder_item = new OrderItem();
            $neworder_item->order_id = $neworder->id;
            $neworder_item->product_id = $order_item;
            $neworder_item->quantity = $qty[$key];
            $neworder_item->price = $order_items_prices[$key];

            // Fetch product name based on product_id
            $product = Product::findOne($order_item);
            if ($product) {
                $newQuantity = $product->quantity - $qty[$key];
                $product->quantity = $newQuantity;
                if ($product->save()) {
                    Yii::$app->session->setFlash('success', 'Product quantity updated successfully!');
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to update product quantity: ' . implode(', ', $product->getFirstErrors()));
                }
                $neworder_item->product_details = $product->toArray();
            } else {
                $neworder_item->product_details = [
                    'name' => 'Unknown Product',
                    'price' => $order_items_prices[$key],
                    'quantity' => $qty[$key],
                    'orderId' => $neworder->id,
                ];
            }

            if ($neworder_item->save()) {
                Yii::$app->session->setFlash('success', 'Order item created successfully!');
            } else {
                Yii::$app->session->setFlash('error', 'Failed to create Order item: ' . implode(', ', $neworder_item->getFirstErrors()));
            }
        }

        return $this->redirect(['site/index']);
    }
}
