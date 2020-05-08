<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SemestreSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gestión de semestres';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="semestre-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear semestre', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <br>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'ID_SEM',
            'DESCRIPCION_SEM',
            [
                'attribute' => 'ESTADO_SEM',
                'value' => function ($model) {                    
                    if ($model->ESTADO_SEM == 0) {
                       return $model->ESTADO_SEM = "INACTIVO";
                    }else
                    if ($model->ESTADO_SEM == 1) {
                       return $model->ESTADO_SEM = "ACTIVO";
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
                    'delete_sem' => function($url, $model, $key) {
                        $imagen = Html::img(Yii::$app->homeUrl . 'imagenes/iconos/delete.png', ['width' => '20px', 'height' => '20px']);
                        return Html::a($imagen, $url, ['class' => 'btn', 'data' => [
                                        'confirm' => '¿Está seguro que desea eliminar? ('.$model->DESCRIPCION_SEM.')',
                                        'method' => 'post', 'params' => ['derp' => 'herp'],], 'title' => 'Eliminar']);
                    }
                ], 'template' => '
    {view} {update}{delete_sem}  
    ', 'header' => '']
        ],
    ]);
    ?>


</div>
