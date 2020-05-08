<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Carrera */

$this->title = 'Modificar carrera';
$this->params['breadcrumbs'][] = ['label' => 'Carreras', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_CAR, 'url' => ['view', 'id' => $model->ID_CAR]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="carrera-update">
     
    <b><h1 style="font-family:Trebuchet MS;"> <?= Html::encode($this->title) ?></h1></b><br>
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
