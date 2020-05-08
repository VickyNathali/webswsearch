<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Semestre */

$this->title = 'Crear semestre';
$this->params['breadcrumbs'][] = ['label' => 'Semestres', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="semestre-create">

    <b><h1 style="font-family:Trebuchet MS;"><?= Html::encode($this->title) ?></h1></b><br>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
