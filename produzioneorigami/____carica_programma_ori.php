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
            include('../Connessioni/serverdb.php');
            include('../include/gestione_date.php');
            include('../sql/script.php');
            include('../sql/script_lotto_artico.php');
            include('../sql/script_macchina.php');
            
            if($DEBUG) ini_set("display_errors", "1");
            
            $actionOnLoad = "";
            //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
    $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'prodotto');
            
            //Costruzione dell'array contenente i vari msg di errore
            $arrayMsgErrPhp = array($msgErrNumDoc, //0
                $msgErrDataDoc, //1
                $msgErrControlloDtDoc, //2
                $msgErrDataOrdine, //3
                $msgErrControlloDtOrdine, //4
                $msgErrSelectStab, //5
                $msgErrNumArticoli, //6                
                $msgErrQtaArticoli //7 
            );

            begin();
            //TODO: scrivere query
            $sqlArtico = findAllLottoArtico("codice");
            commit();
            ?>
            <script language="javascript" type="text/javascript">

                //Trasformo l'array da php a js
                var arrayMsgErrJs = new Array("<?= join('", "', $arrayMsgErrPhp) ?>");

                function controllaCampi(arrayMsgErrJs) {

                    var rv = true;
                    var errorArtico = false;
                    var msg = "";

                    if (document.getElementById('NumDoc').value === "") {
                        rv = false;
                        msg = msg + ' ' + arrayMsgErrJs[0];
                    }
                    if (document.getElementById('GiornoDoc').value === ""
                            || document.getElementById('MeseDoc').value === ""
                            || document.getElementById('AnnoDoc').value === ""
                            || isNaN(document.getElementById('GiornoDoc').value)
                            || isNaN(document.getElementById('MeseDoc').value)
                            || isNaN(document.getElementById('AnnoDoc').value)) {
                        rv = false;
                        msg = msg + ' ' + arrayMsgErrJs[1];
                    }

                    if (!(document.getElementById('GiornoDoc').value.length === 2)
                            || !(document.getElementById('AnnoDoc').value.length === 4)
                            || document.getElementById('GiornoDoc').value < 1
                            || document.getElementById('GiornoDoc').value > 31) {
                        rv = false;
                        msg = msg + ' ' + arrayMsgErrJs[2];
                    }

                    if (document.getElementById('NumOrdine').value !== "") {
                        if (document.getElementById('GiornoOrdine').value === ""
                                || document.getElementById('MeseOrdine').value === ""
                                || document.getElementById('AnnoOrdine').value === ""
                                || isNaN(document.getElementById('GiornoOrdine').value)
                                || isNaN(document.getElementById('MeseOrdine').value)
                                || isNaN(document.getElementById('AnnoOrdine').value)) {
                            rv = false;
                            msg = msg + ' ' + arrayMsgErrJs[3];
                        }

                        if (!(document.getElementById('GiornoOrdine').value.length === 2)
                                || !(document.getElementById('AnnoOrdine').value.length === 4)
                                || document.getElementById('GiornoOrdine').value < 1
                                || document.getElementById('GiornoOrdine').value > 31) {
                            rv = false;
                            msg = msg + ' ' + arrayMsgErrJs[4];
                        }
                    }

                    if (document.getElementById('Stabilimento').value === "") {

                        rv = false;
                        msg = msg + ' ' + arrayMsgErrJs[5];
                    }
                    if (document.getElementById('NumArticoli').value === "") {

                        rv = false;
                        msg = msg + ' ' + arrayMsgErrJs[6];
                    }
                    if (document.getElementById('NumArticoli').value > 0) {
                        for (i = 1; i <= document.getElementById('NumArticoli').value; i++) {

                            if (document.getElementById('Articolo' + i).value !== ""
                                    && isNaN(document.getElementById('QtaArticolo' + i).value)) {

                                errorArtico = true;

                            }
                            if (document.getElementById('Articolo' + i).value === ""
                                    || isNaN(document.getElementById('QtaArticolo' + i).value)) {

                                errorArtico = true;

                            }

                        }
                        if (errorArtico) {
                            rv = false;
                            msg = msg + ' ' + arrayMsgErrJs[7];
                        }

                    }

                    if (!rv) {
                        alert(msg);
                        rv = false;
                    }
                    return rv;

                }

                function Salva() {

                    document.forms["InserisciBolla"].action = "carica_gaz_bolla2.php";
                }
                function Aggiorna() {

                    document.forms["InserisciBolla"].action = "carica_gaz_bolla.php";

                }


            </script>
            <?php
            if (!isset($_POST['NumDoc']) && !isset($_POST['NumDoc'])) {
                ?>

                <div id="container" style="width:70%; margin:15px auto;">
                    <form id="InserisciBolla" name="InserisciBolla" method="post" onsubmit="return controllaCampi(arrayMsgErrJs)" enctype="multipart/form-data">
                        <table width="100%">
                            <tr>
                                <td class="cella3" colspan="2"><?php echo "PROGRAMMA DI PRODUZIONE" ?></td>
                            </tr>
                           
                            <tr>
                                <td class="cella4"><?php echo "DATA DI PRODUZIONE" ?> </td>
                                <td class="cella1"><?php formSceltaData("GiornoDoc", "MeseDoc", "AnnoDoc", $arrayFiltroMese) ?></td>
                            </tr>
                             <tr>
                                <td class="cella2"><?php echo $filtroNumDoc ?></td>
                                <td class="cella1"><input type="text" name="NumDoc" id="NumDoc" size="30px"/>
                                </td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroNumOrdine ?></td>
                                <td class="cella1"><input type="text" name="NumOrdine" id="NumOrdine" size="30px"/>
                                </td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroDataOrdine ?> </td>
                                <td class="cella1"><?php formSceltaData("GiornoOrdine", "MeseOrdine", "AnnoOrdine", $arrayFiltroMese) ?></td>
                            </tr>
                            <tr>
                                <td class="cella4" ><?php echo $filtroStabilimento ?></td>
                                <td class="cella1">
                                    <select name="Stabilimento" id="Stabilimento">
                                        <option value="" selected=""><?php echo $labelOptionSelectStab ?></option>
                                        <option value="<?php echo '0 - 0 - '.$filtroAltroCliente ?>"><?php echo $filtroAltroCliente ?></option>
                                        <?php
                                        $sqlStab = findAllMacchine("descri_stab");
                                        while ($row = mysql_fetch_array($sqlStab)) {
                                            ?>
                                            <option value="<?php echo $row['id_macchina'] . " - " . $row['cod_stab'] . " - " . $row['descri_stab']; ?>"><?php echo $row['id_macchina'] . " - " . $row['cod_stab'] . " - " . $row['descri_stab']; ?></option>
                                        <?php } ?>
                                    </select>

                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroDt ?></td>
                                <td class="cella1"><?php echo dataCorrenteVisualizza() ?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroNote ?></td>
                                <td class="cella1" colspan="2"><textarea name="Note" id="Note" ROWS="2" COLS="40"></textarea></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroNumTipoArticolo ?></td>
                                <td class="cella1"><input type="text" name="NumArticoli" id="NumArticoli" /></td>
                            </tr>
                            <tr>
                                <td class="cella2" style="text-align: right " colspan="2">
                                    <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                    <input type="submit" value="<?php echo $valueButtonAggiorna ?>" onClick="return controllaCampi(arrayMsgErrJs);Aggiorna()"/></td>

                            </tr>
                        </table>
                    </form>
                </div>

                <?php
            } else {

                $NumDoc = str_replace("'", "''", $_POST['NumDoc']);
//      echo "</br>GiornoDoc : ".$_POST['GiornoDoc'];
//      echo "</br>MeseDoc : ".$_POST['MeseDoc'];
//      echo "</br>AnnoDoc : ".$_POST['AnnoDoc'];
                $DtDoc = $_POST['AnnoDoc'] . "-" . $_POST['MeseDoc'] . "-" . $_POST['GiornoDoc'];
                $numMeseDoc = $_POST['MeseDoc'];
                $valMeseDoc = trasformaMeseInLettere($numMeseDoc, $arrayFiltroMese);


                $DtOrdine = $_POST['AnnoOrdine'] . "-" . $_POST['MeseOrdine'] . "-" . $_POST['GiornoOrdine'];
                $numMeseOrdine = $_POST['MeseOrdine'];
                $valMeseOrdine = trasformaMeseInLettere($numMeseOrdine, $arrayFiltroMese);
                $NumOrdine = str_replace("'", "''", $_POST['NumOrdine']);
                $DtOrdine = $_POST['AnnoOrdine'] . "-" . $_POST['MeseOrdine'] . "-" . $_POST['GiornoOrdine'];

                list($IdMacchina, $CodStab, $DescriStab) = explode(" - ", $_POST['Stabilimento']);
                $NumArticoli = str_replace("'", "''", $_POST['NumArticoli']);
                $Note = "";
                if (isset($_POST['Note']) AND trim($_POST['Note']) != "") {
                    $Note = str_replace("'", "''", $_POST['Note']);
                }
                ?>

                <div id="container" style="width:70%; margin:15px auto;">
                    <form id="InserisciBolla" name="InserisciBolla" method="post" onsubmit="return controllaCampi(arrayMsgErrJs)" enctype="multipart/form-data">
                        <table width="100%">
                            <tr>
                                <td class="cella3" colspan="2"><?php echo $titoloPaginaNuovoDdt ?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroNumDoc ?></td>
                                <td class="cella1"><input type="text" name="NumDoc" id="NumDoc" size="30px" value="<?php echo $NumDoc ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroDataDoc ?> </td>
                                <td class="cella1"><?php formModificaSceltaData("GiornoDoc", "MeseDoc", "AnnoDoc", $arrayFiltroMese, $_POST['GiornoDoc'], $_POST['MeseDoc'], $valMeseDoc, $_POST['AnnoDoc']) ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroNumOrdine ?></td>
                                <td class="cella1"><input type="text" name="NumOrdine" id="NumOrdine" size="30px" value="<?php echo $NumOrdine ?>"/>
                                </td>
                            </tr>
                            <td class="cella4"><?php echo $filtroDataOrdine ?> </td>
                            <td class="cella1">
                                <?php formModificaSceltaData("GiornoOrdine", "MeseOrdine", "AnnoOrdine", $arrayFiltroMese, $_POST['GiornoOrdine'], $_POST['MeseOrdine'], $valMeseOrdine, $_POST['AnnoOrdine']) ?>
                            </td>
                            </tr> 
                            <tr>
                                <td class="cella4" ><?php echo $filtroStabilimento ?></td>
                                <td class="cella1">
                                    <select name="Stabilimento" id="Stabilimento">
                                        <option value="<?php echo $IdMacchina . " - " . $CodStab . " - " . $DescriStab; ?>" selected="<?php echo $IdMacchina . " - " . $CodStab . " - " . $DescriStab; ?>"><?php echo $IdMacchina . " - " . $CodStab . " - " . $DescriStab; ?></option>
                                        <option value="<?php echo '0 - 0 - '.$filtroAltroCliente ?>"><?php echo $filtroAltroCliente ?></option>
                                            <?php
                                        $sqlStab = findAllMacchine("descri_stab");
                                        while ($row = mysql_fetch_array($sqlStab)) {
                                            ?>
                                            <option value="<?php echo $row['id_macchina'] . " - " . $row['cod_stab'] . " - " . $row['descri_stab']; ?>"><?php echo $row['id_macchina'] . " - " . $row['cod_stab'] . " - " . $row['descri_stab']; ?></option>
                                        <?php } ?>
                                    </select>

                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroDt ?></td>
                                <td class="cella1"><?php echo dataCorrenteVisualizza() ?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroNote ?></td>
                                <td class="cella1" colspan="2"><textarea name="Note" id="Note" ROWS="2" COLS="40" value="<?php echo $Note ?>"><?php echo $Note?></textarea></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroNumTipoArticolo ?></td>
                                <td class="cella1"><input type="text" name="NumArticoli" id="NumArticoli" value="<?php echo $NumArticoli ?>"/></td>
                            </tr>
                        
                        
                            </table>
                        <table width="100%">

                            <tr>
                                <td class="cella3" ><?php echo $filtroArticolo ?></td>
                                <td class="cella3" ><?php echo $filtroQuantita ?></td>
                                <td class="cella3" ><?php echo $filtroUniMisura ?></td>
                            </tr>
                            <?php
                            for ($i = 1; $i <= $NumArticoli; $i++) {
                                if (isset($_POST['Articolo' . $i]) AND $_POST['Articolo' . $i] != "") {
                                    list($CodArticolo, $DescriArticolo) = explode(";", $_POST['Articolo' . $i]);
//                            echo "</br>i: ".$i." - CodArtocolo : ".$CodArticolo." - DescriArticolo : ".$DescriArticolo;
//                            echo "</br>i: ".$i." POST[Articolo i] : ".$_POST['Articolo'.$i];
                                    ?>
                                    <tr>
                                        <td class="cella1" >
                                            <select  name="Articolo<?php echo $i ?>" id="Articolo<?php echo $i ?>">
                                                <option value="<?php echo $_POST['Articolo' . $i] ?>" selected="<?php echo $_POST['Articolo' . $i] ?>"><?php echo $CodArticolo . " - " . $DescriArticolo ?></option>
                                                <?php
                                                mysql_data_seek($sqlArtico, 0);
                                                while ($rowArtico = mysql_fetch_array($sqlArtico)) {
                                                    ?>
                                                    <option value="<?php echo $rowArtico["codice"] . ";" . $rowArtico["descri"] ?>" size="40"><?php echo $rowArtico["codice"] . " - " . $rowArtico["descri"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td class="cella1"><input type="text" name="QtaArticolo<?php echo $i ?>" id="QtaArticolo<?php echo $i ?>" value="<?php echo $_POST['QtaArticolo' . $i] ?>"/></td>
                                        <td class="cella1"><?php echo $filtroPz ?></td>
                                    </tr>
                                    <?php
                                } else {
//                                    echo "Di nuovo campi vuoti non arriva il post</br>";
                                    ?>
                                    <tr>
                                        <td class="cella1">
                                            <select  name="Articolo<?php echo $i ?>" id="Articolo<?php echo $i ?>">
                                                <option value="" selected=""><?php echo $labelOptionSelectArticolo ?></option>
                                                <?php
                                                mysql_data_seek($sqlArtico, 0);
                                                while ($rowArtico = mysql_fetch_array($sqlArtico)) {
                                                    ?>
                                                    <option value="<?php echo $rowArtico["codice"] . ";" . $rowArtico["descri"] ?>" size="40"><?php echo $rowArtico["codice"] . " - " . $rowArtico["descri"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td class="cella1"><input type="text" name="QtaArticolo<?php echo $i ?>" id="QtaArticolo<?php echo $i ?>" /></td>
                                        <td class="cella1"><?php echo $filtroPz ?></td>
                                    </tr>	
                                    <?php
                                }
                            }
                            ?>
                            <tr>
                            <td class="cella2"><?php echo $filtroCaricaDocumento ?></td>
                            <td class="cella2" colspan="2"><input type="file" name="user_file" value=""/>
                            </td>
                        </tr>
                            <tr>
                                <td class="cella2" style="text-align: right " colspan="3">
                                    <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                    <input type="submit" name="submit1" value="<?php echo $valueButtonAggiorna ?>" onClick="Aggiorna()"/>
                                    <input type="submit" name="submit2" value="<?php echo $valueButtonSalva ?>" onClick="Salva()"/></td>
                            </tr>
                        </table>
                    </form>
                </div>


            <?php }
            ?>

        </div><!--mainContainer-->

    </body>
</html>

