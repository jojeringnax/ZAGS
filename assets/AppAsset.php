<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/style.css',
        'js/paginationjs/dist/pagination.css',
        'img/icons/font/css/open-iconic-bootstrap.min.css',
        'mdb/assets/css/docs.css'
    ];
    public $js = [
        'js/main.js',
        'js/air-datepicker/dist/js/datepicker.js',
        'js/paginationjs/dist/pagination.js',
        'js/popper.min.js',
        'js/tooltip.min.js',
        'js/bootstrap-material-design.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',

    ];

    public function init()
    {
        parent::init();
        // resetting BootstrapAsset to not load own css files
        \Yii::$app->assetManager->bundles['yii\\bootstrap\\BootstrapAsset'] = [
            'css' => [],
            'js' => []
        ];
    }
}
