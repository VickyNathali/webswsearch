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
class DashboardAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //agregado para LTE
        'css/bootstrap.min.css', 
        'bower_components/font-awesome/css/font-awesome.min.css',
//        'bower_components/Ionicons/css/ionicons.min.css',
        'css/AdminLTE.min.css',
        'css/skins/_all-skins.min.css',
        'plugins/iCheck/flat/blue.css',
        //agregado para LTE
        'css/site.css',
    ];
    public $js = [
        //agregado para LTE
        'js/bootstrap.min.js',        
        'bower_components/jquery-ui/jquery-ui.min.js',
        'bower_components/raphael/raphael.min.js',
        'bower_components/jquery-slimscroll/jquery.slimscroll.min.js',
        'bower_components/fastclick/lib/fastclick.js',
        'js/adminlte.min.js',
        'js/dashboard.js',
        //agregado para LTE
        'js/main.js', //agregar para modal        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
