<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\PeriodoAcademico;
use app\models\Docente;

$this->title = 'Reporte de asignación de docentes';
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
<!--para gráficos-->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<!--para gráficos-->

<div class="asig-doc-per-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?> 
    <div class="row">   
        <Center> <h4> <b>REPORTE DE ASIGNACIÓN DE DOCENTES </b> </h4>
            <h4> <b> A LAS ASIGNATURAS </b> </h4>   
        </Center> <br>
        <div class="col-sm-12"> 
            <div class="col-sm-1">  </div>
            <div class="col-sm-5"> 
                <div class="panel panel-default" id="borTbl" >
                    <div class="panel-heading" id="subtitl" > <Center> <b>Período académico </b></Center></div>
                    <div class="panel-body">             
                        <?php
                        //inicio el período académico
                        $per = ArrayHelper::map(PeriodoAcademico::find()->andFilterCompare('ESTADO_PER', '3', '!=')->orderBy('FIN_PER desc')->all(), 'ID_PER', function ($model) {
                                    return $model['INICIO_PER'] . ' hasta ' . $model['FIN_PER'];
                                });
                        echo $form->field($model, 'ID_PER')->dropDownList($per, [
                            'prompt' => 'Seleccionar...',
                            'onChange' => '$.post("' . Yii::$app->urlManager->createUrl('asig-doc-per/buscar_docentes_periodo?id=') . '"+$(this).val(), '
                            . ' function( data ) '
                            . ' {'
                            . ' obj = JSON.parse(data); '
                            . ' var n = obj[0][0];'
                            . " 
                                var i;
                                var tabla = '';
                                var aux_docente = 'vacio';
                                var aux = 'vacio';
                                var cont=1;
                                for (i = 1; i <= n; i++) { 
                                 if (obj[1]['Periodo'] != aux ){ 
                                  tabla += '<h5><center> <b>INFORMACIÓN RELACIONADA A LA ASIGNACIÓN DE DOCENTES EN LAS ASIGNATURAS</b></center></h5>'; 
                                  tabla += '<h5><center> <strong>PERÍODO ACADÉMICO: </strong>'+obj[1]['Periodo']+' </center></h5>';
                                  tabla += '<div class=\"col-md-1\" ></div>';
                                  tabla += '<div class=\"col-md-10\" >';
                                  
                                  for (i = 1; i <= n; i++) { 
                                    if (obj[i]['Docente'] != aux_docente){                                  
                                    aux_docente = obj[i]['Docente'];                                    
                                    tabla += '<h4 class=\"text-info\"><strong>('+cont+') '+obj[i]['Docente']+' </strong></h4>';
                                    var aux_carrera = 'vacio';
                                    var cont_docente=1; 
                                    for (m = 1; m <= n; m++) { 
                                     if(obj[i]['Docente'] == obj[m]['Docente'] && obj[m]['Carrera'] != aux_carrera){
                                        aux_carrera = obj[m]['Carrera'];  
                                        tabla += '<table class=\"table table-bordered table-responsive\">'; 
                                        tabla += '<thead >'; 
                                            tabla += '<tr class=\"bg-info\" >';
                                            tabla += '<th style=\"text-align:right;\" colspan=\"5\"> CARRERA: '+obj[m]['Carrera']+'</th>';
                                            tabla += '</tr>';      
                                            tabla += '<tr >';
                                            tabla += '<th width=\"3%\">N°</th><th width=\"9%\">Nivel</th><th width=\"6%\">Paralelo</th><th>Asignatura</th><th width=\"15%\">Horas de clase</th>';
                                            tabla += '</tr>';
                                        tabla += '</thead>';
                                        
                                        tabla += '<tbody>';
                                        for (j = 1; j <= n; j++) { 
                                           if(obj[m]['Carrera'] == obj[j]['Carrera'] && obj[i]['Docente'] == obj[j]['Docente']){
                                                tabla += '<tr>';                                            
                                                tabla += '<td>'+cont_docente+'</td>';                                               
                                                tabla += '<td>'+obj[j]['Semestre']+'</td>';
                                                tabla += '<td style=\"text-align:center;\" >'+obj[j]['Paralelo']+'</td>';
                                                tabla += '<td>'+obj[j]['Asignatura']+'</td>';                                                                          
                                                tabla += '<td style=\"text-align:center;\" >'+obj[j]['Cantidad']+'</td>';                                                                          
                                                tabla += '</tr>';
                                                cont_docente = cont_docente+1;
                                            };
                                        };
                                        tabla += '</tbody>';                   
                                        tabla += '</table>';
                                     }; //fin de comparar if de aux_carrera
                                    };
                                    aux_carrera = 'vacio';
                                    cont = cont+1; //cantida de docentes
                                    }; //if para ir comparando el nombre de los docentes
                                  }; //for para recoger el docente
                                  tabla += '</div> ';
                                  tabla += '<div class=\"col-md-1\">';
                                  tabla += '</div>';
                                 };//fin de if para comparar a ver si existe algo
                                }; //fin del for para ver si existe algo que mostrar
                                $('#listado').html(tabla); "
                            . ' });'
                        ])->label('Escoja el período académico');
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-5"> 
                <div class="panel panel-default" id="borTbl" >
                    <div class="panel-heading" id="subtitl" > <Center> <b>Docente </b></Center></div>
                    <div class="panel-body">              
                        <?php
                        //consultar y asignar el nombre y apellido del docente a la variable $var1 
                        $var1 = ArrayHelper::map(Docente::find()->where(['ESTADO_DOC' => 1])->orderBy('APELLIDOS_DOC asc')->all(), 'CEDULA_DOC', function ($model) {
                                    return $model['APELLIDOS_DOC'] . ' ' . $model['NOMBRES_DOC'];
                                });
                        //fin consultar y asignar el nombre y apellido del docente a la variable $var1 
                        echo $form->field($model, 'CEDULA_DOC')->dropDownList($var1, [
                            'prompt' => 'Seleccionar...',
                            'onChange' => '$.post("' . Yii::$app->urlManager->createUrl('asig-doc-per/buscar_docentes_asignados?periodo=') . '"+$(\'#asigdocper-id_per\').val()+"&docente="+$(\'#asigdocper-cedula_doc\').val(), '
                            . ' function( data ) '
                            . '{'
                            . ' obj = JSON.parse(data); '
                            . ' var n = obj[0][0];'
                            . " 
                                var i;
                                var tabla = '';
                                var aux_docente = 'vacio';
                                var aux = 'vacio';
                                var cont=1;
                                for (i = 1; i <= n; i++) { 
                                 if (obj[1]['Docente'] != aux ){
                                    tabla += '<h5><center> <b>INFORMACIÓN RELACIONADA A LA ASIGNACIÓN DE</b></center></h5>';                                    
                                    tabla += '<h5><center> <strong>'+obj[1]['Docente']+' EN LAS ASIGNATURAS</strong></center></h5>';
                                    tabla += '<h5><center> <strong>PERÍODO ACADÉMICO: </strong>'+obj[1]['Periodo']+' </center></h5><br>';
                                    tabla += '<div class=\"col-md-1\" ></div>';
                                    tabla += '<div class=\"col-md-10\" >'; 
                                        
                                    var aux_carrera = 'vacio';
                                     for (i = 1; i <= n; i++) { 
                                       if(obj[i]['Carrera'] != aux_carrera){
                                        aux_carrera = obj[i]['Carrera'];
                                        tabla += '<table class=\"table table-bordered table-responsive\">'; 
                                        tabla += '<thead >'; 
                                            tabla += '<tr class=\"bg-info\" >';
                                            tabla += '<th style=\"text-align:right;\" colspan=\"5\"> CARRERA: '+obj[i]['Carrera']+'</th>';
                                            tabla += '</tr>';      
                                            tabla += '<tr >';                                                                                
                                            tabla += '<th width=\"3%\">N°</th><th width=\"9%\">Nivel</th><th width=\"6%\">Paralelo</th><th>Asignatura</th><th width=\"15%\">Horas de clase</th>';
                                            tabla += '</tr>';
                                        tabla += '</thead>';
                                        tabla += '<tbody>';
                                        var i;
                                            for (j = 1; j <= n; j++) {
                                               if(obj[i]['Carrera'] == obj[j]['Carrera']){
                                                tabla += '<tr>';
                                                tabla += '<td>'+j+'</td>';             
                                                tabla += '<td>'+obj[j]['Semestre']+'</td>';
                                                tabla += '<td style=\"text-align:center;\" >'+obj[j]['Paralelo']+'</td>';
                                                tabla += '<td>'+obj[j]['Asignatura']+'</td>';
                                                tabla += '<td style=\"text-align:center;\" >'+obj[j]['Cantidad']+'</td>';
                                                tabla += '</tr>';
                                              };
                                            };
                                        tabla += '</tbody>';                   
                                        tabla += '</table>';
                                      };//if de aux_carrera
                                    };
                                    aux_carrera = 'vacio';
                                    tabla += '</div> ';
                                    tabla += '<div class=\"col-md-1\">';
                                    tabla += '</div>';
                                  }; //fin de if comparando a ver si hay algo que mostrar
                                };   
                                $('#listado').html(tabla); "
                            . ' });'
                        ])->label('Escoja el docente');
                        ?>                                                       
                    </div>
                </div>
            </div> <!-- fin de column 6 -->
            <div class="col-sm-1"> 
                <!--botones para exportar-->
                <p>
                    <a href="<?= Yii::$app->homeUrl ?>asig-doc-per/rep_asig_doc_pdf" target="_blank">
                        <button type="button" class="btn btn-danger"> 
                            <img src="<?= Yii::$app->homeUrl ?>/imagenes/iconos/pdf.png" alt="Pdf"/> Pdf   
                        </button>
                    </a> 
                </p>
                <!--botones para exportar-->
            </div> 
        </div>
        <!--gráfico--> 
        <div id="container" style="min-width: 320px; max-width: 70%; margin: 1em auto; "></div><br>
        <!--gráfico--> 
        <!--div para mostrar el listado-->
        <div id="listado"> </div>
        <!--div para mostrar el listado-->
    </div> <!-- fin del row -->


    <!--código para gráfico de asignacion de aulas-->
    <?php $this->registerJs("
            $('#asigdocper-id_per').on('change',function(){
            $.ajax({
                type:'POST',
                url: '" . Yii::$app->urlManager->createUrl("asig-doc-per/grafico_reporte_docente") . "',
                data: {id: $('#asigdocper-id_per').val()},
                success: function (data){
                       obj = JSON.parse(data);                          
            //para gráfico
                var vector = new Array(); 
                var ini = 0;
                var fin = obj[0][0]; //posición 0 tiene el total en # de aulas
                var j;
                for (j =ini ; j<fin; j++) {
                   vector[j] = [obj[j+1]['Cantidad']+' '+obj[j+1]['Docente'], obj[j+1]['Cantidad']]; //almacena cantidad, nombre aula, porcentaje
                };
            //para gráfico
            //Radialize the colors
            Highcharts.setOptions({
              colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
                return {
                  radialGradient: {
                    cx: 0.5,
                    cy: 0.3,
                    r: 0.7
                  },
                  stops: [
                    [0, color],
                    [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
                  ]
                };
              })
            });

            // Build the chart
            Highcharts.chart('container', {
              chart: {
                backgroundColor: '#F2F5F9',
                plotBackgroundColor: null,
                plotBorderWidth: null,                
                plotShadow: false,
                type:'pie'
              },
              title: {
                text: '<b>Gráfico de la asignación de docentes</b>'                
              },
              tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
              },
              plotOptions: {
                pie: {
                  allowPointSelect: true,
                  cursor: 'pointer',
                  dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                      color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    },
                    connectorColor: 'silver'
                  }
                }
              },
              series: [{
                name: 'Porcentaje',
                data: vector
              }]
              }); //grafico Highcharts.setOption
              } //success         

            }); //ajax
            
            }); // on change 
            
            ");
    ?>
    <!--código para gráfico-->
    <?php ActiveForm::end(); ?>
</div>

