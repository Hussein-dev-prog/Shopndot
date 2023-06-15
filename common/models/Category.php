<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
    public static function tableName()
    {
        return 'categories';
    }

    public function rules()
    {
        return [
            ['id', 'integer'],
            [['id', 'name'], 'required'],
            ['parent_id', 'exist', 'skipOnError' => true, 'skipOnEmpty' => true, 'targetClass' => Category::class, 'targetAttribute' => ['parent_id' => 'id']],

        ];
    }

    public function getParent()
    {
        return $this->hasOne(Category::class, ['parent_id' => 'id']);
    }
    public function getSubcategories()
    {
        return $this->hasMany(Category::class, ['category_id' => 'id']);
    }
}
