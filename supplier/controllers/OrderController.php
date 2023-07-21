<?php

namespace supplier\controllers;

use Yii;
use yii\db\Expression;
use yii\rest\ActiveController;

use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\web\Request;
use common\helpers\Helper;
use common\models\Order;
use common\models\OrderStatus;
use common\models\OrderItem;
use common\models\Product;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\data\Pagination;
use yii\web\Controller;

class OrderController extends Controller
{
    // public $modelClass = 'common\models\Order';

    // public function actions()
    // {
    //     $actions = parent::actions();
    //     unset($actions['index']);
    //     return $actions;
    // }
    public function actionIndex()
    {
        // $actions = parent::actions();
        // unset($actions['index']);
        return $this->render('index');
    }
    // public function behaviors()
    // {
    //     $behaviors = parent::behaviors();

    //     // Override the content negotiation behavior to always return JSON
    //     $behaviors['contentNegotiator']['formats'] = [
    //         'application/json' => Response::FORMAT_JSON,
    //     ];

    //     return $behaviors;
    // }
    // public function behaviors()
    // {
    //     return [
    //         'access' => [
    //             'class' => AccessControl::class,
    //             'rules' => [
    //                 [
    //                     'actions' => ['index', 'view', 'update', 'create', 'delete', 'update-status', 'details'],
    //                     'allow' => true,
    //                     'roles' => ['@'],
    //                 ],
    //             ],
    //         ],
    //         'verbs' => [
    //             'class' => VerbFilter::class,
    //             'actions' => [
    //                 'delete' => ['POST'],
    //             ],
    //         ],
    //     ];
    // }


    // ...

    public function actionDetails($id)
    {
        $query = OrderItem::find()
            ->leftJoin('orders', 'order_items.order_id = orders.id')
            ->where(['orders.id' => $id]);

        $orderItems = $query->all();
        foreach ($orderItems as $orderItem) {
            $products[] =  $orderItem->product_details;
        }
        // var_dump($products);
        return $this->render('details', [
            'products' => $products,
        ]);
    }
    public function actionUpdate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $req = Yii::$app->request->post();
        $id = $req['id'];
        $action = $req['action'];

        $order = Order::find()->where(['id' => $id])->one();
        if ($action == 'accept') {
            $order->orderStatusId = 2;
            if ($order->save()) {
                return ['status' => 'success', 'message' => 'Order Accepted', 'color' => $order->orderStatus->color, 'name' => $order->orderStatus->name];
            } else {
                return ['status' => 'error', 'message' => 'Error accepting the order'];
            }
        } elseif ($action == 'reject') {
            $OrderDetails = OrderItem::find()->where(['order_id' => $id])->one();
            $product = Product::find()->where(['id' => $OrderDetails->product_id])->one();
            $product->quantity = $product->quantity + $OrderDetails->quantity;
            $product->save();
            $order->orderStatusId = 4;
            if ($order->save()) {
                return ['status' => 'success', 'message' => 'Order Rejected', 'color' => $order->orderStatus->color, 'name' => $order->orderStatus->name, 'orderStatusId' => $order->orderStatusId];
            } else {
                return ['status' => 'error', 'message' => 'Error rejecting the order'];
            }
        }
        // Return a default response if the action is not 'accept' or 'reject'
        return ['status' => 'error', 'message' => 'Invalid action'];
    }
    public function beforeAction($action)
    {
        if ($action->id === 'update') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }
}
