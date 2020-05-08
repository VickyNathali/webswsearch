<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Carrera;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EstudianteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gestión de estudiantes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estudiante-index">

    <h1><?= Html::encode($this->title) ?></h1>

<!--    <p>
    <?php //::a('Crear Estudiante', ['create'], ['class' => 'btn btn-success']) ?>
</p>-->
    <br>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php $var1 = array('ACTIVO', 'INACTIVO'); ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'CEDULA_PER',
            'NOMBRES_PER',
            'APELLIDOS_PER',
            [
                'attribute' => 'TOKEN_PER',
                'value' => function ($model) {
                    if ($model->TOKEN_PER == 0) {
                        return $model->TOKEN_PER = "INACTIVO";
                    } else
                    if ($model->TOKEN_PER == 1) {
                        return $model->TOKEN_PER = "ACTIVO";
                    }
                },
                'filter' => array("1" => "ACTIVO", "0" => "INACTIVO"),
            ],
            //'ID_CAR',            
//            [
//                'label' => 'Carrera',
//                'attribute' => 'CONTRASENA_PER',
//                'value' => 'CONTRASENA_PER',
//                'filter' => Html::activeDropDownList(
//                        $searchModel, 'CONTRASENA_PER', ArrayHelper::map(Carrera::find()->asArray()->all(), 'ID_CAR', 'NOMBRE_CAR'), ['class' => 'form-control', 'prompt' => 'Seleccionar ...']),
//            ],
//          ['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\ActionColumn', 'buttons' =>
                ['' => function($url, $model, $key) {
                        $imagen = Html::img(Yii::$app->homeUrl . '/imagenes/iconos/ver.png', ['width' => '20px', 'height' => '20px']);
                        return Html::a($imagen, $url, ['class' => 'btn', 'data' => ['method' => 'post', 'params' => ['derp' => 'herp'],], 'title' => 'Ver']); //use Url::to() in order to change $url 
                    },
                    'update' => function($url, $model, $key) {
                        $imagen = Html::img(Yii::$app->homeUrl . 'imagenes/iconos/edit.png', ['width' => '20px', 'height' => '20px']);
                        return Html::a($imagen, $url, ['class' => 'btn', 'data' => ['method' => 'post', 'params' => ['derp' => 'herp'],], 'title' => 'Modificar']); //use Url::to() in order to change $url 
                    },
                    'delete' => function($url, $model, $key) {
                        $imagen = Html::img(Yii::$app->homeUrl . 'imagenes/iconos/delete.png', ['width' => '20px', 'height' => '20px']);
                        return Html::a($imagen, $url, ['class' => 'btn', 'data' => [
                                        'confirm' => '¿Está seguro que desea eliminar?',
                                        'method' => 'post', 'params' => ['derp' => 'herp'],], 'title' => 'Eliminar']);
                    }
                ], 'template' => '
    {update}{delete}  
    ', 'header' => '']
        ],
    ]);
    ?>


</div>
