<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Administrador;

/* @var $this yii\web\View */
/* @var $model app\models\Persona */

$this->title = $model->NOMBRES_PER;
$this->params['breadcrumbs'][] = ['label' => 'Personas', 'url' => ['index']];
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
<div class="persona-view">
    
    <b><h1 class="panel-heading" align="center" id="subtitl" style="font-family:Trebuchet MS;">PERFIL DE USUARIO</h1></b><br>

    <div class="row" >
        <div class="col-sm-2"></div> <!-- espacio vacio a la izquierda-->
        <!-- columna para tabla de infomacion -->
        <div class="col-sm-8 panel panel-footer" id="cuadroDI">
            <b><h1  style="font-family:Trebuchet MS;">Administrador</h1></b><br>
            <!-- columna para foto -->
            <div class="col-sm-4" >
                <?php
                if ($model->FOTO_PER != false) {
                    echo Html::img('@web/imagenes/Fotos/' . $model->FOTO_PER, ['height' => 215, 'width' => 200, 'class'=>'img-rounded']);                    
                } else {
                    echo Html::img('@web/imagenes/Fotos/sin_imagen.jpg', ['height'=> 215, 'width' => 200,'class'=>'img-rounded']);
                }
                ?>
            </div>
            <!-- columna para foto-->
            <center>
                <table class="table-bordered table-condensed table-hover " width="60%" >
                    <!-- 2 columnas-->
                    <tr class=" badge-info"> 
                        <td WIDTH="25%"><b>Cédula</b></td>
                        <td class="text-justify"> <?= $model->CEDULA_PER ?>  </td>                                        
                    </tr>
                    <!-- 2 columnas-->
                    <!-- 2 columnas-->
                    <tr class=" badge-info"> 
                        <td WIDTH=""><b>Nombres</b></td>
                        <td class="text-justify"> <?= $model->NOMBRES_PER ?>  </td>                                        
                    </tr>
                    <!-- 2 columnas-->
                    <!-- 2 columnas-->
                    <tr class=" badge-info"> 
                        <td WIDTH=""><b>Apellidos</b></td>
                        <td class="text-justify"> <?= $model->APELLIDOS_PER ?>  </td>                                        
                    </tr>
                    <!-- 2 columnas-->                    
                    <!-- 2 columnas-->
                    <tr class=" badge-info"> 
                        <td WIDTH=""><b>Cargo</b></td>
                        <td class="text-justify"> <?= $model_adm->CARGO_ADM ?>  </td>                                   
                    </tr>
                    <!-- 2 columnas-->
                    <!-- 2 columnas-->
                    <tr class=" badge-info"> 
                        <td WIDTH=""><b>Título</b></td>
                        <td class="text-justify"> <?= $model_adm->TITULO_ADM ?>  </td>                                        
                    </tr>
                    <!-- 2 columnas-->
                    <!-- 2 columnas-->
                    <tr class=" badge-info"> 
                        <td WIDTH=""><b>Usuario</b></td>
                        <td class="text-justify"> <?= $model->USUARIO_PER ?>  </td>                                        
                    </tr>
                    <!-- 2 columnas-->
                    <tr class=" badge-info"> 
                        <td WIDTH=""><b>Estado</b></td>                        
                        <td class="text-justify"><?php
                            if ($model->TOKEN_PER == 0)
                                $var1 = 'INACTIVO';
                            if ($model->TOKEN_PER == 1)
                                $var1 = 'ACTIVO';                           
                            ?>
                            <?= $var1 ?>  
                        </td>    
                    </tr>
                </table>
            </center>             
            <br>                 
        </div> <!--final de div de los datos personales--> 
        <div class="col-sm-2"></div> <!--espacio vacio a la derecha--> 
    </div>  <!--final de row-->
    <br>

    <!--botones modiciar/eliminar-->
    <p class="text-center">
        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Modificar', ['update', 'id' => $model->CEDULA_PER], ['class' => 'btn btn-primary']) ?>

        <?=
        Html::a('Eliminar ', ['delete_adm', 'id' => $model->CEDULA_PER], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro que desea eliminar? ('.$model->NOMBRES_PER.' '.$model->APELLIDOS_PER.')',
                'method' => 'post',
            ],
        ])
        ?>  
        
    </p><br>
    <!--botones modiciar/eliminar-->        

</div>
