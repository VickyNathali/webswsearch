<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DiaAulaHora */

$this->title = 'Modificar Dia Aula Hora: ' . $model->CODIGO_ASIG;
$this->params['breadcrumbs'][] = ['label' => 'Dia Aula Horas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CODIGO_ASIG, 'url' => ['view', 'CODIGO_ASIG' => $model->CODIGO_ASIG, 'ID_PER' => $model->ID_PER, 'CEDULA_DOC' => $model->CEDULA_DOC, 'ID_HORA' => $model->ID_HORA, 'ID_DIA' => $model->ID_DIA, 'ID_AUL' => $model->ID_AUL, 'PARALELO' => $model->PARALELO, 'ID_CAR' => $model->ID_CAR, 'ID_SEM' => $model->ID_SEM]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="dia-aula-hora-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
