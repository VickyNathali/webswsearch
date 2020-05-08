<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Asignatura */

$this->title = 'Crear asignatura';
$this->params['breadcrumbs'][] = ['label' => 'Asignaturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asignatura-create">

    <b><h1 style="font-family:Trebuchet MS;"><?= Html::encode($this->title) ?></h1></b><br>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
