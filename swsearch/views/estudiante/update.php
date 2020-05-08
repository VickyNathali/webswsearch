<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Estudiante */

$this->title = 'Cambiar estado del estudiante';
$this->params['breadcrumbs'][] = ['label' => 'Estudiantes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CEDULA_PER, 'url' => ['view', 'id' => $model->CEDULA_PER]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="estudiante-update">

    <b><h1 style="font-family:Trebuchet MS;"><?= Html::encode($this->title) ?></h1></b>
    <br>
    
    <?= $this->render('_form', [
        'model' => $model,
        'model_persona' => $model_persona,
    ]) ?>

</div>
