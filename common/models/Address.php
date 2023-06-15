<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "addresses".
 *
 * @property int $id
 * @property int $user_id
 * @property string $country
 * @property string $city
 * @property string $street
 * @property float|null $location
 *
 * @property User $user
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'addresses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'country', 'city', 'street'], 'required'],
            [['user_id'], 'integer'],
            [['location'], 'number'],
            [['country', 'city', 'street'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'country' => 'Country',
            'city' => 'City',
            'street' => 'Street',
            'location' => 'Location',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public static function findAllByUserId($id)
    {
        return static::findAll(['user_id' => $id]);
    }
    public static function findById($id)
    {
        return static::findOne(['id' => $id]);
    }
    
    
}
