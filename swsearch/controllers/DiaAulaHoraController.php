<?php

namespace app\controllers;

use Yii;
use app\models\DiaAulaHora;
use app\models\DiaAulaHoraSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Dia;
use app\models\Hora;
use app\models\AulaLaboratorio;
use app\models\PeriodoAcademico;
use app\models\Carrera;
use Mpdf\Mpdf;

/**
 * DiaAulaHoraController implements the CRUD actions for DiaAulaHora model.
 */
class DiaAulaHoraController extends Controller {

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
                            'guardar_horario_listar',
                            'listar_pdf',
                            'listar_hora_dia',
                            'listar_aula_hora',
                            'guardar_dia_mh',
                            'rep_asig_aulas',
                            'rep_asig_aulas_pdf',
                            'buscar_aulas_asignadas',
                            'buscar_aulas_periodo',
                            'grafico_reporte_aula'
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
     * Lists all DiaAulaHora models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new DiaAulaHoraSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DiaAulaHora1 model.
     * @param string $CODIGO_ASIG
     * @param integer $ID_PER
     * @param string $CEDULA_DOC
     * @param integer $ID_HORA
     * @param integer $ID_DIA
     * @param integer $ID_AUL
     * @param string $PARALELO
     * @param integer $ID_CAR
     * @param integer $ID_SEM
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($CODIGO_ASIG, $ID_PER, $CEDULA_DOC, $ID_HORA, $ID_DIA, $ID_AUL, $PARALELO, $ID_CAR, $ID_SEM) {
        return $this->render('view', [
                    'model' => $this->findModel($CODIGO_ASIG, $ID_PER, $CEDULA_DOC, $ID_HORA, $ID_DIA, $ID_AUL, $PARALELO, $ID_CAR, $ID_SEM),
        ]);
    }

    //---------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------
    // función para listar el horario de una carrera 
    public function actionListar() {
        $model = new DiaAulaHora();
        
        $session = Yii::$app->session;
        if (isset($session['id_per_listar']) || isset($session['id_car_listar'])) {
            $session->remove('id_per_listar');
            $session->remove('id_car_listar');
        };
        $dias = Dia::find('DESCRIPCION_DIA')->all();
        $d = Array();
        $cont_d = 0;
        foreach ($dias as $dd) {
            $d[$cont_d++] = $dd->DESCRIPCION_DIA;
        };
        $horas = Hora::find()->orderBy('INICIO_HORA asc')->all();
        $h = Array();
        $cont_h = 0;
        foreach ($horas as $hh) {
            $h[$cont_h++] = $hh->INICIO_HORA . ' - ' . $hh->FIN_HORA;
        }
        return $this->render('listar', [
                    'model' => $model,
                    'dias' => $d,
                    'horas' => $h,
        ]);
    }

