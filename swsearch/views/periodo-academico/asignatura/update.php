<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Asignatura */

$this->title = 'Modificar asignatura';
$this->params['breadcrumbs'][] = ['label' => 'Asignaturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CODIGO_ASIG, 'url' => ['view', 'id' => $model->CODIGO_ASIG]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="asignatura-update">

    <b><h1 style="font-family:Trebuchet MS;"><?= Html::encode($this->title) ?></h1></b><br>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
