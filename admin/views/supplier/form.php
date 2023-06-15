<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;
use yii\bootstrap5\Alert;

?>
  <?php if (Yii::$app->session->hasFlash('success')) : ?>
    <?= Alert::widget([
            'options' => ['class' => 'alert-success'],
            'body' => Yii::$app->session->getFlash('success'),
        ]); ?>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')) : ?>
    <?= Alert::widget([
        'options' => ['class' => 'alert-danger'],
        'body' => Yii::$app->session->getFlash('error'),
    ]); ?>
<?php endif; ?>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],

]); ?>
 
    <?= $form->field($model, 'username')->textInput(); ?>
    <?= $form->field($model, 'email')->textInput(); ?>
    <?= $form->field($model, 'phone')->textInput(); ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($supplier, 'name')->textInput(); ?>
    <?= $form->field($supplier, 'imageFile')->fileInput(['id' => 'imageFile'])->label(false) ?>

    <?= $form->field($model, 'status')->radioList([
        User::STATUS_ACTIVE => 'Active',
        User::STATUS_INACTIVE => 'Inactive',
        User::STATUS_DELETED => 'Deleted',
    ]) ?>

     
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
 
<?php ActiveForm::end(); ?>