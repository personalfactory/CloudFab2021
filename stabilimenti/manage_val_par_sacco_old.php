<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <script language="javascript">
        function mostraOrigami4() {
            for (i = 0; i < document.getElementsByName('Origami4').length; i++) {
                document.getElementsByName('Origami4')[i].style.display = "block";
                document.getElementsByName('Origami4')[i].style.height = "450px";
                document.getElementsByName('buttonNascondiOrigami')[i].style.display = "block";
                document.getElementsByName('buttonMostraOrigami')[i].style.display = "none";
            }
            for (i = 0; i < document.getElementsByName('chart_div').length; i++) {
                document.getElementsByName('chart_div')[i].style.display = "none";

            }
            document.getElementById("tabContainer").style.height = "1163px";


        }
        function nascondiOrigami4() {
            for (i = 0; i < document.getElementsByName('Origami4').length; i++) {
                document.getElementsByName('Origami4')[i].style.display = "none";
                document.getElementsByName('buttonMostraOrigami')[i].style.display = "block";
                document.getElementsByName('buttonNascondiOrigami')[i].style.display = "none";
            }
            document.getElementById("tabContainer").style.height = "1163px";

            for (i = 0; i < document.getElementsByName('chart_div').length; i++) {
                document.getElementsByName('chart_div')[i].style.display = "block";


            }
        }
    </script>    
    <body>
        <div id="mainContainer">
            <?php
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

            if (isSet($_GET['IdCategoria']) AND isSet($_GET['NumSacchetti'])) {

                $IdCategoria = $_GET['IdCategoria'];
                $NumSacchetti = $_GET['NumSacchetti'];
                if ($NumSacchetti > 0)
                    $pesoSaccoDefault = number_format($valDefaultPesoMiscela / $NumSacchetti, 0, '', '');
            }

            begin();
            $sqlCat = findCategoriaFromValParSac($IdCategoria);

            while ($rowCat = mysql_fetch_array($sqlCat)) {

                $NomeCategoria = $rowCat['nome_categoria'];
                $DescriCategoria = $rowCat['descri_categoria'];
                $Data = $rowCat['dt_abilitato'];
            }
            ?>
            <div id="container" style=" width:100%; margin:15px auto;">
                <form id="ModificaSoluzioneInsacco" name="ModificaSoluzioneInsacco" method="POST" action="manage_val_par_sacco2.php">
                    <input type="hidden" name="IdCategoria" id="IdCategoria" value=<?php echo $IdCategoria; ?>></input>
                    <input type="hidden" name="NumSacchetti" id="NumSacchetti" value=<?php echo $NumSacchetti; ?>></input>

                    <table width="100%">
                        <tr>
                            <td  class="cella3" colspan="2"><?php echo $filtroTitoloConfMiscela . "  " . $NumSacchetti . " " . $filtroSacchi ?></td>
                        </tr>

                        <tr>
                            <td class="cella2" style="font-size: 20px"><?php echo $filtroCategoria . " " . $IdCategoria ?> </td>                            
                            <td class="cella1" style="font-size: 20px"><?php echo $NomeCategoria ?></td>
                        </tr>
                        <tr>
                            <td class="cella2" ><?php echo $filtroDescrizione ?></td>
                            <td class="cella1" ><?php echo $DescriCategoria; ?></td>
                        </tr>
                        <tr>
                            <td class="cella2" ><?php echo $filtroDt ?></td>
                            <td class="cella1" ><?php echo $Data; ?></td>
                        </tr>                        
                    </table>
                    <table width="100%">
                        <tr>
                            <td class="cella2" style="text-align: right " colspan="2">
                                <input type="reset" onClick="javascript:history.back();" value="<?php echo $valueButtonAnnulla ?>"/>
                                <input id="Salva" type="submit" value="<?php echo $valueButtonSalva ?>" /></td>
                        </tr>
                    </table>
