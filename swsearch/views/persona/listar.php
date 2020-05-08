<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Carrera;

$this->title = 'Listar usuarios';
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
                <center> LISTA DE USUARIOS DEL APLICATIVO WEB </center>
            </div>
            <div class="panel-body">                
                <h5 style="text-align: center"><b>ACTIVOS </b></h5>
                <table class="table table-bordered table-condensed table-responsive table-hover table-striped ">
                    <thead>
                    <th width="5%"><center>CÉDULA</center></th>
                    <th width="35%"><center>APELLIDOS Y NOMBRES</center></th>
                    <th width="30%"><center>CARGO</center></th>                    
                    <th><center>TITULO ACADÉMICO</center></th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($modelo_usuario as $usu) {
                            if($usu->TOKEN_PER == 1){
                            echo "<tr>";
                            foreach ($modelo_adm as $adm) {
                                if ($usu->CEDULA_PER == $adm->CEDULA_PER) {
                                    echo "<td>" . $usu->CEDULA_PER . "</td>";
                                    echo "<td>" . $usu->APELLIDOS_PER . " " . $usu->NOMBRES_PER . "</td>";
                                    echo "<td>" . $adm->CARGO_ADM . "</td>";                                    
                                    echo "<td>" . $adm->TITULO_ADM . "</td>";
                                }
                            }
                            echo "</tr>";
                        }}
                        ?>
                    </tbody>
                </table>
                <h5 style="text-align: center"><b>INACTIVOS </b></h5>                
                <table class="table table-bordered table-condensed table-responsive table-hover table-striped ">
                    <thead>
                    <th width="5%"><center>CÉDULA</center></th>
                    <th width="35%"><center>APELLIDOS Y NOMBRES</center></th>
                    <th width="30%"><center>CARGO</center></th>                    
                    <th><center>TITULO ACADÉMICO</center></th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($modelo_usuario as $usu) {
                            if($usu->TOKEN_PER == 0){
                            echo "<tr>";
                            foreach ($modelo_adm as $adm) {
                                if ($usu->CEDULA_PER == $adm->CEDULA_PER) {
                                    echo "<td>" . $usu->CEDULA_PER . "</td>";
                                    echo "<td>" . $usu->APELLIDOS_PER . " " . $usu->NOMBRES_PER . "</td>";
                                    echo "<td>" . $adm->CARGO_ADM . "</td>";
                                    echo "<td>" . $adm->TITULO_ADM . "</td>";
                                }
                            }
                            echo "</tr>";
                        }}
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
         <div class="panel panel-default" id="borTbl" >
            <div class="panel-heading" id="subtitl" >                     
                <center> <b>LISTA DE USUARIOS DEL APLICATIVO MÓVIL </b></center>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-condensed table-responsive table-hover table-striped ">
                    <thead>
                    <th width="5%"><center>CÉDULA</center></th>
                    <th width="35%"><center>APELLIDOS Y NOMBRES</center></th>
                    <th width="30%"><center>CARRERA</center></th> 
                    <th><center>ESTADO</center></th>
                    </thead>  
                    <tbody>
                        <?php
                        foreach ($modelo_usuario as $usu) {
                            echo "<tr>";
                            foreach ($modelo_est as $est) {
                                if ($usu->CEDULA_PER == $est->CEDULA_PER) {
                                    echo "<td>" . $usu->CEDULA_PER . "</td>";
                                    echo "<td>" . $usu->APELLIDOS_PER . " " . $usu->NOMBRES_PER . "</td>";
                                    echo "<td>" . $est->cAR->NOMBRE_CAR . "</td>";
                                    if ($usu->TOKEN_PER == 1) {
                                        echo "<td>" . "ACTIVO" . "</td>";
                                    } else {
                                        echo "<td>" . "INACTIVO" . "</td>";
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
    </div>
    <div class="col-md-1">        
        <a href="<?= Yii::$app->homeUrl ?>persona/listar_pdf" target="_blank">
            <button type="button" class="btn btn-danger"> 
                <img src="<?= Yii::$app->homeUrl ?>/imagenes/iconos/pdf.png" alt="Pdf"/> Pdf   
            </button>
        </a> 
    </div>
</div>
