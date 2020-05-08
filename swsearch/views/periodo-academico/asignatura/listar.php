<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Listar asignaturas';
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
                <center> LISTA DE ASIGNATURAS</center>
            </div>
            <div class="panel-body">
                <h5 style="text-align: center"><b>ACTIVAS </b></h5>
                <table class="table table-bordered table-condensed table-responsive table-hover table-striped ">
                    <thead>
                    <th width="13%"><center>CÓDIGO</center></th>
                    <th width="60%"><center>NOMBRE</center></th>
                    <th><center>OBSERVACIONES</center></th>                    
                    </thead>
                    <tbody>
                        <?php
                        foreach ($modelo_asig as $asig) {
                            if ($asig->ESTADO_ASIG == 1) {
                                echo "<tr>";
                                echo "<td>" . $asig->CODIGO_ASIG . "</td>";
                                echo "<td>" . $asig->NOMBRE_ASIG . "</td>";
                                echo "<td>" . $asig->OBSERVACIONES_ASIG . "</td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <h5 style="text-align: center"><b>INACTIVAS </b></h5>
                <table class="table table-bordered table-condensed table-responsive table-hover table-striped ">
                    <thead>
                    <th width="13%"><center>CÓDIGO</center></th>
                    <th width="60%"><center>NOMBRE</center></th>
                    <th><center>OBSERVACIONES</center></th>                    
                    </thead>
                    <tbody>
                        <?php
                        foreach ($modelo_asig as $asig) {
                            if ($asig->ESTADO_ASIG == 0) {
                                echo "<tr>";
                                echo "<td>" . $asig->CODIGO_ASIG . "</td>";
                                echo "<td>" . $asig->NOMBRE_ASIG . "</td>";
                                echo "<td>" . $asig->OBSERVACIONES_ASIG . "</td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div class="col-md-2">       
        <a href="<?= Yii::$app->homeUrl ?>asignatura/listar_pdf" target="_blank">
            <button type="button" class="btn btn-danger"> 
                <img src="<?= Yii::$app->homeUrl ?>/imagenes/iconos/pdf.png" alt="Pdf"/> Pdf   
            </button>
        </a> 
    </div>
</div>
