<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Persona */

$this->title = 'Modificar administrador';
$this->params['breadcrumbs'][] = ['label' => 'Personas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CEDULA_PER, 'url' => ['view', 'id' => $model->CEDULA_PER]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="persona-update">

    <b><h1 style="font-family:Trebuchet MS;"><?= Html::encode($this->title) ?></h1></b>
    
    <b><h5 style="font-family:Trebuchet MS; color:blue; ">Ingresar nueva contraseña en caso de querer cambiarla, caso contrario dejar el campo en blanco.</h5></b>
    <br>
    <?= $this->render('_form_m', [
        'model' => $model,
        'model_adm' => $model_adm,
    ]) ?>

</div>
