<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DiaAulaHora */

$this->title = 'Crear Dia Aula Hora';
$this->params['breadcrumbs'][] = ['label' => 'Dia Aula Horas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dia-aula-hora-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
