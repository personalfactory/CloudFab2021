<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <?php
    //#################### GESTIONE UTENTI #####################################
    //Verifico che l'utente abbia il permesso di modificare i valori par comp
    //Verifico che l'utente abbia il permesso di impostare i valori iniziali
    $elencoFunzioni = array("66", "67");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni,$_SESSION['objPermessiVis']);

    //############# STRINGA UTENTI-AZIENDE VISIBILI ############################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
    $strUtentiAziendeComp = getStrUtAzVisib($_SESSION['objPermessiVis'], 'componente');
    
    ?>
    <script language="javascript">
        function Carica() {
            document.forms["ModificaValoreParComp"].action = "modifica_valore_par_comp_stab2.php";
            document.forms["ModificaValoreParComp"].submit();
        }
        function ImpostaValoreIniziale() {
            document.forms["ModificaValoreParComp"].action = "carica_valori_iniziali_comp.php";
            document.forms["ModificaValoreParComp"].submit();
        }
        function RicaricaPagina() {
            location.href = "modifica_valore_par_comp_stab.php";
        }
        function disabilitaAction1() {
            document.getElementById('Salva').disabled = true;

        }
        function disabilitaAction2() {

            document.getElementById('ImpostaValIniziali').disabled = true;

        }
    </script>

    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script_valore_par_comp.php');
            include('../sql/script_macchina.php');


            //############ INIZIALIZZAZIONE DELLE VARIABILI DI SESSIONE ####################
            //Solo se la richiesta della pagina arriva dal menu azzero le variabili di sessione

            if (isset($_GET['FromMenu']) && $_GET['FromMenu'] == 1 && isset($_GET['IdMacchina'])) {
                
                $_SESSION['IdMacchina'] = $_GET['IdMacchina'];
                $_SESSION['IdValComp'] = "";
                $_SESSION['IdParComp'] = "";
                $_SESSION['NomeVariabile'] = "";
                $_SESSION['DescriComponente'] = "";
                $_SESSION['ValoreVariabile'] = "";
                $_SESSION['DtAbilitato'] = "";
                $_SESSION['ValoreIniziale'] = "";
                $_SESSION['DtValoreIniziale'] = "";
                $_SESSION['ValoreMacchina'] = "";
                $_SESSION['DtModificaMac'] = "";
                $_SESSION['DtAgg'] = "";
            }

            //Se il post è settato (vuoto oppure diverso dal vuoto) memorizzo il suo contenuto 
            //nella variabile di sessione
            //Altrimenti la variabile di sessione conserva il valore precedentemente salvato
            if (isSet($_POST['IdValComp'])) {
                $_SESSION['IdValComp'] = trim($_POST['IdValComp']);
            }
            if (isSet($_POST['IdParComp'])) {
                $_SESSION['IdParComp'] = trim($_POST['IdParComp']);
            }
            if (isSet($_POST['NomeVariabile'])) {
                $_SESSION['NomeVariabile'] = trim($_POST['NomeVariabile']);
            }
            if (isSet($_POST['DescriComponente'])) {
                $_SESSION['DescriComponente'] = trim($_POST['DescriComponente']);
            }
            if (isSet($_POST['ValoreVariabile'])) {
                $_SESSION['ValoreVariabile'] = trim($_POST['ValoreVariabile']);
            }
            if (isSet($_POST['DtAbilitato'])) {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitato']);
            }
            if (isSet($_POST['ValoreIniziale'])) {
                $_SESSION['ValoreIniziale'] = trim($_POST['ValoreIniziale']);
            }
            if (isSet($_POST['DtValoreIniziale'])) {
                $_SESSION['DtValoreIniziale'] = trim($_POST['DtValoreIniziale']);
            }
            if (isSet($_POST['ValoreMacchina'])) {
                $_SESSION['ValoreMacchina'] = trim($_POST['ValoreMacchina']);
            }
            if (isSet($_POST['DtModificaMac'])) {
                $_SESSION['DtModificaMac'] = trim($_POST['DtModificaMac']);
            }
            if (isSet($_POST['DtAgg'])) {
                $_SESSION['DtAgg'] = trim($_POST['DtAgg']);
            }

//########### VARIABILE DI ORDINAMENTO DELLA QUERY #############################
            $_SESSION['Filtro'] = "id_val_comp";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }
