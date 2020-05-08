<?php

use yii\helpers\ArrayHelper;
use app\models\PeriodoAcademico;
use app\models\Carrera;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Listar horarios';
?>
<style>     
    #subtitl {
        /*color: #31708f;*/
        font-size:15px;
        font-weight:bold;
        background-color: #c2ccd1; 
        border-color: #b9bfc2; 
    }
    #borTbl{
        border-color: #b9bfc2;  
    }
</style>
<div class="dia-aula-hora-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="row"> 
        <Center> <h4> <b>LISTADO DE HORARIOS DE CLASE </b> </h4>
            <h4> <b> SEGÚN LA CARRERA </b> </h4>   
        </Center> 
        <div class="col-md-12" ><br>
            <div class="col-sm-2"> </div>   
            <div class="col-sm-8"> 
                <div class="panel panel-default" id="borTbl" >
                    <div class="panel-heading" id="subtitl" > <Center> <b>Escoja los dos parámetros </b></Center></div>
                    <table class="table-bordered table-condensed table-hover table-responsive" >
                        <tr class=""> 
                            <td width="25%" class="text-justify">
                                <?php
                                //inicio el período académico
                                $var1 = ArrayHelper::map(PeriodoAcademico::find()->andFilterCompare('ESTADO_PER','3','!=')->orderBy('FIN_PER desc')->all(), 'ID_PER', function ($model) {
                                            return $model['INICIO_PER'] . ' hasta ' . $model['FIN_PER'];
                                        });
                                echo $form->field($model, 'ID_PER')->dropDownList($var1, [
                                    'prompt' => 'Seleccionar ...']);
                                ?>
                            </td>
                            <td width="25%" class="text-justify">
                                <?php
                                //para la carrera
                                $var1 = ArrayHelper::map(Carrera::find()->andFilterCompare('ESTADO_CAR','3','!=')->orderBy('NOMBRE_CAR asc')->all(), 'ID_CAR', 'NOMBRE_CAR');
                                echo $form->field($model, 'ID_CAR')->dropDownList($var1, [
                                    'prompt' => 'Seleccionar ...',
                                    'onChange' => '$.post("' . Yii::$app->urlManager->createUrl('dia-aula-hora/guardar_horario_listar?per=') . '"+$(\'#diaaulahora-id_per\').val()+"&car="+$(\'#diaaulahora-id_car\').val(),function( data ) {'
                                    . ' obj = JSON.parse(data); '
                                    . ' var n = obj[0][0];'
                                    . " 
                                    var i;
                                    var div_encabezado='';
                                    var aux_semestre = 'vacio';
                                    var aux_paralelo = 'vacio';  
                                    var dias = " . json_encode($dias) . ";
                                    var horas = " . json_encode($horas) . ";
                                    for (i = 1; i <= n; i++) { 
                                      if (obj[i]['ID_SEM'] != aux_semestre || obj[i]['PARALELO'] != aux_paralelo ){
                                            aux_paralelo = obj[i]['PARALELO']; 
                                            aux_semestre = obj[i]['ID_SEM'];                                            
                                            div_encabezado += '<div class=\"col-md-12\" >';
                                                div_encabezado += '<h4><center> <b>ESCUELA SUPERIOR POLITÉCNICA DE CHIMBORAZO</b></center></h4>';  
                                                div_encabezado += '<div class=\"col-md-6\" >';
                                                    div_encabezado += '<h5><b>FACULTAD:</b> INFORMÁTICA Y ELECTRÓNICA</h5><br>'; 
                                                div_encabezado += '</div>';
                                                
                                                div_encabezado += '<div class=\"col-md-6\">';
                                                div_encabezado += '<h5  align=\"right\"> <b>ESCUELA:</b> INGENIERÍA EN SISTEMAS</h5>';  
                                                div_encabezado += '<h5  align=\"right\"> <b>CARRERA:</b> '+obj[1]['ID_CAR']+'</h5>';
                                                div_encabezado += '<h5  align=\"right\"> <b>'+obj[1]['ID_PER']+'</b></h5>';     
                                                div_encabezado += '</div>';
                                                                                                                                           
                                                div_encabezado += '<center> <b>HORARIO DE CLASES</b></center>';
                                                div_encabezado += '<center> <b>'+obj[i]['ID_SEM']+' NIVEL - PARALELO '+obj[i]['PARALELO']+'</b></center><br>';                                                
                                               
                                                div_encabezado += '<table class=\"table table-bordered table-hover table-responsive\" id=\"cuadroDI\">';
                                                div_encabezado += '<thead class=\"thead-light\">';
                                                div_encabezado += '<tr class=\"bg-warning\" >';
                                                div_encabezado += '<td width=\"10%\" class=\"text-center\"><strong>Hora</strong></td>';
                                                     dias.forEach(function(dia){
                                                        div_encabezado += '<td width=\"18%\" class=\"text-center\"><strong>'+dia+'</strong></td>';
                                                    });                        
                                                div_encabezado += '</tr>';
                                                div_encabezado += '</thead>';
                                                div_encabezado += '<tbody class=\"table-striped\">';
                                                
                                                horas.forEach(function(hora){
                                                    div_encabezado += '<tr>';
                                                    div_encabezado += '<td class=\" bg-warning text-center\"><strong>'+hora+'</strong></td>';
                                                     dias.forEach(function(dia){
                                                        div_encabezado += '<td class=\"text-center\">';
                                                          for (j = 1; j <= n; j++) {
                                                            if(obj[j]['ID_SEM'] == obj[i]['ID_SEM']
                                                            && obj[j]['PARALELO'] == obj[i]['PARALELO']
                                                            && obj[j]['ID_DIA'] == dia
                                                            && obj[j]['ID_HORA'] == hora){
                                                            //console.log('???????????????????');
                                                            //console.log(obj[j]['CODIGO_ASIG']);
                                                                div_encabezado += obj[j]['CODIGO_ASIG']+'<br>';
                                                                div_encabezado += obj[j]['CEDULA_DOC']+'<br>';
                                                                div_encabezado += obj[j]['ID_AUL'];
                                                            }
                                                          }
                                                        div_encabezado += '</td>';
                                                        });   
                                                    div_encabezado += '</td>';
                                                    div_encabezado += '</tr>';
                                                  });
                                                
                                                div_encabezado += '</tbody>';
                                                div_encabezado += '</table>';
                                                div_encabezado += '</div><br>';
                                        };
                                    };
                                    $('#listado').html(div_encabezado); "
                                    . '});'
                                ]);
                                //fin la carrera
                                ?> 
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-sm-2">
                <a href="<?= Yii::$app->homeUrl ?>dia-aula-hora/listar_pdf" target="_blank">
                    <button type="button" class="btn btn-danger"> 
                        <img src="<?= Yii::$app->homeUrl ?>/imagenes/iconos/pdf.png" alt="Pdf"/> Pdf   
                    </button>
                </a> 

            </div>   
        </div>
        <div id="listado">
        </div>
        <!------------------------------------------------------------------------------------------------------------>
    </div>



    <?php ActiveForm::end(); ?>
</div>


