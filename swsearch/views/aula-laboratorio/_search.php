<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AulaLaboratorioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aula-laboratorio-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID_AUL') ?>

    <?= $form->field($model, 'NOMBRE_AUL') ?>

    <?= $form->field($model, 'LATITUD_AUL') ?>

    <?= $form->field($model, 'LONGITUD_AUL') ?>

    <?= $form->field($model, 'ALTURA_AUL') ?>

    <?php // echo $form->field($model, 'FOTO_AUL') ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reiniciar', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
