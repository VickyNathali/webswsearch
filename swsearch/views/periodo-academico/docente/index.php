<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DocenteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gestión de docentes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docente-index">

    <b><h1 style="font-family:Trebuchet MS;"><?= Html::encode($this->title) ?></h1></b>
    <p>
        <?= Html::a('Crear docente', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <br>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'CEDULA_DOC',
            'NOMBRES_DOC',
            'APELLIDOS_DOC',
            [
                'attribute' => 'ESTADO_DOC',
                'value' => function ($model) {                    
                    if ($model->ESTADO_DOC == 0) {
                       return $model->ESTADO_DOC = "INACTIVO";
                    }else
                    if ($model->ESTADO_DOC == 1) {
                       return $model->ESTADO_DOC = "ACTIVO";
                    }
                },
                'filter' => array("1" => "ACTIVO", "0" => "INACTIVO"), 
            ],
            //'TITULO_DOC',
            //'CELULAR_DOC',
            //'FOTO_DOC:ntext',
            ['class' => 'yii\grid\ActionColumn', 'buttons' =>
                ['view' => function($url, $model, $key) {
                        $imagen = Html::img(Yii::$app->homeUrl . '/imagenes/iconos/ver.png', ['width' => '20px', 'height' => '20px']);
                        return Html::a($imagen, $url, ['class' => 'btn', 'data' => ['method' => 'post', 'params' => ['derp' => 'herp'],], 'title' => 'Ver']); //use Url::to() in order to change $url 
                    },
                    'update' => function($url, $model, $key) {
                        $imagen = Html::img(Yii::$app->homeUrl . 'imagenes/iconos/edit.png', ['width' => '20px', 'height' => '20px']);
                        return Html::a($imagen, $url, ['class' => 'btn', 'data' => ['method' => 'post', 'params' => ['derp' => 'herp'],], 'title' => 'Modificar']); //use Url::to() in order to change $url 
                    },
                    'delete_doc' => function($url, $model, $key) {
                        $imagen = Html::img(Yii::$app->homeUrl . 'imagenes/iconos/delete.png', ['width' => '20px', 'height' => '20px']);
                        return Html::a($imagen, $url, ['class' => 'btn', 'data' => [
                                        'confirm' => '¿Está seguro que desea eliminar? ('.$model->NOMBRES_DOC.' '.$model->APELLIDOS_DOC.')',
                                        'method' => 'post', 'params' => ['derp' => 'herp'],], 'title' => 'Eliminar']);
                    }
                ], 'template' => '
    {view} {update}{delete_doc}  
    ', 'header' => '']
        ],
    ]);
    ?>


</div>
