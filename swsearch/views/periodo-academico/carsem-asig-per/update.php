<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CarsemAsigPer */

$this->title = 'Modificar horario';
$this->params['breadcrumbs'][] = ['label' => 'Carsem Asig Pers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_CAR, 'url' => ['view', 'ID_CAR' => $model->ID_CAR, 'ID_SEM' => $model->ID_SEM, 'CODIGO_ASIG' => $model->CODIGO_ASIG, 'ID_PER' => $model->ID_PER]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="carsem-asig-per-update">

  <b><h1 style="font-family:Trebuchet MS;"><?= Html::encode($this->title) ?></h1></b><br>

    <?= $this->render('_form', [
        'model' => $model,
        'band' => $band,
        'sql'=> $sql,
    ]) ?>

</div>
