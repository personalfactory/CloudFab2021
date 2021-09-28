<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body onload="document.getElementById('NumLottiTot').focus()">

        <div id="tracciabilitaContainer">

            <script language="javascript">
                function Verifica() {
                    document.forms["ScaricaCodLotto"].action = "carica_mov_lotto.php";
                    document.forms["ScaricaCodLotto"].submit();
                }
                function NuovoFornitore() {
                    location.href = "carica_persona.php?HrefBack=carica_mov_lotto.php";
                }
            </script>

            <?php
            //############# VERIFICA PERMESSI ##########################################
            //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
            //dall'utente loggato   
            $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'persona');

            include('../include/menu.php');
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('../include/gestione_date.php');
            include('../sql/script_persona.php');

            $errore = false;
            $messaggio = '';

            //###########################################################################      
            //####################### SCELTA FORMULA #################################### 
            //########################################################################### 

            if (!isset($_POST['NumLottiTot']) || $_POST['NumLottiTot'] == "") {

                $_SESSION['NumLottiTot'] = 0;
                $_SESSION['NumLottiSalvati'] = 0;
                $_SESSION['Prodotto'] = '';
                $_SESSION['DescriLotto'] = '';
                $_SESSION['CodiciLotto'] = array();

                $sqlPersona = findPersoneByTipoVis("CUSTOMER", "nominativo", $strUtentiAziende);
                ?>        
                <div id="tracciabilitaContainer" style=" width:800px; margin:50px auto;">
                    <form class="form" id="ScaricaCodLotto" name="ScaricaCodLotto" method="post">
                        <table width="100%">
                            <tr>
                                <td class="cella22" colspan="2"><?php echo $filtroScaricaLotti ?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroNumLotti ?></td>
                                <td class="cella1"><input type="text" name="NumLottiTot" id="NumLottiTot" size ="10"/>&nbsp;<?php echo $filtroPz ?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroOperazione ?></td>
                                <td class="cella1">
                                    <select name="TipoMov" id="TipoMov">
                                        <option value="1" selected="1"><?php echo $valCausaleInternalTest ?></option>
                                        <option value="2"><?php echo $valCausaleCampioni ?></option>
                                        <option value="3"><?php echo $valCausaleDdtPrf ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroNumDoc ?></td>
                                <td class="cella1"><input type="text" name="NumDoc" id="NumDoc" size="30px"/></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroDataDoc ?> </td>
                                <td class="cella1"><?php formSceltaData("GiornoDoc", "MeseDoc", "AnnoDoc", $arrayFiltroMese) ?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroNumOrdine ?></td>
                                <td class="cella1"><input type="text" name="NumOrdine" id="NumOrdine" size="30px"/></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroDataOrdine ?> </td>
                                <td class="cella1"><?php formSceltaData("GiornoOrdine", "MeseOrdine", "AnnoOrdine", $arrayFiltroMese) ?></td>
                            </tr>
                            <tr>
                                <td class="cella2" ><?php echo $filtroCliente ?></td>
                                <td class="cella1">
                                    <select name="Cliente" id="Cliente">
                                        <option value="" selected=""><?php echo $labelOptionSelectCliente ?></option>
                                        <?php
                                        while ($row = mysql_fetch_array($sqlPersona)) {
                                            ?>
                                            <option value="<?php echo $row['id_persona']; ?>"><?php echo $row['nominativo']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <input  type="button" value="<?php echo $valueButtonNew ?>" onClick="javascript:NuovoFornitore();" title="<?php echo $titleNuovoFornitore ?>"/></td>
                            </tr>  
                            <tr>
                                <td class="cella2"><?php echo $filtroNote ?></td>
                                <td class="cella1" colspan="2"><textarea name="Note" id="Note" ROWS="2" COLS="50"></textarea></td>
                            </tr>
                            <tr>
                                <td class="cella2" colspan="2" style="text-align: right"><input type="submit" onchange="Verifica()" value="<?php echo $valueButtonConferma ?>"/></td>
                            </tr>
                        </table>
                    </form>
                </div>

                <?php
            } else if (isset($_POST['NumLottiTot']) AND $_POST['NumLottiTot'] != "") {

                if (!is_numeric($_POST['NumLottiTot'])) {

                    $errore = true;
                    $messaggio = $messaggio . ' ' . $filtroNumKitPerLotto . ' ' . $msgErrQtaNumerica . ' <br/>';
                }

                $_SESSION['Note'] = "";
                if (isset($_POST['Note']) AND trim($_POST['Note']) != "") {
                    $_SESSION['Note'] = str_replace("'", "''", $_POST['Note']);
                }

                switch ($_POST['TipoMov']) {

                    case 1:
                        $_SESSION['Causale'] = $valCausaleInternalTest;
                        $_SESSION['TipDoc'] = $valTipoDocInternalTest;
                        $_SESSION['DesDoc'] = $valDesDocInternalTest;
                        $_SESSION['ProcAdottata'] = $valProceduraIntTest;

                        break;
                    case 2:
                        $_SESSION['Causale'] = $valCausaleCampioni;
                        $_SESSION['TipDoc'] = $valTipoDocCampioni;
                        $_SESSION['DesDoc'] = $valDesDocCampioni;
                        $_SESSION['ProcAdottata'] = $valProceduraCampioni;

                        break;
                    case 3:
                        $_SESSION['Causale'] = $valCausaleDdtPrf;
                        $_SESSION['TipDoc'] = $valTipoDocDdtPrf;
                        $_SESSION['DesDoc'] = $valDesDocDdtPrf;
                        $_SESSION['ProcAdottata'] = $valProceduraDdtPrf;

                        break;

                    default:
                        break;
                }

                $_SESSION['NumDoc'] = $valDefaultNumDdt;
                $_SESSION['DtDoc'] = dataCorrenteInserimento();
                if (isset($_POST['NumDoc']) AND $_POST['NumDoc'] != "") {
                    $_SESSION['NumDoc'] = str_replace("'", "''", $_POST['NumDoc']);
                    $_SESSION['DtDoc'] = $_POST['AnnoDoc'] . "-" . $_POST['MeseDoc'] . "-" . $_POST['GiornoDoc'];
                }


                $_SESSION['NumOrdine']=$valDefaultNumOrdine;
                $_SESSION['DtOrdine'] = $valDefaultDtOrdine;
                if (isset($_POST['NumOrdine']) AND $_POST['NumOrdine'] != "") {
                    $_SESSION['NumOrdine'] = str_replace("'", "''", $_POST['NumOrdine']);
                    $_SESSION['DtOrdine'] = $_POST['AnnoOrdine'] . "-" . $_POST['MeseOrdine'] . "-" . $_POST['GiornoOrdine'];
                }
                $_SESSION['Cliente'] = str_replace("'", "''", $_POST['Cliente']);


                if ($errore) {

                    echo $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                } else {

                    $_SESSION['NumLottiTot'] = $_POST['NumLottiTot'];
                    ?>

                    <script type="text/javascript">
                        location.href = "carica_mov_lotto1.php"
                    </script>

                    <?php
                }
            }
            ?>
        </div><!--mainContainer-->
    </body>
</html>

