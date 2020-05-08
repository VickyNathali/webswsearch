<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PeriodoAcademicoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gestión de períodos académicos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="periodo-academico-index">

    <b><h1 style="font-family:Trebuchet MS;"><?= Html::encode($this->title) ?></h1></b>

    <p>
        <?= Html::a('Crear período académico', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <br>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'ID_PER',
            'INICIO_PER',
            'FIN_PER',
            [
                'attribute' => 'ESTADO_PER',
                'value' => function ($model) {                    
                    if ($model->ESTADO_PER == 0) {
                       return $model->ESTADO_PER = "INACTIVO";
                    }else
                    if ($model->ESTADO_PER == 1) {
                       return $model->ESTADO_PER = "ACTIVO";
                    }
                },
                'filter' => array("1" => "ACTIVO", "0" => "INACTIVO"),
                
            ],

//            'OBSERVACIONES_PER',
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
                    'delete_per' => function($url, $model, $key) {
                        $imagen = Html::img(Yii::$app->homeUrl . 'imagenes/iconos/delete.png', ['width' => '20px', 'height' => '20px']);
                        return Html::a($imagen, $url, ['class' => 'btn', 'data' => [
                                        'confirm' => '¿Está seguro que desea eliminar? ('.$model->INICIO_PER.' hasta '.$model->FIN_PER.')',
                                        'method' => 'post', 'params' => ['derp' => 'herp'],], 'title' => 'Eliminar']);
                    }
                ], 'template' => '
    {view} {update}{delete_per}  
    ', 'header' => '']
        ],
    ]);
    ?>


</div>