//############### ID MACCHINA ##################################################      
//            $_SESSION['IdMacchina'] = "";
//            if (isset($_GET['IdMacchina'])) {
//                $_SESSION['IdMacchina'] = $_GET['IdMacchina'];
//            }
//############# LOG ###########################     
//      echo "From menu : ".$_GET['FromMenu'];
//      echo "</br> SESSION['IdValComp'] : " . $_SESSION['IdValComp'];
//      echo "</br> SESSION['IdParComp'] : " . $_SESSION['IdParComp'];
//      echo "</br> SESSION['NomeVariabile'] : " . $_SESSION['NomeVariabile'];
//      echo "</br> SESSION['DescriComponente'] : " . $_SESSION['DescriComponente'];
//      echo "</br> SESSION['ValoreVariabile'] : " . $_SESSION['ValoreVariabile'];
//      echo "</br> SESSION['DtAbilitato'] : " . $_SESSION['DtAbilitato'];
//      echo "</br> SESSION['ValoreIniziale'] : " . $_SESSION['ValoreIniziale'];
//      echo "</br> SESSION['DtValoreIniziale'] : " . $_SESSION['DtValoreIniziale'];
//      echo "</br> SESSION['ValoreMacchina'] : " . $_SESSION['ValoreMacchina'];
//      echo "</br> SESSION['DtModificaMac'] : " . $_SESSION['DtModificaMac'];
//      echo "</br> SESSION['DtAgg'] : " . $_SESSION['DtAgg'];
//      echo "</br> SESSION['Filtro']: " . $_SESSION['Filtro'];
//      echo "</br> SESSION['IdMacchina'] : " . $_SESSION['IdMacchina'];
//########### INFORMAZIONI SULLA MACCHINA ######################################

            $sqlValore = findMacchinaById($_SESSION['IdMacchina']);
            while ($rowValore = mysql_fetch_array($sqlValore)) {

                $CodiceStab = $rowValore['cod_stab'];
                $DescriStab = $rowValore['descri_stab'];
                $Data = $rowValore['dt_abilitato'];
            }

