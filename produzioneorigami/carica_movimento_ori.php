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
        $msgErrSelectStab, //9
        $msgErrNumDoc, //10
        $msgErrDataDoc, //11
        $msgErrControlloDtDoc,//12
        $msgErrRespProduzione,//13
        $msgErrDataArr//14
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

            if (document.getElementById('NumDoc').value !== "") {
              /**  rv = false;
                msg = msg + ' ' + arrayMsgErrJs[10];*/

                if (document.getElementById('GiornoDoc').value === ""
                        || document.getElementById('MeseDoc').value === ""
                        || document.getElementById('AnnoDoc').value === ""
                        || isNaN(document.getElementById('GiornoDoc').value)
                        || isNaN(document.getElementById('MeseDoc').value)
                        || isNaN(document.getElementById('AnnoDoc').value)) {
                    rv = false;
                    msg = msg + ' ' + arrayMsgErrJs[11];
                }

                if (!(document.getElementById('GiornoDoc').value.length === 2)
                        || !(document.getElementById('AnnoDoc').value.length === 4)
                        || document.getElementById('GiornoDoc').value < 1
                        || document.getElementById('GiornoDoc').value > 31) {
                    rv = false;
                    msg = msg + ' ' + arrayMsgErrJs[12];
                }
            }
            
            if (document.getElementById('GiornoArrivoMerce').value !== "" &&
                    document.getElementById('AnnoArrivoMerce').value !== "") {
              

                if (document.getElementById('GiornoArrivoMerce').value === ""
                        || document.getElementById('MeseArrivoMerce').value === ""
                        || document.getElementById('AnnoArrivoMerce').value === ""
                        || isNaN(document.getElementById('GiornoArrivoMerce').value)
                        || isNaN(document.getElementById('MeseArrivoMerce').value)
                        || isNaN(document.getElementById('AnnoArrivoMerce').value)) {
                    rv = false;
                    msg = msg + ' ' + arrayMsgErrJs[14];
                }

                if (!(document.getElementById('GiornoArrivoMerce').value.length === 2)
                        || !(document.getElementById('AnnoArrivoMerce').value.length === 4)
                        || document.getElementById('GiornoArrivoMerce').value < 1
                        || document.getElementById('GiornoArrivoMerce').value > 31) {
                    rv = false;
                    msg = msg + ' ' + arrayMsgErrJs[14];
                }
            }

            if (document.getElementById('Stabilimento').value === "") {
                rv = false;
                msg = msg + arrayMsgErrJs[9];
            }
            
            if (document.getElementById('RespProduzione').value === "") {
                rv = false;
                msg = msg + arrayMsgErrJs[13];
            }
            //####### NESSUNA CASELLA SPUNTATA ###################################
            if (!document.getElementById('MarchioCe').checked) {
                rv = false;
                msg = msg + arrayMsgErrJs[4];
            }
            if (!document.getElementById('Merce').checked) {
                rv = false;
                msg = msg + arrayMsgErrJs[0];
            }
            if (!document.getElementById('Stabilita').checked) {
                rv = false;
                msg = msg + arrayMsgErrJs[1];
            }
            /**if (!document.getElementById('Procedura').checked) {
             rv = false;
             msg = msg + arrayMsgErrJs[2];
             }*/



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

            document.forms["InserisciControlloComp"].action = "carica_movimento_ori2.php";
        }
        function NuovaAnagrafica() {
                    location.href = "../stabilimenti/carica_figura.php?HrefBack=../produzioneorigami/carica_movimento_ori.php";
                }
    </script>

    <?php
    if ($DEBUG)
        ini_set('display_errors', '1');

    //################ GETIONE UTENTI ##########################################
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
    include('../sql/script_parametro_glob_mac.php');

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
    $sqlComp = selectComponentiVisByDizionario($strUtAziendeComp, "descri_componente", $_SESSION['lingua']);
    $sqlFigure = selectFigureByGruppoGeoDiverseDaTipo2($_SESSION['GruppoOperatore'], $_SESSION['GeograficoOperatore'], '2', $strUtAziendeFigura);
    $sqlForn = selectFigureByGruppoGeoTipoVis($_SESSION['GruppoOperatore'], $_SESSION['GeograficoOperatore'], '2', $strUtAziendeFigura);



    $valTipoAdditivo = "";
    $valoreTipoMatPrima = "";
    $sqlParGlob = findParGlobMac();
    while ($rowParGlob = mysql_fetch_array($sqlParGlob)) {

        switch ($rowParGlob['id_par_gm']) {

            case 117:
                //RAW MATERIAL
                $strTipoMatPrima = $rowParGlob['valore_variabile'];
                break;

            case 118:
                //DELIVERY NOTE
                $strProcAdottataDN = $rowParGlob['valore_variabile'];
                break;

            case 119:
                //WAREHOUSE OUT
                $strTipoMovWareHOut = $rowParGlob['valore_variabile'];
                break;


            case 137:
                //INTEGRATION (ADDITIVE / COLOR)
                $strTipoAdditivo = $rowParGlob['valore_variabile'];
                break;

            case 138:
                //RETURN
                $strProcAdottataReso = $rowParGlob['valore_variabile'];
                break;

            case 139:
                //SERVER
                $strOrigineMovServer = $rowParGlob['valore_variabile'];
                break;


            case 146:
                ///WAREHOUSE IN
                $strTipoMovWareHIn = $rowParGlob['valore_variabile'];
                break;

            default:
                break;
        }
    }

    commit();
    $actionOnLoad = "";
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
            <?php include('../include/menu.php'); ?>
            <div id="container" style="width:900px; margin:15px auto;">
                <form id="InserisciControlloComp" name="InserisciControlloComp" method="post"  enctype="multipart/form-data" onsubmit="return controllaCampi(arrayMsgErrJs)" >
                    <table width="100%">
                        <tr>
                            <td class="cella3" colspan="3"><?php echo $titoloPaginaNuovoMovimentoOrigami ?></td>
                        </tr>
                        <input type="hidden"  name="origineMov" value="<?php echo $strOrigineMovServer ?>" />
                        <tr>
                            <td class="cella2"><?php echo $filtroStabilimento ?> </td>
                            <td class="cella2" colspan="2">
                                <select name="Stabilimento" id="Stabilimento" >
                                    <option value="0" selected="0"><?php echo $labelOptionSelectStab ?></option>
                                    <?php
                                    while ($rowStab = mysql_fetch_array($sqlStab)) {
                                        ?>
                                        <option value="<?php echo ($rowStab['id_macchina'] . ";" . $rowStab['descri_stab']); ?>"><?php echo ($rowStab['descri_stab']); ?></option>
                                    <?php } ?>
                                </select> 
                            </td>
                        </tr>
                        <tr>
                            <td class="cella1" colspan="3"><?php echo $filtroInfoMovimento ?></td>
                        </tr>

                        <tr>
                            <td class="cella4"><?php echo $filtroOperazione ?> </td>
                            <td class="cella2" colspan="2">
                                <select  name="InfoMov" id="InfoMov" >
                                    <option value="<?php echo $valCarico . ";" . $valCaricoPerAcq . ";" . $strTipoMovWareHIn ?>" selected="<?php echo $valCarico . ";" . $valCaricoPerAcq . ";" . $strTipoMovWareH ?>"><?php echo $filtroCaricoPerAcq ?></option>
                                    <option value="<?php echo $valCarico . ";" . $valCaricoPerInv . ";" . $strTipoMovWareHIn ?>"><?php echo $filtroCaricoPerInv ?></option>
                                    <option value="<?php echo $valScarico . ";" . $valScaricoPerInv . ";" . $strTipoMovWareHOut ?>"><?php echo $filtroScaricoPerInv ?></option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td class="cella2"><?php echo $filtroProceduraAdottata ?></td>                            
                            <td class="cella2"><input type="radio" id="Procedura" name="Procedura" value="<?php echo $strProcAdottataDN ?>"/> <?php echo $filtroDocTrasporto ?></td>
                            <td class="cella2"><input type="radio" id="Procedura" name="Procedura" value="<?php echo $strProcAdottataReso ?>"/><?php echo $filtroReso ?></td>
                        </tr> 
                        <tr>
                            <td class="cella2" ><?php echo $filtroNumDoc ?></td>
                            <td class="cella2" colspan="2"><input type="text" name="NumDoc" id="NumDoc" />
                            </td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroDataDoc ?> </td>
                            <td class="cella2" colspan="2"><?php formSceltaData("GiornoDoc", "MeseDoc", "AnnoDoc", $arrayFiltroMese) ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDataMov ?></td>
                            <td class="cella2" colspan="2"><?php echo dataEstraiVisualizza(dataCorrenteInserimento()); ?></td>
                        </tr>

                        <tr>
                            <td class="cella2"><?php echo $filtroOperatore ?></td>
                            <td class="cella2" colspan="2"> 
                                <select name="Operatore" id="Operatore">
                                    <option value="" selected=""><?php echo $labelOptionSelectOper ?></option>
                                    <?php
                                    while ($rowOper = mysql_fetch_array($sqlFigure)) {
                                        ?>
                                        <option value="<?php echo $rowOper['codice'] ?>"><?php echo ($rowOper['nominativo']); ?></option>
                                    <?php } ?>
                                </select>  
                                <input type="button" value="+" onClick="javascript:NuovaAnagrafica();" title="<?php echo $titleNuovoOperatore ?>"/></td>
                        </tr>
                        <tr>
                            <td class="cella1" colspan="3"><?php echo $filtroInfoMatPrima ?></td>
                        </tr>
                       <!--<tr>
                            <td class="cella2"><?php echo $filtroTipoMateriale ?></td>
                            <td class="cella2"><input type="radio" id="TipoMat" name="TipoMat" value="<?php echo $strTipoMatPrima ?>"/><?php echo $filtroMateriaPrima ?></td>
                            <td class="cella2"><input type="radio" id="TipoMat" name="TipoMat" value="<?php echo $strTipoAdditivo ?>"/><?php echo $filtroIntegrazione ?></td>
                        </tr>-->
                        <input type="hidden" name="TipoMat" id="TipoMat" value="<?php echo $strTipoMatPrima ?>"/>
                        <tr>
                            <td class="cella2" ><?php echo $filtroMateriale ?></td>
                            <td class="cella2" colspan="2">        
                                <select name="IdComponente" id="IdComponente">
                                    <option value="" selected=""><?php echo $labelOptionSelectMateriale ?></option>
                                    <?php
                                    while ($rowComp = mysql_fetch_array($sqlComp)) {
                                        ?>
                                        <option value="<?php echo $rowComp['id_comp'] . ";" . $rowComp['vocabolo']; ?>"><?php echo $rowComp['vocabolo']; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <!--Il codice integrazione è il codice kit della formula (KADV01) relativa agli additivi o colori -->
                        <tr>
                            <td class="cella4"><?php echo $filtroCodiceIntegrazione ?></td>
                            <td class="cella2" colspan="2"><input type="text" name="CodiceIntegrazione" id="CodiceIntegrazione" /></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroRifSilo ?></td>
                            <td class="cella2" colspan="2"><input type="text" name="Silo" id="Silo" /></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroTipoConfezione ?></td>
                            <td class="cella2" colspan="2"><input type="text" name="TipoConf" id="TipoConf" /></td>
                        </tr>

                        <tr>
                            <td class="cella4"><?php echo $filtroNumConfezioni ?></td>
                            <td class="cella2" colspan="2"><input type="text" name="NumConf" id="NumConf" /></td></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroPesoConfezione ?></td>
                            <td class="cella2" colspan="2"><input type="text" name="PesoConf" id="PesoConf" />&nbsp;<?php echo $filtrogBreve ?></td></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroQuantitaTotale ?></td>
                            <td class="cella2" colspan="2"><input type="text" name="Quantita" id="Quantita" />&nbsp;<?php echo $filtrogBreve ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDtArrivoMerce ?> </td>
                            <td class="cella2" colspan="2"><?php formSceltaData("GiornoArrivoMerce", "MeseArrivoMerce", "AnnoArrivoMerce", $arrayFiltroMese) ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroFornitore ?></td>
                            <td class="cella2" colspan="2"> 
                                <select name="Fornitore" id="Fornitore">
                                    <option value="" selected=""><?php echo $labelOptionSelectFornitore ?></option>
                                    <?php
                                    while ($rowForn = mysql_fetch_array($sqlForn)) {
                                        ?>
                                        <option value="<?php echo $rowForn['id_figura'] ?>"><?php echo ($rowForn['nominativo']); ?></option>
                                    <?php } ?>
                                </select> <input type="button" value="+" onClick="javascript:NuovaAnagrafica();" title="<?php echo $titleNuovoOperatore ?>"/></td>
                        </tr>
                        <tr>
                            <td class="cella1" colspan="3"><?php echo $filtroInformazioniSulMarchioCe ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroCodiceCE ?></td>
                            <td class="cella2" colspan="2"><input type="text" name="CodiceCE" id="CodiceCE" /></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroMarchioCE ?></td>
                            <td class="cella2"><input type="radio" id="MarchioCe" name="MarchioCe" value="<?php echo $valStrConforme ?>"/><?php echo $filtroConforme ?></td>
                            <td class="cella2"><input type="radio" id="MarchioCe" name="MarchioCe" value="<?php echo $valStrNonConforme ?>"/><?php echo $filtroNonConforme ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroValutazioneMerce ?></td>
                            <td class="cella2"><input type="radio" id="Merce" name="Merce" value="<?php echo $valStrConforme ?>" /><?php echo $filtroConforme ?></td>
                            <td class="cella2"><input type="radio" id="Merce" name="Merce" value="<?php echo $valStrNonConforme ?>"/><?php echo $filtroNonConforme ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroVerificaStabilita ?></td>
                            <td class="cella2"><input type="radio" id="Stabilita" name="Stabilita" value="<?php echo $valStrConforme ?>"/><?php echo $filtroConforme ?></td>
                            <td class="cella2"><input type="radio" id="Stabilita" name="Stabilita" value="<?php echo $valStrNonConforme ?>"/><?php echo $filtroNonConforme ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroRespProduzione ?></td>
                            <td class="cella2" colspan="2"> 
                                <select name="RespProduzione" id="RespProduzione">
                                    <option value="" selected=""><?php echo $labelOptionSelectRespProd ?></option>
                                    <?php
                                    mysql_data_seek($sqlFigure, 0);
                                    while ($rowRespProd = mysql_fetch_array($sqlFigure)) {
                                        ?>
                                        <option value="<?php echo $rowRespProd['nominativo'] ?>"><?php echo ($rowRespProd['nominativo']); ?></option>
                                    <?php } ?>
                                </select> <input type="button" value="+" onClick="javascript:NuovaAnagrafica();" title="<?php echo $titleNuovoOperatore ?>"/></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroRespQualita ?></td>
                            <td class="cella2" colspan="2"> 
                                <select name="RespQualita" id="RespQualita">
                                    <option value="" selected=""><?php echo $labelOptionSelectRespQualita ?></option>
                                    <?php
                                    mysql_data_seek($sqlFigure, 0);
                                    while ($rowRespQu = mysql_fetch_array($sqlFigure)) {
                                        ?>
                                        <option value="<?php echo $rowRespQu['nominativo'] ?>"><?php echo ($rowRespQu['nominativo']); ?></option>
                                    <?php } ?>
                                </select> <input type="button" value="+" onClick="javascript:NuovaAnagrafica();" title="<?php echo $titleNuovoOperatore ?>"/></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroConsTecnico ?></td>
                            <td class="cella2" colspan="2"> 
                                <select name="ConsTecnico" id="ConsTecnico">
                                    <option value="" selected=""><?php echo $labelOptionSelectConsTecnico ?></option>
                                    <?php
                                    mysql_data_seek($sqlFigure, 0);
                                    while ($rowCons = mysql_fetch_array($sqlFigure)) {
                                        ?>
                                        <option value="<?php echo $rowCons['nominativo'] ?>"><?php echo ($rowCons['nominativo']); ?></option>
                                    <?php } ?>
                                </select> <input type="button" value="+" onClick="javascript:NuovaAnagrafica();" title="<?php echo $titleNuovoOperatore ?>"/></td>
                        </tr>
                        <tr>
                            <td class="cella1" colspan="3"><?php echo $filtroAllegati ?></td>
                        </tr>
                        <tr><td class="cella2" colspan="3"><input type="file" name="user_file1" /></td></tr>
                        <tr><td class="cella2" colspan="3"><input type="file" name="user_file2" /></td></tr>
                        <tr><td class="cella2" colspan="3"><input type="file" name="user_file3" /></td></tr>
                        <tr><td class="cella2" colspan="3"><input type="file" name="user_file4" /></td></tr>

                        <tr>
                            <td class="cella1" colspan="3"><?php echo $filtroNote ?></td>
                        </tr>
                        <tr>                            
                            <td class="cella2" colspan="3"><textarea name="Note" id="Note" ROWS="2" COLS="100%"></textarea></td>
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
