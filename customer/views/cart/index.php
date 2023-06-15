<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Cart';
$this->params['breadcrumbs'][] = $this->title;


?>


<div class="card">
    <div class="card-header">
        <h3>Your cart items</h3>
    </div>
    <div class="card-body p-0">

        <?php if (!empty($items)) : ?>
            <?php $quantities = []; ?>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Image</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; ?>
                    <?php foreach ($items as $item) : ?>
                        <?php $form = ActiveForm::begin(['id' => 'cart-info' . $i,]); ?>
                        <?= $form->field($cart_id, 'id')->hiddenInput(['value' => $cart_id->id])->label(false) ?>
                        <tr>
                            <td>
                                <?= $products[$i]->name ?>
                                <?= $form->field($products[$i], 'name')->hiddenInput(['value' => $products[$i]->name])->label(false) ?>
                                <?= $form->field($products[$i], 'id')->hiddenInput(['value' => $products[$i]->id])->label(false) ?>
                            </td>
                            <td>
                                image
                            </td>
                            <td>
                                <?= Yii::$app->formatter->asCurrency($products[$i]->price) ?>
                                <?= $form->field($products[$i], 'price')->hiddenInput(['value' => $products[$i]->price])->label(false) ?>
                            </td>
                            <td>
                                <?= $form->field($item, 'quantity', ['inputOptions' => ['readonly' => true, 'style' => 'width:100px', 'type' => 'number', 'min' => 1]])->textInput()->label(false) ?>
                            </td>
                            <td>
                                <?= Html::a('Delete', ['cart/deleteitem', 'product_id' => $products[$i]->id, 'cart_id' => $cart_id->id], [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?'
                                    ],
                                ]) ?>
                            </td>
                        </tr>
                        <?php $quantities[] = $item->quantity; ?>
                        <?php $form = ActiveForm::end(); ?>
                        <?php $i++; ?>
                    <?php endforeach; ?>

                </tbody>
            </table>
            <?php $qty = ActiveForm::begin(['id' => 'qty']); ?>
            <?= Html::hiddenInput('cart_id', $cart_id->id) ?>
            <?= Html::hiddenInput('quantities', implode(',', $quantities)) ?>
            <div class="card-body text-right">
                <?= Html::a('Checkout', ['cart/checkout'], [
                    'class' => 'btn btn-primary',
                    'data' => [
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
            <?php $qty = ActiveForm::end(); ?>
        <?php else : ?>

            <p class="text-muted text-center p-5">There are no items in the cart</p>

        <?php endif; ?>

    </div>
</div>