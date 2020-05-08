<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Dia */

$this->title = $model->ID_DIA;
$this->params['breadcrumbs'][] = ['label' => 'Dias', 'url' => ['index']];
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
<div class="dia-view">
    <b><h1 class="panel-heading" align="center" id="subtitl" style="font-family:Trebuchet MS;"> DATOS INFORMATIVOS</h1></b><br>
    <div class="row" >
        <div class="col-sm-2"></div> <!-- espacio vacio a la izquierda-->
        <!-- columna para tabla de infomacion -->
        <div class="col-sm-8 panel panel-footer" id="cuadroDI">
                <b><h1  style="font-family:Trebuchet MS;">Día de la semana</h1></b><br>              
                <center>
                    <table class="table-bordered table-condensed table-hover " width="80%" >
                        <!-- 2 columnas-->
                        <tr class=" badge-info"> 
                            <td WIDTH="25%"><b>Código</b></td>
                            <td class="text-justify"> <?= $model->ID_DIA ?>  </td>                                        
                        </tr>
                        <!-- 2 columnas-->
                        <!-- 2 columnas-->
                        <tr class=" badge-info"> 
                            <td WIDTH=""><b>Día</b></td>
                            <td class="text-justify"> <?= $model->DESCRIPCION_DIA ?>  </td>                                        
                        </tr>
                        <!-- 2 columnas-->                        
                        
                    </table>
                </center>             
                <br> 
        </div>   <!-- final de columna para tabla de infomacion -->
      
        <div class="col-sm-2"></div> <!--espacio vacio a la derecha--> 
    </div>  <!--final de row-->
    <br>      
    
    <p class="text-center">
         <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Modificar', ['update', 'id' => $model->ID_DIA], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Eliminar', ['delete', 'id' => $model->ID_DIA], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro que desea eliminar?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>    

</div>
