<?php

namespace customer\controllers;

use common\models\Address;
use common\models\Cart;
use common\models\CartItem;
use common\models\Customer;
use common\models\Product;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

use function PHPUnit\Framework\throwException;

class CartController extends Controller
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
        $cart_id = Cart::findByUserId(Yii::$app->user->identity);
        $items = CartItem::findItemsByCartId($cart_id->id);

        $products = [];
        foreach ($items as $item) {
            $product = Product::findById($item->product_id);
            $products[] = $product;
        }

        return $this->render(
            'index',
            [
                'cart_id' => $cart_id,
                'items' => $items,
                'products' => $products,
            ]

        );
    }

    public function actionAddtocart()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $req = Yii::$app->request->post();
        $product_id = $req['product_id'];
        $cart_id = Cart::findByUserId(Yii::$app->user->identity)->id;
        $qty = $req['quantity'];

        $cartitem = CartItem::findItem($cart_id, $product_id);
        $productqty = Product::find()->where(['id' => $product_id])->one();

        if ($cartitem) {
            if ($qty > $productqty->quantity) {
                return ['status' => 'error', 'message' => 'Quantity exceeds product quantity'];
            } else {
                $cartitem->quantity += $qty;
            }
            if ($cartitem->validate() && $cartitem->save()) {
                return ['status' => 'success', 'message' => 'This item is already added to cart! Quantity increased by' . $qty];
            } else {
                return ['status' => 'error', 'message' => 'invalid input'];
            }
        } else {
            $cartitem = new CartItem();
            if ($qty > $productqty->quantity) {
                return ['status' => 'error', 'message' => 'Quantity exceeds product quantity'];
            } else {
                $cartitem->cart_id = $cart_id;
                $cartitem->product_id = $product_id;
                $cartitem->quantity = $qty;
            }


            if ($cartitem->validate() && $cartitem->save()) {
                return ['status' => 'success', 'message' => 'Item added to cart successfully!'];
                // return $this->redirect(['index']);
            } else {
                return ['status' => 'error', 'message' => 'Failed to add item to cart.'];
                // throw new \yii\web\HttpException(400);
            }
        }
    }
    public function actionCheckout()
    {
        $req = Yii::$app->request->post();
        // var_dump($req);
        $user = Yii::$app->user->identity;
        $customer = Customer::findById($user);
        $email = $user->email;

        $addresses = Address::findAllByUserId($user);
        if (!$addresses) {
            return $this->redirect(['profile/newaddress']); // Replace 'controller/action' with the
        }
        $cart_id = $req['cart_id'];
        $qty = explode(',', $req['quantities']);

        $items = CartItem::findItemsByCartId($cart_id);

        $products = [];
        foreach ($items as $item) {
            $product = Product::findById($item->product_id);
            $products[] = $product;
        }


        return $this->render(
            'checkout',
            [
                'quantities' => $qty,
                'email' => $email,
                'user' => $user,
                'customer' => $customer,
                'addresses' => $addresses,
                'products' => $products,
                'cart_id' => $cart_id

            ]
        );
    }

    public function actionDeleteitem()
    {
        $req = Yii::$app->request->get();
        $cart = $req['cart_id'];
        $product = $req['product_id'];
        $item = CartItem::findItem($cart, $product);

        if ($item->delete()) {
            Yii::$app->session->setFlash('success', 'successfully removed');
        }
        return $this->redirect(['index']);
    }
}
