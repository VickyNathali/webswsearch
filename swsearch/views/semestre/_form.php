<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Semestre */
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
/*         color: #31708f;*/
        background-color: #c2ccd1;
    }
</style>
<script type="text/javascript" src="../js/validarEntradas.js"></script>

<div class="semestre-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-3"> 
        </div>
        <div class="col-md-6">  <br>
            <div class="panel panel-footer" id="cuadroDI" >
                <div class="panel-heading" align="center" id="subtitl" >DATO INFORMATIVO</div>
                <div class="panel-body">
                    <?= $form->field($model, 'DESCRIPCION_SEM')->textInput(['maxlength' => true, 'autofocus' => 'autofocus','placeholder' => 'PRIMERO','onkeyup' => 'javascript:this.value=this.value.toUpperCase();', 'onkeypress' => 'return soloLetras(event);']) ?>
                    <?php
                    //*** CREADO PARA CONSULTAR SI EL SEMESTRE YA EXISTE EN EL SISTEMA***
                    $this->registerJs(
                            "                                          
                                        $(document).ready(function () {
                                            $('#semestre-descripcion_sem').change(function () {
                                                  $.ajax({
                                                    type: 'POST',
                                                    url: 'buscar_sem_por_despn',
                                                    data: {descripcion: $('#semestre-descripcion_sem').val()},
                                                    success: function (responseText) {                                                        
                                                        var descripcion = $('#semestre-descripcion_sem').val();
                                                        var mensaje = JSON.parse(responseText);
                                                        $('#semestre-descripcion_sem').val('$model->DESCRIPCION_SEM');
                                                        $('#semestre-descripcion_sem').focus();                                                        
                                                        $('#mensaje_codigo').html('<div class=\"alert alert-danger flash-msg\"> La descripción <b>' + descripcion + '</b> ya existe!</div>');
                                                                $('.flash-msg').delay(5000).fadeOut('slow');                                                              
                                                        },
                                                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                                                             $('#mensaje_codigo').html('<div class=\"alert alert-success flash-msg\"> La descripción de semestre está disponible!</div>');
                                                                $('.flash-msg').delay(5000).fadeOut('slow');
                                                         }
                                                    });
                                    });
                            });
                            "
                    );
                    //*** FIN PARA CONSULTAR SI EL SEMESTRE YA EXISTE EN EL SISTEMA ***
                    ?>

                    <div id='mensaje_codigo'>
                    </div>                    
                    <?= $form->field($model, 'ESTADO_SEM')->radioList([1 => 'ACTIVO', 0 => 'INACTIVO'])->label('Estado'); ?>
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
