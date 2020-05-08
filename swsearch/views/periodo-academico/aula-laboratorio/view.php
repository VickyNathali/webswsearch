<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AulaLaboratorio */

$this->title = $model->NOMBRE_AUL;
$this->params['breadcrumbs'][] = ['label' => 'Aula Laboratorios', 'url' => ['index']];
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
<div class="aula-laboratorio-view">

    <b><h1 class="panel-heading" align="center" id="subtitl" style="font-family:Trebuchet MS;"> DATOS INFORMATIVOS</h1></b><br>

    <div class="row" >
        <div class="col-sm-2"></div> <!-- espacio vacio a la izquierda-->
        <!-- columna para tabla de infomacion -->
        <div class="col-sm-8 panel panel-footer" id="cuadroDI">
            <b><h1  style="font-family:Trebuchet MS;">Aula o laboratorio</h1></b><br>              

            <!-- columna para foto -->
            <div class="col-sm-4">
                <?php
                if ($model->FOTO_AUL != false) {
                    echo Html::img('@web/imagenes/aulas/' . $model->FOTO_AUL, ['height' => 150, 'width' => 200, 'class'=>'img-rounded']);
                    // echo "<div class='alert alert-info'><h5>".$model->nombre_producto.'</h5></div>';
                } else {
                    echo Html::img('@web/imagenes/aulas/sin_imagen.jpg', ['height' => 150, 'width' => 200, 'class'=>'img-rounded']);
                }
                ?>
            </div>
            <!-- columna para foto-->

            <center>
                <table class="table-bordered table-condensed table-hover " width="60%" >
                    <!-- 2 columnas-->
                    <tr class=" badge-info"> 
                        <td WIDTH="25%"><b>Nombre</b></td>
                        <td class="text-justify"> <?= $model->NOMBRE_AUL ?>  </td>                                        
                    </tr>
                    <!-- 2 columnas-->
                    <tr class=" badge-info"> 
                        <td WIDTH=""><b>Lalitud</b></td>
                        <td class="text-justify"> <?= $model->LATITUD_AUL ?>  </td>                                        
                    </tr>
                    <!-- 2 columnas-->
                    <tr class=" badge-info"> 
                        <td WIDTH=""><b>Longitud</b></td>
                        <td class="text-justify"> <?= $model->LONGITUD_AUL ?>  </td>                                        
                    </tr>                    
                    <!-- 2 columnas-->
                    <tr class=" badge-info"> 
                        <td WIDTH=""><b>Observaciones</b></td>
                        <td class="text-justify"> <?= $model->OBSERVACIONES_AUL ?>  </td>                                        
                    </tr>
                    <!-- 2 columnas-->
                    <tr class=" badge-info"> 
                        <td WIDTH=""><b>Estado</b></td>                        
                        <td class="text-justify"><?php
                            if ($model->ESTADO_AUL == 0)
                                $var1 = 'INACTIVA';
                            if ($model->ESTADO_AUL == 1)
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

    <!--botones modiciar/eliminar-->
    <p class="text-center">
        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Modificar', ['update', 'id' => $model->ID_AUL], ['class' => 'btn btn-primary']) ?>

        <?=
        Html::a('Eliminar ', ['delete_aul', 'id' => $model->ID_AUL], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro que desea eliminar? (' . $model->NOMBRE_AUL . ')',
                'method' => 'post',
            ],
        ])
        ?>
    </p><br>
    <!--botones modiciar/eliminar-->  

</div>
