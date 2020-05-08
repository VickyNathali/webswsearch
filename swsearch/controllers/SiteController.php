<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Persona;
use app\models\Administrador;

class SiteController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin() {
        $session = Yii::$app->session;
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $rol = Persona::find()->where(['CEDULA_PER' => Yii::$app->user->identity->CEDULA_PER])->one();
            $adm = Administrador::find()->where(['CEDULA_PER' => Yii::$app->user->identity->CEDULA_PER])->one();
            //$rol = 1 ->Activo $rol = 0 ->Inactivo $rol = 3 ->Eliminado
            if (isset($rol->TOKEN_PER) && isset($adm->CEDULA_PER)) {
                $session['estado_adm_swsearch'] = $rol->TOKEN_PER;
            }
            return $this->goHome();
        }

        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout() {
        Yii::$app->user->logout();
        if (isset($session['estado_adm_swsearch'])) {
            $session->remove('estado_adm_swsearch');
        };
        //sesiones del horario (carsem-asig-per)
        if (isset($session['id_carrera'])) {
            $session->remove('id_carrera');
        };
        if (isset($session['id_semestre'])) {
            $session->remove('id_semestre');
        };
        if (isset($session['id_periodo'])) {
            $session->remove('id_periodo');
        };
        if (isset($session['id_asignatura'])) {
            $session->remove('id_asignatura');
        };
        if (isset($session['id_docente'])) {
            $session->remove('id_docente');
        };
        if (isset($session['id_paralelo'])) {
            $session->remove('id_paralelo');
        };
        if (isset($session['id_hora'])) {
            $session->remove('id_hora');
        };
        if (isset($session['id_aula'])) {
            $session->remove('id_aula');
        };
        if (isset($session['id_dia'])) {
            $session->remove('id_dia');
        };
        // fin sesiones del horario (carsem-asig-per)
        
        // ---sesiones para reporte rep_asig_aulas (dia-hora-aula)
        if (isset($session['asig_aulas_reporte'])) {
            $session->remove('asig_aulas_reporte');
        };
        if (isset($session['aulas_periodo'])) {
            $session->remove('aulas_periodo');
        };
        
        // ---sesiones para reporte rep_asig_doc (asig-doc-per)
        if (isset($session['asig_doc_reporte'])) {
            $session->remove('asig_doc_reporte');
        };
        if (isset($session['doc_per_reporte'])) {
            $session->remove('doc_per_reporte');
        };
       
        // ---sesion para listar asignaturas - docentes (asig-doc-per)
        if (isset($session['id_asigdoc_listar'])) {
            $session->remove('id_asigdoc_listar');
        };
        if (isset($session['id_asigdoca_listar'])) {
            $session->remove('id_asigdoca_listar');
        };

        // --- sesiones para listar horarios (dia-aula-hora)
        if (isset($session['id_per_listar'])) {
            $session->remove('id_per_listar');
        };
        if (isset($session['id_car_listar'])) {
            $session->remove('id_car_listar');
        };

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }

        return $this->render('contact', [
                    'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout() {
        return $this->render('about');
    }

}
