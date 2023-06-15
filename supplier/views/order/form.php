<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<h1>Edit Order</h1>

<?php $form = ActiveForm::begin(); ?>
<?= $form->field($order, 'orderStatusId')->dropDownList(
    $statusOptions,
    [
        'prompt' => 'Select Status',
        'options' => [$order->orderStatusId => ['selected' => true, 'data-color' => ($order->orderStatus ? $order->orderStatus->getColor() : ''), 'value' => ($order->orderStatus ? $order->orderStatus->getName() : '')]],
        'class' => 'form-control',
        'style' => 'background-color:' . ($order->orderStatus ? $order->orderStatus->getColor() : '') . '; color:white',
    ]
) ?>
<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>