<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Wishlist';
$this->params['breadcrumbs'][] = $this->title;


?>


<div class="card">
    <div class="card-header">
        <h3>Your Wishlist items</h3>
    </div>
    <div class="card-body ">

        <?php if (!empty($items)) : ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Image</th>
                        <th>Unit Price</th>
                        <th>Action</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; ?>
                    <?php foreach ($items as $item) : ?>
                        <tr>
                            <td>
                                <?= $item->name ?>
                            </td>
                            <td>
                                <img src="<?= $item->image ?>" alt="" style="width:50px;height:50px">


                            </td>
                            <td>
                                <?= Yii::$app->formatter->asCurrency($item->price) ?>
                            </td>
                            <td>
                                <?= Html::a('Remove', ['wishlist/deleteitem', 'id' => $wishlistitems[$i]->id], [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
                                    ],
                                ]) ?>
                            </td>
                            <td>
                                .
                            </td>
                        </tr>
                        <?php $i++ ?>
                    <?php endforeach; ?>


                </tbody>
            </table>
        <?php else : ?>

            <p class=" text-center ">There are no items in your Wishlist</p>

        <?php endif; ?>

    </div>
</div>