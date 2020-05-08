<?php
use Mpdf\Mpdf;
use yii\helpers\Html;
?>
<!DOCTYPE html>
<style> 
   div.onitsside {
    /*page: rotated;*/
    page-break-after: always;   
}
</style>
<html lang="es">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">        
    </head>
    <body>
        <!--mpdf
         <htmlpageheader name="myheader">
         <table width="100%"><tr>
         <td width="2px" rowspan="2">
        </td>   
         </tr>
        </table>
         </htmlpageheader>
        <htmlpagefooter name="myfooter">
         <div style="border-top: 1px solid #000000; font-size: 9pt; text-align: left; padding-top: 3mm; ">       
        <b>Fuente: </b>
        Sistema-SwSearch
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
        Página {PAGENO} de {nb}
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
        <b>Impreso el </b>
        <?= date('Y-m-d H:i:s') ?>         
         </div>   
         </htmlpagefooter>
        
        <sethtmlpageheader name="myheader" value="on" show-this-page="1" />       
        <sethtmlpagefooter name="myfooter" value="on" />
        
        mpdf-->       
        <?php
        $this->title = 'HORARIO DE CLASE';
        ?>

        <div class="row ">    
            <?php
            $aux_semestre = 'vacio';
            $aux_paralelo = 'vacio';
            foreach ($des_horario as $hi) {
                if ($hi['ID_SEM'] != $aux_semestre || $hi['PARALELO'] != $aux_paralelo) {
                    $aux_paralelo = $hi['PARALELO'];
                    $aux_semestre = $hi['ID_SEM'];
                    ?>
                    <div style="page-break-after: always;"> <!-- para un salto de pagina forzado-->
                    <h3  style="text-align:center;">ESCUELA SUPERIOR POLITÉCNICA DE CHIMBORAZO</h3>
                    <table width="100%" >
                        <tr>
                            <td width="50%" >
                                <?= Html::img(Yii::$app->homeUrl . '/imagenes/logo-espoch.png', ['width' => '7%', 'class' => '',]) ?>
                                <?php echo "<br>" . "<b>FACULTAD: </b>" . "INFORMÁTICA Y ELECTRÓNICA";
                                    echo "<br>";
                                    echo "<br>";
                                    echo "<br>";                               
                                    echo "<br>";
                                ?> 
                            </td> 
                            <td width="50%" style="text-align:right;" >
                                <?= Html::img(Yii::$app->homeUrl . '/imagenes/logo-eis.jpg', ['width' => '7%', 'class' => '',]) ?>
                                <?php
                                echo "<br>" . "<b>ESCUELA: </b>" . "INGENIERÍA EN SISTEMAS";
                                echo "<br>";
                                echo "<b>CARRERA: </b>" . $m_carrera->NOMBRE_CAR;
                                echo "<br>";
                                echo "<b>" . $m_periodo->INICIO_PER . ' hasta ' . $m_periodo->FIN_PER . "</b>";
                                ?>                      
                            </td> 
                        </tr>
                    </table>

                    <p style="text-align:center;" >
                        <?php
                        echo "<b>HORARIO DE CLASES </b>";
                        echo "<br>";
                        echo "<b>" . $hi['ID_SEM'] . ' NIVEL - PARALELO ' . $hi['PARALELO'] . "</b>";
                        ?>   
                    </p>                
                    <table border="1" cellspacing="0" width="100%">
                        <thead style="text-align:center;" >
                            <tr>
                                <td width="10%"><b>Hora</b></td> 
                                <?php foreach ($dias as $dia) { ?>
                                    <td width="18%" class="text-center"><b><?= $dia->DESCRIPCION_DIA ?></b></td>
                                <?php } ?> 
                            </tr>
                        </thead>
                        <tbody >
                            <?php foreach ($horas as $hora) { ?>
                                <tr >
                                    <td style="text-align:center;"><strong><?= $hora->INICIO_HORA . ' - ' . $hora->FIN_HORA ?></strong></td>                          
                                    <?php foreach ($dias as $dia) { ?>
                                        <td style="text-align:center;">
                                            <?php
                                            foreach ($des_horario as $hd) {
                                                if ($hd['ID_SEM'] == $hi['ID_SEM'] && $hd['PARALELO'] == $hi['PARALELO'] && $hd['ID_DIA'] == ($dia->DESCRIPCION_DIA) && $hd['ID_HORA'] == ($hora->INICIO_HORA . ' - ' . $hora->FIN_HORA)) {
                                                    echo $hd['CODIGO_ASIG'] . "<br>";
                                                    echo $hd['CEDULA_DOC'] . "<br>";
                                                    echo $hd['ID_AUL'];
                                                }
                                            }
                                            ?>                   
                                        </td>
                                    <?php } //cierre de if de dia?> 
                                </tr>
                            <?php } //cierre de if de horas ?>  
                        </tbody>
                    </table>
                    </div> <!--salto de pagina forzado-->
                    <?php
                } //fin de primer if condicionando aux_semestre y aux_paralelo
            } //fin de primer foreach hi
            
            ?>
        </div>
    </body>
</html>  