<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <script language="javascript">

        function Salva() {

            document.forms["ModificaSoluzioneInsacco"].action = "manage_val_par_sacco2.php";
            document.forms["ModificaSoluzioneInsacco"].submit();

        }

      

    </script>    

    <body>
        <div id="mainContainer">
            <?php
            if ($DEBUG)
                ini_set("display_errors", "1");
            include('../include/menu.php');
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_parametro_sing_mac.php');
            include('../sql/script_valore_par_sacchetto.php');

            $IdCategoria = 0;
            $NumSacchetti = 0;
            $pesoSaccoDefault = 0;

            if (isSet($_POST['IdCategoria']) AND isSet($_POST['NumSacchetti'])) {

                $IdCategoria = $_POST['IdCategoria'];
                $NumSacchetti = $_POST['NumSacchetti'];
                if ($NumSacchetti > 0)
                    $pesoSaccoDefault = number_format($valDefaultPesoMiscela / $NumSacchetti, 0, '', '');
            }

            begin();
            $sqlCat = findCategoriaFromValParSac($IdCategoria);

            while ($rowCat = mysql_fetch_array($sqlCat)) {

                $NomeCategoria = $rowCat['nome_categoria'];
                
            }
           
            ?>
            <div id="container" style=" width:100%; margin:15px auto;">
                <form id="ModificaSoluzioneInsacco" name="ModificaSoluzioneInsacco" method="POST">
                    <input type="hidden" name="IdCategoria" id="IdCategoria" value=<?php echo $IdCategoria; ?>></input>
                    <input type="hidden" name="NumSacchetti" id="NumSacchetti" value=<?php echo $NumSacchetti; ?>></input>

                    <table width="100%">
                        <tr>
                            <td  class="cella3" style="font-size: 20px" colspan="3"><?php echo $filtroVerificaConfigSacchi ?></td>
                        </tr>                        
                        <tr>
                            <td class="cella2" style="font-size: 20px"><?php echo $filtroCategoria . " " . $IdCategoria ?> </td>                            
                            <td class="cella1" style="font-size: 20px"><?php echo $NomeCategoria ?></td>
                            <td class="cella1" style="font-size: 20px"><?php echo $NumSacchetti . " " . $filtroSacchi ?></td>
                        </tr>
                    </table>
                    <table width="100%">
                       
                            <!-- ###########################################################-->
                            <td class="cella2" style="text-align: right " >
                                <input type="reset" onClick="javascript:history.back();" value="<?php echo $valueButtonAnnulla ?>" />
                                <input type="button" onClick="javascript:Salva()" value="<?php echo $valueButtonSalva ?>" title="<?php echo $titleSalvaConfSacchi ?>"/></td>
                        </tr>
                    </table>
                    <?php
