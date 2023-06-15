<?php

namespace supplier\controllers;

use Yii;
use common\models\Product;
use common\models\Category;

use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\web\Request;
use common\helpers\Helper;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

class ProductController extends Controller
{
    protected function getCategoryList()
    {
        $categories = Category::find()->all();
        $categoryList = ArrayHelper::map($categories, 'id', 'name');
        return $categoryList;
    }
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'update', 'create', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        $products = Product::find()->where(['supplier_id' => Yii::$app->user->id]);
        $exist = TRUE;
        if (!$products) {
            $exist = FALSE;
        }
        $pagination = new Pagination([
            'defaultPageSize' => 5, // Number of items per page
            'totalCount' => $products->count(),
        ]);
        $products = $products->orderBy('name')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('index', [
            'products' => $products,
            'exist' => $exist,
            'pagination' => $pagination,

        ]);
    }
    public function actionCreate()
    {
        $model = new Product();
        $categories =  Category::find()->where(['not', ['parent_id' => 0]])->all();
        $categoryList = $this->getCategoryList();
        // print_r($categoryList);
        // die;
        $date = date("Y-m-d H:i:s");
        $status = 1;
        $model->created_at = $date;
        $model->updated_at = $date;
        $model->status = $status;
        $model->supplier_id =  Yii::$app->user->identity->id;
        Helper::uploadLogoFile('products', $model, 'imageFile', 'image');

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Product created successfully');
            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('error', 'Failed to create Product');
        }

        return $this->render('form', [
            'model' => $model,
            'categories' => $categories,
            'categoryList' => $categoryList,
        ]);
    }
    public function actionUpdate($id)
    {
        $model = Product::findOne($id);

        $categoryList = $this->getCategoryList();
        Helper::uploadLogoFile('products', $model, 'imageFile', 'image');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Product Updated successfully');
            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('error', 'Failed to update Product');
        }

        return $this->render('form', [
            'model' => $model,
            'categoryList' => $categoryList,
        ]);
    }



    public function actionDelete($id)
    {
        $model = Product::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('The requested product does not exist.');
        }

        // Check if the user is authorized to delete the product (you can modify this based on your authorization logic)


        // Perform the deletion
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Product Deleted Successfully');
        }
        // Redirect to the index page or any other relevant page after deletion
        return $this->redirect(['index']);
    }
    // Define a shared method in your controller (e.g., MyController.php)

}
