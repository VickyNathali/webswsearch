<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Semestre */

$this->title = $model->DESCRIPCION_SEM;
$this->params['breadcrumbs'][] = ['label' => 'Semestres', 'url' => ['index']];
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
<div class="semestre-view">
    <b><h1 class="panel-heading" align="center" id="subtitl" style="font-family:Trebuchet MS;"> DATOS INFORMATIVOS</h1></b><br>

    <div class="row" >
        <div class="col-sm-2"></div> <!-- espacio vacio a la izquierda-->
        <!-- columna para tabla de infomacion -->
        <div class="col-sm-8 panel panel-footer" id="cuadroDI">
                <b><h1  style="font-family:Trebuchet MS;">Semestre</h1></b><br>              
                <center>
                    <table class="table-bordered table-condensed table-hover " width="80%" >
                        <!-- 2 columnas-->
                        <tr class=" badge-info"> 
                            <td WIDTH="25%"><b>Código</b></td>
                            <td class="text-justify"> <?= $model->ID_SEM ?>  </td>                                        
                        </tr>
                        <!-- 2 columnas-->
                        <!-- 2 columnas-->
                        <tr class=" badge-info"> 
                            <td WIDTH=""><b>Nivel</b></td>
                            <td class="text-justify"> <?= $model->DESCRIPCION_SEM ?>  </td>                                        
                        </tr>
                        <!-- 2 columnas-->   
                        <tr class=" badge-info"> 
                        <td WIDTH=""><b>Estado</b></td>                        
                        <td class="text-justify"><?php
                            if ($model->ESTADO_SEM == 0)
                                $var1 = 'INACTIVO';
                            if ($model->ESTADO_SEM == 1)
                                $var1 = 'ACTIVO';                           
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
        <?= Html::a('Modificar', ['update', 'id' => $model->ID_SEM], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete_sem', 'id' => $model->ID_SEM], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro que desea eliminar? ('.$model->DESCRIPCION_SEM.')',
                'method' => 'post',
            ],
        ]) ?>
    </p>    

</div>
