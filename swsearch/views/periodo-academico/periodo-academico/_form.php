<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PeriodoAcademico */
/* @var $form yii\widgets\ActiveForm */
?>

<style> 
    #cuadroDI {
        border-top: 1px solid #c2ccd1;
        border-right: 1px solid #c2ccd1;
        border-bottom: 1px solid #c2ccd1;
        border-left: 1px solid #c2ccd1;        
        border-radius: 0.5rem; 
    }
    #subtitl {
        font-size:20px;
        font-weight:bold;
/*        color: #31708f;*/
        background-color: #c2ccd1;     
    }
</style>

<div class="periodo-academico-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-3"> </div>
        <div class="col-md-6"> 
            <div class="panel panel-footer" id="cuadroDI" >
                <div class="panel-heading" align="center" id="subtitl" >DATOS INFORMATIVOS</div>
                <div class="panel-body">
                                                                      
                    <?php // $form->field($model, 'INICIO_PER')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'INICIO_PER')->textInput(['type' => 'date','autofocus' => 'autofocus','id'=> 'fechauno']) ?>                    
                    <?= $form->field($model, 'FIN_PER')->textInput(['type' => 'date', 'min' => '']) ?> 
                    <?= $form->field($model, 'OBSERVACIONES_PER')->textarea(['maxlength' => true]) ?>

                </div>                    
            </div>
            
            <p class="text-center">
                <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-warning']) ?>
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
            </p>    
        </div>
        <div class="col-md-3">  </div>  
    </div>
    <?php ActiveForm::end(); ?>

</div>
