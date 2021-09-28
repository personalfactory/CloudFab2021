<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script_persona.php');
            include('../sql/script.php');
            include('../sql/script_materia_prima.php');
            include('../include/gestione_date.php');
            ini_set('display_errors', "1");
            
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
                $msgErrControlloDtDoc, //10
                $msgErrControlloDtArr, //11
                $valCarico, //12
                $valCaricoPerAcq //13
            );
            
            //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
    $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'materia_prima'); 
            
            begin();
            $sqlArtico = findAllMatPrime("descri_mat",$strUtentiAziende);               
            $sqlPersona = selectPersoneDiverseDa($valFornitore, "nominativo");
            $sqlForn = selectPersoneByTipo($valFornitore, "nominativo");
            commit();
            ?>
            <script language="javascript" type="text/javascript">
                //Trasformo l'array da php a js
                var arrayMsgErrJs = new Array("<?= join('", "', $arrayMsgErrPhp) ?>");

                function controllaCampi(arrayMsgErrJs) {

                    var rv = true;
                    var msg = "";
                    var tipoCaricoPerAcq = arrayMsgErrJs[12] + ';' + arrayMsgErrJs[13];

                    if (document.getElementById('Articolo').value === "") {
                        rv = false;
                        msg = msg + ' ' + arrayMsgErrJs[0];
                    }
                    if (document.getElementById('Quantita').value === "" || isNaN(document.getElementById('Quantita').value)) {
                        rv = false;
                        msg = msg + ' ' + arrayMsgErrJs[6];
                    }
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

                        if (!(document.getElementById('GiornoDoc').value.length === 2)
                                || !(document.getElementById('AnnoDoc').value.length === 4)
                                || document.getElementById('GiornoDoc').value < 1
                                || document.getElementById('GiornoDoc').value > 31) {
                            rv = false;
                            msg = msg + ' ' + arrayMsgErrJs[10];
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

                        if (!(document.getElementById('GiornoArr').value.length === 2)
                                || !(document.getElementById('AnnoArr').value.length === 4)
                                || document.getElementById('GiornoArr').value < 1
                                || document.getElementById('GiornoArr').value > 31) {

                            rv = false;
                            msg = msg + ' ' + arrayMsgErrJs[11];
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

//                function Salva() {
//                    document.forms["NuovoMovimento"].action = "carica_gaz_movmag2.php";
//                }
    
               function NuovoFornitore() {
                    location.href = "carica_persona.php?HrefBack=carica_gaz_movmag.php";
                }
            </script>

            <div id="container" style="width:70%; margin:15px auto;">
                <form id="NuovoMovimento" name="NuovoMovimento" method="post" action = "carica_gaz_movmag2.php" onsubmit="return controllaCampi(arrayMsgErrJs)"  enctype="multipart/form-data">
                    <table width="100%">
                        <tr>
                            <td class="cella3" colspan="3"><?php echo $titoloPaginaNuovoMovMag ?></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroOperazione ?> </td>
                            <td class="cella1" colspan="2">
                                <select  name="TipoMov" id="TipoMov" >
                                    <option value="<?php echo $valCarico . ";" . $valCaricoPerAcq ?>" selected="<?php echo $valCarico . ";" . $valCaricoPerAcq ?>"><?php echo $filtroCaricoPerAcq ?></option>
                                    <option value="<?php echo $valCarico . ";" . $valCaricoPerInv ?>"><?php echo $filtroCaricoPerInv ?></option>
                                    <option value="<?php echo $valScarico . ";" . $valScaricoPerInv ?>"><?php echo $filtroScaricoPerInv ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroArticolo ?></td>
                            <td class="cella1" colspan="2">
                                <select  name="Articolo" id="Articolo"  >
                                    <option value="" selected=""><?php echo $labelOptionSelectArticolo ?></option>
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
                            <td class="cella1" colspan="2"> 
                                <select  name="Fornitore" id="Fornitore"  >
                                    <option value="" selected=""><?php echo $labelOptionSelectFornitore ?></option>
                                    <?php
                                    while ($rowForn = mysql_fetch_array($sqlForn)) {
                                        ?>
                                        <option value="<?php echo $rowForn["nominativo"] ?>" size="40"><?php echo $rowForn["nominativo"] ?></option>
                                    <?php } ?>
                                </select>
                            <input type="button" value="<?php echo $valueButtonNew?>" onClick="javascript:NuovoFornitore();" title="<?php echo $titleNuovoFornitore ?>"/></td>
                             
                        </tr>
                        <tr>
                            <td class="cella2" ><?php echo $filtroCodiceFornitore ?></td>
                            <td class="cella1" colspan="2"><input type="text" name="CodiceArticoloFornitore" id="CodiceArticoloFornitore" /></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroQuantita ?></td>
                            <td class="cella1" colspan="2"><input type="text" name="Quantita" id="Quantita" /><?php echo $valUniMisKg ?></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroNumDoc ?> </td>
                            <td class="cella1" colspan="2"><input type="text" name="NumDoc" id="NumDoc" /></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroDataDoc ?> </td>
                            <td class="cella1" colspan="2"><?php formSceltaData("GiornoDoc", "MeseDoc", "AnnoDoc", $arrayFiltroMese) ?>                                  
                            </td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroValutazioneMerce ?></td>
                            <td class="cella1"><input type="checkbox" id="Merce[Conforme]" name="Merce[Conforme]" value="<?php echo $valConforme ?>" /><?php echo $filtroConforme ?></td>
                            <td class="cella1"><input type="checkbox" id="Merce[NonConforme]" name="Merce[NonConforme]" value="<?php echo $valNonConforme ?>"/><?php echo $filtroNonConforme ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroVerificaStabilita ?></td>
                            <td class="cella1"><input type="checkbox" id="Stabilita[Conforme]" name="Stabilita[Conforme]" value="<?php echo $valStabile ?>"/><?php echo $filtroConforme ?></td>
                            <td class="cella1"><input type="checkbox" id="Stabilita[NonConforme]" name="Stabilita[NonConforme]" value="<?php echo $valNonStabile ?>"/><?php echo $filtroNonConforme ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroProceduraAdottata ?></td>
                            <td class="cella1"><input type="checkbox" id="Procedura[Reso]" name="Procedura[Reso]" value="<?php echo $valReso ?>"/><?php echo $filtroReso ?></td>
                            <td class="cella1"><input type="checkbox" id="Procedura[ScaricatoSilos]" name="Procedura[ScaricatoSilos]" value="<?php echo $valScaricatoSilos ?>"/> <?php echo $filtroScaricatoSilos ?></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroDataArrivo ?> </td>
                            <td class="cella1" colspan="2"><?php formSceltaData("GiornoArr", "MeseArr", "AnnoArr", $arrayFiltroMese) ?>                                  
                            </td>
                        </tr>
                        <tr>
                            <td class="cella2" ><?php echo $filtroOperatore ?></td>
                            <td class="cella1" colspan="2">
                                <select  name="Operatore" id="Operatore"  >
                                    <option value="" selected=""><?php echo $labelOptionSelectOper ?></option>
                                    <?php
                                    while ($rowOper = mysql_fetch_array($sqlPersona)) {
                                        ?>
                                        <option value="<?php echo $rowOper["nominativo"] ?>" size="40"><?php echo $rowOper["nominativo"] ?></option>
                                    <?php } ?>
                                </select></td>
                        </tr>

                        <tr>
                            <td class="cella2"><?php echo $filtroRespProduzione ?></td>
                            <td class="cella1" colspan="2">
                                <select  name="RespProduzione" id="RespProduzione"  >
                                    <option value="" selected=""><?php echo $labelOptionSelectRespProd ?></option>
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
                            <td class="cella1" colspan="2">
                                <select  name="RespQualita" id="RespQualita"  >
                                    <option value="" selected=""><?php echo $labelOptionSelectRespQualita ?></option>
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
                            <td class="cella1" colspan="2">
                                <select  name="ConsTecnico" id="ConsTecnico"  >
                                    <option value="" selected=""><?php echo $labelOptionSelectConsTecnico ?></option>
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
                            <td class="cella1" colspan="2"><textarea name="Note" id="Note" ROWS="2" COLS="70"></textarea></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroCaricaDocumento ?></td>
                            <td class="cella1" colspan="2"><input type="file" name="user_file" value=""/>
                            </td>
                        </tr>
                        <tr>
                            <td class="cella2" style="text-align: right " colspan="3">
                                <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                <input type ="submit" value="<?php echo $valueButtonSalva ?>" /></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div><!--mainContainer-->
    </body>
</html>



