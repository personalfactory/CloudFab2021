<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php
    include('../include/validator.php');
    ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <script language="javascript">
        function Carica() {
            document.forms["InserisciProdotto"].action = "carica_prodotto2.php";
            document.forms["InserisciProdotto"].submit();
        }
        function AggiornaCalcoli() {
            document.forms["InserisciProdotto"].action = "carica_prodotto.php";
            document.forms["InserisciProdotto"].submit();
        }
    </script>
    <script language="javascript" src="../js/visualizza_elementi.js"></script>

    <?php
    if ($DEBUG)
        ini_set("display_errors", "1");

    //###### VERIFICA PERMESSO VISUALIZZAZIONE SESTO LIVELLO GRUPPI ############
    $actionOnLoad = "";
    $elencoFunzioni = array("96");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);

    //############# STRINGHE UTENTI - AZIENDE VISIBILI #########################

    $strUtentiAziendeProd = getStrUtAzVisib($_SESSION['objPermessiVis'], 'prodotto');
    $strUtentiAziendeForm = getStrUtAzVisib($_SESSION['objPermessiVis'], 'formula');
    $strUtentiAziendeCat = getStrUtAzVisib($_SESSION['objPermessiVis'], 'categoria');
    $strUtentiAziendeComp = getStrUtAzVisib($_SESSION['objPermessiVis'], 'componente');
    $strUtentiAziendeMaz = getStrUtAzVisib($_SESSION['objPermessiVis'], 'mazzetta');
    $strUtAzGruppo = getStrUtAzVisib($_SESSION['objPermessiVis'], 'gruppo');

    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'prodotto');

    //########################################################################## 
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../include/precisione.php');
            include('../include/funzioni.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_prodotto.php');
            include('../sql/script_categoria.php');
            include('../sql/script_mazzetta.php');
            include('../sql/script_comune.php');
            include('../sql/script_gruppo.php');
            include('../sql/script_componente.php');
            include('../sql/script_formula.php');
            include('../sql/script_parametro_prod.php');
            include('../sql/script_parametro_glob_mac.php');

            include('../laboratorio/sql/script_lab_materie_prime.php');

            $Pagina = "carica_prodotto";

            begin();
            $sqlCodProdotto = selectCodFormulaNotInProdotto($strUtentiAziendeForm);
            $sqlCat = findAllCategorieVis("nome_categoria", $strUtentiAziendeCat);
            //$sqlComponente = selectComponentiVis($strUtentiAziendeComp, "descri_componente");
            $sqlComponente = selectCompVisByDizionarioAndTipo2($strUtentiAziendeComp, "descri_componente", $_SESSION['lingua'], $valTipo2RawMaterial);
            $sqlMazzetta = findAllMazzettaDefiniteVis($strUtentiAziendeMaz);
            $sqlMaz = findMazzettaByNome("Non definita");
            $sqlParProd = findAllParametriProd("id_par_prod");
            $sqlParGlob = findParGlobMac();
            $sqlSerieColore = findAllSerieVisibiliAbilitati("serie_colore", "serie_colore", $strUtentiAziendeProd);
            $sqlSerieAdditivo = findAllSerieVisibiliAbilitati("serie_additivo", "serie_additivo", $strUtentiAziendeProd);
            commit();

            while ($row = mysql_fetch_array($sqlMaz)) {
                $IdMazzettaNonDef = $row['id_mazzetta'];
                $NomeMazzettaNonDef = $row['nome_mazzetta'];
            }


            while ($rowParGlob = mysql_fetch_array($sqlParGlob)) {

                switch ($rowParGlob['id_par_gm']) {

                    case 131:
                        //MANUAL
                        $valMetodoPesaManual = $rowParGlob['valore_variabile'];
                        break;

                    case 144:
                        //SILOS
                        $valMetodoPesaSilo = $rowParGlob['valore_variabile'];
                        break;
                    case 155:
                        //NONE
                        $serieColoreDefault = $rowParGlob['valore_variabile'];
                        $serieAdditivoDefault = $rowParGlob['valore_variabile'];
                        break;

                    default:
                        break;
                }
            }

