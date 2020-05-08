<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Semestre;
use yii\helpers\ArrayHelper;
use pcrt\widgets\select2\Select2; //libreria para busqueda avanzada  mediante escritura
/* @var $this yii\web\View */
/* @var $model app\models\Carrera */
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

<div class="carrera-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-3"> </div>
        <div class="col-md-6"> 
            <div class="panel panel-footer" id="cuadroDI" >
                <div class="panel-heading" align="center" id="subtitl" >DATOS INFORMATIVOS</div>
                <div class="panel-body">
                    <?= $form->field($model, 'NOMBRE_CAR')->textInput(['maxlength' => true, 'autofocus' => 'autofocus','placeholder' => 'INGENIERÍA EN INFORMÁTICA', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase();', 'onkeypress' => 'return soloLetras(event);']) ?>
                    <?php
                    //*** CREADO PARA CONSULTAR SI LA CARRERA YA EXISTE EN EL SISTEMA***
                    $this->registerJs(
                            "                                          
                                        $(document).ready(function () {
                                            $('#carrera-nombre_car').change(function () {
                                                ////////////////////////////////
                                                  $.ajax({
                                                    type: 'POST',
                                                    url: 'buscar_car_por_nombre',
                                                    data: {carrera: $('#carrera-nombre_car').val()},
                                                    success: function (responseText) {                                                        
                                                        var nombre = $('#carrera-nombre_car').val();
                                                        var mensaje = JSON.parse(responseText);
                                                        $('#carrera-nombre_car').val('$model->NOMBRE_CAR');
                                                        $('#carrera-nombre_car').focus();
                                                        $('#mensaje_codigo').html('<div class=\"alert alert-danger flash-msg\"> El nombre de carrera <b>' + nombre + '</b> ya existe!</div>');
                                                                $('.flash-msg').delay(5000).fadeOut('slow');                                                              
                                                        },
                                                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                                                             $('#mensaje_codigo').html('<div class=\"alert alert-success flash-msg\"> El nombre de carrera está disponible!</div>');
                                                                $('.flash-msg').delay(5000).fadeOut('slow');
                                                         }
                                                    });
                                                ////////////////////////////////
                                    });
                            });
                            "
                    );
                    //*** FIN PARA CONSULTAR SI LA CARRERA YA EXISTE EN EL SISTEMA ***
                    ?>

                    <div id='mensaje_codigo'>
                    </div> 
                    <?= $form->field($model, 'DIRECTOR_CAR')->textInput(['maxlength' => true,'placeholder' => 'ING. PEPE OLVARES', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase();', 'onkeypress' => 'return soloLetras(event);']) ?>        
                    
                    <?= $form->field($model, 'TITULO_OBT_CAR')->textInput(['maxlength' => true, 'placeholder' => 'INGENIERO/A EN INFORMÁTICA', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase();', 'onkeypress' => 'return soloLetras(event);']) ?>       
                    
                     <?php
                    //para la semestre                     
                    $var1 = ArrayHelper::map(Semestre::find()->where(['ESTADO_SEM' => 1])->all(), 'ID_SEM', 'ID_SEM');                    
                    echo $form->field($model, 'DURACION_CAR')
                                ->widget(Select2::classname(), [
                                    'items' => $var1,
                                    'options' => ['placeholder' => 'Seleccionar ...'],
                                        ]
                        );
                    //fin la semestre
                    ?>  
                    
                    <?= $form->field($model, 'ESTADO_CAR')->radioList([1 => 'ACTIVA', 0 => 'INACTIVA'])->label('Estado'); ?>
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
    </div>

    <?php ActiveForm::end(); ?>

</div>
