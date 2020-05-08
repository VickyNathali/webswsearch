<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Administrador */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="administrador-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'CEDULA_PER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CARGO_ADM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TITULO_ADM')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