//Larghezza colonne 
//TOTALE container 1170px
            $wid1 = "5%";
            $wid2 = "5%";
            $wid3 = "5%";
            $wid4 = "20%";
            $wid5 = "15%";
            $wid6 = "10%";
            $wid7 = "5%";
            $wid8 = "10%";
            $wid9 = "5%";
            $wid10 = "10%";
            $wid11 = "10%";
            ?>

            <form class="form" id="ModificaValoreParComp" name="ModificaValoreParComp" method="post" >
                <table class="table3">
                    <tr>
                        <th colspan="11"><?php echo $titoloPaginaModificaValParComp; ?></th>
                    </tr>
                    <tr>
                        <th colspan="11"> <?php echo $filtroStabilimento . " " . $DescriStab ?></th>
                    </tr> 
                </table>
                <table class="table3" width="100%">
                    <!--################## RICERCA CON INPUT TEXT ###############################-->
                    <tr>
                        <td><input style="width:100%" type="text" name="IdValComp" value="<?php echo $_SESSION['IdValComp'] ?>" onChange="document.forms['ModificaValoreParComp'].submit();"/></td>
                        <td><input style="width:100%" type="text" name="IdParComp"   value="<?php echo $_SESSION['IdParComp'] ?>" onChange="document.forms['ModificaValoreParComp'].submit();"/></td>
                        <td><input style="width:100%" type="text" name="NomeVariabile"  value="<?php echo $_SESSION['NomeVariabile'] ?>" onChange="document.forms['ModificaValoreParComp'].submit();"/></td>
                        <td><input style="width:100%" type="text" name="DescriComponente" value="<?php echo $_SESSION['DescriComponente'] ?>" onChange="document.forms['ModificaValoreParComp'].submit();"/></td>
                        <td><input style="width:100%" type="text" name="ValoreVariabile" value="<?php echo $_SESSION['ValoreVariabile'] ?>" onChange="document.forms['ModificaValoreParComp'].submit();"/></td>
                        <td><input style="width:100%" type="text" name="DtAbilitato" value="<?php echo $_SESSION['DtAbilitato'] ?>" onChange="document.forms['ModificaValoreParComp'].submit();"/></td>
                        <td><input style="width:100%" type="text" name="ValoreIniziale"  value="<?php echo $_SESSION['ValoreIniziale'] ?>" onChange="document.forms['ModificaValoreParComp'].submit();"/></td>
                        <td><input style="width:100%" type="text" name="DtValoreIniziale" value="<?php echo $_SESSION['DtValoreIniziale'] ?>" onChange="document.forms['ModificaValoreParComp'].submit();"/></td>
                        <td><input style="width:100%" type="text" name="ValoreMacchina" value="<?php echo $_SESSION['ValoreMacchina'] ?>" onChange="document.forms['ModificaValoreParComp'].submit();"/></td>
                        <td><input style="width:100%" type="text" name="DtModificaMac"  value="<?php echo $_SESSION['DtModificaMac'] ?>" onChange="document.forms['ModificaValoreParComp'].submit();"/></td>
                        <td><input style="width:100%" type="text" name="DtAgg"  value="<?php echo $_SESSION['DtAgg'] ?>" onChange="document.forms['ModificaValoreParComp'].submit();"/></td>
                        <td><img src="/CloudFab/images/icone/lente_piccola.png" onClick="document.forms['ModificaValoreParComp'].submit();" title="<?php echo $titleRicerca ?>"/></td>
                    </tr>
                    <!--################## ORDINAMENTO ########################################-->
                    <tr>
                        <td class="cella3" style="width:<?php echo $wid1 ?>"><div id="OrdinaIdValComp"><?php echo $filtroId; ?>
                                <button name="Filtro" type="submit" value="id_val_comp" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                                    <img src="/CloudFab/images/arrow3.png" /></button></div>
                        </td>
                        <td class="cella3" style="width:<?php echo $wid2 ?>"><div id="OrdinaIdPar"><?php echo $filtroIdPar; ?>
                                <button name="Filtro" type="submit" value="p.id_par_comp" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                                    <img src="/CloudFab/images/arrow3.png" /></button></div>
                        </td>
                        <td class="cella3" style="width:<?php echo $wid3 ?>"><div id="OrdinaPar"><?php echo $filtroPar; ?>
                                <button name="Filtro" type="submit" value="nome_variabile" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                                    <img src="/CloudFab/images/arrow3.png" /></button></div>
                        </td>
                        <td class="cella3" style="width:<?php echo $wid4 ?>"><div id="OrdinaComp"><?php echo $filtroComponente; ?>
                                <button name="Filtro" type="submit" value="descri_componente" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                                    <img src="/CloudFab/images/arrow3.png" /></button></div>
                        </td>
                        <td class="cella3" style="width:<?php echo $wid5 ?>"><div id="OrdinaVal"><?php echo $filtroValore; ?>
                                <button name="Filtro" type="submit" value="valore_variabile" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                                    <img src="/CloudFab/images/arrow3.png" /></button></div>
                        </td>
                        <td class="cella3" style="width:<?php echo $wid6 ?>"><div id="OrdinaDtAbil"><?php echo $filtroDtAbilitato; ?>
                                <button name="Filtro" type="submit" value="v.dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                                    <img src="/CloudFab/images/arrow3.png" /></button></div>
                        </td>
                        <td class="cella3" style="width:<?php echo $wid7 ?>"><div id="OrdinaValIniziale"><?php echo $filtroValoreIniziale; ?>
                                <button name="Filtro" type="submit" value="valore_iniziale" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                                    <img src="/CloudFab/images/arrow3.png" /></button></div>
                        </td>
                        <td class="cella3" style="width:<?php echo $wid8 ?>"><div id="OrdinaDtValIniziale"><?php echo $filtroDtValoreIniziale; ?>
                                <button name="Filtro" type="submit" value="dt_valore_iniziale" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                                    <img src="/CloudFab/images/arrow3.png" /></button></div>
                        </td>
                        <td class="cella3" style="width:<?php echo $wid9 ?>"><div id="OrdinaValMac"><?php echo $filtroValoreMacchina; ?>
                                <button name="Filtro" type="submit" value="valore_mac" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                                    <img src="/CloudFab/images/arrow3.png" /></button></div>
                        </td>
                        <td class="cella3" style="width:<?php echo $wid10 ?>"><div id="OrdinaDtModMacMac"><?php echo $filtroDtModificaMac; ?>
                                <button name="Filtro" type="submit" value="dt_modifica_mac" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                                    <img src="/CloudFab/images/arrow3.png" /></button></div>
                        </td>
                        <td class="cella3" style="width:<?php echo $wid11 ?>"><div id="OrdinaDtAgg"><?php echo $filtroDtAgg; ?>
                                <button name="Filtro" type="submit" value="dt_agg_mac" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                                    <img src="/CloudFab/images/arrow3.png" /></button></div>
                        </td>
                    </tr>
                    <tr>
                        <?php
