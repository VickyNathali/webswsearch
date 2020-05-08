<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AsigDocPer */

$this->title = 'Modificar Asig Doc Per: ' . $model->CODIGO_ASIG;
$this->params['breadcrumbs'][] = ['label' => 'Asig Doc Pers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CODIGO_ASIG, 'url' => ['view', 'CODIGO_ASIG' => $model->CODIGO_ASIG, 'ID_PER' => $model->ID_PER, 'CEDULA_DOC' => $model->CEDULA_DOC, 'PARALELO' => $model->PARALELO, 'ID_CAR' => $model->ID_CAR, 'ID_SEM' => $model->ID_SEM]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="asig-doc-per-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
