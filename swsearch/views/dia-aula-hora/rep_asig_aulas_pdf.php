<?php
ini_set('memory_limit', '512M');
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
        $this->title = 'REPORTE DEL USO DE AULAS Y LABORATORIOS ';
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
    if (isset($m_periodo->INICIO_PER) && isset($m_aula->NOMBRE_AUL)) {
    ?> 
    <!--en caso de que se haya escogido solo periodo mostrar ese encabezado-->    
    <h4 style="text-align:center;">
        <?php
            echo "<br>". 'INFORMACIÓN RELACIONADA AL USO DEL';
            echo "<br>";
            echo $m_aula->NOMBRE_AUL;
            echo "<br>";
            echo 'Período académico: '.$m_periodo->INICIO_PER . ' hasta ' . $m_periodo->FIN_PER;
        ?>     
    </h4>
    <div class="col-md-12"> 
        <?php
        $aux_dia = 'vacio';            
        foreach ($rep_aulas as $hi) {
            if ($hi['ID_DIA'] != $aux_dia) {
                $aux_dia = $hi['ID_DIA'];       
        ?>
        <h4 color="#31708f"><strong><?= $hi['ID_DIA'] ?> </strong></h4>
                <?php 
                    $aux_carrera = 'vacio'; 
                    $contador = 1;
                    foreach ($rep_aulas as $hm) {
                        if ($hi['ID_DIA'] == $hm['ID_DIA'] && $hm['ID_CAR'] != $aux_carrera) {
                        $aux_carrera = $hm['ID_CAR'];         
                ?>
                        <table border="1" cellpadding="0" cellspacing="0" >                                       
                            <thead>
                                <tr bgcolor='#d9edf7'>
                                    <th height="30" style="text-align:right;" colspan="6"><?= 'CARRERA: '.$hm['ID_CAR'] ?></th>
                                </tr>    
                                <tr  style="text-align:center;">
                                    <th height="30" width="4%">N°</th>
                                    <th height="30" width="10%">Hora</th>
                                    <th height="30" width="10%">Nivel</th>
                                    <th height="30" width="9%">Paralelo</th>
                                    <th height="30" width="20%">Docente</th>
                                    <th height="30" width="60%">Asignatura</th>
                                </tr>
                            </thead>
                           <tbody >
                               <?php
                                foreach ($rep_aulas as $hj) {  
                                if ($hm['ID_CAR'] == $hj['ID_CAR'] && $hi['ID_DIA'] == $hj['ID_DIA']) {                                    
                                     echo "<tr>";                                     
                                        echo "<td style='text-align:center;'>" .$contador++. "</td>";
                                        echo "<td>" . $hj['ID_HORA'] . "</td>";
                                        echo "<td>" . $hj['ID_SEM'] . "</td>";                                       
                                        echo "<td style='text-align:center;'>" . $hj['PARALELO'] . "</td>";
                                        echo "<td>" . $hj['CEDULA_DOC'] . "</td>";
                                        echo "<td>" . $hj['CODIGO_ASIG'] . "</td>";
                                     echo "</tr>";
                                    } //fin de if de para mostar tabla
                                }   
                                ?> 
                            </tbody>                   
                        </table>  <br>          
                <?php
                        } //fin de if de aux_carrera
                    } 
                ?>
        <?php
                //$aux_carrera = 'vacio';
            } //fin de primer if condicionando $aux_aula
        } //fin de primer foreach hi
        ?>
    </div>
      <?php
    }else{ if (isset($m_periodo->INICIO_PER)) {
    ?> 
    <!----------------------------------------------------------------------------------------------------->
    <!--en caso de que se haya escogido solo periodo mostrar este apartado con el encabezado-->
    <h4 style="text-align:center;">
        <?php
            echo "<br>". 'INFORMACIÓN RELACIONADA AL USO DE LAS AULAS Y LABORATORIOS';
            echo "<br>";
            echo 'Período académico: '.$m_periodo->INICIO_PER . ' hasta ' . $m_periodo->FIN_PER;
        ?>    
    </h4>
    <div class="col-md-12"> 
        <?php
        $aux_aula = 'vacio';
        $cont=1;              
        foreach ($rep_aulas as $hi) {
            if ($hi['ID_AUL'] != $aux_aula) {
                $aux_aula = $hi['ID_AUL'];       
        ?>
        <h4 color="#31708f"><strong><?= '('.$cont.') '.$hi['ID_AUL'] ?> </strong></h4>
                <?php 
                    $aux_carrera = 'vacio';
                    $cont_aula=1;                    
                    foreach ($rep_aulas as $hm) {
                        if ($hi['ID_AUL'] == $hm['ID_AUL'] && $hm['ID_CAR'] != $aux_carrera) {
                        $aux_carrera = $hm['ID_CAR'];         
                ?>
                        <table border="1" cellpadding="0" cellspacing="0" >                                       
                            <thead>
                                <tr bgcolor='#d9edf7'>
                                    <th height="30" style="text-align:right;" colspan="7"><?= 'CARRERA: '.$hm['ID_CAR'] ?></th>
                                </tr>    
                                <tr  style="text-align:center;">
                                    <th height="30" width="4%">N°</th>
                                    <th height="30" width="10%">Hora</th>
                                    <th height="30" width="12%">Día</th>
                                    <th height="30" width="10%">Nivel</th>
                                    <th height="30" width="9%">Paralelo</th>
                                    <th height="30" width="20%">Docente</th>
                                    <th height="30" width="65%">Asignatura</th>
                                </tr>
                            </thead>
                           <tbody >
                               <?php
                                foreach ($rep_aulas as $hj) {
                                if ($hm['ID_CAR'] == $hj['ID_CAR'] && $hi['ID_AUL'] == $hj['ID_AUL']) {                                    
                                     echo "<tr>";                                     
                                        echo "<td style='text-align:center;'>" . $cont_aula . "</td>";
                                        echo "<td>" . $hj['ID_HORA'] . "</td>";
                                        echo "<td>" . $hj['ID_DIA'] . "</td>";
                                        echo "<td>" . $hj['ID_SEM'] . "</td>";                                       
                                        echo "<td style='text-align:center;'>" . $hj['PARALELO'] . "</td>";
                                         echo "<td>" . $hj['CEDULA_DOC'] . "</td>";
                                        echo "<td>" . $hj['CODIGO_ASIG'] . "</td>";
                                     echo "</tr>";
                                    $cont_aula = $cont_aula+1;
                                    } //fin de if de para mostar tabla
                                }   
                                ?> 
                            </tbody>                   
                        </table>  <br>          
                <?php
                        } //fin de if de aux_carrera
                    }                    
                ?>
        <?php
                //$aux_carrera = 'vacio';
                $cont = $cont+1; //cantida de aulas
            } //fin de primer if condicionando $aux_aula
        } //fin de primer foreach hi
        ?>
    </div>
      <?php
    }}
    ?>

</div>
</body>
</html>  