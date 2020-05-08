<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PersonaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gestión de administradores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="persona-index">

    <b><h1 style="font-family:Trebuchet MS;"><?= Html::encode($this->title) ?></h1></b>
    
    <p>
        <?= Html::a('Crear administrador', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <br>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'CEDULA_PER',
            'NOMBRES_PER',
            'APELLIDOS_PER',
           // 'USUARIO_PER',
           //'CONTRASEÑA_PER',
            //'FOTO_PER:ntext',
            [
                'attribute' => 'TOKEN_PER',
                'value' => function ($model) {                    
                    if ($model->TOKEN_PER == 0) {
                       return $model->TOKEN_PER = "INACTIVO";
                    }else
                    if ($model->TOKEN_PER == 1) {
                       return $model->TOKEN_PER = "ACTIVO";
                    }
                },  
                'filter' => array("1" => "ACTIVO", "0" => "INACTIVO"),
            ],

//          ['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\ActionColumn', 'buttons' =>
                ['view' => function($url, $model, $key) {
                        $imagen = Html::img(Yii::$app->homeUrl . '/imagenes/iconos/ver.png', ['width' => '20px', 'height' => '20px']);
                        return Html::a($imagen, $url, ['class' => 'btn', 'data' => ['method' => 'post', 'params' => ['derp' => 'herp'],], 'title' => 'Ver']); //use Url::to() in order to change $url 
                    },
                    'update' => function($url, $model, $key) {
                        $imagen = Html::img(Yii::$app->homeUrl . 'imagenes/iconos/edit.png', ['width' => '20px', 'height' => '20px']);
                        return Html::a($imagen, $url, ['class' => 'btn', 'data' => ['method' => 'post', 'params' => ['derp' => 'herp'],], 'title' => 'Modificar']); //use Url::to() in order to change $url 
                    },
                    'delete_adm' => function($url, $model, $key) {
                        $imagen = Html::img(Yii::$app->homeUrl . 'imagenes/iconos/delete.png', ['width' => '20px', 'height' => '20px']);
                        return Html::a($imagen, $url, ['class' => 'btn', 'data' => [
                                        'confirm' => '¿Está seguro que desea eliminar? ('.$model->NOMBRES_PER.' '.$model->APELLIDOS_PER.')',
                                        'method' => 'post', 'params' => ['derp' => 'herp'],], 'title' => 'Eliminar']);
                    }
                ], 'template' => '
    {view} {update}{delete_adm}  
    ', 'header' => '']
            
            
        ],
    ]); ?>


</div>
