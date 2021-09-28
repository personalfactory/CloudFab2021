<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <?php
    //TODO : creare nuove funzioni per par prod mac
    //#################### GESTIONE UTENTI #####################################
    //Verifico che l'utente abbia il permesso di modificare i valori par prod
    $elencoFunzioni = array("66", "67");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);

    //############# STRINGA UTENTI-AZIENDE VISIBILI ############################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
    $strUtentiAziendeProd = getStrUtAzVisib($_SESSION['objPermessiVis'], 'prodotto');
    ?>
    <script language="javascript">
        function Carica() {
            document.forms["ModificaValoreParProdMac"].action = "modifica_valore_par_prod_mac2.php";
            document.forms["ModificaValoreParProdMac"].submit();
        }
        function RicaricaPagina() {
            location.href = "modifica_valore_par_prod_mac.php";
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
            include('../sql/script_valore_par_prod_mac.php');
            include('../sql/script_macchina.php');


            //############ INIZIALIZZAZIONE DELLE VARIABILI DI SESSIONE ####################
            //Solo se la richiesta della pagina arriva dal menu azzero le variabili di sessione

            if (isset($_GET['FromMenu']) && $_GET['FromMenu'] == 1 && isset($_GET['IdMacchina'])) {

                $_SESSION['IdMacchina'] = $_GET['IdMacchina'];
                $_SESSION['IdValPM'] = "";
                $_SESSION['IdParPM'] = "";
                $_SESSION['NomeVariabile'] = "";
                $_SESSION['DescriVariabile'] = "";
                $_SESSION['NomeProdotto'] = "";
                $_SESSION['ValoreVariabile'] = "";
                $_SESSION['DtAbilitato'] = "";
            }

            //Se il post è settato (vuoto oppure diverso dal vuoto) memorizzo il suo contenuto 
            //nella variabile di sessione
            //Altrimenti la variabile di sessione conserva il valore precedentemente salvato
            if (isSet($_POST['IdValPM'])) {
                $_SESSION['IdValPM'] = trim($_POST['IdValPM']);
            }
            if (isSet($_POST['IdParPM'])) {
                $_SESSION['IdParPM'] = trim($_POST['IdParPM']);
            }
            if (isSet($_POST['NomeVariabile'])) {
                $_SESSION['NomeVariabile'] = trim($_POST['NomeVariabile']);
            }
            if (isSet($_POST['DescriVariabile'])) {
                $_SESSION['DescriVariabile'] = trim($_POST['DescriVariabile']);
            }
            if (isSet($_POST['NomeProdotto'])) {
                $_SESSION['NomeProdotto'] = trim($_POST['NomeProdotto']);
            }
            if (isSet($_POST['ValoreVariabile'])) {
                $_SESSION['ValoreVariabile'] = trim($_POST['ValoreVariabile']);
            }
            if (isSet($_POST['DtAbilitato'])) {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitato']);
            }


//########### VARIABILE DI ORDINAMENTO DELLA QUERY #############################
            $_SESSION['Filtro'] = "id_val_pm";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }

//########### INFORMAZIONI SULLA MACCHINA ######################################

            $sqlMac = findMacchinaById($_SESSION['IdMacchina']);
            while ($rowMac = mysql_fetch_array($sqlMac)) {

                $CodiceStab = $rowMac['cod_stab'];
                $DescriStab = $rowMac['descri_stab'];
                $Data = $rowMac['dt_abilitato'];
            }

