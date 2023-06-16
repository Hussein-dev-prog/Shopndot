<?php

namespace common\helpers;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\web\View;

class Helper
{
    public static function uploadLogoFile($type, $model, $propertyName, $fieldName)
    {
        $image = UploadedFile::getInstance($model, $propertyName);
        if ($image) {

            $root = Yii::getAlias('@customer/web');

            $path = "$root/uploads";

            $path .= DIRECTORY_SEPARATOR . $type;
            if (!is_dir($path)) {
                mkdir($path, 0777);
            }

            $path .= DIRECTORY_SEPARATOR . date('Y');
            if (!is_dir($path)) {
                mkdir($path, 0777);
            }

            $path .= DIRECTORY_SEPARATOR . date('m');
            if (!is_dir($path)) {
                mkdir($path, 0777);
            }

            $path .= '/' . date('d');
            if (!is_dir($path)) {
                mkdir($path, 0777);
            }

            $filename = rand(1000, 9999) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999) . '.' . $image->extension;

            $baseUrl = str_replace(['admin-', 'supplier-'], 'customer-', Url::base(true));
            $url = str_replace($root, $baseUrl, "$path/$filename");

            $model->$fieldName = $url;
            $model->imageFile = $image;
            $model->imageFile->saveAs("$path/$filename");
        }
    }

    public static function vue($name, $params = [])
    {
        $parts = explode('#', $name);
        $name = $parts[0];
        $id = $name;
        if (isset($parts[1])) {
            $id = $parts[1];
        }
        $args = Json::encode($params);
        echo Html::tag('div', '', ['id' => $id]);

        $js = <<< JS
        window.addEventListener("DOMContentLoaded", (event) => {

            console.log(window.vueApps);
            window.vueApps && window.vueApps.{$name} && window.vueApps.{$name}('{$id}', {$args})
        });
        JS;
        Yii::$app->view->registerJs($js, View::POS_END);
        Yii::$app->view->registerJsFile(Url::base(true) . '/js/apps/' . $name . '.js', ['type' => 'module']);
    }

    public static function jsVars()
    {
        $isGuest = Json::encode(Yii::$app->user->isGuest);
        $loginUrl = Json::encode(Url::to(['/site/login']));
        $js = <<<JS
        window.jsVars = window.jsVars || {}
        window.jsVars.isGuest = {$isGuest};
        window.jsVars.loginUrl = {$loginUrl};
    JS;

        Yii::$app->view->registerJs($js, View::POS_HEAD);
    }
}
