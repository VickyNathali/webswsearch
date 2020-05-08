<?php

namespace app\controllers;

use Yii;
use app\models\AsigDocPer;
use app\models\AsigDocPerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\PeriodoAcademico;
use app\models\Carrera;
use app\models\Docente;
use Mpdf\Mpdf;

/**
 * AsigDocPerController implements the CRUD actions for AsigDocPer model.
 */
class AsigDocPerController extends Controller {

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
                            'listar',
                            'guardar_asigdoc_listar',
                            'listar_pdf',
                            'rep_asig_doc',
                            'rep_asig_doc_pdf',
                            'buscar_docentes_asignados',
                            'buscar_docentes_periodo',
                            'grafico_reporte_docente'
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
     * Lists all AsigDocPer models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AsigDocPerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AsigDocPer1 model.
     * @param string $CODIGO_ASIG
     * @param integer $ID_PER
     * @param string $CEDULA_DOC
     * @param string $PARALELO
     * @param integer $ID_CAR
     * @param integer $ID_SEM
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($CODIGO_ASIG, $ID_PER, $CEDULA_DOC, $PARALELO, $ID_CAR, $ID_SEM) {
        return $this->render('view', [
                    'model' => $this->findModel($CODIGO_ASIG, $ID_PER, $CEDULA_DOC, $PARALELO, $ID_CAR, $ID_SEM),
        ]);
    }

