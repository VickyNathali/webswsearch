<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Listar docentes';
?>
<style>     
    #subtitl {
        /*        color: #31708f;*/
        font-size:18px;
        font-weight:bold;
        background-color: #c2ccd1; 
        border-color: #b9bfc2; 
    }
    #borTbl{
        border-color: #b9bfc2;  
    }
</style>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="panel panel-default" id="borTbl" >
            <div class="panel-heading" id="subtitl" >                     
                <center> LISTA DE DOCENTES</center></div>
            <div class="panel-body">
                <h5 style="text-align: center"><b>ACTIVOS </b></h5>
                <table class="table table-bordered table-condensed table-responsive table-hover table-striped ">
                    <thead>
                    <th width="10%"><center>CÉDULA</center></th>
                    <th width="30%"><center>APELLIDOS Y NOMBRES</center></th>
                    <th width="24%"><center>TÍTULO</center></th>                    
                    <th width="10%"><center>CELULAR</center></th>
                    <th><center>CORREO</center></th>
                    </thead>
                    <tbody >
                        <?php
                        foreach ($modelo_docentes as $doc) {
                            if ($doc->ESTADO_DOC == 1) {
                            echo "<tr>";
                            echo "<td>" . $doc->CEDULA_DOC . "</td>";
                            echo "<td>" . $doc->APELLIDOS_DOC . " " . $doc->NOMBRES_DOC . "</td>";
                            echo "<td>" . $doc->TITULO_DOC . "</td>";
                            echo "<td>" . $doc->CELULAR_DOC . "</td>";
                            echo "<td>" . $doc->CORREO_DOC . "</td>";
                            echo "</tr>";
                        }}
                        ?>
                    </tbody>
                </table>
                <h5 style="text-align: center"><b>INACTIVOS </b></h5>
                <table class="table table-bordered table-condensed table-responsive table-hover table-striped ">
                    <thead>
                    <th width="10%"><center>CÉDULA</center></th>
                    <th width="30%"><center>APELLIDOS Y NOMBRES</center></th>
                    <th width="24%"><center>TÍTULO</center></th>                    
                    <th width="10%"><center>CELULAR</center></th>
                    <th><center>CORREO</center></th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($modelo_docentes as $doc) {
                            if ($doc->ESTADO_DOC == 0) {
                            echo "<tr>";
                            echo "<td>" . $doc->CEDULA_DOC . "</td>";
                            echo "<td>" . $doc->APELLIDOS_DOC . " " . $doc->NOMBRES_DOC . "</td>";
                            echo "<td>" . $doc->TITULO_DOC . "</td>";
                            echo "<td>" . $doc->CELULAR_DOC . "</td>";
                            echo "<td>" . $doc->CORREO_DOC . "</td>";
                            echo "</tr>";
                        }}
                        ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div class="col-md-1">
        <a href="<?= Yii::$app->homeUrl ?>docente/listar_pdf" target="_blank">
            <button type="button" class="btn btn-danger"> 
                <img src="<?= Yii::$app->homeUrl ?>/imagenes/iconos/pdf.png" alt="Pdf"/> Pdf   
            </button>
        </a> 
    </div>
</div>
