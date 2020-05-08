<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Listar carreras';
?>

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-9">
        <div class="panel panel-info">
            <div class="panel-heading" >                 
                <center> <b>LISTA DE DÍAS</b></center></div>
            <div class="panel-body">
                <table class="table table-bordered table-condensed table-responsive table-hover table-striped ">
                    <thead>
                    <th><center>CÓDIGO</center></th>
                    <th><center>DÍA</center></th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($modelo_dia as $dia) {
                            echo "<tr>";
                            echo "<td>" . $dia->ID_DIA . "</td>";
                            echo "<td>" . $dia->DESCRIPCION_DIA . "</td>";                            
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div class="col-md-1">
        <button type="button" class="btn btn-danger"> 
            <a href="<?= Yii::$app->homeUrl ?>/carrera/listar_pdf"> <img src="<?= Yii::$app->homeUrl ?>/imagenes/iconos/pdf.png" alt="x"/> Pdf </a>
        </button>
    </div>
</div>
