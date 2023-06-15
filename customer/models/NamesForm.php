<?php

namespace customer\models;

use Yii;
use yii\base\Model;
use common\models\Customer;

/**
 * Signup form
 */
class NamesForm extends Model
{
    public $firstname;
    public $lastname;


    public function rules()
    {
        return [
            [['firstname','lastname'], 'trim'],
            [['firstname','lastname'], 'required'],
            [['firstname','lastname'], 'string', 'min' => 2, 'max' => 255],
            
        ];
    }

    public function postsignup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $customer = new Customer();
        $customer->firstname = $this->firstname;
        $customer->lastname = $this->lastname;


        return $customer->save();
    }
}
