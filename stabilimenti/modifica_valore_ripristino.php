<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <?php
   
    //#################### GESTIONE UTENTI #####################################
    //Verifico che l'utente abbia il permesso di modificare i valori par ripristino
    $elecoFunzioni = array("70");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni,$_SESSION['objPermessiVis']);

    if ($DEBUG) {

        echo "<br/>actionOnLoad : " . $actionOnLoad;
    }
    ?>
            <script language="javascript">
                function Carica() {
                    document.forms["ModificaValoreRip"].action = "modifica_valore_ripristino2.php";
                    document.forms["ModificaValoreRip"].submit();
                }
                function disabilitaAction1() {
            document.getElementById('Salva').disabled = true;

        }
            </script>
    
     <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script_valore_ripristino.php');
            include('../sql/script_macchina.php');

            //############ INIZIALIZZAZIONE DELLE VARIABILI DI SESSIONE ####################
            //Solo se la richiesta della pagina arriva dal menu azzero le variabili di sessione
            if (isset($_GET['FromMenu']) && $_GET['FromMenu'] == 1) {
                $_SESSION['IdValRip'] = "";
                $_SESSION['IdParRip'] = "";
                $_SESSION['NomeVariabile'] = "";
                $_SESSION['ValoreVariabile'] = "";
                $_SESSION['DtAbilitato'] = "";
                $_SESSION['IdProcesso'] = "";
                $_SESSION['DtRegistrato'] = "";
                $_SESSION['DtAggMac'] = "";
            }

            if (isSet($_POST['IdValRip'])) {
                $_SESSION['IdValRip'] = trim($_POST['IdValRip']);
            }
            if (isSet($_POST['IdParRip'])) {
                $_SESSION['IdParRip'] = trim($_POST['IdParRip']);
            }
            if (isSet($_POST['NomeVariabile'])) {
                $_SESSION['NomeVariabile'] = trim($_POST['NomeVariabile']);
            }
            if (isSet($_POST['ValoreVariabile'])) {
                $_SESSION['ValoreVariabile'] = trim($_POST['ValoreVariabile']);
            }
            if (isSet($_POST['DtAbilitato'])) {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitato']);
            }
            if (isSet($_POST['IdProcesso'])) {
                $_SESSION['IdProcesso'] = trim($_POST['IdProcesso']);
            }
            if (isSet($_POST['DtRegistrato'])) {
                $_SESSION['DtRegistrato'] = trim($_POST['DtRegistrato']);
            }
            if (isSet($_POST['DtAggMac'])) {
                $_SESSION['DtAggMac'] = trim($_POST['DtAggMac']);
            }

//########### VARIABILE DI ORDINAMENTO DELLA QUERY #############################
            $_SESSION['Filtro'] = "id_valore_ripristino";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }
//############### ID MACCHINA ##################################################      
            $_SESSION['IdMacchina'] = "";
            if (isset($_GET['IdMacchina'])) {
                $_SESSION['IdMacchina'] = $_GET['IdMacchina'];
            }
