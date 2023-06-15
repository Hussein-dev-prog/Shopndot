<?php

use yii\helpers\Url;
use yii\web\View;

$this->title = 'Shop';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row" style="">
    <div class="" style="display:flex;flex-direction:row;align-items:center;justify-content:center;text-align: center;">
        <div class="">
            <?php if ($shop->logo) : ?>
                <img style=" width:200px;height:200px;object-fit:cover;border-radius:100%;box-shadow: 1px 1px #000;" src="<?= $shop->logo ?>" alt="<?= $shop->name ?>">
            <?php endif; ?>
        </div>
        <div style="margin-left:20px">
            <h2><?= $shop->name ?></h2>
            <div>description?</div>
        </div>
    </div>
</div>

<section class="py-1">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-3 row-cols-xl-3 justify-content-center">
            <?php if (!empty($products)) : ?>
                <?php foreach ($products as $product) : ?>
                    <div class="col mb-2">
                        <div class="card" style="width: 18rem;">
                            <!-- Product image -->
                            <img class="card-img-top" src="<?= $product->image ?>" alt="..." style="height:200px;object-fit:contain" />
                            <?php if ($product->quantity > 0) { ?>
                                <p class="bg-success" style="color:white;position:absolute;top:0px;padding:5px;width:50%;opacity:0.9">In Stock</p>
                            <?php } else { ?>
                                <p class="bg-danger" style="color:white;position:absolute;top:0px;padding:5px;width:50%;opacity:0.9">Out Of Stock</p>
                            <?php } ?>
                            <!-- Product details -->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name -->
                                    <h5 class="fw-bolder"><?= substr($product->name, 0, 15) ?></h5>
                                    <!-- Product price -->
                                    $<?= $product->price ?><br>
                                    <?= $product->quantity ?> Items
                                    <input type="number" class="form-control mt-2 product-quantity" max="<?= $product->quantity ?>" value="1" id="<?= $product->id ?>quantity" name="user_quantity" <?php if ($product->quantity == 0) echo 'disabled' ?>>
                                </div>
                            </div>
                            <!-- Product actions -->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                    <a href="<?= Url::to(['/site/displayproduct', 'id' => $product->id]) ?>" class="btn btn-outline-dark mt-auto view-button">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <button class="btn btn-outline-dark mt-auto wishlist-button <?php if (Yii::$app->user->identity && $product->userWishlist(Yii::$app->user->identity)) : ?>clicked <?php endif; ?>" data-product-id="<?= $product->id ?>" <?php if ($product->quantity == 0) echo 'disabled' ?>>
                                        <i class="bi bi-heart-fill"></i>
                                    </button>
                                    <button class="btn btn-outline-dark mt-auto cart-button <?php if (Yii::$app->user->identity && ($product->userCartItem(Yii::$app->user->identity))) : ?>clicked<?php endif; ?>" data-product-id="<?= $product->id ?>" <?php if ($product->quantity == 0) echo 'disabled' ?>>
                                        <i class="bi bi-cart-fill"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="text-muted text-center">This shop has no products yet</p>
            <?php endif; ?>
        </div>
    </div>
</section>
<script>
    <?php ob_start() ?>

    $(document).ready(function() {
        $('.cart-button').click(function() {
            $(this).toggleClass('clicked');
            var product_id = $(this).data('product-id');
            var qty = $(`#${product_id}quantity`).val();

            console.log(qty);
            var isLoggedIn = <?= Yii::$app->user->isGuest ? 'false' : 'true' ?>;
            if (!isLoggedIn) {
                window.location.href = '<?= Url::to(['/site/login']) ?>';
                return; // Stop further execution
            }
            $.ajax({
                url: 'http://customer-shopndot.test/index.php?r=cart/addtocart',
                type: 'POST',
                // dataType: 'json', // Parse the response as JSON
                data: {
                    product_id: product_id,
                    quantity: qty,
                },
                success: function(response) {
                    var qty = $('#<?= $product->id ?>quantity').val().trim();
                    $(this).off('click'); // Disable further clicks

                    if (response.status === 'success') {
                        $(this).off('click'); // Disable further clicks
                        alert(response.message);
                    } else if (response.status === 'error') {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert(error);
                }
            });
        });

        $('.wishlist-button').click(function() {
            var product_id = $(this).data('product-id');

            var isLoggedIn = <?= Yii::$app->user->isGuest ? 'false' : 'true' ?>;
            if (!isLoggedIn) {
                window.location.href = '<?= Url::to(['/site/login']) ?>';
                return; // Stop further execution
            }
            $.ajax({
                url: 'http://customer-shopndot.test/index.php?r=wishlist/additem',
                type: 'POST',
                data: {
                    product_id: product_id,
                },
                success: (response) => {
                    if (response.status === 'success') {
                        $(this).toggleClass('clicked');
                        $(this).off('click'); // Disable further clicks
                        alert(response.message);
                    } else if (response.status === 'error') {
                        alert(response.message);
                    }
                },
                error: (xhr, status, error) => {
                    alert('this error has occured: ' + error);
                }
            });
        })
    });

    <?php $js = ob_get_clean() ?>

    <?php
    $this->registerJs($js, View::POS_READY, 'unique-js-identifier');
    ?>
</script>