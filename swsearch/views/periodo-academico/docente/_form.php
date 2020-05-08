<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Docente */
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
        /*         color: #31708f;*/
        background-color: #c2ccd1;         
    }
</style>
<script type="text/javascript" src="../js/validarEntradas.js"></script>

<div class="docente-form">

    <?php //Cambiar $form para la foto  ?>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?> 

    <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-6"> 
            <div class="panel panel-footer" id="cuadroDI" >
                <div class="panel-heading" align="center" id="subtitl" >DATOS PERSONALES</div>
                <div class="panel-body">
                    <?= $form->field($model, 'CEDULA_DOC')->textInput(['maxlength' => true, 'autofocus' => 'autofocus','placeholder' => 'Ej.: 2200000001','onkeypress' => 'return soloNumeros(event);', 'onchange' => 'js:validar("");']) ?>
                    <div id="salida"> </div>
                    <div id='mensaje_codigo'> </div> 
                    <?= $form->field($model, 'NOMBRES_DOC')->textInput(['maxlength' => true, 'placeholder' => 'Ej.: JUAN ALBERTO', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase();', 'onkeypress' => 'return soloLetras(event);', 'onpaste' => 'return false']) ?>
                    <?= $form->field($model, 'APELLIDOS_DOC')->textInput(['maxlength' => true, 'placeholder' => 'Ej.: ALTAMIRANO LÓPEZ', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase();', 'onkeypress' => 'return soloLetras(event);', 'onpaste' => 'return false']) ?>
                    <?= $form->field($model, 'TITULO_DOC')->textInput(['maxlength' => true, 'placeholder' => 'Ej.: INGENIERO INFORMÁTICO', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase();', 'onkeypress' => 'return soloLetras(event);', 'onpaste' => 'return false']) ?>
                    <?= $form->field($model, 'CELULAR_DOC')->textInput(['maxlength' => true, 'placeholder' => 'Ej.: 0987654321', 'onkeypress' => 'return soloNumeros(event);', 'onchange' => 'js:validarCelular("");']) ?>
                    <div id="celular"> </div>        
                    <?= $form->field($model, 'CORREO_DOC')->textInput(['maxlength' => true, 'placeholder' => 'Ej.: j.altamirano@espoch.edu.ec', 'onkeyup' => 'javascript:this.value=this.value.toLowerCase();', 'onchange' => 'js:validarEmail("");']) ?>
                    <div id="email"> </div>
                    <?= $form->field($model, 'LINK_PAG_DOC')->textInput(['maxlength' => true, 'placeholder' => 'Ej.: https://www.linkedin.com/in/juan-altamirano-2aa677175/', 'onkeyup' => 'javascript:this.value=this.value.toLowerCase();']) ?>
                    <?= $form->field($model, 'ESTADO_DOC')->radioList([1 => 'ACTIVO', 0 => 'INACTIVO'])->label('Estado') ?>

                </div>                    
            </div>
            <p class="text-center">
                <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-warning']) ?>
                <!--                <div class="form-group" id="botones">-->
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
                <!--</div>-->
            </p>    
        </div>
        <div class="col-md-3">             
        </div>
        <script type="text/javascript">
            function validar() {
                var cad = document.getElementById("docente-cedula_doc").value.trim();
                var total = 0;
                var longitud = cad.length;
                var longcheck = longitud - 1;
                var band = 0;

                if (cad !== "" && longitud === 10) {
                    for (i = 0; i < longcheck; i++) {
                        if (i % 2 === 0) {
                            var aux = cad.charAt(i) * 2;
                            if (aux > 9)
                                aux -= 9;
                            total += aux;
                        } else {
                            total += parseInt(cad.charAt(i)); // parseInt o concatenará en lugar de sumar
                        }
                    }

                    total = total % 10 ? 10 - total % 10 : 0;

                    if (cad.charAt(longitud - 1) == total) {
                        $('#salida').html('<div class="alert alert-success flash-msg"> Cédula correcta!</div>');
                        $('.flash-msg').delay(2000).fadeOut('slow');
                        band = 1;
                    } else {
                        $('#salida').html('<div class="alert alert-danger flash-msg"> Cédula incorrecta!</div>');
                        $('.flash-msg').delay(2000).fadeOut('slow');                       
                        $('#docente-cedula_doc').val('<?= $model->CEDULA_DOC; ?>'); 
                        $('#docente-cedula_doc').focus();
                    }
                } else if (longitud != 10) {
                    $('#salida').html('<div class="alert alert-danger flash-msg"> Cédula incorrecta!</div>');
                    $('.flash-msg').delay(2000).fadeOut('slow');
                    $('#docente-cedula_doc').val('<?= $model->CEDULA_DOC; ?>'); 
                    $('#docente-cedula_doc').focus();
                }
                ;
                if (band === 1) {
                    $.ajax({
                        type: 'POST',
                        url: 'buscar_docente_por_cedula',
                        data: {docente: $('#docente-cedula_doc').val()},
                        success: function (responseText) {
                            var cedula = $('#docente-cedula_doc').val();
                            var mensaje = JSON.parse(responseText);
                            $('#docente-cedula_doc').val('<?= $model->CEDULA_DOC; ?>');
                            $('#docente-cedula_doc').focus();
                            $('#mensaje_codigo').html('<div class="alert alert-warning flash-msg"> La cédula <b>' + cedula + '</b> pertenece a: ' + mensaje + '</div>');
                            $('.flash-msg').delay(2000).fadeOut('slow');

                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            $('#mensaje_codigo').html('<div class="alert alert-success flash-msg"> La cédula está disponible!</div>');
                            $('.flash-msg').delay(2000).fadeOut('slow');
                        }
                    });
                }
            }

            function validarEmail()
            {
                var email = document.getElementById("docente-correo_doc").value.trim();
                // Patron para el correo
                var patron = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
                if (patron.test(email))
                {
                    //Correo correcto
                    $('#email').html('<div class="alert alert-success flash-msg"> Correo válido!</div>');
                    $('.flash-msg').delay(2000).fadeOut('slow');
                } else {
                    //Correo incorrecto
                    $('#email').html('<div class="alert alert-danger flash-msg"> Correo invalido!</div>');
                    $('.flash-msg').delay(2000).fadeOut('slow');
                    $('#docente-correo_doc').val('<?= $model->CORREO_DOC; ?>');
                    $('#docente-correo_doc').focus();
                }
            }

            function validarCelular()
            {
                var celular = document.getElementById("docente-celular_doc").value.trim();
                // Patron para el celular comprueba si escribió 10 numeros
                var patron = /^\d{10}$/;                             
                if (patron.test(celular))
                {
                    //Correo correcto
                    $('#celular').html('<div class="alert alert-success flash-msg"> Celular válido!</div>');
                    $('.flash-msg').delay(2000).fadeOut('slow');
                } else {
                    //Correo incorrecto
                    $('#celular').html('<div class="alert alert-danger flash-msg"> Celular invalido!</div>');
                    $('.flash-msg').delay(2000).fadeOut('slow');
                    $('#docente-celular_doc').val('<?= $model->CELULAR_DOC; ?>');
                    $('#docente-celular_doc').focus();
                }
            }
        </script>
    </div>
    <?php ActiveForm::end(); ?>

</div>
