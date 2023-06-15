<?php

namespace customer\controllers;

use common\models\Product;
use common\models\WishlistItem;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class WishlistController extends Controller
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
        $items = WishlistItem::findCustomerItems(Yii::$app->user->identity);
        $products = [];
        foreach ($items as $item) {
            $product = Product::findById($item->product_id);
            $products[] = $product;
        }
        return $this->render(
            'index',
            [
                'items' => $products,
                'wishlistitems' => $items,
            ]
        );
    }

    public function actionDeleteitem()
    {
        $req = Yii::$app->request->get();
        $item = WishlistItem::findById($req['id']);

        if ($item->delete()) {
            Yii::$app->session->setFlash('success', 'wishlist item successfully removed');
        }
        return $this->redirect(['index']);
    }

    public function actionAdditem()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $req = Yii::$app->request->post();
        $product_id = $req['product_id'];
        $customer_id = Yii::$app->user->id;

        $existingItem = WishlistItem::exists($customer_id,$product_id);

        if ($existingItem) {
            return ['status' => 'error', 'message' => 'This item is already added to your wishlist.'];
        } else {
            $newitem = new WishlistItem();
            $newitem->product_id = $product_id;
            $newitem->customer_id = $customer_id;
            if ($newitem->validate() && $newitem->save()) {
                return ['status' => 'success', 'message' => 'Item added to wishlist successfully!'];
                // return $this->redirect(['index']);
            } else {
                return ['status' => 'error', 'message' => 'Failed to add item to your wishlist.'];
                // throw new \yii\web\HttpException(400);
            }
        }
    }
}
