<?php

namespace app\controllers;

use Yii;
use app\models\PeriodoAcademico;
use app\models\PeriodoAcademicoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PeriodoAcademicoController implements the CRUD actions for PeriodoAcademico model.
 */
class PeriodoAcademicoController extends Controller {

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
                            'delete_per',
                            'listar'
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
     * Lists all PeriodoAcademico models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PeriodoAcademicoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PeriodoAcademico model.
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
     * Creates a new PeriodoAcademico model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PeriodoAcademico();
       
        if ($model->load(Yii::$app->request->post())) { 
            $model->ESTADO_PER = 1; ////ACTIVO=1 INACTIVO=0, está adentro por que no se muestra la opcion en interfaz _form      
            if ($model->save()) {
                //colocar estado inactivo (0) al periodo actualmente activo
                $periodo_ant = PeriodoAcademico::findBySql("SELECT * FROM periodo_academico AS per 
                WHERE per.ESTADO_PER = 1")->one();               
                $periodo_ant->ESTADO_PER = 0;
                $periodo_ant->save();
                //--------------------------------------------------------------              
                return $this->redirect(['view', 'id' => $model->ID_PER]);
            }
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing PeriodoAcademico model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID_PER]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PeriodoAcademico model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    //eliminado lógico de administradores
    public function actionDelete_per($id) {
        $estado = PeriodoAcademico::findOne(['ID_PER' => $id]);
        $estado->ESTADO_PER = 3; //eliminada
        $estado->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the PeriodoAcademico model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PeriodoAcademico the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PeriodoAcademico::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }

}
