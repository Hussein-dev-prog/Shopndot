<?php

use yii\helpers\Url;
use common\helpers\Helper;

/** @var yii\web\View $this */
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

use yii\web\View;

$this->title = 'Shop n Dot';
?>
<style>
    .view-button.clicked {
        color: blue;
    }

    .view-button:hover {
        background-color: blue;
        color: white;
    }

    .wishlist-button.clicked {
        color: red;
    }

    .wishlist-button:hover {
        background-color: red;
        color: white;

    }

    .cart-button.clicked {
        color: green;
    }

    .cart-button:hover {
        background-color: green;
        color: white;

    }
</style>


<section class="py-1">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-4 row-cols-xl-4 justify-content-center">

            <?php if (!empty($products)) : ?>
                <?php foreach ($products as $product) : ?>
                    <?php
                    $componentId = 'product#product' . $product->id;
                    Helper::vue($componentId, ['product' => $product]);
                    ?>

                <?php endforeach; ?>
            <?php else : ?>
                <p class="text-muted text-center">This shop has no products yet</p>
            <?php endif; ?>
        </div>
    </div>
</section>