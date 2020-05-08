<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PeriodoAcademico */

$this->title = 'Modificar período académico';
$this->params['breadcrumbs'][] = ['label' => 'Periodo Academicos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_PER, 'url' => ['view', 'id' => $model->ID_PER]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="periodo-academico-update">

    <b><h1 style="font-family:Trebuchet MS;"><?= Html::encode($this->title) ?></h1></b><br>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
