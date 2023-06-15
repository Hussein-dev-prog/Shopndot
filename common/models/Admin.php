<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "admins".
 *
 * @property int|null $id
 * @property string $firstname
 * @property string $lastname
 */
class Admin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admins';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['firstname', 'lastname'], 'required'],
            [['firstname', 'lastname'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
        ];
    }
    public static function primaryKey()
    {
        return ['id'];
    }
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id']);
    }
}
