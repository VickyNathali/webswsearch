<?php

namespace app\controllers;

use Yii;
use app\models\Semestre;
use app\models\SemestreSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * SemestreController implements the CRUD actions for Semestre model.
 */
class SemestreController extends Controller {

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
                            'delete_sem',
                            'buscar_sem_por_despn'
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
     * Lists all Semestre models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new SemestreSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Semestre model.
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
     * Creates a new Semestre model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Semestre();
        $model->ESTADO_SEM = 1; //afuera de post xq si se presenta la opcion de escoger en la vista _form CASO CONTRARIO: poner dentro de post       

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID_SEM]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    //funcion para buscar la existencia de un semestre
    public function actionBuscar_sem_por_despn() {
        // El administrador ingresa la descripcion del semestre y busca si existe en la base de datos
        $descrip_sem = $_POST['descripcion'];
        $semestre = Semestre::findBySql("SELECT 
                    * FROM dia            
                    WHERE dia.DESCRIPCION_SEM ='" . $descrip_sem . "' limit 1")->one();
        return json_encode($semestre->DESCRIPCION_SEM);
    }

    /**
     * Updates an existing Semestre model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID_SEM]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Semestre model.
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
    public function actionDelete_sem($id) {
        $estado = Semestre::findOne(['ID_SEM' => $id]);
        $estado->ESTADO_SEM = 3; //eliminada
        $estado->save();
        return $this->redirect(['index']);
    }
    /**
     * Finds the Semestre model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Semestre the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Semestre::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }

}
