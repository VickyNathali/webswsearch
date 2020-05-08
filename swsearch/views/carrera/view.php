<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Carrera */

$this->title = $model->NOMBRE_CAR;
$this->params['breadcrumbs'][] = ['label' => 'Carreras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<style> 
    #cuadroDI {
        border-top: 2px solid #c2ccd1;
        border-right: 2px solid #c2ccd1;
        border-bottom: 2px solid #c2ccd1;
        border-left: 2px solid #c2ccd1;        
        border-radius: 1rem; 
    }
    #subtitl {
        font-size:20px;
        font-weight:bold;
        background-color: #c2ccd1;         
    }
</style>
<div class="carrera-view">

    <b><h1 class="panel-heading" align="center" id="subtitl" style="font-family:Trebuchet MS;"> DATOS INFORMATIVOS</h1></b><br>
    <div class="row" >
        <div class="col-sm-2"></div> <!-- espacio vacio a la izquierda-->
        <!-- columna para tabla de infomacion -->
        <div class="col-sm-8 panel panel-footer" id="cuadroDI">
            <b><h1  style="font-family:Trebuchet MS;">Carrera</h1></b><br>              
            <center>
                <table class="table-bordered table-condensed table-hover " width="80%" >
                    <!-- 2 columnas-->
                    <tr class=" badge-info"> 
                        <td WIDTH="25%"><b>Nombre</b></td>
                        <td class="text-justify"> <?= $model->NOMBRE_CAR ?>  </td>                                        
                    </tr>
                    <!-- 2 columnas-->
                    <!-- 2 columnas-->
                    <tr class=" badge-info"> 
                        <td WIDTH="25%"><b>Director</b></td>
                        <td class="text-justify"> <?= $model->DIRECTOR_CAR ?>  </td>                                        
                    </tr>
                    <!-- 2 columnas-->                   
                    <!-- 2 columnas-->
                    <tr class=" badge-info"> 
                        <td WIDTH=""><b>Título a obtener</b></td>
                        <td class="text-justify"> <?= $model->TITULO_OBT_CAR ?>  </td>                                        
                    </tr>
                    <!-- 2 columnas-->  
                     <!-- 2 columnas-->
                    <tr class=" badge-info"> 
                        <td WIDTH="25%"><b>Duración</b></td>
                        <td class="text-justify"> <?= $model->DURACION_CAR ?> semestres </td>                                        
                    </tr>
                    <!-- 2 columnas-->
                    <tr class=" badge-info"> 
                        <td WIDTH=""><b>Estado</b></td>                        
                        <td class="text-justify"><?php
                            if ($model->ESTADO_CAR == 0)
                                $var1 = 'INACTIVA';
                            if ($model->ESTADO_CAR == 1)
                                $var1 = 'ACTIVA';                           
                            ?>
                            <?= $var1 ?>  
                        </td>    
                    </tr>
                </table>
            </center>             
            <br> 
        </div>   <!-- final de columna para tabla de infomacion -->

        <div class="col-sm-2"></div> <!--espacio vacio a la derecha--> 
    </div>  <!--final de row-->
    <br>    
    <p class="text-center">
        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Modificar', ['update', 'id' => $model->ID_CAR], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Eliminar', ['delete_logico', 'id' => $model->ID_CAR], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro que desea eliminar? ('.$model->NOMBRE_CAR.')',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

</div>
