<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$this->title = 'Product';
$this->params['breadcrumbs'][] = $this->title;

?>



<div class="row">
    <div class="col">
        <img class="img-fluid" alt="Product Image" src="<?= $product->image ?>" alt="<?= $product->id ?>">
    </div>
    <div class="col">
        <div>
            <h3 class="d-inline-block"><?= $product->name ?></h3>
            <button id="addToWishlist" class="d-inline-block btn btn-outline-warning" data-product-id="<?= $product->id ?>">bookmark</button>

        </div>
        <p><?= Yii::$app->formatter->asCurrency($product->price) ?></p>
        <p><?= $product->description ?></p>
        <p>color?</p>
        Quantity : <?= Html::textInput('qty', 1, [
                        'id' => 'quantity',
                        'class' => 'form-control ',
                        'style' => 'width: 100px',
                        'type' => 'number',
                        'min' => 1,
                        // 'max' => $product->stock
                    ]) ?>
        <button id="addToCartBtn" class="btn btn-outline-primary" data-product-id="<?= $product->id ?>">Add to Cart</button>
        <div class="row">
            <div class="col">
                <p>shop img</p>
            </div>
            <div class="col">
                <p><?= $shop->name ?></p>
                <?=
                // search for best practices
                // 
                Html::a('visit our shop', ['site/displayshop'], ['class' => 'link-secondary'])
                ?>
            </div>
        </div>
        <p>fcontact your seller</p>

    </div>
</div>


<div class="mb-4 mt-4">
    <h3>Related products</h3>
</div>
<div class="row pt-7">
    <?php // loop 
    ?>
    <div class="mx-auto mx-sm-0 col-10 col-sm-6 col-md-4 col-lg-3 mb-5 ">
        <div class="h-100 d-flex flex-column px-sm-3 ">
            <div class="h-100 d-flex flex-column">
                <a href="" class="text-decoration-none">
                    <div class=" h-400">
                        <img src="https://templates.microweber.com/simple-shop/userfiles/cache/thumbnails/450/tn-glassess-226488389.webp" class="img-fluid" alt="Product Image">
                    </div>
                </a>
                <div class="pt-4 pb-6">
                    <div class="text-center">
                        <a href="" class="text-dark text-decoration-none">
                            <h5 class="mt-1 mb-2">Sunglasses</h5>
                        </a>
                    </div>

                    <div class="text-center">
                        <span>$ 57.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>


<script>
    <?php ob_start() ?>

    $(document).ready(function() {
        $('#addToCartBtn').click(function() {
            var product_id = $(this).data('product-id');
            var qty = $('#quantity').val();

            $.ajax({
                url: 'http://customer-shopndot.test/index.php?r=cart/addtocart'
                <?php //Url::to(['cart/addtocart'])
                ?>,
                type: 'POST',
                data: {
                    product_id: product_id,
                    quantity: qty,

                },
                success: function(response) {
                    if (response.status === 'success') {
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

        $('#addToWishlist').click(function() {
            var product_id = $(this).data('product-id');

            $.ajax({
                url: 'http://customer-shopndot.test/index.php?r=wishlist/additem',
                type: 'POST',
                data: {
                    product_id: product_id,
                },
                success: (response) => {
                    if (response.status === 'success') {
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