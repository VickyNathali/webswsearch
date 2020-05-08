<?php

use yii\helpers\Html;
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
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
        <b>Impreso el </b>
        <?= date('Y-m-d H:i:s') ?>         
         </div>   
         </htmlpagefooter>
         
        <sethtmlpageheader name="myheader" value="on" show-this-page="1" />
         <sethtmlpagefooter name="myfooter" value="on" />
        
         mpdf-->
        <?= Html::img(Yii::$app->homeUrl . '/imagenes/encabezado.png', ['width' => '100%', 'class' => 'img - thumbnail',]) ?>
        <br>
        <br>
        <?php
        $this->title = 'LISTA DE ASIGNATURAS Y ASIGNACIÓN DE DOCENTES';
        ?>

<!--<table border='1' width="100%">            
    <tr bgcolor='#06DEF8'>
        -->
        <br>
        <table width="100%">
            <tr>
                <td width="10px" rowspan="2">
            <center>
                <h2>FACULTAD DE INFORMÁTICA Y ELECTRÓNICA</h2>
                <h2>ESCUELA DE INGENIERÍA EN SISTEMAS</h2>   
            </center>
        </td>   
    </tr>
</table>
<br>
<div class="row">    
    <h3 style="text-align:center;"><?= $this->title; ?></h3>
    <div class="col-md-12"> 
        <?php
        echo "<br>";
        echo "<b>Carrera: </b>".$m_carrera->NOMBRE_CAR; 
        echo "<br>";
        echo "<b>Período académico: </b>".$m_periodo->INICIO_PER . ' hasta ' . $m_periodo->FIN_PER;
        $aux_semestre = 'vacio';
        foreach ($listar_asigdoc as $sem) {
            if ($sem['ID_SEM'] != $aux_semestre) {
                $aux_semestre = $sem['ID_SEM'];                
                ?>
                <h4 style="text-align:center;"><?= $sem['ID_SEM']; ?> NIVEL</h4>               
                <table border="1" cellspacing="0" width="100%">
                    <thead style="text-align:center;" >
                        <tr bgcolor='#B8E5FB'>
                            <td width="4%"><b>N°</b></td>  
                            <td width="45%"><b>Asignatura</b></td>  
                            <td><b>Asignaciones</b></td> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $k;
                        $cont_materias = 1;
                        $bandera_materia = 0;
                        $lista_materias[] = array();
                        foreach ($listar_asigdoc as $mat) { //variable j
                            echo "<tr>";
                            //--------------------------------------------------   
                            foreach ($lista_materias as $lis){
                                if ($lis == $mat['CODIGO_ASIG'])
                                    $bandera = 1;
                            }                                                     
                            //--------------------------------------------------                         
                            if ($mat['ID_SEM'] == $sem['ID_SEM'] && $bandera_materia == 0) {
                                $lista_materias[$cont_materias-1] = $mat['CODIGO_ASIG'];
                                echo "<td style='text-align:center;'>" . $cont_materias . "</td>";
                                echo "<td>" . $mat['CODIGO_ASIG'] . "</td>";
                                echo "<td>";
                                ?>
                                <table border="1" cellspacing="0" width="100%">
                                    <thead style="text-align:center;" >
                                        <tr bgcolor='#cee9f6'>
                                            <td width="20%"><b>Paralelo</b></td>  
                                            <td><b>Docente</b></td>  
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($listar_asigdoc as $pardoc) { //variable j
                                            echo "<tr>";
                                            if ($mat['CODIGO_ASIG'] == $pardoc['CODIGO_ASIG']) {
                                                echo "<td style='text-align:center;'>" . $pardoc['PARALELO'] . "</td>";
                                                echo "<td>" . $pardoc['CEDULA_DOC'] . "</td>";
                                            }
                                            echo "</tr>";
                                        }
                                        ?>   
                                    </tbody>
                                </table>
                                <?php
                                echo "</td>"; //fin del td que contiene la segunda tabla
                                $cont_materias = $cont_materias + 1;
                            } //fin del if de bandera_materia  
                            echo "</tr>"; //fin de tr debajo del foreach $mat
                        } //fin de segundo foreach $mat
                    ?>
                    </tbody>            
                </table>
                <?php
            } //fin de if que compara semestre con auxiliar
        } //fin del primer foreach que recorre el semestre: $sem
        ?>     
    </div>

</div>
</body>
</html>  