    /**
     * Creates a new AsigDocPer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new AsigDocPer1();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'CODIGO_ASIG' => $model->CODIGO_ASIG, 'ID_PER' => $model->ID_PER, 'CEDULA_DOC' => $model->CEDULA_DOC, 'PARALELO' => $model->PARALELO, 'ID_CAR' => $model->ID_CAR, 'ID_SEM' => $model->ID_SEM]);
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    //---------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------
    // función para listar asignaturas-docentes (listar en vista asig-doc-per)
    public function actionListar() {
        
        $session = Yii::$app->session;
        if (isset($session['id_asigdoc_listar']) || isset($session['id_asigdoca_listar'])) {
            $session->remove('id_asigdoc_listar');
            $session->remove('id_asigdoca_listar');
        };
        
        $model = new AsigDocPer();
        return $this->render('listar', [
                    'model' => $model,
        ]);
    }

    public function actionGuardar_asigdoc_listar($id, $car) {
        $session = Yii::$app->session;
        $db = Yii::$app->db;
        $session['id_asigdoc_listar'] = $id; //periodo
        $session['id_asigdoca_listar'] = $car; //carrera
        $resultado = $db->createCommand("SELECT CONCAT(doc.NOMBRES_DOC, ' ', doc.APELLIDOS_DOC ) AS CEDULA_DOC,
                                                asig.NOMBRE_ASIG AS CODIGO_ASIG,
                                                CONCAT(per.INICIO_PER, ' hasta ', per.FIN_PER) AS ID_PER,
                                                h.PARALELO AS PARALELO,
                                                c.NOMBRE_CAR AS ID_CAR,
                                                s.DESCRIPCION_SEM AS ID_SEM
                                                FROM `asig_doc_per` AS h 
                                                INNER JOIN docente AS doc
                                                ON h.CEDULA_DOC = doc.CEDULA_DOC
                                                INNER JOIN asignatura AS asig
                                                ON h.CODIGO_ASIG = asig.CODIGO_ASIG
                                                INNER JOIN periodo_academico AS per
                                                ON h.ID_PER = per.ID_PER                                                
                                                INNER JOIN carrera AS c
                                                ON h.ID_CAR = c.ID_CAR
                                                INNER JOIN semestre AS s
                                                ON h.ID_SEM = s.ID_SEM                                                
                                                WHERE 
                                                h.ID_CAR =  " . $car . " AND h.ID_PER = " . $id . "                                                
                                                ORDER BY s.`ID_SEM`, PARALELO
         ")->queryAll();
        //consulta sql para mostrar datos en la tabla
        $datos = [];
        $cont = 0;
        foreach ($resultado as $hor) {
            $cont++;
            $datos[$cont]['ID_PER'] = $hor['ID_PER'];
            $datos[$cont]['PARALELO'] = $hor['PARALELO'];
            $datos[$cont]['ID_CAR'] = $hor['ID_CAR'];
            $datos[$cont]['ID_SEM'] = $hor['ID_SEM'];
            $datos[$cont]['CODIGO_ASIG'] = $hor['CODIGO_ASIG'];
            $datos[$cont]['CEDULA_DOC'] = $hor['CEDULA_DOC'];
        }
        $datos[0][0] = $cont;
        return json_encode($datos);
    }

    public function actionListar_pdf() {
        //Llamamos a la conexión de la base de datos
        $db = Yii::$app->db;
        //asignamos las variables de sesion a una variable periodo y carrera
        $session = Yii::$app->session;
        $periodo = ' ';
        $carrera = ' ';

        //-----------------------------------------------------------------------
        //consulta para ver si existen registros de la carrera seleccionada (y asi mostrar en el pdf)
        if (isset($session['id_asigdoc_listar'])) {
            $periodo = $session['id_asigdoc_listar'];
            $m_periodo = PeriodoAcademico::findOne($periodo);
        };
        if (isset($session['id_asigdoca_listar'])) {
            $carrera = $session['id_asigdoca_listar'];
            $sql_carrera = "SELECT NOMBRE_CAR FROM carrera                                              
                        WHERE ID_CAR IN (SELECT h.`ID_CAR` FROM carrera AS a
                        INNER JOIN `asig_doc_per` AS h
                        ON a.`ID_CAR` = h.`ID_CAR` 
                        WHERE h.ID_CAR = '" . $carrera . "' AND h.ID_PER = '" . $periodo . "')";
            $m_carrera = Carrera::findBySql($sql_carrera)->one();
        };
        //----------------------------------------------------------------------

        $listar_asigdoc = $db->createCommand("SELECT CONCAT(doc.NOMBRES_DOC, ' ', doc.APELLIDOS_DOC ) AS CEDULA_DOC,
                                                asig.NOMBRE_ASIG AS CODIGO_ASIG,                                          
                                                h.PARALELO AS PARALELO,                                                
                                                s.DESCRIPCION_SEM AS ID_SEM
                                                FROM `asig_doc_per` AS h 
                                                INNER JOIN docente AS doc
                                                ON h.CEDULA_DOC = doc.CEDULA_DOC                                               
                                                INNER JOIN asignatura AS asig                                                
                                                ON h.CODIGO_ASIG = asig.CODIGO_ASIG 
                                                INNER JOIN semestre AS s
                                                ON h.ID_SEM = s.ID_SEM                                                
                                                WHERE 
                                                h.ID_CAR = '" . $carrera . "' AND h.ID_PER = '" . $periodo . "'                                                
                                                ORDER BY s.`ID_SEM`, PARALELO")->queryAll();
        //consulta sql para mostrar datos en la tabla

        if (isset($m_carrera->NOMBRE_CAR)) { //en caso de q no exista ningun dato la pagina del pdf se mostrará en blanco
            $mpdf = new mPDF ();
            $mpdf->SetTitle("Lista de asignaturas y asignacion de docentes carrera: " . $m_carrera->NOMBRE_CAR);
            $mpdf->SetAuthor("FIE-ESPOCH");
            $mpdf->showWatermarkText = true;
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->watermarkTextAlpha = 0.1;
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->WriteHTML($this->renderPartial('listar_pdf', array(
                        'listar_asigdoc' => $listar_asigdoc,
                        'm_periodo' => $m_periodo,
                        'm_carrera' => $m_carrera,
                            ), true));
            $mpdf->Output('Lista de asignaturas y asignacion de docentes carrera: ' . $m_carrera->NOMBRE_CAR . ' ' . date('Y-m-d') . '.pdf', 'I');
            exit();
        }
    }

    //---------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------
    //************************************************************************************************
    //*********************************** REPORTE DE ASIGNACIÓN DE DOCENTES **************************
    //************************************************************************************************
    //++ función del reporte por asignación de docentes ++
    public function actionRep_asig_doc() {
        //Consultamos y eliminamos variable de sesión para generar reporte
        $session = Yii::$app->session;
        if (isset($session['doc_per_reporte']) || isset($session['asig_doc_reporte'])) {
            $session->remove('asig_doc_reporte');
            $session->remove('doc_per_reporte');
        };
        //Fin de consultamos y eliminamos variable de sesión para generar reporte

        $model = new AsigDocPer();
        return $this->render('rep_asig_doc', [
                    'model' => $model,
        ]);
    }

    //++ función de buscar todos los docentes asignados a las asignatura al escoger un periodo academico (datos mostrados en tabla)++
    public function actionBuscar_docentes_periodo($id) {
        //Llamamos a la conexión de la base de datos para hacer la consulta
        //se hizo así xq no había como guardar los datos en un modelo debido a que eran demasiados
        $db = Yii::$app->db;

        //Guardamos en una variable de sesión para generar el pdf
        $session = Yii::$app->session;
        $session['doc_per_reporte'] = $id;

        $resultado = $db->createCommand("SELECT
            COUNT(h.CEDULA_DOC) AS ID_AUL,
            CONCAT(d.`APELLIDOS_DOC`, ' ',d.`NOMBRES_DOC`) AS CEDULA_DOC,
            CONCAT(per.INICIO_PER, ' hasta ', per.FIN_PER) AS ID_PER,
            c.`NOMBRE_CAR` AS ID_CAR,
            s.`DESCRIPCION_SEM` AS ID_SEM, 
            h.`PARALELO` AS PARALELO,
            a.`NOMBRE_ASIG` AS CODIGO_ASIG        
            FROM `dia_aula_hora` AS h         
	INNER JOIN docente AS d
        ON d.`CEDULA_DOC` = h.`CEDULA_DOC`
        INNER JOIN asignatura AS a
        ON a.`CODIGO_ASIG` = h.`CODIGO_ASIG`
        INNER JOIN periodo_academico AS per
        ON h.ID_PER = per.ID_PER        
        INNER JOIN carrera AS c
        ON c.`ID_CAR` = h.`ID_CAR`   
        INNER JOIN semestre AS s
        ON s.`ID_SEM` = h.`ID_SEM`   
        WHERE 
        (h.`ID_PER`='" . $id . "' AND d.ESTADO_DOC = 1)
        GROUP BY h.CODIGO_ASIG, h.`PARALELO`       
        ORDER BY d.`APELLIDOS_DOC`, c.`ID_CAR`, h.`ID_SEM`    
        ")->queryAll();
        //consulta sql para mostrar datos en la tabla
        //crear modelo para guardar datos del docente      
        $datos = [];
        $cont = 0;
        foreach ($resultado as $hor) {
            $cont++;
            $datos[$cont]['Carrera'] = $hor['ID_CAR'];
            $datos[$cont]['Semestre'] = $hor['ID_SEM'];
            $datos[$cont]['Paralelo'] = $hor['PARALELO'];
            $datos[$cont]['Asignatura'] = $hor['CODIGO_ASIG'];
            $datos[$cont]['Docente'] = $hor['CEDULA_DOC'];
            $datos[$cont]['Cantidad'] = $hor['ID_AUL'];
            $datos[$cont]['Periodo'] = $hor['ID_PER'];
        }
        $datos[0][0] = $cont;
        return json_encode($datos);
    }

    //funcion para el grafico q se genera cuando esocje un periodo academico
    public function actionGrafico_reporte_docente() {
        $id = $_POST['id'];
        //modelo para gráfico de asignacion de docentes  //se utiliza estado_doc por que es de tipo entero
        $grafico_docentes = Docente::findBySql("SELECT COUNT(h.CEDULA_DOC) AS ESTADO_DOC, CONCAT(`NOMBRES_DOC`,' ',`APELLIDOS_DOC`) AS NOMBRES_DOC  
        FROM docente AS d
        INNER JOIN asig_doc_per AS h
        ON h.CEDULA_DOC = d.CEDULA_DOC
        WHERE (h.ID_PER= '" . $id . "' AND d.ESTADO_DOC = 1)
        GROUP BY h.CEDULA_DOC
        ")->all();

        $datos = [];
        $cont = 0;
        foreach ($grafico_docentes as $gra) {
            $cont++;
            $datos[$cont]['Docente'] = $gra->NOMBRES_DOC;
            $datos[$cont]['Cantidad'] = $gra->ESTADO_DOC; //en CEDULA_DOC estamos guardando la cantidad de veces que se asignó a un docente en dicho periodo
        }
        $datos[0][0] = $cont;
        return json_encode($datos);
    }

    //++ función para buscar inf de docentes asignados cuando escoje periodo y docente++
    public function actionBuscar_docentes_asignados($periodo, $docente) {
        //Llamamos a la conexión de la bse de datos
        $db = Yii::$app->db;
        //Guardamos en una variable de sesión el docente escogido para generar el pdf  
        $session = Yii::$app->session;
        $session['asig_doc_reporte'] = $docente;
        $session['doc_per_reporte'] = $periodo;

        $resultado = $db->createCommand("SELECT
            COUNT(h.CEDULA_DOC) AS ID_AUL,
            CONCAT(d.`APELLIDOS_DOC`, ' ',d.`NOMBRES_DOC`) AS CEDULA_DOC,
            CONCAT(per.INICIO_PER, ' hasta ', per.FIN_PER) AS ID_PER,
            c.`NOMBRE_CAR` AS ID_CAR,
            s.`DESCRIPCION_SEM` AS ID_SEM, 
            h.`PARALELO` AS PARALELO,
            a.`NOMBRE_ASIG` AS CODIGO_ASIG        
            FROM `dia_aula_hora` AS h         
	INNER JOIN docente AS d
        ON d.`CEDULA_DOC` = h.`CEDULA_DOC`
        INNER JOIN asignatura AS a
        ON a.`CODIGO_ASIG` = h.`CODIGO_ASIG`
        INNER JOIN periodo_academico AS per
        ON h.ID_PER = per.ID_PER        
        INNER JOIN carrera AS c
        ON c.`ID_CAR` = h.`ID_CAR`   
        INNER JOIN semestre AS s
        ON s.`ID_SEM` = h.`ID_SEM`   
        WHERE 
        (h.`CEDULA_DOC`='" . $docente . "' AND h.`ID_PER`='" . $periodo . "')
        GROUP BY h.CODIGO_ASIG, h.`PARALELO`       
        ORDER BY d.`APELLIDOS_DOC`, c.`ID_CAR`, h.`ID_SEM`  
        ")->queryAll();
        //consulta sql para mostrar datos en la tabla   
        $datos = [];
        $cont = 0;
        foreach ($resultado as $hor) {
            $cont++;
            $datos[$cont]['Carrera'] = $hor['ID_CAR'];
            $datos[$cont]['Semestre'] = $hor['ID_SEM'];
            $datos[$cont]['Paralelo'] = $hor['PARALELO'];
            $datos[$cont]['Asignatura'] = $hor['CODIGO_ASIG'];
            $datos[$cont]['Docente'] = $hor['CEDULA_DOC'];
            $datos[$cont]['Cantidad'] = $hor['ID_AUL'];
            $datos[$cont]['Periodo'] = $hor['ID_PER'];
        }
        $datos[0][0] = $cont;
        return json_encode($datos);
    }

    //++ función de pdf del reporte de asignacion de docentes ++
    public function actionRep_asig_doc_pdf() {
        //Llamamos a la conexión de la base de datos
        $db = Yii::$app->db;

        $session = Yii::$app->session;
        $periodo = ''; 
        $docente = '';
        $m_docente = '';

        //---------------------------------------------------------------------
        //para imprimir docente y periodo sin tener q abrir un foreach de reporte_docente en el listar_pdf 
        if (isset($session['asig_doc_reporte'])) {
            $docente = $session['asig_doc_reporte'];
            $m_docente = Docente::findOne($docente);
        };

        if (isset($session['doc_per_reporte'])) {
            $periodo = $session['doc_per_reporte'];
            //consulta para ver si existen registros del periodo seleccionado (y asi mostrar en el pdf)
            $sql_periodo = "SELECT * FROM periodo_academico                                              
                            WHERE ID_PER IN (SELECT h.`ID_PER` FROM periodo_academico AS a
                            INNER JOIN `dia_aula_hora` AS h
                            ON a.`ID_PER` = h.`ID_PER` 
                            WHERE h.ID_PER = '" . $periodo . "')";
            $m_periodo = PeriodoAcademico::findBySql($sql_periodo)->one();
        };
        //---------------------------------------------------------------------
        if (isset($session['asig_doc_reporte']) && isset($session['doc_per_reporte'])) {
            $reporte_docente = $db->createCommand("SELECT
                COUNT(h.CEDULA_DOC) AS ID_AUL,
                CONCAT(d.`APELLIDOS_DOC`, ' ',d.`NOMBRES_DOC`) AS CEDULA_DOC,
                CONCAT(per.INICIO_PER, ' hasta ', per.FIN_PER) AS ID_PER,
                c.`NOMBRE_CAR` AS ID_CAR,
                s.`DESCRIPCION_SEM` AS ID_SEM, 
                h.`PARALELO` AS PARALELO,
                a.`NOMBRE_ASIG` AS CODIGO_ASIG        
                FROM `dia_aula_hora` AS h         
            INNER JOIN docente AS d
            ON d.`CEDULA_DOC` = h.`CEDULA_DOC`
            INNER JOIN asignatura AS a
            ON a.`CODIGO_ASIG` = h.`CODIGO_ASIG`
            INNER JOIN periodo_academico AS per
            ON h.ID_PER = per.ID_PER        
            INNER JOIN carrera AS c
            ON c.`ID_CAR` = h.`ID_CAR`   
            INNER JOIN semestre AS s
            ON s.`ID_SEM` = h.`ID_SEM`   
            WHERE 
            (h.`CEDULA_DOC`='". $docente ."' AND h.`ID_PER`='". $periodo ."')
            GROUP BY h.CODIGO_ASIG, h.`PARALELO`       
            ORDER BY d.`APELLIDOS_DOC`, c.`ID_CAR`, h.`ID_SEM`  
            ")->queryAll();
            
        } else{ if (isset($session['doc_per_reporte'])) {
            $reporte_docente = $db->createCommand("SELECT
                COUNT(h.CEDULA_DOC) AS ID_AUL,
                CONCAT(d.`APELLIDOS_DOC`, ' ',d.`NOMBRES_DOC`) AS CEDULA_DOC,
                CONCAT(per.INICIO_PER, ' hasta ', per.FIN_PER) AS ID_PER,
                c.`NOMBRE_CAR` AS ID_CAR,
                s.`DESCRIPCION_SEM` AS ID_SEM, 
                h.`PARALELO` AS PARALELO,
                a.`NOMBRE_ASIG` AS CODIGO_ASIG        
                FROM `dia_aula_hora` AS h         
            INNER JOIN docente AS d
            ON d.`CEDULA_DOC` = h.`CEDULA_DOC`
            INNER JOIN asignatura AS a
            ON a.`CODIGO_ASIG` = h.`CODIGO_ASIG`
            INNER JOIN periodo_academico AS per
            ON h.ID_PER = per.ID_PER        
            INNER JOIN carrera AS c
            ON c.`ID_CAR` = h.`ID_CAR`   
            INNER JOIN semestre AS s
            ON s.`ID_SEM` = h.`ID_SEM`   
            WHERE 
            (h.`ID_PER`='". $periodo ."' AND d.ESTADO_DOC = 1)
            GROUP BY h.CODIGO_ASIG, h.`PARALELO`       
            ORDER BY d.`APELLIDOS_DOC`, c.`ID_CAR`, h.`ID_SEM`    
            ")->queryAll();
        }}
        
        //consulta sql para mostrar datos en la tabla
        if (isset($m_periodo->ID_PER)) {
            $mpdf = new mPDF ();
            $mpdf->SetTitle("Reporte de la asignacion de docentes". $m_periodo->ID_PER);
            $mpdf->SetAuthor("FIE-ESPOCH");
            $mpdf->showWatermarkText = true;
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->watermarkTextAlpha = 0.1;
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->WriteHTML($this->renderPartial('rep_asig_doc_pdf', array(
                        'reporte_docente' => $reporte_docente,
                        'm_docente' => $m_docente,
                        'm_periodo' => $m_periodo,
                            ), true));
            $mpdf->Output('Reporte de asignacion de docentes '. $m_periodo->ID_PER . ' '  . date('Y-m-d') . '.pdf', 'I');
            exit();
        }
    }

    //************************************************************************************************
    //*********************************** REPORTE DE ASIGNACIÓN DE DOCENTES **************************
    //************************************************************************************************

    /**
     * Updates an existing AsigDocPer1 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $CODIGO_ASIG
     * @param integer $ID_PER
     * @param string $CEDULA_DOC
     * @param string $PARALELO
     * @param integer $ID_CAR
     * @param integer $ID_SEM
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($CODIGO_ASIG, $ID_PER, $CEDULA_DOC, $PARALELO, $ID_CAR, $ID_SEM) {
        $model = $this->findModel($CODIGO_ASIG, $ID_PER, $CEDULA_DOC, $PARALELO, $ID_CAR, $ID_SEM);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'CODIGO_ASIG' => $model->CODIGO_ASIG, 'ID_PER' => $model->ID_PER, 'CEDULA_DOC' => $model->CEDULA_DOC, 'PARALELO' => $model->PARALELO, 'ID_CAR' => $model->ID_CAR, 'ID_SEM' => $model->ID_SEM]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AsigDocPer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $CODIGO_ASIG
     * @param integer $ID_PER
     * @param string $CEDULA_DOC
     * @param string $PARALELO
     * @param integer $ID_CAR
     * @param integer $ID_SEM
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($CODIGO_ASIG, $ID_PER, $CEDULA_DOC, $PARALELO, $ID_CAR, $ID_SEM) {
        $this->findModel($CODIGO_ASIG, $ID_PER, $CEDULA_DOC, $PARALELO, $ID_CAR, $ID_SEM)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AsigDocPer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $CODIGO_ASIG
     * @param integer $ID_PER
     * @param string $CEDULA_DOC
     * @param string $PARALELO
     * @param integer $ID_CAR
     * @param integer $ID_SEM
     * @return AsigDocPer1 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($CODIGO_ASIG, $ID_PER, $CEDULA_DOC, $PARALELO, $ID_CAR, $ID_SEM) {
        if (($model = AsigDocPer::findOne(['CODIGO_ASIG' => $CODIGO_ASIG, 'ID_PER' => $ID_PER, 'CEDULA_DOC' => $CEDULA_DOC, 'PARALELO' => $PARALELO, 'ID_CAR' => $ID_CAR, 'ID_SEM' => $ID_SEM])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }

}
