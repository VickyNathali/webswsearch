<?php

use yii\helpers\ArrayHelper;
use app\models\PeriodoAcademico;
use app\models\Carrera;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Listar asignaturas y docentes';
?>
<style>     
    #subtitl {
        /*        color: #31708f;*/
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
        <Center> <h4> <b>LISTADO DE LAS ASIGNATURAS CON SUS RESPECTIVOS DOCENTES</b> </h4> 
            <h4> <b> SEGÚN LA CARRERA </b> </h4>   
        </Center> 
        <div class="col-md-12" ><br>
            <div class="col-sm-2"> </div>   
            <div class="col-sm-8"> 
                <div class="panel panel-default" id="borTbl" >
                    <div class="panel-heading" id="subtitl" > <Center> <b>Escoja los dos parámetros</b></Center></div>
                    <table class="table-bordered table-condensed table-hover " >
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
                                    'onChange' => '$.post("' . Yii::$app->urlManager->createUrl('asig-doc-per/guardar_asigdoc_listar?id=') . '"+$(\'#asigdocper-id_per\').val()+"&car="+$(\'#asigdocper-id_car\').val(),function( data ) {'
                                    . ' obj = JSON.parse(data); '
                                    . ' var n = obj[0][0];'
                                    . " 
                                    var i;
                                    var div_encabezado='';
                                    var aux_semestre = 'vacio'; 
                                    var aux = 'vacio';
                                    for (i = 1; i <= n; i++) { 
                                    if (obj[1]['ID_CAR'] != aux){                                         
                                     div_encabezado += '<div class=\"col-md-1\" >';
                                     div_encabezado += '</div>';
                                     div_encabezado += '<div class=\"col-md-10\" >';
                                        div_encabezado += '<div class=\"panel panel-default\" id=\"borTbl\" >';
                                                div_encabezado += '<div class=\"panel-heading\" id=\"subtitl\" >';
                                                  div_encabezado += '<center> <b>LISTA DE ASIGNATURAS Y ASIGNACIÓN DE DOCENTES</b></center>';
                                                div_encabezado += '</div><br>';                                                
                                            div_encabezado += '<div class=\"panel-body\" >';  
                                                div_encabezado += '<h4  align=\"left\"> <b>Carrera: </b> '+obj[1]['ID_CAR']+'</h4>';
                                                div_encabezado += '<h4  align=\"left\"> <b>Período académico: </b>'+obj[1]['ID_PER']+'</b></h4>';     
                                                                                                                                                                                          
                                            for (i = 1; i <= n; i++) { 
                                                if (obj[i]['ID_SEM'] != aux_semestre){                                                    
                                                    aux_semestre = obj[i]['ID_SEM'];
                                                                                                                                                                    
                                                div_encabezado += '<center> <b>'+obj[i]['ID_SEM']+' NIVEL</b></center><br>'; 
                                                div_encabezado += '<table class=\"table table-bordered table-condensed table-responsive table-hover table-striped\">';
                                                    div_encabezado += '<thead>';
                                                        div_encabezado += '<th width=\" 5%\" class=\"text-center\">N°</th>';
                                                        div_encabezado += '<th width=\" 50%\" class=\"text-center\">Asignatura</th>';
                                                        div_encabezado += '<th width=\"\" class=\"text-center\">Asignaciones</th>';
                                                    div_encabezado += '</thead>';
                                                    div_encabezado += '<tbody >';                                                                                                      
                                                           var cont_materias=1; 
                                                           var bandera_materia = 0; 
                                                           var lista_materias = new Array();
                                                        for (j = 1; j <= n; j++) {
                                                        div_encabezado += '<tr>'; 
                                                         for (k = 0; k < cont_materias; k++) {
                                                          if (lista_materias[k] == obj[j]['CODIGO_ASIG'])
                                                            bandera_materia = 1;
                                                         }
                                                            if(obj[j]['ID_SEM'] == obj[i]['ID_SEM'] &&  bandera_materia == 0 ) {                                                             
                                                                lista_materias[cont_materias-1] = obj[j]['CODIGO_ASIG'];                                                            
                                                                div_encabezado += '<td style=\"text-align:center;\">'+cont_materias+'</td>';                                                                   
                                                                div_encabezado += '<td>'+obj[j]['CODIGO_ASIG']+'</td>';
                                                                div_encabezado += '<td>';
                                                                    div_encabezado += '<table class=\"table table-bordered table-condensed table-responsive table-hover table-striped\">';
                                                                        div_encabezado += '<thead>';
                                                                            div_encabezado += '<th width=\"15% \" class=\"text-center\">Paralelo</th>';
                                                                            div_encabezado += '<th width=\"\" class=\"text-center\">Docente</th>';
                                                                        div_encabezado += '</thead>';
                                                                        div_encabezado += '<tbody >';
                                                                            for (m = 1; m <= n; m++) {
                                                                            div_encabezado += '<tr>';   
                                                                             if( obj[j]['CODIGO_ASIG'] == obj[m]['CODIGO_ASIG']){
                                                                                div_encabezado += '<td style=\"text-align:center;\" >'+obj[m]['PARALELO']+'</td>';
                                                                                div_encabezado += '<td>'+obj[m]['CEDULA_DOC']+'</td>';
                                                                                };
                                                                            div_encabezado += '</tr>'; 
                                                                            };
                                                                        div_encabezado += '</tbody>';
                                                                   div_encabezado += '</table>';
                                                                div_encabezado += '</td>';     
                                                                cont_materias = cont_materias+1;
                                                            };   //fin del if para bandera_materia
                                                            
                                                        div_encabezado += '</tr>';  
                                                        };                          //fin del for de j
                                                    div_encabezado += '</tbody>';
                                                div_encabezado += '</table>';
                                                };                                  //fin de if donde comparo semestre con aux
                                            };                                      //fin del primer for con i
                                           div_encabezado += '</div>'; //fin del div con class=panel-body
                                        div_encabezado += '</div>'; //fin del div con id=borTbl
                                    div_encabezado += '</div>'; //fin del div de class=col-md-10
                                    div_encabezado += '<div class=\"col-md-1\">';
                                    div_encabezado += '</div>';
                                    }; //fin de for
                                    }; //fin de if
                                    $('#listado').html(div_encabezado); "
                                    . '});' //function
                                ]);
                                //fin la carrera
                                ?> 
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-sm-2">     
                <a href="<?= Yii::$app->homeUrl ?>asig-doc-per/listar_pdf" target="_blank">
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

