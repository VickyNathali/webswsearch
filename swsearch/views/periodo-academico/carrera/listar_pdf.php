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
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
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
        $this->title = 'LISTA DE CARRERAS ';
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
                <br>
                <h3><?= $this->title; ?></h3>
                <br><br>
            </center>
        </td>   
    </tr>
</table>
<div class="row">
    <div class="col-md-12">
        <h4 align="center">ACTIVAS</h4>
        <table border="1" cellpadding="2" cellspacing="0" width="100%">
            <thead style="text-align:center;" >
                <tr bgcolor='#d9edf7'>
                    <td width="25%"><b>NOMBRE</b></td>
                    <td width="20%"><b>DIRECTOR</b></td>                       
                    <td width="15%"><b>DURACIÓN</b></td>                          
                    <td ><b>TÍTULO A OBTENER</b></td>                    
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($carrera as $car) {
                    if ($car->ESTADO_CAR == 1) {
                        echo "<tr>";
                        echo "<td>" . $car->NOMBRE_CAR . "</td>";
                        echo "<td>" . $car->DIRECTOR_CAR . "</td>";
                        echo "<td>" . $car->DURACION_CAR . " semestres</td>";
                        echo "<td>" . $car->TITULO_OBT_CAR . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
        <h4 align="center">INACTIVAS</h4>
        <table border="1" cellpadding="2" cellspacing="0" width="100%">
            <thead style="text-align:center;" >
                <tr bgcolor='#d9edf7'>
                    <td width="25%"><b>NOMBRE</b></td>
                    <td width="20%"><b>DIRECTOR</b></td>                       
                    <td width="15%"><b>DURACIÓN</b></td>                       
                    <td ><b>TÍTULO A OBTENER</b></td>                    
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($carrera as $car) {
                    if ($car->ESTADO_CAR == 0) {
                        echo "<tr>";
                        echo "<td>" . $car->NOMBRE_CAR . "</td>";
                        echo "<td>" . $car->DIRECTOR_CAR . "</td>";
                        echo "<td>" . $car->DURACION_CAR . " semestres</td>";
                        echo "<td>" . $car->TITULO_OBT_CAR . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>  