//Larghezza colonne 
//TOTALE container 1170px
            $wid1 = "5%";
            $wid2 = "5%";
            $wid3 = "15%";
            $wid4 = "30%";
            $wid5 = "25%";
            $wid6 = "10%";
            $wid7 = "10%";
            ?>

            <form class="form" id="ModificaValoreParProdMac" name="ModificaValoreParProdMac" method="post" >
                <table class="table3">
                    <tr>
                        <th colspan="11"><?php echo $titoloPaginaModificaValParProdMac; ?></th>
                    </tr>
                    <tr>
                        <th colspan="11"> <?php echo $filtroStabilimento . " " . $DescriStab ?></th>
                    </tr> 
                </table>
                <table class="table3" width="100%">
                    <!--################## RICERCA CON INPUT TEXT ###############################-->
                    <tr>
                        <td><input style="width:100%" type="text" name="IdValPM" value="<?php echo $_SESSION['IdValPM'] ?>" onChange="document.forms['ModificaValoreParProdMac'].submit();"/></td>
                        <td><input style="width:100%" type="text" name="IdParPM"   value="<?php echo $_SESSION['IdParPM'] ?>" onChange="document.forms['ModificaValoreParProdMac'].submit();"/></td>
                        <td><input style="width:100%" type="text" name="NomeVariabile"  value="<?php echo $_SESSION['NomeVariabile'] ?>" onChange="document.forms['ModificaValoreParProdMac'].submit();"/></td>
                        <td><input style="width:100%" type="text" name="DescriVariabile"  value="<?php echo $_SESSION['DescriVariabile'] ?>" onChange="document.forms['ModificaValoreParProdMac'].submit();"/></td>
                        <td><input style="width:100%" type="text" name="NomeProdotto" value="<?php echo $_SESSION['NomeProdotto'] ?>" onChange="document.forms['ModificaValoreParProdMac'].submit();"/></td>
                        <td><input style="width:100%" type="text" name="ValoreVariabile" value="<?php echo $_SESSION['ValoreVariabile'] ?>" onChange="document.forms['ModificaValoreParProdMac'].submit();"/></td>
                        <td><input style="width:100%" type="text" name="DtAbilitato" value="<?php echo $_SESSION['DtAbilitato'] ?>" onChange="document.forms['ModificaValoreParProdMac'].submit();"/></td>
                        <td><img src="/CloudFab/images/icone/lente_piccola.png" onClick="document.forms['ModificaValoreParProdMac'].submit();" title="<?php echo $titleRicerca ?>"/></td>
                    </tr>
                    <!--################## ORDINAMENTO ########################################-->
                    <tr>
                        <td class="cella3" style="width:<?php echo $wid1 ?>"><div id="OrdinaIdValPM"><?php echo $filtroIdValore; ?>
                                <button name="Filtro" type="submit" value="id_val_pm" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                                    <img src="/CloudFab/images/arrow3.png" /></button></div>
                        </td>
                        <td class="cella3" style="width:<?php echo $wid2 ?>"><div id="OrdinaIdPar"><?php echo $filtroIdPar; ?>
                                <button name="Filtro" type="submit" value="p.id_par_pm" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                                    <img src="/CloudFab/images/arrow3.png" /></button></div>
                        </td>
                        <td class="cella3" style="width:<?php echo $wid3 ?>"><div id="OrdinaPar"><?php echo $filtroPar; ?>
                                <button name="Filtro" type="submit" value="nome_variabile" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                                    <img src="/CloudFab/images/arrow3.png" /></button></div>
                        </td>
                        <td class="cella3" style="width:<?php echo $wid4 ?>"><div id="OrdinaDescriVar"><?php echo $filtroDescrizione; ?>
                                <button name="Filtro" type="submit" value="descri_variabile" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                                    <img src="/CloudFab/images/arrow3.png" /></button></div>
                        </td>
                        <td class="cella3" style="width:<?php echo $wid5 ?>"><div id="OrdinaProd"><?php echo $filtroProdotto; ?>
                                <button name="Filtro" type="submit" value="nome_prodotto" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                                    <img src="/CloudFab/images/arrow3.png" /></button></div>
                        </td>
                        <td class="cella3" style="width:<?php echo $wid6 ?>"><div id="OrdinaVal"><?php echo $filtroValore; ?>
                                <button name="Filtro" type="submit" value="valore_variabile" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                                    <img src="/CloudFab/images/arrow3.png" /></button></div>
                        </td>
                        <td class="cella3" style="width:<?php echo $wid7?>"><div id="OrdinaDtAbil"><?php echo $filtroDtAbilitato; ?>
                                <button name="Filtro" type="submit" value="v.dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                                    <img src="/CloudFab/images/arrow3.png" /></button></div>
                        </td>

                    </tr>
                    <tr>
<?php
//######### VISUALIZZAZIONE DEI PARAMETRI PRESENTI NELLA TABELLA [valore_par_comp] #######
$NPar = 1;
$sqlPar = findValoreParProdByIdMacchina($_SESSION['IdMacchina'], $_SESSION['Filtro'], $_SESSION['IdValPM'], $_SESSION['IdParPM'], $_SESSION['NomeVariabile'], $_SESSION['NomeProdotto'], $_SESSION['ValoreVariabile'], $_SESSION['DtAbilitato'], $strUtentiAziendeProd);
$trovate = mysql_num_rows($sqlPar);

echo "<br/>" . $msgRecordTrovati . $trovate . "<br/>";
echo "<br/>" . $msgSelectCriteriRicerca . "<br/>";
while ($rowPar = mysql_fetch_array($sqlPar)) {
    $strFineNom = "";
    if (strlen($rowPar['nome_variabile']) > 50) {
        $strFineNom = $filtroPuntini;
    }
    
    $strFineNomeProd = "";
    if (strlen($rowPar['nome_prodotto']) > 100) {
        $strFineNomeProd = $filtroPuntini;
    }

    $dtAbilitato = dataEstraiVisualizza($rowPar['dt_abilitato']);
    ?>
                            <tr>
                                <td class="cella4" style="width:<?php echo $wid1 ?>"><?php echo($rowPar['id_val_pm']) ?>
                                <td class="cella4" style="width:<?php echo $wid2 ?>"><?php echo($rowPar['id_par_pm']) ?></td>
                                <td class="cella4" style="width:<?php echo $wid3 ?>"><?php echo(substr($rowPar['nome_variabile'], 0, 50) . $strFineNom) ?></td>
                                <td class="cella4" style="width:<?php echo $wid4 ?>"><?php echo $rowPar['descri_variabile'] ?></td>
                                <td class="cella4" style="width:<?php echo $wid5 ?>"><?php echo(substr($rowPar['nome_prodotto'], 0, 100) . $strFineNomeProd) ?></td>
                                <td class="cella4" style="width:<?php echo $wid6 ?>"><textarea style="width:90%" rows="1"  type="text" name="Valore<?php echo($rowPar['id_val_pm']); ?>" id="Valore<?php echo($rowPar['id_val_pm']); ?>"  value="<?php echo($rowPar['valore_variabile']); ?>"><?php echo($rowPar['valore_variabile']); ?></textarea></td>
                                <td class="cella4" style="width:<?php echo $wid7 ?>" title="<?php echo $dtAbilitato ?>"><?php echo $dtAbilitato ?></td>
                            </tr>
    <?php
    $NPar++;
}
?>

                    </tr>
                    <tr>
                        <td class="cella2" style="text-align: right " colspan="7">
                            <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                            <input type="button" onclick="javascript:Carica();" value="<?php echo $valueButtonSalva ?>" />
                        </td>
                    </tr>
                </table>
            </form>
            <div id="msgLog"><?php
                        if ($DEBUG) {
                            echo "<br/>Tabella prodotto : utenti - aziende visibili " . $strUtentiAziendeProd;
                            echo "<br/>actionOnLoad : " . $actionOnLoad;
                        }
?>
            </div>
        </div>

        </div><!--mainContainer-->
    </body>
</html>