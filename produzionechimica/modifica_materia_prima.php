<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <?php
    include('../Connessioni/serverdb.php');
    include('../sql/script_materia_prima.php');
    include('../sql/script_persona.php');
    include('../include/gestione_date.php');
    include('../sql/script_generazione_formula.php');

    if ($DEBUG)
        ini_set(display_errors, 1);
    //#############  AZIENDE SCRIVIBILI  #######################################
    //Array contenente le aziende di cui l'utente può editare i dati nella tabella materia_prima
    $actionOnLoad = "";
    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'materia_prima');
    //##########################################################################
    ?>
    <script language="javascript" type="text/javascript">

        function controllaCampi(arrayMsg) {

            var rv = true;
            var msg = "";

            if (document.getElementById('Descrizione').value === "") {
                rv = false;
                msg = msg + ' ' + arrayMsg[3];
            }
            if (document.getElementById('PreAcq').value !== "" & isNaN(document.getElementById('PreAcq').value)) {
                rv = false;
                msg = msg + ' ' + arrayMsg[4] + ' ' + arrayMsg[0];
            }
            if (document.getElementById('PreMed').value !== "" & isNaN(document.getElementById('PreMed').value)) {
                rv = false;
                msg = msg + ' ' + arrayMsg[5] + ' ' + arrayMsg[0];
            }
            if (document.getElementById('ScortaMinima').value !== "" & isNaN(document.getElementById('ScortaMinima').value)) {
                rv = false;
                msg = msg + ' ' + arrayMsg[1] + ' ' + arrayMsg[0];
            }
            if (document.getElementById('Inventario').value !== "" & isNaN(document.getElementById('GiacenzaIniziale').value)) {
                rv = false;
                msg = msg + ' ' + arrayMsg[2] + ' ' + arrayMsg[0];
            }
            if (document.getElementById('GiacenzaAttuale').value !== "" & isNaN(document.getElementById('GiacenzaAttuale').value)) {
                rv = false;
                msg = msg + ' ' + arrayMsg[6] + ' ' + arrayMsg[0];
            }

            if (!rv) {

                alert(msg);
                rv = false;
            }
            return rv;

        }

        function disabilitaOperazioni() {
            document.getElementById('Salva').disabled = true;
        }

    </script>
    <?php
    $Codice = $_GET['Codice'];

//1 .Visualizzo il record che intendo modificare all'interno della form
    $sql = findMatPrimaByCodice($Codice);
    while ($row = mysql_fetch_array($sql)) {
        $Descrizione = $row['descri_mat'];
        $PreAcq = $row['pre_acq'];
        $PreMed = $row['pre_med_pon'];
        $UniMisura = $row['uni_mis'];
        $Fornitore = $row['fornitore'];
        $ScortaMinima = $row['scorta_minima'];
        $GiacenzaAttuale = $row['giacenza_attuale'];
        $Inventario = $row['inventario'];
        $DtInventario = $row['dt_inventario'];
        $Note = $row['note'];
        $Data = $row['dt_abilitato'];
        $IdUtenteProp = $row['id_utente'];
        $IdAzienda = $row['id_azienda'];
        $NomeAzienda = getNomeAziendaById($_SESSION['objUtility'], $IdAzienda);
    }

//######################################################################
//#################### GESTIONE UTENTI #################################
//######################################################################            
//Si recupera il proprietario del dato e si verifica se l'utente 
//corrente ha il permesso di editare i dati di quell'utente proprietario 
//nelle tabelle coinvolte
//Se non ha il permesso bisogna disabilitare i pulsanti di salvataggio..
//############# VERIFICA PERMESSO DI SCRITTURA E MODIFICA ##############

    $actionOnLoad = "";

    $elencoFunzioni = array("3"); //vedere dettaglio prodotto-formula
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);


    $viewVerificaPermessi = 0;
    $arrayTabelleCoinvolte = array("materia_prima");
    if ($IdUtenteProp != $_SESSION['id_utente']) {
        $viewVerificaPermessi = 1;
        //Se il proprietario del dato è un utente diverso dall'utente 
        //corrente si verifica il permesso 3
        if ($DEBUG)
            echo "</br>Eseguita verifica permesso di tipo 3";
        $actionOnLoad = $actionOnLoad . verificaPermModifica3($_SESSION['objPermessiVis'], $arrayTabelleCoinvolte, $IdUtenteProp, $IdAzienda);
    }



