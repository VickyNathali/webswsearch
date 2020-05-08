<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\AulaLaboratorio;
use app\models\PeriodoAcademico;

$this->title = 'Reporte de asignación de aulas';
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

<div class="dia-aula-hora-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?> 
    <div class="row">
        <Center> <h4> <b>REPORTE DEL USO DE AULAS Y LABORATORIOS </b> </h4>   
        </Center> <br> 
        <div class="col-sm-12"> 
        <div class="col-sm-1"> </div>   
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
                        'prompt' =>
                        'Seleccionar...',
                        'onChange' => '$.post("' . Yii::$app->urlManager->createUrl('dia-aula-hora/buscar_aulas_periodo?id=') . '"+$(this).val(), '
                        . ' function( data ) '
                        . ' {'
                        . ' obj = JSON.parse(data); '
                        . ' var n = obj[0][0];'
                        . " 
                            var i;
                            var div_encabezado='';                            
                            var aux_aula = 'vacio';
                            var aux = 'vacio';
                            var cont=1;
                            for (i = 1; i <= n; i++) { 
                            if (obj[1]['Periodo'] != aux ){          
                            div_encabezado += '<h5><center> <b>INFORMACIÓN RELACIONADA AL USO DE LAS AULAS Y LABORATORIOS</b></center></h5>'; 
                            div_encabezado += '<h5><center> <strong>PERÍODO ACADÉMICO: </strong>'+obj[1]['Periodo']+' </center></h5>';
                            div_encabezado += '<div class=\"col-md-12\" >';
                            for (i = 1; i <= n; i++) { 
                                if (obj[i]['Aula'] != aux_aula ){                                  
                                aux_aula = obj[i]['Aula'];
                                
                                div_encabezado += '<h4 class=\"text-info\"><strong> ('+cont+') '+obj[i]['Aula']+' </strong></h4>';
                                var aux_carrera = 'vacio';
                                var cont_aula=1; 
                                for (m = 1; m <= n; m++) { 
                                   if(obj[i]['Aula'] == obj[m]['Aula'] && obj[m]['Carrera'] != aux_carrera){
                                        aux_carrera = obj[m]['Carrera'];                                        
                                        div_encabezado += '<table class=\"table table-bordered table-responsive\" >';                                        
                                        div_encabezado += '<thead >'; 
                                            div_encabezado += '<tr class=\"bg-info\" >';
                                            div_encabezado += '<th style=\"text-align:right;\" colspan=\"7\"> CARRERA: '+obj[m]['Carrera']+'</th>';
                                            div_encabezado += '</tr>';      
                                            div_encabezado += '<tr >';
                                            div_encabezado += '<th width=\"3%\">N°</th><th width=\"13%\">Hora</th><th width=\"9%\">Día</th><th width=\"9%\">Nivel</th><th width=\"6%\">Paralelo</th><th width=\"23%\">Docente</th><th>Asignatura</th>';
                                            div_encabezado += '</tr>';
                                        div_encabezado += '</thead>';
                                        
                                        div_encabezado += '<tbody class=\"table-striped\">';
                                        for (j = 1; j <= n; j++) { 
                                           if(obj[m]['Carrera'] == obj[j]['Carrera'] && obj[i]['Aula'] == obj[j]['Aula']){
                                                div_encabezado += '<tr>';                                            
                                                div_encabezado += '<td>'+cont_aula+'</td>';
                                                div_encabezado += '<td>'+obj[j]['Hora']+'</td>';
                                                div_encabezado += '<td>'+obj[j]['Dia']+'</td>';
                                                div_encabezado += '<td>'+obj[j]['Semestre']+'</td>';
                                                div_encabezado += '<td style=\"text-align:center;\" >'+obj[j]['Paralelo']+'</td>';
                                                div_encabezado += '<td>'+obj[j]['Docente']+'</td>';
                                                div_encabezado += '<td>'+obj[j]['Asignatura']+'</td>';                                                                                     
                                                div_encabezado += '</tr>';
                                                 cont_aula = cont_aula+1;
                                            };
                                        };
                                        div_encabezado += '</tbody>';                   
                                        div_encabezado += '</table>';
                                    };//fin de aux carrera
                                  };
                                  //aux_carrera = 'vacio';
                                  cont = cont+1; //cantida de aulas
                                }; //if para ir comparando el nombre de las aulas
                              }; //for para recoger el aula
                             div_encabezado += '</div>';
                             }; //fin de if para ver si hay algo que mostrar
                            };
                            $('#listado').html(div_encabezado); "
                        . ' });'
                    ])->label('Escoja el período académico');
                    ?>
                </div>
            </div>
        </div>
        <div class="col-sm-5"> 
            <div class="panel panel-default" id="borTbl" >
                <div class="panel-heading" id="subtitl" > <Center> <b>Aula o Laboratorio </b></Center></div>
                <div class="panel-body">              
                    <?php
                    //asignar el nombre de las aulas y laboratorios a la variable $var1                     
                    $var1 = ArrayHelper::map(AulaLaboratorio::find()->where(['ESTADO_AUL' => 1])->orderBy('NOMBRE_AUL asc')->all(), 'ID_AUL', function ($model) {
                                return $model['NOMBRE_AUL'];
                            });
                    //asignar el nombre de las aulas y laboratorios a la variable $var1 
                    echo $form->field($model, 'ID_AUL')->dropDownList($var1, [
                        'prompt' => 'Seleccionar...',
                        'onChange' => '$.post("' . Yii::$app->urlManager->createUrl('dia-aula-hora/buscar_aulas_asignadas?periodo=') . '"+$(\'#diaaulahora-id_per\').val()+"&aula="+$(\'#diaaulahora-id_aul\').val(), '
                        . ' function( data ) '
                        . ' {'
                        . ' obj = JSON.parse(data); '
                        . ' var n = obj[0][0];'
                        . "                                                             
                            var i;
                                var div_encabezado='';                               
                                var aux_dia = 'vacio';
                                var aux = 'vacio';
                                for (i = 1; i <= n; i++) { 
                                if (obj[1]['Aula'] != aux ){          
                                div_encabezado += '<h5><center> <b>INFORMACIÓN RELACIONADA AL USO DEL </b></center></h5>';
                                div_encabezado += '<center><strong>'+obj[1]['Aula']+'</strong></center>';                                    
                                div_encabezado += '<h5><center> <strong>PERÍODO ACADÉMICO: </strong>'+obj[1]['Periodo']+' </center></h5>';
                                div_encabezado += '<div class=\"col-md-12\" >';
                                for (i = 1; i <= n; i++) { 
                                    if (obj[i]['Dia'] != aux_dia ){                                  
                                    aux_dia = obj[i]['Dia'];

                                    div_encabezado += '<h4 class=\"text-info\" ><strong>'+obj[i]['Dia']+' </strong></h4>';
                                    var aux_carrera = 'vacio';
                                     for (m = 1; m <= n; m++) { 
                                       if(obj[i]['Dia'] == obj[m]['Dia'] && obj[m]['Carrera'] != aux_carrera){
                                            aux_carrera = obj[m]['Carrera'];                                        
                                            div_encabezado += '<table class=\"table table-bordered table-responsive\" >';                                        
                                            div_encabezado += '<thead >'; 
                                                div_encabezado += '<tr class=\"bg-info\" >';
                                                div_encabezado += '<th style=\"text-align:right;\" colspan=\"6\"> CARRERA: '+obj[m]['Carrera']+'</th>';
                                                div_encabezado += '</tr>';      
                                                div_encabezado += '<tr>';
                                                div_encabezado += '<th width=\"3%\">N°</th><th width=\"13%\">Hora</th><th width=\"9%\">Nivel</th><th width=\"6%\">Paralelo</th><th width=\"23%\">Docente</th><th>Asignatura</th>';                                            
                                                div_encabezado += '</tr>';
                                            div_encabezado += '</thead>';
                                            div_encabezado += '<tbody class=\"table-striped\">';
                                            for (j = 1; j <= n; j++) { 
                                               if(obj[m]['Carrera'] == obj[j]['Carrera'] && obj[i]['Dia'] == obj[j]['Dia']){
                                                    div_encabezado += '<tr>';                                            
                                                    div_encabezado += '<td>'+j+'</td>';
                                                    div_encabezado += '<td>'+obj[j]['Hora']+'</td>';
                                                    div_encabezado += '<td>'+obj[j]['Semestre']+'</td>';
                                                    div_encabezado += '<td style=\"text-align:center;\" >'+obj[j]['Paralelo']+'</td>';
                                                    div_encabezado += '<td>'+obj[j]['Docente']+'</td>';
                                                    div_encabezado += '<td>'+obj[j]['Asignatura']+'</td>';                                                                                     
                                                    div_encabezado += '</tr>';
                                                };
                                            };
                                            div_encabezado += '</tbody>';                   
                                            div_encabezado += '</table>';
                                        };
                                      };
                                      aux_carrera = 'vacio';
                                    }; //if para ir los dias de la semana
                                  }; //for para recorrer los dias
                                 div_encabezado += '</div>';
                                 }; //fin de if para ver si hay algo que mostrar
                                };
                                $('#listado').html(div_encabezado); "
                        . ' });'
                    ])->label('Escoja el aula o laboratorio');
                    ?>                                                       
                </div>
            </div>
        </div> <!-- fin de column 6 -->            
        <div class="col-sm-1"> 
            <!--boton para exportar-->
            <p>
                <a href="<?= Yii::$app->homeUrl ?>dia-aula-hora/rep_asig_aulas_pdf" target="_blank">
                    <button type="button" class="btn btn-danger"> 
                        <img src="<?= Yii::$app->homeUrl ?>/imagenes/iconos/pdf.png" alt="Pdf"/> Pdf   
                    </button>
                </a> 
            </p>
            <!--boton para exportar-->
        </div>  
        <!--gráfico--> 
        </div>
        <div id="container" style="min-width: 320px; max-width: 70%; margin: 1em auto; "></div><br>
        <!--gráfico-->     
        <!--div para mostrar el listado de la tabla-->
        <div id="listado"></div>
        <!--div para mostrar el listado-->
    </div> <!-- fin del row -->

    <!--código para gráfico de asignacion de aulas-->
    <?php $this->registerJs("
            $('#diaaulahora-id_per').on('change',function(){
            $.ajax({
                type:'POST',
                url: '" . Yii::$app->urlManager->createUrl("dia-aula-hora/grafico_reporte_aula") . "',
                data: {id: $('#diaaulahora-id_per').val()},
                success: function (data){
                       obj = JSON.parse(data);
            //para gráfico
                var vector = new Array(); 
                var ini = 0;
                var fin = obj[0][0]; //posición 0 tiene el total en # de aulas
                var j;
                for (j =ini ; j<fin; j++) {
                   vector[j] = [obj[j+1]['Cantidad']+' '+obj[j+1]['Aula'], obj[j+1]['Cantidad']]; //almacena cantidad, nombre aula, porcentaje
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
                            [1, Highcharts.color(color).brighten(-0.5).get('rgb')] // darken
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
                text: '<b>Gráfico del uso de aulas y laboratorios</b>'                
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

