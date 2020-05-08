<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Administrador */

$this->title = 'Modificar Administrador: ' . $model->CEDULA_PER;
$this->params['breadcrumbs'][] = ['label' => 'Administradors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CEDULA_PER, 'url' => ['view', 'id' => $model->CEDULA_PER]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="administrador-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
