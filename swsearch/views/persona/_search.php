<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PersonaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="persona-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'CEDULA_PER') ?>

    <?= $form->field($model, 'NOMBRES_PER') ?>

    <?= $form->field($model, 'APELLIDOS_PER') ?>

    <?= $form->field($model, 'USUARIO_PER') ?>

    <?= $form->field($model, 'CONTRASEÑA_PER') ?>
    
     <?= $form->field($model, 'TOKEN_PER') ?>

    <?php // echo $form->field($model, 'FOTO_PER') ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reiniciar', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
