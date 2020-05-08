<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dia */

$this->title = 'Modificar Dia: ' . $model->ID_DIA;
$this->params['breadcrumbs'][] = ['label' => 'Dias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_DIA, 'url' => ['view', 'id' => $model->ID_DIA]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="dia-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