//############# STRINGHE AZIENDE VISIBILI ###########################
    $strUtentiAziendeVisMat = getStrUtAzVisib($_SESSION['objPermessiVis'], 'materia_prima');

//$strUtentiAziendeVisPer = getStrUtAzVisib($_SESSION['objPermessiVis'], 'materia_prima'); 
//$sqlForn = findPersoneByTipoVis("FURNISHER", "nominativo", $strUtentiAziendeVisPer);

    $strUtentiAziendeVisForm = getStrUtAzVisib($_SESSION['objPermessiVis'], 'formula');
    $sqlFormule = '';
    $sqlFormule = findFormuleByMatPrima($Codice, $strUtentiAziendeVisForm);
    ?>

    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
//Nota il file it.php iene incluso nel menu quindi i mesaggi di errore e 
//le altre variabili vanno definite dopo l'inclusione del menu
            $arrayMsgPhp = array($msgErrValoreNumerico, //0
                $filtroScortaMinima, //1
                $filtroGiacenzaIniziale, //2
                $msgErrDescri, //3
                $filtroPrezzoAcq, //4
                $filtroPrezzoMedPon, //5
                $filtroGiacenzaAtt //6
            );
            $NomeUm = "";
            if ($UniMisura == 'kg') {
                $NomeUm = $filtroKg;
            } else {
                $NomeUm = $filtroQuintale;
            }
            $Tipo = substr($Codice, 0, 4);
            if (substr($Codice, 0, 4) == 'comp')
                $Tipo = $filtroMtDrymix;
            else
                $Tipo = $filtroMtCompound;
            ?>
            <div id="container" style="width:70%; margin:15px auto;">
                <form id="ModificaMateriaPrima" name="ModificaMateriaPrima" method="post" action= "modifica_materia_prima2.php" method="post" onsubmit='return controllaCampi(new Array("<?= join('", "', $arrayMsgPhp) ?>"))'>

                    <table style="width:100%;">
                        <tr>
                            <td class="cella3" colspan="2"><?php echo $titoloPaginaModificaMatPrima ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroTipoMt ?> </td>
                            <td class="cella1"><?php echo $Tipo ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroCodice ?> </td>
                            <td class="cella1"><?php echo $Codice; ?></td>
                            <input type="hidden" name="Codice" id="Codice" value="<?php echo $Codice; ?>"/>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDescrizione ?></td>
                            <td class="cella1"><?php echo $Descrizione; ?></td>
                            <input type="hidden" size="40px" name="Descrizione" id="Descrizione" value="<?php echo $Descrizione; ?>"/>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroFornitore ?></td>
                            <td class="cella1"><?php echo $Fornitore; ?></td>
                            <input type="hidden" name="Fornitore" id="Fornitore" value="<?php echo $Fornitore; ?>"/>