<?php for ($sacco = 1; $sacco <= $NumSacchetti; $sacco++) { ?>
                        <ul id="tabs">
                            <li><a href="#tab<?php echo $sacco ?>"><?php echo $filtroSac . " " . $sacco ?></a></li>
                        </ul>
    <?php
}

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
        $arraySacco['valore'][$i] = $row['valore_variabile'];
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
        $arrayVelocita['valore'][$i] = $row['valore_variabile'];
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
        $arrayPesatura['valore'][$i] = $row['valore_variabile'];
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
        $aliquotaConf['nomePar'][1] = $row['nome_variabile'];
        $aliquotaConf['valore'][1] = $row['valore_base'];
    }
    $sqlAliquote2 = findParSMById(51);
    while ($row = mysql_fetch_array($sqlAliquote2)) {
        $aliquotaConf['idPar'][2] = $row['id_par_sm'];
        $aliquotaConf['nomePar'][2] = $row['nome_variabile'];
        $aliquotaConf['valore'][2] = $row['valore_base'];
    }
    $sqlAliquote3 = findParSMById(52);
    while ($row = mysql_fetch_array($sqlAliquote3)) {
        $aliquotaConf['idPar'][3] = $row['id_par_sm'];
        $aliquotaConf['nomePar'][3] = $row['nome_variabile'];
        $aliquotaConf['valore'][3] = $row['valore_base'];
    }
    $aliquotaConf['valore'][4] = 100;

    // ################ TEMPI DI APERTURA ######################################
    $sqlTempiApertura = selectValoriBySoluzione($IdCategoria, $NumSacchetti, 4, $sacco);
    $i = 0;
    while ($row = mysql_fetch_array($sqlTempiApertura)) {

        $arrayTempiApertura['idPar'][$i] = $row['id_par_sac'];
        $arrayTempiApertura['idVal'][$i] = $row['id_val_par_sac'];
        $arrayTempiApertura['nomePar'][$i] = $row['nome_variabile'];
        $arrayTempiApertura['valore'][$i] = $row['valore_variabile'];
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
        $arrayTempiChiusura['valore'][$i] = $row['valore_variabile'];
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
    $arrayPeraturaO4 = array();
    $arrayTempiAperturaO4 = array();
    $arrayTempiChiusuraO4 = array();

    // ################ PARAMETRI DEL SACCO  ###################################
    $sqlValoriSaccoO4 = selectValoriBySoluzione($IdCategoria, $NumSacchetti, '1-O4', $sacco);
    $y = 0;
    while ($row = mysql_fetch_array($sqlValoriSaccoO4)) {

        $arraySaccoO4['idPar'][$y] = $row['id_par_sac'];
        $arraySaccoO4['idVal'][$y] = $row['id_val_par_sac'];
        $arraySaccoO4['nomePar'][$y] = $row['nome_variabile'];
        $arraySaccoO4['valore'][$y] = $row['valore_variabile'];
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

        $arrayPeraturaO4['idPar'][$y] = $row['id_par_sac'];
        $arrayPeraturaO4['idVal'][$y] = $row['id_val_par_sac'];
        $arrayPeraturaO4['nomePar'][$y] = $row['nome_variabile'];
        $arrayPeraturaO4['valore'][$y] = $row['valore_variabile'];
        $arrayPeraturaO4['uniMis'][$y] = $row['uni_mis'];
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
        $arrayTempiAperturaO4['valore'][$y] = $row['valore_variabile'];
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
        $arrayTempiChiusuraO4['valore'][$y] = $row['valore_variabile'];
        $arrayTempiChiusuraO4['uniMis'][$y] = $row['uni_mis'];
        $y++;

        $arrayTotValori['idValParSac'][$v] = $row['id_val_par_sac'];
        $arrayTotValori['valoreOld'][$v] = $row['valore_variabile'];
        $v++;
    }


    commit();
    ?>

                        <div id="tabContainer">
                            <div class="content">
                                <a name="tab<?php echo $sacco ?>" id="tab<?php echo $sacco ?>"></a>


                                <!--########################################### ORIGAMI 5-6 ###############################################--> 
                                <table width="100%" >
                                    <tr>
                                        <td class="cella3" colspan="4"><?php echo $filtroConfezionamento . " " . $filtroSac . " " . $sacco ?> </td>
                                    </tr>
                                    <tr>
                                        <td class="cella1" width="10%"><?php echo $filtroId ?></td>
                                        <td class="cella1" width="20%"><?php echo $filtroPar ?></td>
                                        <td class="cella1" width="10%"><?php echo $filtroValore ?></td>
                                        <td class="cella1" width="60%"></td>

                                    </tr> <?php
                    for ($j = 0; $j < count($arraySacco['idPar']); $j++) {
                        ?>
                                        <tr>
                                            <td class="cella1" ><?php echo $arraySacco['idPar'][$j] ?></td>
                                            <td class="cella1" ><?php echo $arraySacco['nomePar'][$j] ?></td>
                                            <td class="cella1" >
                                                <input type="text" style="width:80px" name="Valore<?php echo $arraySacco['idVal'][$j]; ?>" value="<?php echo($arraySacco['valore'][$j]); ?>"/><?php echo ( $arraySacco['uniMis'][$j]); ?></td>

                                            <td class="cella1" ></td>
    <?php }
    ?>  
                                </table>
                                <table>
                                    <tr>
                                        <td class="dataRigWhite" colspan="7"><?php echo $filtroVelocitaMiscelatore ?> </td>
                                    </tr>
                                    <tr>
                                        <td class="cella2" width="5%"><?php echo $filtroId ?></td>
                                        <td class="cella2" width="10%"><?php echo $filtroPar ?></td>
                                        <td class="cella2" width="5%" ><?php echo $filtroVelocita ?></td>
                                        <td class="cella2" width="5%"><?php echo $filtroId ?></td>
                                        <td class="cella2" width="10%" ><?php echo $filtroPercConfezionamento ?></td>
                                        <td class="cella2" width="10%" ><?php echo $filtroIntervallo ?></td>   
                                        <td class="cella2" width="10%" ><?php echo $filtroPercInterventoSacco ?></td> 
                                    </tr>

    <?php
    $classeCella = "cella1";
    $t = 3;
    for ($j = 0; $j < count($arrayVelocita['idPar']); $j++) {
        ?>
                                        <tr>
                                            <td class="cella2" ><?php echo $arrayVelocita['idPar'][$j] ?></td>
                                            <td class="cella2" ><?php echo $arrayVelocita['nomePar'][$j] ?></td>
                                            <td class="cella2" >
                                                <nobr><input type="text" style="width:80px" name="Valore<?php echo $arrayVelocita['idVal'][$j]; ?>" value="<?php echo($arrayVelocita['valore'][$j]); ?>"/><?php echo ( $arrayVelocita['uniMis'][$j]); ?></nobr></td>

        <?php if ($t > 0) { ?>
                                                <td class="cella2" ><?php echo $aliquotaConf['idPar'][$t] ?></td>
                                                <td class="cella2" ><?php echo $aliquotaConf['nomePar'][$t] ?></td>

                                                <td class="cella2" ><?php echo $aliquotaConf['valore'][$t + 1] ?>%</td>
                                                <td class="cella2" ><?php echo $aliquotaConf['valore'][$t] ?>%</td>


        <?php } else { ?>
                                                <!-- INIZIO PESATURA FINE-->
                                                <td class="cella2" ><?php echo $arrayPesatura['idPar'][0] ?></td>
                                                <td class="cella2" ><?php echo $arrayPesatura['nomePar'][0] ?></td>

                                                <td class="cella2" ><?php echo $aliquotaConf['valore'][1] ?>%</td>
                                                <td class="cella2" ><?php echo $arrayPesatura['valore'][0] . " " . $arrayPesatura['uniMis'][0] ?></td>
            <?php
        }
        $t--;
    }
    ?>  
                                </table>
                                <table>
                                    <tr>
                                        <td class="dataRigWhite" colspan="4"><?php echo $filtroPesatura ?> </td>
                                        <td class="dataRigWhite" colspan="6"><?php echo $filtroTempiaperChiusuraValv ?> </td>
                                    </tr>
                                    <tr>
                                        <td class="cella1" width="5%"><?php echo $filtroId ?></td>
                                        <td class="cella1" width="10%"><?php echo $filtroPar ?></td>
                                        <td class="cella1" width="10%" ><?php echo $filtroPesoMancante ?></td>
                                        <td class="cella1" width="10%" ><?php echo $filtroPesoEffettivo ?></td>
                                        <td class="cella2" width="5%"><?php echo $filtroId ?></td>
                                        <td class="cella2" width="10%"><?php echo $filtroPar ?></td>
                                        <td class="cella2" width="5%" ><?php echo $filtroTempoApertura ?></td>
                                        <td class="cella2" width="5%"><?php echo $filtroId ?></td>
                                        <td class="cella2" width="10%"><?php echo $filtroPar ?></td>
                                        <td class="cella2" width="5%" ><?php echo $filtroTempoChiusura ?></td>
                                    </tr> <?php
                                    for ($j = 0; $j < count($arrayPesatura['idPar']); $j++) {
                                        ?>
                                        <tr>
                                            <td class="cella1" ><?php echo $arrayPesatura['idPar'][$j] ?></td>
                                            <td class="cella1" ><?php echo $arrayPesatura['nomePar'][$j] ?></td>
                                            <td class="cella1" >
                                                <nobr><input type="text" style="width:80px" name="Valore<?php echo $arrayPesatura['idVal'][$j]; ?>" value="<?php echo($arrayPesatura['valore'][$j]); ?>"/><?php echo($arrayPesatura['uniMis'][$j]); ?></nobr></td>

        <?php
//                                         
        $valPeso = $pesoSaccoDefault - $arraySacco['valore'][0] - $arrayPesatura['valore'][$j];
        ?>
                                            <td class="cella1" title="<?php echo $pesoSaccoDefault . " - " . $arraySacco['nomePar'][0] . " - " . $arrayPesatura['nomePar'][$j] ?>" ><?php echo $valPeso . " " . $arrayPesatura['uniMis'][$j] ?></td>


                                            <td class="cella2" ><?php echo $arrayTempiApertura['idPar'][$j] ?></td>
                                            <td class="cella2" ><?php echo $arrayTempiApertura['nomePar'][$j] ?></td>
                                            <td class="cella2" >
                                                <nobr><input type="text" style="width:80px" name="Valore<?php echo $arrayTempiApertura['idVal'][$j]; ?>" value="<?php echo($arrayTempiApertura['valore'][$j]); ?>"/><?php echo($arrayTempiApertura['uniMis'][$j]); ?></nobr></td>

                                            <td class="cella2" ><?php echo $arrayTempiChiusura['idPar'][$j] ?></td>
                                            <td class="cella2" ><?php echo $arrayTempiChiusura['nomePar'][$j] ?></td>
                                            <td class="cella2" >
                                                <nobr><input type="text" style="width:80px" name="Valore<?php echo $arrayTempiChiusura['idVal'][$j]; ?>" value="<?php echo($arrayTempiChiusura['valore'][$j]); ?>"/><?php echo($arrayTempiChiusura['uniMis'][$j]); ?></nobr></td>
                                        </tr>
    <?php }
    ?>  
                                </table>
                                <div style="width:100%;">

                                    <input type="button" name="buttonMostraOrigami" style="border:none;" value="MOSTRA ORIGAMI 4" onClick="mostraOrigami4();" title="<?php echo $titleMostraAltreInfoProd ?>"></input>
                                    <input type="button" name="buttonNascondiOrigami" style="border:none;display:none;" value="NASCONDI ORIGAMI 4" onClick="nascondiOrigami4();" title="<?php echo $titleNascondiAltreInfoProd ?>"></input>
                                </div>
                                <!--############################ ORIGAMI 4 #########################################-->
                                <div class="Origami4" name="Origami4" style="display:none;">
                                    <table style="width:100%">
                                        <tr>
                                            <td class="cella3" colspan="4"><?php echo $filtroOrigami4 . " - " . $filtroConfezionamento . " " . $sacco ?> </td>
                                        </tr>
                                        <tr>
                                            <td class="cella1" width="10%"><?php echo $filtroId ?></td>
                                            <td class="cella1" width="20%"><?php echo $filtroPar ?></td>
                                            <td class="cella1" width="10%"><?php echo $filtroValore ?></td>
                                            <td class="cella1" width="60%"></td>

                                        </tr> <?php
    for ($j = 0; $j < count($arraySaccoO4['idPar']); $j++) {
//                    echo "count par sacco :".count($arraySaccoO4['idPar']);
        ?>
                                            <tr>
                                                <td class="cella1" ><?php echo $arraySaccoO4['idPar'][$j] ?></td>
                                                <td class="cella1" ><?php echo $arraySaccoO4['nomePar'][$j] ?></td>
                                                <td class="cella1" >
                                                    <nobr><input type="text" style="width:80px" name="Valore<?php echo $arraySaccoO4['idVal'][$j]; ?>" value="<?php echo($arraySaccoO4['valore'][$j]); ?>"/><?php echo($arraySaccoO4['uniMis'][$j]); ?></nobr></td>
                                                <td class="cella1" ></td>
                                            </tr>
    <?php }
    ?>  
                                    </table>

                                    <table  style="width:100%">
                                        <tr>
                                            <td class="dataRigWhite" colspan="4"><?php echo $filtroPesatura ?> </td>
                                            <td class="dataRigWhite" colspan="6"><?php echo $filtroTempiaperChiusuraValv ?> </td>
                                        </tr>
                                        <tr>
                                            <td class="cella1" width="5%"><?php echo $filtroId ?></td>
                                            <td class="cella1" width="10%"><?php echo $filtroPar ?></td>
                                            <td class="cella1" width="10%" ><?php echo $filtroPesoMancante ?></td>
                                            <td class="cella1" width="10%" ><?php echo $filtroPesoEffettivo ?></td>
                                            <td class="cella2" width="5%"><?php echo $filtroId ?></td>
                                            <td class="cella2" width="10%"><?php echo $filtroPar ?></td>
                                            <td class="cella2" width="5%" ><?php echo $filtroTempoApertura ?></td>
                                            <td class="cella2" width="5%"><?php echo $filtroId ?></td>
                                            <td class="cella2" width="10%"><?php echo $filtroPar ?></td>
                                            <td class="cella2" width="5%" ><?php echo $filtroTempoChiusura ?></td>
                                        </tr> <?php
    for ($j = 0; $j < count($arrayPeraturaO4['idPar']); $j++) {
        ?>
                                            <tr>
                                                <td class="cella1" ><?php echo $arrayPeraturaO4['idPar'][$j] ?></td>
                                                <td class="cella1" ><?php echo $arrayPeraturaO4['nomePar'][$j] ?></td>
                                                <td class="cella1" >
                                                    <nobr><input type="text" style="width:80px" name="Valore<?php echo $arrayPeraturaO4['idVal'][$j]; ?>" value="<?php echo($arrayPeraturaO4['valore'][$j]); ?>"/><?php echo($arrayPeraturaO4['uniMis'][$j]); ?></nobr></td>

        <?php
        $valPesoO4 = $pesoSaccoDefault - $arraySaccoO4['valore'][0] - $arrayPeraturaO4['valore'][$j];
        ?>
                                                <td class="cella1" title="<?php echo $pesoSaccoDefault . " - " . $arraySacco['nomePar'][0] . " - " . $arrayPeraturaO4['nomePar'][$j] ?>" ><?php echo $valPesoO4 . " " . $arrayPeraturaO4['uniMis'][$j] ?></td>
                                                <td class="cella2" ><?php echo $arrayTempiAperturaO4['idPar'][$j] ?></td>
                                                <td class="cella2" ><?php echo $arrayTempiAperturaO4['nomePar'][$j] ?></td>
                                                <td class="cella2" >
                                                    <nobr><input type="text" style="width:80px" name="Valore<?php echo $arrayTempiAperturaO4['idVal'][$j]; ?>" value="<?php echo($arrayTempiAperturaO4['valore'][$j]); ?>"/><?php echo($arrayTempiAperturaO4['uniMis'][$j]); ?></nobr></td>

                                                <td class="cella2" ><?php echo $arrayTempiChiusuraO4['idPar'][$j] ?></td>
                                                <td class="cella2" ><?php echo $arrayTempiChiusuraO4['nomePar'][$j] ?></td>
                                                <td class="cella2" >
                                                    <nobr><input type="text" style="width:80px" name="Valore<?php echo $arrayTempiChiusuraO4['idVal'][$j]; ?>" value="<?php echo($arrayTempiChiusuraO4['valore'][$j]); ?>"/><?php echo($arrayTempiChiusuraO4['uniMis'][$j]); ?></nobr></td>
                                            </tr>
    <?php }
    ?>  
                                    </table>
                                </div>




    <?php
    $values[$sacco] = [];
//Per ottenere un andamento dei tempi costante tra due punti (due valori)
    //sono stati aggiunti dei punti intermedi al grafico
    for ($j = 0; $j < count($arrayPesatura['idPar']); $j++) {
        $valPeso = $pesoSaccoDefault - $arraySacco['valore'][0] - $arrayPesatura['valore'][$j];
        array_push($values[$sacco], array("PesoSacco" => $valPeso, "TempoApertura" => $arrayTempiApertura['valore'][$j], "TempoChiusura" => $arrayTempiChiusura['valore'][$j]));

        if ($j < count($arrayPesatura['idPar']) - 1) {
            $valPeso2 = $pesoSaccoDefault - $arraySacco['valore'][0] - $arrayPesatura['valore'][$j + 1];
            array_push($values[$sacco], array("PesoSacco" => $valPeso2, "TempoApertura" => $arrayTempiApertura['valore'][$j], "TempoChiusura" => $arrayTempiChiusura['valore'][$j]));
        }
        if ($j == count($arrayPesatura['idPar']) - 1)
            array_push($values[$sacco], array("PesoSacco" => $pesoSaccoDefault - $arraySacco['valore'][0]+1, "TempoApertura" => $arrayTempiApertura['valore'][$j], "TempoChiusura" => $arrayTempiChiusura['valore'][$j]));
    }
    array_push($values[$sacco], array("PesoSacco" => $pesoSaccoDefault- $arraySacco['valore'][0], "TempoApertura" => 0, "TempoChiusura" => $arraySacco['valore'][3]));
    array_push($values[$sacco], array("PesoSacco" => $pesoSaccoDefault, "TempoApertura" => 0, "TempoChiusura" => $arraySacco['valore'][3]));
//                        print_r($values[$sacco]);
//counting the length of the array
    $countArrayLength = count($values[$sacco]);
    ?>
                                <script type="text/javascript" src="https://www.google.com/jsapi"></script>
                                <script type="text/javascript">
                                        google.load('visualization', '1', {packages: ['corechart']});

                                        function drawChart() {

                                            var data = new google.visualization.DataTable();
                                            data.addColumn('number', 'PesoSacco');
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
                                                title: '<?php echo $filtroSacco . " " . $sacco . " " . $pesoSaccoDefault . " " . $filtroKgBreve . " " . $titoloGraficoParInsacco ?>',
                                                hAxis: {title: '<?php echo $filtroPesoSacco . " (" . $filtrogBreve . ")" ?>'},
                                                vAxis: {title: '<?php echo $filtroTempoMs ?>'},
                                                legend: {position: 'top-right', textStyle: {color: 'blue', fontSize: 16}},
                                                pointsVisible: true

                                            };

                                            var chart = new google.visualization.LineChart(document.getElementById('chart_div<?php echo $sacco ?>'));

                                            chart.draw(data, options);
                                        }
                                        google.setOnLoadCallback(drawChart);
                                </script>

                                <div id="chart_div<?php echo $sacco ?>" name="chart_div" style="width: 100%; height:450px;">

                                </div>

<?php } ?>
                            <!--<script type="text/javascript">alert('<?php echo "NumTotValori : " . count($arrayTotValori['idValParSac']); ?>')</script>-->

                            <input type="hidden" name="countArrayTot" value="<?php echo count($arrayTotValori['idValParSac']) ?>"/>
<?php for ($a = 0; $a < count($arrayTotValori['idValParSac']); $a++) { ?>

                                <input type="hidden" name="arrayTotIdVal<?php echo $a ?>" value="<?php echo $arrayTotValori['idValParSac'][$a] ?>"/>
                                <input type="hidden" name="arrayTotValoriOld<?php echo $a ?>" value="<?php echo $arrayTotValori['valoreOld'][$a] ?>"/>
<?php } ?>

                        </div><!-- content-->
                    </div><!-- tabContainer -->
                </form>


            </div>

        </div>





    </body>

</html>
