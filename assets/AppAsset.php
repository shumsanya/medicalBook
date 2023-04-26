<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'designCT/css/nucleo-icons.css',
        'designCT/css/black-dashboard.css?v=1.0.0',
        'designCT/demo/demo.css',
        'css/myCss.css',
    ];
    public $js = [
        'js/setPHPSESSID.js',
        'designCT/js/plugins/chartjs.min.js',
        'designCT/js/core/popper.min.js',
        'designCT/js/core/bootstrap.min.js',
        'designCT/js/plugins/perfect-scrollbar.jquery.min.js',
        'designCT/js/black-dashboard.min.js',
        'designCT/js/plugins/bootstrap-notify.js',
        'designCT/js/side_setting_menu.js',
        'designCT/js/set_active_class.js',
        'designCT/demo/demo.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
