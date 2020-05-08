<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PeriodoAcademicoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="periodo-academico-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID_PER') ?>

    <?= $form->field($model, 'INICIO_PER') ?>

    <?= $form->field($model, 'FIN_PER') ?>

    <?= $form->field($model, 'OBSERVACIONES_PER') ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reiniciar', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
