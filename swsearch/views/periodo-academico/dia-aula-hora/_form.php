<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DiaAulaHora */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dia-aula-hora-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'CODIGO_ASIG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ID_PER')->textInput() ?>

    <?= $form->field($model, 'CEDULA_DOC')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ID_HORA')->textInput() ?>

    <?= $form->field($model, 'ID_DIA')->textInput() ?>

    <?= $form->field($model, 'ID_AUL')->textInput() ?>

    <?= $form->field($model, 'OBSERVACIONES_DAH')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PARALELO')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
