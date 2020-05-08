<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DiaAulaHora */

$this->title = $model->CODIGO_ASIG;
$this->params['breadcrumbs'][] = ['label' => 'Dia Aula Horas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="dia-aula-hora-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'CODIGO_ASIG' => $model->CODIGO_ASIG, 'ID_PER' => $model->ID_PER, 'CEDULA_DOC' => $model->CEDULA_DOC, 'ID_HORA' => $model->ID_HORA, 'ID_DIA' => $model->ID_DIA, 'ID_AUL' => $model->ID_AUL, 'PARALELO' => $model->PARALELO, 'ID_CAR' => $model->ID_CAR, 'ID_SEM' => $model->ID_SEM], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'CODIGO_ASIG' => $model->CODIGO_ASIG, 'ID_PER' => $model->ID_PER, 'CEDULA_DOC' => $model->CEDULA_DOC, 'ID_HORA' => $model->ID_HORA, 'ID_DIA' => $model->ID_DIA, 'ID_AUL' => $model->ID_AUL, 'PARALELO' => $model->PARALELO, 'ID_CAR' => $model->ID_CAR, 'ID_SEM' => $model->ID_SEM], [
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
            'CODIGO_ASIG',
            'ID_PER',
            'CEDULA_DOC',
            'ID_HORA',
            'ID_DIA',
            'ID_AUL',
            'PARALELO',
            'ID_CAR',
            'ID_SEM',
            'OBSERVACIONES_DAH',
        ],
    ]) ?>

</div>
