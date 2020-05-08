<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CarreraSemestre */

$this->title = 'Crear Carrera Semestre';
$this->params['breadcrumbs'][] = ['label' => 'Carrera Semestres', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carrera-semestre-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
