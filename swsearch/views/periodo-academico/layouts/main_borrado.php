<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use pceuropa\menu\Menu;

AppAsset::register($this);
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
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
            <?php
            NavBar::begin([
                'brandLabel' => '<img src="' . Yii::$app->homeUrl . '/imagenes/logo.png" class="centrado" style="display:inline; vertical-align:top; height:65px;"> SwSearch',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $session = Yii::$app->session;
            if (isset(Yii::$app->user->identity->CEDULA_PER)) {
                if ($session['estado_adm_swsearch'] == 1) {
                    //********************* ES ADMINISTRADOR*********************************
                    echo Nav::widget([
                        'options' => ['class' => 'navbar-nav navbar-right'],
                       
                        'items' => [                           
//                            //*----* GESTIÓN DE INGRESOS
//                            ['label' => 'INGRESOS', 'items' => [
//                                    ['label' => 'Asignatura', 'url' => ['/asignatura/create']],
//                                    ['label' => 'Aula o laboratorio', 'url' => ['/aula-laboratorio/create']],
//                                    ['label' => 'Docente', 'url' => ['/docente/create']],
//                                    ['label' => 'Planificación', 'url' => ['/planificacion/create']],
//                                    ['label' => 'Horario', 'url' => ['/horario/crear']],
//                                    //tercer nivel submenu
//                                    [
//                                        'label' => 'OTROS',
//                                        'itemsOptions' => ['class' => 'dropdown-submenu'],
//                                        'submenuOptions' => ['class' => 'dropdown-menu'],
//                                        'items' => [
//                                            ['label' => 'Período académico', 'url' => ['/periodo-academico/create']],
//                                            ['label' => 'Carrera', 'url' => ['/carrera/create']],
//                                            ['label' => 'Semestre', 'url' => ['/semestre/create']],
//                                            ['label' => 'Día', 'url' => ['/dia/create']],
//                                            ['label' => 'Hora', 'url' => ['/hora/create']],
//                                        ],
//                                    ],
//                                //tercer nivel submenu
//                                ],
//                            ],
                            //*----* GESTIÓN DE  BUSCAR
                            ['label' => 'Gestión',
//                                    'options' => ['class' => '.nav nav-tabs'],
                                    'items' => [
                                    ['label' => 'Horario', 'url' => ['/carsem-asig-per/index']],
                                    ['label' => 'Asignatura', 'url' => ['/asignatura/index']],
                                    ['label' => 'Aulas - laboratorios', 'url' => ['/aula-laboratorio/index']],
                                    ['label' => 'Docentes', 'url' => ['/docente/index']],
                                    ['label' => 'Período académico', 'url' => ['/periodo-academico/index']],
                                    //tercer nivel submenu
                                    [
                                        'label' => 'OTROS',
                                        'itemsOptions' => ['class' => 'dropdown-submenu'],
                                        'submenuOptions' => ['class' => 'dropdown-menu'],
                                        'items' => [
                                            ['label' => 'Carrera', 'url' => ['/carrera/index']],
                                            ['label' => 'Semestre', 'url' => ['/semestre/index']],
                                            ['label' => 'Horas de clase', 'url' => ['/hora/index']],
                                        ],
                                    ],
                                //tercer nivel submenu
                                ],
                            ],
                            //*----* GESTIÓN DE  LISTAR
                            ['label' => 'Listas',
//                                    'options' => ['class' => 'glyphicon glyphicon-list-alt'],
                                    'items' => [
                                    ['label' => 'Usuarios', 'url' => ['/persona/listar']],
                                    ['label' => 'Asignaturas', 'url' => ['/asignatura/listar']],
                                    ['label' => 'Aulas y Laboratorios', 'url' => ['/aula-laboratorio/listar']],
                                    ['label' => 'Carreras', 'url' => ['/carrera/listar']],
                                    ['label' => 'Docentes', 'url' => ['/docente/listar']],
                                    ['label' => 'Asignatura-docentes', 'url' => ['/asig-doc-per/listar']],
                                    ['label' => 'Horarios', 'url' => ['/dia-aula-hora/listar']],
                                ],
                            ],
                            //*----* GESTIÓN DE  REPORTES
                            ['label' => 'Reportes',
//                                'options' => ['class' => 'glyphicon glyphicon-stats'],
                                    'items' => [
                                    ['label' => 'Usarios por aplicativo', 'url' => ['/persona/rep_usuarios']],
                                    ['label' => 'Asignación de aulas', 'url' => ['/dia-aula-hora/rep_asig_aulas']],
                                    ['label' => 'Asignación de docentes', 'url' => ['/asig-doc-per/rep_asig_doc']],
                                ],
                            ],
                             //*----* GESTIÓN DE ADMINISTRADOR
                            ['label' => 'Administración',
//                                'options' => ['class' => 'glyphicon glyphicon-user'],
                                     'url' => ['/persona/index'],
                                     
                            ],
                            //---- INICIAR SESION
                            Yii::$app->user->isGuest ? (
                                    ['label' => 'Iniciar sesión', 'url' => ['/site/login']]
                                    ) : (
                                    '<li>'
                                    . Html::beginForm(['/site/logout'], 'post')
                                    . Html::submitButton(
                                            '[' . Yii::$app->user->identity->USUARIO_PER . '] '. Html::img(Yii::$app->homeUrl.'imagenes/iconos/uplog.png') .'', ['class' => 'btn btn-link logout']
                                    )                                    
                                    . Html::endForm()
                                    . '</li>'
                                    )
                        ],
                    ]);

                    //************************************************************************
                }
                if (!isset($session['estado_adm_swsearch'])) {
                    //********************* ES VISITANTE*********************************
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
                }
            } else {
                //*************************************************************************
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-right'],
                    'items' => [
//                        ['label' => 'Inicio', 'url' => ['/site/index']],
//                        ['label' => 'Acerca de', 'url' => ['/site/about']],
//                        ['label' => 'Contactos', 'url' => ['/site/contact']],
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
            }
            NavBar::end();
            ?>
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
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Anterior</span>
                </a>
                <a class="right carousel-control" href="#carousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Siguiente</span>
                </a>
            </div>

            <div class="container">
                <?php
//            Breadcrumbs::widget([
//                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
//            ]) 
                ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; FIE - ESPOCH <?= date('Y') ?></p>

                <p class="pull-right">Desarrollado por Vicky Arrobo</p>
            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
