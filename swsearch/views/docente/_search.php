<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DocenteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="docente-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

     <?= $form->field($model, 'CEDULA_DOC') ?>

    <?= $form->field($model, 'NOMBRES_DOC') ?>

    <?= $form->field($model, 'APELLIDOS_DOC') ?>

    <?= $form->field($model, 'TITULO_DOC') ?>

    <?= $form->field($model, 'CELULAR_DOC') ?>

    <?php // echo $form->field($model, 'CORREO_DOC') ?>

    <?php // echo $form->field($model, 'LINK_PAG_DOC') ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reiniciar', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
