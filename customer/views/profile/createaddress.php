<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="">

    <?php $form = ActiveForm::begin([
        'id' => 'create-address',
        'action' => ['profile/createaddress']
    ]); ?>

    <?= $form->field($model, 'country')->textInput()?>

    <?= $form->field($model, 'city')->textInput()?>

    <?= $form->field($model, 'street')->textInput()?>

    <?= $form->field($model, 'location')->textInput()?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


