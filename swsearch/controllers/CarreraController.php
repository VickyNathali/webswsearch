<?php

namespace app\controllers;

use Yii;
use app\models\Carrera;
use app\models\CarreraSemestre;
use app\models\CarsemAsigPer;
use app\models\Semestre;
use app\models\CarreraSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Mpdf\Mpdf;

/**
 * CarreraController implements the CRUD actions for Carrera model.
 */
class CarreraController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true, // Esta propiedad establece que tiene permisos
                        'actions' => [
                            'view',
                            'create',
                            'index',
                            'update',
                            'delete',
                            'listar',
                            'listar_pdf',
                            'buscar_car_por_nombre',
                            'delete_logico'
                        ], // El administrador tiene permisos sobre las siguientes acciones
                        // Este método nos permite crear un filtro sobre la identidad del usuario
                        // y así establecer si tiene permisos o no
                        'matchCallback' => function ($rule, $action) {
                            $session = Yii::$app->session;
                            $var1 = $session['estado_adm_swsearch'];
                            $var2 = "1";  //var_dump($var1); exit();                             
                            return ($var1 === $var2);
                        }
                    ],
                ]
            ],
            // Controla el modo en que se accede a las acciones, en este ejemplo a la acción logout
            // sólo se puede acceder a través del método post
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => [
                        'post'
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Carrera models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new CarreraSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Carrera model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Carrera model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Carrera();
        $model->ESTADO_CAR = 1; //ACTIVA=1 INACTIVO=0, 
        if ($model->load(Yii::$app->request->post())) {
           if ($model->save()) {
                $n = $model->DURACION_CAR + 1;
                $semestre = Semestre::findBySql("SELECT * 
                FROM semestre as sem WHERE 
                sem.ID_SEM < " . $n)->all();
                foreach ($semestre as $sem){
                    $model_sem = new CarreraSemestre();
                    $model_sem->ID_CAR = $model->ID_CAR;
                    $model_sem->ID_SEM = $sem->ID_SEM;
                    //$model_sem->ESTADO_CARSEM = $sem->ESTADO_SEM;
                    $model_sem->ESTADO_CARSEM = 1;
                    $model_sem->save();
                }
                return $this->redirect(['view', 'id' => $model->ID_CAR]);
            }
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //modificar estado a inactivo=0 en carrera-semestre, en caso de que modifique en carrera
            $var1 = CarreraSemestre::find()->where(['ID_CAR' => $id])->all();
            foreach ($var1 as $v) {
                $v->ESTADO_CARSEM = 0;
                $v->save();
            }
            //modificar estado a inactivo=0 en carsem-asig-per
            $estado_csap = CarsemAsigPer::find()->where(['ID_CAR' => $id])->all();
            foreach ($estado_csap as $cp) {
                $cp->ESTADO_CSAP = 0; //inactiva
                $cp->save();
            }
            //buscar los semestre existentes en tabla semestre
            $n = $model->DURACION_CAR + 1;
            $semestre = Semestre::findBySql("SELECT * 
            FROM semestre as sem WHERE 
            sem.ID_SEM < " . $n)->all();

            foreach ($semestre as $sem) {
                $sem_exist = CarreraSemestre::find()->where(['ID_CAR' => $model->ID_CAR, 'ID_SEM' => $sem->ID_SEM])->one();
                if (isset($sem_exist->ID_CAR) && isset($sem_exist->ID_SEM)) {
                    $sem_exist->ESTADO_CARSEM = $model->ESTADO_CAR;
                    $sem_exist->save();
                } else {
                    $model_sem = new CarreraSemestre();
                    $model_sem->ID_CAR = $model->ID_CAR;
                    $model_sem->ID_SEM = $sem->ID_SEM;
                    $model_sem->ESTADO_CARSEM = $sem->ESTADO_SEM;
                    $model_sem->save();
                }
            }
            //carrera-semestre        

            return $this->redirect(['view', 'id' => $model->ID_CAR]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    public function actionListar() {
        $modelo_carrera = Carrera::find()->orderBy('NOMBRE_CAR asc')->all();
        return $this->render('listar', [
                    'modelo_carrera' => $modelo_carrera,
        ]);
    }

    //++ función de descargar pdf de listar carreras ++
    public function actionListar_pdf() {
        $sql = "select * from carrera order by NOMBRE_CAR asc";
        $carrera = Carrera::findBySql($sql)->all();
        $mpdf = new mPDF ();
        $mpdf->SetTitle("Lista de carreras");
        $mpdf->SetAuthor("FIE-ESPOCH");
        $mpdf->showWatermarkText = true;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($this->renderPartial('listar_pdf', array(
                    'carrera' => $carrera,
                        ), true));
        $mpdf->Output('Lista de carreras ' . date('Y-m-d') . '.pdf', 'I');
        exit();
    }

    //funcion para buscar la existencia de una carrera
    public function actionBuscar_car_por_nombre() {
        // El administrador ingresa el nombre de la carrera y busca si existe en la base de datos
        $nombre_carrera = $_POST['carrera'];
        $carrera = Carrera::findBySql("SELECT 
                    * FROM carrera as car            
                    WHERE car.NOMBRE_CAR ='" . $nombre_carrera . "' limit 1")->one();
        return json_encode($carrera->NOMBRE_CAR);
    }

    /**
     * Updates an existing Carrera model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    /**
     * Deletes an existing Carrera model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $var1 = CarreraSemestre::find()->where(['ID_CAR' => $id])->all();
        foreach ($var1 as $v) {
            $v->delete();
        }
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    //eliminado logico de la carrera
    public function actionDelete_logico($id) {
        $estado_csap = CarsemAsigPer::find()->where(['ID_CAR' => $id])->all();
        foreach ($estado_csap as $cp) {
            $cp->ESTADO_CSAP = 3; //eliminada
            $cp->save();
        }

        $estado_carsem = CarreraSemestre::find()->where(['ID_CAR' => $id])->all();
        foreach ($estado_carsem as $c) {
            $c->ESTADO_CARSEM = 3; //eliminada
            $c->save();
        }

        $estado = Carrera::find()->where(['ID_CAR' => $id])->one();
        $estado->ESTADO_CAR = 3; //eliminada
        $estado->save();
        return $this->redirect(['index']);
    }

    //eliminado logico de la carrera

    /**
     * Finds the Carrera model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Carrera the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Carrera::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