    //funcion para guardar las variables escogidas en la vista de listar
    public function actionGuardar_horario_listar($per, $car) {
        $session = Yii::$app->session;
        $db = Yii::$app->db;
        $session['id_per_listar'] = $per;
        $session['id_car_listar'] = $car;
        $resultado = $db->createCommand("SELECT CONCAT(doc.NOMBRES_DOC, ' ', doc.APELLIDOS_DOC ) AS CEDULA_DOC,
                                                asig.NOMBRE_ASIG AS CODIGO_ASIG,
                                                CONCAT(per.INICIO_PER, ' hasta ', per.FIN_PER) AS ID_PER,
                                                CONCAT(ho.INICIO_HORA, ' - ', ho.FIN_HORA) AS ID_HORA,
                                                d.DESCRIPCION_DIA AS ID_DIA,
                                                a.NOMBRE_AUL AS ID_AUL,
                                                h.PARALELO AS PARALELO,
                                                c.NOMBRE_CAR AS ID_CAR,
                                                s.DESCRIPCION_SEM AS ID_SEM
                                                FROM `dia_aula_hora` AS h 
                                                INNER JOIN docente AS doc
                                                ON h.CEDULA_DOC = doc.CEDULA_DOC
                                                INNER JOIN asignatura AS asig
                                                ON h.CODIGO_ASIG = asig.CODIGO_ASIG
                                                INNER JOIN periodo_academico AS per
                                                ON h.ID_PER = per.ID_PER
                                                INNER JOIN hora AS ho
                                                ON h.ID_HORA = ho.ID_HORA
                                                INNER JOIN dia AS d
                                                ON h.ID_DIA = d.ID_DIA
                                                INNER JOIN aula_laboratorio AS a
                                                ON h.ID_AUL = a.ID_AUL
                                                INNER JOIN carrera AS c
                                                ON h.ID_CAR = c.ID_CAR
                                                INNER JOIN semestre AS s
                                                ON h.ID_SEM = s.ID_SEM                                                
                                                WHERE 
                                                h.ID_CAR = " . $car . " AND h.ID_PER = " . $per . "                                                 
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
            $datos[$cont]['ID_DIA'] = $hor['ID_DIA'];
            $datos[$cont]['ID_HORA'] = $hor['ID_HORA'];
            $datos[$cont]['CODIGO_ASIG'] = $hor['CODIGO_ASIG'];
            $datos[$cont]['CEDULA_DOC'] = $hor['CEDULA_DOC'];
            $datos[$cont]['ID_AUL'] = $hor['ID_AUL'];
        }
        $datos[0][0] = $cont;
        return json_encode($datos);
    }

