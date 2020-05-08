<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Dia */
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
        background-color: #c2ccd1;         
    }
</style>

<div class="dia-form">
    <?php $form = ActiveForm::begin(); ?>   
    <div class="row">
        <div class="col-md-3"> 
            <!--user-->
            <div class="img-responsive">
                <center> 
                    <img src="<?= \Yii::$app->request->BaseUrl; ?>/imagenes/iconos/monday.png" alt="Día" />
                </center>                  
            </div>
            <!--user-->
        </div>
        <div class="col-md-1"> </div>
        <div class="col-md-6">  <br> <br>
            <div class="panel panel-footer" id="cuadroDI" >
                <div class="panel-heading" align="center" id="subtitl" >DATO INFORMATIVO</div>
                <div class="panel-body">
                    <?= $form->field($model, 'DESCRIPCION_DIA')->textInput(['maxlength' => true]) ?>
                    <?php
                    //*** CREADO PARA CONSULTAR SI EL DIA YA EXISTE EN EL SISTEMA***
                    $this->registerJs(
                            "                                          
                                        $(document).ready(function () {
                                            $('#dia-descripcion_dia').change(function () {
                                                ////////////////////////////////
                                                  $.ajax({
                                                    type: 'POST',
                                                    url: 'buscar_dia_por_nombre',
                                                    data: {dia: $('#dia-descripcion_dia').val()},
                                                    success: function (responseText) {                                                        
                                                        var descripcion = $('#dia-descripcion_dia').val();
                                                        var mensaje = JSON.parse(responseText);
                                                        $('#dia-descripcion_dia').val('');  
                                                        $('#mensaje_codigo').html('<div class=\"alert alert-danger flash-msg\"> La descripción <b>' + descripcion + '</b> ya existe!</div>');
                                                                $('.flash-msg').delay(5000).fadeOut('slow');
                                                              
                                                        },
                                                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                                                             $('#mensaje_codigo').html('<div class=\"alert alert-success flash-msg\"> La descripción de día está disponible!</div>');
                                                                $('.flash-msg').delay(5000).fadeOut('slow');
                                                         }
                                                    });
                                                ////////////////////////////////
                                    });
                            });
                            "
                    );
                    //*** FIN PARA CONSULTAR SI EL DIA YA EXISTE EN EL SISTEMA ***
                    ?>

                    <div id='mensaje_codigo'>
                    </div>                    
                </div>                    
            </div>
            <p class="text-center">
                <?= Html::a('Cancelar', ['../web'], ['class' => 'btn btn-warning']) ?>
                <!--                <div class="form-group" id="botones">-->
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
                <!--</div>-->
            </p>   
        </div>
        <div class="col-md-2">             
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
