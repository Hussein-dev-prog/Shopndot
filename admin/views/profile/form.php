<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
 
<?php $form = ActiveForm::begin(); ?>
 
    <?= $form->field($model, 'firstname')->textInput(); ?>
    <?= $form->field($model, 'lastname')->textInput(); ?>
    <?= $form->field($model->user, 'username')->textInput(); ?>
    <?= $form->field($model->user, 'email')->textInput(); ?>
    <?= $form->field($model->user, 'phone')->textInput(); ?>
    <?= $form->field($model->user, 'password')->passwordInput() ?>

     
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
 
<?php ActiveForm::end(); ?>