<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use app\models\Persona;
use app\models\Administrador;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\assets\DashboardAsset;
use pceuropa\menu\Menu;

DashboardAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<style>
    .centrado{
        margin:-20px auto;
        display:block;
    }
    .my-navbar {
        background-color: #000215;
    }
</style>

<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <link rel="shortcut icon" type="image/x-icon" href="<?= \Yii::$app->request->BaseUrl ?>/logo.ico">
        <?php $this->head() ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <?php $this->beginBody() ?> 
        <!--condicion para ver si muestro el menu o el inicia sesion-->
        <?php
        $session = Yii::$app->session;
        if (isset($session['estado_adm_swsearch']) && isset(Yii::$app->user->identity->CEDULA_PER)) {
            //en caso de q exista una session no se pone nada xq ya tiene el menú en wrapper 
        } else {
            //pongo navbar para q inicie sesion
            echo "<br><br>";
            NavBar::begin([
                'brandLabel' => '<img src="' . Yii::$app->homeUrl . '/imagenes/logosw.png" class="centrado" style="display:inline; vertical-align:top; height:65px;"> SwSearch',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
        }
        $session = Yii::$app->session;
        if (isset($session['estado_adm_swsearch']) && isset(Yii::$app->user->identity->CEDULA_PER)) {
            if ($session['estado_adm_swsearch'] == 1) {
                ?>
                <!--en caso de q exista una cedula a la sesion se le asigna el valor 1:activo-->
                <!--wrapper para el cual se dibuja cuando este una sesion iniciada-->
                <div class="wrapper"> 
                    <header class="main-header">
                        <!-- Logo izquierda -->
                        <a href="<?= Yii::$app->homeUrl; ?>" class="logo">
                            <!-- mini logo para sidebar mini 50x50 pixels -->
                            <span class="logo-mini">
                                <img src="<?= \Yii::$app->request->BaseUrl; ?>/imagenes/logo_sin_fondo.png" alt="Logo SwSearch" class="centrado" style="display:inline; vertical-align:top; height:50px;"/>
                            </span>
                            <!-- logo for estado regular -->
                            <span class="logo-lg">
                                <img src="<?= \Yii::$app->request->BaseUrl; ?>/imagenes/logo_sin_fondo.png" alt="Logo SwSearch" class="centrado" style="display:inline; vertical-align:top; height:50px;"/>SwSearch
                            </span>
                        </a>
                        <!-- Header Navbar: style can be found in header.less -->
                        <nav class="navbar navbar-static-top">
                            <!-- Para guardar menú de la izquiera y tener panatalla completa-->
                            <a href="#" class="sidebar-toggle" data-toggle="push-menu" title="Navegación del menú" role="button">
                                <span class="sr-only"></span>
                            </a>
                            <div class="navbar-custom-menu">
                                <ul class="nav navbar-nav">
                                    <!-- Cuenta de usuario en la cabecera -->
                                    <li class="dropdown user user-menu">
                                        <a id="perfil_usuario" href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <?php
                                            if (isset(Yii::$app->user->identity->CEDULA_PER)) {
                                                $modelo = Persona::find()->where(['CEDULA_PER' => Yii::$app->user->identity->CEDULA_PER])->one();
                                                $modelo_administrador = Administrador::find()->where(['CEDULA_PER' => Yii::$app->user->identity->CEDULA_PER])->one();

                                                if ($modelo->FOTO_PER != false) {
                                                    echo Html::img('@web/imagenes/Fotos/' . $modelo->FOTO_PER, ['height' => 75, 'width' => 80, 'class' => 'user-image', 'alt' => 'Imagen de usuario']);
                                                } else {
                                                    echo Html::img('@web/imagenes/Fotos/sin_imagen.jpg', ['height' => 75, 'width' => 80, 'class' => 'user-image']);
                                                }
                                                ?>
                                                <span class="hidden-xs"><?php
                                                    echo $modelo->USUARIO_PER;
                                                }
                                                ?></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <!-- Imagen del que esta logeado y acceso a perfil y salir-->
                                            <li class="user-header">
                                                <?php
                                                if (isset(Yii::$app->user->identity->CEDULA_PER)) {
                                                    $modelo = Persona::find()->where(['CEDULA_PER' => Yii::$app->user->identity->CEDULA_PER])->one();
                                                    $modelo_administrador = Administrador::find()->where(['CEDULA_PER' => Yii::$app->user->identity->CEDULA_PER])->one();

                                                    if ($modelo->FOTO_PER != false) {
                                                        echo Html::img('@web/imagenes/Fotos/' . $modelo->FOTO_PER, ['height' => 75, 'width' => 80, 'class' => 'img-circle', 'alt' => 'Imagen de usuario']);
                                                    } else {
                                                        echo Html::img('@web/imagenes/Fotos/sin_imagen.jpg', ['height' => 75, 'width' => 80, 'class' => 'img-circle']);
                                                    }
                                                    ?>
                                                    <p>
                                                        <?php
                                                        echo $modelo->NOMBRES_PER . ' ' . $modelo->APELLIDOS_PER;
                                                        echo"<br>";
                                                        echo $modelo_administrador->CARGO_ADM;
                                                    }
                                                    ?>
                                                    <small>Hora: <?= date('H:i a') ?> Fecha:<?= date('d-F-Y') ?></small>                                           
                                                </p>
                                            </li> 
                                            <!-- Ver perfil y salir del sistema -->
                                            <li class="user-footer">
                                                <div class="pull-left">
                                                    <?php
                                                    if (isset(Yii::$app->user->identity->CEDULA_PER)) {
                                                        $modelo = Persona::find()->where(['CEDULA_PER' => Yii::$app->user->identity->CEDULA_PER])->one();
                                                        echo Html::a('Perfil', ['persona/view', 'id' => $modelo->CEDULA_PER], ['class' => 'btn btn-default btn-flat']);
                                                    }
                                                    ?> 
                                                </div>
                                                <div class="pull-right">
                                                    <!--<a class="btn btn-default btn-flat">-->
                                                    <?=
                                                    Html::a(
                                                            'Salir', ['/site/logout'], ['data-method' => 'post', 'class' => 'btn btn-default btn-flat float-right']
                                                    )
                                                    ?>
                                                    <?php
//                                            echo Nav::widget([
//                                                'options' => ['class' => ''],
//                                                'items' => [
//                                                    Yii::$app->user->isGuest ? (
//                                                            ['label' => 'Iniciar sesión', 'url' => ['/site/login']]
//                                                            ) : (
//                                                            '<li>'
//                                                            . Html::beginForm(['/site/logout'], 'post')
//                                                            . Html::submitButton(
//                                                                    'Salir', ['class' => 'btn btn-default btn-flat']
//                                                            )
//                                                            . Html::endForm()
//                                                            . '</li>'
//                                                            )
//                                                ],
//                                            ]);
                                                    ?>
                                                    <!--Cerrar sesión</a>-->
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                    <!-- Administración de la página (agregar otros usuarios) -->
                                    <li>
                                        <a href="<?= Yii::$app->homeUrl ?>persona/index" title="Administración">
                                            <i class="fa fa-gears fa-spin fa-1x fa-fw" aria-hidden="true"></i>
                                        </a>
                                            <!--<a href="persona/index" title="Administración"><i class="fa fa-gears"></i> </a>-->
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </header>            
                    <aside class="main-sidebar">
                        <!-- sidebar: style can be found in sidebar.less -->
                        <section class="sidebar">
                            <!-- Sidebar user panel -->
                            <div class="user-panel">
                                <div class="pull-left image">
                                    <?php
                                    if (isset(Yii::$app->user->identity->CEDULA_PER)) {
                                        $modelo = Persona::find()->where(['CEDULA_PER' => Yii::$app->user->identity->CEDULA_PER])->one();

                                        if ($modelo->FOTO_PER != false) {
                                            echo Html::img('@web/imagenes/Fotos/' . $modelo->FOTO_PER, ['height' => 60, 'width' => 60, 'class' => 'img-circle', 'alt' => 'Imagen de usuario']);
                                        } else {
                                            echo Html::img('@web/imagenes/Fotos/sin_imagen.jpg', ['height' => 60, 'width' => 60, 'class' => 'img-circle']);
                                        }
                                        ?>
                                    </div>
                                    <div class="pull-left info">
                                        <p>
                                            <?php
                                            echo $modelo->NOMBRES_PER;
                                        }
                                        ?>
                                    </p>
                                    <a href="#"><i class="fa fa-circle text-success"></i> En linea</a>
                                </div>
                            </div>

                            <!-- sidebar menu: : style can be found in sidebar.less -->
                            <ul class="sidebar-menu" data-widget="tree">
                                <li class="header">Menú principal</li>

                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-edit"></i> <span>Gestión</span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="<?= Yii::$app->homeUrl ?>carsem-asig-per/index"><i class="fa fa-circle"></i> Horarios</a></li>
                                        <li><a href="<?= Yii::$app->homeUrl ?>asignatura/index"><i class="fa fa-circle"></i> Asignaturas</a></li>
                                        <li><a href="<?= Yii::$app->homeUrl ?>aula-laboratorio/index"><i class="fa fa-circle"></i> Aulas - laboratorios</a></li>
                                        <li><a href="<?= Yii::$app->homeUrl ?>docente/index"><i class="fa fa-circle"></i> Docentes</a></li>
                                        <li><a href="<?= Yii::$app->homeUrl ?>periodo-academico/index"><i class="fa fa-circle"></i> Períodos académicos</a></li>
                                        <li class="treeview">
                                            <a href="#"><i class="fa fa-circle-o"></i> OTROS
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a>
                                            <ul class="treeview-menu">
                                                <li><a href="<?= Yii::$app->homeUrl ?>carrera/index"><i class="fa fa-circle"></i> Carreras</a></li>
                                                <li><a href="<?= Yii::$app->homeUrl ?>semestre/index"><i class="fa fa-circle"></i> Semestres</a></li>
                                                <li><a href="<?= Yii::$app->homeUrl ?>hora/index"><i class="fa fa-circle"></i> Horas de clase</a></li> 

                                            </ul>
                                        </li>

                                    </ul>
                                </li>

                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-files-o"></i> <span>Listados</span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="<?= Yii::$app->homeUrl ?>persona/listar"><i class="fa fa-circle"></i> Usuarios</a></li>
                                        <li><a href="<?= Yii::$app->homeUrl ?>asignatura/listar"><i class="fa fa-circle"></i> Asignaturas</a></li>
                                        <li><a href="<?= Yii::$app->homeUrl ?>aula-laboratorio/listar"><i class="fa fa-circle"></i> Aulas-Laboratorios</a></li>
                                        <li><a href="<?= Yii::$app->homeUrl ?>carrera/listar"><i class="fa fa-circle"></i> Carreras</a></li>
                                        <li><a href="<?= Yii::$app->homeUrl ?>docente/listar"><i class="fa fa-circle"></i> Docentes</a></li>
                                        <li><a href="<?= Yii::$app->homeUrl ?>asig-doc-per/listar"><i class="fa fa-circle"></i> Asignaturas-docentes</a></li>
                                        <li><a href="<?= Yii::$app->homeUrl ?>dia-aula-hora/listar"><i class="fa fa-circle"></i> Horarios</a></li>                                
                                    </ul>
                                </li>
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-pie-chart"></i>
                                        <span>Reportes</span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">                                       
                                        <li><a href="<?= Yii::$app->homeUrl ?>dia-aula-hora/rep_asig_aulas"><i class="fa fa-circle"></i> Asignación de aulas</a></li>
                                        <li><a href="<?= Yii::$app->homeUrl ?>asig-doc-per/rep_asig_doc"><i class="fa fa-circle"></i> Asignación de docentes</a></li>

                                    </ul>
                                </li>

                                <li>                                   
                                    <a href="<?= Yii::$app->homeUrl ?>estudiante/index" title="">
                                        <i class="fa fa-user"></i>
                                        <span>Activar estudiante</span>                                        
                                    </a>
                                </li>                                
<!--                                <li>                                 
                                    <a href="https://adminlte.io/docs" target="_blank">
                                        <i class="fa fa-book"></i> 
                                        <span>Manual de usuario</span>
                                    </a>
                                </li>-->
                                <li class="header">Etiquetas</li> 
                                <li>
                                    <a href="<?= Yii::$app->homeUrl ?>estudiante/index" title="">
                                       <i class="fa fa-circle-o text-green"></i> 
                                        <span>Información</span>
                                    </a>
                                </li>
                            </ul>
                        </section>
                        <!-- /.sidebar -->
                    </aside>
                    <div class="content-wrapper">
                        <!-- Carrusel -->
                        <!--<section class="content-header"> </section>-->
                        <div id="carousel" class="carousel slide carousel-fade" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carousel" data-slide-to="0" class="active"></li>
                                <li data-target="#carousel" data-slide-to="1"></li>
                                <li data-target="#carousel" data-slide-to="2"></li>
                            </ol>
                            <!-- Carousel items -->
                            <div class="carousel-inner">
                                <div class="active item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                            </div>
                            <!-- Left and right controls -->
                            <a class="left carousel-control" href="#carousel" data-slide="prev">
                                <!--<span class="glyphicon glyphicon-chevron-left"></span>-->
                                <span class="sr-only">Anterior</span>
                            </a>
                            <a class="right carousel-control" href="#carousel" data-slide="next">
                                <!--<span class="glyphicon glyphicon-chevron-right"></span>-->
                                <span class="sr-only">Siguiente</span>
                            </a>
                        </div>
                        <!-- Main content -->
                        <section class="content">                   
                            <?= $content ?>
                        </section>
                    </div>

                </div>
                <!--cierro los dos if (identity cedula y el se la sesion, caso contrario llamo a login-->
                <?php
            }
        } else {
            if (isset(Yii::$app->user->identity->USUARIO_PER)) {
                Yii::$app->user->logout();
            };
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    Yii::$app->user->isGuest ? (
                            ['label' => 'Iniciar sesión', 'url' => ['/site/login']]
                            ) : (
                            '<li>'
                            . Html::beginForm(['/site/logout'], 'post')
                            . Html::submitButton(
                                    'Salir (' . Yii::$app->user->identity->USUARIO_PER . ')', ['class' => 'btn btn-link logout']
                            )
                            . Html::endForm()
                            . '</li>'
                            )
                ],
            ]);
            //************************************************************************
            NavBar::end();
            ?>    
            <!--el else es para el login sin slider izquierdo-->
            <div class="wrapper1"> 
                <!-- Carrusel -->                
                <div id="carousel" class="carousel slide carousel-fade" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel" data-slide-to="1"></li>
                        <li data-target="#carousel" data-slide-to="2"></li>
                    </ol>
                    <!-- Carousel items -->
                    <div class="carousel-inner">
                        <div class="active item"></div>
                        <div class="item"></div>
                        <div class="item"></div>
                    </div>
                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#carousel" data-slide="prev">
                        <!--<span class="glyphicon glyphicon-chevron-left"></span>-->
                        <span class="sr-only">
                            Antrerior</span>
                    </a>
                    <a class="right carousel-control" href="#carousel" data-slide="next">
                        <!--<span class="glyphicon glyphicon-chevron-right"></span>-->
                        <span class="sr-only">Siguiente</span>
                    </a>
                </div>
                <!-- Main content -->
                <section class="container">                   
                    <?= $content ?>
                </section>
            </div>
        <?php } ?>        

        <!--footer del aplicativo-->
        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; FIE - ESPOCH <?= date('Y') ?></p>                
                <?= $session['estado_adm_swsearch'] ?>
                <p class="pull-right">Desarrollado por VA</p>
            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
