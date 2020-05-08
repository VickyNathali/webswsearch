<?php

namespace app\controllers;

use Yii;
use app\models\AulaLaboratorio;
use app\models\AulaLaboratorioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile; //Para subir fotos
use Mpdf\Mpdf;

/**
 * AulaLaboratorioController implements the CRUD actions for AulaLaboratorio model.
 */
class AulaLaboratorioController extends Controller {

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
                            'delete_aul',
                            'listar',
                            'listar_pdf',
                            'buscar_aula_por_nombre'
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
     * Lists all AulaLaboratorio models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AulaLaboratorioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AulaLaboratorio model.
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
     * Creates a new AulaLaboratorio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new AulaLaboratorio();
        $model->ESTADO_AUL = 1; //ACTIVA=1 INACTIVO=0 afuera de post xq si se presenta la opcion de escoger en la vista _form   
        if ($model->load(Yii::$app->request->post())) {

            //Subiendo Fotos de aulas o laboratorios
            $model->FOTO_AUL = UploadedFile::getInstance($model, 'FOTO_AUL');
            if ($model->FOTO_AUL && $model->validate()) {
                // $model->FOTO_AUL->saveAs('imagenes/aulas/' . $model->FOTO_AUL->baseName . '.' . $model->FOTO_AUL->extension);
                $image_name = $model->NOMBRE_AUL . rand(1, 4000) . '.' . $model->FOTO_AUL->extension;
                $image_path = 'imagenes/aulas/' . $image_name;
                $model->FOTO_AUL->saveAs($image_path);
                $model->FOTO_AUL = $image_name; //en la base de datos guarda el nombre del aula con un número aleatorio (Juan1256)
            } // Fin subiendo fotos de aulas o laboratorios

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->ID_AUL]);
            }
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing AulaLaboratorio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $foto_aula = $model->FOTO_AUL;

        if ($model->load(Yii::$app->request->post())) {
            
            //Subiendo Foto
            $model->FOTO_AUL = UploadedFile::getInstance($model, 'FOTO_AUL');
            if ($model->FOTO_AUL && $model->validate()) {
                // $model->FOTO_AUL->saveAs('imagenes/aulas/' . $model->FOTO_AUL->baseName . '.' . $model->FOTO_AUL->extension);
                $image_name = $model->NOMBRE_AUL . rand(1, 4000) . '.' . $model->FOTO_AUL->extension;
                $image_path = 'imagenes/aulas/' . $image_name;
                $model->FOTO_AUL->saveAs($image_path);
                $model->FOTO_AUL = $image_name; //en la base de datos guarda el nombre del aula con un número aleatorio (Juan1256)
            } else {
                $model->FOTO_AUL = $foto_aula;
            }
            // Fin subiendo foto

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->ID_AUL]);
            }
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    public function actionListar() {
        $modelo_aula = AulaLaboratorio::find()->orderBy('NOMBRE_AUL asc')->all();
        return $this->render('listar', [
                    'modelo_aula' => $modelo_aula,
        ]);
    }

    //++ función de descargar pdf de listar aulas y laboratorios ++
    public function actionListar_pdf() {
        $sql = "select * from aula_laboratorio order by NOMBRE_AUL asc";
        $aulas = AulaLaboratorio::findBySql($sql)->all();
        $mpdf = new mPDF ();
        $mpdf->SetTitle("Lista de aulas y laboratorios");
        $mpdf->SetAuthor("FIE-ESPOCH");
        $mpdf->showWatermarkText = true;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($this->renderPartial('listar_pdf', array(
                    'aulas' => $aulas,
                        ), true));
        $mpdf->Output('Lista de aulas ' . date('Y-m-d') . '.pdf', 'I');
        exit();
    }

    //funcion para buscar la existencia de un aula o laboratorio 
    public function actionBuscar_aula_por_nombre() {
        // El administrador ingresa el nombre del aula o laboratorio y busca si existe en la base de datos
        $nombre_aula = $_POST['aulalaboratorio'];
        $aulalaboratorio = AulaLaboratorio::findBySql("SELECT 
                    * FROM aula_laboratorio as aul            
                    WHERE aul.NOMBRE_AUL ='" . $nombre_aula . "' limit 1")->one();
        return json_encode($aulalaboratorio->NOMBRE_AUL);
    }

    /**
     * Deletes an existing AulaLaboratorio model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    //eliminado logico del aula
    public function actionDelete_aul($id) {
        $estado = AulaLaboratorio::findOne(['ID_AUL' => $id]);
        $estado->ESTADO_AUL = 3; //eliminada
        $estado->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the AulaLaboratorio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AulaLaboratorio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = AulaLaboratorio::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }

}
