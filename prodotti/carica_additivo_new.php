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
            document.forms["InserisciProdotto"].action = "carica_additivo_new2.php";
            document.forms["InserisciProdotto"].submit();
        }
        function AggiornaCalcoli() {
            document.forms["InserisciProdotto"].action = "carica_additivo_new.php";
            document.forms["InserisciProdotto"].submit();
        }

        //Funzioni per la visualizzazione del form relativo alla serie colore
        function visualizzaListBoxSerieEsistente() {
            document.getElementById("SerieEs").style.visibility = "visible";
            document.getElementById("SerieNu").style.visibility = "hidden";

        }
        function visualizzaFormNuovaSerie() {
            document.getElementById("SerieEs").style.visibility = "hidden";
            document.getElementById("SerieNu").style.visibility = "visible";

        }
    </script>
    <script language="javascript" src="../js/visualizza_elementi.js"></script>

    <?php
    if ($DEBUG)
        ini_set("display_errors", "1");

    //###### VERIFICA PERMESSO VISUALIZZAZIONE SESTO LIVELLO GRUPPI ############
    $actionOnLoad = "";
    $elencoFunzioni = array("149");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);

    //############# STRINGHE UTENTI - AZIENDE VISIBILI #########################

    $strUtentiAziendeProd = getStrUtAzVisib($_SESSION['objPermessiVis'], 'prodotto');
    $strUtentiAziendeForm = getStrUtAzVisib($_SESSION['objPermessiVis'], 'formula');
    $strUtentiAziendeComp = getStrUtAzVisib($_SESSION['objPermessiVis'], 'componente');
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
            include('../sql/script_codice.php');

            $Pagina = "carica_additivo_new";

            begin();
            $sqlCodProdotto = selectCodFormulaNotInProdotto($strUtentiAziendeForm);
                    
            $sqlParProd = findAllParametriProd("id_par_prod");
            $sqlParGlob = findParGlobMac();
           
            $sqlSereAdditivo = findAllSerieVisibiliAbilitati("serie_additivo","serie_additivo", $strUtentiAziendeProd);

            $strTipoColore = "";
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

                    default:
                        break;
                }
            }

            $sqlComponente = selectCompVisByDizionarioAndTipo2($strUtentiAziendeComp, "descri_componente", $_SESSION['lingua'], $valTipo2Additivo);
            commit();

