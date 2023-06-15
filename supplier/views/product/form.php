<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
?>
<div class="container-fluid">
    <div class="row">
        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'], // Set the enctype here
            'class' => ['col-md-12']
        ]); ?>
        <div class="row" style="justify-content:space-between;align-items: baseline;">
            <div class="col-md-6">
                <h4 style="text-align:center">Product Info</h4>
                <div style="border-radius:10px;">
                    <?= $form->field($model, 'name')->textInput(['class' => 'form-control mt-4', 'placeholder' => 'Product Name']) ?>
                    <?= $form->field($model, 'description')->textInput(['class' => 'form-control mt-4', 'placeholder' => 'Product Description']) ?>
                    <?= $form->field($model, 'price')->textInput(['class' => 'form-control mt-4', 'placeholder' => 'Product Price']) ?>
                    <?= $form->field($model, 'quantity')->textInput(['class' => 'form-control mt-4', 'placeholder' => 'Product quantity']) ?>
                    <?= $form->field($model, 'imageFile')->fileInput() ?>
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
                </div>
            </div>
            <div class="col-md-4">
                <h4 style="text-align:center">Categories</h4>
                <div style="background-color:#1cc88a;border-radius:10px;color:white;padding:15px">
                    <?= $form->field($model, 'category_id')->radioList($categoryList, [
                        'separator' => '<br>',
                    ])->label('Categories') ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>