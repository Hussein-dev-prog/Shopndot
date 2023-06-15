<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Social extends ActiveRecord
{
    public static function tableName()
    {
        return 'socials';
    }

    public function rules()
    {
        return
            [
                [['id', 'supplier_id'], 'integer'],
                [['id', 'supplier_id', 'provider', 'link'], 'required'],
                ['supplier_id', 'exist', 'skipOnEmpty' => true, 'targetClass' => Supplier::class, 'targetAttribute' => ['supplier_id', 'id']]
            ];
    }
    public function getSupllier()
    {
        return $this->hasOne(Supplier::class, ['supplier_id' => 'id']);
    }
}
