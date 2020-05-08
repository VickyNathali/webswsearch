<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Carrera;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Estudiante */
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
<div class="estudiante-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-3">             
        </div>
        <div class="col-md-6"> 
            <div class="panel panel-footer" id="cuadroDI" >
                <div class="panel-heading" align="center" id="subtitl" >DATOS PERSONALES</div>
                <div class="panel-body">
                    <center>
                        <?php
                        if ($model_persona->FOTO_PER != false) {
                            echo Html::img('@web/imagenes/Fotos/' . $model_persona->FOTO_PER, ['height' => 150, 'width' => 150, 'class' => 'img-rounded']);
                        } else {
                            echo Html::img('@web/imagenes/Fotos/sin_imagen.jpg', ['height' => 150, 'width' => 150, 'class' => 'img-rounded']);
                        }
                        ?>
                    </center><br>
                    <div class="auto" id="auto" style="display: none">
                        <?= $form->field($model, 'CEDULA_PER')->textInput(['maxlength' => true]) ?> 
                    </div>

                    <table class=""  >
                        <!-- 2 columnas-->
                        <tr class=" badge-info"> 
                            <td height="40" width="50%"><b>Cédula</b></td>
                            <td class="text-justify"> <?= $model->CEDULA_PER ?> </td>                                        
                        </tr>
                        <tr class=" badge-info"> 
                            <td height="40" WIDTH=""><b>Nombres y apellidos</b></td>
                            <td class="text-justify"><?= $model_persona->NOMBRES_PER . ' ' . $model_persona->APELLIDOS_PER ?>  </td>                                        
                        </tr>
                        <tr class=" badge-info"> 
                            <td height="40" WIDTH=""><b>Usuario</b></td>
                            <td class="text-justify">  <?= $model_persona->USUARIO_PER ?>  </td>                                        
                        </tr>
                        <tr class=" badge-info"> 
                            <td height="40" WIDTH=""><b>Contraseña</b></td>
                            <td class="text-justify">  <?= $model_persona->CONTRASENA_PER ?>  </td>                                        
                        </tr>                        
                        <tr class=" badge-info"> 
                            <td height="40" WIDTH=""><b>Carrera</b></td>
                            <td class="text-justify">  <?= $model->cAR->NOMBRE_CAR ?>  </td>                                        
                        </tr>                       
                        <tr class=" badge-info"> 
                            <td height="40" WIDTH=""><b> Estado</b></td>
                            <td class="text-justify">  <?= $form->field($model_persona, 'TOKEN_PER')->radioList([1 => 'ACTIVO', 0 => 'INACTIVO'])->label('') ?>  </td>                                        
                        </tr>                       
                    </table>                  
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
