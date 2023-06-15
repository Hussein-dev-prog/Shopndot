<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \customer\models\SignupForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Set Names';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to complete registration:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-postsignup', 'action' => ['site/setnames']]); ?>

            <?= $form->field($model, 'firstname')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'lastname') ?>

            <?= $form->field($signupmodel, 'username')->hiddenInput()->label(false) ?>
            <div class="form-group">
                <?= Html::submitButton('Done', ['class' => 'btn btn-secondary', 'name' => 'postsignup-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>