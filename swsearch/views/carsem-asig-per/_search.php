<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CarsemAsigPerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="carsem-asig-per-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID_CAR') ?>

    <?= $form->field($model, 'ID_SEM') ?>

    <?= $form->field($model, 'CODIGO_ASIG') ?>

    <?= $form->field($model, 'ID_PER') ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reiniciar', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