//######### VISUALIZZAZIONE DEI PARAMETRI PRESENTI NELLA TABELLA [valore_par_comp] #######
                        $NPar = 1;
                        $sqlPar = findValoreParCompByIdMacchina($_SESSION['IdMacchina'], $_SESSION['Filtro'], $_SESSION['IdValComp'], $_SESSION['IdParComp'], $_SESSION['NomeVariabile'], $_SESSION['DescriComponente'], $_SESSION['ValoreVariabile'], $_SESSION['DtAbilitato'], $_SESSION['ValoreIniziale'], $_SESSION['DtValoreIniziale'], $_SESSION['ValoreMacchina'], $_SESSION['DtModificaMac'], $_SESSION['DtAgg'], $strUtentiAziendeComp);
                        $trovate = mysql_num_rows($sqlPar);

                        echo "<br/>" . $msgRecordTrovati . $trovate . "<br/>";
                        echo "<br/>" . $msgSelectCriteriRicerca . "<br/>";
                        while ($rowPar = mysql_fetch_array($sqlPar)) {
                            $strFineNom = "";
                            if (strlen($rowPar['nome_variabile']) > 15) {
                                $strFineNom = $filtroPuntini;
                            }
                            $strFineDesComp = "";
                            if (strlen($rowPar['descri_componente']) > 30) {
                                $strFineDesComp = $filtroPuntini;
                            }
                            $strFineValMac = "";
                            if (strlen($rowPar['valore_mac']) > 15) {
                                $strFineValMac = $filtroPuntini;
                            }
                            $strFineValIn="";
                            if (strlen($rowPar['valore_iniziale']) > 15) {
                                $strFineValIn = $filtroPuntini;
                            }    
                            $dtAbilitato = dataEstraiVisualizza($rowPar['dt_abilitato']);
                            $dtValIniziale = dataEstraiVisualizza($rowPar['dt_valore_iniziale']);
                            $dtModificaMac = dataEstraiVisualizza($rowPar['dt_modifica_mac']);
                            $dtAggMac = dataEstraiVisualizza($rowPar['dt_agg_mac']);
                            ?>
                            <tr>
                                <td class="cella4" style="width:<?php echo $wid1 ?>"><?php echo($rowPar['id_val_comp']) ?>
                                    <td class="cella4" style="width:<?php echo $wid2 ?>"><?php echo($rowPar['id_par_comp']) ?></td>
                                    <td class="cella4" style="width:<?php echo $wid3 ?>" title="<?php echo($rowPar['nome_variabile'] . ": " . $rowPar['descri_variabile']) ?>"><?php echo(substr($rowPar['nome_variabile'], 0, 15) . $strFineNom) ?></td>
                                    <td class="cella4" style="width:<?php echo $wid4 ?>" title="<?php echo($rowPar['descri_componente']) ?>"><?php echo(substr($rowPar['descri_componente'], 0,30) . $strFineDesComp) ?></td>
                                    <td class="cella1" style="width:<?php echo $wid5 ?>"><textarea style="width:90%" rows="1" type="text" name="Valore<?php echo($rowPar['id_val_comp']); ?>" id="Valore<?php echo($rowPar['id_val_comp']); ?>"  value="<?php echo($rowPar['valore_variabile']); ?>"><?php echo($rowPar['valore_variabile']); ?></textarea></td>
                                    <td class="cella4" style="width:<?php echo $wid6 ?>" title="<?php echo $dtAbilitato ?>"><?php echo substr($dtAbilitato, 0, 11) ?></td>
                                    <td class="cella4" style="width:<?php echo $wid7 ?>" title="<?php echo $rowPar['valore_iniziale'] ?>" ><?php echo substr($rowPar['valore_iniziale'], 0, 10). $strFineValIn ?></td>
                                    <td class="cella4" style="width:<?php echo $wid8 ?>" title="<?php echo $dtValIniziale ?>"><?php echo substr($dtValIniziale, 0, 11) ?></td>
                                    <td class="cella4" style="width:<?php echo $wid9 ?>" title="<?php echo $rowPar['valore_mac'] ?>"><?php echo substr($rowPar['valore_mac'], 0, 10) . $strFineValMac?></td>
                                    <td class="cella4" style="width:<?php echo $wid10 ?>" title="<?php echo $dtModificaMac ?>"><?php echo substr($dtModificaMac, 0, 11) ?></td>
                                    <td class="cella4" style="width:<?php echo $wid11 ?>" title="<?php echo $dtAggMac ?>"><?php echo substr($dtAggMac, 0, 11) ?></td>
                            </tr>
                            <?php
                            $NPar++;
                        }
                        ?>

                    </tr>
                    <tr>
                        <td class="cella2" style="text-align: right " colspan="11">
                            <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                            <input type="button" id="ImpostaValIniziali" onclick="javascript:ImpostaValoreIniziale();" title="<?php echo $titleImpostaValoriIn ?>" value="<?php echo $valueBottonImpostaValIn ?>" />
                            <input type="button" onclick="javascript:Carica();" value="<?php echo $valueButtonSalva ?>" />
                        </td>
                    </tr>
                </table>
            </form>
            <div id="msgLog"><?php
if ($DEBUG) {
        echo "<br/>Tabella componente : utenti - aziende visibili " . $strUtentiAziendeComp;
        echo "<br/>actionOnLoad : " . $actionOnLoad;
    }?>
        </div>
        </div>
        
        </div><!--mainContainer-->
    </body>
</html>