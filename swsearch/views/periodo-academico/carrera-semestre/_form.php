<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CarreraSemestre */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="carrera-semestre-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ID_SEM')->textInput() ?>

    <?= $form->field($model, 'ID_CAR')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
