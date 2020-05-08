<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AsigDocPer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="asig-doc-per-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'CODIGO_ASIG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ID_PER')->textInput() ?>

    <?= $form->field($model, 'CEDULA_DOC')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PARALELO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ID_CAR')->textInput() ?>

    <?= $form->field($model, 'ID_SEM')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
