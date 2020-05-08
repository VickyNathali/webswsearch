<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Iniciar sesión';
$this->params['breadcrumbs'][] = $this->title;
?>

<style> 
    .example1 {
        border: 2px black #ffffff;
        padding: 10px;
        border-radius: 0.5rem;       
    }

</style>

<div class="row text-center">
<!--    <h1><?= Html::encode($this->title) ?></h1>
 

    <!--logo-->
    <br>
    <div class="img-responsive">
        <center> 
            <img src="<?= \Yii::$app->request->BaseUrl; ?>/imagenes/logo.jpg" alt="Logo SwSearch" />
        </center> 
        <br>
        Por favor complete los siguientes campos
    </div>

    <!--logo-->

    <?php
    $form = ActiveForm::begin([
                'id' => 'login-form',
//                'layout' => 'horizontal',
                'fieldConfig' => [
//                    'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
//                    'labelOptions' => ['class' => 'col-lg-1 control-label'],
                ],
    ]);
    ?>
    <div id="tabla1">        
        <div class="img-responsive">
            <center> 
                <img src="<?= \Yii::$app->request->BaseUrl; ?>/imagenes/user.png" alt="Iniciar sesion" />
            </center>                  
        </div>
        <center><h3><b>Iniciar sesión</b></h3></center>
        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'example1', 'placeholder' => 'Usuario'])->label('<i class="glyphicon glyphicon-user"></i>') ?>
       <?= $form->field($model, 'password')->passwordInput(['class' => 'example1', 'placeholder' => 'Contraseña'])
           ->label('<span onclick="mostrarPassword()" class="glyphicon glyphicon-lock" title="Mostrar/ocultar contraseña" </span>')
        ?>
        <div class="form-group">            
        <?= Html::submitButton('Entrar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>         
        </div>

    </div><br>
    <script>
        function mostrarPassword() {
            var cambio = document.getElementById("loginform-password");
            if (cambio.type == "password") {
                cambio.type = "text";
                $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
            } else {
                cambio.type = "password";
                $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
            }
        }

    </script>
<?php ActiveForm::end(); ?>

</div>