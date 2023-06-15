<?php

use yii\helpers\Html;
use common\models\Admin;

$this->title = "Profile";
?>

<?php if (!$profileExists) : ?>
    <?= Html::a('Create', ['profile/create'], ['class' => 'btn btn-danger']); ?>
<?php endif; ?>

<h1>Profile Details</h1>
<?php if ($profileExists) : ?>
    <h3>Firstname: <?= Html::encode($firstname); ?></h3>
    <h3>Lastname: <?= Html::encode($lastname); ?></h3>
    <h3>Username: <?= Html::encode($model->user->username); ?></h3>
    <h3>Email: <?= Html::encode($model->user->email); ?></h3>
    <h3>Phone Number: <?= Html::encode($model->user->phone); ?></h3>


    <?= Html::a("Edit", ['profile/update', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>
    <?= Html::a("Delete", ['profile/delete', 'id' => $model->id], ['class' => 'btn btn-danger']); ?>
<?php else : ?>
    <p>No profile found.</p>
<?php endif; ?>