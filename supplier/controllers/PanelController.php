<?php

namespace supplier\controllers;

use Yii;
use yii\db\Expression;
use common\models\Order;
use common\models\OrderItem;
use common\models\Product;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;
use yii\data\Pagination;

class PanelController extends Controller
{
    public function actionData($supplierId)
    {
        Yii::$app->response->format = 'json';

        $query = Order::find()->alias('order')->joinWith(['orderItems' => function ($query) use ($supplierId) {
            $query->alias('items');
            $query->where(new Expression('CONCAT(JSON_EXTRACT(JSON_UNQUOTE(items.product_details), "$.supplier_id"),"") = :supplierId', [':supplierId' => $supplierId]));
        }], true, 'INNER JOIN')

            //->joinWith(['customer'])
            // ->leftJoin('order_items', 'order_items.order_id = orders.id')
            // ->andWhere(new Expression('JSON_EXTRACT(JSON_UNQUOTE(product_details), "$.supplier_id") = :supplierId', [':supplierId' => $supplierId]))
        ;
        // return $query->createCommand()->getRawSql();

        $pagination = new Pagination([
            'defaultPageSize' => 5, // Number of items per page
            'totalCount' => $query->count(),
        ]);
        $orders = array_values(ArrayHelper::map($query->orderBy(['created_at' => SORT_DESC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all(), 'id', function ($row) {
            return $row->toArray([], ["customer", "items"]);
        }));

        return $orders;

        if ($orders) {
            $orderStatusNames = [];
            $orderStatusColors = [];
            $customerNames = [];

            // foreach ($orders as $order) {
            //     $orderStatus = $order->orderStatus;
            //     $orderStatusNames[] = $orderStatus ? $orderStatus->getName() : 'N/A';
            //     $orderStatusColors[] = $orderStatus ? $orderStatus->getColor() : 'black';
            //     $customerNames[] = $order->customer->firstname . "  " . $order->customer->lastname;
            // }

            // return $this->render('index', [
            //     'orders' => $orders,
            //     'orderStatusNames' => $orderStatusNames,
            //     'orderStatusColors' => $orderStatusColors,
            //     'customerNames' => $customerNames,
            //     'pagination' => $pagination,

            // ]);
            return  $orders;
        }
        return null;
    }
}
