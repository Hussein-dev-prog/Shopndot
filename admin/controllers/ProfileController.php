<?php

namespace admin\controllers;

use Yii;
use common\models\Admin;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;

class ProfileController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => ['index', 'create', 'update', 'delete'],

                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        return Yii::$app->getResponse()->redirect(['site/login']);
                    } else {
                        throw new ForbiddenHttpException('You are not authorized to access this page.');
                    }
                },
            ],
        ];
    }
    public function actionIndex()
    {
        $user = User::findOne(Yii::$app->user->id);
        $profile = $user->getAdmin()->one();
        // Check if the profile is found
        if ($profile !== null) {
            $firstname = $profile->firstname;
            $lastname = $profile->lastname;
            $profileExists = true;

            // Other code
        } else {
            $firstname = null;
            $lastname = null;
            $profileExists = false;
        }

        return $this->render('index', [
            'model' => $profile,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'profileExists' => $profileExists,

        ]);
    }
    public function actionCreate()
    {

        $model = new Admin();
        $model->id =  Yii::$app->user->id;
        //new record
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('form', ['model' => $model]);
    }
    public function actionUpdate($id)
    {
        $user = User::findOne(Yii::$app->user->id);
        $profile = $user->getAdmin()->one();

        if ($profile === null) {
            Yii::$app->session->setFlash('error', 'Profile not found.');
            return $this->redirect(['index']);
        }

        if ($profile->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())) {
            $isValid = $profile->validate() && $user->validate();

            if ($isValid) {
                $profile->save(false); // Save the profile without validating again
                $user->save(false); // Save the user without validating again

                Yii::$app->session->setFlash('success', 'Profile has been updated successfully.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('form', [
            'model' => $profile,
            'user' => $user,
        ]);
    }
    public function actionDelete($id)
    {
        $profile = Admin::findOne($id);

        if ($profile !== null) {
            $userId = $profile->id;
            $user = User::findOne($userId);

            if ($user !== null) {
                $user->delete(); // Delete the user record
            }

            $profile->delete(); // Delete the profile record

            Yii::$app->session->setFlash('success', 'Profile and user have been deleted successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'Profile not found.');
        }

        return $this->redirect(['index']);
    }
}