//############# LOG ###########################      
//      echo "From menu : ".$_GET['FromMenu'];
//      echo "</br> SESSION['IdValRip'] : " . $_SESSION['IdValRip'];
//      echo "</br> SESSION['IdParRip'] : " . $_SESSION['IdParRip'];
//      echo "</br> SESSION['NomeVariabile'] : " . $_SESSION['NomeVariabile'];
//      echo "</br> SESSION['ValoreVariabile'] : " . $_SESSION['ValoreVariabile'];
//      echo "</br> SESSION['DtAbilitato'] : " . $_SESSION['DtAbilitato'];
//      echo "</br> SESSION['IdProcesso'] : " . $_SESSION['IdProcesso'];
//      echo "</br> SESSION['DtRegistrato'] : " . $_SESSION['DtRegistrato'];
//      echo "</br> SESSION['DtAggMac'] : " . $_SESSION['DtAggMac'];
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
            $wid1 = "10%";
            $wid2 = "10%";
            $wid3 = "20%";
            $wid4 = "20%";
            $wid5 = "10%";
            $wid6 = "10%";
            $wid7 = "10%";
            $wid8 = "10%";
            ?>

           

                <form class="form" id="ModificaValoreRip" name="ModificaValoreRip" method="post" >
                    <table class="table3" width="100%">
                        <tr>
                            <th><?php echo $titoloPaginaGestioneParRipristino ?></th>
                        </tr>
                        <tr>
                            <th><?php echo $filtroStabilimento . " " . $DescriStab ?></th>
                        </tr> 
                    </table>
                    <table class="table3" width="100%">
                        <!--        
                        <!--################## RICERCA CON INPUT TEXT ###############################-->
                        <tr>
                            <td><input style="width:100%" type="text" name="IdValRip" value="<?php echo $_SESSION['IdValRip'] ?>" onChange="document.forms['ModificaValoreRip'].submit();"/></td>
                            <td><input style="width:100%" type="text" name="IdParRip"  value="<?php echo $_SESSION['IdParRip'] ?>" onChange="document.forms['ModificaValoreRip'].submit();"/></td>
                            <td><input style="width:100%" type="text" name="NomeVariabile"  value="<?php echo $_SESSION['NomeVariabile'] ?>" onChange="document.forms['ModificaValoreRip'].submit();"/></td>
                            <td><input style="width:100%" type="text" name="ValoreVariabile" value="<?php echo $_SESSION['ValoreVariabile'] ?>" onChange="document.forms['ModificaValoreRip'].submit();"/></td>
                            <td><input style="width:100%" type="text" name="IdProcesso" value="<?php echo $_SESSION['IdProcesso'] ?>" onChange="document.forms['ModificaValoreRip'].submit();"/></td>
                            <td><input style="width:100%" type="text" name="DtRegistrato"  value="<?php echo $_SESSION['DtRegistrato'] ?>" onChange="document.forms['ModificaValoreRip'].submit();"/></td>
                            <td><input style="width:100%" type="text" name="DtAbilitato"  value="<?php echo $_SESSION['DtAbilitato'] ?>" onChange="document.forms['ModificaValoreRip'].submit();"/></td>
                            <td><input style="width:100%" type="text" name="DtAggMac"  value="<?php echo $_SESSION['DtAggMac'] ?>" onChange="document.forms['ModificaValoreRip'].submit();"/></td>
                            <td><img src="/CloudFab/images/icone/lente_piccola.png" onClick="document.forms['ModificaValoreRip'].submit();" title="<?php echo $titleRicerca ?>"/></td>
                        </tr>
                        <!--################## ORDINAMENTO ########################################-->
                        <tr>
                            <td class="cella3" style="width:<?php echo $wid1 ?>"><div id="OrdinaIdVal"><?php echo $filtroId; ?>
                                    <button name="Filtro" type="submit" value="id_valore_ripristino" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                                        <img src="/CloudFab/images/arrow3.png" /></button></div>
                            </td>
                            <td class="cella3" style="width:<?php echo $wid2 ?>"><div id="OrdinaIdPar"><?php echo $filtroIdPar; ?>
                                    <button name="Filtro" type="submit" value="id_par_ripristino" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                                        <img src="/CloudFab/images/arrow3.png" /></button></div>
                            </td>
                            <td class="cella3" style="width:<?php echo $wid3 ?>"><div id="OrdinaPar"><?php echo $filtroPar; ?>
                                    <button name="Filtro" type="submit" value="nome_variabile" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                                        <img src="/CloudFab/images/arrow3.png" /></button></div>
                            </td>
                            <td class="cella3" style="width:<?php echo $wid4 ?>"><div id="OrdinaVal"><?php echo $filtroValore; ?>
                                    <button name="Filtro" type="submit" value="valore_variabile" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                                        <img src="/CloudFab/images/arrow3.png" /></button></div>
                            </td>
                            <td class="cella3" style="width:<?php echo $wid5 ?>"><div id="OrdinaidProc"><?php echo $filtroIdProcesso; ?>
                                    <button name="Filtro" type="submit" value="id_pro_corso" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                                        <img src="/CloudFab/images/arrow3.png" /></button></div>
                            </td>
                            <td class="cella3" style="width:<?php echo $wid6 ?>"><div id="OrdinaRegistr"><?php echo $filtroDtRegistrato; ?>
                                    <button name="Filtro" type="submit" value="dt_registrato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                                        <img src="/CloudFab/images/arrow3.png" /></button></div>
                            </td>
                            <td class="cella3" style="width:<?php echo $wid7 ?>"><div id="OrdinaDtAbil"><?php echo $filtroDtAbilitato; ?>
                                    <button name="Filtro" type="submit" value="dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                                        <img src="/CloudFab/images/arrow3.png" /></button></div>
                            </td>
                            <td class="cella3" style="width:<?php echo $wid8 ?>"><div id="OrdinaDtAggMac"><?php echo $filtroDtAgg; ?>
                                    <button name="Filtro" type="submit" value="dt_agg_mac" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                                        <img src="/CloudFab/images/arrow3.png" /></button></div>
                            </td>
                        </tr>
                        <tr>
                            <?php
                            //Visualizzo l'elenco dei parametri presenti nella tabella [valore_ripristino]
                            $NPar = 1;
                            $sqlPar = findValoreRipristinoByIdMacchina(
                                    $_SESSION['IdMacchina'], $_SESSION['Filtro'], $_SESSION['IdValRip'], $_SESSION['IdParRip'], $_SESSION['NomeVariabile'], $_SESSION['ValoreVariabile'], $_SESSION['DtAbilitato'], $_SESSION['IdProcesso'], $_SESSION['DtRegistrato'], $_SESSION['DtAggMac']);

                            $trovate = mysql_num_rows($sqlPar);

                            echo "<br/>" . $msgRecordTrovati . $trovate . "<br/>";
                            echo "<br/>" . $msgSelectCriteriRicerca . "<br/>";

                            while ($rowPar = mysql_fetch_array($sqlPar)) {

                                $strFineDtRe = "";
                                $dtRegistrato = dataEstraiVisualizza($rowPar['dt_registrato']);
                                if (strlen($rowPar['dt_registrato']) > 11) {
                                    
                                    $strFineDtRe = $filtroPuntini;
                                }
                                $strFineDtAb = "";
                                $dtAbilitato = dataEstraiVisualizza($rowPar['dt_abilitato']);
                                if (strlen($rowPar['dt_abilitato']) > 11) {
                                    $strFineDtAb = $filtroPuntini;
                                }
                                $strFineDtAgg = "";
                                $dtAggMac = dataEstraiVisualizza($rowPar['dt_agg_mac']);
                                if (strlen($rowPar['dt_agg_mac']) > 11) {
                                    $strFineDtAgg = $filtroPuntini;
                                }
                                ?>
                                <tr>
                                    <td class="cella4" style="width:<?php echo $wid1 ?>"><?php echo($rowPar['id_valore_ripristino']) ?></td>
                                    <td class="cella4" style="width:<?php echo $wid2 ?>"><?php echo($rowPar['id_par_ripristino']) ?></td>
                                    <td class="cella4" style="width:<?php echo $wid3 ?>" title="<?php echo($rowPar['descri_variabile']) ?>"><?php echo($rowPar['nome_variabile']) ?></td>
                                    <td class="cella1" style="width:<?php echo $wid4 ?>"><textarea style="width:90%" type="text" rows="1" name="Valore<?php echo($NPar); ?>" id="Valore<?php echo($NPar); ?>" value="<?php echo($rowPar['valore_variabile']); ?>"><?php echo($rowPar['valore_variabile']); ?></textarea></td>
                                    <td class="cella4" style="width:<?php echo $wid5 ?>"><?php echo($rowPar['id_pro_corso']) ?></td>
                                    <td class="cella4" style="width:<?php echo $wid6 ?>" title="<?php echo $dtRegistrato ?>"><?php echo substr($dtRegistrato, 0, 11) . $strFineDtRe ?></td>
                                    <td class="cella4" style="width:<?php echo $wid7 ?>" title="<?php echo $dtAbilitato ?>"><?php echo substr($dtAbilitato, 0, 11) . $strFineDtAb ?></td>
                                    <td class="cella4" style="width:<?php echo $wid8 ?>" title="<?php echo $dtAggMac ?>"><?php echo substr($dtAggMac, 0, 11) . $strFineDtAgg ?></td>
                                </tr>

    <?php
    $NPar++;
}
?>
                        </tr>
                        <tr>
                            <td class="cella2" style="text-align: right " colspan="8">
                                <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                <input type="button" id="Salva" onclick="javascript:Carica();" value="<?php echo $valueButtonSalva ?>" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>

        </div><!--mainContainer-->

    </body>
</html>

