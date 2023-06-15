<?php

namespace customer\assets;

use yii\web\AssetBundle;
use yii\bootstrap5\BootstrapAsset;

/**
 * Main customer application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css'

    ];
    public $js = [
        'js/scripts.js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        BootstrapAsset::class,

    ];
}
