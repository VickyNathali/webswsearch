<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Docente */

$this->title = $model->NOMBRES_DOC;
$this->params['breadcrumbs'][] = ['label' => 'Docentes', 'url' => ['index']];
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
<div class="docente-view">

    <b><h1 class="panel-heading" align="center" id="subtitl" style="font-family:Trebuchet MS;"> DATOS INFORMATIVOS</h1></b><br>

    <div class="row" >
        <div class="col-sm-2"></div> <!-- espacio vacio a la izquierda-->
        <!-- columna para tabla de infomacion -->
        <div class="col-sm-8 panel panel-footer" id="cuadroDI">
            <b><h1  style="font-family:Trebuchet MS;">Docente</h1></b><br> 
            <center>
                <table class="table-bordered table-condensed table-hover " width="80%" >
                    <!-- 2 columnas-->
                    <tr class=" badge-info"> 
                        <td WIDTH=""><b>Cédula</b></td>
                        <td class="text-justify"> <?= $model->CEDULA_DOC ?>  </td>                                        
                    </tr>
                    <tr class=" badge-info"> 
                        <td WIDTH=""><b>Nombres</b></td>
                        <td class="text-justify"> <?= $model->NOMBRES_DOC ?>  </td>                                        
                    </tr>                    
                    <tr class=" badge-info"> 
                        <td WIDTH=""><b>Apellidos</b></td>
                        <td class="text-justify"> <?= $model->APELLIDOS_DOC ?>  </td>                                        
                    </tr>  
                    <tr class=" badge-info"> 
                        <td WIDTH=""><b>Título</b></td>
                        <td class="text-justify"> <?= $model->TITULO_DOC ?>  </td>                                        
                    </tr>
                    <tr class=" badge-info"> 
                        <td WIDTH=""><b>Celular</b></td>
                        <td class="text-justify"> <?= $model->CELULAR_DOC ?>  </td>                                        
                    </tr>
                    <!-- 2 columnas-->
                    <tr class=" badge-info"> 
                        <td WIDTH=""><b>Correo</b></td>
                        <td class="text-justify"> <?= $model->CORREO_DOC ?>  </td>                                        
                    </tr>
                    <!-- 2 columnas-->
                    <tr class=" badge-info"> 
                        <td WIDTH=""><b>Link de página personal</b></td>
                        <td class="text-justify"> <?= $model->LINK_PAG_DOC ?>  </td>                                        
                    </tr>
                    <!-- 2 columnas-->
                    <tr class=" badge-info"> 
                        <td WIDTH=""><b>Estado</b></td>                        
                        <td class="text-justify"><?php
                            if ($model->ESTADO_DOC == 0)
                                $var1 = 'INACTIVO';
                            if ($model->ESTADO_DOC == 1)
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
        <?= Html::a('Modificar', ['update', 'id' => $model->CEDULA_DOC], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Eliminar', ['delete_doc', 'id' => $model->CEDULA_DOC], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro que desea eliminar?('.$model->NOMBRES_DOC.' '.$model->APELLIDOS_DOC.')',
                'method' => 'post',
            ],
        ])
        ?>
    </p>



</div>
