<?php

namespace app\controllers;

use Yii;
use app\models\CarsemAsigPer;
use app\models\CarsemAsigPerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\PeriodoAcademico;
use app\models\Asignatura;
use app\models\Carrera;
use app\models\Semestre;
use app\models\Dia;
use app\models\Hora;
use yii\filters\AccessControl;
use app\models\AsigDocPer;
use app\models\DiaAulaHora;
//use yii\helpers\Html;
use Mpdf\Mpdf;

/**
 * CarsemAsigPerController implements the CRUD actions for CarsemAsigPer model.
 */
class CarsemAsigPerController extends Controller {

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
                            'delete1',
                            'descargar_horario_pdf',
                            'guardar_semestre',
                            'guardar_periodo',
                            //'guardar_asignatura',
                            'agregar',
                            //'guardar_docente',
                            'modificar',
                            'delete_doc',
                            'agregarh',
                            //'guardar_aula',
                            'modificarh',
                            'delete_aula'
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
     * Lists all CarsemAsigPer models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new CarsemAsigPerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CarsemAsigPer model.
     * @param integer $ID_CAR
     * @param integer $ID_SEM
     * @param string $CODIGO_ASIG
     * @param integer $ID_PER
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($ID_CAR, $ID_SEM, $CODIGO_ASIG, $ID_PER) {
        return $this->render('view', [
                    'model' => $this->findModel($ID_CAR, $ID_SEM, $CODIGO_ASIG, $ID_PER),
        ]);
    }

