<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AsigDocPerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="asig-doc-per-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'CODIGO_ASIG') ?>

    <?= $form->field($model, 'ID_PER') ?>

    <?= $form->field($model, 'CEDULA_DOC') ?>

    <?= $form->field($model, 'PARALELO') ?>

    <?= $form->field($model, 'ID_CAR') ?>

    <?php // echo $form->field($model, 'ID_SEM') ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reiniciar', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
