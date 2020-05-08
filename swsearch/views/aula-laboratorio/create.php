<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AulaLaboratorio */

$this->title = 'Crear aula o laboratorio';
$this->params['breadcrumbs'][] = ['label' => 'Aula Laboratorios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aula-laboratorio-create">
    
    <b><h1 style="font-family:Trebuchet MS;"><?= Html::encode($this->title) ?></h1></b><br>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
