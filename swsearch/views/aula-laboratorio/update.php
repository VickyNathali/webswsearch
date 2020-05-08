<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AulaLaboratorio */

$this->title = 'Modificar aula o laboratorio';
$this->params['breadcrumbs'][] = ['label' => 'Aula Laboratorios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_AUL, 'url' => ['view', 'id' => $model->ID_AUL]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="aula-laboratorio-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_m', [
        'model' => $model,
    ]) ?>

</div>
