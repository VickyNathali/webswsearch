<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Listar carreras';
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
    <div class="col-md-9">
        <div class="panel panel-default" id="borTbl" >
            <div class="panel-heading" id="subtitl" >                
                <center> LISTA DE CARRERAS</center></div>
            <div class="panel-body">
                <h5 style="text-align: center"><b>ACTIVAS </b></h5>
                <table class="table table-bordered table-condensed table-responsive table-hover table-striped ">
                    <thead>
                    <th width="25%"><center>NOMBRE</center></th>
                    <th width="20%"><center>DIRECTOR</center></th>
                    <th width="15%"><center>DURACIÓN</center></th>
                    <th><center>TÍTULO A OBTENER</center></th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($modelo_carrera as $car) {
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
                <h5 style="text-align: center"><b>INACTIVAS </b></h5>
                <table class="table table-bordered table-condensed table-responsive table-hover table-striped ">
                    <thead>
                    <th width="25%"><center>NOMBRE</center></th>
                    <th width="20%"><center>DIRECTOR</center></th>
                    <th width="15%"><center>DURACIÓN</center></th>
                    <th><center>TÍTULO A OBTENER</center></th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($modelo_carrera as $car) {
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
    </div>
    <div class="col-md-1">        
        <a href="<?= Yii::$app->homeUrl ?>carrera/listar_pdf" target="_blank">
            <button type="button" class="btn btn-danger"> 
                <img src="<?= Yii::$app->homeUrl ?>/imagenes/iconos/pdf.png" alt="Pdf"/> Pdf   
            </button>
        </a> 
    </div>
</div>
