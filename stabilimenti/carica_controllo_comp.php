<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <?php
    //Costruzione dell'array contenente i vari msg di errore
    $arrayMsgErrPhp = array($msgErrValutaMerce, //0
        $msgErrVerificaStab, //1
        $msgErrProcAdottata, //2
        $msgErrSelectStab, //3
        $msgErrMarchioCE, //4
        $msgErrSelectOperatore, //5
        $msgErrSelectMateriaPrima, //6
        $msgErrCodice, //7
        $msgErrQtaNumerica, //8
        $msgErrSelectStab //9
    );
    ?>
    <script language="javascript" type="text/javascript">

        var arrayMsgErrJs = new Array("<?= join('", "', $arrayMsgErrPhp) ?>");

        function disabilitaAction88() {
            //PERMESSO CONTROLLO MATERIE PRIME SILOS
            //Disabilita il link alla pagina di salvataggio
            document.getElementById('Salva').disabled = true;
        }
        function controllaCampi(arrayMsgErrJs) {

            var rv = true;
            var msg = "";

            if (document.getElementById('Stabilimento').value === "") {
                rv = false;
                msg = msg + arrayMsgErrJs[9];
            }
            //####### NESSUNA CASELLA SPUNTATA ###################################
            if (!document.getElementById('MarchioCe[Conforme]').checked &&
                    !document.getElementById('MarchioCe[NonConforme]').checked) {
                rv = false;
                msg = msg + arrayMsgErrJs[4];
            }
            if (!document.getElementById('Merce[Conforme]').checked &&
                    !document.getElementById('Merce[NonConforme]').checked) {
                rv = false;
                msg = msg + arrayMsgErrJs[0];
            }
            if (!document.getElementById('Stabilita[Conforme]').checked &&
                    !document.getElementById('Stabilita[NonConforme]').checked) {
                rv = false;
                msg = msg + arrayMsgErrJs[1];
            }
            if (!document.getElementById('Procedura[Reso]').checked &&
                    !document.getElementById('Procedura[ScaricatoSilos]').checked) {
                rv = false;
                msg = msg + arrayMsgErrJs[2];
            }
            //####### ENTRAMBE LE CASELLE SPUNTATE ###############################
            if (document.getElementById('MarchioCe[Conforme]').checked &&
                    document.getElementById('MarchioCe[NonConforme]').checked) {
                rv = false;
                msg = msg + arrayMsgErrJs[4];
            }
            if (document.getElementById('Merce[Conforme]').checked &&
                    document.getElementById('Merce[NonConforme]').checked) {
                rv = false;
                msg = msg + arrayMsgErrJs[0];
            }
            if (document.getElementById('Stabilita[Conforme]').checked &&
                    document.getElementById('Stabilita[NonConforme]').checked) {
                rv = false;
                msg = msg + arrayMsgErrJs[1];
            }
            if (document.getElementById('Procedura[Reso]').checked &&
                    document.getElementById('Procedura[ScaricatoSilos]').checked) {
                rv = false;
                msg = msg + arrayMsgErrJs[2];
            }

            //####### CONTROLLO CAMPI ############################################
            if (document.getElementById('IdComponente').value === "") {
                rv = false;
                msg = msg + arrayMsgErrJs[6];
            }
//            if (document.getElementById('CodiceIngressoComp').value === "") {
//                rv = false;
//                msg = msg + arrayMsgErrJs[7];
//            }
//            if (document.getElementById('Operatore').value === "") {
//                rv = false;
//                msg = msg + arrayMsgErrJs[5];
//            }

            if (document.getElementById('Quantita').value === "" || isNaN(document.getElementById('Quantita').value)) {
                rv = false;
                msg = msg + ' ' + arrayMsgErrJs[8];
            }

            if (!rv) {
                alert(msg);
                rv = false;
            }
            return rv;

        }

        function Carica() {

            document.forms["InserisciControlloComp"].action = "carica_controllo_comp2.php";
        }


    </script>
    <?php
    if ($DEBUG) ini_set('display_errors', 1);
   
    //################ GETIONE UTENTI ##########################################
    $elencoFunzioni = array("88");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni,$_SESSION['objPermessiVis']);

    //############# STRINGA UTENTI-AZIENDE VISIBILI ############################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
    $strUtAziendeMac = getStrUtAzVisib($_SESSION['objPermessiVis'], 'macchina');
    $strUtAziendeComp = getStrUtAzVisib($_SESSION['objPermessiVis'], 'componente');
    $strUtAziendeFigura = getStrUtAzVisib($_SESSION['objPermessiVis'], 'figura');

    //##########################################################################
    
    include('../include/gestione_date.php');
    include('../include/precisione.php');
    include('../Connessioni/serverdb.php');
    include('../sql/script.php');
    include('../sql/script_figura.php');
    include('../sql/script_macchina.php');
    include('../sql/script_anagrafe_macchina.php');
    include('../sql/script_componente.php');

    $_SESSION['IdMacchina'] = "";
    $_SESSION['DescriStab'] = "";
    if ($_SESSION['GruppoOperatore'] == "") {
        $_SESSION['GruppoOperatore'] = "Universale";
    }
    if ($_SESSION['GeograficoOperatore'] == "") {
        $_SESSION['GeograficoOperatore'] = "Mondo";
    }

    begin();   
    
    $sqlStab = selectStabByGruppoGeoVis($_SESSION['GruppoOperatore'], $_SESSION['GeograficoOperatore'], $strUtAziendeMac);
    $sqlComp = selectComponentiVisByDizionario($strUtAziendeComp, "descri_componente",$_SESSION['lingua']);
    $sqlFigure = selectFigureByGruppoGeoDiverseDaTipo2($_SESSION['GruppoOperatore'], $_SESSION['GeograficoOperatore'], '2', $strUtAziendeFigura);
    $sqlForn = selectFigureByGruppoGeoTipoVis($_SESSION['GruppoOperatore'], $_SESSION['GeograficoOperatore'], '2', $strUtAziendeFigura);

    commit();
    ?>

    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">

            <?php include('../include/menu.php'); ?>
            <div id="container" style="width:900px; margin:15px auto;">
                <form id="InserisciControlloComp" name="InserisciControlloComp" method="post" onsubmit="return controllaCampi(arrayMsgErrJs)" >
                    <table width="100%">
                        <tr>
                            <td class="cella3" colspan="3"><?php echo $titoloPaginaCaricaControlloComp ?></td>
                        </tr>

                        <tr>
                            <td class="cella2"><?php echo $filtroStabilimento ?> </td>
                            <td class="cella1" colspan="2">
                                <select name="Stabilimento" id="Stabilimento" >
                                    <option value="" selected=""><?php echo $labelOptionSelectStab ?></option>
                                    <?php
                                    while ($rowStab = mysql_fetch_array($sqlStab)) {
                                        ?>
                                        <option value="<?php echo ($rowStab['id_macchina'] . ";" . $rowStab['descri_stab']); ?>"><?php echo ($rowStab['descri_stab']); ?></option>
                                    <?php } ?>
                                </select> 
                            </td>
                        </tr>

                        <tr>
                            <td class="cella2" ><?php echo $filtroMateriaPrima ?></td>
                            <td class="cella1" colspan="2" > 
                                <select name="IdComponente" id="IdComponente">
                                    <option value="" selected=""><?php echo $labelOptionSelectMatPri ?></option>
                                    <?php
                                    while ($rowComp = mysql_fetch_array($sqlComp)) {
                                        ?>
                                        <option value="<?php echo $rowComp['id_comp'].";".$rowComp['vocabolo']; ?>"><?php echo $rowComp['vocabolo']; ?></option>
                                    <?php } ?>
                                </select></td>
                        </tr>
                        
