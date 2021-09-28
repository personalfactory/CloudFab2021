<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>    
    <!--Bisogna verificare il permesso di vedere la formula - prodotto e il permesso di vedere il dettaglio della miscela-->
   <?php
    //############# VERIFICA PERMESSO VISUALIZZAZIONE LISTA ####################
    $actionOnLoad = "";
    $elencoFunzioni = array("3","93","127");
    //3 vedere dettaglio prodotto-formula
    //93 vedere dettaglio ddt
    //127 vedere dettaglio miscela
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);
    ?>
      
<body onLoad="<?php echo $actionOnLoad ?>">
    
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../include/precisione.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_gaz_movmag.php');
            include('../sql/script_persona.php');            
            include('../sql/script_miscela_componente.php');
            include('../sql/script_prodotto.php');
            include('../sql/script_miscela.php');

            
            //Costruzione dell'array contenente i vari msg di errore
            $arrayMsgErrPhp = array($msgErrArtico, //0
                $msgErrDataArr, //1
                $msgErrValutaMerce, //2
                $msgErrVerificaStab, //3
                $msgErrFornitore, //4
                $msgErrCodArtFornitore, //5
                $msgErrQtaNumerica, //6
                $msgErrDataDoc, //7
                $msgErrNumDoc, //8
                $msgErrProcAdottata, //9
                $msgErrPrezzo, //10
                $valCarico, //11
                $valCaricoPerAcq //12
            );
            ?>
            <script language="javascript" type="text/javascript">

                //Trasformo l'array da php a js
                var arrayMsgErrJs = new Array("<?= join('", "', $arrayMsgErrPhp) ?>");

                function controllaCampi(arrayMsgErrJs) {

                    var rv = true;
                    var msg = "";
                    var tipoCaricoPerAcq = arrayMsgErrJs[11] + ';' + arrayMsgErrJs[12];

                    if (document.getElementById('Articolo').value === "") {
                        rv = false;
                        msg = msg + ' ' + arrayMsgErrJs[0];
                    }

                    if (document.getElementById('Quantita').value === "" || isNaN(document.getElementById('Quantita').value)) {
                        rv = false;
                        msg = msg + ' ' + arrayMsgErrJs[6];
                    }
//                    if (document.getElementById('Prezzo').value !== "" && isNaN(document.getElementById('Prezzo').value)) {
//                        rv = false;
//                        msg = msg + ' ' + arrayMsgErrJs[10];
//                    }
                    //## SI ESEGUONO I SEGUENTI CONTROLLI SOLO PER IL CARICO PER ACQUISTO #######
                    if (document.getElementById('TipoMov').value === tipoCaricoPerAcq) {

                        if (document.getElementById('NumDoc').value === "") {
                            rv = false;
                            msg = msg + ' ' + arrayMsgErrJs[8];
                        }
                        if (document.getElementById('GiornoDoc').value === ""
                                || document.getElementById('MeseDoc').value === ""
                                || document.getElementById('AnnoDoc').value === ""
                                || isNaN(document.getElementById('GiornoDoc').value)
                                || isNaN(document.getElementById('MeseDoc').value)
                                || isNaN(document.getElementById('AnnoDoc').value)) {
                            rv = false;
                            msg = msg + ' ' + arrayMsgErrJs[7];
                        }
                        if (document.getElementById('GiornoArr').value === ""
                                || document.getElementById('MeseArr').value === ""
                                || document.getElementById('AnnoArr').value === ""
                                || isNaN(document.getElementById('GiornoArr').value)
                                || isNaN(document.getElementById('MeseArr').value)
                                || isNaN(document.getElementById('AnnoArr').value)) {
                            rv = false;
                            msg = msg + ' ' + arrayMsgErrJs[1];
                        }
                    }
                    if (!document.getElementById('Merce[Conforme]').checked &&
                            !document.getElementById('Merce[NonConforme]').checked) {
                        rv = false;
                        msg = msg + arrayMsgErrJs[2];
                    }
                    if (!document.getElementById('Stabilita[Conforme]').checked &&
                            !document.getElementById('Stabilita[NonConforme]').checked) {
                        rv = false;
                        msg = msg + arrayMsgErrJs[3];
                    }
                    if (!document.getElementById('Procedura[Reso]').checked &&
                            !document.getElementById('Procedura[ScaricatoSilos]').checked) {
                        rv = false;
                        msg = msg + arrayMsgErrJs[9];
                    }
                    //####### ENTRAMBE LE CASELLE SPUNTATE ###############################

                    if (document.getElementById('Merce[Conforme]').checked &&
                            document.getElementById('Merce[NonConforme]').checked) {
                        rv = false;
                        msg = msg + arrayMsgErrJs[2];
                    }
                    if (document.getElementById('Stabilita[Conforme]').checked &&
                            document.getElementById('Stabilita[NonConforme]').checked) {
                        rv = false;
                        msg = msg + arrayMsgErrJs[3];
                    }
                    if (document.getElementById('Procedura[Reso]').checked &&
                            document.getElementById('Procedura[ScaricatoSilos]').checked) {
                        rv = false;
                        msg = msg + arrayMsgErrJs[9];
                    }

                    if (!rv) {
                        alert(msg);
                        rv = false;
                    }
                    return rv;

                }

                function Salva() {
                    document.forms["ModificaMovimento"].action = "modifica_gaz_movmag2.php";
                }

            </script>


            <?php
            $IdMov = $_GET['IdMov'];