################################################################################
//Per facilitare il salvataggio creo un array contenente tutti gli id_val_par_sac 
                    $v = 0;
                    $arrayTotValori = array();
                    for ($sacco = 1; $sacco <= $NumSacchetti; $sacco++) {
// #############################################################################
// ################ ORIGAMI 5-6 ################################################
// #############################################################################

                        $arraySacco = array();
                        $arrayVelocita = array();
                        $arrayPesatura = array();
                        $arrayAliquoteSm = array();
                        $arrayTempiApertura = array();
                        $arrayTempiChiusura = array();

                        // ################ PARAMETRI DEL SACCO  ###################################
                        $sqlValoriSacco = selectValoriBySoluzione($IdCategoria, $NumSacchetti, 1, $sacco);
                        $i = 0;
                        while ($row = mysql_fetch_array($sqlValoriSacco)) {

                            $arraySacco['idPar'][$i] = $row['id_par_sac'];
                            $arraySacco['idVal'][$i] = $row['id_val_par_sac'];
                            $arraySacco['nomePar'][$i] = $row['nome_variabile'];
                            $arraySacco['nomeVis'][$i] = $row['nome_vis'];
                            $arraySacco['valore'][$i] = $row['valore_variabile'];

                            //Se il valore è stato modificato l'array viene aggiornato
                            if (isSet($_POST['Valore' . $row["id_val_par_sac"]]))
                                $arraySacco['valore'][$i] = $_POST['Valore' . $row["id_val_par_sac"]];

                            $arraySacco['uniMis'][$i] = $row['uni_mis'];
                            $i++;

                            $arrayTotValori['idValParSac'][$v] = $row['id_val_par_sac'];
                            $arrayTotValori['valoreOld'][$v] = $row['valore_variabile'];
                            $v++;
                        }
                        // ################ VELOCITA ################################################
                        $sqlValoriVelocita = selectValoriBySoluzione($IdCategoria, $NumSacchetti, 2, $sacco);
                        $i = 0;
                        while ($row = mysql_fetch_array($sqlValoriVelocita)) {

                            $arrayVelocita['idPar'][$i] = $row['id_par_sac'];
                            $arrayVelocita['idVal'][$i] = $row['id_val_par_sac'];
                            $arrayVelocita['nomePar'][$i] = $row['nome_variabile'];
                            $arrayVelocita['nomeVis'][$i] = $row['nome_vis'];
                            $arrayVelocita['valore'][$i] = $row['valore_variabile'];

                            //Se il valore è stato modificato l'array viene aggiornato
                            if (isSet($_POST['Valore' . $row["id_val_par_sac"]]))
                                $arrayVelocita['valore'][$i] = $_POST['Valore' . $row["id_val_par_sac"]];


                            $arrayVelocita['uniMis'][$i] = $row['uni_mis'];
                            $i++;

                            $arrayTotValori['idValParSac'][$v] = $row['id_val_par_sac'];
                            $arrayTotValori['valoreOld'][$v] = $row['valore_variabile'];
                            $v++;
                        }

                        // ################ PESATURA ###############################################
                        $sqlValoriPesatura = selectValoriBySoluzione($IdCategoria, $NumSacchetti, 3, $sacco);
                        $i = 0;
                        while ($row = mysql_fetch_array($sqlValoriPesatura)) {

                            $arrayPesatura['idPar'][$i] = $row['id_par_sac'];
                            $arrayPesatura['idVal'][$i] = $row['id_val_par_sac'];
                            $arrayPesatura['nomePar'][$i] = $row['nome_variabile'];
                            $arrayPesatura['nomeVis'][$i] = $row['nome_vis'];
                            $arrayPesatura['valore'][$i] = $row['valore_variabile'];

                            //Se il valore è stato modificato l'array viene aggiornato
                            if (isSet($_POST['Valore' . $row["id_val_par_sac"]]))
                                $arrayPesatura['valore'][$i] = $_POST['Valore' . $row["id_val_par_sac"]];

                            $arrayPesatura['uniMis'][$i] = $row['uni_mis'];
                            $i++;

                            $arrayTotValori['idValParSac'][$v] = $row['id_val_par_sac'];
                            $arrayTotValori['valoreOld'][$v] = $row['valore_variabile'];
                            $v++;
                        }

                        //######## Parametri Singola Macchina ##############################
                        $sqlAliquote1 = findParSMById(50);
                        while ($row = mysql_fetch_array($sqlAliquote1)) {
                            $aliquotaConf['idPar'][1] = $row['id_par_sm'];
                            $aliquotaConf['nomePar'][1] = $filtroAliquota1Conf;
//                            $aliquotaConf['nomePar'][1] = $row['nome_variabile'];
                            $aliquotaConf['valore'][1] = $row['valore_base'];
                        }
                        $sqlAliquote2 = findParSMById(51);
                        while ($row = mysql_fetch_array($sqlAliquote2)) {
                            $aliquotaConf['idPar'][2] = $row['id_par_sm'];
//                            $aliquotaConf['nomePar'][2] = $row['nome_variabile'];
                            $aliquotaConf['nomePar'][2] = $filtroAliquota2Conf;
                            $aliquotaConf['valore'][2] = $row['valore_base'];
                        }
                        $sqlAliquote3 = findParSMById(52);
                        while ($row = mysql_fetch_array($sqlAliquote3)) {
                            $aliquotaConf['idPar'][3] = $row['id_par_sm'];
//                            $aliquotaConf['nomePar'][3] = $row['nome_variabile'];
                            $aliquotaConf['nomePar'][3] = $filtroAliquota3Conf;
                            $aliquotaConf['valore'][3] = $row['valore_base'];
                        }
                        $aliquotaConf['valore'][4] = 100;
                        $aliquotaConf['nomePar'][4] = $filtroAliquota4Conf;


                        $sqlSbloccoScarico = findParSMById(314);
                        while ($row = mysql_fetch_array($sqlSbloccoScarico)) {
                            $sbloccoScarico['idPar'][0] = $row['id_par_sm'];
//                            $aliquotaConf['nomePar'][3] = $row['nome_variabile'];
                            $sbloccoScarico['nomePar'][0] = $filtroSbloccoScarico;
                            $sbloccoScarico['valore'][0] = $row['valore_base'];
                        }
                        // ################ TEMPI DI APERTURA ######################################
                        $sqlTempiApertura = selectValoriBySoluzione($IdCategoria, $NumSacchetti, 4, $sacco);
                        $i = 0;
                        while ($row = mysql_fetch_array($sqlTempiApertura)) {

                            $arrayTempiApertura['idPar'][$i] = $row['id_par_sac'];
                            $arrayTempiApertura['idVal'][$i] = $row['id_val_par_sac'];
                            $arrayTempiApertura['nomePar'][$i] = $row['nome_variabile'];
                            $arrayTempiApertura['nomeVis'][$i] = $row['nome_vis'];
                            $arrayTempiApertura['valore'][$i] = $row['valore_variabile'];

                            //Se il valore è stato modificato l'array viene aggiornato
                            if (isSet($_POST['Valore' . $row["id_val_par_sac"]]))
                                $arrayTempiApertura['valore'][$i] = $_POST['Valore' . $row["id_val_par_sac"]];

                            $arrayTempiApertura['uniMis'][$i] = $row['uni_mis'];
                            $i++;

                            $arrayTotValori['idValParSac'][$v] = $row['id_val_par_sac'];
                            $arrayTotValori['valoreOld'][$v] = $row['valore_variabile'];
                            $v++;
                        }

                        // ################ TEMPI DI CHIUSURA ######################################
                        $sqlTempiChiusura = selectValoriBySoluzione($IdCategoria, $NumSacchetti, 5, $sacco);
                        $i = 0;
                        while ($row = mysql_fetch_array($sqlTempiChiusura)) {

                            $arrayTempiChiusura['idPar'][$i] = $row['id_par_sac'];
                            $arrayTempiChiusura['idVal'][$i] = $row['id_val_par_sac'];
                            $arrayTempiChiusura['nomePar'][$i] = $row['nome_variabile'];
                            $arrayTempiChiusura['nomeVis'][$i] = $row['nome_vis'];
                            $arrayTempiChiusura['valore'][$i] = $row['valore_variabile'];

                            //Se il valore è stato modificato l'array viene aggiornato
                            if (isSet($_POST['Valore' . $row["id_val_par_sac"]]))
                                $arrayTempiChiusura['valore'][$i] = $_POST['Valore' . $row["id_val_par_sac"]];

                            $arrayTempiChiusura['uniMis'][$i] = $row['uni_mis'];
                            $i++;

                            $arrayTotValori['idValParSac'][$v] = $row['id_val_par_sac'];
                            $arrayTotValori['valoreOld'][$v] = $row['valore_variabile'];
                            $v++;
                        }

                        // ########################################################################
                        // ################ ORIGAMI 4 #############################################
                        // ########################################################################
                        //Parametri macchina per le origami 4
                        $arraySaccoO4 = array();
                        $arrayPesaturaO4 = array();
                        $arrayTempiAperturaO4 = array();
                        $arrayTempiChiusuraO4 = array();

                        // ################ PARAMETRI DEL SACCO  ###################################
                        $sqlValoriSaccoO4 = selectValoriBySoluzione($IdCategoria, $NumSacchetti, '1-O4', $sacco);
                        $y = 0;
                        while ($row = mysql_fetch_array($sqlValoriSaccoO4)) {

                            $arraySaccoO4['idPar'][$y] = $row['id_par_sac'];
                            $arraySaccoO4['idVal'][$y] = $row['id_val_par_sac'];
                            $arraySaccoO4['nomePar'][$y] = $row['nome_variabile'];
                            $arraySaccoO4['nomeVis'][$y] = $row['nome_vis'];
                            $arraySaccoO4['valore'][$y] = $row['valore_variabile'];

                            //Se il valore è stato modificato l'array viene aggiornato
                            if (isSet($_POST['Valore' . $row["id_val_par_sac"]]))
                                $arraySaccoO4['valore'][$y] = $_POST['Valore' . $row["id_val_par_sac"]];

                            $arraySaccoO4['uniMis'][$y] = $row['uni_mis'];
                            $y++;

                            $arrayTotValori['idValParSac'][$v] = $row['id_val_par_sac'];
                            $arrayTotValori['valoreOld'][$v] = $row['valore_variabile'];
                            $v++;
                        }

                        // ################ VELOCITA ###############################################
                        $sqlValoriPesaturaO4 = selectValoriBySoluzione($IdCategoria, $NumSacchetti, '3-O4', $sacco);
                        $y = 0;
                        while ($row = mysql_fetch_array($sqlValoriPesaturaO4)) {

                            $arrayPesaturaO4['idPar'][$y] = $row['id_par_sac'];
                            $arrayPesaturaO4['idVal'][$y] = $row['id_val_par_sac'];
                            $arrayPesaturaO4['nomePar'][$y] = $row['nome_variabile'];
                            $arrayPesaturaO4['nomeVis'][$y] = $row['nome_vis'];
                            $arrayPesaturaO4['valore'][$y] = $row['valore_variabile'];

                            //Se il valore è stato modificato l'array viene aggiornato
                            if (isSet($_POST['Valore' . $row["id_val_par_sac"]]))
                                $arrayPesaturaO4['valore'][$y] = $_POST['Valore' . $row["id_val_par_sac"]];

                            $arrayPesaturaO4['uniMis'][$y] = $row['uni_mis'];
                            $y++;

                            $arrayTotValori['idValParSac'][$v] = $row['id_val_par_sac'];
                            $arrayTotValori['valoreOld'][$v] = $row['valore_variabile'];
                            $v++;
                        }

                        // ################ TEMPI DI APERTURA ######################################
                        $sqlTempiAperturaO4 = selectValoriBySoluzione($IdCategoria, $NumSacchetti, '4-O4', $sacco);
                        $y = 0;
                        while ($row = mysql_fetch_array($sqlTempiAperturaO4)) {

                            $arrayTempiAperturaO4['idPar'][$y] = $row['id_par_sac'];
                            $arrayTempiAperturaO4['idVal'][$y] = $row['id_val_par_sac'];
                            $arrayTempiAperturaO4['nomePar'][$y] = $row['nome_variabile'];
                            $arrayTempiAperturaO4['nomeVis'][$y] = $row['nome_vis'];
                            $arrayTempiAperturaO4['valore'][$y] = $row['valore_variabile'];

                            //Se il valore è stato modificato l'array viene aggiornato
                            if (isSet($_POST['Valore' . $row["id_val_par_sac"]]))
                                $arrayTempiAperturaO4['valore'][$y] = $_POST['Valore' . $row["id_val_par_sac"]];

                            $arrayTempiAperturaO4['uniMis'][$y] = $row['uni_mis'];
                            $y++;

                            $arrayTotValori['idValParSac'][$v] = $row['id_val_par_sac'];
                            $arrayTotValori['valoreOld'][$v] = $row['valore_variabile'];
                            $v++;
                        }

                        // ################ TEMPI DI CHIUSURA ######################################
                        $sqlTempiChiusuraO4 = selectValoriBySoluzione($IdCategoria, $NumSacchetti, '5-O4', $sacco);
                        $y = 0;
                        while ($row = mysql_fetch_array($sqlTempiChiusuraO4)) {

                            $arrayTempiChiusuraO4['idPar'][$y] = $row['id_par_sac'];
                            $arrayTempiChiusuraO4['idVal'][$y] = $row['id_val_par_sac'];
                            $arrayTempiChiusuraO4['nomePar'][$y] = $row['nome_variabile'];
                            $arrayTempiChiusuraO4['nomeVis'][$y] = $row['nome_vis'];
                            $arrayTempiChiusuraO4['valore'][$y] = $row['valore_variabile'];

                            //Se il valore è stato modificato l'array viene aggiornato
                            if (isSet($_POST['Valore' . $row["id_val_par_sac"]]))
                                $arrayTempiChiusuraO4['valore'][$y] = $_POST['Valore' . $row["id_val_par_sac"]];

                            $arrayTempiChiusuraO4['uniMis'][$y] = $row['uni_mis'];
                            $y++;

                            $arrayTotValori['idValParSac'][$v] = $row['id_val_par_sac'];
                            $arrayTotValori['valoreOld'][$v] = $row['valore_variabile'];
                            $v++;
                        }


                        //############################################################
                        //############################################################
                        //############################################################

                        commit();
                        ?>
                        <div style="background-color: #efefef;width: 100%;text-align: center;font-size:18px">
                            <?php echo "SACCO " . $sacco ?>
                            <div>
                                <!--########################################### ORIGAMI 5-6 ###############################################--> 
                                <?php
                                for ($j = 0; $j < count($arraySacco['idPar']); $j++) {
                                    ?>
                                    <input type="hidden" style="width:80px" name="Valore<?php echo $arraySacco['idVal'][$j]; ?>" value="<?php echo($arraySacco['valore'][$j]); ?>" />

                                <?php }                                
                               
                                $t = 3;
                                $valPeso = 0;
                                $pesoSaccoMenoTubo = $pesoSaccoDefault - $arraySacco['valore'][0];
                                for ($j = 0; $j < count($arrayVelocita['idPar']); $j++) {
                                    ?>
                                    <input type="hidden" style="width:80px" name="Valore<?php echo $arrayVelocita['idVal'][$j]; ?>" value="<?php echo($arrayVelocita['valore'][$j]); ?>" />
                                <?php
                                }
                                for ($j = 0; $j < count($arrayPesatura['idPar']); $j++) {
                                    ?>
                                    <input type="hidden" style="width:80px" name="Valore<?php echo $arrayPesatura['idVal'][$j]; ?>" value="<?php echo($arrayPesatura['valore'][$j]); ?>" />
                                    <?php
//                                         
                                    $valPeso = $pesoSaccoDefault - $arraySacco['valore'][0] - $arrayPesatura['valore'][$j];
                                    ?>
                                    <input type="hidden" style="width:80px" name="Valore<?php echo $arrayTempiApertura['idVal'][$j]; ?>" value="<?php echo($arrayTempiApertura['valore'][$j]); ?>" />
                                    <input type="hidden" style="width:80px" name="Valore<?php echo $arrayTempiChiusura['idVal'][$j]; ?>" value="<?php echo($arrayTempiChiusura['valore'][$j]); ?>" />
                                    </tr>
                                <?php }
                                 


                                //############################ ORIGAMI 4 #########################################
                               
                                for ($j = 0; $j < count($arraySaccoO4['idPar']); $j++) {
//                    echo "count par sacco :".count($arraySaccoO4['idPar']);
                                    ?>
                                    <input type="hidden" style="width:80px" name="Valore<?php echo $arraySaccoO4['idVal'][$j]; ?>" value="<?php echo($arraySaccoO4['valore'][$j]); ?>" />

                                <?php }
                                
                                for ($j = 0; $j < count($arrayPesaturaO4['idPar']); $j++) {
                                    ?>
                                    <input type="hidden" style="width:80px" name="Valore<?php echo $arrayPesaturaO4['idVal'][$j]; ?>" value="<?php echo($arrayPesaturaO4['valore'][$j]); ?>" />
                                    <?php
                                    $valPesoO4 = $pesoSaccoDefault - $arraySaccoO4['valore'][0] - $arrayPesaturaO4['valore'][$j];
                                    ?>
                                    <input type="hidden" style="width:80px" name="Valore<?php echo $arrayTempiAperturaO4['idVal'][$j]; ?>" value="<?php echo($arrayTempiAperturaO4['valore'][$j]); ?>" />
                                    <input type="hidden" style="width:80px" name="Valore<?php echo $arrayTempiChiusuraO4['idVal'][$j]; ?>" value="<?php echo($arrayTempiChiusuraO4['valore'][$j]); ?>" />
                                    </tr>
                                <?php }
                                ?>  
                                </table>
                            </div>


                            <?php
                            //#######################################################################
                            //#### Crea l'array contenente tutti i valori da inserire nel grafico ###
                            //#######################################################################
                            $valuesVelocita[$sacco] = [];
                            //###############################################################
                            //Aggiunta dei punti relativi alla velocità sull'asse X
                            //###############################################################
                            $t = 3;
                            $valPeso = 0;
                            for ($j = 0; $j < count($arrayVelocita['valore']); $j++) {

                                array_push($valuesVelocita[$sacco], array("PesoSacco" => $valPeso, "Velocita" => $arrayVelocita['valore'][$j]));

                                if ($t > 0) {

                                    $valPeso = ($pesoSaccoMenoTubo - $aliquotaConf['valore'][$t] * $pesoSaccoMenoTubo / 100);

                                    $pesoCalcolato = ($pesoSaccoMenoTubo - $aliquotaConf['valore'][$t] * $pesoSaccoMenoTubo / 100);
                                    $inizioPesaturaFine = $pesoSaccoMenoTubo - $arrayPesatura['valore'][0];

                                    $valPeso = $inizioPesaturaFine;
                                    if ($inizioPesaturaFine > $pesoCalcolato) {

                                        $valPeso = $pesoCalcolato;
                                    }



                                    array_push($valuesVelocita[$sacco], array("PesoSacco" => $valPeso, "Velocita" => $arrayVelocita['valore'][$j]));
                                } else if ($t = 3) {
//                                      <!-- INIZIO PESATURA FINE-->

                                    $pesoCalcolato = ($pesoSaccoMenoTubo - $aliquotaConf['valore'][1] * $pesoSaccoMenoTubo / 100);
                                    $inizioPesaturaFine = $pesoSaccoMenoTubo - $arrayPesatura['valore'][0];

                                    $valPeso = $inizioPesaturaFine;
                                    if ($inizioPesaturaFine > $pesoCalcolato) {

                                        $valPeso = $pesoCalcolato;
                                    }
                                    $dosingWithoutMotor = $arraySacco['valore'][4];
                                    $valPesoSblocco = $pesoSaccoMenoTubo - $dosingWithoutMotor;
                                    $velocitaSblocco = 0;

                                    array_push($valuesVelocita[$sacco], array("PesoSacco" => $valPeso, "Velocita" => $arrayVelocita['valore'][3]));
                                    array_push($valuesVelocita[$sacco], array("PesoSacco" => $valPesoSblocco + 1, "Velocita" => $arrayVelocita['valore'][3]));
                                    array_push($valuesVelocita[$sacco], array("PesoSacco" => $valPesoSblocco, "Velocita" => $velocitaSblocco));
//                                    
                                }
                                $t--;
                            }
                            //###################### GRAFICO TEMPI APERTURA E CHIUSURA ############################
                            $values[$sacco] = [];
                            //Per ottenere un andamento dei tempi costante tra due punti (due valori)
                            //sono stati aggiunti dei punti intermedi al grafico aggiungendo un +1 al valore successivo
                            for ($j = 0; $j < count($arrayPesatura['idPar']); $j++) {
                                $valPeso = $pesoSaccoDefault - $arraySacco['valore'][0] - $arrayPesatura['valore'][$j];
                                array_push($values[$sacco], array("PesoSacco" => $valPeso, "TempoApertura" => $arrayTempiApertura['valore'][$j], "TempoChiusura" => $arrayTempiChiusura['valore'][$j]));

                                if ($j < count($arrayPesatura['idPar']) - 1) {
                                    $valPeso2 = $pesoSaccoDefault - $arraySacco['valore'][0] - $arrayPesatura['valore'][$j + 1];
                                    array_push($values[$sacco], array("PesoSacco" => $valPeso2, "TempoApertura" => $arrayTempiApertura['valore'][$j], "TempoChiusura" => $arrayTempiChiusura['valore'][$j]));
                                }
                                if ($j == count($arrayPesatura['idPar']) - 1)
                                    array_push($values[$sacco], array("PesoSacco" => $pesoSaccoDefault - $arraySacco['valore'][0] + 1, "TempoApertura" => $arrayTempiApertura['valore'][$j], "TempoChiusura" => $arrayTempiChiusura['valore'][$j]));
                            }
                            array_push($values[$sacco], array("PesoSacco" => $pesoSaccoDefault - $arraySacco['valore'][0], "TempoApertura" => 0, "TempoChiusura" => $arraySacco['valore'][3]));
                            array_push($values[$sacco], array("PesoSacco" => $pesoSaccoDefault, "TempoApertura" => 0, "TempoChiusura" => $arraySacco['valore'][3]));
//                        print_r($values[$sacco]);
//counting the length of the array
                            $countArrayLength = count($values[$sacco]);
                            $countArrayLengthVel = count($valuesVelocita[$sacco]);
                            ?>
                            <script type="text/javascript" src="https://www.google.com/jsapi"></script>
                            <script type="text/javascript">
                                google.load('visualization', '1', {packages: ['corechart']});

                                function drawChartVel() {

                                    var data = new google.visualization.DataTable();
                                    data.addColumn('number', '<?php echo $filtroPesoSacco ?>');
                                    data.addColumn('number', '<?php echo $filtroVelocita ?>');

                                    data.addRows([
    <?php
    for ($i = 0; $i < $countArrayLengthVel; $i++) {
        echo "[" . $valuesVelocita[$sacco][$i]['PesoSacco'] . "," . $valuesVelocita[$sacco][$i]['Velocita'] . "],";
    }
    ?>
                                    ]);
                                    var options = {
                                        title: '<?php echo $filtroSac . " " . $sacco . " - " . $filtroVelocitaMiscelatore ?>',
                                        hAxis: {title: '<?php echo $filtroPesoSacco . " (" . $filtrogBreve . ")" ?>'},
                                        vAxis: {title: '<?php echo $filtroVelocitaGrafico ?>', colors: '#008000'},
                                        legend: 'none',
                                        pointsVisible: true,
                                        colors: ['green', '#008000']


                                    };

                                    var chart = new google.visualization.LineChart(document.getElementById('chart_vel<?php echo $sacco ?>'));

                                    chart.draw(data, options);
                                }
                                function drawChart() {

                                    var data = new google.visualization.DataTable();
                                    data.addColumn('number', '<?php echo $filtroPesoSacco ?>');
                                    data.addColumn('number', '<?php echo $filtroApertura ?>');
                                    data.addColumn('number', '<?php echo $filtroChiusura ?>');


                                    data.addRows([
    <?php
    for ($i = 0; $i < $countArrayLength; $i++) {
        echo "[" . $values[$sacco][$i]['PesoSacco'] . "," . $values[$sacco][$i]['TempoApertura'] . "," . $values[$sacco][$i]['TempoChiusura'] . "],";
    }
    ?>
                                    ]);
                                    var options = {
                                        title: '<?php echo $titoloGraficoParInsacco ?>',
                                        hAxis: {title: '<?php echo $filtroPesoSacco . " (" . $filtrogBreve . ")" ?>'},
                                        vAxis: {title: '<?php echo $filtroTempoMs ?>'},
                                        legend: {position: 'top-right', textStyle: {color: 'blue', width: '100px'}},
                                        pointsVisible: true

                                    };

                                    var chart = new google.visualization.LineChart(document.getElementById('chart_div<?php echo $sacco ?>'));

                                    chart.draw(data, options);
                                }

                                google.setOnLoadCallback(drawChartVel);
                                google.setOnLoadCallback(drawChart);
                            </script>

                            <div style="float:left;width:40%;height:450px" id="chart_vel<?php echo $sacco ?>" name="chart_vel" ></div>
                            <div style="float:right;width:60%;height:450px" id="chart_div<?php echo $sacco ?>" name="chart_div" ></div>


                        <?php } //fine ciclo sacchi        
                        ?>


                        <input type="hidden" name="countArrayTot" value="<?php echo count($arrayTotValori['idValParSac']) ?>"/>
                        <?php for ($a = 0; $a < count($arrayTotValori['idValParSac']); $a++) { ?>
                            <input type="hidden" name="arrayTotIdVal<?php echo $a ?>" value="<?php echo $arrayTotValori['idValParSac'][$a] ?>"/>
                            <input type="hidden" name="arrayTotValoriOld<?php echo $a ?>" value="<?php echo $arrayTotValori['valoreOld'][$a] ?>"/>
                        <?php } ?>
                          
                        </div>
                    </form>
                    </div><!-- container-->
 
            </div><!-- mainContainer -->


    </body>

</html>
