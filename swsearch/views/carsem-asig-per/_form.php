<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Asignatura;
use app\models\Carrera;
use app\models\CarreraSemestre;
use app\models\Semestre;
use app\models\PeriodoAcademico;
use yii\helpers\ArrayHelper;
use pcrt\widgets\select2\Select2; //libreria para busqueda avanzada  mediante escritura
//use kartik\select2\Select2; //libreria para busqueda avanzada  mediante escritura
use yii\helpers\Url;
use yii\bootstrap\Modal;
use app\models\AsigDocPer;
use yii\grid\GridView;
use app\models\DiaAulaHora;

/* @var $this yii\web\View */
/* @var $model app\models\CarsemAsigPer */
/* @var $form yii\widgets\ActiveForm */

if ($band == 1) {
    $session = Yii::$app->session;
    $car = $session['id_carrera']; //carrera
    $sem = $session['id_semestre']; //semestre
    $per = $session['id_periodo']; //periodo
}
?>
<style> 
    /*botones de modificar dia-aula-hora*/
    #botones{
        float: right;
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
    /*     #tblAsignatura{
            width="80%" 
            width: 99%;*/

</style>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.1.1.min.js"></script>
<div class="carsem-asig-per-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?> 

    <div class="row">
        <div class="col-md-1"> </div>
        <!--------------------------------------------------------------------------------------------------------------------->
        <!--------------------------------------------------------------------------------------------------------------------->
        <div class="col-md-10 panel panel-footer" id="cuadroDI">
            <div class="panel-heading" align="center" id="subtitl">
                <center> <b>HORARIO DE CLASES</b></center>
            </div>
            <div class="panel-body">
                <table class="table-bordered table-condensed table-hover " >
                    <tr class=" badge-info"> 
                        <td width="25%" class="text-justify">
                            <?php
                            //inicio el período académico
                            $var1 = ArrayHelper::map(PeriodoAcademico::find()->where(['ESTADO_PER' => 1])->all(), 'ID_PER', function ($model) {
                                        return $model['INICIO_PER'] . ' hasta ' . $model['FIN_PER'];
                                    });
                            echo $form->field($model, 'ID_PER')->dropDownList($var1, [
                                'prompt' => 'Seleccionar ...',
                                'onClick' => '$.post("' . Yii::$app->urlManager->createUrl('carsem-asig-per/guardar_periodo?id=') . '"+$(this).val(), function( data ) {});'
                            ]);
                            //fin período académico
                            ?>
                        </td>
                        <td width="25%" class="text-justify">
                            <?php
                            //para la carrera
                            $var1 = ArrayHelper::map(Carrera::find()->where(['ESTADO_CAR' => 1])->orderBy('NOMBRE_CAR asc')->all(), 'ID_CAR', 'NOMBRE_CAR');
                            echo $form->field($model, 'ID_CAR')->dropDownList($var1, [
                                'prompt' => 'Seleccionar ...',
                                'onClick' => '$.post("' . Yii::$app->urlManager->createUrl('carrera-semestre/listar_sem_carrera?id=') . '"+$(this).val(), function( data ) {$("select#carsemasigper-id_sem").html(data);});'
                            ]);
                            //fin la carrera
                            ?> 
                        </td>
                        <td width="20%" class="text-justify">
                            <div id="escoger_nivel">
                                <?php
                                //para la semestre
                                $var1 = ArrayHelper::map(CarreraSemestre::find()->where(['ID_CAR' => $model->ID_CAR, 'ESTADO_CARSEM' => 1])->all(), 'ID_SEM', 'sEM.DESCRIPCION_SEM');
                                echo $form->field($model, 'ID_SEM')->dropDownList($var1, ['prompt' => 'Seleccionar ...',
                                    'onClick' => '$.post("' . Yii::$app->urlManager->createUrl('carsem-asig-per/guardar_semestre?id=') . '"+$(this).val(), function( data ) {});'
                                ]);
                                //fin la semestre
                                ?>   
                            </div>
                        </td>
                        <td class="text-justify">
                            <div id="ingresar_asignatura">
                                <?php
                                //para mostrar las asignaturas q no esten asignadas a ningun nivel en el periodo escogido  
                                if (isset($per) && ($per > 0)) {
                                    $asig_exist = "SELECT
                                        *
                                        FROM `asignatura`
                                        WHERE CODIGO_ASIG NOT IN (SELECT c.CODIGO_ASIG FROM asignatura AS a 
                                        INNER JOIN `carsem_asig_per` AS c 
                                        ON a.CODIGO_ASIG = c.CODIGO_ASIG 
                                        WHERE c.ID_PER = '" . $per . "') AND ESTADO_ASIG=1 ";
                                    $var1 = ArrayHelper::map(Asignatura::findBySql($asig_exist)->orderBy('NOMBRE_ASIG asc')->all(), 'CODIGO_ASIG', 'NOMBRE_ASIG');
                                    echo $form->field($model, 'CODIGO_ASIG')
                                            ->widget(Select2::classname(), [
                                                'items' => $var1,
                                                'options' => ['placeholder' => 'Seleccionar ...'
                                                // 'onClick' => '$.post("' . Yii::$app->urlManager->createUrl('carsem-asig-per/guardar_asignatura?id=') . '"+$(this).val(), function( data ) {});'
                                                ],
                                    ]);
                                }
                                //fin la asignatura
                                ?>  
                            </div>
                        </td>
                    </tr>
                    <!--   botones de actualizar pagina (para buscar las asignaturas asignadas al nivel escogido) y agregar asignatura-->
                    <p class="text-right">
                        <?= Html::a('<span class="glyphicon glyphicon-search"></span>', ['create'], ['id' => 'btnBuscar', 'title' => 'Buscar horarios', 'class' => 'btn btn-info']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-plus"></span>', ['id' => 'btnAgregar', 'class' => 'btn btn-success', 'title' => 'Agregar']) ?>
                    </p>  
                </table>
                <br>    
            </div> <!--fin de panel body-->  
        </div> <!--fin de col-md-10-->
        <!--------------------------------------------------------------------------------------------------------------------->
        <!--------------------------------------------------------------------------------------------------------------------->
        <div class="col-md-1"> </div>
    </div> 

    <!--------------------------------------------------------------------------------------------------------------------->
    <!--hide y show de botones principales del formulario-->
    <?php
    if (isset($sem) && $sem > 0) {
        $this->registerJs("                                          
        $(document).ready(function () {
        $('#btnAgregar').hide();
        $('#btnBuscar').hide();                   
        $('#horarios').show();
        });
        
        $('#ingresar_asignatura').on('change',function(){
        $('#btnAgregar').show(); });
        $('#escoger_nivel').on('click',function(){
        $('#btnBuscar').show(); });

    ");
    } else {
        $this->registerJs("                                          
        $(document).ready(function () {
        $('#btnBuscar').hide();
        $('#ingresar_asignatura').hide();
        $('#btnAgregar').hide();        
        $('#horarios').hide();                
                            
        //muestra el boton buscar para ver si hay materias en ese periodo, carrera y nivel
        $('#escoger_nivel').on('click',function(){
        $('#btnBuscar').show(); });
        }); 
    ");
    }
    ?>

    <!--------------------------------------------------------------------------------------------------------------------->
    <!--cambiar de color al seleccionar una celda de la tabla tblAsignatura-->
    <script language="javascript" type="text/javascript">
        var ultimaFila = null;
        var colorOriginal;
        $(Inicializar);
        function Inicializar() {
            $('#tblAsignatura tr').click(function () {
                if (ultimaFila != null) {
                    ultimaFila.css('background-color', colorOriginal)
                }
                colorOriginal = $(this).css('background-color');
                $(this).css('background-color', '#daffd3');
                ultimaFila = $(this);
            });
        }
    </script>

    <script language="javascript" type="text/javascript">
        var ultima = null;
        var color;
        $(Inicializa);
        function Inicializa() {
            $('#tblDocente td').click(function () {
                if (ultima != null) {
                    ultima.css('background-color', colorl)
                }
                colorl = $(this).css('background-color');
                $(this).css('background-color', '#ccfbc4');
                ultima = $(this);
            });
        }
    </script>
    <div class="row" id="horarios">
        <div class="col-md-12" >            
            <div class="col-md-6">                
                <?php
                if (isset($sem) && $sem > 0) {
                    $m_car = Carrera::find()->where(['ID_CAR' => $car])->one();
                    echo "<b>CARRERA: </b>" . $m_car->NOMBRE_CAR;
                    echo "<br>";
                    $m_sem = Semestre::find()->where(['ID_SEM' => $sem])->one();
                    echo "<b>NIVEL: </b>" . $m_sem->DESCRIPCION_SEM;
                    echo "<br>";
                    $m_per = PeriodoAcademico::find()->where(['ID_PER' => $per])->one();
                    echo "<b>PERÍODO ACADÉMICO: </b>" . $m_per->INICIO_PER . ' hasta ' . $m_per->FIN_PER . "</b>";
                    echo "<br>";
                    echo "<br>";
                }
                ?>  
            </div>
            <!--<div class="col-md-1"> </div>-->
            <div class="col-md-6">
                <p style="text-align:right;">
                    Descargar horario:
                    <a href="<?= Yii::$app->homeUrl ?>carsem-asig-per/descargar_horario_pdf" target="_blank">
                        <button type="button" class="btn btn-danger"> 
                            <img src="<?= Yii::$app->homeUrl ?>/imagenes/iconos/pdf.png" alt="Pdf"/> Pdf   
                        </button>
                    </a>
                </p> 
            </div>
        </div> 
        <?php
        if (isset($sql_validar->INICIO_PER)) {
            ?>
            <div class="col-md-12" >
                <table id="tblAsignatura" align="center" class="table table-bordered table-responsive" >
                    <thead bgcolor="#c2ccd1">
                    <th width="3%"><center>N°</center></th>
                    <th width="7%"><center>CÓDIGO</center></th>
                    <th style="text-align:right;">ASIGNATURAS</th>
                    </thead>
                    <tbody>
                        <?php
                        $var = 1;
                        $mensaje = "Agregue asignaturas";
                        foreach ($sql as $s) {
                            if (isset($s->CODIGO_ASIG)) {
                                echo "<tr>";
                                echo "<td>" . $var++ . "</td>";
                                echo "<td>" . $s->CODIGO_ASIG;
                                ?> 
                            <center>
                                <!----------------------------------------------------------->
                                <!--Botones de agregar docente y eliminar asignatura-->
                                <?=
                                Html::button('<span  class="fa fa-user-plus"></span>', ['value' => Url::to(['agregar', 'asig' => $s->CODIGO_ASIG]), 'class' => 'modalButton', 'id' => 'add_docente',
                                    'title' => 'Agregar docente-paralelo', 'style' => 'color:black; border: none; border-color: transparent; background-color: transparent'])
                                ?>                     
                                <?=
                                Html::a('', ['delete1', 'ID_CAR' => $model->ID_CAR, 'ID_SEM' => $model->ID_SEM, 'CODIGO_ASIG' => $s->CODIGO_ASIG, 'ID_PER' => $model->ID_PER], [
                                    'title' => 'Eliminar asignatura',
                                    'class' => 'glyphicon glyphicon-trash',
                                    'style' => 'color:red',
                                    'data' => [
                                        'confirm' => '¿Está seguro que desea eliminar? ' . $s->NOMBRE_ASIG . ' de ' . $model->sEM->sEM->DESCRIPCION_SEM . ' de ' . $model->sEM->cAR->NOMBRE_CAR,
                                        'method' => 'post',
                                    ],
                                ])
                                ?>
                                <!-- Fin agregar docente y eliminar asignatura-->
                                <!----------------------------------------------------------->
                            </center>
                            <?php
                            echo "</td>"; //terminar columna td de mostrar codigo de asignatura
                            echo "<td>";
                            echo "<center><font color='#31708f' size='3'><b>" . $s->NOMBRE_ASIG . "</b></font></center>";
//------------------------------------------------------------------------------------------------------------------- 
                            ?>
                            <table id='tblDocente' align="center" class="table table-bordered table-condensed table-responsive table-hover table-striped ">    <!--tabla de docente y paralelo-->                 
                                <?php
                                //  mostrar los docente y paralelos en los que se da la asignatura
                                $model_docente = AsigDocPer::findBySql("SELECT
                                  *
                                  FROM `asig_doc_per`
                                  WHERE CODIGO_ASIG = '" . $s->CODIGO_ASIG . "'
                                  AND ID_PER ='" . $per . "' AND ID_CAR ='" . $car . "' AND ID_SEM ='" . $sem . "'ORDER BY PARALELO")->all();
                                foreach ($model_docente as $docen) {
                                    echo "<td>";
                                    echo "<center>" . "<b>" . ' Paralelo: ' . "</b>";
                                    echo $docen->PARALELO . "</center>";
                                    echo $docen->cEDULADOC->NOMBRES_DOC . ' ' . $docen->cEDULADOC->APELLIDOS_DOC;
                                    ?> 
                                    <!------------------------------------------------------------------------->
                                    <!--botones del docente y paralelo (modificar,agregar aula, eliminar docente-->
                                    <?=
                                    Html::button('<span class="fa fa-edit"></span>', ['value' => Url::to(['modificar', 'asig' => $docen->CODIGO_ASIG, 'doc' => $docen->CEDULA_DOC, 'par' => $docen->PARALELO]), 'class' => 'modalButtonM', 'id' => 'edit_docente',
                                        'title' => 'Modificar docente-paralelo', 'style' => 'color:black; border: none; border-color: transparent; background-color: transparent'])
                                    ?>
                                    <?=
                                    Html::button('<span class="fa fa-calendar-plus-o"></span>', ['value' => Url::to(['agregarh', 'asig' => $docen->CODIGO_ASIG, 'doc' => $docen->CEDULA_DOC, 'par' => $docen->PARALELO]), 'class' => 'modalButtonH', 'id' => 'add_aula',
                                        'title' => 'Agregar día-aula-hora', 'style' => 'color:black; border: none; border-color: transparent; background-color: transparent'])
                                    ?>
                                    <?=
                                    Html::a('', ['delete_doc', 'CODIGO_ASIG' => $docen->CODIGO_ASIG, 'ID_PER' => $docen->ID_PER,
                                        'CEDULA_DOC' => $docen->CEDULA_DOC, 'PARALELO' => $docen->PARALELO,
                                        'ID_CAR' => $docen->ID_CAR, 'ID_SEM' => $docen->ID_SEM], [
                                        'class' => 'fa fa-user-times',
                                        'style' => 'color:INDIANRED',
                                        'title' => 'Eliminar docente-paralelo',
                                        'data' => [
                                            'confirm' => '¿Está seguro que desea eliminar?' . $docen->cEDULADOC->APELLIDOS_DOC
                                            . ' que imparte ' . $docen->cAR->cODIGOASIG->NOMBRE_ASIG . ' en ' . $model->sEM->sEM->DESCRIPCION_SEM . ' de ' . $model->sEM->cAR->NOMBRE_CAR,
                                            'method' => 'post',
                                        ],
                                    ])
                                    ?>
                                    <!--botones del docente y paralelo-->
                                    <!------------------------------------------------------------------------->
                                    <?php
                                    echo "<br>" . "<br>"; //espacio despues de docente para mostrar hora.aula.dia 
//======================================aula, hora dìa=============================================================================
                                    $model_aula = DiaAulaHora::findBySql("SELECT
                                          *
                                          FROM `dia_aula_hora`
                                          WHERE CEDULA_DOC = '" . $docen->CEDULA_DOC . "'
                                          AND CODIGO_ASIG = '" . $docen->CODIGO_ASIG . "'
                                          AND PARALELO = '" . $docen->PARALELO . "'
                                          AND ID_PER =" . $docen->ID_PER . "  ORDER BY `ID_DIA`,ID_HORA ASC ")->all();

                                    foreach ($model_aula as $aula) {
                                        echo "<li >";
                                        echo $aula->dIA->DESCRIPCION_DIA;
                                        echo "<b>" . ' ' . $aula->aUL->NOMBRE_AUL . ' ' . "</b>";
                                        //echo $aula->hORA->INICIO_HORA . ' ' . $aula->hORA->FIN_HORA;
                                        $date = new DateTime($aula->hORA->INICIO_HORA);
                                        $date1 = new DateTime($aula->hORA->FIN_HORA);
                                        echo $date->format('H:i') . '-' . $date1->format('H:i');
                                        echo "<div class='col-md-3' id='botones' >";
                                        ?>
                                        <!------------------------------------------------------------------------->
                                        <!--botones del aula, dia, hora-->
                                        <?=
                                        Html::button('', ['value' => Url::to(['modificarh', 'hora' => $aula->ID_HORA, 'par' => $aula->PARALELO, 'asig' => $aula->CODIGO_ASIG, 'doc' => $aula->CEDULA_DOC, 'aula' => $aula->ID_AUL, 'dia' => $aula->ID_DIA]), 'class' => 'modalButtonMH fa fa-edit', 'id' => 'edit_aula',
                                            'title' => 'Modificar día-aula-hora', 'style' => 'color:black; border: none; border-color: transparent; background-color: transparent', 'id' => ''])
                                        ?>
                                        <?=
                                        Html::a('', ['delete_aula', 'CODIGO_ASIG' => $aula->CODIGO_ASIG, 'ID_PER' => $aula->ID_PER,
                                            'CEDULA_DOC' => $aula->CEDULA_DOC, 'ID_HORA' => $aula->ID_HORA, 'ID_DIA' => $aula->ID_DIA,
                                            'ID_AUL' => $aula->ID_AUL, 'PARALELO' => $aula->PARALELO, 'ID_CAR' => $aula->ID_CAR,
                                            'ID_SEM' => $aula->ID_SEM], [
                                            'class' => 'fa fa-calendar-times-o',
                                            'style' => 'color:salmon',
                                            'title' => 'Eliminar día-aula-hora',
                                            'data' => [
                                                'confirm' => '¿Está seguro que desea eliminar? ' . $aula->aUL->NOMBRE_AUL
                                                . ' de la asignatura ' . $aula->cODIGOASIG->cAR->cODIGOASIG->NOMBRE_ASIG . ' impartida por ' . $aula->cODIGOASIG->cEDULADOC->NOMBRES_DOC . ''
                                                . ' ' . $aula->cODIGOASIG->cEDULADOC->APELLIDOS_DOC . ' el día' . $aula->dIA->DESCRIPCION_DIA,
                                                'method' => 'post',
                                            ],
                                        ])
                                        ?>
                                        <!-- FIN de botones del aula, dia, hora-->
                                        <!------------------------------------------------------------------------->
                                        <?php
                                        echo "</div>";
                                        echo "</li>";
                                    } //fin de foreach aula
//====================================fin aula, hora dìa================================================================
                                    echo "</td>";
                                }
                                ?>
                                <!--                         fin mostrar los docente y paralelos en los que se da la asignatura-->
                                <!----------------------------------------------------------------------------------------------------------------------->
                            </table>                                            
                            <?php
                            echo "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>            
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <h4 style="text-align:center;">
                <?php
                echo "<b>" . 'NO HAY NINGUNA ASIGNATURA' . "</b>";
            }
            ?> 
        </h4>

    </div>

    <!--modal para agregar docente y paralelo-->
    <?php
    Modal::begin([
        'header' => '<h2 style="font-family:Trebuchet MS;">Agregar</h2>',
        'id' => 'modal',
        'size' => 'none',
        'options' => [
            'tabindex' => false // importante para Select2 
        ],
    ]);
    echo "<div id='modalContent'></div>";
    Modal::end();
    ?>  
    <!--modal para agregar docente y paralelo-->
    <!----------------------------------------------------------------------------->
    <!--modal para MODIFICAR docente y paralelo-->
    <?php
    Modal::begin([
        'header' => '<h2 style="font-family:Trebuchet MS;">Modificar</h2>',
        'id' => 'modalM',
        'size' => 'none',
        'options' => [
            'tabindex' => false // importante para Select2 
        ],
    ]);
    echo "<div id='modalContentM'></div>";
    Modal::end();
    ?> 
    <!--modal para MODIFICAR docente y paralelo-->
    <!----------------------------------------------------------------------------->
    <!--modal para AGREGAR aula, hora y dia-->
    <?php
    Modal::begin([
        'header' => '<h2 style="font-family:Trebuchet MS;">Agregar horas de clases</h2>',
        'id' => 'modalH',
        'size' => 'none',
        'options' => [
            'tabindex' => false // importante para Select2 
        ],
    ]);
    echo "<div id='modalContentH'></div>";
    Modal::end();
    ?> 
    <!--modal para AGREGAR aula, hora y dia-->
    <!----------------------------------------------------------------------------->
    <!--modal para MODIFICAR aula, hora y dia-->
    <?php
    Modal::begin([
        'header' => '<h2 style="font-family:Trebuchet MS;">Modificar horas de clases</h2>',
        'id' => 'modalMH',
        'size' => 'none',
        'options' => [
            'tabindex' => false // importante para Select2 
        ],
    ]);
    echo "<div id='modalContentMH'></div>";
    Modal::end();
    ?> 
    <!--modal para MODIFICAR aula, hora y dia-->

    <?php ActiveForm::end(); ?>

</div>
