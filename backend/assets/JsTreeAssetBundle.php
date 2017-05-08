<?php

namespace backend\assets;


use yii\web\AssetBundle;

class JsTreeAssetBundle extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];
    /**
     * @inheritdoc
     */
    public $sourcePath = 'jstree/dist';

    /**
     * @inheritdoc
     */
    public $css = [
        'themes/default/style.min.css',
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'jstree.min.js',
    ];
}