<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use common\helpers\Helper;

$this->title = 'Product';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$componentId = 'singleProduct#product' . $product->id;
Helper::vue($componentId, ['product' => $product, 'shop' => $shop]);
Helper::jsVars();
?>

