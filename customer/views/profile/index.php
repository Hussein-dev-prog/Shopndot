<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Profile';
$this->params['breadcrumbs'][] = $this->title;

// update button should be fixed (make controller actions)
?>
    
        <div class="card">
            <div class="card-header">
                Account information
            </div>
            <div class="card-body">
                <?php $form = ActiveForm::begin(['id' => 'user-info', 'action' => ['profile/updateuser']]); ?>
                    <?= $form->field($user, 'username')->textInput() ?>
                    <?= $form->field($customer, 'firstname')->textInput() ?>
                    <?= $form->field($customer, 'lastname')->textInput() ?>
                    <?= $form->field($user, 'email')->textInput() ?>
                    <?= $form->field($user, 'phone')->textInput() ?>
                    <button class="btn btn-primary">Update</button>
                <?php $form = ActiveForm::end(); ?>

            </div>
        </div>
        <?=Html::a('add address', ['profile/newaddress'], ['class' => 'btn btn-primary']); ?>

        <?php foreach ($addresses as $address ):?>
        <div class="card">
            <div class="card-header">
                Address information
            </div>
            <?php $form = ActiveForm::begin(['id' => 'adress-info', 'action' => ['profile/updateaddress'] ]); ?>
            <div class="card-body">
                <?= $form->field($address, 'id')->hiddenInput(['value' => $address->id])->label(false) ?>
                <?= $form->field($address, 'country')->textInput() ?>
                <?= $form->field($address, 'city')->textInput() ?>
                <?= $form->field($address, 'street')->textInput() ?>
                <?= $form->field($address, 'location')->textInput() ?>
                <button class="btn btn-primary">Update</button>
                <?= Html::a('Delete', ['profile/deleteaddress'], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this address?',
                        'method' => 'post',
                    ],
                ]) ?>

            </div>
            <?php $form = ActiveForm::end(); ?>
        </div>
        <?php endforeach; ?>













        
