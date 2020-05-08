<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dia */

$this->title = 'Crear día';
$this->params['breadcrumbs'][] = ['label' => 'Dias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dia-create">

    <b><h1 style="font-family:Trebuchet MS;"><?= Html::encode($this->title) ?></h1></b><br>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