//1 .Visualizzo il record che intendo modificare all'interno della form
            $sql = findMovimentoById($IdMov);

            while ($row = mysql_fetch_array($sql)) {
                $Operazione = $row['operazione'];
                $Causale = $row['causale'];
                $Articolo = $row['artico'];
                $DescriArticolo = $row['descri_artico'];
                $Fornitore = $row['fornitore'];
                $CodiceArticoloFornitore = $row['cod_artico_fornitore'];
                $Quantita = $row['quanti'];
                $NumDoc = $row['num_doc'];

                $DtDoc = $row['dt_doc'];
                $valAnno = substr($DtDoc, 0, 4);
                $valGiorno = substr($DtDoc, 8, 9);
                $numMese = substr($DtDoc, 5, -3);
                $valMese = trasformaMeseInLettere($numMese, $arrayFiltroMese);

                $DtAr = $row['dt_arrivo_merce'];
                $valAnnoAr = substr($DtAr, 0, 4);
                $valGiornoAr = substr($DtAr, 8, 9);
                $numMeseAr = substr($DtAr, 5, -3);
                $valMeseAr = trasformaMeseInLettere($numMeseAr, $arrayFiltroMese);

                $Operatore = $row['operatore'];
                $RespProduzione = $row['resp_produzione'];
                $RespQualita = $row['resp_qualita'];
                $ConsTecnico = $row['consulente_tecnico'];

                $ValutazioneMerce = $row['valutazione_merce'];
                $VerificaStabilita = $row['verifica_stabilita'];
                $ProceduraAdottata = $row['procedura_adottata'];
                $Note = $row['note'];
                $DocLink = $row['doc_link'];
                $DocLinkCompleto = "";
                if ($DocLink != "")
                    $DocLinkCompleto = $DocLink . $estFileDdt;

                $Prezzo = $row['prezzo'];
                $UniMisura = $row['uni_mis'];
                $Data = $row['dt_abilitato'];
            }


