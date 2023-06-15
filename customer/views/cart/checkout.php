<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap5\ActiveField;

$order_items_names = [];
$order_items_prices = [];


$this->title = 'Checkout';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
    'id' => 'checkout-form', 'action' => ['order/create']
]); ?>
<div class="row">
    <div class="col">
        <div class="card mb-3">
            <div class="card-header">
                <h5>Account information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        Email : <?= $email ?>

                    </div>
                    <div class="col-md-6">
                        Firstname : <?= $customer->firstname ?>
                    </div>
                    <div class="col-md-6">
                        Lastname : <?= $customer->lastname ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Address information</h5>
            </div>
            <div class="card-body">
                <p>Select an address:</p>
                <?php $arrayaddress = [] ?>
                <?php foreach ($addresses as $address) : ?>
                    <?php $stringaddress = $address->country . ',' . $address->city . ',' . $address->street . ',' . $address->location ?>
                    <?php $arrayaddress[$stringaddress] = $stringaddress ?>
                <?php endforeach; ?>
                <?= Html::dropDownList(
                    'address',
                    null,
                    $arrayaddress,
                    ['class' => 'form-control']
                ) ?>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h5>Order Summary</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0; ?>
                        <?php $i = 0; ?>
                        <?php foreach ($products as $product) : ?>
                            <tr>    
                                <td>
                                    <img src="<?= $product->image ?>" alt="" style="height:50px;width:50px;object-fit:contain">
                                </td>
                                <td>
                                    <?= $product->name ?>
                                </td>
                                <td>
                                    <?= $quantities[$i] ?>
                                </td>
                                <td>
                                    <?= Yii::$app->formatter->asCurrency($product->price) ?>
                                </td>
                                <?php $order_items_names[] = $product->id ?>
                                <?php $order_items_prices[] = $product->price ?>
                            </tr>
                            <?php $total += $product->price * $quantities[$i] ?>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <hr>
                <table class="table">
                    <tr>
                        <td>Total Items</td>
                        <td class="text-right"><?= array_sum($quantities) ?></td>
                    </tr>
                    <tr>
                        <td>Total Price</td>
                        <td class="text-right">
                            <?= Yii::$app->formatter->asCurrency($total) ?>
                            <?= Html::hiddenInput('total', $total) ?>
                        </td>
                    </tr>
                </table>

                <p class="text-right mt-3">
                    <?= Html::hiddenInput('quantities', implode(',', $quantities)) ?>
                    <?= Html::hiddenInput('order_items_names', implode(',', $order_items_names)) ?>
                    <?= Html::hiddenInput('order_items_prices', implode(',', $order_items_prices)) ?>
                    <?= Html::hiddenInput('customer_id', $customer->id) ?>
                    <?= Html::hiddenInput('cart_id', $cart_id) ?>
                    <?= Html::hiddenInput('supplier_id', $product->supplier_id) ?>
                    <button class="btn btn-secondary">Finalize Order</button>
                </p>
            </div>
        </div>
    </div>
</div>
<?php $form = ActiveForm::end(); ?>