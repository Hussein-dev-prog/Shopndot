<?php

use yii\helpers\Html;
use common\models\Product;
use yii\helpers\Url;
use common\models\Category;
use supplier\models\Order;
use common\models\OrderStatus;
use yii\widgets\LinkPager;

$this->title = "Products";

// Get the list of order statuses

?>
<style>
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
<h1>Orders</h1>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Customer Name</th>
            <th>Country</th>
            <th>City</th>
            <th>Street</th>
            <th>Location</th>
            <th>Status</th>
            <th>Acrion</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($orders ?? false) : ?>
            <?php foreach ($orders as $key => $order) : ?>
                <tr>
                    <td><?= $order->id ?></td>
                    <td><?= $customerNames[$key] ?></td> <!-- Display customer name -->
                    <td><?= $order->country ?></td>
                    <td><?= $order->city ?></td>
                    <td><?= $order->street ?></td>
                    <td><?= $order->location ?></td>
                    <td id="status-<?= $order->id ?>" style="background-color: <?= $orderStatusColors[$key] ?>;color:white"><?= $orderStatusNames[$key] ?></td>


                    <td>
                        <?php if ($order->orderStatusId != 2 && $order->orderStatusId != 4) : ?>

                            <a href="#" class="btn as accept-button-<?= $order->id ?>" style="background-color:blue;color:white" data-id="<?= $order->id ?>" data-action="accept">Accept</a>
                            <a href="#" class="btn asd reject-button-<?= $order->id ?>" style="background-color:red;color:white" data-id="<?= $order->id ?>" data-action="reject">Reject</a>
                        <?php endif; ?>

                        <?= Html::a("View", ['order/details', 'id' => $order->id], [
                            'class' => 'btn ',
                            'style' => 'background-color:#1cc88a;color:white'
                        ]); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="7">No orders available.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?= LinkPager::widget([
    'pagination' => $pagination,
    'options' => ['class' => 'pagination'],
    'linkOptions' => ['class' => 'page-link'],
    'activePageCssClass' => 'active',
    'disabledPageCssClass' => 'disabled',
]) ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('.as, .asd').click(function(e) {
            e.preventDefault(); // Prevent the default behavior of the anchor tag

            var button = $(this);
            var orderId = button.data('id'); // Access the data-id attribute of the <a> tag
            var action = button.data('action');
            var statusElement = $('#status-' + orderId); // Declare the statusElement variable outside the AJAX call
            var acceptButton = $('.accept-button-' + orderId);
            var rejectButton = $('.reject-button-' + orderId);


            $.ajax({
                url: 'http://supplier-shopndot.test/index.php?r=order/update', // Update the URL to the correct route
                type: 'post',
                data: {
                    'id': orderId,
                    'action': action
                },
                success: function(response) {
                    // Handle the AJAX response here
                    statusElement.text(response.name);
                    statusElement.css('background-color', response.color);
                    if (response.name) {
                        $('.accept-button-' + orderId).remove();
                        $('.reject-button-' + orderId).remove();
                    }


                    console.log(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Handle the error here
                    console.log(errorThrown);
                }
            });
        });
    });
</script>