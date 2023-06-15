<?php

namespace admin\controllers;

use common\models\Admin;
use common\models\Customer;
use common\models\LoginForm;
use common\models\Supplier;
use common\models\User;
use common\models\Order;
use common\models\OrderItem;
use common\models\Product;
use yii\db\Expression;


use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */


    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $adminCount = Admin::find()->count();
        $supplierCount = Supplier::find()->count();
        $customerCount = Customer::find()->count();
        $today = date('Y-m-d');
        $currentYear = date('Y');
        $currentMonth = date('m');
        $orderCount = Order::find()
            ->where(['DATE(created_at)' => new Expression('CURDATE()')])
            ->count();
        $dailyIncome = Order::find()
            ->select(['SUM(order_item.price * order_item.quantity) AS income'])
            ->joinWith('orderItems as order_item')
            ->where(['DATE(orders.created_at)' =>  new Expression('CURDATE()')])
            ->andWhere(['orders.orderStatusId' => 2])
            ->scalar();
        $monthlyIncome = Order::find()
            ->select(['SUM(order_item.price * order_item.quantity) AS income'])
            ->joinWith('orderItems as order_item')
            ->where(['YEAR(orders.created_at)' => $currentYear])
            ->andWhere(['MONTH(orders.created_at)' => $currentMonth])
            ->andWhere(['orders.orderStatusId' => 2])
            ->scalar();
        $yearlyIncome = Order::find()
            ->select(['SUM(order_item.price * order_item.quantity) AS income'])
            ->joinWith('orderItems as order_item')
            ->where(['YEAR(orders.created_at)' => $currentYear])
            ->andWhere(['orders.orderStatusId' => 2])
            ->scalar();
        $acceptedCount = Order::find()
            ->where(['orderstatusid' => 2])
            ->andWhere(['DATE(created_at)' => new Expression('CURDATE()')])
            ->count();

        $rejectedCount = Order::find()
            ->where(['orderstatusid' => 4])
            ->andWhere(['DATE(created_at)' => new Expression('CURDATE()')])
            ->count();
        $outOfStockProducts =  Product::find()
            ->where(['quantity' => 0])
            ->count();

        $availableProducts = Product::find()
            ->where(['>', 'quantity', 0])
            ->count();
        return $this->render('index', [
            'orderCount' => $orderCount,
            'adminCount' => $adminCount,
            'customerCount' => $customerCount,
            'supplierCount' => $supplierCount,
            'dailyIncome' => $dailyIncome,
            'monthlyIncome' => $monthlyIncome,
            'yearlyIncome' => $yearlyIncome,
            'acceptedCount' => $acceptedCount,
            'rejectedCount' => $rejectedCount,
            'outOfStockProducts' => $outOfStockProducts,
            'availableProducts' => $availableProducts,




        ]);
    }

    /**
     * Login action.
     *
     * @return string|Response  
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        // $type = $model->getUserRecord()->type;

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }


        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // Check if the logged-in user has type 'supplier'
            $user = User::findIdentity(Yii::$app->user->getId());
            if ($user->type == 'admin') {
                return $this->goBack();
            }
        }
        $this->layout = 'blank';
        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
