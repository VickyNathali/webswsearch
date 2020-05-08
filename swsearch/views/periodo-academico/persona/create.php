<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Persona */

$this->title = 'Crear administrador';
$this->params['breadcrumbs'][] = ['label' => 'Personas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="persona-create">

    <b><h1 align="left" style="font-family:Trebuchet MS;"><?= Html::encode($this->title) ?></h1></b><br>

    <?= $this->render('_form', [
        'model' => $model,
        'model_adm' => $model_adm,
    ]) ?>

</div>