//##############################################################################
//##################### ANAGRAFE DEL PRODOTTO ##################################
//##############################################################################
//Se il nome prodotto ed il codice prodotto non sono stati settati 
//allora viene visualizzata la form di inserimento vuota
            if (!isset($_POST['CodiceProdotto']) && !isset($_POST['NomeProdotto'])) {
                ?>

                <div id="container" style="width:1300px; margin:15px auto;">
                    <form id="InserisciProdotto" name="InserisciProdotto" method="post" >
                        <table width="100%" >
                            <tr>
                                <td  colspan="6" class="cella3"><?php echo $titoloPaginaNuovoProd ?></td>
                            </tr>
                            <?php
                            //########### GENERAZIONE CODICE PRODOTTO PADRE ####################
                            if (!isset($_GET['IdProdottoPadre']) && !isset($_GET['CodProdottoPadre'])) {

                                $IdProdottoPadre = "0";
                                $CodProdottoPadre = "";
                                ?>
                                <tr>
                                    <td  class="cella4"><?php echo $filtroCodice ?></td>
                                    <td class="cella1">
                                        <select name="CodiceProdotto" id="CodiceProdotto">
                                            <option value="" selected=""><?php echo $labelOptionSelectCodProd ?></option>
                                            <?php
                                            while ($rowCodProdotto = mysql_fetch_array($sqlCodProdotto)) {
                                                ?>
                                                <option value="<?php echo ($rowCodProdotto['MID(cod_formula,2,5)']); ?>"><?php echo ($rowCodProdotto['MID(cod_formula,2,5)']); ?></option>
                                            <?php } ?>
                                        </select> 
                                    </td>
                                </tr>
                                <?php
                                //#################################################################
                                //############# GENERAZIONE CODICE PRODOTTO FIGLIO ################
                                //#################################################################
                            } else if (isset($_GET['IdProdottoPadre']) && isset($_GET['CodProdottoPadre'])) {

                                $IdProdottoPadre = $_GET['IdProdottoPadre'];
                                $CodProdottoPadre = $_GET['CodProdottoPadre'];
                                $CodProdotto = "";
                                $NumCodice = 0;
                                $codiceFamiglia = "";
                                $codiceFamiglia = substr($CodProdottoPadre, 0, 3);
                                //Il codice del prodotto figlio deve essere generato automaticamente
                                $CodProdotto = calcolaNuovoCodiceProdotto($codiceFamiglia, $valPrimaLetteraCod);
                                ?>
                                <tr>
                                    <td class="cella4"><?php echo $filtroCodice ?> </td>
                                    <td class="cella1"><input type="text" name="CodiceProdotto" id="CodiceProdotto" size="50" value="<?php echo $CodProdotto ?>"/></td>
                                </tr>
                                <?php
                                //###################################################################
                            }
                            ?>
                            <tr>
                                <td class="cella4"><?php echo $filtroNome ?> </td>
                                <td class="cella1"><input type="text" name="NomeProdotto" id="NomeProdotto" size="50"/></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroCategoria ?></td>
                                <td class="cella1">
                                    <select name="Categoria" id="Categoria">
                                        <option value="" selected=""><?php echo $labelOptionCatDefault ?></option>
                                        <?php
                                        while ($row = mysql_fetch_array($sqlCat)) {
                                            ?>
                                            <option value="<?php echo($row['id_cat']) . ";" . ($row['nome_categoria']) ?>" title="<?php echo $row['descri_categoria'] ?>"><?php echo($row['nome_categoria']) ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroProdPadre ?></td>
                                <td class="cella1"><?php echo $CodProdottoPadre; ?></td>
                                <input type="hidden" name="IdProdottoPadre" id="IdProdottoPadre" size="50" value="<?php echo $IdProdottoPadre ?>"/>
                                <input type="hidden" name="CodProdottoPadre" id="CodProdottoPadre" size="50" value="<?php echo $CodProdottoPadre ?>"/>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroLimColore ?></td>
                                <td class="cella1"><input type="text" name="LimiteColore" id="LimiteColore" value="<?php echo $DefaultLimiteColore; ?>"/></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroFattoreDivisore ?></td>
                                <td class="cella1"><input type="text" name="FattoreDivisore" id="FattoreDivisore" value="<?php echo $DefaultFattoreDivisore; ?>"/></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroFascia ?></td>
                                <td class="cella1"><input type="text" name="Fascia" id="Fascia" value="<?php echo $DefaultFascia; ?>"/></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroMazzetta ?></td>
                                <td class="cella1">
                                    <select name="Mazzetta" id="Mazzetta">
                                        <option value="<?php echo ($IdMazzettaNonDef . ';' . $NomeMazzettaNonDef); ?>" selected=""><?php echo $NomeMazzettaNonDef; ?></option>
                                        <?php
                                        while ($rowMaz = mysql_fetch_array($sqlMazzetta)) {
                                            ?>
                                            <option value="<?php echo($rowMaz['id_mazzetta']) . ';' . ($rowMaz['nome_mazzetta']); ?>"><?php echo($rowMaz['nome_mazzetta']) ?></option>
                                        <?php } ?>
                                    </select> 
                                </td>
                            </tr>
                           <!-- <tr>
                                <td class="cella4"><?php echo $filtroSerieColore ?></td>
                                <td class="cella1">
                                    <?php
                                    /**
                                    $k = 1;
                                    while ($rowSerieColori = mysql_fetch_array($sqlSerieColore)) {
                                        ?>
                                        <input type="checkbox" id="SerieColore<?php echo $k ?>" name="SerieColore<?php echo $k ?>" value="<?php echo($rowSerieColori['serie_colore']) ?>"/><?php echo($rowSerieColori['serie_colore']) ?><br/>

                                        <?php $k++;
                                    } */
                                    ?>
                                </td>
                            </tr>-->
 <tr>
                                <td class="cella4"><?php echo $filtroSerieColore ?></td>
                                <td class="cella1">
                                    <select id="SerieColore" name="SerieColore">
                                        <option value="<?php echo $serieColoreDefault ?>" selected="<?php echo $serieColoreDefault ?>"><?php echo $labelOptionSelectSerie ?> </option>
                                        <?php while ($rowSerieColore = mysql_fetch_array($sqlSerieColore)) { ?>
                                            <option value="<?php echo($rowSerieColore['serie_colore']) ?>"><?php echo($rowSerieColore['serie_colore']) ?></option>
    <?php } ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td class="cella4"><?php echo $filtroSerieAdditivo ?></td>
                                <td class="cella1">
                                    <select id="SerieAdditivo" name="SerieAdditivo">
                                        <option value="<?php echo $serieAdditivoDefault ?>" selected="<?php echo $serieAdditivoDefault ?>"><?php echo $labelOptionSelectAdditivo ?> </option>
                                        <?php while ($rowSerieAdditivo = mysql_fetch_array($sqlSerieAdditivo)) { ?>
                                            <option value="<?php echo($rowSerieAdditivo['serie_additivo']) ?>"><?php echo($rowSerieAdditivo['serie_additivo']) ?></option>
    <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroGeografico ?></td>
                                <td class="cella11"><?php include('./moduli/visualizza_form_geografico.php'); ?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroGruppoAcquisto ?></td>
                                <td class="cella11"><?php include('./moduli/visualizza_form_gruppo.php'); ?></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroAzienda ?></td>
                                <td class="cella1">
                                    <select name="Azienda" id="Azienda"> 
                                        <option value="<?php echo $_SESSION['id_azienda'] . ";" . $_SESSION['nome_azienda'] ?>" selected="selected"><?php echo $_SESSION['nome_azienda'] ?></option>
                                        <?php
                                        //Si selezionano solo le aziende che l'utente ha il permesso di editare
                                        for ($a = 0; $a < count($arrayAziendeScrivibili); $a++) {
                                            $idAz = $arrayAziendeScrivibili[$a]->getIdAzienda();
                                            $nomeAz = $arrayAziendeScrivibili[$a]->getNomeAzienda();
                                            if ($idAz != $_SESSION['id_azienda']) {
                                                ?>
                                                <option value="<?php echo( $idAz . ';' . $nomeAz); ?>"><?php echo($nomeAz) ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select> 
                                </td>
                            </tr>
                        </table>
                        <!--
                        ##############################################################################
                        ##################### COMPONENTI #############################################
                        ##############################################################################-->
                        <table width="100%" >
                            <tr>
                                <td class="cella3" width="400px"><?php echo $filtroMateriaPrima ?></td>
                                <td class="cella3"><?php echo $filtroMetodoPesa ?></td>
                                <td class="cella3"><?php echo $filtroOrdineDosaggio ?></td>
                                <td class="cella3"><?php echo $filtroTollEcc ?></td>
                                <td class="cella3"><?php echo $filtroTollDif ?></td>
                                <td class="cella3"><?php echo $filtroFluidificazione ?></td>
                                <td class="cella3"><?php echo $filtroQuantita ?></td>
                                <td class="cella3"><?php echo $filtroCostoKilo ?></td>
                            </tr>
                            <?php
                            $PrezzoKilo = 0;
                            $PrezzoGrammo = 0;
                            //Visualizzo l'elenco dei componenti presenti nella tabella [componente]
                            $NComp = 1;
                            $colore = 1;
                            while ($rowComponente = mysql_fetch_array($sqlComponente)) {

                                if ($colore == 1) {
                                    ?>
                                    <tr>
                                        <td width="300" class="cella2"><?php echo($rowComponente['descri_componente']) ?></td>
                                        <td class="cella2">
                                            <select name="MetodoPesa<?php echo($NComp); ?>" id="MetodoPesa<?php echo($NComp); ?>">
                                                <option value="<?php echo $valMetodoPesaSilo ?>" selected="<?php echo $valMetodoPesaSilo ?>"><?php echo $valMetodoPesaSilo ?></option>
                                                <option value="<?php echo $valMetodoPesaManual ?>" > <?php echo $valMetodoPesaManual ?></option>
                                            </select>
                                        </td>
                                        <td class="cella2"><input size="8px" type="text" name="OrdineDos<?php echo($NComp); ?>" id="OrdineDos<?php echo($NComp); ?>" value="0" /></td>

                                        <?php
                                        //Recupero il prezzo                                   
                                        $sqlPrezzo = findLabMatPrimaByCodice($rowComponente['cod_componente']);
                                        //findMatPrimaByCodice($rowComponente['cod_componente']);
                                        while ($rowPrezzo = mysql_fetch_array($sqlPrezzo)) {

                                            $PrezzoKilo = number_format($rowPrezzo['prezzo'], 4, ',', '');
                                            $PrezzoGrammo = $rowPrezzo['prezzo'] / 1000;
                                        }//End While Prezzo                                     
                                        ?>
                                        <td class="cella2"><input size="8px" type="text" name="TollEcc<?php echo($NComp); ?>" id="TollEcc<?php echo($NComp); ?>" value="0" /></td>
                                        <td class="cella2"><input size="8px" type="text" name="TollDif<?php echo($NComp); ?>" id="TollDif<?php echo($NComp); ?>" value="0" /></td>
                                        <td class="cella2"><input size="8px" type="text" name="Fluidificazione<?php echo($NComp); ?>" id="Fluidificazione<?php echo($NComp); ?>" value="0" /> <?php echo $filtrogBreve ?></td>
                                        <td class="cella2"><nobr><input size="10px" type="text" name="Qta<?php echo($NComp); ?>" id="Qta<?php echo($NComp); ?>" value="0" /><?php echo $filtrogBreve ?></nobr></td>
                                        <td class="cella2"><nobr><?php echo $PrezzoKilo . " " . $filtroEuro ?></nobr></td>                                        
                                    </tr>
                                    <?php
                                    $colore = 2;
                                } else {
                                    ?>
                                    <tr>
                                        <td width="300" class="cella1"><?php echo($rowComponente['descri_componente']) ?></td>
                                        <td class="cella1">
                                            <select name="MetodoPesa<?php echo($NComp); ?>" id="MetodoPesa<?php echo($NComp); ?>">
                                                <option value="<?php echo $valMetodoPesaSilo ?>" selected="<?php echo $valMetodoPesaSilo ?>"><?php echo $valMetodoPesaSilo ?></option>
                                                <option value="<?php echo $valMetodoPesaManual ?>" > <?php echo $valMetodoPesaManual ?></option>
                                            </select>
                                        </td>
                                        <td class="cella1"><input size="8px" type="text" name="OrdineDos<?php echo($NComp); ?>" id="OrdineDos<?php echo($NComp); ?>" value="0" /></td>

                                        <?php
                                        //Recupero il prezzo                                   
                                        $sqlPrezzo = findLabMatPrimaByCodice($rowComponente['cod_componente']);
                                        //findMatPrimaByCodice($rowComponente['cod_componente']);
                                        while ($rowPrezzo = mysql_fetch_array($sqlPrezzo)) {

                                            $PrezzoKilo = number_format($rowPrezzo['prezzo'], 4, ',', '');
                                            $PrezzoGrammo = $rowPrezzo['prezzo'] / 1000;
                                        }//End While Prezzo                                     
                                        ?>
                                        <td class="cella1"><input size="8px" type="text" name="TollEcc<?php echo($NComp); ?>" id="TollEcc<?php echo($NComp); ?>" value="0" /></td>
                                        <td class="cella1"><input size="8px" type="text" name="TollDif<?php echo($NComp); ?>" id="TollDif<?php echo($NComp); ?>" value="0" /></td>
                                        <td class="cella1"><input size="8px" type="text" name="Fluidificazione<?php echo($NComp); ?>" id="Fluidificazione<?php echo($NComp); ?>" value="0" /> <?php echo $filtrogBreve ?></td>
                                        <td class="cella1"><nobr><input size="10px" type="text" name="Qta<?php echo($NComp); ?>" id="Qta<?php echo($NComp); ?>" value="0" /><?php echo $filtrogBreve ?></nobr></td>
                                        <td class="cella1"><nobr><?php echo $PrezzoKilo . " " . $filtroEuro ?></nobr></td>                                        
                                    </tr>
                                    <?php
                                    $colore = 1;
                                }
                                $NComp++;
                            }//End While componenti
                            ?>
                        </table>

                        <!--
                        ##############################################################################
                        ##################### PARAMETRI PRODOTTO #####################################
                        ##############################################################################-->

                        <table width="100%" >
                            <tr>
                                <td class="cella3"><?php echo $filtroPar ?></td>
                                <td class="cella3"><?php echo $filtroDescrizione ?></td>
                                <td class="cella3"><?php echo $filtroValore ?></td>
                                <td class="cella3"><?php echo $filtroUniMisura ?></td>
                            </tr>
                            <?php
                            while ($rowPar = mysql_fetch_array($sqlParProd)) {
                                ?>
                                <tr>
                                    <td width="30%" class="cella4" title="<?php echo($rowPar['descri_variabile']) ?>"><?php echo($rowPar['nome_variabile']) ?></td>
                                    <td width="40%" class="cella4" ><?php echo($rowPar['descri_variabile']) ?></td>
                                    <td width="15%" class="cella4"><input type="text" style="width:90%" name="Valore<?php echo($rowPar['id_par_prod']); ?>" id="Valore<?php echo($rowPar['id_par_prod']); ?>" value="<?php echo $rowPar['valore_base'] ?>" /></td>
                                    <td width="15%" class="cella4"><?php echo $rowPar['uni_mis'] ?></td>
                                </tr>
                                <?php
                            }//End While parametri
                            ?>
                            <tr>
                                <td class="cella2" style="text-align: right " colspan="4">
                                    <input type="reset"  onClick="javascript:history.back();" value="<?php echo $valueButtonAnnulla ?>"/>
                                    <input id="Aggiorna" type="button" onclick="javascript:AggiornaCalcoli();" value="<?php echo $valueButtonAggiorna ?>" /></td>
                            </tr>  
                        </table>
                    </form>
                </div>  
                <?php
            } else {
                //###################################################################
                ////////////////////////////AGGIORNAMENTO SCRIPT ////////////////////
                //###################################################################
                //Se il codice prodotto ed il nome prodotto sono stati settati 
                //allora viene effettuato l'aggiornamento della pagina
                //Ricavo il valore dei campi tipo_riferimrnto e geografico mandati tramite POST
                $TipoRiferimento = $_POST['scegli_geografico'];

                $Geografico = "";
                if ($TipoRiferimento == "Mondo") {
                    $Geografico = "Mondo";
                } else if ($TipoRiferimento == "Continente") {
                    $Geografico = $_POST['Continente'];
                } else if ($TipoRiferimento == "Stato") {
                    $Geografico = $_POST['Stato'];
                } else if ($TipoRiferimento == "Regione") {
                    $Geografico = $_POST['Regione'];
                } else if ($TipoRiferimento == "Provincia") {
                    $Geografico = $_POST['Provincia'];
                } else if ($TipoRiferimento == "Comune") {
                    $Geografico = $_POST['Comune'];
                }

                //Ricavo il valore dei campi livello_gruppo e gruppo mandati tramite POST
                $LivelloGruppo = $_POST['scegli_gruppo'];
                $Gruppo = "";
                if ($LivelloGruppo == "PrimoLivello") {
                    $Gruppo = $_POST['PrimoLivello'];
                } else if ($LivelloGruppo == "SecondoLivello") {
                    $Gruppo = $_POST['SecondoLivello'];
                } else if ($LivelloGruppo == "TerzoLivello") {
                    $Gruppo = $_POST['TerzoLivello'];
                } else if ($LivelloGruppo == "QuartoLivello") {
                    $Gruppo = $_POST['QuartoLivello'];
                } else if ($LivelloGruppo == "QuintoLivello") {
                    $Gruppo = $_POST['QuintoLivello'];
                } else if ($LivelloGruppo == "SestoLivello") {
//            $Gruppo = $_POST['SestoLivello'];
                    $Gruppo = "Universale";
                }

                $Geografico = str_replace("'", "", $Geografico);
                $Gruppo = str_replace("'", "", $Gruppo);

                $CodiceProdotto = "";
                $NomeProdotto = "";
                $CodProdottoPadre = "";
                $IdProdottoPadre = "";
                $LimiteColore = "";
                $FattoreDivisore = "";
                $Fascia = "";
                $PostMazzetta = "";
                $SerieColore = $serieColoreDefault;
                $SerieAdditivo = $serieAdditivoDefault;


                if (isSet($_POST['CodiceProdotto']))
                    $CodiceProdotto = str_replace("'", "", $_POST['CodiceProdotto']);
                if (isSet($_POST['NomeProdotto']))
                    $NomeProdotto = str_replace("'", "", $_POST['NomeProdotto']);
                if (isSet($_POST['CodProdottoPadre']))
                    $CodProdottoPadre = str_replace("'", "", $_POST['CodProdottoPadre']);
                if (isSet($_POST['IdProdottoPadre']))
                    $IdProdottoPadre = str_replace("'", "", $_POST['IdProdottoPadre']);
                if (isSet($_POST['LimiteColore']))
                    $LimiteColore = str_replace("'", "", $_POST['LimiteColore']);
                if (isSet($_POST['FattoreDivisore']))
                    $FattoreDivisore = str_replace("'", "", $_POST['FattoreDivisore']);
                if (isSet($_POST['Fascia']))
                    $Fascia = str_replace("'", "", $_POST['Fascia']);
                if (isSet($_POST['Mazzetta']))
                    $PostMazzetta = str_replace("'", "", $_POST['Mazzetta']);

                if (isSet($_POST['SerieColore']))
                    $SerieColore = str_replace("'", "", $_POST['SerieColore']);
                if (isSet($_POST['SerieAdditivo']))
                    $SerieAdditivo = str_replace("'", "", $_POST['SerieAdditivo']);



                //Inizializzo la variabile errore relativa ai campi delle tbelle prodotto e anagrafe_prodotto
                $errore = false;
                //Inizializzo la variabile che conta il numero di errori sulle quantita 
                $NumErrore = 0;

                //Gestione degli errori relativa all'aggiornamento dei campi del prodotto
                include('./include/controllo_input_prodotto.php');

                $messaggio = $messaggio . ' ' . $msgErrNellaPag;

                if (!$errore) {
                    echo '<div id="container">' . $msgInfoDatiCorretti . '</div>';
                }

                if ($errore) {
                    echo '<div id="msgErr">' . $messaggio . '</div>';
                }
                list($Mazzetta, $NomeMazzetta) = explode(';', $_POST['Mazzetta']);
                list($Categoria, $NomeCategoria) = explode(';', $_POST['Categoria']);
                list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);
                ?>

                <div id="container" style="width:1200px; margin:15px auto;">
                    <form id="InserisciProdotto" name="InserisciProdotto" method="post">
                        <table width="100%" >
                            <tr>
                                <td  colspan="6" class="cella3"><?php echo $titoloPaginaNuovoProd ?></td>
                            </tr>
                            <tr>
                                <td width="100" class="cella4"><?php echo $filtroCodice ?> </td>
                                <td width="529" class="cella1">
                                    <select name="CodiceProdotto" id="CodiceProdotto">
                                        <option value="<?php echo $CodiceProdotto; ?>" selected=""><?php echo $CodiceProdotto; ?> </option>
                                        <?php
                                        //Visualizzo solo i codici formula non ancora associati al prodotto senza K davanti
                                        mysql_data_seek($sqlCodProdotto, 0);
                                        while ($rowCodProdotto = mysql_fetch_array($sqlCodProdotto)) {
                                            ?>
                                            <option value="<?php echo ($rowCodProdotto['MID(cod_formula,2,5)']); ?>"><?php echo ($rowCodProdotto['MID(cod_formula,2,5)']); ?></option>
    <?php } ?>
                                    </select></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroNome ?> </td>
                                <td class="cella1"><input type="text" name="NomeProdotto" id="NomeProdotto" size="50" value="<?php echo $NomeProdotto; ?>"/></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroCategoria ?></td>
                                <td class="cella1">
                                    <select name="Categoria" id="Categoria">
                                        <option value="<?php echo $Categoria . ";" . $NomeCategoria; ?>" selected=""><?php echo $NomeCategoria; ?></option>
                                        <?php
                                        mysql_data_seek($sqlCat, 0);
                                        while ($row = mysql_fetch_array($sqlCat)) {
                                            ?>
                                            <option value="<?php echo($row['id_cat']) . ";" . ($row['nome_categoria']); ?>" title="<?php echo $row['descri_categoria'] ?>"><?php echo($row['nome_categoria']); ?></option>
    <?php }//End While select categorie        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroProdPadre ?></td>
                                <td class="cella1"><?php echo $CodProdottoPadre; ?>
                                    <input type="hidden" name="IdProdottoPadre" id="IdProdottoPadre" size="50" value="<?php echo $IdProdottoPadre ?>"/>
                                    <input type="hidden" name="CodProdottoPadre" id="CodProdottoPadre" size="50" value="<?php echo $CodProdottoPadre ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroLimColore ?></td>
                                <td class="cella1"><input type="text" name="LimiteColore" id="LimiteColore" value="<?php echo $LimiteColore; ?>"/> </td>
                            </tr>

                            <tr>
                                <td class="cella4"><?php echo $filtroFattoreDivisore ?></td>
                                <td class="cella1"><input type="text" name="FattoreDivisore" id="FattoreDivisore" value="<?php echo $FattoreDivisore; ?>"/> </td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroFascia ?></td>
                                <td class="cella1"><input type="text" name="Fascia" id="Fascia" value="<?php echo $Fascia; ?>"/></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroMazzetta ?></td>
                                <td class="cella1">
                                    <?php
                                    //Prendo la descrizione della mazzetta dall' id_mazzetta 
                                    //arrivato in POST 
                                    if ($Mazzetta != "") {
                                        $sqlDescriMazzetta = findMazzettaByID($Mazzetta);
                                        while ($rowDescriMazzetta = mysql_fetch_array($sqlDescriMazzetta)) {
                                            $CodMazzetta = $rowDescriMazzetta['cod_mazzetta'];
                                        }
                                    }
                                    ?>

                                    <select name="Mazzetta" id="Mazzetta">
                                        <option value="<?php echo $Mazzetta . ';' . $NomeMazzetta; ?>" selected=""><?php echo $NomeMazzetta; ?></option>
                                        <?php
                                        mysql_data_seek($sqlMazzetta, 0);
                                        while ($rowMaz = mysql_fetch_array($sqlMazzetta)) {
                                            ?>
                                            <option value="<?php echo($rowMaz['id_mazzetta']) . ';' . ($rowMaz['nome_mazzetta']); ?>"><?php echo($rowMaz['nome_mazzetta']) ?></option>
    <?php } //End While select mazzetta       ?>
                                    </select>

                                </td>
                            </tr>

                            <!--<tr>
                                <td class="cella4"><?php echo $filtroSerieColore ?></td>
                                <td class="cella1" >
                                <?php
                              /**  $k = 1;
                                if (mysql_num_rows($sqlSerieColore) > 0)
                                    $numSerieTot= mysql_num_rows($sqlSerieColore);
                                    mysql_data_seek($sqlSerieColore, 0);
                                while ($rowSerieColori = mysql_fetch_array($sqlSerieColore)) {

                                    if (isset($_POST['SerieColore' . $k]) AND $_POST['SerieColore' . $k]!="") {
                                        ?>
                                        <input type="checkbox" name="SerieColore<?php echo($k); ?>" value="<?php echo $_POST['SerieColore' . $k]; ?>" checked="checked" /><?php echo $_POST['SerieColore' . $k]; ?><br/>

                                        <?php
                                    } else {
                                        ?>
                                            <input type="checkbox" name="SerieColore<?php echo($k); ?>" value="<?php echo($rowSerieColori['serie_colore']) ?>" /><?php echo($rowSerieColori['serie_colore']) ?><br/>
                                        <?php
                                    }
                                   
                                    $k++;
                                }*/
                                ?>
                            </td>

                            </tr>-->
                            
                            
                             <tr>
                                <td class="cella4"><?php echo $filtroSerieColore ?></td>
                                <td class="cella1">
                                    <select id="SerieColore" name="SerieColore">
                                        <option value="<?php echo $SerieColore; ?>" selected="<?php echo $SerieColore; ?>"><?php echo $SerieColore; ?></option>
                                        <?php while ($rowSerieColore = mysql_fetch_array($sqlSerieColore)) { ?>
                                            <option value="<?php echo($rowSerieColore['serie_colore']) ?>"><?php echo($rowSerieColore['serie_colore']) ?></option>
    <?php } ?>
                                    </select>
                                </td>
                            </tr>     
                            
                            <tr>
                                <td class="cella4"><?php echo $filtroSerieAdditivo ?></td>
                                <td class="cella1">
                                    <select id="SerieAdditivo" name="SerieAdditivo">
                                        <option value="<?php echo $SerieAdditivo; ?>" selected="<?php echo $SerieAdditivo; ?>"><?php echo $SerieAdditivo; ?></option>
                                        <?php while ($rowSerieAdditivo = mysql_fetch_array($sqlSerieAdditivo)) { ?>
                                            <option value="<?php echo($rowSerieAdditivo['serie_additivo']) ?>"><?php echo($rowSerieAdditivo['serie_additivo']) ?></option>
    <?php } ?>
                                    </select>
                                </td>
                            </tr>                          

                            <tr>
                                <td class="cella2"><?php echo $filtroGeografico ?></td>
                                <td class="cella11"><?php include('./moduli/visualizza_form_modifica_geografico.php'); ?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroGruppoAcquisto ?></td>
                                <td class="cella11"><?php include('./moduli/visualizza_form_modifica_gruppo.php'); ?></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroAzienda ?></td>
                                <td class="cella1">
                                    <select name="Azienda" id="Azienda"> 
                                        <option value="<?php echo $IdAzienda . ';' . $NomeAzienda; ?>" selected=""><?php echo $NomeAzienda; ?></option>
                                        <?php
                                        //Si selezionano solo le aziende scrivibili dall' utente
                                        for ($a = 0; $a < count($arrayAziendeScrivibili); $a++) {
                                            $idAz = $arrayAziendeScrivibili[$a]->getIdAzienda();
                                            $nomeAz = $arrayAziendeScrivibili[$a]->getNomeAzienda();
                                            if ($idAz != $IdAzienda) {
                                                ?>
                                                <option value="<?php echo( $idAz . ';' . $nomeAz); ?>"><?php echo($nomeAz) ?></option>                                       
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select> 
                                </td>
                            </tr>
                        </table>
                        <!--
                        ##############################################################################
                        ##################### COMPONENTI #############################################
                        ##############################################################################-->
                        <table width="100%">
                            <tr>
                                <td class="cella3" width="400px"><?php echo $filtroMateriaPrima ?></td>
                                <td class="cella3"><?php echo $filtroMetodoPesa ?></td>
                                <td class="cella3"><?php echo $filtroOrdineDosaggio ?></td>
                                <td class="cella3"><?php echo $filtroTollEcc ?></td>
                                <td class="cella3"><?php echo $filtroTollDif ?></td>
                                <td class="cella3"><?php echo $filtroFluidificazione ?></td>
                                <td class="cella3"><?php echo $filtroQuantita ?></td>
                                <td class="cella3"><?php echo $filtroCostoKilo ?></td>
                                <td class="cella3"><?php echo $filtroCosto ?></td>
                            </tr>

                            <?php
                            //Visualizzo l'elenco dei componenti presenti nella tabella [componente]
                            $PrezzoKilo = 0;
                            $Prezzo = 0;
                            $NComp = 1;
                            $PrezzoTotale = 0;
                            $QtaTotComp = 0;
                            mysql_data_seek($sqlComponente, 0);
                            $colore = 1;
                            while ($rowComponente = mysql_fetch_array($sqlComponente)) {

                                $QtaTotComp = $QtaTotComp + $_POST['Qta' . $NComp];

                                if ($colore == 1) {
                                    ?>
                                    <tr>
                                        <td width="300" class="cella2"> <?php echo($rowComponente['descri_componente']) ?></td>
                                        <td class="cella2">
                                            <select name="MetodoPesa<?php echo($NComp); ?>" id="MetodoPesa<?php echo($NComp); ?>">
                                                <option value="<?php echo $_POST['MetodoPesa' . $NComp]; ?>" ><?php echo $_POST['MetodoPesa' . $NComp]; ?></option>
                                                <option value="<?php echo $valMetodoPesaSilo ?>"><?php echo $valMetodoPesaSilo ?></option>
                                                <option value="<?php echo $valMetodoPesaManual ?>"><?php echo $valMetodoPesaManual ?></option>
                                            </select>
                                        </td>
                                        <td class="cella2"><input size="8px" type="text" name="OrdineDos<?php echo($NComp); ?>" id="OrdineDos<?php echo($NComp); ?>" value="<?php echo $_POST['OrdineDos' . $NComp]; ?>" /></td>
                                        <td class="cella2"><input size="8px" type="text" name="TollEcc<?php echo($NComp); ?>" id="TollEcc<?php echo($NComp); ?>" value="<?php echo $_POST['TollEcc' . $NComp]; ?>" /></td>
                                        <td class="cella2"><input size="8px" type="text" name="TollDif<?php echo($NComp); ?>" id="TollDif<?php echo($NComp); ?>" value="<?php echo $_POST['TollDif' . $NComp]; ?>" /></td>
                                        <td class="cella2"><input size="8px" type="text" name="Fluidificazione<?php echo($NComp); ?>" id="Fluidificazione<?php echo($NComp); ?>" value="<?php echo $_POST['Fluidificazione' . $NComp]; ?>" /></td>
                                        <?php
                                        //Inizio prezzo
                                        $sqlPrezzo = findLabMatPrimaByCodice($rowComponente['cod_componente']);
                                        //findMatPrimaByCodice($rowComponente['cod_componente']);
                                        while ($rowPrezzo = mysql_fetch_array($sqlPrezzo)) {
                                            $PrezzoKilo = number_format($rowPrezzo['prezzo'], 4, ',', '');
                                            $PrezzoGrammo = $rowPrezzo['prezzo'] / 1000;
                                            $Prezzo = number_format(($_POST['Qta' . $NComp]) * ($PrezzoGrammo), 4);
                                            $PrezzoTotale = $PrezzoTotale + $Prezzo;
                                        }//End While Prezzo  
                                        ?>

                                        <td  class="cella2"><nobr><input size=10pxtype="text" name="Qta<?php echo($NComp); ?>" id="Qta<?php echo($NComp); ?>" value="<?php echo $_POST['Qta' . $NComp]; ?>" /><?php echo $filtrogBreve ?></nobr></td>
                                        <td width="70px" class="cella2"><nobr><?php echo $PrezzoKilo . " " . $filtroEuro ?></nobr></td>
                                        <td width="100px" class="cella2"><nobr><?php echo $Prezzo . " " . $filtroEuro ?></nobr></td>	
                                    </tr>
                                    <?php
                                    $colore = 2;
                                } else {
                                    ?>
                                    <tr>
                                        <td width="300" class="cella1"> <?php echo($rowComponente['descri_componente']) ?></td>
                                        <td class="cella1">
                                            <select name="MetodoPesa<?php echo($NComp); ?>" id="MetodoPesa<?php echo($NComp); ?>">
                                                <option value="<?php echo $_POST['MetodoPesa' . $NComp]; ?>" ><?php echo $_POST['MetodoPesa' . $NComp]; ?></option>
                                                <option value="<?php echo $valMetodoPesaSilo ?>"><?php echo $valMetodoPesaSilo ?></option>
                                                <option value="<?php echo $valMetodoPesaManual ?>"><?php echo $valMetodoPesaManual ?></option>
                                            </select>
                                        </td>
                                        <td class="cella1"><input size="8px" type="text" name="OrdineDos<?php echo($NComp); ?>" id="OrdineDos<?php echo($NComp); ?>" value="<?php echo $_POST['OrdineDos' . $NComp]; ?>" /></td>
                                        <td class="cella1"><input size="8px" type="text" name="TollEcc<?php echo($NComp); ?>" id="TollEcc<?php echo($NComp); ?>" value="<?php echo $_POST['TollEcc' . $NComp]; ?>" /></td>
                                        <td class="cella1"><input size="8px" type="text" name="TollDif<?php echo($NComp); ?>" id="TollDif<?php echo($NComp); ?>" value="<?php echo $_POST['TollDif' . $NComp]; ?>" /></td>
                                        <td class="cella1"><input size="8px" type="text" name="Fluidificazione<?php echo($NComp); ?>" id="Fluidificazione<?php echo($NComp); ?>" value="<?php echo $_POST['Fluidificazione' . $NComp]; ?>" /></td>
                                        <?php
                                        //Inizio prezzo
                                        $sqlPrezzo = findLabMatPrimaByCodice($rowComponente['cod_componente']);
                                        //findMatPrimaByCodice($rowComponente['cod_componente']);
                                        while ($rowPrezzo = mysql_fetch_array($sqlPrezzo)) {
                                            $PrezzoKilo = number_format($rowPrezzo['prezzo'], 4, ',', '');
                                            $PrezzoGrammo = $rowPrezzo['prezzo'] / 1000;
                                            $Prezzo = number_format(($_POST['Qta' . $NComp]) * ($PrezzoGrammo), 4);
                                            $PrezzoTotale = $PrezzoTotale + $Prezzo;
                                        }//End While Prezzo  
                                        ?>

                                        <td  class="cella1"><nobr><input size=10pxtype="text" name="Qta<?php echo($NComp); ?>" id="Qta<?php echo($NComp); ?>" value="<?php echo $_POST['Qta' . $NComp]; ?>" /><?php echo $filtrogBreve ?></nobr></td>
                                        <td width="70px" class="cella1"><nobr><?php echo $PrezzoKilo . " " . $filtroEuro ?></nobr></td>
                                        <td width="100px" class="cella1"><nobr><?php echo $Prezzo . " " . $filtroEuro ?></nobr></td>	
                                    </tr>
                                    <?php
                                    $colore = 1;
                                }


                                $NComp++;
                            }//End While Componenti
                            mysql_close();
                            $QtaTotComp = number_format($QtaTotComp, 2, '.', ' ');
                            ?>
                            <tr>
                                <td class="dataRigWhite" colspan="6"><?php echo $filtroTotali ?></td>
                                <td class="dataRigWhite" colspan="2"><?php echo $QtaTotComp . " " . $filtrogBreve ?></td>
                                <td class="dataRigWhite"><?php echo $PrezzoTotale; ?>&nbsp; &euro;</td>
                            </tr>	
                        </table> 
                        <!--
                        ##############################################################################
                        ##################### PARAMETRI PRODOTTO #####################################
                        ##############################################################################-->
                        <table width="100%" >
                            <tr>
                                <td class="cella3"><?php echo $filtroPar ?></td>
                                <td class="cella3"><?php echo $filtroDescrizione ?></td>
                                <td class="cella3"><?php echo $filtroValore ?></td>
                                <td class="cella3"><?php echo $filtroUniMisura ?></td>
                            </tr>
                            <?php
                            while ($rowPar = mysql_fetch_array($sqlParProd)) {
                                ?>
                                <tr>
                                    <td width="30%" class="cella4" title="<?php echo($rowPar['descri_variabile']) ?>"><?php echo($rowPar['nome_variabile']) ?></td>
                                    <td width="40%" class="cella4" ><?php echo($rowPar['descri_variabile']) ?></td>
                                    <td width="15%" class="cella4"><input style="width:90%" type="text" name="Valore<?php echo($rowPar['id_par_prod']); ?>" id="Valore<?php echo($rowPar['id_par_prod']); ?>" value="<?php echo $_POST['Valore' . $rowPar['id_par_prod']]; ?>"  /></td>
                                    <td width="15%" class="cella4"><?php echo $rowPar['uni_mis'] ?></td>
                                </tr>
                                <?php
                            }//End While parametri
                            ?>
                            <tr>
                                <td class="cella2" style="text-align: right " colspan="4">
                                    <input type="reset"  onClick="javascript:history.back();" value="<?php echo $valueButtonAnnulla ?>"/>
                                    <input type="button" onclick="javascript:AggiornaCalcoli();" value="<?php echo $valueButtonAggiorna ?>" />
                                    <?php if (!$errore) { ?>
                                        <input type="button" onclick="javascript:Carica();" value="<?php echo $valueButtonSalva ?>" />
    <?php } ?> 
                                </td>
                            </tr>  
                        </table>
                        <?php
                    }//End Aggiornamento
                    ?>
                </form>
            </div>

            <div id="msgLog">
                <?php
                if ($DEBUG) {
                    echo "</br>Tab prodotto : Utenti e aziende visibili " . $strUtentiAziendeProd;
                    echo "</br>Tab formula : Utenti e aziende visibili " . $strUtentiAziendeForm;
                    echo "</br>Tab categoria : Utenti e aziende visibili " . $strUtentiAziendeForm;
                    echo "</br>Tab componente : Utenti e aziende visibili " . $strUtentiAziendeComp;
                    echo "</br>Tab mazzetta : Utenti e aziende visibili " . $strUtentiAziendeMaz;
                    echo "</br>Tab gruppo : Utenti e aziende visibili " . $strUtAzGruppo;
                    echo "</br>Tabella prodotto: AZIENDE SCRIVIBILI: ";
                    for ($i = 0; $i < count($arrayAziendeScrivibili); $i++) {

                        echo $arrayAziendeScrivibili[$i]->getIdAzienda() . " " . $arrayAziendeScrivibili[$i]->getNomeAzienda() . "</br>";
                    }
                }
                ?>
            </div>
        </div><!--mainContainer-->
    </body>
</html>