//TODO: FURNISHER va portato fuori           
            $sqlPersona = selectPersoneDiverseDa($valFornitore, "nominativo");
            $sqlForn = selectPersoneByTipo($valFornitore, "nominativo");

            $arrayMiscele=array();
            $i=0;
            //Cerco nella tabella miscela_componente tutte le miscele in cui è finita la materia prima
            $sqlMiscele = findMisceleByIdMov($IdMov);
             while ($rowMis = mysql_fetch_array($sqlMiscele)) {
             $arrayMiscele[$i]=$rowMis['id_miscela'];
                 $i++;
             }
            
             $sqlClienti='';
           if(count($arrayMiscele)>0)
              
            $sqlClienti=trovaClientiMiscela($arrayMiscele);
            ?>

            <div id="container" style="width:70%; margin:15px auto;">
                <form id="ModificaMovimento" name="ModificaMovimento" method="post" onsubmit="return controllaCampi(arrayMsgErrJs)" enctype="multipart/form-data">
                    <table width="100%">
                        <tr>
                            <td class="cella3" colspan="5"><?php echo $titoloPaginaModMovMag ?></td>
                        </tr>
                        <input type="hidden" name="IdMov" id="IdMov" value="<?php echo $IdMov ?>"/>
                        <tr>
                            <td class="cella4"><?php echo $filtroOperazione ?> </td>
                            <td class="cella1" colspan="4">
                                <select  name="TipoMov" id="TipoMov" >
                                    <option value="<?php echo $Operazione . ";" . $Causale ?>" selected="<?php echo $Operazione . ";" . $Causale ?>"><?php echo $Causale ?></option>
                                    <option value="<?php echo $valCarico . ";" . $valCaricoPerAcq ?>"><?php echo $filtroCaricoPerAcq ?></option>
                                    <option value="<?php echo $valCarico . ";" . $valCaricoPerInv ?>"><?php echo $filtroCaricoPerInv ?></option>
                                    <option value="<?php echo $valScarico . ";" . $valScaricoPerLav ?>"><?php echo $filtroScaricoPerLav ?></option>
                                    <option value="<?php echo $valScarico . ";" . $valScaricoPerInv ?>"><?php echo $filtroScaricoPerInv ?></option>
                                    <option value="<?php echo $valScarico . ";" . $valScaricoPerVen ?>"><?php echo $filtroScaricoPerVen ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroArticolo ?></td>
                            <td class="cella1" colspan="4">
                                <select  name="Articolo" id="Articolo">
                                    <option value="<?php echo $Articolo . ";" . $DescriArticolo ?>" selected="<?php echo $Articolo . ";" . $DescriArticolo ?>"><?php echo $DescriArticolo . " - " . $Articolo ?></option>
                                    <?php
                                    while ($rowArtico = mysql_fetch_array($sqlArtico)) {
                                        ?>
                                        <option value="<?php echo($rowArtico["cod_mat"]) . ";" . $rowArtico["descri_mat"] ?>" size="40"><?php echo $rowArtico["descri_mat"] . " - " . $rowArtico["cod_mat"] ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroFornitore ?></td>
                            <td class="cella1" colspan="4"> 
                                <select  name="Fornitore" id="Fornitore"  >
                                    <option value="<?php echo $Fornitore ?>" selected="<?php echo $Fornitore ?>"><?php echo $Fornitore ?></option>
                                    <?php
                                    while ($rowForn = mysql_fetch_array($sqlForn)) {
                                        ?>
                                        <option value="<?php echo $rowForn["nominativo"] ?>" size="40"><?php echo $rowForn["nominativo"] ?></option>
                                    <?php } ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td class="cella2" ><?php echo $filtroCodiceFornitore ?></td>
                            <td class="cella1" colspan="4"><input type="text" name="CodiceArticoloFornitore" id="CodiceArticoloFornitore" value="<?php echo $CodiceArticoloFornitore ?>"/></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroQuantita ?></td>
                            <td class="cella1" colspan="4"><input type="text" name="Quantita" id="Quantita" value="<?php echo $Quantita ?>"/><?php echo $valUniMisKg ?></td>
                            <tr>
                                <td class="cella4"><?php echo $filtroPrezzo ?></td>
                                <td class="cella1" colspan="4"><?php echo $Prezzo . " " . $filtroEuroKg ?></td>
                                <input type="hidden" name="Prezzo" id="Prezzo" value="<?php echo $Prezzo ?>"/>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroNumDoc ?> </td>
                                <td class="cella1" colspan="4"><input type="text" name="NumDoc" id="NumDoc" value="<?php echo $NumDoc ?>"/></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroDataDoc ?> </td>
                                <td class="cella1" colspan="4"><?php formModificaSceltaData("GiornoDoc", "MeseDoc", "AnnoDoc", $arrayFiltroMese, $valGiorno, $numMese, $valMese, $valAnno) ?>                                  
                                </td>
                            </tr>
                            <tr>
                                <td class="cella2" ><?php echo $filtroValutazioneMerce ?></td>
                                <?php if ($ValutazioneMerce == $valConforme) { ?>                               
                                    <td class="cella1"><input type="checkbox" id="Merce[Conforme]" name="Merce[Conforme]" value="<?php echo $valConforme ?>" checked="checked"/><?php echo $filtroConforme ?></td>
                                    <td class="cella1" colspan="3"><input type="checkbox" id="Merce[NonConforme]" name="Merce[NonConforme]" value="<?php echo $valNonConforme ?>"/><?php echo $filtroNonConforme ?></td>

                                <?php } else if ($ValutazioneMerce == $valNonConforme) { ?>
                                    <td class="cella1"><input type="checkbox" id="Merce[Conforme]" name="Merce[Conforme]" value="<?php echo $valConforme ?>" /><?php echo $filtroConforme ?></td>
                                    <td class="cella1" colspan="3"><input type="checkbox" id="Merce[NonConforme]" name="Merce[NonConforme]" value="<?php echo $valNonConforme ?>" checked="checked"/><?php echo $filtroNonConforme ?></td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroVerificaStabilita ?></td>
                                <?php if ($VerificaStabilita == $valStabile) { ?> 
                                    <td class="cella1"><input type="checkbox" id="Stabilita[Conforme]" name="Stabilita[Conforme]" value="<?php echo $valStabile ?>" checked="checked"/><?php echo $filtroConforme ?></td>
                                    <td class="cella1"colspan="3"><input type="checkbox" id="Stabilita[NonConforme]" name="Stabilita[NonConforme]" value="<?php echo $valNonStabile ?>"/><?php echo $filtroNonConforme ?></td>
                                <?php } else if ($VerificaStabilita == $valNonStabile) { ?>
                                    <td class="cella1"><input type="checkbox" id="Stabilita[Conforme]" name="Stabilita[Conforme]" value="<?php echo $valStabile ?>"/><?php echo $filtroConforme ?></td>
                                    <td class="cella1" colspan="3"><input type="checkbox" id="Stabilita[NonConforme]" name="Stabilita[NonConforme]" value="<?php echo $valNonStabile ?>" checked="checked"/><?php echo $filtroNonConforme ?></td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroProceduraAdottata ?></td>
                                <?php if ($ProceduraAdottata == $valReso) { ?> 
                                    <td class="cella1"><input type="checkbox" id="Procedura[Reso]" name="Procedura[Reso]" value="<?php echo $valReso ?>" checked="checked"/><?php echo $filtroReso ?></td>
                                    <td class="cella1" colspan="3"><input type="checkbox" id="Procedura[ScaricatoSilos]" name="Procedura[ScaricatoSilos]" value="ScaricatoSilos"/> <?php echo $filtroScaricatoSilos ?></td>
                                <?php } else if ($ProceduraAdottata == $valScaricatoSilos) { ?>
                                    <td class="cella1"><input type="checkbox" id="Procedura[Reso]" name="Procedura[Reso]" value="<?php echo $valReso ?>" /><?php echo $filtroReso ?></td>
                                    <td class="cella1" colspan="3"><input type="checkbox" id="Procedura[ScaricatoSilos]" name="Procedura[ScaricatoSilos]" value="<?php echo $valScaricatoSilos ?>" checked="checked"/> <?php echo $filtroScaricatoSilos ?></td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroDataArrivo ?></td>
                                <td class="cella1" colspan="4"><?php formModificaSceltaData("GiornoArr", "MeseArr", "AnnoArr", $arrayFiltroMese, $valGiornoAr, $numMeseAr, $valMeseAr, $valAnnoAr) ?></td>
                            </tr>
                            <tr>
                                <td class="cella2" ><?php echo $filtroOperatore ?></td>
                                <td class="cella1" colspan="4">
                                    <select  name="Operatore" id="Operatore"  >
                                        <option value="<?php echo $Operatore ?>" selected="<?php echo $Operatore ?>"><?php echo $Operatore ?></option>
                                        <?php
                                        while ($rowOper = mysql_fetch_array($sqlPersona)) {
                                            ?>
                                            <option value="<?php echo $rowOper["nominativo"] ?>" size="40"><?php echo $rowOper["nominativo"] ?></option>
                                        <?php } ?>
                                    </select></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroRespProduzione ?></td>
                                <td class="cella1" colspan="4">
                                    <select  name="RespProduzione" id="RespProduzione"  >
                                        <option value="<?php echo $RespProduzione ?>" selected="<?php echo $RespProduzione ?>"><?php echo $RespProduzione ?></option>
                                        <?php
                                        mysql_data_seek($sqlPersona, 0);
                                        while ($rowRespProd = mysql_fetch_array($sqlPersona)) {
                                            ?>
                                            <option value="<?php echo $rowRespProd["nominativo"] ?>" size="40"><?php echo $rowRespProd["nominativo"] ?></option>
                                        <?php } ?>
                                    </select></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroRespQualita ?></td>
                                <td class="cella1" colspan="4">
                                    <select  name="RespQualita" id="RespQualita"  >
                                        <option value="<?php echo $RespQualita ?>" selected="<?php echo $RespQualita ?>"><?php echo $RespQualita ?></option>
                                        <?php
                                        mysql_data_seek($sqlPersona, 0);
                                        while ($rowRespQu = mysql_fetch_array($sqlPersona)) {
                                            ?>
                                            <option value="<?php echo $rowRespQu["nominativo"] ?>" size="40"><?php echo $rowRespQu["nominativo"] ?></option>
                                        <?php } ?>
                                    </select></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroConsTecnico ?></td>
                                <td class="cella1" colspan="4">
                                    <select  name="ConsTecnico" id="ConsTecnico">
                                        <option value="<?php echo $ConsTecnico ?>" selected="<?php echo $ConsTecnico ?>"><?php echo $ConsTecnico ?></option>
                                        <?php
                                        mysql_data_seek($sqlPersona, 0);
                                        while ($rowCons = mysql_fetch_array($sqlPersona)) {
                                            ?>
                                            <option value="<?php echo $rowCons["nominativo"] ?>" size="40"><?php echo $rowCons["nominativo"] ?></option>
                                        <?php } ?>
                                    </select></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroNote ?></td>
                                <td class="cella1" colspan="4"><textarea name="Note" id="Note" ROWS="2" COLS="70" value="<?php echo $Note ?>"><?php echo $Note ?></textarea></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroDocLink ?> </td>
                                <td class="cella1" colspan="4"><a  target="_blank" href="<?php echo $sourceDdtDownloadDir . $DocLink . $estFileDdt ?>"><?php echo $DocLinkCompleto ?></a></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroCaricaDocumento ?></td>
                                <td class="cella1" colspan="4"><input type="file" name="user_file" value=""/>
                                </td>
                            </tr>
                            
                            <?php
                            if(mysql_num_rows($sqlMiscele)>0){
                                ?>
                               <tr>
                                <td class="cella3" colspan="5"><?php echo $filtroProdCompound ?></td>
                            </tr>  
                                <tr>
                                <td class="cella2"><?php echo $filtroCodMov ?></td>
                                <td class="cella2"><?php echo $filtroIdMiscela ?></td>
                                <td class="cella2" colspan='2'><?php echo $filtroProdotto ?></td>
                                <td class="cella2" ><?php echo $filtroDtProd ?></td>

                            </tr>
                                <?php
                                    mysql_data_seek($sqlMiscele, 0);
                            while ($rowMis = mysql_fetch_array($sqlMiscele)) {
                                
                                $idProdotto = 0;
                                if ($rowMis['cod_formula'] != '') {
                                    $sqlProd = findProdottoByCodice(substr($rowMis['cod_formula'], 1));
                                    while ($rowP = mysql_fetch_array($sqlProd)) {
                                        $idProdotto = $rowP['id_prodotto'];
                                    }
                                }
                                ?>

                                <tr>
                                    <td class="cella1"><?php echo $rowMis['cod_mov'] ?></td>
                                    <td class="cella1"><a name="127" href="dettaglio_miscela.php?Miscela=<?php echo($rowMis['id_miscela']) ?>"><?php echo $rowMis['id_miscela'] ?></a></td>
                                    
                                    <td class="cella1"><a name="3" href="../prodotti/vista_prodotto_formula.php?Prodotto=<?php echo $idProdotto ?>"><?php echo $rowMis['cod_formula'] ?></a></td>
                                    <td class="cella1"><?php echo $rowMis['descri_formula'] ?></td>
                                    <td class="cella1"><?php echo $rowMis['dt_miscela'] ?></td>
                                </tr>

                            <?php }
                            }
                            ?>
                    </table>
                            
                            <?php
                            if($sqlClienti!=''){
                                ?>
                                <table width="100%">
                                    <tr>
                                <td class="cella3" colspan="5"><?php echo $filtroClientiCompound ?></td>
                            </tr> 
                                <tr>
                                <td class="cella2"><?php echo $filtroIdMacchina ?></td>
                                <td class="cella2"><?php echo $filtroCliente ?></td> 
                                <td class="cella2"><?php echo $filtroNumDdt ?></td>
                                <td class="cella2"><?php echo $filtroDtDdt ?></td>
                            </tr>
                                <?php
                            while ($rowCli = mysql_fetch_array($sqlClienti)) {
                                ?>
                                <tr>
                                    <td class="cella1"><?php echo $rowCli['id_macchina'] ?></td>
                                    <td class="cella1"><?php echo $rowCli['descri_stab'] ?></a></td>
                                    <td class="cella1"><a name="93" href="dettaglio_bolla.php?NumBolla=<?php echo($rowCli['num_bolla']) ?>&DtBolla=<?php echo $rowCli['dt_bolla'] ?>"><?php echo $rowCli['num_bolla'] ?></a></td>                        
                                    <td class="cella1"><?php echo $rowCli['dt_bolla'] ?></td>
                                </tr>
                            <?php }
                            }
                            ?>
                            </table>
                            <table width="100%">
                            <tr>
                                <td class="cella2" style="text-align: right " >
                                    <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                    <input type="submit" value="<?php echo $valueButtonSalva ?>" onClick="Salva()"/></td>
                            </tr>
                    </table>
                </form>

            </div>
        </div>
    </body>
</html>
