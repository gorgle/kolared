<?php
/**
 * Created by PhpStorm.
 * User: alexchen
 * Date: 2017/3/13
 * Time: 下午3:31
 */

namespace backend\assets;


use yii\web\AssetBundle;

class MaterialAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/material';
    public $css = [
        'assets/css/material-dashboard.css',
        'assets/css/demo.css',
        'assets/css/font-awesome.min.css',
        'assets/css/materialIcon.css',
    ];
    public $js = [
        'assets/js/material.min.js',
        'assets/js/chartist.min.js',
        'assets/js/bootstrap-notify.js',
        'assets/js/material-dashboard.js',
        'assets/js/demo.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
//        'https://maps.googleapis.com/maps/api/js',
    ];
}