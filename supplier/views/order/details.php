<?php

use yii\helpers\Html;
use common\models\Product;
use yii\helpers\Url;
use common\models\Category;

$this->title = "Products";
?>
<h1>Order Details</h1>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Image</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product) : ?>
            <tr>
                <td><?= $product['id'] ?></td>
                <td><?= $product['name'] ?></td>
                <td>
                    <?php
                    $category = Category::findOne($product['category_id']);
                    echo $category ? $category->name : '';
                    ?>
                </td>
                <td>
                    <?php if ($product['image']) : ?>
                        <img style="width:100px;height:100px;object-fit:cover" src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                    <?php endif; ?>
                </td>
                <td width="1000px"><?= $product['description'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>