    public function actionListar_pdf() {
        //Llamamos a la conexión de la base de datos
        $db = Yii::$app->db;
        
        //asignamos las variables de sesion a una variable periodo-carrera
        $session = Yii::$app->session;
        $periodo = ' ';
        $carrera = ' ';

        //----------------------------------------------------------------------- 
        //para imprimir carrera y periodo sin tener q abrir un for en el listar_pdf
        if (isset($session['id_per_listar'])) {
            $periodo = $session['id_per_listar'];
            $m_periodo = PeriodoAcademico::findOne($periodo);
        };

        if (isset($session['id_car_listar'])) {
            $carrera = $session['id_car_listar'];
            //funcion sql para ver si existe algun registro de la carrera selecionado y asi mostrar
            $sql_carrera = "SELECT NOMBRE_CAR FROM carrera                                              
                        WHERE ID_CAR IN (SELECT h.`ID_CAR` FROM carrera AS a
                        INNER JOIN `dia_aula_hora` AS h
                        ON a.`ID_CAR` = h.`ID_CAR` 
                        WHERE h.ID_CAR = '". $carrera ."' AND h.ID_PER = '". $periodo ."')";
            $m_carrera = Carrera::findBySql($sql_carrera)->one();
            $sql_hora=" SELECT
                    * FROM hora
                    WHERE `ID_HORA` IN (SELECT h.`ID_HORA` FROM `hora` AS a 
                    INNER JOIN `dia_aula_hora` AS h 
                    ON a.`ID_HORA` = h.`ID_HORA` 
                    WHERE h.ID_CAR = ".$carrera." AND h.ID_PER = '".$periodo."' AND h.ID_CAR = '".$carrera."' )ORDER BY `INICIO_HORA`";
            $horas = Hora::findBySql($sql_hora)->all();
        }
        //----------------------------------------------------------------------
        //----------------------------------------------------------------------       
        $dias = Dia::find()->all(); 
        //----------------------------------------------------------------------
        
        $listar_horarios = $db->createCommand("SELECT CONCAT(doc.NOMBRES_DOC, ' ', doc.APELLIDOS_DOC ) AS CEDULA_DOC,
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
                                                h.ID_CAR = '". $carrera ."' AND h.ID_PER = '". $periodo ."'                                                 
                                                ORDER BY s.`ID_SEM`, PARALELO")->queryAll();

        //consulta sql para mostrar datos en la tabla
        if (isset($m_carrera->NOMBRE_CAR)) {
            $mpdf = new mPDF([ 'mode' => 'utf-8','format' => 'A4-L', 'orientation' => 'L']);
            //([ 'mode' => 'utf-8','format' => 'A4-L', 'orientation' => 'L']); 
            $mpdf->SetTitle("Lista de horarios de clase carrera: " . $m_carrera->NOMBRE_CAR);
            $mpdf->SetAuthor("FIE-ESPOCH");
            $mpdf->showWatermarkText = true;
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->watermarkTextAlpha = 0.1;
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->WriteHTML($this->renderPartial('listar_pdf', array(
                        'listar_horarios' => $listar_horarios,
                        'm_periodo' => $m_periodo,
                        'm_carrera' => $m_carrera,
                        'dias' => $dias,
                        'horas' => $horas,
                            ), true));
            $mpdf->Output('Lista de horarios de clase carrera:' . $m_carrera->NOMBRE_CAR . ' ' . date('Y-m-d') . '.pdf', 'I');
            exit();
        }
    }
    //---------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------
    
    //funcion para consultar las horas disponibles de un horario en un día (agregarh) en views carsem-asig-per
    public function actionListar_hora_dia($id) {
        $session = Yii::$app->session;
        $per = $session['id_periodo']; //periodo
        $car = $session['id_carrera']; //carrera
        $sem = $session['id_semestre']; //semestre   
        $par = $session['id_paralelo']; //paralelo
        $doc = $session['id_docente']; //docente
        $session['id_dia'] = $id; //dia
        $horas = "SELECT
                            * FROM `hora`
                            WHERE `ID_HORA` NOT IN (SELECT d.`ID_HORA` FROM `hora` AS h 
                            INNER JOIN `dia_aula_hora` AS d 
                            ON h.`ID_HORA` = d.`ID_HORA` 
                            WHERE d.ID_CAR = '" . $car . "' AND d.ID_SEM = '" . $sem . "' AND 
                            d.ID_PER = '" . $per . "' AND d.PARALELO = '" . $par . "' "
                            . "AND d.ID_DIA = '" . $id . "')AND `ID_HORA` NOT IN (SELECT d.`ID_HORA` FROM `hora` AS h 
                            INNER JOIN `dia_aula_hora` AS d 
                            ON h.`ID_HORA` = d.`ID_HORA` 
                            INNER JOIN docente AS doc
                            ON d.`CEDULA_DOC` = doc.`CEDULA_DOC`
                            WHERE d.ID_PER = '" . $per . "' AND d.ID_DIA = '" . $id . "' 
                            AND d.`CEDULA_DOC`='". $doc."') AND ESTADO_HORA=1 ORDER BY INICIO_HORA asc";

        $exist_hor = Hora::findBySql($horas)->all();
//                 echo "<option value = '0'>"                                 
//                ."Seleccionar...</option>";
        foreach ($exist_hor as $hora)
            echo "<option value = '" . $hora->ID_HORA . "'>" . $hora->INICIO_HORA . ' ' . $hora->FIN_HORA . "</option>";
    }

    //funcion para consultar las aulas disponibles de un horario en una hora (agregarh)en views carsem-asig-per
    public function actionListar_aula_hora($id) {
        $session = Yii::$app->session;
        $per = $session['id_periodo']; //periodo               
        $dia = $session['id_dia']; //dia  
        $session['id_hora'] = $id; //hora
        $aulas = "SELECT
                            * FROM `aula_laboratorio`
                            WHERE `ID_AUL` NOT IN (SELECT d.`ID_AUL` FROM `aula_laboratorio` AS a 
                            INNER JOIN `dia_aula_hora` AS d 
                            ON a.`ID_AUL` = d.`ID_AUL` 
                            WHERE d.ID_PER = '" . $per . "' AND d.ID_DIA = '" . $dia . "'"
                . "AND d.ID_HORA = '" . $id . "')AND ESTADO_AUL=1 ";

        $exist_aulas = AulaLaboratorio::findBySql($aulas)->all();
        foreach ($exist_aulas as $aul)
            echo "<option value = '" . $aul->ID_AUL . "'>" . $aul->NOMBRE_AUL . "</option>";
    }
    
    //funcion para guardar día cuando se cambia de día en la vista modificarh (en views carsem-asig-per)
    public function actionGuardar_dia_mh($id) {
        $session = Yii::$app->session;
        $session['id_dia'] = $id;
    } 

    //************************************************************************************************
    //*********************************** REPORTE DE ASIGNACIÓN DE AULAS Y LABORATORIOS **************
    //************************************************************************************************
    //++ función del reporte por asignación de aulas_laboratorios ++
    public function actionRep_asig_aulas() {
        //Eliminamos variable de sesión en caso de que exista para generar reporte pdf
        $session = Yii::$app->session;
        if (isset($session['aulas_periodo']) ||isset($session['asig_aulas_reporte'])) {
            $session->remove('asig_aulas_reporte');
            $session->remove('aulas_periodo');
        };
        //Eliminamos variable de sesión en caso de que exista para generar reporte pdf
        $model = new DiaAulaHora();
        return $this->render('rep_asig_aulas', [
                    'model' => $model,
        ]);
    }

    //++ fin de función del reporte por asignación de aulas_laboratorios ++
    //++ función de buscar todas aulas asignadas a las materias al escoger un periodo academico (datos mostrados en tabla)++
    public function actionBuscar_aulas_periodo($id) {
        //Llamamos a la conexión de la base de datos para hacer la consulta
        //se hizo así la consulta xq no había como guardar los datos en un modelo debido a que eran demasiados
        $db = Yii::$app->db;
        $session = Yii::$app->session;
        $session['aulas_periodo'] = $id;
        //Guardamos en una variable de sesión para generar el pdf

        $resultado = $db->createCommand("SELECT 
            i.`DESCRIPCION_DIA` AS ID_DIA,
            CONCAT(per.INICIO_PER, ' hasta ', per.FIN_PER) AS ID_PER,
            CONCAT(r.`INICIO_HORA`, ' - ',r.`FIN_HORA`) AS ID_HORA,   
            c.`NOMBRE_CAR` AS ID_CAR,
            s.`DESCRIPCION_SEM` AS ID_SEM, 
            h.`PARALELO` AS PARALELO,
            a.`NOMBRE_ASIG` AS CODIGO_ASIG,
            CONCAT(d.`APELLIDOS_DOC`, ' ',d.`NOMBRES_DOC`) AS CEDULA_DOC,
            l.`NOMBRE_AUL` AS ID_AUL             
            FROM `dia_aula_hora` AS h         
        INNER JOIN asignatura AS a
        ON a.`CODIGO_ASIG` = h.`CODIGO_ASIG`
        INNER JOIN docente AS d
        ON d.`CEDULA_DOC` = h.`CEDULA_DOC`
        INNER JOIN periodo_academico AS per
        ON h.ID_PER = per.ID_PER
        INNER JOIN dia AS i
        ON i.`ID_DIA` = h.`ID_DIA`
        INNER JOIN hora AS r
        ON r.`ID_HORA` = h.`ID_HORA`
        INNER JOIN aula_laboratorio AS l
        ON l.`ID_AUL` = h.`ID_AUL`
        INNER JOIN carrera AS c
        ON c.`ID_CAR` = h.`ID_CAR`   
        INNER JOIN semestre AS s
        ON s.`ID_SEM` = h.`ID_SEM`   
        WHERE 
        (h.`ID_PER`=" . $id . " AND l.ESTADO_AUL = 1)
        ORDER BY l.ID_AUL, c.`ID_CAR`, i.ID_DIA, r.ID_HORA   
        ")->queryAll();
        //consulta sql para mostrar datos en la tabla
        //crear modelo para guardar datos del horario        
        $datos = [];
        $cont = 0;
        foreach ($resultado as $hor) {
            $cont++;
            $datos[$cont]['Dia'] = $hor['ID_DIA'];
            $datos[$cont]['Periodo'] = $hor['ID_PER'];
            $datos[$cont]['Hora'] = $hor['ID_HORA'];
            $datos[$cont]['Carrera'] = $hor['ID_CAR'];
            $datos[$cont]['Semestre'] = $hor['ID_SEM'];
            $datos[$cont]['Paralelo'] = $hor['PARALELO'];
            $datos[$cont]['Docente'] = $hor['CEDULA_DOC'];
            $datos[$cont]['Asignatura'] = $hor['CODIGO_ASIG'];
            $datos[$cont]['Aula'] = $hor['ID_AUL'];
        }
        $datos[0][0] = $cont;
        return json_encode($datos);
    }

    public function actionGrafico_reporte_aula() {
        $id = $_POST['id'];
        //modelo para grafico de asignacion de aulas 
        $modelo_asig_aulas = AulaLaboratorio::findBySql("SELECT COUNT(h.ID_AUL) AS ID_AUL, NOMBRE_AUL
        FROM aula_laboratorio AS a
        INNER JOIN `dia_aula_hora` AS h
        ON h.ID_AUL = a.ID_AUL
        WHERE (h.`ID_PER`= " . $id . " AND a.ESTADO_AUL=1)
        GROUP BY h.ID_AUL 
        ")->all();
        //modelo para grafico de asignacion de aulas  
        $datos = [];
        $cont = 0;
        foreach ($modelo_asig_aulas as $gra) {
            $cont++;
            $datos[$cont]['Aula'] = $gra->NOMBRE_AUL;
            $datos[$cont]['Cantidad'] = $gra->ID_AUL; //en ID_AUL estamos guardando la cantidad de veces utilizada el aula
        }
        $datos[0][0] = $cont;
        return json_encode($datos);
    }

    //++ función para buscar inf de aulas asignadas(funcion utilizada en reporte para mostrar tabla de datos) ++
    public function actionBuscar_aulas_asignadas($periodo, $aula) {
        //Llamamos a la conexión de la base de datos
        $db = Yii::$app->db;

        //Guardamos en una variable de sesión el aula o laboratorio escogido para generar el pdf  
        $session = Yii::$app->session;
        $session['asig_aulas_reporte'] = $aula;
        $session['aulas_periodo'] = $periodo;
        //Fin de guardamos en una variable de sesión el aula o laboratorio escogido para generar el pdf 
        //crear modelo para guardar datos del horario      
        $resultado = $db->createCommand("SELECT 
            i.`DESCRIPCION_DIA` AS ID_DIA,
            CONCAT(per.INICIO_PER, ' hasta ', per.FIN_PER) AS ID_PER,
            CONCAT(r.`INICIO_HORA`, ' - ',r.`FIN_HORA`) AS ID_HORA,   
            c.`NOMBRE_CAR` AS ID_CAR,
            s.`DESCRIPCION_SEM` AS ID_SEM, 
            h.`PARALELO` AS PARALELO,
            a.`NOMBRE_ASIG` AS CODIGO_ASIG,
            l.`NOMBRE_AUL` AS ID_AUL,             
            CONCAT(d.`APELLIDOS_DOC`, ' ',d.`NOMBRES_DOC`) AS CEDULA_DOC
            FROM `dia_aula_hora` AS h           
        INNER JOIN asignatura AS a
        ON a.`CODIGO_ASIG` = h.`CODIGO_ASIG`
        INNER JOIN docente AS d
        ON d.`CEDULA_DOC` = h.`CEDULA_DOC`
        INNER JOIN dia AS i
        ON i.`ID_DIA` = h.`ID_DIA`
        INNER JOIN hora AS r
        ON r.`ID_HORA` = h.`ID_HORA`
        INNER JOIN periodo_academico AS per
        ON h.ID_PER = per.ID_PER
        INNER JOIN aula_laboratorio AS l
        ON l.`ID_AUL` = h.`ID_AUL`
        INNER JOIN carrera AS c
        ON c.`ID_CAR` = h.`ID_CAR`   
        INNER JOIN semestre AS s
        ON s.`ID_SEM` = h.`ID_SEM`   
        WHERE 
        (h.`ID_AUL`= '" . $aula . "' AND h.`ID_PER`='" . $periodo . "')
        ORDER BY i.ID_DIA, c.`ID_CAR`, r.ID_HORA      
        ")->queryAll();

        $datos = [];
        $cont = 0;
        foreach ($resultado as $hor) {
            $cont++;
            $datos[$cont]['Dia'] = $hor['ID_DIA'];
            $datos[$cont]['Hora'] = $hor['ID_HORA'];
            $datos[$cont]['Carrera'] = $hor['ID_CAR'];
            $datos[$cont]['Semestre'] = $hor['ID_SEM'];
            $datos[$cont]['Paralelo'] = $hor['PARALELO'];
            $datos[$cont]['Docente'] = $hor['CEDULA_DOC'];
            $datos[$cont]['Asignatura'] = $hor['CODIGO_ASIG'];
            $datos[$cont]['Aula'] = $hor['ID_AUL'];
            $datos[$cont]['Periodo'] = $hor['ID_PER'];
        }
        $datos[0][0] = $cont;
        return json_encode($datos);
    }

    //++ fin de función para buscar inf aulas asignadas  ++
    //++ función para pdf del reporte por asignación de aulas_laboratorios ++
    public function actionRep_asig_aulas_pdf() {
        //Llamamos a la conexión de la base de datos
        $db = Yii::$app->db;
        
        //asignamos las variables de sesion a una variable periodo-carrera
        $session = Yii::$app->session;
        $periodo = '';
        $aula = '';
        $m_aula = '';

        //---------------------------------------------------------------------
        //para imprimir aulas y periodo sin tener q abrir un foreach de rep_aulas en el listar_pdf 
        if (isset($session['asig_aulas_reporte'])) {
            $aula = $session['asig_aulas_reporte'];
            $m_aula = AulaLaboratorio::findOne($aula);
        };

        if (isset($session['aulas_periodo'])) {
            $periodo = $session['aulas_periodo'];
             //consulta para ver si existen registros del periodo seleccionado (y asi mostrar en el pdf)
            $sql_periodo = "SELECT * FROM periodo_academico                                              
                            WHERE ID_PER IN (SELECT h.`ID_PER` FROM periodo_academico AS a
                            INNER JOIN `dia_aula_hora` AS h
                            ON a.`ID_PER` = h.`ID_PER` 
                            WHERE h.ID_PER = '". $periodo ."')";
            $m_periodo = PeriodoAcademico::findBySql($sql_periodo)->one();            
        };                

        //---------------------------------------------------------------------
        if (isset($session['asig_aulas_reporte']) && isset($session['aulas_periodo'])) {
                $rep_aulas = $db->createCommand("SELECT 
                i.`DESCRIPCION_DIA` AS ID_DIA,
                CONCAT(per.INICIO_PER, ' hasta ', per.FIN_PER) AS ID_PER,
                CONCAT(r.`INICIO_HORA`, ' - ',r.`FIN_HORA`) AS ID_HORA,   
                c.`NOMBRE_CAR` AS ID_CAR,
                s.`DESCRIPCION_SEM` AS ID_SEM, 
                h.`PARALELO` AS PARALELO,
                a.`NOMBRE_ASIG` AS CODIGO_ASIG,
                l.`NOMBRE_AUL` AS ID_AUL,             
                CONCAT(d.`APELLIDOS_DOC`, ' ',d.`NOMBRES_DOC`) AS CEDULA_DOC
                FROM `dia_aula_hora` AS h           
            INNER JOIN asignatura AS a
            ON a.`CODIGO_ASIG` = h.`CODIGO_ASIG`
            INNER JOIN docente AS d
            ON d.`CEDULA_DOC` = h.`CEDULA_DOC`
            INNER JOIN dia AS i
            ON i.`ID_DIA` = h.`ID_DIA`
            INNER JOIN hora AS r
            ON r.`ID_HORA` = h.`ID_HORA`
            INNER JOIN periodo_academico AS per
            ON h.ID_PER = per.ID_PER
            INNER JOIN aula_laboratorio AS l
            ON l.`ID_AUL` = h.`ID_AUL`
            INNER JOIN carrera AS c
            ON c.`ID_CAR` = h.`ID_CAR`   
            INNER JOIN semestre AS s
            ON s.`ID_SEM` = h.`ID_SEM`   
            WHERE 
            (h.`ID_AUL`= '". $aula ."' AND h.`ID_PER`='". $periodo ."')
            ORDER BY i.ID_DIA, c.`ID_CAR`, r.ID_HORA      
            ")->queryAll();
        }else{ if (isset($session['aulas_periodo'])) {
                $rep_aulas = $db->createCommand("SELECT 
                i.`DESCRIPCION_DIA` AS ID_DIA,
                CONCAT(per.INICIO_PER, ' hasta ', per.FIN_PER) AS ID_PER,
                CONCAT(r.`INICIO_HORA`, ' - ',r.`FIN_HORA`) AS ID_HORA,   
                c.`NOMBRE_CAR` AS ID_CAR,
                s.`DESCRIPCION_SEM` AS ID_SEM, 
                h.`PARALELO` AS PARALELO,
                a.`NOMBRE_ASIG` AS CODIGO_ASIG,
                CONCAT(d.`APELLIDOS_DOC`, ' ',d.`NOMBRES_DOC`) AS CEDULA_DOC,
                l.`NOMBRE_AUL` AS ID_AUL             
                FROM `dia_aula_hora` AS h         
            INNER JOIN asignatura AS a
            ON a.`CODIGO_ASIG` = h.`CODIGO_ASIG`
            INNER JOIN docente AS d
            ON d.`CEDULA_DOC` = h.`CEDULA_DOC`
            INNER JOIN periodo_academico AS per
            ON h.ID_PER = per.ID_PER
            INNER JOIN dia AS i
            ON i.`ID_DIA` = h.`ID_DIA`
            INNER JOIN hora AS r
            ON r.`ID_HORA` = h.`ID_HORA`
            INNER JOIN aula_laboratorio AS l
            ON l.`ID_AUL` = h.`ID_AUL`
            INNER JOIN carrera AS c
            ON c.`ID_CAR` = h.`ID_CAR`   
            INNER JOIN semestre AS s
            ON s.`ID_SEM` = h.`ID_SEM`   
            WHERE 
            (h.`ID_PER`='". $periodo ."' AND l.ESTADO_AUL = 1)
            ORDER BY l.ID_AUL, c.`ID_CAR`, i.ID_DIA, r.ID_HORA     
            ")->queryAll();
        }}

        //consulta sql para mostrar datos en la tabla
        if (isset($m_periodo->ID_PER)) {
            $mpdf = new mPDF();
            $mpdf->SetTitle("Reporte del uso de aulas y laboratorios: " . $m_periodo->ID_PER);
            $mpdf->SetAuthor("FIE-ESPOCH");
            $mpdf->showWatermarkText = true;
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->watermarkTextAlpha = 0.1;
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->WriteHTML($this->renderPartial('rep_asig_aulas_pdf', array(
                        'rep_aulas' => $rep_aulas,
                        'm_periodo' => $m_periodo,
                        'm_aula' => $m_aula,
                            ), true));
            $mpdf->Output('Reporte del uso de aulas y laboratorios:' . $m_periodo->ID_PER . ' ' . date('Y-m-d') . '.pdf', 'I');
            exit();
        }
    }   

    //************************************************************************************************
    //*********************************** REPORTE DE ASIGNACIÓN DE AULAS Y LABORATORIOS **************
    //************************************************************************************************

    /**
     * Creates a new DiaAulaHora model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new DiaAulaHora1();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'CODIGO_ASIG' => $model->CODIGO_ASIG, 'ID_PER' => $model->ID_PER, 'CEDULA_DOC' => $model->CEDULA_DOC, 'ID_HORA' => $model->ID_HORA, 'ID_DIA' => $model->ID_DIA, 'ID_AUL' => $model->ID_AUL, 'PARALELO' => $model->PARALELO, 'ID_CAR' => $model->ID_CAR, 'ID_SEM' => $model->ID_SEM]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing DiaAulaHora1 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $CODIGO_ASIG
     * @param integer $ID_PER
     * @param string $CEDULA_DOC
     * @param integer $ID_HORA
     * @param integer $ID_DIA
     * @param integer $ID_AUL
     * @param string $PARALELO
     * @param integer $ID_CAR
     * @param integer $ID_SEM
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($CODIGO_ASIG, $ID_PER, $CEDULA_DOC, $ID_HORA, $ID_DIA, $ID_AUL, $PARALELO, $ID_CAR, $ID_SEM) {
        $model = $this->findModel($CODIGO_ASIG, $ID_PER, $CEDULA_DOC, $ID_HORA, $ID_DIA, $ID_AUL, $PARALELO, $ID_CAR, $ID_SEM);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'CODIGO_ASIG' => $model->CODIGO_ASIG, 'ID_PER' => $model->ID_PER, 'CEDULA_DOC' => $model->CEDULA_DOC, 'ID_HORA' => $model->ID_HORA, 'ID_DIA' => $model->ID_DIA, 'ID_AUL' => $model->ID_AUL, 'PARALELO' => $model->PARALELO, 'ID_CAR' => $model->ID_CAR, 'ID_SEM' => $model->ID_SEM]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DiaAulaHora1 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $CODIGO_ASIG
     * @param integer $ID_PER
     * @param string $CEDULA_DOC
     * @param integer $ID_HORA
     * @param integer $ID_DIA
     * @param integer $ID_AUL
     * @param string $PARALELO
     * @param integer $ID_CAR
     * @param integer $ID_SEM
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($CODIGO_ASIG, $ID_PER, $CEDULA_DOC, $ID_HORA, $ID_DIA, $ID_AUL, $PARALELO, $ID_CAR, $ID_SEM) {
        $this->findModel($CODIGO_ASIG, $ID_PER, $CEDULA_DOC, $ID_HORA, $ID_DIA, $ID_AUL, $PARALELO, $ID_CAR, $ID_SEM)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DiaAulaHora1 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $CODIGO_ASIG
     * @param integer $ID_PER
     * @param string $CEDULA_DOC
     * @param integer $ID_HORA
     * @param integer $ID_DIA
     * @param integer $ID_AUL
     * @param string $PARALELO
     * @param integer $ID_CAR
     * @param integer $ID_SEM
     * @return DiaAulaHora1 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($CODIGO_ASIG, $ID_PER, $CEDULA_DOC, $ID_HORA, $ID_DIA, $ID_AUL, $PARALELO, $ID_CAR, $ID_SEM) {
        if (($model = DiaAulaHora::findOne(['CODIGO_ASIG' => $CODIGO_ASIG, 'ID_PER' => $ID_PER, 'CEDULA_DOC' => $CEDULA_DOC, 'ID_HORA' => $ID_HORA, 'ID_DIA' => $ID_DIA, 'ID_AUL' => $ID_AUL, 'PARALELO' => $PARALELO, 'ID_CAR' => $ID_CAR, 'ID_SEM' => $ID_SEM])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }

}
