<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CarreraSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="carrera-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID_CAR') ?>

    <?= $form->field($model, 'NOMBRE_CAR') ?>

    <?= $form->field($model, 'DIRECTOR_CAR') ?>

    <?= $form->field($model, 'DURACION_CAR') ?>

    <?= $form->field($model, 'TITULO_OBT_CAR') ?>
    
    <?= $form->field($model, 'ESTADO_CAR') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
