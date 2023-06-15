<?php

$this->title = "Manage Admins";

use common\models\User;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap5\Alert;

?>

<style>
    table th,
    td {
        padding: 10px;
    }

    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;
    }

    .table-bordered {
        border: 1px solid #ddd;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #ddd;
    }

    .table th,
    .table td {
        padding: 12px 15px;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }

    .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
    }

    .table tbody+tbody {
        border-top: 2px solid #dee2e6;
    }

    .btn {
        display: inline-block;
        padding: 6px 12px;
        margin-bottom: 0;
        font-size: 14px;
        font-weight: 400;
        line-height: 1.42857143;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        -ms-touch-action: manipulation;
        touch-action: manipulation;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background-image: none;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .pagination {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }

    .pagination li {
        display: inline-block;
        margin: 0 5px;
    }

    .pagination li a {
        display: inline-block;
        padding: 5px 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
        color: #333;
        text-decoration: none;
    }

    .pagination li.active a {
        background-color: #007bff;
        color: #fff;
    }

    .pagination li.disabled a {
        color: #ccc;
        cursor: not-allowed;
    }
</style>
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
<?= Html::a('Create', ['admin/create'], ['class' => 'btn btn-success my-4']); ?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($model as $field) { ?>
            <tr>
                <td><?= $field->username; ?></td>
                <td><?= $field->email; ?></td>
                <td><?= $field->phone; ?></td>
                <td>
                    <?php if ($field->status == User::STATUS_ACTIVE) : ?>
                        Active
                    <?php elseif ($field->status == User::STATUS_INACTIVE) : ?>
                        Inactive
                    <?php elseif ($field->status == User::STATUS_DELETED) : ?>
                        Deleted
                    <?php endif ?>
                </td>
                <td>
                    <?= Html::a("Edit", ['admin/update', 'id' => $field->id], ['class' => 'btn btn-primary']); ?>
                    <?= Html::a("Delete", ['admin/delete', 'id' => $field->id], ['class' => 'btn btn-danger']); ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?= LinkPager::widget([
    'pagination' => $pagination,
    'options' => ['class' => 'pagination'],
    'linkOptions' => ['class' => 'page-link'],
    'activePageCssClass' => 'active',
    'disabledPageCssClass' => 'disabled',
]) ?>