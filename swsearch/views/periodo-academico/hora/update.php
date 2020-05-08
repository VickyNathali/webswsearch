<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Hora */

$this->title = 'Modificar hora ';
$this->params['breadcrumbs'][] = ['label' => 'Horas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_HORA, 'url' => ['view', 'id' => $model->ID_HORA]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="hora-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
