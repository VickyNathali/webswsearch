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
                <center> <b>LISTA DE HORAS DE CLASE</b></center></div>
            <div class="panel-body">
                <table class="table table-bordered table-condensed table-responsive table-hover table-striped ">
                    <thead>
                    <th><center>CODIGO</center></th>
                    <th><center>HORA DE INICIO</center></th> 
                    <th><center>HORA DE FIN</center></th> 
                    </thead>
                    <tbody>
                        <?php
                        foreach ($modelo_hora as $hora) {
                            echo "<tr>";
                            echo "<td>" . $hora->ID_HORA . "</td>";
                            echo "<td>" . $hora->INICIO_HORA . "</td>";
                            echo "<td>" . $hora->FIN_HORA . "</td>";
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
            <a href="<?= Yii::$app->homeUrl ?>/hora/listar_pdf"> <img src="<?= Yii::$app->homeUrl ?>/imagenes/iconos/pdf.png" alt="x"/> Pdf </a>
        </button>
    </div>
</div>
