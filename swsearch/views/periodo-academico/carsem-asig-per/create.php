<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CarsemAsigPer */

$this->title = 'Crear horario';
$this->params['breadcrumbs'][] = ['label' => 'Carsem Asig Pers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="carsem-asig-per-create">

        <b><h1 style="font-family:Trebuchet MS;"><?= Html::encode($this->title) ?></h1></b><br>
            <?=
            $this->render('_form', [
                'model' => $model,
                'band' => $band,
                'sql' => $sql,
                'sql_validar' => $sql_validar,
            ])
            ?>


    </div>
