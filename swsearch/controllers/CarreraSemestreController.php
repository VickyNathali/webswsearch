<?php

namespace app\controllers;

use Yii;
use app\models\Carrera;
use app\models\Semestre;
use app\models\CarreraSemestre;
use app\models\CarreraSemestreSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CarreraSemestreController implements the CRUD actions for CarreraSemestre model.
 */
class CarreraSemestreController extends Controller {

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
                            'listar_sem_carrera'
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
     * Lists all CarreraSemestre models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new CarreraSemestreSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    //funcion utilizada en _form de carsem-asig-per
    public function actionListar_sem_carrera($id) {
        $session = Yii::$app->session;
        $session['id_carrera'] = $id;

        $semestres = CarreraSemestre::find()->where(['ID_CAR' => $id,'ESTADO_CARSEM'=>1])->all();
        foreach ($semestres as $sem)
            echo "<option value = '" . $sem->ID_SEM . "'>" . $sem->sEM->DESCRIPCION_SEM . "</option>";
    }

    /**
     * Displays a single CarreraSemestre model.
     * @param integer $ID_SEM
     * @param integer $ID_CAR
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($ID_SEM, $ID_CAR) {
        return $this->render('view', [
                    'model' => $this->findModel($ID_SEM, $ID_CAR),
        ]);
    }

    /**
     * Creates a new CarreraSemestre model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new CarreraSemestre();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID_SEM' => $model->ID_SEM, 'ID_CAR' => $model->ID_CAR]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing CarreraSemestre model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $ID_SEM
     * @param integer $ID_CAR
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($ID_SEM, $ID_CAR) {
        $model = $this->findModel($ID_SEM, $ID_CAR);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID_SEM' => $model->ID_SEM, 'ID_CAR' => $model->ID_CAR]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CarreraSemestre model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $ID_SEM
     * @param integer $ID_CAR
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($ID_SEM, $ID_CAR) {
        $this->findModel($ID_SEM, $ID_CAR)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CarreraSemestre model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $ID_SEM
     * @param integer $ID_CAR
     * @return CarreraSemestre the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID_SEM, $ID_CAR) {
        if (($model = CarreraSemestre::findOne(['ID_SEM' => $ID_SEM, 'ID_CAR' => $ID_CAR])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }

}
