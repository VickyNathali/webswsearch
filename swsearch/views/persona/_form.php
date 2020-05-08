<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Persona */
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
<div class="persona-form">
    <!--Cambiar $form para la foto-->
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?> 
    <div class="row">
        <div class="col-md-3">             
        </div>
        <div class="col-md-6"> 
            <div class="panel panel-footer" id="cuadroDI" >
                <div class="panel-heading" align="center" id="subtitl" >DATOS PERSONALES</div>
                <div class="panel-body">
                    <?= $form->field($model, 'CEDULA_PER')->textInput(['maxlength' => true, 'autofocus' => 'autofocus', 'placeholder' => '2200000001', 'onkeypress' => 'return soloNumeros(event);', 'onchange' => 'js:validar("validar");']) ?> 
                    <div id="salida">      
                    </div>
                    <div id='mensaje_codigo'>
                    </div> 
                    <?= $form->field($model, 'NOMBRES_PER')->textInput(['maxlength' => true, 'placeholder' => 'JUAN ALBERTO', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase();', 'onkeypress' => 'return soloLetras(event);', 'onpaste' => 'return false']) ?>
                    <?= $form->field($model, 'APELLIDOS_PER')->textInput(['maxlength' => true, 'placeholder' => 'ALTAMIRANO LÓPEZ', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase();', 'onkeypress' => 'return soloLetras(event);', 'onpaste' => 'return false']) ?>
                    <?= $form->field($model_adm, 'CARGO_ADM')->textInput(['maxlength' => true, 'placeholder' => 'TÉCNICO DOCENTE', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase();', 'onkeypress' => 'return soloLetras(event);', 'onpaste' => 'return false']) ?>
                    <?= $form->field($model_adm, 'TITULO_ADM')->textInput(['maxlength' => true, 'placeholder' => 'INGENIERO INFORMÁTICO', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase();', 'onkeypress' => 'return soloLetras(event);', 'onpaste' => 'return false']) ?>
                    <?= $form->field($model, 'USUARIO_PER')->textInput(['maxlength' => true, 'placeholder' => 'J.u-a_n@2', 'onkeypress' => 'return validarUsuario(event);']) ?>
                    <?php
                    //*** CREADO PARA CONSULTAR SI EL NOMBRE DE USUARIO YA EXISTE EN EL SISTEMA***
                            $this->registerJs(
                                    "                                          
                                        $(document).ready(function () {
                                            $('#persona-usuario_per').change(function () {
                                                  $.ajax({
                                                    type: 'POST',
                                                    url: 'buscar_nombre_usuario',
                                                    data: {nusuario: $('#persona-usuario_per').val()},
                                                    success: function (responseText) {                                                        
                                                        var nombre = $('#persona-usuario_per').val();
                                                        var mensaje = JSON.parse(responseText);
                                                        $('#persona-usuario_per').val('$model->USUARIO_PER');
                                                        $('#persona-usuario_per').focus();
                                                        $('#mensaje_usuario').html('<div class=\"alert alert-danger flash-msg\"> El nombre de usuario <b>' + nombre + '</b> ya existe!</div>');
                                                                $('.flash-msg').delay(5000).fadeOut('slow');                                                              
                                                        },
                                                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                                                             $('#mensaje_usuario').html('<div class=\"alert alert-success flash-msg\"> El nombre de usuario está disponible!</div>');
                                                                $('.flash-msg').delay(5000).fadeOut('slow');
                                                         }
                                                    });
                                            });
                                        });
                                    "
                                );
                    //*** FIN PARA CONSULTAR SI EL NOMBRE DE USUARIO YA EXISTE EN EL SISTEMA ***
                    ?>
                    <div id='mensaje_usuario'></div> 
                    <?=
                            $form->field($model, 'CONTRASENA_PER')->passwordInput(['maxlength' => true, 'placeholder' => 'Jt1234','pattern'=>'[A-Za-z0-9!?-]{6,12}','title'=>'Debe tener 6 caracteres como minímo'])
                            ->label('Contraseña ( <span onclick="mostrarPassword()"  class="fa fa-eye-slash icon"> </span> )')
                    ?>
                    <?= $form->field($model, 'TOKEN_PER')->radioList([1 => 'ACTIVO', 0 => 'INACTIVO']) ?>
                    <?php
                    if ($model->FOTO_PER != false) {
                        echo Html::img('@web/imagenes/Fotos/' . $model->FOTO_PER, ['height' => 100, 'width' => 100, 'class' => 'img-rounded']);
                        echo "<div class='alert alert-info'><h4><b>Foto actual: </b></h4>" . $model->FOTO_PER . '</div>';
                    } else {
                        echo Html::img('@web/imagenes/Fotos/sin_imagen.jpg', ['height' => 100, 'width' => 100, 'class' => 'img-rounded']);
                    }
                    ?>
                    <?= $form->field($model, 'FOTO_PER')->fileInput() ?>  
                </div>                    
            </div>

            <p class="text-center">
                <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-warning']) ?>
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
            </p>
        </div>
        <div class="col-md-3">             
        </div>
        <script type="text/javascript">
            function validar() {
                var cad = document.getElementById("persona-cedula_per").value.trim();
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
                        $('#persona-cedula_per').val('<?= $model->CEDULA_PER; ?>'); 
                        $('#persona-cedula_per').focus();
                    }
                } else if (longitud != 10) {
                    $('#salida').html('<div class="alert alert-danger flash-msg"> Cédula incorrecta!</div>');
                    $('.flash-msg').delay(2000).fadeOut('slow');
                    $('#persona-cedula_per').val('<?= $model->CEDULA_PER; ?>'); 
                    $('#persona-cedula_per').focus();
                }
                ;

                if (band === 1) {
                    $.ajax({
                        type: 'POST',
                        url: 'buscar_usuario_por_cedula',
                        data: {usuario: $('#persona-cedula_per').val()},
                        success: function (responseText) {
                            var cedula = $('#persona-cedula_per').val();
                            var mensaje = JSON.parse(responseText);
                            $('#persona-cedula_per').val('<?= $model->CEDULA_PER; ?>');
                            $('#persona-cedula_per').focus();
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
        </script>
        <script>
            function mostrarPassword() {
                var cambio = document.getElementById("persona-contrasena_per");
                if (cambio.type == "password") {
                    cambio.type = "text";
                    $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
                } else {
                    cambio.type = "password";
                    $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
                }
            }

        </script>
    </div> 
<?php ActiveForm::end(); ?>

</div>