<!--                        <tr>
                            <td class="cella2"><?php echo $filtroCodiceMatPri ?></td>
                            <td class="cella1" colspan="2"><input type="text" name="CodiceIngressoComp" id="CodiceIngressoComp" /></td>
                        </tr>                       -->
                        <tr>
                            <td class="cella2"><?php echo $filtroQuantita ?></td>
                            <td class="cella1" colspan="2"><input type="text" name="Quantita" id="Quantita" />&nbsp;<?php echo $filtrogBreve ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroCodiceCE ?></td>
                            <td class="cella1" colspan="2"><input type="text" name="CodiceCE" id="CodiceCE" /></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroMarchioCE ?></td>
                            <td class="cella1"><input type="checkbox" id="MarchioCe[Conforme]" name="MarchioCe[Conforme]" value="<?php echo $valConforme ?>"/><?php echo $filtroConforme ?></td>
                            <td class="cella1"><input type="checkbox" id="MarchioCe[NonConforme]" name="MarchioCe[NonConforme]" value="<?php echo $valNonConforme ?>"/><?php echo $filtroNonConforme ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroValutazioneMerce ?></td>
                            <td class="cella1"><input type="checkbox" id="Merce[Conforme]" name="Merce[Conforme]" value="<?php echo $valConforme ?>" /><?php echo $filtroConforme ?></td>
                            <td class="cella1"><input type="checkbox" id="Merce[NonConforme]" name="Merce[NonConforme]" value="<?php echo $valNonConforme ?>"/><?php echo $filtroNonConforme ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroVerificaStabilita ?></td>
                            <td class="cella1"><input type="checkbox" id="Stabilita[Conforme]" name="Stabilita[Conforme]" value="<?php echo $valConforme ?>"/><?php echo $filtroConforme ?></td>
                            <td class="cella1"><input type="checkbox" id="Stabilita[NonConforme]" name="Stabilita[NonConforme]" value="<?php echo $valNonConforme ?>"/><?php echo $filtroNonConforme ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroProceduraAdottata ?></td>                            
                            <td class="cella1"><input type="checkbox" id="Procedura[ScaricatoSilos]" name="Procedura[ScaricatoSilos]" value="<?php echo $valScaricatoSilos ?>"/> <?php echo $filtroScaricatoSilos ?></td>
                            <td class="cella1"><input type="checkbox" id="Procedura[Reso]" name="Procedura[Reso]" value="<?php echo $valReso ?>"/><?php echo $filtroReso ?></td>
                        </tr>
                        
                        
                        <tr>
                            <td class="cella2"><?php echo $filtroDtArrivoMerce ?></td>
                            <td class="cella1" colspan="2"><?php echo dataEstraiVisualizza(dataCorrenteInserimento()); ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroOperatore ?></td>
                            <td class="cella1" colspan="2"> 
                                <select name="Operatore" id="Operatore">
                                    <option value="" selected=""><?php echo $labelOptionSelectOper ?></option>
                                    <?php
                                    while ($rowOper = mysql_fetch_array($sqlFigure)) {
                                        ?>
                                        <option value="<?php echo $rowOper['codice'] ?>"><?php echo ($rowOper['nominativo']); ?></option>
                                    <?php } ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroFornitore ?></td>
                            <td class="cella1" colspan="2"> 
                                <select name="Fornitore" id="Fornitore">
                                    <option value="" selected=""><?php echo $labelOptionSelectFornitore ?></option>
                                    <?php
                                    while ($rowForn = mysql_fetch_array($sqlForn)) {
                                        ?>
                                        <option value="<?php echo $rowForn['id_figura'] ?>"><?php echo ($rowForn['nominativo']); ?></option>
                                    <?php } ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroRespProduzione ?></td>
                            <td class="cella1" colspan="2"> 
                                <select name="RespProduzione" id="RespProduzione">
                                    <option value="" selected=""><?php echo $labelOptionSelectRespProd ?></option>
                                    <?php
                                    mysql_data_seek($sqlFigure, 0);
                                    while ($rowRespProd = mysql_fetch_array($sqlFigure)) {
                                        ?>
                                        <option value="<?php echo $rowRespProd['nominativo'] ?>"><?php echo ($rowRespProd['nominativo']); ?></option>
                                    <?php } ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroRespQualita ?></td>
                            <td class="cella1" colspan="2"> 
                                <select name="RespQualita" id="RespQualita">
                                    <option value="" selected=""><?php echo $labelOptionSelectRespQualita ?></option>
                                    <?php
                                    mysql_data_seek($sqlFigure, 0);
                                    while ($rowRespQu = mysql_fetch_array($sqlFigure)) {
                                        ?>
                                        <option value="<?php echo $rowRespQu['nominativo'] ?>"><?php echo ($rowRespQu['nominativo']); ?></option>
                                    <?php } ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroConsTecnico ?></td>
                            <td class="cella1" colspan="2"> 
                                <select name="ConsTecnico" id="ConsTecnico">
                                    <option value="" selected=""><?php echo $labelOptionSelectConsTecnico ?></option>
                                    <?php
                                    mysql_data_seek($sqlFigure, 0);
                                    while ($rowCons = mysql_fetch_array($sqlFigure)) {
                                        ?>
                                        <option value="<?php echo $rowCons['nominativo'] ?>"><?php echo ($rowCons['nominativo']); ?></option>
                                    <?php } ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroNote ?></td>
                            <td class="cella1" colspan="2"><textarea name="Note" id="Note" ROWS="4" COLS="60"></textarea></td>
                        </tr>
                        <tr>
                            <td class="cella2" style="text-align: right " colspan="3">
                                 
                                
                                <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                <input type="submit" id="Salva" value="<?php echo $valueButtonSalva ?>" onClick="Carica()"/></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div id="msgLog">
                <?php
                if ($DEBUG) {
                    echo "</br>ActionOnLoad : " . $actionOnLoad;
                    echo "</br>Tabella macchina utenti e aziende visibili : " . $strUtAziendeMac;
                    echo "</br>Tabella componente utenti e aziende visibili : " . $strUtAziendeComp;
                    echo "</br>Tabella figura utenti e aziende visibili : " . $strUtAziendeFigura;
                }
                ?>
            </div>
        </div><!--mainContainer-->
    </body>
</html>
