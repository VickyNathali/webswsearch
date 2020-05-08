<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CarreraSemestre */

$this->title = $model->ID_SEM;
$this->params['breadcrumbs'][] = ['label' => 'Carrera Semestres', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="carrera-semestre-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'ID_SEM' => $model->ID_SEM, 'ID_CAR' => $model->ID_CAR], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'ID_SEM' => $model->ID_SEM, 'ID_CAR' => $model->ID_CAR], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro que desea eliminar?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID_SEM',
            'ID_CAR',
        ],
    ]) ?>

</div>
