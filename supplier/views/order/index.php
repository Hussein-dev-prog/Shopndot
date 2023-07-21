<?php

use yii\helpers\Html;
use common\models\Product;
use yii\helpers\Url;
use common\models\Category;
use supplier\models\Order;
use common\models\OrderStatus;
use yii\widgets\LinkPager;
use common\helpers\Helper;

$this->title = "Products";

// Get the list of order statuses

?>
<section class="py-1">
    <?php
    // $componentId = 'orders';
    Helper::vue('orders');
    Helper::jsVars();
    ?>

    <?php ?>
</section>