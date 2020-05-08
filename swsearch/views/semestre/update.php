<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Semestre */

$this->title = 'Modificar semestre';
$this->params['breadcrumbs'][] = ['label' => 'Semestres', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_SEM, 'url' => ['view', 'id' => $model->ID_SEM]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="semestre-update">

    <h1 style="font-family:Trebuchet MS;"><?= Html::encode($this->title) ?></h1></b><br>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
