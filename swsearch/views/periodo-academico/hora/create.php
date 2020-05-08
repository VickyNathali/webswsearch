<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Hora */

$this->title = 'Crear hora';
$this->params['breadcrumbs'][] = ['label' => 'Horas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hora-create">

    <b><h1 style="font-family:Trebuchet MS;"><?= Html::encode($this->title) ?></h1></b><br>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
