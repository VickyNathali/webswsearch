<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DiaAulaHoraSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dia-aula-hora-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'CODIGO_ASIG') ?>

    <?= $form->field($model, 'ID_PER') ?>

    <?= $form->field($model, 'CEDULA_DOC') ?>

    <?= $form->field($model, 'ID_HORA') ?>

    <?= $form->field($model, 'ID_DIA') ?>

    <?php // echo $form->field($model, 'ID_AUL') ?>

    <?php // echo $form->field($model, 'PARALELO') ?>

    <?php // echo $form->field($model, 'ID_CAR') ?>

    <?php // echo $form->field($model, 'ID_SEM') ?>

    <?php // echo $form->field($model, 'OBSERVACIONES_DAH') ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reiniciar', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
