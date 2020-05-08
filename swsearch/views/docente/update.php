<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Docente */

$this->title = 'Modificar docente';
$this->params['breadcrumbs'][] = ['label' => 'Docentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CEDULA_DOC, 'url' => ['view', 'id' => $model->CEDULA_DOC]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="docente-update">

     <b><h1 style="font-family:Trebuchet MS;"><?= Html::encode($this->title) ?></h1></b><br>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
