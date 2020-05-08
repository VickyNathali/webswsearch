<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Carrera */

$this->title = 'Crear carrera';
$this->params['breadcrumbs'][] = ['label' => 'Carreras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carrera-create">
    <b><h1 style="font-family:Trebuchet MS;"> <?= Html::encode($this->title) ?></h1></b><br>
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
