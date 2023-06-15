<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use customer\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header>
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-expand-md  fixed-top',
            ],

        ]);
        $menuItems = [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Products', 'url' => ['/product/index']],
        ];
        if (!Yii::$app->user->isGuest) {
            $menuItems[] =  [
                'label' => 'Profile',
                'url' => ['/profile/index']
            ];
            $menuItems[] = ['label' => '  <i class="bi bi-heart-fill"></i>', 'url' => ['/wishlist/index']];
            $menuItems[] = [
                'label' => '<i class="bi-cart-fill me-1"></i>',
                'url' => ['/cart/index']
            ];
        }
        // if (Yii::$app->user->isGuest) {
        //     $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        // }

        echo Nav::widget([
            'options' => [
                'class' => 'navbar-nav me-auto mb-2 mb-md-0'
            ],
            'items' => $menuItems,
            'encodeLabels' => false, // Add this line to disable label encoding

        ]);
        if (Yii::$app->user->isGuest) {
            echo Html::tag('div', Html::a('<i class="bi bi-box-arrow-in-right"></i>', ['/site/login'], ['class' => ['']]), ['class' => ['d-flex']]);
        } else {
            echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
                . Html::submitButton(
                    '<i class="bi bi-box-arrow-in-left"></i>' . Yii::$app->user->identity->username . '',
                    ['class' => 'btn btn-link logout text-decoration-none text-secondary']
                )
                . Html::endForm();
        }
        NavBar::end();
        ?>
    </header>

    <main role="main" class="flex-shrink-0">
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
