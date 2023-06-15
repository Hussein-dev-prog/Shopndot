<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
    'fieldConfig' => [
        'options' => ['class' => 'container'],
    ],
]); ?>
<div class="row">
    <div style="
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;" class="col-md-6">
        <?php if ($model->logo) : ?>
            <label for="imageFile" style="cursor: pointer;">
                <img style="width: 200px; height: 200px; object-fit: cover; border-radius: 100%;" src="<?= $model->logo ?>" alt="<?= $model->name ?>">
            </label>
        <?php endif; ?>
        <?= $form->field($model, 'imageFile')->fileInput(['id' => 'imageFile'])->label(false) ?>
    </div>
    <div class="col-md-6 social">
        <?= $form->field($model, 'name')->textInput(); ?>
        <?php foreach ($socials as $index => $social) : ?>
            <div class="social-item">
                <?= $form->field($social, "[$index]provider")->textInput(); ?>
                <?= $form->field($social, "[$index]link")->textInput(); ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="col-md-12" style="text-align:center">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Create' : 'Update',
            [
                'class' => $model->isNewRecord ? 'btn btn-success mt-4' : 'btn btn-primary mt-4',
                'style' => 'width:50%',
            ]
        ); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>