    /**
     * Creates a new CarsemAsigPer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    .....................................................................
//public function actionCreate()
//    {
//        $model = new CarsemAsigPer();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'ID_CAR' => $model->ID_CAR, 'ID_SEM' => $model->ID_SEM, 'CODIGO_ASIG' => $model->CODIGO_ASIG, 'ID_PER' => $model->ID_PER]);
//        }
//
//        return $this->render('create', [
//            'model' => $model,
//        ]);
//    }
    //    .....................................................................

    public function actionCreate() {
        $model = new CarsemAsigPer();
        $session = Yii::$app->session;
        $band = 0;
        $sql = new Asignatura(); //se crea un modelo para mostrar la tabla de datos
        $sql_validar = new PeriodoAcademico(); //se crea para poner un if y ver si existe algo para mostrar en la tabla

        if (isset($session['id_carrera']) && isset($session['id_semestre']) && isset($session['id_periodo'])) {
            $model->ID_CAR = $session['id_carrera']; //carrera
            $model->ID_SEM = $session['id_semestre']; //semestre
            $model->ID_PER = $session['id_periodo']; //periodo            
            $band = 1;
            $sql = Asignatura::findBySql("SELECT asig.`CODIGO_ASIG`, asig.`NOMBRE_ASIG`
                    FROM `asignatura` AS asig
                    INNER JOIN `carsem_asig_per` AS hor
                    ON asig.`CODIGO_ASIG` = hor.`CODIGO_ASIG`
                    WHERE 
                    hor.ID_CAR = '". $model->ID_CAR ."' AND hor.ID_SEM = '". $model->ID_SEM ."' 
                    AND hor.ID_PER = '". $model->ID_PER ."'")->all();
            $sql_periodo = "SELECT * FROM periodo_academico                                              
                        WHERE ID_PER IN (SELECT h.`ID_PER` FROM periodo_academico AS a
                        INNER JOIN `carsem_asig_per` AS h
                        ON a.`ID_PER` = h.`ID_PER` 
                        WHERE h.ID_CAR = '". $model->ID_CAR ."' AND h.ID_SEM = '". $model->ID_SEM ."' AND h.ID_PER = '". $model->ID_PER ."')";
            $sql_validar = PeriodoAcademico::findBySql($sql_periodo)->one();   
        } else {
            $periodo = PeriodoAcademico::find()->where(['ESTADO_PER' => 1])->one(); //siempre solo hay un estado activo 
            $model->ID_PER = $periodo->ID_PER;
            $session['id_periodo'] = $model->ID_PER;
        }
        if ($model->load(Yii::$app->request->post())) {
            $session['id_periodo'] = $model->ID_PER;
            $session['id_carrera'] = $model->ID_CAR;
            $session['id_semestre'] = $model->ID_SEM;
            $model->ESTADO_CSAP = 1; //ACTIVA=1 INACTIVO=0
            if ($model->save()) {
                return $this->redirect(['create']);
            }
        }

        return $this->render('create', [
                    'model' => $model,
                    'band' => $band,
                    'sql' => $sql,
                    'sql_validar' => $sql_validar,
        ]);
    }

    //agregar docente y paralelo a una asignatura
    public function actionAgregar($asig) {
         
        $session = Yii::$app->session;        
        $session['id_asignatura'] = $asig;
        $per = $session['id_periodo']; //periodo
        //$asig = $session['id_asignatura']; //asignatura
        $car = $session['id_carrera']; //carrera
        $sem = $session['id_semestre']; //semestre       

        $model = new AsigDocPer();
        $model->CODIGO_ASIG = $asig;
        $model->ID_PER = $per;
        $model->ID_CAR = $car;
        $model->ID_SEM = $sem;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['create']);
        }
        return $this->renderAjax('agregar', [
                    'model' => $model,
        ]);
    }

    //agregar aula, hora y dia a un docente-asignatura
    public function actionAgregarh($asig, $doc, $par) {
        $session = Yii::$app->session;
        
        //asigno a la variables de sesion los parametros q envio cuando llamo al modal de agregar aula-hora-dia
        $session['id_asignatura'] = $asig; //asignatura     
        $session['id_docente'] = $doc; //docente
        $session['id_paralelo'] = $par; //paralelo
        
        $per = $session['id_periodo']; //periodo
        $car = $session['id_carrera']; //carrera
        $sem = $session['id_semestre']; //semestre   
       // $asig = $session['id_asignatura'];        
       //$doc = $session['id_docente']; //docente
       // $par = $session['id_paralelo']; //paralelo

        //asigno los valores de las sesiones a los atributos que ya se conocen de la tabla dia,hora,aul
        $model = new DiaAulaHora();
        $model->ID_PER = $per;
        $model->ID_CAR = $car;
        $model->ID_SEM = $sem;
        $model->CODIGO_ASIG = $asig;
        $model->CEDULA_DOC = $doc;
        $model->PARALELO = $par;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['create']);
        }
        return $this->renderAjax('agregarh', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing CarsemAsigPer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $ID_CAR
     * @param integer $ID_SEM
     * @param string $CODIGO_ASIG
     * @param integer $ID_PER
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    //modificar docentes de una asignatura
    public function actionModificar($asig, $doc, $par) {
        $session = Yii::$app->session;
        //asigno a la variables de sesion los parametros q envio cuando llamo al modal de modificar docente
        $session['id_asignatura'] = $asig;
        $session['id_docente'] = $doc;
        $session['id_paralelo'] = $par;
        
        $per = $session['id_periodo']; //periodo
       // $asig = $session['id_asignatura']; //asignatura
        $car = $session['id_carrera']; //carrera
        $sem = $session['id_semestre']; //semestre       
        //$doc = $session['id_docente']; //docente
        //$par = $session['id_paralelo']; //paralelo

        $model_docent = AsigDocPer::findBySql("SELECT * FROM asig_doc_per WHERE                        
                        CODIGO_ASIG = '" . $asig . "'
                        AND CEDULA_DOC= '" . $doc . "'
                        AND ID_PER= '" . $per . "'
                        AND ID_SEM= '" . $sem . "'
                        AND ID_CAR= '" . $car . "'
                        AND PARALELO = '" . $par . "'")->one();

        if ($model_docent->load(Yii::$app->request->post()) && $model_docent->save()) {
            return $this->redirect(['create']);
        }
        return $this->renderAjax('modificar', [
                    'model_docent' => $model_docent,
        ]);
    }

    //modificar docentes de una asignatura
    public function actionModificarh($hora, $par, $asig, $doc, $aula, $dia) {        

        $session = Yii::$app->session;
        
        //asigno a variable de sesion los parametros que envío cuando llamo al modal de modifica aula-hora-dia
        $session['id_asignatura'] = $asig;
        $session['id_docente'] = $doc;
        $session['id_paralelo'] = $par;
        $session['id_hora'] = $hora;
        $session['id_aula'] = $aula;
        $session['id_dia'] = $dia;          
       
        $per = $session['id_periodo']; //periodo        
        $car = $session['id_carrera']; //carrera
        $sem = $session['id_semestre']; //semestre
        //$asig = $session['id_asignatura']; //asignatura       
        //$doc = $session['id_docente']; //docente
        //$par = $session['id_paralelo']; //paralelo
        //$hora = $session['id_hora']; //docente
        //$dia = $session['id_dia']; //paralelo
        //$aula = $session['id_aula']; //paralelo

        $model_aula = DiaAulaHora::findBySql("SELECT * FROM dia_aula_hora WHERE                        
                        CODIGO_ASIG = '" . $asig . "'
                        AND CEDULA_DOC= '" . $doc . "'
                        AND ID_PER= '" . $per . "'
                        AND ID_SEM= '" . $sem . "'
                        AND ID_CAR= '" . $car . "' 
                        AND ID_AUL= '" . $aula . "'
                        AND ID_DIA= '" . $dia . "'
                        AND ID_HORA= '" . $hora . "'
                        AND PARALELO = '" . $par . "'")->one();

        if ($model_aula->load(Yii::$app->request->post()) && $model_aula->save()) {
            return $this->redirect(['create']);
        }
        return $this->renderAjax('modificarh', [
                    'model_aula' => $model_aula,
        ]);
    }

    //eliminar docente y aulas q esten asignada a ellos
    public function actionDelete_doc($CODIGO_ASIG, $ID_PER, $CEDULA_DOC, $PARALELO, $ID_CAR, $ID_SEM) {
        $aula = DiaAulaHora::findBySql("SELECT * FROM dia_aula_hora WHERE 
                        CEDULA_DOC = '" . $CEDULA_DOC . "'
                        AND ID_CAR = '" . $ID_CAR . "'
                        AND ID_SEM = '" . $ID_SEM . "'
                        AND PARALELO = '" . $PARALELO . "'   
                        AND CODIGO_ASIG = '" . $CODIGO_ASIG . "'                        
                        AND ID_PER= '" . $ID_PER . "'")->all();
        if (isset($aula)) {
            foreach ($aula as $v) {
                $v->delete();
            }
        }
        $docente = AsigDocPer::findBySql("SELECT * FROM asig_doc_per WHERE 
                        CODIGO_ASIG = '" . $CODIGO_ASIG . "'
                        AND CEDULA_DOC= '" . $CEDULA_DOC . "'
                        AND ID_CAR = '" . $ID_CAR . "'
                        AND ID_SEM = '" . $ID_SEM . "'
                        AND ID_PER= '" . $ID_PER . "'
                        AND PARALELO = '" . $PARALELO . "' ")->one();
        if (isset($docente)) {
            $docente->delete();
        }

        return $this->redirect(['create']);
    }

    //eliminar aula, hora y dia de un docente con asignatura
    public function actionDelete_aula($CODIGO_ASIG, $ID_PER, $CEDULA_DOC, $ID_HORA, $ID_DIA, $ID_AUL, $PARALELO, $ID_CAR, $ID_SEM) {
        $var = DiaAulaHora::findOne(['CODIGO_ASIG' => $CODIGO_ASIG, 'ID_PER' => $ID_PER, 'CEDULA_DOC' => $CEDULA_DOC, 'ID_HORA' => $ID_HORA, 'ID_DIA' => $ID_DIA, 'ID_AUL' => $ID_AUL, 'PARALELO' => $PARALELO, 'ID_CAR' => $ID_CAR, 'ID_SEM' => $ID_SEM]);
        $var->delete();

        return $this->redirect(['create']);
    }

    //---  se crean funciones para crear variables de sesion para la primera vez que ingresa a la funcion crear horario
    public function actionGuardar_semestre($id) {
        $session = Yii::$app->session;
        $session['id_semestre'] = $id;
    }
    public function actionGuardar_periodo($id) {
        $session = Yii::$app->session;
        $session['id_periodo'] = $id;
    }
//    public function actionGuardar_asignatura($id) {
//        $session = Yii::$app->session;
//        $session['id_asignatura'] = $id;
//    }
//    public function actionGuardar_docente($id, $doc, $par) {
//        $session = Yii::$app->session;
//        $session['id_asignatura'] = $id;
//        $session['id_docente'] = $doc;
//        $session['id_paralelo'] = $par;
//    }
//    public function actionGuardar_aula($hora, $par, $asig, $doc, $aula, $dia) {
//        $session = Yii::$app->session;
//        $session['id_asignatura'] = $asig;
//        $session['id_docente'] = $doc;
//        $session['id_paralelo'] = $par;
//        $session['id_hora'] = $hora;
//        $session['id_aula'] = $aula;
//        $session['id_dia'] = $dia;
//    }    
    //---  se crean funciones para crear variables de sesion para la primera vez que ingresa a la funcion crear horario

    //funcion para descargar horario dentro del _form
    public function actionDescargar_horario_pdf() {
        //Llamamos a la conexión de la base de datos
        $db = Yii::$app->db;

        //asignamos las variables de sesion a una variable periodo-carrera-semestre
        $session = Yii::$app->session;
        $periodo = ' ';
        $carrera = ' ';
        $semestre = ' ';
        if (isset($session['id_periodo'])) {
            $periodo = $session['id_periodo'];
        };
        if (isset($session['id_carrera'])) {
            $carrera = $session['id_carrera'];
        };
        if (isset($session['id_semestre'])) {
            $semestre = $session['id_semestre'];
        };
        
         //----------------------------------------------------------------------       
        $dias = Dia::find()->all();
        $sql_hora=" SELECT
                    * FROM hora
                    WHERE `ID_HORA` IN (SELECT h.`ID_HORA` FROM `hora` AS a 
                    INNER JOIN `dia_aula_hora` AS h 
                    ON a.`ID_HORA` = h.`ID_HORA` 
                    WHERE h.ID_CAR = ".$carrera." AND h.ID_PER = ".$periodo." AND h.ID_SEM = ".$semestre." )ORDER BY `INICIO_HORA`";
        $horas = Hora::findBySql($sql_hora)->all();

        //----------------------------------------------------------------------
        
         //consulta sql para mostrar datos en la tabla
        $des_horario = $db->createCommand("SELECT CONCAT(doc.NOMBRES_DOC, ' ', doc.APELLIDOS_DOC ) AS CEDULA_DOC,
                                                asig.NOMBRE_ASIG AS CODIGO_ASIG,
                                                CONCAT(ho.INICIO_HORA, ' - ', ho.FIN_HORA) AS ID_HORA,
                                                d.DESCRIPCION_DIA AS ID_DIA,
                                                a.NOMBRE_AUL AS ID_AUL,
                                                h.PARALELO AS PARALELO,                                               
                                                s.DESCRIPCION_SEM AS ID_SEM
                                                FROM `dia_aula_hora` AS h 
                                                INNER JOIN docente AS doc
                                                ON h.CEDULA_DOC = doc.CEDULA_DOC
                                                INNER JOIN asignatura AS asig
                                                ON h.CODIGO_ASIG = asig.CODIGO_ASIG                                               
                                                INNER JOIN hora AS ho
                                                ON h.ID_HORA = ho.ID_HORA
                                                INNER JOIN dia AS d
                                                ON h.ID_DIA = d.ID_DIA
                                                INNER JOIN aula_laboratorio AS a
                                                ON h.ID_AUL = a.ID_AUL                                                
                                                INNER JOIN semestre AS s
                                                ON h.ID_SEM = s.ID_SEM                                                
                                                WHERE 
                                                h.ID_CAR = ".$carrera." AND h.ID_PER = ".$periodo." AND h.ID_SEM = ".$semestre."                                                
                                                ORDER BY s.`ID_SEM`, PARALELO")->queryAll();
            
        
         //consulta para ver si existen registros de la carrera seleccionada (y asi mostrar en el pdf)
        $sql_carrera= "SELECT NOMBRE_CAR FROM carrera                                              
                        WHERE ID_CAR IN (SELECT h.`ID_CAR` FROM carrera AS a
                        INNER JOIN `dia_aula_hora` AS h
                        ON a.`ID_CAR` = h.`ID_CAR` 
                        WHERE h.ID_CAR = " . $carrera . " AND h.ID_PER = " . $periodo . " AND h.ID_SEM = ".$semestre.")";
        //para imprimir carrera y periodo sin tener q abrir un for en el descargar_horario_pdf
        $m_carrera = Carrera::findBySql($sql_carrera)->one();        
        $m_semestre = Semestre::findOne($semestre);       
        $m_periodo = PeriodoAcademico::findOne($periodo);
        //----------------------------------------------------------------------
        
    if(isset($m_carrera->NOMBRE_CAR)){ //si no existe ningun horario aparecerá pantalla en blanco
        $mpdf = new mPDF(['orientation' => 'L']);
        $mpdf->SetTitle("Horario de clases carrera: ".$m_carrera->NOMBRE_CAR .' nivel: '.$m_semestre->DESCRIPCION_SEM);
        $mpdf->SetAuthor("FIE-ESPOCH");
        $mpdf->showWatermarkText = true;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($this->renderPartial('descargar_horario_pdf', array(
                    'des_horario' => $des_horario,
                    'm_periodo' => $m_periodo,
                    'm_carrera' => $m_carrera,
                    'dias' => $dias,
                    'horas' => $horas,     
                        ), true));   
        
        $mpdf->Output('Horario de clase carrera:'.$m_carrera->NOMBRE_CAR.' nivel '.$m_semestre->DESCRIPCION_SEM.' ' . date('Y-m-d') . '.pdf', 'I');
        exit();
     }
    }

    
    
    /**
     * Updates an existing CarsemAsigPer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $ID_CAR
     * @param integer $ID_SEM
     * @param string $CODIGO_ASIG
     * @param integer $ID_PER
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($ID_CAR, $ID_SEM, $CODIGO_ASIG, $ID_PER) {
        $model = $this->findModel($ID_CAR, $ID_SEM, $CODIGO_ASIG, $ID_PER);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID_CAR' => $model->ID_CAR, 'ID_SEM' => $model->ID_SEM, 'CODIGO_ASIG' => $model->CODIGO_ASIG, 'ID_PER' => $model->ID_PER]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CarsemAsigPer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $ID_CAR
     * @param integer $ID_SEM
     * @param string $CODIGO_ASIG
     * @param integer $ID_PER
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($ID_CAR, $ID_SEM, $CODIGO_ASIG, $ID_PER) {
        $sql = AsigDocPer::findBySql("SELECT * FROM asig_doc_per WHERE 
                        CODIGO_ASIG = '" . $CODIGO_ASIG . "'
                        AND ID_CAR= '" . $ID_CAR . "'
                        AND ID_SEM= '" . $ID_SEM . "'
                        AND ID_PER= '" . $ID_PER . "'")->all();

        foreach ($sql as $s) {
            //eliminar tambien todas las aulas, horas y dias de un docente-asignatura
            $aulas = DiaAulaHora::findBySql("SELECT * FROM dia_aula_hora WHERE 
                        CEDULA_DOC = '" . $s->CEDULA_DOC . "'
                        AND PARALELO = '" . $s->PARALELO . "'    
                        AND CODIGO_ASIG = '" . $s->CODIGO_ASIG . "'
                        AND ID_CAR = '" . $s->ID_CAR. "' 
                        AND ID_SEM = '" . $s->ID_SEM . "' 
                        AND ID_PER= '" . $s->ID_PER . "'")->all();
            if (isset($aulas)) {
                foreach ($aulas as $aula) {
                    $aula->delete();
                }
            }
        }

        foreach ($sql as $s) {
            //eliminar tambien todos los docentes, que dan esa asignatura en tal periodo academico        
            if (isset($s)) {
                $s->delete();
            }
        }
        $this->findModel($ID_CAR, $ID_SEM, $CODIGO_ASIG, $ID_PER)->delete();

        return $this->redirect(['index']);
    }

    //cambie el redirect cuando se elimina una materia para q vaya al create xq iba al index 
    public function actionDelete1($ID_CAR, $ID_SEM, $CODIGO_ASIG, $ID_PER) {
        $sql = AsigDocPer::findBySql("SELECT * FROM asig_doc_per WHERE 
                        CODIGO_ASIG = '" . $CODIGO_ASIG . "'
                        AND ID_CAR= '" . $ID_CAR . "'
                        AND ID_SEM= '" . $ID_SEM . "'
                        AND ID_PER= '" . $ID_PER . "'")->all();

        foreach ($sql as $s) {
            //eliminar tambien todas las aulas, horas y dias de un docente-asignatura
            $aulas = DiaAulaHora::findBySql("SELECT * FROM dia_aula_hora WHERE 
                        CEDULA_DOC = '" . $s->CEDULA_DOC . "'
                        AND PARALELO = '" . $s->PARALELO . "'    
                        AND CODIGO_ASIG = '" . $s->CODIGO_ASIG . "'
                        AND ID_CAR = '" . $s->ID_CAR. "' 
                        AND ID_SEM = '" . $s->ID_SEM . "' 
                        AND ID_PER= '" . $s->ID_PER . "'")->all();
            if (isset($aulas)) {
                foreach ($aulas as $aula) {
                    $aula->delete();
                }
            }
        }

        foreach ($sql as $s) {
            //eliminar tambien todos los docentes, que dan esa asignatura en tal periodo academico        
            if (isset($s)) {
                $s->delete();
            }
        }

        $this->findModel($ID_CAR, $ID_SEM, $CODIGO_ASIG, $ID_PER)->delete();
//        $model_1 = CarsemAsigPer::findOne(['ID_CAR' => $ID_CAR, 'ID_SEM' => $ID_SEM, 'CODIGO_ASIG' => $CODIGO_ASIG, 'ID_PER' => $ID_PER]);
//        $model_1->ESTADO_CSAP = 3; //ACTIVA=1 INACTIVO=0
        
        return $this->redirect(['create']);
    }


    /**
     * Finds the CarsemAsigPer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $ID_CAR
     * @param integer $ID_SEM
     * @param string $CODIGO_ASIG
     * @param integer $ID_PER
     * @return CarsemAsigPer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID_CAR, $ID_SEM, $CODIGO_ASIG, $ID_PER) {
        if (($model = CarsemAsigPer::findOne(['ID_CAR' => $ID_CAR, 'ID_SEM' => $ID_SEM, 'CODIGO_ASIG' => $CODIGO_ASIG, 'ID_PER' => $ID_PER])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }

}
