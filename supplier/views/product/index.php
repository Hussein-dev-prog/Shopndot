<?php

use yii\helpers\Html;
use common\models\Product;
use yii\helpers\Url;
use common\models\Category;
use yii\bootstrap5\Alert;
use yii\widgets\LinkPager;

$this->title = "Products";
?>
<style>
    .pagination {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }

    .pagination li {
        display: inline-block;
        margin: 0 5px;
    }

    .pagination li a {
        display: inline-block;
        padding: 5px 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
        color: #333;
        text-decoration: none;
    }

    .pagination li.active a {
        background-color: #007bff;
        color: #fff;
    }

    .pagination li.disabled a {
        color: #ccc;
        cursor: not-allowed;
    }
</style>
<?php if (Yii::$app->session->hasFlash('success')) : ?>
    <?= Alert::widget([
        'options' => ['class' => 'alert-success'],
        'body' => Yii::$app->session->getFlash('success'),
    ]); ?>
<?php endif; ?>


<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1>Products</h1>
    <a href="<?= Url::to(['/product/create']) ?>" class="btn btn-danger">Add Product</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th style="width: 50px;">ID</th>
            <th style="width: 150px;">Name</th>
            <th style="width: 100px;">Price</th>
            <th style="width: 100px;">Quantity</th>
            <th style="width: 150px;">Category</th>
            <th style="width: 100px;">Image</th>
            <th style="width: 200px;">Description</th>
            <th style="width: 150px;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($exist) : ?>
            <?php foreach ($products as $product) : ?>
                <tr>
                    <td><?= $product->id ?></td>
                    <td><?= $product->name ?></td>
                    <td><?= $product->price ?></td>
                    <td><?= $product->quantity ?></td>
                    <td><?= $product->category ? $product->category->name : '--' ?></td>
                    <td>
                        <?php if ($product->image) : ?>
                            <img style="width: 100px; height: 100px; object-fit: contain;" src="<?= $product->image ?>" alt="<?= $product->name ?>">
                        <?php endif; ?>
                    </td>
                    <td><?= $product->description ?></td>
                    <td>
                        <?= Html::a("Edit", ['product/update', 'id' => $product->id], ['class' => 'btn btn-success']) ?>
                        <?= Html::a("Delete", ['product/delete', 'id' => $product->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this product?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<?= LinkPager::widget([
    'pagination' => $pagination,
    'options' => ['class' => 'pagination'],
    'linkOptions' => ['class' => 'page-link'],
    'activePageCssClass' => 'active',
    'disabledPageCssClass' => 'disabled',
]) ?>