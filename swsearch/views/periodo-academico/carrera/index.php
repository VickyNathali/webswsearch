<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CarreraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gestión de carreras';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carrera-index">

    <b><h1 style="font-family:Trebuchet MS;"><?= Html::encode($this->title) ?></h1></b>

    <p>
        <?= Html::a('Crear carrera', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <br>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Carrera',
                'attribute' => 'NOMBRE_CAR',
            ],
            'DIRECTOR_CAR',
            [
                'attribute' => 'ESTADO_CAR',
                'value' => function ($model) {                    
                    if ($model->ESTADO_CAR == 0) {
                       return $model->ESTADO_CAR = "INACTIVA";
                    }else
                    if ($model->ESTADO_CAR == 1) {
                       return $model->ESTADO_CAR = "ACTIVA";
                    }
                },
                'filter' => array("1" => "ACTIVA", "0" => "INACTIVA"),
                
            ],
//            ['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\ActionColumn', 'buttons' =>
                ['view' => function($url, $model, $key) {
                        $imagen = Html::img(Yii::$app->homeUrl . '/imagenes/iconos/ver.png', ['width' => '20px', 'height' => '20px']);
                        return Html::a($imagen, $url, ['class' => 'btn', 'data' => ['method' => 'post', 'params' => ['derp' => 'herp'],], 'title' => 'Ver']); //use Url::to() in order to change $url 
                    },
                    'update' => function($url, $model, $key) {
                        $imagen = Html::img(Yii::$app->homeUrl . 'imagenes/iconos/edit.png', ['width' => '20px', 'height' => '20px']);
                        return Html::a($imagen, $url, ['class' => 'btn', 'data' => ['method' => 'post', 'params' => ['derp' => 'herp'],], 'title' => 'Modificar']); //use Url::to() in order to change $url 
                    },
                    'delete_logico' => function($url, $model, $key) {
                        $imagen = Html::img(Yii::$app->homeUrl . 'imagenes/iconos/delete.png', ['width' => '20px', 'height' => '20px']);
                        return Html::a($imagen, $url, ['class' => 'btn', 'data' => [
                                        'confirm' => '¿Está seguro que desea eliminar? ('.$model->NOMBRE_CAR.')',
                                        'method' => 'post', 'params' => ['derp' => 'herp'],], 'title' => 'Eliminar']);
                    }
                ], 'template' => '
    {view} {update}{delete_logico}  
    ', 'header' => '']
        ],
    ]);
    ?>


</div>
