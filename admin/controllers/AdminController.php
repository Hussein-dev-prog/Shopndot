<?php

namespace admin\controllers;

use Yii;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
use yii\data\Pagination;

class AdminController extends Controller
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
        $model = User::find()->where(['type' => 'admin']);
        $pagination = new Pagination([
            'defaultPageSize' => 5, // Number of items per page
            'totalCount' => $model->count(),
        ]);
        $model = $model->orderBy('username')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('index', [
            'model' => $model,
            'pagination' => $pagination,
        ]);
    }
    public function actionCreate()
    {
        $model = new User();
        $model->type = 'admin';

        // Check if the request is a POST request
        if (Yii::$app->request->isPost) {
            $req = Yii::$app->request->post('User');
            $model->setPassword($req['password']);

            $email = $req['email'];

            $existemail = User::find()->where(['email' => $req['email']])->exists();
            $existUsername = User::find()->where(['username' => $req['username']])->exists();
            $existPhone = User::find()->where(['phone' => $req['phone']])->exists();

            if ($existemail) {
                Yii::$app->session->setFlash('error', 'Email already exists');
            } else if ($existUsername) {
                Yii::$app->session->setFlash('error', 'Username already exists');
            } else if ($existPhone) {
                Yii::$app->session->setFlash('error', 'Phone already exists');
            } else {
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    Yii::$app->session->setFlash('success', 'Admin created successfully');
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to create admin');
                }
            }
        }

        return $this->render('form', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = User::find()->where(['id' => $id])->one();

        // $id not found in database
        if ($model === null)
            throw new NotFoundHttpException('The requested page does not exist.');

        if (Yii::$app->request->isPost) {
            $req = Yii::$app->request->post('User');
            $existemail = User::find()->where(['email' => $req['email']])->andwhere(['!=', 'id', $id])->exists();
            $existUsername = User::find()->where(['username' => $req['username']])->andwhere(['!=', 'id', $id])->exists();
            $existPhone = User::find()->where(['phone' => $req['phone']])->andWhere(['!=', 'id', $id])->exists();

            if ($existemail) {
                Yii::$app->session->setFlash('error', 'Email already exists');
            } else if ($existUsername) {
                Yii::$app->session->setFlash('error', 'Username already exists');
            } else if ($existPhone) {
                Yii::$app->session->setFlash('error', 'Phone already exists');
            } else {
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    Yii::$app->session->setFlash('success', 'Admin Updated successfully');
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to create admin');
                }
            }
        }
        return $this->render('form', ['model' => $model]);
    }
    public function actionDelete($id)
    {
        $model = User::findOne($id);

        // $id not found in database
        if ($model === null)
            throw new NotFoundHttpException('The requested page does not exist.');

        // delete record
        $model->delete();

        return $this->redirect(['index']);
    }
}
