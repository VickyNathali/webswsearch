<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\AulaLaboratorio;
use app\models\Dia;
use app\models\Hora;
use app\models\Asignatura;
use yii\helpers\ArrayHelper;
use pcrt\widgets\select2\Select2; //libreria para busqueda avanzada  mediante escritura

$session = Yii::$app->session;
$per = $session['id_periodo']; //periodo
$car = $session['id_carrera']; //carrera
$sem = $session['id_semestre']; //semestre   
$asig = $session['id_asignatura']; //asignatura            
$doc = $session['id_docente']; //docente
$par = $session['id_paralelo']; //paralelo
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
<div class="asig-doc-per-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?> 

    <?php
    echo "<b>" . ' Período acádemico: ' . "</b>";
    echo $model->cODIGOASIG->cAR->pER->INICIO_PER . ' hasta ' . $model->cODIGOASIG->cAR->pER->FIN_PER;
    echo "<br>";
    echo "<br>";
    echo "<b>" . ' Asignatura: ' . "</b>";
    echo $model->cODIGOASIG->cAR->cODIGOASIG->NOMBRE_ASIG; 
    echo "<br>";
    echo "<br>";
    echo "<b>" . ' Docente: ' . "</b>";
    echo $model->cODIGOASIG->cEDULADOC->NOMBRES_DOC . ' ' . $model->cODIGOASIG->cEDULADOC->APELLIDOS_DOC;
    echo "<br>";
    echo "<br>";
    echo "<b>" . ' Paralelo: ' . "</b>";
    echo $model->cODIGOASIG->PARALELO;
    echo "<br>";
    echo "<br>";
    ?>   
    <!--mostrar periodo y asignatura que esta seleccionada-->
    <div class="row">
        <div class="col-md-12"> 
            <div class="panel panel-footer" id="cuadroDI" >
                <div class="panel-body">
                    <?php
                    //para el día 
                    $var1 = ArrayHelper::map(Dia::find()->all(), 'ID_DIA', 'DESCRIPCION_DIA');
                    echo $form->field($model, 'ID_DIA')->dropDownList($var1, [
                        'prompt' => 'Seleccionar ...',
                        'onClick' => '$.post("' . Yii::$app->urlManager->createUrl('dia-aula-hora/listar_hora_dia?id=') . '"+$(this).val(), function( data ) {$("#diaaulahora-id_hora").html(data);});'
                    ]);
                    //fin del día
                    ?> 

                    <?php
                    //para el hora
                    $horas = ArrayHelper::map(Hora::find()->where(['ESTADO_HORA' => 1])->orderBy('INICIO_HORA asc')->all(), 'ID_HORA', function ($model) {
                                return $model['INICIO_HORA'] . ' ' . $model['FIN_HORA'];
                            });
                    echo $form->field($model, 'ID_HORA')->dropDownList($horas, [
                        'prompt' => 'Seleccionar ...',
                        'onClick' => '$.post("' . Yii::$app->urlManager->createUrl('dia-aula-hora/listar_aula_hora?id=') . '"+$(this).val(), function( data ) {$("select#diaaulahora-id_aul").html(data);});'
                    ]);
                    //fin del hora
                    ?>

                    <?php
                    //para el aula
                    $var1 = ArrayHelper::map(AulaLaboratorio::find()->where(['ESTADO_AUL' => 1])->orderBy('NOMBRE_AUL asc')->all(), 'ID_AUL', function ($model) {
                                return $model['NOMBRE_AUL'];
                            });
                    echo $form->field($model, 'ID_AUL')
                            ->widget(Select2::classname(), [
                                'items' => $var1,
                                'options' => ['placeholder' => 'Seleccionar ...'],
                                    ]
                    );
                    //fin el aula
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
