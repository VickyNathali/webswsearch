<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Docente;
use app\models\AsigDocPer;
use yii\helpers\ArrayHelper;
use pcrt\widgets\select2\Select2; //libreria para busqueda avanzada  mediante escritura

$session = Yii::$app->session;
$per = $session['id_periodo']; //periodo
$asig = $session['id_asignatura']; //asignatura
$sem = $session['id_semestre']; //semestre
$car = $session['id_carrera']; //carrera
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
    echo "<b>" . ' Asignatura: ' . "</b>";
    echo $model_docent->cAR->cODIGOASIG->NOMBRE_ASIG;
    echo "<br>";
    echo "<br>";
    echo "<b>" . ' Período acádemico: ' . "</b>";
    echo $model_docent->cAR->pER->INICIO_PER . ' ' . $model_docent->cAR->pER->FIN_PER;
    echo "<br>";
    echo "<br>";
    ?>   
    <!--mostrar periodo y asignatura que esta seleccionada--> 

    <div class="row">
        <div class="col-md-12"> 
            <div class="panel panel-footer" id="cuadroDI" >
                <div class="panel-body">
                    <?php
                    //para el docente                    
                    $sql = "SELECT
                            *
                            FROM `docente`
                            WHERE CEDULA_DOC NOT IN (SELECT c.CEDULA_DOC FROM docente AS d 
                            INNER JOIN `asig_doc_per` AS c 
                            ON d.CEDULA_DOC = c.CEDULA_DOC 
                            WHERE c.ID_CAR = '" . $car . "' AND c.PARALELO = '" . $par . "' AND c.ID_SEM = '" . $sem . "' AND "
                            . "c.ID_PER = '" . $per . "' AND c.`CODIGO_ASIG`='" . $asig . "')OR CEDULA_DOC = '" . $doc . "'";
                    //no utilizo la consulta por que hay docentes q dan la misma materia en diferentes paralelos                    

                    $var1 = ArrayHelper::map(Docente::find()->where(['ESTADO_DOC' => 1])->orderBy('APELLIDOS_DOC asc')->all(), 'CEDULA_DOC', function ($model_docent) {
                                return $model_docent['NOMBRES_DOC'] . ' ' . $model_docent['APELLIDOS_DOC'];
                            });

                    echo $form->field($model_docent, 'CEDULA_DOC')
                            ->widget(Select2::classname(), [
                                'items' => $var1,
                                'options' => ['placeholder' => 'Seleccionar ...'],
                                    ]
                    );

                    //fin el docente
                    ?>  

                    <?php
                    $paralelos_creados = array();
                    $model_paralelos = AsigDocPer::findBySql("SELECT
                            c.PARALELO
                            FROM `asig_doc_per` AS c
                           WHERE c.ID_CAR = '" . $car . "' AND c.ID_SEM = '" . $sem . "' AND "
                                    . "c.ID_PER = '" . $per . "' AND c.`CODIGO_ASIG`='" . $asig . "'")->all();
                    foreach ($model_paralelos as $mp) {
                        if ($par != $mp->PARALELO)
                            $paralelos_creados[$mp->PARALELO] = $mp->PARALELO;
                    }
                    $paralelos = array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D');
                    $paralelos_disponibles = array_diff($paralelos, $paralelos_creados);
                    echo $form->field($model_docent, 'PARALELO')
                            ->widget(Select2::classname(), [
                                'items' => $paralelos_disponibles,
                                'options' => ['placeholder' => 'Seleccionar ...'],
                                    ]
                    );
                    ?> 

                </div>
            </div>
        </div>
    </div>
    
    <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
        <?= Html::submitButton('Guardar', ['id' => 'btnUpdate', 'class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
