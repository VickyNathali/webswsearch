<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Carrera;
use app\models\Semestre;
use app\models\Asignatura;
use app\models\PeriodoAcademico;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CarsemAsigPerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gestión de horario';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carsem-asig-per-index">

    <b><h1 style="font-family:Trebuchet MS;"><?= Html::encode($this->title) ?></h1></b>

    <p>
        <?= Html::a('Horario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <br>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            //para mostrar las fechas de periodo
            [
                'attribute' => 'ID_PER',
                //'value' => 'pER.INICIO_PER',
                'value' => function ($model) {
                    return $model->pER->INICIO_PER . ' hasta ' . $model->pER->FIN_PER;
                },
                'filter' => Html::activeDropDownList(
                        $searchModel, 'ID_PER', ArrayHelper::map(PeriodoAcademico::find()->where(['ESTADO_PER' => 1])->asArray()->orderBy('FIN_PER asc')->all(), 'ID_PER', 'FIN_PER', 'INICIO_PER'), ['class' => 'form-control', 'prompt' => 'Seleccionar ...']),
            ],
            //Fin para mostrar las fechas de periodo     
            //para mostrar la descripcion de carrera
            [
                'attribute' => 'ID_CAR',
                'value' => 'sEM.cAR.NOMBRE_CAR',
                'filter' => Html::activeDropDownList(
                        $searchModel, 'ID_CAR', ArrayHelper::map(Carrera::find()->where(['ESTADO_CAR' => 1])->asArray()->all(), 'ID_CAR', 'NOMBRE_CAR'), ['class' => 'form-control', 'prompt' => 'Seleccionar ...']),
            ],
            //Fin para mostrar carrera         
             //para mostrar la descripcion de semestre
            [
                'attribute' => 'ID_SEM',
                'value' => 'sEM.sEM.DESCRIPCION_SEM',
                'filter' => Html::activeDropDownList(
                        $searchModel, 'ID_SEM', ArrayHelper::map(Semestre::find()->where(['ESTADO_SEM' => 1])->asArray()->all(), 'ID_SEM', 'DESCRIPCION_SEM'), ['class' => 'form-control', 'prompt' => 'Seleccionar ...']),
            ],
            //Fin para mostrar semestre
            //para mostrar la descripcion de asignatura
            [
                'attribute' => 'CODIGO_ASIG',
                'value' => 'cODIGOASIG.NOMBRE_ASIG',
                'filter' => Html::activeDropDownList(
                        $searchModel, 'CODIGO_ASIG', ArrayHelper::map(Asignatura::find()->where(['ESTADO_ASIG' => 1])->asArray()->orderBy('NOMBRE_ASIG asc')->all(), 'CODIGO_ASIG', 'NOMBRE_ASIG'), ['class' => 'form-control', 'prompt' => 'Seleccionar ...']),
            ],
            //Fin para mostrar asignatura
           
//          ['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\ActionColumn', 'buttons' =>
//                ['view' => function($url, $model, $key) {
//                        $imagen = Html::img(Yii::$app->homeUrl . '/imagenes/iconos/ver.png', ['width' => '20px', 'height' => '20px']);
//                        return Html::a($imagen, $url, ['class' => 'btn', 'data' => ['method' => 'post', 'params' => ['derp' => 'herp'],], 'title' => 'Ver']); //use Url::to() in order to change $url 
//                    },
//                    'update' => function($url, $model, $key) {
//                        $imagen = Html::img(Yii::$app->homeUrl . 'imagenes/iconos/edit.png', ['width' => '20px', 'height' => '20px']);
//                        return Html::a($imagen, $url, ['class' => 'btn', 'data' => ['method' => 'post', 'params' => ['derp' => 'herp'],], 'title' => 'Modificar']); //use Url::to() in order to change $url 
//                    },
                    ['delete' => function($url, $model, $key) {
                        $imagen = Html::img(Yii::$app->homeUrl . 'imagenes/iconos/delete.png', ['width' => '20px', 'height' => '20px']);
                        return Html::a($imagen, $url, ['class' => 'btn', 'data' => [
                                        'confirm' => '¿Está seguro que desea eliminar? ' . $model->cODIGOASIG->NOMBRE_ASIG . ' de ' . $model->sEM->sEM->DESCRIPCION_SEM . ' de ' . $model->sEM->cAR->NOMBRE_CAR,
                                        'method' => 'post', 'params' => ['derp' => 'herp'],], 'title' => 'Eliminar']);
                    }
                ], 'template' => '
    {delete}  
    ', 'header' => '']
        ],
    ]);
    ?>


</div>
