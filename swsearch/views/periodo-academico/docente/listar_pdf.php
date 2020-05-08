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
        $this->title = 'LISTA DE DOCENTES ';
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
                    <td width="15%"><b>CÉDULA</b></td>
                    <td width="35%"><b>APELLIDOS Y NOMBRES</b></td>                       
                    <td width="20%"><b>TÍTULO</b></td>                       
                    <td width="14%"><b>CELULAR</b></td>                       
                    <td width="30%"><b>CORREO</b></td>  
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($docentes as $doc) {
                    if ($doc->ESTADO_DOC == 1) {
                        echo "<tr>";
                        echo "<td>" . $doc->CEDULA_DOC . "</td>";
                        echo "<td>" . $doc->APELLIDOS_DOC . " " . $doc->NOMBRES_DOC . "</td>";
                        echo "<td>" . $doc->TITULO_DOC . "</td>";
                        echo "<td>" . $doc->CELULAR_DOC . "</td>";
                        echo "<td>" . $doc->CORREO_DOC . "</td>";
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
                    <td width="15%"><b>CÉDULA</b></td>
                    <td width="35%"><b>APELLIDOS Y NOMBRES</b></td>                       
                    <td width="20%"><b>TÍTULO</b></td>                       
                    <td width="14%"><b>CELULAR</b></td>                       
                    <td width="30%"><b>CORREO</b></td>  
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($docentes as $doc) {
                    if ($doc->ESTADO_DOC == 0) {
                        echo "<tr>";
                        echo "<td>" . $doc->CEDULA_DOC . "</td>";
                        echo "<td>" . $doc->APELLIDOS_DOC . " " . $doc->NOMBRES_DOC . "</td>";
                        echo "<td>" . $doc->TITULO_DOC . "</td>";
                        echo "<td>" . $doc->CELULAR_DOC . "</td>";
                        echo "<td>" . $doc->CORREO_DOC . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</div>
</div>

</body>
</html>  