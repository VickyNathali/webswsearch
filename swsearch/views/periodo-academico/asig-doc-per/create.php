<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AsigDocPer */

$this->title = 'Crear Asig Doc Per';
$this->params['breadcrumbs'][] = ['label' => 'Asig Doc Pers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asig-doc-per-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
