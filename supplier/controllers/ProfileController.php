<?php

namespace supplier\controllers;

use yii\base\Model;
use common\models\Supplier;
use common\models\User;
use common\models\Social;
use yii\web\Controller;
use Yii;
use yii\web\UploadedFile;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
use common\helpers\Helper;



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
        $profile = $user->getSupplier()->one();
        $socials = Social::findAll(['supplier_id' => Yii::$app->user->id]);

        $profileExists = ($profile !== null);

        return $this->render('index', [
            'profile' => $profile,
            'profileExists' => $profileExists,
            'socials' => $socials,
        ]);
    }


    // public function actionUpdate()
    // {
    //     $model = Yii::$app->user->identity->supplier;
    //     $social = Social::find()->where(['supplier_id' => $model->id])->all();

    //     if (!$social) {
    //         $social = new Social();
    //         $social->supplier_id = $model->id;
    //     }
    //     Helper::uploadLogoFile('profile', $model, 'imageFile', 'logo');
    //     if ($model->load(Yii::$app->request->post()) && $social->load(Yii::$app->request->post())) {

    //         $model->save(false);
    //         $social->save(false);
    //         return $this->redirect(['index']);
    //     }

    //     return $this->render('form', [
    //         'model' => $model,
    //         'social' => $social,
    //     ]);
    // }
    public function actionUpdate()
    {
        $model = Yii::$app->user->identity->supplier;

        $socials = $model->socials; // Retrieve the existing social media accounts

        // Ensure that at least three social media accounts are available
        while (count($socials) < 4) {
            $socials[] = new Social();
        }

        Helper::uploadLogoFile('profile', $model, 'imageFile', 'logo');

        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($socials, Yii::$app->request->post())) {
            // $valid = $model->validate() && Model::validateMultiple($socials);

            // if ($valid) {
            $model->save(false);

            foreach ($socials as $social) {
                $social->supplier_id = $model->id;
                $social->save(false);
            }

            return $this->redirect(['index']);
        }
        // }

        return $this->render('form', [
            'model' => $model,
            'socials' => $socials,
        ]);
    }
}
