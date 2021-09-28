<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <script language="javascript">

        function CaricaVersoMacchina() {
            document.forms["AggiornaMacchine"].action = "sync_carica_verso_macchine.php";
            document.forms["AggiornaMacchine"].submit();
        }
        function CaricaVersoTutti() {

            document.forms["AggiornaMacchine"].action = "sync_carica_verso_macchine.php?CaricaTutti=1";
            document.forms["AggiornaMacchine"].submit();
        }
    </script>  
    <?php
    if ($DEBUG)
        ini_set('display_errors', 1);
    //################## GESTIONE UTENTI #########################
    $actionOnLoad = "";
    $elencoFunzioni = array("57", "58");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);


    //Stringa contentente gli utenti proprietari e le aziende di cui visualizzare le macchine
    $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'macchina');
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script_macchina.php');
            include('../sql/script_aggiornamento.php');


            //########################################################################
            //########## FORM DI SCELTA DELLO STABILIMENTO ###########################
            //########################################################################

            if (!isset($_POST['idMacchina']) && !isset($_GET['CaricaTutti'])) {
                ?>

                <div id="container" style="width:70%; margin:100px auto; ">
                    <form id="AggiornaMacchine" name="AggiornaMacchine" method="post" action="sync_carica_verso_macchina.php">
                        <table width="100%">
                            <tr>
                                <td class="cella2" colspan="2" style="font-size:20px"><?php echo $titoloPaginaInvioAgg ?></td>
                            </tr>
                            <tr>
                                
                                <td class="cella111">
                                    <select name="idMacchina" id="idMacchina" class="listBoxAgg">
                                        <option class="listBoxAgg" value="" selected=""><?php echo $labelOptionSelectStab ?></option>
                                        <?php
                                        $sql = findAllMacchineVisAbilitate("id_macchina", $strUtentiAziende);
                                        while ($row = mysql_fetch_array($sql)) {
                                            ?>
                                            <option class="listBoxAgg" value="<?php echo $row['id_macchina']; ?>"><?php echo $row['id_macchina'] . " - " . $row['cod_stab'] . " - " . $row['descri_stab']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <input class="buttonInvia" type="submit" title="<?php echo $titleInviaAggStab ?>" value="<?php echo $valueButtonInvia ?>" onClick="javascript:CaricaVersoMacchina();"/></td>
                            </tr>
                            <tr>
                                <td  class="cella22" style="text-align: right " >
                                    <input type="reset" class="buttonInvia" value="<?php echo $valueButtonAnnulla ?>" onClick="location.href = '/CloudFab/index.php'"/>
                                    <input type="button" class="buttonInvia" id="58" title="<?php echo $titleInviaAggTuttiStab ?>" value="<?php echo $valueButtonAggiornaTutti ?>" onClick="javascript:CaricaVersoTutti();"/></td>
                            </tr>
                        </table>
                    </form>
                </div>

                <?php
                //######################################################################
                //########## AGGIORNAMENTO VERSO UNA SINGOLA MACCHINA ##################
                //######################################################################
            } else if (isset($_POST['idMacchina']) && !isset($_GET['CaricaTutti'])) {

                // SI RECUPERA DAL DB LA VERSIONE DELL' ULTIMO AGGIORNAMENTO INVIATO 
                $versioneUltimoAgg = 0;
                $maxVersione = 0;

                $IdMacchina = $_POST['idMacchina'];

                $sqlOldAgg = findMaxVersioneAggByTipoIdMac($tipoAggOut, $IdMacchina);
                while ($rowOldAgg = mysql_fetch_array($sqlOldAgg)) {
                    $versioneUltimoAgg = $rowOldAgg['versione'];
                    }

                if ($versioneUltimoAgg == "") {
                    $versioneUltimoAgg = 0;
                }

                //###################### SI ESEGUE L' AGGIORNAMENTO ##################
                //ISTRUZIONE LINUX
                $log = shell_exec('sh startSync.sh dist/SyncOrigami.jar uploadAggiornamentoDaServerPerMacchina ' . $IdMacchina);

                //ISTRUZIONE WINDOWS
//          $log = shell_exec('startSyncWin.bat "dist\SyncOrigami.jar" "uploadAggiornamentoDaServerPerMacchina" ' . $IdMacchina);
                //SI VERIFICA L'INVIO DEL FILE SELEZIONANDO L'ULTIMA 
                //VERSIONE DELL'AGGIORNAMENTO DALLA TABELLA aggiornamento 

                $sqlMaxVersione = findMaxVersioneAggByTipoIdMac($tipoAggOut, $IdMacchina);

                while ($rowMaxVersione = mysql_fetch_array($sqlMaxVersione)) {
                    $maxVersione = $rowMaxVersione['versione'];
                }
                if ($maxVersione == "") {
                    $maxVersione = 0;
                }

                echo "<br/>versioneUltimoAgg : " . $versioneUltimoAgg;
                echo "<br/>maxversione : " . $maxVersione;

                // RECUPERO I DETTAGLI DELL' AGGIORNAMENTO APPENA INVIATO 
                $sqlAgg = findAggByTipoIdMacVersione($tipoAggOut, $IdMacchina, $maxVersione);
                while ($rowAgg = mysql_fetch_array($sqlAgg)) {

                    //################# VISUALIZZAZIONE RISULTATI ########################

                    if ($rowAgg['versione'] == $versioneUltimoAgg + 1) {
                        //CASO 1: AGGIORNAMENTO INVIATO
                        echo $filtroIdMacchina . " : " . $IdMacchina . "</br>";
                        echo $filtroStabilimento . " : " . $rowAgg['descri_stab'] . "</br>";
                        echo $filtroCodStab . " : " . $rowAgg['cod_stab'] . "</br>";
                        echo $filtroNomeFile . " : " . $rowAgg['nome_file'] . "</br>";
                        echo $filtroVersioneUscita . " : " . $rowAgg['versione'] . "</br>";
                        echo $filtroDtOraAgg . " : " . $rowAgg['dt_aggiornamento'] . "</br>";

                        echo "</br><div style='color: darkgreen'>" . $msgInfoAggInv . "</div>";
//                        echo '<a href="visualizza_log.php">' . $msgInfoVediLog . '</a>';
                        echo '<a href="/CloudFab/index.php">' . $filtroTornaHome . '</a>';
                    } else {
                        //ISTRUZIONE LINUX
//              $report = shell_exec("grep -c 'DatiAggiornamentoNotFoundException' /var/www/CloudFab/syncorigami/SyncOrigami/dist/log/syncorigami.log");

                        $pos = strpos($log, "DatiAggiornamentoNotFoundException");

                        if ($pos == true) {
                            //CASO 2: NON CI SONO DATI NUOVI
                            echo "<div style='color: darkgreen' > " . $msgInfoNotAgg . " " . $rowAgg['descri_stab'] . "</br></div>";
                            echo '<a href="/CloudFab/index.php">' . $filtroTornaHome . '</a>';
//                            echo '<a href="visualizza_log.php">' . $msgInfoVediLog . '</a>';
                        } else {
                            //CASO 3: AGGIORNAMENTO NON INVIATO CON ERRORI
                            echo "<div style='color: #FF0000' >" . $msgErrAgg . "</div>";
                            echo '<a href="/CloudFab/index.php">' . $filtroTornaHome . '</a>';
//                            echo '<a href="visualizza_log.php">' . $msgInfoVediLog . '</a>';
                            //L'INVIO DELLE NOTIFICHE VIA MAIL VIENE GESTITO DURANTE L'AGGIORNAMENTO
                        }
                    }
                }

                //#####################################################################
                //############# AGGIORNAMENTO VERSO TUTTE LE MACCHINE #################
                //#####################################################################
            } else if (isset($_GET['CaricaTutti'])) {

                //SELEZIONO DALLA TAB AGGIORNAMENTO IL NUM DI AGG OUT PRIMA DI ESEGUIRE IL PROGRAMMA
                $sqlAggOutOld = countAgg($tipoAggOut);
                while ($rowAggOutOld = mysql_fetch_array($sqlAggOutOld)) {

                    $numAggOutOld = $rowAggOutOld['num_agg_out'];
                    $dtUltAgg = $rowAggOutOld['dt_ult_agg'];
                }

                //############# ESECUZIONE DELL'AGGIORNAMENTO ########################
                $log = shell_exec('sh startSync.sh dist/SyncOrigami.jar uploadAggiornamentiDaServerPerTutteLeMacchine');

                //VERIFICA : SELEZIONO IL NUM DI AGG DOPO L'ESECUZIONE DEL PROGRAMMA
                $numAggInv = 0;
                $sqlAggOutNew = findAggByTipoDtUltAgg($tipoAggOut, $dtUltAgg);
                while ($rowAggOutNew = mysql_fetch_array($sqlAggOutNew)) {

                    //################# VISUALIZZAZIONE RISULTATI ########################
                    $numAggInv++;

                    //CASO 1: AGGIORNAMENTO INVIATO
                    echo "</br><div style='color: darkgreen' >" . $msgInfoAggInviatoAStab . "</div>";
                    echo $filtroIdMacchina . " : " . $rowAggOutNew['id_macchina'] . "</br>";
                    echo $filtroStabilimento . " : " . $rowAggOutNew['descri_stab'] . "</br>";
                    echo $filtroCodStab . " : " . $rowAggOutNew['cod_stab'] . "</br>";
                    echo $filtroNomeFile . " : " . $rowAggOutNew['nome_file'] . "</br>";
                    echo $filtroVersioneUscita . " : " . $rowAggOutNew['versione'] . "</br>";
                    echo $filtroDtOraAgg . " : " . $rowAggOutNew['dt_aggiornamento'] . "</br>";
                }

                if (strpos($log, " ERROR [main]")) {
                    //CASO 3: AGGIORNAMENTO NON INVIATO : PRESENZA DI ERRORI
                    echo "<div style='color: #FF0000' >" . $msgErrAgg . "</div>";
                    echo '<a href="/CloudFab/index.php">' . $filtroTornaHome . '</a>';
                }
                echo "</br><div style='color: darkgreen' >" . $msgInfoTotAggInv . " " . $numAggInv . "</br></div>";
//                echo '<a href="visualizza_log.php">' . $msgInfoVediLog . '</a>';
                echo '<a href="/CloudFab/index.php">' . $filtroTornaHome . '</a>';
            }
            ?>


            <div id="msgLog">
                <?php
                if ($DEBUG) {

//        echo "</br>actionOnLoad :" . $actionOnLoad;
//        echo "</br>Tab macchina : Utenti e aziende visibili " . $strUtentiAziende;
                }
                ?>
            </div>
        </div><!--mainContainer-->


    </body>
</html>
