<?php

namespace customer\controllers;

use Yii;
use common\models\Address;
use common\models\Customer;
use common\models\User;
use yii\web\Controller;
use yii\filters\AccessControl;

class ProfileController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $currentuser_id = Yii::$app->user->identity;

        $addresses = Address::findAllByUserId($currentuser_id);
        $user = Yii::$app->user->identity;
        $customer = Customer::findById($currentuser_id);

        return $this->render('index', [
            'customer' => $customer,
            'addresses' => $addresses,
            'user' => $user,
        ]);
    }


    public function actionUpdateuser()
    {
        $req = Yii::$app->request->post();
        $inputcustomer = $req['Customer'];
        $inputuser = $req['User'];
        $user = User::findIdentity(Yii::$app->user->identity);

        $customer = Customer::findById(Yii::$app->user->identity);
        $customer->firstname = $inputcustomer['firstname'];
        $customer->lastname = $inputcustomer['lastname'];


        $user->username = $inputuser['username'];
        $user->email = $inputuser['email'];
        $user->phone = $inputuser['phone'];

        // $user->update();
        $customer->update();
        $this->redirect(['index']);
    }

    public function actionDeleteaddress()
    {
        $req = Yii::$app->request->post();
        $address = Address::findById($req['Address']);

        $address->delete();
        // Yii::$app->session->setFlash('danger',$address->id . ' was deleted');
        $this->redirect(['index']);
    }

    public function actionUpdateaddress()
    {
        $req = Yii::$app->request->post();
        $inputaddress = $req['Address'];

        $address = Address::findById($inputaddress['id']);
        $address->country = $inputaddress['country'];
        $address->city = $inputaddress['city'];
        $address->street = $inputaddress['street'];
        $address->location = $inputaddress['location'];

        $address->update();
        // Yii::$app->session->setFlash('warning',$inputaddress['id'] . ' was updated');
        return $this->redirect(['index']);
    }

    public function actionNewaddress()
    {
        $model = new Address();
        return $this->render(
            'createaddress',
            [
                'model' => $model,
            ]
        );
    }

    public function actionCreateaddress()
    {
        $model = new Address();
        if (Yii::$app->request->isPost) {
            $model->user_id = Yii::$app->user->identity->id;
            $model->country = Yii::$app->request->post('Address')['country'];
            $model->city = Yii::$app->request->post('Address')['city'];
            $model->street = Yii::$app->request->post('Address')['street'];
            $model->location = Yii::$app->request->post('Address')['location'];

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Address created successfully!');
            } else {
                Yii::$app->session->setFlash('error', 'Failed to create Address: ' . implode(', ', $model->getFirstErrors()));
            }
        }
        return $this->redirect(['index']);
    }
}
