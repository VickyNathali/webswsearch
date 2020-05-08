<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Listar aulas y laboratorios';
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
                <center> LISTA DE AULAS Y LABORATORIOS</center></div>
            <div class="panel-body">
                <h5 style="text-align: center"><b>ACTIVAS </b></h5>
                <table class="table table-bordered table-condensed table-responsive table-hover table-striped ">
                    <thead>
                    <th width="30%"><center>NOMBRE</center></th>
                    <th width="15%"><center>LATITUD</center></th>
                    <th width="15%"><center>LONGITUD</center></th>
                    <th width="20%"><center>OBSERVACIONES</center></th> 
                    <th width="20%"><center>FOTO</center></th>  
                    </thead>
                    <tbody>
                        <?php
                        foreach ($modelo_aula as $aula) {
                            if ($aula->ESTADO_AUL == 1) {
                                echo "<tr >";
                                echo "<td>" . $aula->NOMBRE_AUL . "</td>";
                                echo "<td style='text-align:center;'>" . $aula->LATITUD_AUL . "</td>";
                                echo "<td style='text-align:center;'>" . $aula->LONGITUD_AUL . "</td>";                                
                                echo "<td style='text-align:justify;'>" . $aula->OBSERVACIONES_AUL . "</td>";
                                echo "<td> <center>";
                                if ($aula->FOTO_AUL != false) {
                                    echo Html::img('@web/imagenes/aulas/' . $aula->FOTO_AUL, ['height' => 100, 'width' => 110]);
                                } else {
                                    echo Html::img('@web/imagenes/aulas/sin_imagen.jpg', ['height' => 100, 'width' => 110]);
                                }
                                echo "</center></td> ";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <h5 style="text-align: center"><b>INACTIVAS </b></h5>
                <table class="table table-bordered table-condensed table-responsive table-hover table-striped ">
                    <thead>
                    <th width="30%"><center>NOMBRE</center></th>
                    <th width="15%"><center>LATITUD</center></th>
                    <th width="15%"><center>LONGITUD</center></th>
                    <th width="20%"><center>OBSERVACIONES</center></th> 
                    <th width="20%"><center>FOTO</center></th>  
                    </thead>
                    <tbody>
                        <?php
                        foreach ($modelo_aula as $aula) {
                            if ($aula->ESTADO_AUL == 0) {
                                echo "<tr>";
                                echo "<td>" . $aula->NOMBRE_AUL . "</td>";
                                echo "<td>" . $aula->LATITUD_AUL . "</td>";
                                echo "<td>" . $aula->LONGITUD_AUL . "</td>";
                                echo "<td>" . $aula->OBSERVACIONES_AUL . "</td>";
                                echo "<td> <center>";
                                if ($aula->FOTO_AUL != false) {
                                    echo Html::img('@web/imagenes/aulas/' . $aula->FOTO_AUL, ['height' => 100, 'width' => 120]);
                                } else {
                                    echo Html::img('@web/imagenes/aulas/sin_imagen.jpg', ['height' => 100, 'width' => 120]);
                                }
                                 echo "</center></td> ";
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
        <a href="<?= Yii::$app->homeUrl ?>aula-laboratorio/listar_pdf" target="_blank">
            <button type="button" class="btn btn-danger"> 
                <img src="<?= Yii::$app->homeUrl ?>/imagenes/iconos/pdf.png" alt="Pdf"/> Pdf   
            </button>
        </a> 
    </div>
</div>
