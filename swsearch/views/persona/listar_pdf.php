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
        $this->title = 'LISTA DE USUARIOS DEL APLICATIVO WEB';
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
         <h4 align="center">ACTIVOS</h4>
        <table border="1" cellpadding="2" cellspacing="0" width="100%">
            <thead style="text-align:center;" >
                <tr bgcolor='#d9edf7'>
                    <td width="14%"><b>CÉDULA</b></td>
                    <td width="35%"><b> APELLIDOS Y NOMBRES</b></td>                       
                    <td width="26%"><b>CARGO</b></td>  
                    <td><b>TÍTULO ACADÉMICO</b></td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($usuarios as $usu) {
                    if ($usu->TOKEN_PER == 1) {
                        echo "<tr>";
                        foreach ($administrador as $adm) {
                            if ($usu->CEDULA_PER == $adm->CEDULA_PER) {
                                echo "<td>" . $usu->CEDULA_PER . "</td>";
                                echo "<td>" . $usu->APELLIDOS_PER . " " . $usu->NOMBRES_PER . "</td>";
                                echo "<td>" . $adm->CARGO_ADM . "</td>";
                                echo "<td>" . $adm->TITULO_ADM . "</td>";
                            }
                        }
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
         <h4 align="center">INACTIVOS</h4>
        <table border="1" cellpadding="2" cellspacing="0" width="100%">
            <thead style="text-align:center;" >
                <tr bgcolor='#d9edf7'>
                    <td width="14%"><b>CÉDULA</b></td>
                    <td width="35%"><b> APELLIDOS Y NOMBRES</b></td>                       
                    <td width="26%"><b>CARGO</b></td>  
                    <td><b>TÍTULO ACADÉMICO</b></td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($usuarios as $usu) {
                    if ($usu->TOKEN_PER == 0) {
                        echo "<tr>";
                        foreach ($administrador as $adm) {
                            if ($usu->CEDULA_PER == $adm->CEDULA_PER) {
                                echo "<td>" . $usu->CEDULA_PER . "</td>";
                                echo "<td>" . $usu->APELLIDOS_PER . " " . $usu->NOMBRES_PER . "</td>";
                                echo "<td>" . $adm->CARGO_ADM . "</td>";
                                echo "<td>" . $adm->TITULO_ADM . "</td>";
                            }
                        }
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
        <br>                   
        <h3 align="center">LISTA DE USUARIOS DEL APLICATIVO MÓVIL</h3>
        <br>
        <table border="1" cellpadding="2" cellspacing="0" width="100%">
            <thead style="text-align:center;" >
                <tr bgcolor='#d9edf7'>
                    <td width="14%"><b>CÉDULA</b></td>
                    <td width="35%"><b> APELLIDOS Y NOMBRES</b></td>                       
                    <td width="26%"><b>CARRERA</b></td>  
                    <td><b>TIPO DE USUARIO</b></td>
                </tr></thead>
            <tbody>
                <?php
                foreach ($usuarios as $usu) {
                    echo "<tr>";
                    foreach ($estudiante as $est) {
                        if ($usu->CEDULA_PER == $est->CEDULA_PER) {
                            echo "<td>" . $usu->CEDULA_PER . "</td>";
                            echo "<td>" . $usu->APELLIDOS_PER . " " . $usu->NOMBRES_PER . "</td>";
                            echo "<td>" . $est->cAR->NOMBRE_CAR . "</td>";
                            if ($usu->TOKEN_PER == 1) {
                                echo "<td>" . "Activo" . "</td>";
                            } else {
                                echo "<td>" . "Inactivo" . "</td>";
                            }
                        }
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>  