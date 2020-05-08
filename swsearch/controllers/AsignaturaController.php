<?php

namespace app\controllers;

use Yii;
use app\models\Asignatura;
use app\models\AsignaturaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile; //Para subir pdf
use Mpdf\Mpdf; //para descargar el listado de pdf

/**
 * AsignaturaController implements the CRUD actions for Asignatura model.
 */

class AsignaturaController extends Controller {

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
                            'download',
                            'buscar_asig_por_codigo',
                            'delete_asig'
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
     * Lists all Asignatura models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AsignaturaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Asignatura model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Asignatura model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Asignatura();
        $model->ESTADO_ASIG = 1; //afuera de post xq si se presenta la opcion de escoger en la vista _form CASO CONTRARIO: poner dentro de post       
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->CODIGO_ASIG]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Asignatura model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->CODIGO_ASIG]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    // función para descargar silabo de la asignatura
    public function actionDownload($id) {
        $download = Asignatura::findOne($id);
        $path = Yii::getAlias('@webroot') . '/archivos/silabos/' . $download->SILABO_ASIG;
        if (file_exists($path)) {
            return (Yii::$app->response->sendFile($path)->send());
            exit;
        } else {
            throw new NotFoundHttpException("can't find {$download->SILABO_ASIG} file");
        }
    }

    // función para listar las asignaturas
    public function actionListar() {
        $modelo_asig = Asignatura::find()->orderBy('CODIGO_ASIG asc')->all();
        return $this->render('listar', [
                    'modelo_asig' => $modelo_asig,
        ]);
    }

    //++ función de descargar pdf de vista listar asignaturas ++
    public function actionListar_pdf() {
        $sql = "select * from asignatura order by CODIGO_ASIG asc";
        $asignaturas = Asignatura::findBySql($sql)->all();
        $mpdf = new mPDF ();
        $mpdf->SetTitle("Lista de asignaturas");
        $mpdf->SetAuthor("FIE-ESPOCH");
        $mpdf->showWatermarkText = true;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($this->renderPartial('listar_pdf', array(
                    'asignaturas' => $asignaturas,
                        ), true));
        $mpdf->Output('Lista de asignaturas ' . date('Y-m-d') . '.pdf', 'I');
        exit();
    }

    //funcion para buscar la existencia de una asignatura
    public function actionBuscar_asig_por_codigo() {
        // El administrador ingresa el código de la asignatura y busca si existe en la base de datos
        $codigo_asignatura = $_POST['asignatura'];
        $asignatura = Asignatura::findBySql("SELECT 
                    * FROM asignatura as asig            
                    WHERE asig.CODIGO_ASIG ='" . $codigo_asignatura . "' limit 1")->one();
        return json_encode($asignatura->NOMBRE_ASIG);
    }

    /**
     * Deletes an existing Asignatura model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    //eliminado logico de la asignatura
    public function actionDelete_asig($id) {
        $estado =  Asignatura::findOne(['CODIGO_ASIG' => $id]);
        $estado->ESTADO_ASIG = 3; //eliminada
        $estado->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Asignatura model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Asignatura the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Asignatura::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }

}