//##############################################################################
//##################### ANAGRAFE DEL PRODOTTO ##################################
//##############################################################################
//Se il nome prodotto  non sono stati settati 
//allora viene visualizzata la form di inserimento vuota
            if (!isset($_POST['NomeProdotto'])) {

//##############################################################################
//################## GENERAZIONE DEL CODICE FORMULA ############################
//##############################################################################
//TODO: gestire codice famiglia
                $codiceFamiglia = $valFamigliaAdditivoDefault;
                $_SESSION['CodiceProdotto'] = calcolaNuovoCodiceProdotto($codiceFamiglia, $valPrimaLetteraCod);
                $_SESSION['CodiceFormula'] = $valPrimaLetteraCod . $_SESSION['CodiceProdotto'];
                

//#################### FINE GENERAZIONE CODICE FORMULA #########################
                ?>

                <div id="container" style="width:1300px; margin:15px auto;">
                    <form id="InserisciProdotto" name="InserisciProdotto" method="post" >
                        <table width="100%" >
                            <tr>
                                <td  colspan="6" class="cella1" style="text-align: center"><b><?php echo $titoloNewRicettaAdditivo ?></b></td>
                            </tr>
                            <tr>
                                <td class="cella4" width="400px" ><?php echo $filtroCodice ?></td>
                                <td class="cella4"><?php echo $_SESSION['CodiceProdotto'] ?></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroNome ?> </td>
                                <td class="cella4"><input type="text" name="NomeProdotto" id="NomeProdotto" size="50"/></td>
                            </tr>
                           
                            <!--TO DO inserire par glob FCO per indicare famiglia di colori-->
                            <tr>
                                <td class="cella4"><?php echo $filtroSerieAdditivo ?></td>
                                <td class="cella4">

                                    <table  width="100%">
                                        <tr>
                                            <td class="cella4">
                                                <input type="radio" id="scegli_serie" name="scegli_serie" onclick="javascript:visualizzaListBoxSerieEsistente();" value="SerieEs" checked="checked"/><?php echo $filtroLabEsistente ?></td>
                                            <td class="cella4">

                                                <div id="SerieEsistente" >
                                                    <select id="SerieEs" name="SerieEs">
                                                        <option value="" selected=""><?php echo $labelOptionSelectAdditivo ?> </option>
                                                        <?php while ($rowSerieAdd = mysql_fetch_array($sqlSereAdditivo)) { ?>
                                                            <option value="<?php echo($rowSerieAdd['serie_additivo']) ?>"><?php echo($rowSerieAdd['serie_additivo']) ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div></td>
                                        </tr>
                                        <tr>
                                            <td class="cella4" >
                                                <input type="radio" id="scegli_serie" name="scegli_serie" onclick="javascript:visualizzaFormNuovaSerie();" value="SerieNu" /><?php echo $filtroLabNuova ?></td>
                                            <td class="cella4"  >
                                                <div id="SerieNuova" style="visibility:hidden;">
                                                    <input type="text" name="SerieNu" id="SerieNu" size="50" style="text-transform: uppercase;" placeholder="<?php echo $filtroInserireNomeSerie ?>"/>

                                                </div></td>
                                        </tr> 
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroGeografico ?></td>
                                <td class="cella4"><?php include('./moduli/visualizza_form_geografico.php'); ?></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroGruppoAcquisto ?></td>
                                <td class="cella4"><?php include('./moduli/visualizza_form_gruppo.php'); ?></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroAzienda ?></td>
                                <td class="cella4">
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
                                <td class="cella1" width="400px"><?php echo $filtroAdditivi ?></td>
                                <td class="cella1"><?php echo $filtroMetodoPesa ?></td>
                                <td class="cella1"><?php echo $filtroOrdineDosaggio ?></td>
                                <td class="cella1"><?php echo $filtroTollEcc ?></td>
                                <td class="cella1"><?php echo $filtroTollDif ?></td>
                                <td class="cella1"><?php echo $filtroFluidificazione ?></td>
                                <td class="cella1"><?php echo $filtroQuantita ?></td>
                                <td class="cella1"><?php echo $filtroCostoKilo ?></td>
                            </tr>
                            <?php
                            $PrezzoKilo = 0;
                            $PrezzoGrammo = 0;
                            //Visualizzo l'elenco dei componenti presenti nella tabella [componente]
                            $NComp = 1;

                            while ($rowComponente = mysql_fetch_array($sqlComponente)) {
                                ?>
                                <tr>
                                    <td width="400px" class="cella2"><?php echo($rowComponente['descri_componente']) ?></td>
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
                                    <td class="cella2"><nobr><input size="8px" type="text" name="Fluidificazione<?php echo($NComp); ?>" id="Fluidificazione<?php echo($NComp); ?>" value="0" /> <?php echo $filtrogBreve ?></nobr></td>
                                    <td class="cella2"><nobr><input size="10px" type="text" name="Qta<?php echo($NComp); ?>" id="Qta<?php echo($NComp); ?>" value="0" /> <?php echo $filtrogBreve ?></nobr></td>
                                    <td class="cella2"><nobr><?php echo $PrezzoKilo . " " . $filtroEuro ?></nobr></td>                                        
                                </tr>
        <?php
        $NComp++;
    }//End While componenti
    ?>
                        </table>

                        <!--
                        ##############################################################################
                        ##################### PARAMETRI PRODOTTO #####################################
                        ##############################################################################-->

    <?php
    while ($rowPar = mysql_fetch_array($sqlParProd)) {
        ?>
                               
                                   <input type="hidden" style="width:90%" name="Valore<?php echo($rowPar['id_par_prod']); ?>" id="Valore<?php echo($rowPar['id_par_prod']); ?>" value="<?php echo $rowPar['valore_base'] ?>" />
                                 
        <?php
    }//End While parametri
    ?>
                                    <table width="100%" >
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
   
    list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);


    if (isSet($_POST['NomeProdotto']))
        $NomeProdotto = str_replace("'", "", $_POST['NomeProdotto']);
    if (isSet($_POST['Famiglia']))
        $Famiglia = str_replace("'", "", $_POST['Famiglia']);

    if (isset($_POST['scegli_serie'])) {
        $scegliSerie = $_POST['scegli_serie'];

        if ($scegliSerie == "SerieEs") {
            $SerieAdditivo = $_POST['SerieEs'];
        } else if ($scegliSerie == "SerieNu") {
            $SerieAdditivo = str_replace("'", "''", $_POST['SerieNu']);
        }
    }

    //Inizializzo la variabile errore relativa ai campi delle tbelle prodotto e anagrafe_prodotto
    $errore = false;
    //Inizializzo la variabile che conta il numero di errori sulle quantita 
    $NumErrore = 0;

    //Gestione degli errori relativa all'aggiornamento dei campi del prodotto
    include('./include/controllo_input_integrazioni.php');

    $messaggio = $messaggio . ' ' . $msgErrNellaPag;

    if (!$errore) {
        echo '<div id="container">' . $msgInfoDatiCorretti . '</div>';
    }

    if ($errore) {
        echo '<div id="msgErr">' . $messaggio . '</div>';
    }
    ?>

                <div id="container" style="width:1200px; margin:15px auto;">
                    <form id="InserisciProdotto" name="InserisciProdotto" method="post">
                        <table width="100%">
                            <tr>
                                <td colspan="6" class="cella1" style="text-align: center"><b><?php echo $titoloNewRicettaAdditivo ?></b></td>
                            </tr>
                            <tr>
                                <td class="cella4" width="400px" ><?php echo $filtroCodice ?> </td>
                                <td class="cella4"><?php echo $_SESSION['CodiceProdotto'] ?></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroNome ?> </td>
                                <td class="cella4"><input type="text" name="NomeProdotto" id="NomeProdotto" size="50" value="<?php echo $NomeProdotto; ?>"/></td>
                            </tr>
                           

                            <tr>
                                <td class="cella4"><?php echo $filtroSerieAdditivo ?></td>
                                <td class="cella4">


    <?php if ($scegliSerie == 'SerieEs') { ?>

                                        <table  width="100%">
                                            <tr>
                                                <td class="cella4">
                                                    <input type="radio" id="scegli_serie" name="scegli_serie" onclick="javascript:visualizzaListBoxSerieEsistente();" value="SerieEs" checked="checked"/><?php echo $filtroLabEsistente ?></td>
                                                <td class="cella4">

                                                    <div id="SerieEsistente" >
                                                        <select id="SerieEs" name="SerieEs">
                                                            <option value="<?php echo $SerieAdditivo ?>" selected="<?php echo $SerieAdditivo ?>"><?php echo $SerieAdditivo ?> </option>
        <?php while ($rowSerieAdd = mysql_fetch_array($sqlSereAdditivo)) { ?>
                                                                <option value="<?php echo($rowSerieAdd['serie_additivo']) ?>"><?php echo($rowSerieAdd['serie_additivo']) ?></option>
        <?php } ?>
                                                        </select>
                                                    </div></td>
                                            </tr>
                                            <tr>
                                                <td class="cella4" >
                                                    <input type="radio" id="scegli_serie" name="scegli_serie" onclick="javascript:visualizzaFormNuovaSerie();" value="SerieNu" /><?php echo $filtroLabNuova ?></td>
                                                <td class="cella4"  >
                                                    <div id="SerieNuova" style="visibility:hidden;">
                                                        <input type="text" name="SerieNu" id="SerieNu" size="50" style="text-transform: uppercase;" placeholder="<?php echo $filtroInserireNomeSerie ?>"/>

                                                    </div></td>
                                            </tr> 
                                        </table>


    <?php } else if ($scegliSerie == 'SerieNu') { ?>

                                        <table  width="100%">
                                            <tr>
                                                <td class="cella4">
                                                    <input type="radio" id="scegli_serie" name="scegli_serie" onclick="javascript:visualizzaListBoxSerieEsistente();" value="SerieEs" checked="checked"/><?php echo $filtroLabEsistente ?></td>
                                                <td class="cella4">

                                                    <div id="SerieEsistente" style="visibility:hidden;">
                                                        <select id="SerieEs" name="SerieEs">
                                                            <option value="" selected=""><?php echo $labelOptionSelectSerie ?> </option>
        <?php while ($rowSerieAdd = mysql_fetch_array($sqlSereAdditivo)) { ?>
                                                                <option value="<?php echo($rowSerieAdd['serie_additivo']) ?>"><?php echo($rowSerieAdd['serie_additivo']) ?></option>
        <?php } ?>
                                                        </select>
                                                    </div></td>
                                            </tr>
                                            <tr>
                                                <td class="cella4" >
                                                    <input type="radio" id="scegli_serie" name="scegli_serie" onclick="javascript:visualizzaFormNuovaSerie();" value="SerieNu" checked="checked" /><?php echo $filtroLabNuova ?></td>
                                                <td class="cella4"  >
                                                    <div id="SerieNuova" >
                                                        <input type="text" name="SerieNu" id="SerieNu" size="50" style="text-transform: uppercase;" value="<?php echo $SerieAdditivo ?>"/>

                                                    </div></td>
                                            </tr> 
                                        </table>
    <?php } ?>

                                </td>                                
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroGeografico ?></td>
                                <td class="cella4"><?php include('./moduli/visualizza_form_modifica_geografico.php'); ?></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroGruppoAcquisto ?></td>
                                <td class="cella4"><?php include('./moduli/visualizza_form_modifica_gruppo.php'); ?></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroAzienda ?></td>
                                <td class="cella4">
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
                                <td class="cella1" width="400px"><?php echo $filtroAdditivi ?></td>
                                <td class="cella1"><?php echo $filtroMetodoPesa ?></td>
                                <td class="cella1"><?php echo $filtroOrdineDosaggio ?></td>
                                <td class="cella1"><?php echo $filtroTollEcc ?></td>
                                <td class="cella1"><?php echo $filtroTollDif ?></td>
                                <td class="cella1"><?php echo $filtroFluidificazione ?></td>
                                <td class="cella1"><?php echo $filtroQuantita ?></td>
                                <td class="cella1"><?php echo $filtroCostoKilo ?></td>
                                <td class="cella1"><?php echo $filtroCosto ?></td>
                            </tr>

    <?php
    //Visualizzo l'elenco dei componenti presenti nella tabella [componente]
    $PrezzoKilo = 0;
    $Prezzo = 0;
    $NComp = 1;
    $PrezzoTotale = 0;
    $QtaTotComp = 0;
    mysql_data_seek($sqlComponente, 0);

    while ($rowComponente = mysql_fetch_array($sqlComponente)) {

        $QtaTotComp = $QtaTotComp + $_POST['Qta' . $NComp];
        ?>
                                <tr>
                                    <td width="400px" class="cella2"> <?php echo($rowComponente['descri_componente']) ?></td>
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
                                    <td class="cella2"><nobr><input size="8px" type="text" name="Fluidificazione<?php echo($NComp); ?>" id="Fluidificazione<?php echo($NComp); ?>" value="<?php echo $_POST['Fluidificazione' . $NComp]; ?>" /> <?php echo $filtrogBreve ?></nobr></td>
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

                                    <td class="cella2"><nobr><input size=10pxtype="text" name="Qta<?php echo($NComp); ?>" id="Qta<?php echo($NComp); ?>" value="<?php echo $_POST['Qta' . $NComp]; ?>" /><?php echo $filtrogBreve ?></nobr></td>
                                    <td class="cella2"><nobr><?php echo $PrezzoKilo . " " . $filtroEuro ?></nobr></td>
                                    <td class="cella2"><nobr><?php echo $Prezzo . " " . $filtroEuro ?></nobr></td>	
                                </tr>
                                    <?php
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
                        
    <?php
    while ($rowPar = mysql_fetch_array($sqlParProd)) {
        
        
        ?>
                               
                                   <input style="width:90%" type="hidden" name="Valore<?php echo($rowPar['id_par_prod']); ?>" id="Valore<?php echo($rowPar['id_par_prod']); ?>" value="<?php echo $_POST['Valore' . $rowPar['id_par_prod']]; ?>"  />
                                   
        <?php
    }//End While parametri
    ?>
                                    <table width="100%" >
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
