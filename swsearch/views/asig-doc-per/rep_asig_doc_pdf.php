<?php

use yii\helpers\Html;
use app\models\Estudiante;
?>
<!DOCTYPE html>

<html lang="es">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
    </head>
    <body>
        <!--mpdf
         <htmlpageheader name="myheader">
         <table width="100%"><tr>
         <td width="2px" rowspan="2">        
        </td>   
         </tr>
        </table>
         </htmlpageheader>
        <htmlpagefooter name="myfooter">
         <div style="border-top: 1px solid #000000; font-size: 9pt; text-align: left; padding-top: 3mm; ">       
        <b>Fuente: </b>
        Sistema-SwSearch
        &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
        Página {PAGENO} de {nb}
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
        <b>Impreso el </b>
        <?= date('Y-m-d H:i:s') ?>         
         </div>     
         </htmlpagefooter>         
         <sethtmlpageheader name="myheader" value="on" show-this-page="1" />
         <sethtmlpagefooter name="myfooter" value="on" />
         mpdf-->

        <?= Html::img(Yii::$app->homeUrl . '/imagenes/encabezado.png', ['widtd' => '100%', 'class' => '',]) ?>
        <br><br><br>
        <?php
        $this->title = 'REPORTE DE ASIGNACIÓN DE DOCENTES A LAS ASIGNATURAS';
        ?>
        <br>
        <table width="100%">
            <tr>
                <td width="10px" rowspan="2">
                <center>
                <h2>FACULTAD DE INFORMÁTICA Y ELECTRÓNICA</h2>
                <h2>ESCUELA DE INGENIERÍA EN SISTEMAS</h2>       
                <br>
                <h3><?= $this->title; ?></h3><br><br>
                <br>
                </center> 
                </td>   
            </tr>
        </table>

