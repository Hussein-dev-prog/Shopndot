<?php

namespace supplier\controllers;

use Yii;
use yii\db\Expression;

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
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\data\Pagination;

class OrderController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'update', 'create', 'delete', 'update-status', 'details'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        $orders = Order::find()
            ->leftJoin('order_items', 'order_items.order_id = orders.id')
            ->andWhere(new Expression('JSON_EXTRACT(JSON_UNQUOTE(product_details), "$.supplier_id") = :supplierId', [':supplierId' => Yii::$app->user->identity->id]));
        $pagination = new Pagination([
            'defaultPageSize' => 5, // Number of items per page
            'totalCount' => $orders->count(),
        ]);
        $orders = $orders->orderBy(['created_at' => SORT_DESC])
        ->offset($pagination->offset)
        ->limit($pagination->limit)
        ->all();
    
        if ($orders) {
            $orderStatusNames = [];
            $orderStatusColors = [];
            $customerNames = [];

            foreach ($orders as $order) {
                $orderStatus = $order->orderStatus;
                $orderStatusNames[] = $orderStatus ? $orderStatus->getName() : 'N/A';
                $orderStatusColors[] = $orderStatus ? $orderStatus->getColor() : 'black';
                $customerNames[] = $order->customer->firstname . "  " . $order->customer->lastname;
            }

            return $this->render('index', [
                'orders' => $orders,
                'orderStatusNames' => $orderStatusNames,
                'orderStatusColors' => $orderStatusColors,
                'customerNames' => $customerNames,
                'pagination' => $pagination,

            ]);
        } else {
            return '';
        }
    }


    // ...

    public function actionDetails($id)
    {
        $query = OrderItem::find()
            ->leftJoin('orders', 'order_items.order_id = orders.id')
            ->where(['orders.id' => $id]);
        // echo  $query->createCommand()->getRawSql();
        // exit;
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
                return ['status' => 'success', 'message' => 'Order Rejected', 'color' => $order->orderStatus->color, 'name' => $order->orderStatus->name];
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
