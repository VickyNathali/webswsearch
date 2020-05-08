<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\AulaLaboratorio;
use app\models\Dia;
use app\models\Hora;
use yii\helpers\ArrayHelper;
//use kartik\select2\Select2; //libreria para busqueda avanzada  mediante escritura
use pcrt\widgets\select2\Select2; //libreria para busqueda avanzada  mediante escritura

$session = Yii::$app->session;
$per = $session['id_periodo']; //periodo
$car = $session['id_carrera']; //carrera
$sem = $session['id_semestre']; //semestre   
$asig = $session['id_asignatura']; //asignatura            
$doc = $session['id_docente']; //docente
$par = $session['id_paralelo']; //paralelo

$hora = $session['id_hora']; //hora
$dia = $session['id_dia']; //dia
$aula = $session['id_aula']; //aula
?>
<style> 
    #cuadroDI {
        border-top: 2px solid #c2ccd1;
        border-right: 2px solid #c2ccd1;
        border-bottom: 2px solid #c2ccd1;
        border-left: 2px solid #c2ccd1;        
        border-radius: 1rem; 
    }
    #subtitl {
        font-size:20px;
        font-weight:bold;
        background-color: #c2ccd1;         
    }
</style>
<div class="asig-doc-per-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?> 

    <?php
    echo "<b>" . ' Asignatura: ' . "</b>";
    echo $model_aula->cODIGOASIG->cAR->cODIGOASIG->NOMBRE_ASIG;
    echo "<br>";
    echo "<br>";
    echo "<b>" . ' Período acádemico: ' . "</b>";
    echo $model_aula->cODIGOASIG->cAR->pER->INICIO_PER . ' ' . $model_aula->cODIGOASIG->cAR->pER->FIN_PER;
    echo "<br>";
    echo "<br>";
    echo "<b>" . ' Docente: ' . "</b>";
    echo $model_aula->cODIGOASIG->cEDULADOC->NOMBRES_DOC . ' ' . $model_aula->cODIGOASIG->cEDULADOC->APELLIDOS_DOC;
    echo "<br>";
    echo "<br>";
    echo "<b>" . ' Paralelo: ' . "</b>";
    echo $model_aula->cODIGOASIG->PARALELO;
    echo "<br>";
    echo "<br>";
    ?>   
    <!--mostrar periodo y asignatura que esta seleccionada-->
    <div class="row">
        <div class="col-md-12"> 
            <div class="panel panel-footer" id="cuadroDI" >
                <div class="panel-body">
                    <?php
                    //para el día   
                    $var1 = ArrayHelper::map(Dia::find()->all(), 'ID_DIA', 'DESCRIPCION_DIA');
                    echo $form->field($model_aula, 'ID_DIA')->dropDownList($var1, [
                        'prompt' => 'Seleccionar ...',
                        'onClick' => '$.post("' . Yii::$app->urlManager->createUrl('dia-aula-hora/listar_hora_dia?id=') . '"+$(this).val(), function( data ) {$("#diaaulahora-id_hora").html(data);});'
                    ]);

//                    
//                    $var1 = ArrayHelper::map(Dia::find()->all(), 'ID_DIA', 'DESCRIPCION_DIA');
//                    echo $form->field($model_aula, 'ID_DIA')
//                            ->widget(Select2::classname(), [
//                                'data' => $var1,
//                                'options' => ['placeholder' => 'Seleccionar ...'],
//                                    ]
//                    );
                    //fin del día
                    ?> 

                    <?php
                    $horas = "SELECT
                            * FROM `hora`
                            WHERE `ID_HORA` NOT IN (SELECT d.`ID_HORA` FROM `hora` AS h 
                            INNER JOIN `dia_aula_hora` AS d 
                            ON h.`ID_HORA` = d.`ID_HORA` 
                            WHERE d.ID_CAR = '" . $car . "' AND d.ID_SEM = '" . $sem . "' AND d.ID_DIA = '" . $dia . "' AND 
                            d.ID_PER = '" . $per . "' AND d.PARALELO = '" . $par . "')OR ID_HORA = '" . $hora . "' ORDER BY INICIO_HORA ASC";

                    //para el hora
                    
                    $var = ArrayHelper::map(Hora::findBySql($horas)->all(), 'ID_HORA', function ($model_aula) {
                                return $model_aula['INICIO_HORA'] . ' ' . $model_aula['FIN_HORA'];
                            });
                    echo $form->field($model_aula, 'ID_HORA')->dropDownList($var, [
                        'prompt' => 'Seleccionar ...',
                        'onClick' => '$.post("' . Yii::$app->urlManager->createUrl('dia-aula-hora/listar_aula_hora?id=') . '"+$(this).val(), function( data ) {$("select#diaaulahora-id_aul").html(data);});'
                    ]);
                    
                    //aumentar libreria en composer.json
                   // "kartik-v/yii2-widget-select2": "@dev"
                                                            
//                    echo $form->field($model_aula, 'ID_HORA')
//                            ->widget(Select2::classname(), [
//                                'data' => $var,
//                                'options' => ['placeholder' => 'Seleccionar ...'],
//                                'pluginOptions' => [
//                                    'allowClear' => true,
//                                ],
//                                'pluginEvents' => [
//                                    "select2:select" => "function() { "                                    
//                                    . "  $.ajax({
//                                type: 'POST',
//                                url:  '../dia-aula-hora/listar_aula_hora?id='+$(this).val(),
//                                data: {                                   
//                                },
//                                success: function (responseText) {                                
//                                  $('select#diaaulahora-id_aul').html(responseText);                                  
//                                }
//                            });"
//                                    . "}",
//                                ]
//                                ] );
                    //fin del hora
                    ?>
                    <?php
                    //para el aula
                    $vara = ArrayHelper::map(AulaLaboratorio::find()->orderBy('NOMBRE_AUL asc')->all(), 'ID_AUL', function ($model_aula) {
                                return $model_aula['NOMBRE_AUL'];
                            });
                    echo $form->field($model_aula, 'ID_AUL')
                            ->widget(Select2::classname(), [
                                'items' => $vara,
                                'options' => ['placeholder' => 'Seleccionar ...'],
                                    ]
                    );
                    //fin el aula
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
