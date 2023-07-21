<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int $customer_id
 * @property int $status
 * @property string $created_at
 * @property float $total_cost
 *
 * @property Customer $customer
 * @property OrderItem[] $orderItems
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'status', 'total_cost'], 'required'],
            [['customer_id', 'status', 'orderStatusId'], 'integer'],
            [['created_at'], 'safe'],
            [['total_cost'], 'number'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::class, 'targetAttribute' => ['customer_id' => 'id']],
            [['orderStatusId'], 'exist', 'skipOnError' => true, 'targetClass' => OrderStatus::class, 'targetAttribute' => ['orderStatusId' => 'id']],

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
            'status' => 'Status',
            'created_at' => 'Created At',
            'total_cost' => 'Total Cost',
            [['orderStatusId'], 'integer'],

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
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }
    public function getOrderStatus()
    {
        return $this->hasOne(OrderStatus::class, ['id' => 'orderStatusId']);
    }

    public function fields()
    {
        $list = parent::fields();

        $list['statusLabel'] = function () {
            return $this->orderStatus ? $this->orderStatus->getName() : 'N/A';
        };

        $list['statusColor'] = function () {
            return $this->orderStatus ? $this->orderStatus->getColor() : '#fff';
        };

        return $list;
    }

    function extraFields()
    {
        return ['customer', 'items' => function () {
            return $this->orderItems;
        }];
    }
}
