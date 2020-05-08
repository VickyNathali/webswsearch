<?php

namespace app\controllers;

use Yii;
use app\models\Docente;
use app\models\DocenteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile; //Para subir fotos
use Mpdf\Mpdf;

/**
 * DocenteController implements the CRUD actions for Docente model.
 */
class DocenteController extends Controller {

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
                            'delete_doc',
                            'listar',
                            'listar_pdf',
                            'buscar_docente_por_cedula'
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
     * Lists all Docente models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new DocenteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Docente model.
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
     * Creates a new Docente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Docente();
        $model->ESTADO_DOC = 1; //afuera de post xq si se presenta la opcion de escoger en la vista _form CASO CONTRARIO: poner dentro de post       

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->CEDULA_DOC]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Docente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->CEDULA_DOC]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Docente model.
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
    public function actionDelete_doc($id) {
        $estado = Docente::findOne(['CEDULA_DOC' => $id]);
        $estado->ESTADO_DOC = '3';
        $estado->save();
        return $this->redirect(['index']);
    }
    
    public function actionListar() {
        //$modelo_usuarios = Usuario::model()->findAllBySql('select * from usuario order by APELLIDOS_USU');
        $modelo_docentes = Docente::find()->orderBy('APELLIDOS_DOC asc')->all();
        return $this->render('listar', [
                    'modelo_docentes' => $modelo_docentes,
        ]);
    }

    //++ función de descargar pdf de listar carreras ++
    public function actionListar_pdf() {
        $sql = "select * from docente order by APELLIDOS_DOC asc";
        $docentes = Docente::findBySql($sql)->all();
        $mpdf = new mPDF ();
        $mpdf->SetTitle("Lista de docentes");
        $mpdf->SetAuthor("FIE-ESPOCH");
        $mpdf->showWatermarkText = true;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($this->renderPartial('listar_pdf', array(
                    'docentes' => $docentes,
                        ), true));
        $mpdf->Output('Lista de docentes ' . date('Y-m-d') . '.pdf', 'I');
        exit();
    }

    //funcion para buscar la existencia de un docente
    public function actionBuscar_docente_por_cedula() {
        // El administrador ingresa la cédula del docente y busca si existe en la base de datos
        $cedula_docente = $_POST['docente'];
        $docente = Docente::findBySql("SELECT 
                    * FROM docente as doc            
                    WHERE doc.CEDULA_DOC ='" . $cedula_docente . "' limit 1")->one();
//        if(isset($docente->NOMBRES_DOC)){
//           $var1 = $docente->NOMBRES_DOC;
//        }
//        else{
//            $var1 = 'no existe';
//        }
        return json_encode($docente->NOMBRES_DOC);
    }

    /**
     * Finds the Docente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Docente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Docente::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }

}