<div class="row">
    
    <!-------------------------------------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------------------------------------->
    <!--para documento pdf cuando hay periodo y aula-->
    <?php 
    if (isset($m_periodo->INICIO_PER) && isset($m_docente->NOMBRES_DOC)) {
    ?> 
    <!--en caso de que se haya escogido solo periodo mostrar ese encabezado-->    
    <h4 style="text-align:center;">
        <?php
            echo "<br>". 'INFORMACIÓN RELACIONADA A LA ASIGNACIÓN DE';
            echo "<br>";
            echo $m_docente->NOMBRES_DOC . ' '.$m_docente->APELLIDOS_DOC .' EN LAS ASIGNATURAS';
            echo "<br>";
            echo 'Período académico: '.$m_periodo->INICIO_PER . ' hasta ' . $m_periodo->FIN_PER;
        ?>     
    </h4>
    
    <div class="col-md-12">
            <?php 
                $aux_carrera = 'vacio';
                $contador =1;                    
                foreach ($reporte_docente as $hm) {
                    if ($hm['ID_CAR'] != $aux_carrera) {
                    $aux_carrera = $hm['ID_CAR'];         
            ?>
                    <table border="1" cellpadding="0" cellspacing="0" >                                       
                        <thead>
                            <tr bgcolor='#d9edf7'>
                                <th height="30" style="text-align:right;" colspan="5"><?= 'CARRERA: '.$hm['ID_CAR'] ?></th>
                            </tr>    
                            <tr  style="text-align:center;">
                                <th height="30" width="4%">N°</th>
                                <th height="30" width="11%">Nivel</th>
                                <th height="30" width="10%">Paralelo</th>                                
                                <th height="30" width="70%">Asignatura</th>
                                <th height="30" width="20%">Horas de clase</th>                                           
                            </tr>
                        </thead>
                        <tbody >
                            <?php
                                foreach ($reporte_docente as $hj) {
                                if ($hm['ID_CAR'] == $hj['ID_CAR']) {                                    
                                     echo "<tr>";                                     
                                        echo "<td style='text-align:center;'>" . $contador++ . "</td>";
                                        echo "<td>" . $hj['ID_SEM'] . "</td>";                                       
                                        echo "<td style='text-align:center;'>" . $hj['PARALELO'] . "</td>";
                                        echo "<td>" . $hj['CODIGO_ASIG'] . "</td>";
                                        echo "<td style='text-align:center;' >" . $hj['ID_AUL'] . "</td>"; //cantidad de horas de clase
                                     echo "</tr>";
                                    } //fin de if de para mostar tabla
                                }   
                            ?> 
                        </tbody>                   
                    </table>  <br>      
            <?php 
                    } //fin de if donde se comparara la carrera aux_carrera
                }        
            ?>        
    </div>   
    <?php
    }else{ if (isset($m_periodo->INICIO_PER)) {
    ?> 
    <!-------------------------------------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------------------------------------->
    <!--para documento pdf cuando solo ha escogido periodo -->
    <h4 style="text-align:center;">
        <?php
            echo "<br>". 'INFORMACIÓN RELACIONADA A LA ASIGNACIÓN DE DOCENTES EN LAS ASIGNATURAS';
            echo "<br>";
            echo 'Período académico: '.$m_periodo->INICIO_PER . ' hasta ' . $m_periodo->FIN_PER;
        ?>    
    </h4>
    <div class="col-md-12">
         <?php
        $aux_docente = 'vacio';
        $cont=1;              
        foreach ($reporte_docente as $hi) {
            if ($hi['CEDULA_DOC'] != $aux_docente) {
                $aux_docente = $hi['CEDULA_DOC'];   
        ?>
         <h4 color="#31708f"><strong><?= '('.$cont.') '.$hi['CEDULA_DOC'] ?> </strong></h4>
            <?php 
                $aux_carrera = 'vacio';
                $cont_docente=1;                    
                foreach ($reporte_docente as $hm) {
                    if ($hi['CEDULA_DOC'] == $hm['CEDULA_DOC'] && $hm['ID_CAR'] != $aux_carrera) {
                    $aux_carrera = $hm['ID_CAR'];         
            ?>
                    <table border="1" cellpadding="0" cellspacing="0" >                                       
                        <thead>
                            <tr bgcolor='#d9edf7'>
                                <th height="30" style="text-align:right;" colspan="5"><?= 'CARRERA: '.$hm['ID_CAR'] ?></th>
                            </tr>    
                            <tr  style="text-align:center;">
                                <th height="30" width="4%">N°</th>
                                <th height="30" width="11%">Nivel</th>
                                <th height="30" width="10%">Paralelo</th>                                
                                <th height="30" width="70%">Asignatura</th>
                                <th height="30" width="20%">Horas de clase</th>                                           
                            </tr>
                        </thead>
                        <tbody >
                            <?php
                                foreach ($reporte_docente as $hj) {
                                if ($hm['ID_CAR'] == $hj['ID_CAR'] && $hi['CEDULA_DOC'] == $hj['CEDULA_DOC']) {                                    
                                     echo "<tr>";                                     
                                        echo "<td style='text-align:center;'>" . $cont_docente . "</td>";
                                        echo "<td>" . $hj['ID_SEM'] . "</td>";                                       
                                        echo "<td style='text-align:center;'>" . $hj['PARALELO'] . "</td>";
                                        echo "<td>" . $hj['CODIGO_ASIG'] . "</td>";
                                        echo "<td style='text-align:center;' >" . $hj['ID_AUL'] . "</td>"; //cantidad de horas de clase
                                     echo "</tr>";
                                    $cont_docente = $cont_docente+1;
                                    } //fin de if de para mostar tabla
                                }   
                            ?> 
                        </tbody>                   
                    </table>  <br>      
            <?php 
                    } //fin de if donde se comparara la carrera aux_carrera
                }        
            ?>        
        <?php 
             //$aux_carrera = 'vacio';
             $cont = $cont+1; //cantidad de docentes
            } //cierre de if donde se compara aux_docente
        }        
        ?>
    </div> 
     <?php
    }}
    ?>
</div>
</body>
</html>  