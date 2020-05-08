<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CarreraSemestre */

$this->title = 'Modificar Carrera Semestre: ' . $model->ID_SEM;
$this->params['breadcrumbs'][] = ['label' => 'Carrera Semestres', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_SEM, 'url' => ['view', 'ID_SEM' => $model->ID_SEM, 'ID_CAR' => $model->ID_CAR]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="carrera-semestre-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