<!--                            <td class="cella1"> 
                                <select  name="Fornitore" id="Fornitore"  >
                                    <option value="<?php echo $Fornitore ?>" selected="<?php echo $Fornitore ?>"><?php echo $Fornitore ?></option>
                            <?php
                            while ($rowForn = mysql_fetch_array($sqlForn)) {
                                ?>
                                                <option value="<?php echo $rowForn["nominativo"] ?>" size="40"><?php echo $rowForn["nominativo"] ?></option>
                            <?php } ?>
                                </select></td>-->
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroUniMisura ?></td>
                            <td class="cella1"><?php echo $filtroKg ?></td>

                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroPrezzoAcq ?></td>
                            <td class="cella1"><input type="text" name="PreAcq" id="PreAcq" value="<?php echo $PreAcq; ?>"/><?php echo $filtroEuro; ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroPrezzoMedPon ?></td>
                            <td class="cella1"><?php echo $PreMed . " " . $filtroEuro; ?></td>
                            <input type="hidden" name="PreMed" id="PreMed" value="<?php echo $PreMed; ?>"/>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroScortaMinima ?></td>
                            <td class="cella1"><input type="text" name="ScortaMinima" id="ScortaMinima" value="<?php echo $ScortaMinima; ?>"/><?php echo $filtroKgBreve; ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroInventario ?></td>
                            <td class="cella1"><?php echo $Inventario . " " . $filtroKgBreve; ?></td>
                            <input type="hidden" name="Inventario" id="Inventario" value="<?php echo $Inventario; ?>"/>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDtInventario ?></td>
                            <td class="cella1"><?php echo $DtInventario ?></td>
                            <input type="hidden" name="DtInventario" id="DtInventario" value="<?php echo $DtInventario; ?>"/>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroGiacenza ?></td>
                            <td class="cella1"><?php echo $GiacenzaAttuale . " " . $filtroKgBreve ?></td>
                            <input type="hidden" name="GiacenzaAttuale" id="GiacenzaAttuale" value="<?php echo $GiacenzaAttuale; ?>"/>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroNote ?> </td>
                            <td class="cella1"><textarea name="Note" id="Note" ROWS="2" COLS="49"><?php echo $Note; ?></textarea></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDt ?></td>
                            <td class="cella1"><?php echo $Data; ?></td>
                        </tr>
                        <!-- La modifica dell' azienda di  una materia prima  viene gestita nel laboratorio-->
                        <tr>
                            <td class="cella4"><?php echo $filtroAzienda ?></td>
                            <td class="cella1"><?php echo $NomeAzienda ?></td>
                        </tr>
                    </table>
                    <!--//Visualizzazione formule in cui è contenuta la materia prima -->
                    <?php if ($sqlFormule!='' AND mysql_num_rows($sqlFormule)>0) { ?>
                        <table style="width:100%;">
                            <tr>
                                <td class="cella3" colspan="3"><?php echo $filtroProdottiContenenti . $Descrizione ?></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroCodice ?></td>
                                <td class="cella4"><?php echo $filtroNomeProdotto ?></td>
                                <td class="cella4"><?php echo $filtroQtaPerMiscela ?></td>
                            </tr>
                            <?php while ($rowForm = mysql_fetch_array($sqlFormule)) { ?>
                                <tr>
                                    <td class="cella1"> <a name="3" href="../prodotti/vista_prodotto_formula.php?Prodotto=<?php echo $rowForm['id_prodotto'] ?>"><?php echo $rowForm['cod_formula'] ?></a></td>
                                    <td class="cella1"><?php echo $rowForm['descri_formula'] ?></td>
                                    <td class="cella1" style="text-align:center"><?php echo number_format($rowForm['quantita'], '0', ',', ' ') . ' ' . $filtrogBreve ?></td>
                                </tr>
                            <?php }
                            ?></table>

                    <?php }
                    ?>
                    <table style="width:100%;">
                        <tr>
                            <td class="cella2" style="text-align: right " colspan="2">
                                <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                <input type="submit" id='Salva' value="<?php echo $valueButtonAggiornaPrezziMov . " - " . $valueButtonSalva ?>" title="<?php echo $titleSalvaAggiornaPrezzi ?>"/>
                            </td>
                        </tr>
                    </table>
                </form>

            </div>
            <div id="msgLog">
                <?php
                if ($DEBUG) {
                    if ($viewVerificaPermessi)
                        echo "</br>Eseguita verifica permesso di tipo 3";
                    echo "</br>ActionOnLoad : " . $actionOnLoad;
                    echo "</br>Id utente prop del dato: " . $IdUtenteProp;
                    echo "</br>Id azienda proprietaria del dato: " . $IdAzienda;
//                            echo "</br>Tabella persona: utenti e aziende vis : ".$strUtentiAziendeVisPer;
                }
                ?>
            </div>

    </body>
</html>
