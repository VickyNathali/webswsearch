<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AulaLaboratorio */
/* @var $form yii\widgets\ActiveForm */
?>
<style> 
    ::placeholder {        
    font-style: italic;
    }
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
<div class="aula-laboratorio-form">  

    <?php //Cambiar $form para el pdf ?>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?> 

    <div class="row">
        <div class="col-md-3"> </div>
        <div class="col-md-6"> 
            <div class="panel panel-footer" id="cuadroDI" >
                <div class="panel-heading" align="center" id="subtitl" >DATOS INFORMATIVOS</div>
                <div class="panel-body">

                    <?= $form->field($model, 'NOMBRE_AUL')->textInput(['maxlength' => true, 'autofocus' => 'autofocus', 'placeholder' => 'Ej.: LAB. PROGRAMACIÓN - EIS', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase();']) ?>
                    <?php
                    //*** CREADO PARA CONSULTAR SI EL AULA O LABORATORIO YA EXISTE EN EL SISTEMA***
                    $this->registerJs(
                            "                                          
                                        $(document).ready(function () {
                                            $('#aulalaboratorio-nombre_aul').change(function () {
                                                ////////////////////////////////
                                                  $.ajax({
                                                    type: 'POST',
                                                    url: 'buscar_aula_por_nombre',
                                                    data: {aulalaboratorio: $('#aulalaboratorio-nombre_aul').val()},
                                                    success: function (responseText) {                                                        
                                                        var nombre = $('#aulalaboratorio-nombre_aul').val();
                                                        var mensaje = JSON.parse(responseText);
                                                        $('#aulalaboratorio-nombre_aul').val('');
                                                        $('#aulalaboratorio-nombre_aul').focus();
                                                        $('#mensaje_codigo').html('<div class=\"alert alert-danger flash-msg\"> El nombre de aula <b>' + nombre + '</b> ya existe!</div>');
                                                                $('.flash-msg').delay(5000).fadeOut('slow');                                                              
                                                        },
                                                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                                                             $('#mensaje_codigo').html('<div class=\"alert alert-success flash-msg\"> El nombre de aula está disponible!</div>');
                                                                $('.flash-msg').delay(5000).fadeOut('slow');
                                                         }
                                                    });
                                                ////////////////////////////////
                                    });
                            });
                            "
                    );
                    //*** FIN PARA CONSULTAR SI LA ASIGNATURA YA EXISTE EN EL SISTEMA ***
                    ?>

                    <div id='mensaje_codigo'>
                    </div>                    

                    <?= $form->field($model, 'LATITUD_AUL')->textInput(['maxlength' => true,'placeholder' => 'Ej.: -1.656072']) ?>
                    <?= $form->field($model, 'LONGITUD_AUL')->textInput(['maxlength' => true,'placeholder' => 'Ej.: -78.679219']) ?>
                    <?= $form->field($model, 'ESTADO_AUL')->radioList([1 => 'ACTIVA', 0 => 'INACTIVA'])->label('Estado'); ?>

                    <?php
                      // subir la foto
                    if ($model->FOTO_AUL != false) {
                        echo Html::img('@web/imagenes/aulas/' . $model->FOTO_AUL, ['height' => 100, 'width' => 100, 'class'=>'img-rounded']);
                        echo "<div class='alert alert-info'><h4><b>Foto actual: </b></h4>" . $model->FOTO_AUL . '</div>';
                    } else {
                        echo Html::img('@web/imagenes/aulas/sin_imagen.jpg', ['height' => 100, 'width' => 100, 'class'=>'img-rounded']);
                    }
                    // Fin de la foto
                    ?>                    
                    <?= $form->field($model, 'FOTO_AUL')->fileInput(['required'=>true]) ?>
                    <?= $form->field($model, 'OBSERVACIONES_AUL')->textarea(['maxlength' => true, 'placeholder' => 'Ej.: Laboratorio ubicado en el primer piso del edificio central de la FIE a la derecha al salir de elevador dirigirse al fondo...']) ?>

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
