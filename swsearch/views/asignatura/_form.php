<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Asignatura */
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
<script type="text/javascript" src="../js/validarEntradas.js"></script>

<div class="asignatura-form">

    <?php //Cambiar $form para el pdf ?>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?> 

    <div class="row">
        <div class="col-md-3"> </div>
        <div class="col-md-6"> 
            <div class="panel panel-footer" id="cuadroDI" >
                <div class="panel-heading" align="center" id="subtitl" >DATOS INFORMATIVOS</div>
                <div class="panel-body">
                    <?= $form->field($model, 'CODIGO_ASIG')->textInput(['maxlength' => true,'autofocus' => 'autofocus','placeholder' => 'SOFI1234']) ?>
                     <?php
                    //*** CREADO PARA CONSULTAR SI LA ASIGNATURA YA EXISTE EN EL SISTEMA***
                    $this->registerJs(
                            "                                          
                                        $(document).ready(function () {
                                            $('#asignatura-codigo_asig').change(function () {
                                                  $.ajax({
                                                    type: 'POST',
                                                    url: 'buscar_asig_por_codigo',
                                                    data: {asignatura: $('#asignatura-codigo_asig').val()},
                                                    success: function (responseText) {                                                        
                                                        var codigo = $('#asignatura-codigo_asig').val();
                                                        var mensaje = JSON.parse(responseText);
                                                        $('#asignatura-codigo_asig').val('$model->CODIGO_ASIG');
                                                        $('#asignatura-codigo_asig').focus();
                                                        $('#mensaje_codigo').html('<div class=\"alert alert-danger flash-msg\"> El código <b>' + codigo + '</b> pertenece a: ' + mensaje + '</div>');
                                                                $('.flash-msg').delay(5000).fadeOut('slow'); 
                                                        },
                                                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                                                             $('#mensaje_codigo').html('<div class=\"alert alert-success flash-msg\"> El código está disponible!</div>');
                                                                $('.flash-msg').delay(5000).fadeOut('slow');
                                                         }
                                                    });
                                    });
                            });
                            "
                    );
                    //*** FIN PARA CONSULTAR SI LA ASIGNATURA YA EXISTE EN EL SISTEMA ***
                    ?>
                    <div id='mensaje_codigo'> </div> 
                    
                    <?= $form->field($model, 'NOMBRE_ASIG')->textInput(['maxlength' => true,'placeholder' => 'INFORMÁTICA','onkeyup' => 'javascript:this.value=this.value.toUpperCase();']) ?>
                    <?= $form->field($model, 'OBSERVACIONES_ASIG')->textarea(['maxlength' => true]) ?>
                    <?= $form->field($model, 'ESTADO_ASIG')->radioList([1 => 'ACTIVA', 0 => 'INACTIVA'])->label('Estado'); ?>

                </div>                    
            </div>
            <p class="text-center">
                    <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-warning']) ?>
                    <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
            </p>              
        </div>
        <div class="col-md-3">             
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
