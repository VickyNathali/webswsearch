<?php

namespace app\controllers;

use Yii;
use app\models\Dia;
use app\models\DiaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * DiaController implements the CRUD actions for Dia model.
 */
class DiaController extends Controller
{
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
//                            'view',
//                            'create',
//                            'index',
//                            'update',
//                            'delete',
//                            'listar',
//                            'buscar_dia_por_nombre'
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
     * Lists all Dia models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DiaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionListar() {
        $modelo_dia = Dia::find()->orderBy('ID_DIA asc')->all();
        return $this->render('listar', [
                    'modelo_dia' => $modelo_dia,
        ]);
    }
    
    //funcion para buscar la existencia de un día
    public function actionBuscar_dia_por_nombre() {
        // El administrador ingresa la descripcion del día y busca si existe en la base de datos
        $descrip_dia = $_POST['dia'];
        $dia= Dia::findBySql("SELECT 
                    * FROM dia            
                    WHERE dia.DESCRIPCION_DIA ='" . $descrip_dia . "' limit 1")->one();
        return json_encode($dia->DESCRIPCION_DIA);
    }

    /**
     * Displays a single Dia model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Dia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dia();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID_DIA]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Dia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID_DIA]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Dia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Dia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dia::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }
}
