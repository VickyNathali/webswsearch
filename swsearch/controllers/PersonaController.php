<?php

namespace app\controllers;

use Yii;
use app\models\Persona;
use app\models\Administrador;
use app\models\Estudiante;
use app\models\PersonaSearch;
use app\models\PersonaAdministradorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Mpdf\Mpdf;
use yii\filters\AccessControl;
use yii\web\UploadedFile; //Para subir fotos

/**
 * PersonaController implements the CRUD actions for Persona model.
 */

class PersonaController extends Controller {

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
                            'delete_adm',
                            'listar',
                            'listar_pdf',
                            'buscar_usuario_por_cedula',
                            'buscar_nombre_usuario'
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
     * Lists all Persona models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PersonaAdministradorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Persona model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        $model_adm = Administrador::findBySql('select * from administrador where CEDULA_PER = ' . $id . ' order by CEDULA_PER desc limit 1')->one(); //crear modelo_adm para guardar el array con los datos del administrador

        return $this->render('view', [
                    'model' => $model,
                    'model_adm' => $model_adm,
        ]);
    }

    /**
     * Creates a new Persona model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Persona();
        //crear un modelo (variable)administrador  para pedir los datos del administrador
        $model_adm = new Administrador();
        $model->TOKEN_PER = 1; //esta afuera del post por que si se muestra en la interfaz la opcion (sale por defecto seleccionado activo)

        if ($model->load(Yii::$app->request->post()) && $model_adm->load(Yii::$app->request->post())) {
            //$model->CONTRASENA_PER = md5($model->CONTRASENA_PER);
            
            //Subiendo Fotos
            $model->FOTO_PER = UploadedFile::getInstance($model, 'FOTO_PER');
            if ($model->FOTO_PER && $model->validate()) {
                $image_name = $model->NOMBRES_PER . rand(1, 4000) . '.' . $model->FOTO_PER->extension;
                $image_path = 'imagenes/Fotos/' . $image_name;
                $model->FOTO_PER->saveAs($image_path);
                $model->FOTO_PER = $image_name; //en la base de datos guarda el nombre con un número aleatorio (Juan1256)           
                //$model->FOTO_PER->saveAs('imagenes/Fotos/' . $model->FOTO_PER->baseName . '.' . $model->FOTO_PER->extension);
            } 
            // Fin subiendo fotos
            
            if ($model->save()) {
                $model_adm->CEDULA_PER = $model->CEDULA_PER; //asignar la cédula de la entidad padre (usuario) a la entidad hija administrador
                $model_adm->save();
                return $this->redirect(['view', 'id' => $model->CEDULA_PER]);
            }
        }

        return $this->render('create', [
                    'model' => $model,
                    'model_adm' => $model_adm,
        ]);
    }

    //funcion para buscar la existencia de la cedula del usuario
    public function actionBuscar_usuario_por_cedula() {
        // El usuario ingresa la cédula y busca si existe en la base de datos
        $cedula_usuario = $_POST['usuario'];
        $usuario = Persona::findBySql("SELECT 
            * 
            FROM persona as per            
            WHERE 
            per.CEDULA_PER ='" . $cedula_usuario . "' limit 1")->one();
        return json_encode($usuario->APELLIDOS_PER . ' ' . $usuario->NOMBRES_PER);
    }
    //funcion para buscar la existencia del nombre usuario
    public function actionBuscar_nombre_usuario() {
        // El usuario ingresa nombre de usuario y busca si existe en la base de datos
        $nombre_usuario = $_POST['nusuario'];
        $usuario = Persona::findBySql("SELECT 
            * 
            FROM persona as per            
            WHERE 
            per.USUARIO_PER ='" . $nombre_usuario . "' limit 1")->one();
        return json_encode($usuario->APELLIDOS_PER . ' ' . $usuario->NOMBRES_PER);
    }

    /**
     * Updates an existing Persona model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        //crear un modelo (variable)administrador  para consultar los datos del administrador
        $model_adm = Administrador::findBySql('select * from administrador where CEDULA_PER = ' . $id . ' order by CEDULA_PER desc limit 1')->one(); //crear modelo_practicas para guardar el array con los datos de las practicas del estudiante

        //$contraseña = $model->CONTRASENA_PER;
        $foto = $model->FOTO_PER;
        //$model->CONTRASENA_PER = '';
        if ($model->load(Yii::$app->request->post()) && $model_adm->load(Yii::$app->request->post())) {
//            if ($model->CONTRASENA_PER == '') {
//                $model->CONTRASENA_PER = $contraseña;
//            } else {
//                $model->CONTRASENA_PER = md5($model->CONTRASENA_PER);
//            }

            //Subiendo Foto
            $model->FOTO_PER = UploadedFile::getInstance($model, 'FOTO_PER');
            if ($model->FOTO_PER && $model->validate()) {
//                $model->FOTO_PER->saveAs('imagenes/Fotos/' . $model->FOTO_PER->baseName . '.' . $model->FOTO_PER->extension);
                $image_name = $model->NOMBRES_PER . rand(1, 4000) . '.' . $model->FOTO_PER->extension;
                $image_path = 'imagenes/Fotos/' . $image_name;
                $model->FOTO_PER->saveAs($image_path);
                $model->FOTO_PER = $image_name; //en la base de datos guarda el nombre con un número aleatorio (Juan1256)   
            } // Fin subiendo foto
            else {
                $model->FOTO_PER = $foto;
            }
            if ($model->save()) {
                $model_adm->CEDULA_PER = $model->CEDULA_PER; //asignar la cédula de la entidad padre (usuario) a la entidad hija administrador
                $model_adm->save();
                return $this->redirect(['view', 'id' => $model->CEDULA_PER]);
            }
        }

        return $this->render('update', [
                    'model' => $model,
                    'model_adm' => $model_adm,
        ]);
    }

    public function actionListar() {
        $modelo_usuario = Persona::find()->orderBy('APELLIDOS_PER asc')->all();
        $modelo_adm = Administrador::find()->all();
        $modelo_est = Estudiante::find()->all();
        return $this->render('listar', [
                    'modelo_usuario' => $modelo_usuario,
                    'modelo_adm' => $modelo_adm,
                    'modelo_est' => $modelo_est,
        ]);
    }

    //++ función de pdf de listar usuarios del sistema ++
    public function actionListar_pdf() {
        $sql = "select * from persona order by APELLIDOS_PER asc";
        $usuarios = Persona::findBySql($sql)->all();
        $administrador = Administrador::find()->all();
        $estudiante = Estudiante::find()->all();
        $mpdf = new mPDF ();
        $mpdf->SetTitle("Lista de usuarios de los aplicativos");
        $mpdf->SetAuthor("FIE-ESPOCH");
        $mpdf->showWatermarkText = true;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($this->renderPartial('listar_pdf', array(
                    'usuarios' => $usuarios,
                    'administrador' => $administrador,
                    'estudiante' => $estudiante,
                        ), true));
        $mpdf->Output('Lista de usuarios ' . date('Y-m-d') . '.pdf', 'I');
        exit();
    }

    /**
     * Deletes an existing Persona model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $var1 = Administrador::find()->where(['CEDULA_PER' => $id])->one();
        $var1->delete();

        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    //eliminado lógico de administradores
    public function actionDelete_adm($id) {            
       
        $estado = Persona::find()->where(['CEDULA_PER' => $id])->one();
        $estado->TOKEN_PER = '3'; //eliminada
        $estado->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Persona model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Persona the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Persona::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }

}
