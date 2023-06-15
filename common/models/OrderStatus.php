<?php

namespace common\models;

use yii\db\ActiveRecord;

class OrderStatus extends ActiveRecord
{
    public static function tableName()
    {
        return 'order_status';
    }

    // Define any additional relations or behaviors if needed

    // Example getter for the name attribute
    public function getName()
    {
        return $this->name;
    }

    // Example getter for the color attribute
    public function getColor()
    {
        return $this->color;
    }
}
