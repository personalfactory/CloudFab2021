<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <script language="javascript">
        function Modifica() {
            document.forms["ModificaProdotto"].action = "modifica_prodotto2.php";
            document.forms["ModificaProdotto"].submit();
        }
        function AggiornaCalcoli() {
            document.forms["ModificaProdotto"].action = "modifica_prodotto.php";
            document.forms["ModificaProdotto"].submit();
        }
        function Duplica() {
            document.forms["ModificaProdotto"].action = "duplica_prodotto.php";
            document.forms["ModificaProdotto"].submit();
        }

        function disabilitaOperazioni() {

            document.getElementById('Aggiungi').disabled = true;
            document.getElementById('Aggiorna').disabled = true;

            for (i = 0; i < document.getElementsByName('SostituisciComp').length; i++) {
                document.getElementsByName('SostituisciComp')[i].removeAttribute('href');
            }
            for (i = 0; i < document.getElementsByName('DisabilitaComp').length; i++) {
                document.getElementsByName('DisabilitaComp')[i].removeAttribute('href');
            }
        }

    </script> 
    <script language="javascript" src="../js/visualizza_elementi.js"></script>
    <?php
    if ($DEBUG)
        ini_set("display_errors", "1");

    include('../include/precisione.php');
    include('../include/funzioni.php');
    include('../Connessioni/serverdb.php');
    include('../sql/script.php');
    include('../sql/script_prodotto.php');
    include('../sql/script_categoria.php');
   // include('../sql/script_componente_prodotto.php');
    include('../sql/script_comune.php');
    include('../sql/script_gruppo.php');
//    include('../sql/script_materia_prima.php');
    include('../laboratorio/sql/script_lab_materie_prime.php');
    include('../sql/script_mazzetta.php');
    include('../sql/script_valore_prodotto.php');

    include('../sql/script_componente_pesatura.php');
    include('../sql/script_parametro_glob_mac.php');

    $Pagina = "modifica_prodotto";
    //######################################################################
    //#################### GESTIONE UTENTI #################################
    //######################################################################      
    //############# VERIFICA PERMESSO DI SCRITTURA E MODIFICA ##############
    //Si recupera il proprietario del prodotto e si verifica se l'utente 
    //corrente ha il permesso di editare  i dati di quell'utente proprietario 
    //nella tabella prodotto contenente i filtri id_utente e id_azienda
    //Se non ha il permesso bisogna disabilitare i pulsanti di salvataggio...
    //Si verifica inoltre il permesso di visualizzare il sesto livello dei gruppi
    $actionOnLoad = "";
    $elencoFunzioni = array("96");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);
    //############# STRINGHE AZIENDE VISIBILI  #############################
    //Stringhe contenenti l'elenco degli id delle aziende visibili dall'utente loggato
    //per ogni tabella
    $strUtentiAziendeMaz = getStrUtAzVisib($_SESSION['objPermessiVis'], 'mazzetta');
    $strUtentiAziendeCat = getStrUtAzVisib($_SESSION['objPermessiVis'], 'categoria');
    $strUtAzGruppo = getStrUtAzVisib($_SESSION['objPermessiVis'], 'gruppo');
    $strUtentiAziendeProd = getStrUtAzVisib($_SESSION['objPermessiVis'], 'prodotto');

    //Array contenente le aziende di cui l'utente può editare i dati nella tabella prodotto
    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'prodotto');

    //##########################################################################   

    $sqlParGlob = findParGlobMac();
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



    if (!isset($_POST['IdProdotto']) && isset($_GET['Prodotto'])) {
//Vuol dire che l'id_prodotto proviene dalla pagina di visualizzazione prodotti 
//NON E' UN AGGIORNAMENTO della stesso script
        $IdProdotto = $_GET['Prodotto'];
        $CodProdottoPadre = "";
        //visualizzo il record che intendo modificare all'interno del form
        //estraggo i dati del prodotto da modificare dalle tabelle prodotto e anagrafe prodotto
        $sqlProdotto = findAllDatiProdottoById($IdProdotto);

        while ($rowProdotto = mysql_fetch_array($sqlProdotto)) {
            $CodiceProdotto = $rowProdotto['cod_prodotto'];
            $NomeProdotto = $rowProdotto['nome_prodotto'];
            $IdProdottoPadre = $rowProdotto['colorato'];
            $LimiteColore = $rowProdotto['lim_colore'];
            $FattoreDivisore = $rowProdotto['fattore_div'];
            $Fascia = $rowProdotto['fascia'];
            $IdMazzetta = $rowProdotto['id_mazzetta'];
            $CodMazzetta = $rowProdotto['cod_mazzetta'];
            $NomeMazzetta = $rowProdotto['nome_mazzetta'];
            $Geografico = $rowProdotto['geografico'];
            $TipoRiferimento = $rowProdotto['tipo_riferimento'];
            $Gruppo = $rowProdotto['gruppo'];
            $LivelloGruppo = $rowProdotto['livello_gruppo'];
            $IdCategoria = $rowProdotto['id_cat'];
            $NomeCategoria = $rowProdotto['nome_categoria'];
            $ProdAbilitato = $rowProdotto['abilitato'];
            $IdAzienda = $rowProdotto['id_azienda'];
            $IdUtenteProp = $rowProdotto['id_utente'];
            $SerieColore = $rowProdotto['serie_colore'];
            $SerieAdditivo = $rowProdotto['serie_additivo'];
        }


        $NomeAzienda = getNomeAziendaById($_SESSION['objUtility'], $IdAzienda);

        $arrayTabelleCoinvolte = array("prodotto");
        if ($IdUtenteProp != $_SESSION['id_utente']) {
            //Se il proprietario del dato è un utente diverso dall'utente 
            //corrente si verifica il permesso 3
            if ($DEBUG)
                echo "</br>Eseguita verifica permesso di tipo 3";
            $actionOnLoad = $actionOnLoad . verificaPermModifica3($_SESSION['objPermessiVis'], $arrayTabelleCoinvolte, $IdUtenteProp, $IdAzienda);
        }

        //######################################################################
        //############ CODICE PRODOTTO PADRE ###################################
        //######################################################################

        if ($IdProdottoPadre == "0") {

            $CodProdottoPadre = $CodiceProdotto;
        } else {

            $sqlProdPadre = findProdottoById($IdProdottoPadre);

            while ($rowProdPadre = mysql_fetch_array($sqlProdPadre)) {

                $CodProdottoPadre = $rowProdPadre['cod_prodotto'];
            }
        }
        begin();
        $sqlMaz = findAllMazzetteDiverseDa($CodMazzetta, "cod_mazzetta", $strUtentiAziendeMaz);
        $sqlCat = findAllCategorieDiverseDa($NomeCategoria, "nome_categoria", $strUtentiAziendeCat);
       // $sqlComponente = selectComponentiByIdProdotto($IdProdotto);
        $sqlValProd = selectValoriProdottoByIdProd($IdProdotto, "v.id_par_prod");
        $sqlCompPesatura = selectCompPesaturaByIdProdotto($IdProdotto);

        $sqlSerieColore = findAllSerieColoreVisAbilDiverseDa($SerieColore, $strUtentiAziendeProd);
        $sqlSerieAdditivo = findAllSerieAdditivoVisAbilDiverseDa($SerieAdditivo, $strUtentiAziendeProd);


        commit();
        //######################################################################
        ?>
        <body onLoad="<?php echo $actionOnLoad ?>">
            <div id="mainContainer">
                <?php include('../include/menu.php'); ?>
                <div id="container" style="width:1300px; margin:15px auto;">
                    <form id="ModificaProdotto" name="ModificaProdotto" method="post" >
                        <table width="100%" >
                            <input type="hidden" name="IdProdotto" id="IdProdotto" value="<?php echo $IdProdotto; ?>"></input>
                            <input type="hidden" name="IdUtenteProp" id="IdUtenteProp" value="<?php echo $IdUtenteProp; ?>"></input>

                            <input type="hidden" name="GruppoOld" id="GruppoOld" value="<?php echo $Gruppo; ?>"></input>
                            <input type="hidden" name="LivelloGruppoOld" id="LivelloGruppoOld" value="<?php echo $LivelloGruppo; ?>"></input>
                            <input type="hidden" name="GeograficoOld" id="GeograficoOld" value="<?php echo $Geografico; ?>"></input>
                            <input type="hidden" name="TipoRiferimentoOld" id="TipoRiferimentoOld" value="<?php echo $TipoRiferimento; ?>"></input>

                            <tr>
                                <td  colspan="9" class="cella3"><?php echo $titoloPaginaModificaProdotto ?></td>
                            </tr>
                            <tr>
                                <td width="400px" class="cella4"><?php echo $filtroCodice . " " . $filtroProdotto ?></td>
                                <td  class="cella1"><input name="CodiceProdotto" type="hidden" id="CodiceProdotto" maxlength="5" 
                                                                        value="<?php echo $CodiceProdotto; ?>"><?php echo $CodiceProdotto; ?></input></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroNome . " " . $filtroProdotto ?></td>
                                <td class="cella1"><input type="text" name="NomeProdotto" size="50" id="NomeProdotto" value="<?php echo $NomeProdotto; ?>"></input></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroCategoria ?></td>
                                <td class="cella1">
                                    <select name="Categoria" id="Categoria">
                                        <option value="<?php echo $IdCategoria . ";" . $NomeCategoria; ?>" selected=""><?php echo $NomeCategoria; ?></option>
                                        <?php while ($row = mysql_fetch_array($sqlCat)) { ?>
                                            <option value="<?php echo($row['id_cat']) . ";" . ($row['nome_categoria']); ?>" title="<?php echo $row['descri_categoria'] ?>"><?php echo($row['nome_categoria']); ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroProdotto . " " . $filtroPadre ?></td>
                                <td class="cella1"><input type="text" name="CodProdottoPadre" id="CodProdottoPadre" size="50" value="<?php echo $CodProdottoPadre ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroLimColore ?></td>
                                <td class="cella1"><input type="text" name="LimiteColore" id="LimiteColore" value="<?php echo $LimiteColore; ?>"></input></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroFattoreDivisore ?></td>
                                <td class="cella1"><input type="text" name="FattoreDivisore" id="FattoreDivisore" value="<?php echo $FattoreDivisore; ?>">
                                    </input></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroFascia ?></td>
                                <td class="cella1"><input type="text" name="Fascia" id="Fascia" value="<?php echo $Fascia; ?>"></input> </td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroMazzetta ?></td>
                                <td class="cella1">
                                    <select name="Mazzetta" id="Mazzetta">
                                        <option value="<?php echo $IdMazzetta . ";" . $NomeMazzetta . ';' . $CodMazzetta; ?>" selected=""><?php echo $NomeMazzetta; ?></option>
                                        <?php
                                        while ($row = mysql_fetch_array($sqlMaz)) {
                                            ?>
                                            <option value="<?php echo($row['id_mazzetta']) . ';' . ($row['nome_mazzetta']) . ';' . ($row['cod_mazzetta']); ?>"><?php echo($row['nome_mazzetta']) ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>

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
                                        //Si selezionano solo le aziende scrivibili dall'utente
                                        for ($a = 0; $a < count($arrayAziendeScrivibili); $a++) {
                                            $idAz = $arrayAziendeScrivibili[$a]->getIdAzienda();
                                            $nomeAz = $arrayAziendeScrivibili[$a]->getNomeAzienda();
                                            if ($idAz <> $IdAzienda) {
                                                ?>
                                                <option value="<?php echo( $idAz . ';' . $nomeAz); ?>"><?php echo($nomeAz) ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select> 
                                </td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroAbilitato ?></td>
                                <td class="cella1"><input type="text" name="ProdAbilitato" id="ProdAbilitato" value="<?php echo $ProdAbilitato; ?>" title="<?php echo $titleAbilitazione ?>"/></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroDtAbilitato ?></td>
                                <td class="cella1"><?php echo maxDataProdotto($IdProdotto); ?></td>
                            </tr>
                        </table>
                        <!--##############################################################-->
                        <!--################### COMPONENTI ###############################-->
                        <!--##############################################################-->
                        <table width="100%">
                            <tr>
                                <td width="500px" class="cella3"><?php echo $filtroMateriaPrima ?></td>
                                <td class="cella3"><?php echo $filtroMetodoPesa ?></td>
                                <td class="cella3"><?php echo $filtroOrdineDosaggio ?></td>
                                <td class="cella3"><?php echo $filtroTollEcc ?></td>
                                <td class="cella3"><?php echo $filtroTollDif ?></td>
                                <td class="cella3"><?php echo $filtroFluidificazione ?></td>
                                <td class="cella3"><?php echo $filtroQuantita ?></td>
                                <td class="cella3"><?php echo $filtroCostoKilo ?></td>
                                <td class="cella3"><?php echo $filtroCosto ?> </td>
                                <td class="cella3"><?php echo $filtroAbilitato ?> </td>
                                <td class="cella3"></td>
                            </tr>
                            <?php
                            //Estraggo i dati dei componenti da modificare dalla tab componente_pesatura	
                            $NComp = 1;
                            $Prezzo = 0;
                            $PrezzoTotale = 0;
                            $QtaTotComp = 0;
                            while ($rowComponente = mysql_fetch_array($sqlCompPesatura)) {
                                if ($rowComponente['comp_abilitato'] == $valAbilitato) {
                                    $QtaTotComp = $QtaTotComp + $rowComponente['quantita'];
                                }
                                ?>
                                <tr>
                                    <td class="cella4"><?php echo($rowComponente['descri_componente']); ?></td>
                                    <td class="cella1">
                                        <select name="MetodoPesa<?php echo($NComp); ?>" id="MetodoPesa<?php echo($NComp); ?>">
                                            <option value="<?php echo $rowComponente['metodo_pesa'] ?>" selected="<?php echo $rowComponente['metodo_pesa'] ?>"><?php echo $rowComponente['metodo_pesa'] ?></option>
                                            <option value="<?php echo $valMetodoPesaSilo ?>" selected="<?php echo $valMetodoPesaSilo ?>"><?php echo $valMetodoPesaSilo ?></option>
                                            <option value="<?php echo $valMetodoPesaManual ?>" > <?php echo $valMetodoPesaManual ?></option>

                                        </select>
                                    </td>
                                    <td class="cella1"><input size="8px" type="text" name="OrdineDos<?php echo($NComp); ?>" id="OrdineDos<?php echo($NComp); ?>" value="<?php echo($rowComponente['ordine_dosaggio']); ?>" /></td>
                                    <?php
                                    //Inizio prezzo
                                    $sqlPrezzo = findLabMatPrimaByCodice($rowComponente['cod_componente']);
//                                            findMatPrimaByCodice($rowComponente['cod_componente']);

                                    $PrezzoUnitario = 0;
                                    $PrezzoKilo = 0;
                                    $Prezzo = 0;
                                    while ($rowPrezzo = mysql_fetch_array($sqlPrezzo)) {
                                        $PrezzoUnitario = 0;
                                        $PrezzoKilo = 0;
                                        $Prezzo = 0;
                                        if ($rowPrezzo['prezzo'] > 0) {
                                            $PrezzoKilo = $rowPrezzo['prezzo'];
                                            $PrezzoUnitario = $rowPrezzo['prezzo'] / 1000;
                                            $Prezzo = number_format(($rowComponente['quantita']) * ($PrezzoUnitario), 4);
                                        }
                                        $PrezzoTotale = $PrezzoTotale + $Prezzo;
                                    }
                                    ?>
                                    <td class="cella1"><input size="8px" type="text" name="TollEcc<?php echo($NComp); ?>" id="TollEcc<?php echo($NComp); ?>" value="<?php echo($rowComponente['toll_eccesso']); ?>" /></td>
                                    <td class="cella1"><input size="8px" type="text" name="TollDif<?php echo($NComp); ?>" id="TollDif<?php echo($NComp); ?>" value="<?php echo($rowComponente['toll_difetto']); ?>" /></td>
                                    <td class="cella1"><input size="8px" type="text" name="Fluidificazione<?php echo($NComp); ?>" id="Fluidificazione<?php echo($NComp); ?>" value="<?php echo($rowComponente['valore_residuo_fluidificazione']); ?>" /> <?php echo $filtrogBreve ?></td>
                                    <td class="cella1"><nobr><input size="10px" type="text" name="Qta<?php echo($NComp); ?>" id="Qta<?php echo($NComp); ?>" value="<?php echo($rowComponente['quantita']); ?>" /> <?php echo $filtrogBreve ?></nobr></td>
                                    <td class="cella1"><nobr><?php echo $PrezzoKilo . " " . $filtroEuro ?></nobr></td>   
                                    <td class="cella1"><nobr><?php echo $Prezzo . " " . $filtroEuro ?></nobr></td>   
                                    <td class="cella1"><?php echo($rowComponente['comp_abilitato']); ?></td>
                                         	
                                        
                                        <input size="3px" type="hidden" name="CompAbilitato<?php echo($NComp); ?>" id="CompAbilitato<?php echo($NComp); ?>"  value="<?php echo($rowComponente['comp_abilitato']); ?>"/>
                                    <td class="cella1"><nobr>
                                        <?php if($rowComponente['comp_abilitato']==$valAbilitato){?>
                                            <a href="disabilita_componente_nel_prodotto.php?IdProdotto=<?php echo $IdProdotto ?>&IdComponente=<?php echo $rowComponente['id_comp']?>&RefBack=modifica_prodotto.php?Prodotto=<?php echo $IdProdotto ?>">
                                <img src="/CloudFab/images/pittogrammi/patumiera_G.png" class="icone"  title="<?php echo $titleDisabilita ?>"/></a>
                            <?php } else if($rowComponente['comp_abilitato']==$valDisabilitato){?>
                                         <a href="abilita_componente_nel_prodotto.php?IdProdotto=<?php echo $IdProdotto ?>&IdComponente=<?php echo $rowComponente['id_comp']?>&RefBack=modifica_prodotto.php?Prodotto=<?php echo $IdProdotto ?>">
                                <img src="/CloudFab/images/pittogrammi/icon_list.png" class="icone"  title="<?php echo $titleAbilitaComp ?>"/></a>    
                                            
                            <?php } ?>
                                            <a name="SostituisciComp" href="sostituisci_componente_prodotto.php?IdComponente=<?php echo($rowComponente['id_comp']); ?>&IdProdotto=<?php echo $IdProdotto ?>&TipoMateriale=1">
                                                <img src="/CloudFab/images/pittogrammi/componenti_R.png" class="icone" title="<?php echo $titleSostituisciComp ?>"/></a>  	 
                                            <a name="ComponentiAlternativi" href="definisci_componenti_alternativi.php?IdComponente=<?php echo($rowComponente['id_comp']); ?>&IdProdotto=<?php echo $IdProdotto ?>&NomeProd=<?php echo $NomeProdotto ?>">
                                                <img src="/CloudFab/images/pittogrammi/componenti_G.png" class="icone" title="<?php echo $titleDefinisciCompAlternativi ?>"/></a>  	 
                                        </nobr>

                                                      <!-- <a name="DisabilitaComp" href="disabilita_record.php?Tabella=componente_prodotto&IdRecord=<?php echo $rowComponente['id_comp_prod'] ?>&RefBack=modifica_prodotto.php?Prodotto=<?php echo $IdProdotto ?>">
                                                            <img src="/CloudFab/images/pittogrammi/patumiera_G.png" class="icone"  title="<?php echo $titleDisabilitaComp ?>"/></a></td>	  -->    
                                    </td>
                                </tr>
                                <?php
                                $NComp++;
                            }//End While Componenti
                            $QtaTotComp = number_format($QtaTotComp, 2, '.', ' ');
                            ?>
                            <tr>
                                <td class="dataRigWhite" colspan="6"><?php echo $filtroTotali ?></td>
                                <td class="dataRigWhite" colspan="2"><?php echo $QtaTotComp . " " . $filtrogBreve; ?></td>
                                <td class="dataRigWhite" ><?php echo $PrezzoTotale . " " . $filtroEuro ?></td>
                                <td class="dataRigWhite" colspan="2"></td>
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
                            while ($rowPar = mysql_fetch_array($sqlValProd)) {
                                ?>
                                <tr>
                                    <td width="30%" class="cella4" title="<?php echo($rowPar['descri_variabile']) ?>"><?php echo($rowPar['nome_variabile']) ?></td>
                                    <td width="40%" class="cella4"><?php echo($rowPar['descri_variabile']) ?></td>
                                    <td width="15%" class="cella1"><input style="width:90%" type="text" name="Valore<?php echo($rowPar['id_val_pr']); ?>" id="Valore<?php echo($rowPar['id_val_pr']); ?>" value="<?php echo $rowPar['valore_variabile'] ?>"  /></td>
                                    <td width="15%" class="cella1"><?php echo $rowPar['uni_mis'] ?></td>
                                </tr>
                                <?php
                            }//End While parametri
                            ?>
                            <tr> 
                                <td class="cella2"  style="text-align: right " colspan="6">
                                    <input type="reset"  onClick="javascript:history.back();" value="<?php echo $valueButtonAnnulla ?>"/>
                                    <input type="button" id="Aggiungi" name="Aggiungi" onClick="location.href = 'aggiungi_componente_prodotto.php?IdProdotto=<?php echo $IdProdotto; ?>&TipoMateriale=1'" title="<?php echo $titleAggiungiComp ?>"  value="<?php echo $valueButtonAggiungiComp ?>" />
                  <!--                  <input type="button" onclick="javascript:Duplica();" value="DUPLICA" />-->
                                    <input type="button" id="Aggiorna" name="Aggiorna" onClick="javascript:AggiornaCalcoli();" value="<?php echo $valueButtonAggiorna ?>" />
                    <!--                 <input type="button" onclick="javascript:Modifica();" value="SALVA" />-->
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>     	

                <?php
            } else { //Se l'id_prodotto non è arrivato tramite get ma tramite POST
//##############################################################################	
//////////////////////INIZIO AGGIORNAMENTO//////////////////////////////////////
//##############################################################################  
                $IdProdotto = $_POST['IdProdotto'];

                //Gruppo e rif geo prima della modifica
                //Utili per la generazione dei valori par prod mac
                $TipoRiferimentoOld = $_POST['TipoRiferimentoOld'];
                $LivelloGruppoOld = $_POST['LivelloGruppoOld'];
                $GeograficoOld = $_POST['GeograficoOld'];
                $GruppoOld = $_POST['GruppoOld'];
                //################################################
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
//          $Gruppo = $_POST['SestoLivello'];
                    $Gruppo = "Universale";
                }

                $CodiceProdotto = str_replace("'", "", $_POST['CodiceProdotto']);
                $NomeProdotto = str_replace("'", "", $_POST['NomeProdotto']);
                $CodProdottoPadre = str_replace("'", "", $_POST['CodProdottoPadre']);
                $LimiteColore = str_replace("'", "", $_POST['LimiteColore']);
                $FattoreDivisore = str_replace("'", "", $_POST['FattoreDivisore']);
                $Fascia = str_replace("'", "", $_POST['Fascia']);
                $PostMazzetta = str_replace("'", "", $_POST['Mazzetta']);
                $Geografico = str_replace("'", "", $Geografico);
                $Gruppo = str_replace("'", "", $Gruppo);
                $Categoria = str_replace("'", "", $_POST['Categoria']);
                $ProdAbilitato = str_replace("'", "", $_POST['ProdAbilitato']);


                $SerieColore = $serieColoreDefault;
                $SerieAdditivo = $serieAdditivoDefault;

                if (isSet($_POST['SerieColore']))
                    $SerieColore = str_replace("'", "", $_POST['SerieColore']);
                if (isSet($_POST['SerieAdditivo']))
                    $SerieAdditivo = str_replace("'", "", $_POST['SerieAdditivo']);


                list($Mazzetta, $NomeMazzetta, $CodMazzetta) = explode(';', $PostMazzetta);
                list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);
                $IdUtenteProp = $_POST['IdUtenteProp'];
                //STUDIARE
//Inizializzo la variabile errore relativa ai campi delle tabelle prodotto e anagrafe_prodotto
                $errore = false;
                //Inizializzo la variabile che conta il numero di errori fatti sui campi quantita e presa
                $NumErrore = 0;

                //Gestione degli errori relativa all'aggiornamento dei campi del prodotto
                include('./include/controllo_input_prodotto.php');
                if ($errore) {
                    $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                    echo '<div id="msgErr">' . $messaggio . '</div>';
                } else {

                    list($Mazzetta, $NomeMazzetta, $CodMazzetta) = explode(';', $PostMazzetta);
                    list($Categoria, $NomeCategoria) = explode(';', $_POST['Categoria']);

                    $sqlMaz = findAllMazzetteDiverseDa($CodMazzetta, "cod_mazzetta", $strUtentiAziendeMaz);
                    $sqlCat = findAllCategorieDiverseDa($NomeCategoria, "nome_categoria", $strUtentiAziendeCat);
                    //$sqlComponente = selectComponentiByIdProdotto($IdProdotto);
                    $sqlCompPesatura = selectCompPesaturaByIdProdotto($IdProdotto);

                    $sqlValProd = selectValoriProdottoByIdProd($IdProdotto, "v.id_par_prod");

                    $sqlSerieColore = findAllSerieColoreVisAbilDiverseDa($SerieColore, $strUtentiAziendeProd);
                    $sqlSerieAdditivo = findAllSerieAdditivoVisAbilDiverseDa($SerieAdditivo, $strUtentiAziendeProd);
                    ?>
                    <body onLoad="<?php echo $actionOnLoad ?>">
                        <div id="mainContainer">

        <?php include('../include/menu.php'); ?>
                            <div id="container" style="width:1300px; margin:15px auto;">
                                <form id="ModificaProdotto" name="ModificaProdotto" method="post" >
                                    <table width="100%" >
                                        <tr>
                                            <td  colspan="2" class="cella3"><?php echo $titoloPaginaModificaProdotto ?></td>
                                        </tr>
                                        <input type="hidden" name="IdUtenteProp" id="IdUtenteProp" value="<?php echo $IdUtenteProp; ?>"></input>
                                        <input type="hidden" name="IdProdotto" id="IdProdotto" value=<?php echo $IdProdotto; ?>></input>
                                        <input type="hidden" name="GruppoOld" id="GruppoOld" value="<?php echo $GruppoOld; ?>"></input>
                                        <input type="hidden" name="LivelloGruppoOld" id="LivelloGruppoOld" value="<?php echo $LivelloGruppoOld; ?>"></input>
                                        <input type="hidden" name="GeograficoOld" id="GeograficoOld" value="<?php echo $GeograficoOld; ?>"></input>
                                        <input type="hidden" name="TipoRiferimentoOld" id="TipoRiferimentoOld" value="<?php echo $TipoRiferimentoOld; ?>"></input>
                                        <tr>
                                            <td width="400px" class="cella4"><?php echo $filtroCodice . " " . $filtroProdotto ?></td>
                                            <td class="cella1"><input name="CodiceProdotto" type="hidden" id="CodiceProdotto" maxlength="5" 
                                                                      value="<?php echo $CodiceProdotto; ?>"><?php echo $CodiceProdotto; ?></input></td>
                                        </tr>
                                        <tr>
                                            <td class="cella4"><?php echo $filtroNome . " " . $filtroProdotto ?></td>
                                            <td class="cella1"><input type="text" name="NomeProdotto" id="NomeProdotto" size="50" value="<?php echo $NomeProdotto; ?>"/></td>
                                        </tr>
                                        <tr>
                                            <td class="cella4"><?php echo $filtroCategoria ?></td>
                                            <td class="cella1">
                                                <select name="Categoria" id="Categoria">
                                                    <option value="<?php echo $Categoria . ";" . $NomeCategoria; ?>" selected><?php echo $NomeCategoria; ?></option>
        <?php
        while ($row = mysql_fetch_array($sqlCat)) {
            ?>
                                                        <option value="<?php echo($row['id_cat']) . ";" . ($row['nome_categoria']); ?>" title="<?php echo $row['descri_categoria'] ?>"><?php echo($row['nome_categoria']); ?></option>
                                                    <?php }//End While select categorie       ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="cella4"><?php echo $filtroProdPadre ?></td>
                                            <td class="cella1"> <input type="text" name="CodProdottoPadre" id="CodProdottoPadre"  value="<?php echo $CodProdottoPadre ?>"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="cella4"><?php echo $filtroLimColore ?></td>
                                            <td class="cella1"><input type="text" name="LimiteColore" id="LimiteColore" value=<?php echo $LimiteColore; ?>></td>
                                        </tr>
                                        <tr>
                                            <td class="cella4"><?php echo $filtroFattoreDivisore ?></td>
                                            <td class="cella1"><input type="text" name="FattoreDivisore" id="FattoreDivisore" value=<?php echo $FattoreDivisore; ?>></td>
                                        </tr>
                                        <tr>
                                            <td class="cella4"><?php echo $filtroFascia ?></td>
                                            <td class="cella1"><input type="text" name="Fascia" id="Fascia" value=<?php echo $Fascia; ?>></td>
                                        </tr>
                                        <tr>
                                            <td class="cella4"><?php echo $filtroMazzetta ?></td>
                                            <td class="cella1">

                                                <select name="Mazzetta" id="Mazzetta">
                                                    <option value="<?php echo $Mazzetta . ';' . $NomeMazzetta . ';' . $CodMazzetta; ?>" selected><?php echo $NomeMazzetta; ?></option>
        <?php
        while ($row = mysql_fetch_array($sqlMaz)) {
            ?>
                                                        <option value="<?php echo($row['id_mazzetta']) . ';' . ($row['nome_mazzetta']) . ';' . ($row['cod_mazzetta']); ?>"><?php echo($row['nome_mazzetta']) ?></option>
                                                    <?php } //End While select mazzetta        ?>
                                                </select></td>
                                        </tr>
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
                                        <tr>
                                            <td class="cella4"><?php echo $filtroAbilitato ?></td>
                                            <td class="cella1"><input type="text" name="ProdAbilitato" id="ProdAbilitato" value="<?php echo $ProdAbilitato; ?>" title="<?php echo $titleAbilitazione ?>"></input></td>
                                        </tr>
                                        <tr>
                                            <td class="cella4"><?php echo $filtroDtAbilitato ?></td>
                                            <td class="cella1"><?php echo maxDataProdotto($IdProdotto); ?></td>
                                        </tr>

                                    </table>              
                                    <table width="100%">
                                        <tr>
                                            <td width="500px" class="cella3"><?php echo $filtroMateriaPrima ?></td>
                                            <td class="cella3"><?php echo $filtroMetodoPesa ?></td>
                                            <td class="cella3"><?php echo $filtroOrdineDosaggio ?></td>
                                            <td class="cella3"><?php echo $filtroTollEcc ?></td>
                                            <td class="cella3"><?php echo $filtroTollDif ?></td>
                                            <td class="cella3"><?php echo $filtroFluidificazione ?></td>
                                            <td class="cella3"><?php echo $filtroQuantita ?></td>
                                            <td class="cella3"><?php echo $filtroCostoKilo ?></td>
                                            <td class="cella3"><?php echo $filtroCosto ?> </td>
                                            <td class="cella3"><?php echo $filtroAbilitato ?> </td>
                                            <td class="cella3"></td>
                                        </tr>
        <?php
        //Visualizzo l'elenco dei componenti presenti nella tabella componente
        $NComp = 1;
        $PrezzoTotale = 0;
        $PrezzoKilo = 0;
        $Prezzo = 0;
        $QtaTotComp = 0;
        while ($rowComponente = mysql_fetch_array($sqlCompPesatura)) {
            if ($rowComponente['comp_abilitato'] == $valAbilitato) {
                $QtaTotComp = $QtaTotComp + $_POST['Qta' . $NComp];
            }
            ?>
                                            <tr>
                                                <td width="300" class="cella4"> <?php echo($rowComponente['descri_componente']) ?></td>
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
                                                <td class="cella1"><input size="8px" type="text" name="Fluidificazione<?php echo($NComp); ?>" id="Fluidificazione<?php echo($NComp); ?>" value="<?php echo $_POST['Fluidificazione' . $NComp]; ?>" /> <?php echo $filtrogBreve ?></td>

            <?php
            //Inizio prezzo
            $sqlPrezzo = findLabMatPrimaByCodice($rowComponente['cod_componente']);
            //findMatPrimaByCodice($rowComponente['cod_componente']);
            while ($rowPrezzo = mysql_fetch_array($sqlPrezzo)) {
                if ($_POST['Qta' . $NComp] > 0) {
                    $PrezzoKilo = $rowPrezzo['prezzo'];
                    $PrezzoUnitario = $rowPrezzo['prezzo'] / 1000;
                    $Prezzo = number_format(($_POST['Qta' . $NComp]) * ($PrezzoUnitario), 4);
                    $PrezzoTotale = $PrezzoTotale + $Prezzo;
                }
            }//End prezzo
            ?>
                                                <td  class="cella1"><nobr><input size=10pxtype="text" name="Qta<?php echo($NComp); ?>" id="Qta<?php echo($NComp); ?>" value="<?php echo $_POST['Qta' . $NComp]; ?>" /><?php echo $filtrogBreve ?></nobr></td>
                                                <td width="70px" class="cella1"><nobr><?php echo $PrezzoKilo . " " . $filtroEuro ?></nobr></td>
                                                <td width="100px" class="cella1"><nobr><?php echo $Prezzo . " " . $filtroEuro ?></nobr></td>	
                                                <td class="cella1"><?php echo $_POST['CompAbilitato' . $NComp]; ?></td>
                                                    <input type="hidden"  name="CompAbilitato<?php echo($NComp); ?>" id="CompAbilitato<?php echo($NComp); ?>" value="<?php echo $_POST['CompAbilitato' . $NComp]; ?>" />
                                                <td class="cella1">
                                                    
                                                     <nobr>
                                                         <?php if($_POST['CompAbilitato' . $NComp]==$valAbilitato){?>
                                                         <a href="disabilita_componente_nel_prodotto.php?IdProdotto=<?php echo $IdProdotto ?>&IdComponente=<?php echo $rowComponente['id_comp']?>&RefBack=modifica_prodotto.php?Prodotto=<?php echo $IdProdotto ?>">
                                <img src="/CloudFab/images/pittogrammi/patumiera_G.png" class="icone"  title="<?php echo $titleDisabilita ?>"/></a>
                            <?php } else if($_POST['CompAbilitato' . $NComp]==$valDisabilitato){?>
                                         <a href="abilita_componente_nel_prodotto.php?IdProdotto=<?php echo $IdProdotto ?>&IdComponente=<?php echo $rowComponente['id_comp']?>&RefBack=modifica_prodotto.php?Prodotto=<?php echo $IdProdotto ?>">
                                <img src="/CloudFab/images/pittogrammi/icon_list.png" class="icone"  title="<?php echo $titleAbilitaComp ?>"/></a>    
                                            
                            <?php } ?>
                                                         
                                                         
                                                         
                                                         
                                                         
                                                        
                                                    <a name="SostituisciComp" href="sostituisci_componente_prodotto.php?IdComponente=<?php echo($rowComponente['id_comp']); ?>&IdProdotto=<?php echo $IdProdotto ?>&TipoMateriale=1">
                                                            <img src="/CloudFab/images/pittogrammi/componenti_R.png" class="icone" title="<?php echo $titleSostituisciComp ?>"/></a>  
                                                        <a name="ComponentiAlternativi" href="definisci_componenti_alternativi.php?IdComponente=<?php echo($rowComponente['id_comp']); ?>&IdProdotto=<?php echo $IdProdotto ?>&NomeProd=<?php echo $NomeProdotto ?>">
                                                            <img src="/CloudFab/images/pittogrammi/componenti_G.png" class="icone" title="<?php echo $titleDefinisciCompAlternativi ?>"/></a></nobr>
                                                 <!--  <a name="DisabilitaComp" href="disabilita_record.php?Tabella=componente_prodotto&IdRecord=<?php echo $rowComponente['id_comp_prod'] ?>&RefBack=modifica_prodotto.php?Prodotto=<?php echo $IdProdotto ?>">
                                                       <img src="/CloudFab/images/pittogrammi/patumiera_G.png" class="icone" title="<?php echo $titleDisabilitaComp ?>"/></a></td>	      -->
                                            </tr>
            <?php
            $NComp++;
        }//End While Componenti
        mysql_close();
        $QtaTotComp = number_format($QtaTotComp, 2, '.', ' ');
        ?>
                                        <tr>
                                            <td class="dataRigWhite" colspan="6"><?php echo $filtroTotali ?></td>
                                            <td class="dataRigWhite" colspan="2"><?php echo $QtaTotComp . " " . $filtrogBreve; ?></td>
                                            <td class="dataRigWhite" ><?php echo $PrezzoTotale . " " . $filtroEuro ?></td>
                                            <td class="dataRigWhite" colspan="2"></td>

                                        </tr>
                                    </table>
                                    <!--
                    ##########################################################################
                    ##################### PARAMETRI PRODOTTO #################################
                    ##########################################################################-->
                                    <table width="100%" >
                                        <tr>
                                            <td class="cella3"><?php echo $filtroPar ?></td>
                                            <td class="cella3"><?php echo $filtroDescrizione ?></td>
                                            <td class="cella3"><?php echo $filtroValore ?></td>
                                            <td class="cella3"><?php echo $filtroUniMisura ?></td>
                                        </tr>
        <?php
        while ($rowPar = mysql_fetch_array($sqlValProd)) {
            ?>
                                            <tr>
                                                <td width="30%" class="cella4" title="<?php echo($rowPar['descri_variabile']) ?>"><?php echo($rowPar['nome_variabile']) ?></td>
                                                <td width="40%" class="cella4"><?php echo($rowPar['descri_variabile']) ?></td>
                                                <td width="15%" class="cella1"><input style="width:90%" type="text" name="Valore<?php echo($rowPar['id_val_pr']); ?>" id="Valore<?php echo($rowPar['id_val_pr']); ?>" value="<?php echo $_POST['Valore' . $rowPar['id_val_pr']]; ?>" /></td>
                                                <td width="15%" class="cella1"><?php echo $rowPar['uni_mis'] ?></td>
                                            </tr>
            <?php
        }//End While parametri
        ?>
                                        <tr> 
                                            <td class="cella2"  style="text-align: right " colspan="6">
                                                <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                                <input type="button" id="Aggiungi" name="Aggiungi" value="<?php echo $valueButtonAggiungiComp ?>" title="<?php echo $titleAggiungiComp ?>"   onClick="location.href = 'aggiungi_componente_prodotto.php?IdProdotto=<?php echo $IdProdotto; ?>TipoMateriale=1'"/>
                            <!--                    <input type="button" onclick="javascript:Duplica();" value="DUPLICA" />-->
                                                <input type="button" id="Aggiorna" name="Aggiorna" value="<?php echo $valueButtonAggiorna ?>" onClick="javascript:AggiornaCalcoli();"  />
                                                <input type="button" value="<?php echo $valueButtonSalva ?>" onClick="javascript:Modifica();"  />
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
        <?php
    }//End errore
}//End Aggiornamento
?>      


                    <div id="msgLog">
<?php
if ($DEBUG) {
    echo "</br>ActionOnLoad : " . $actionOnLoad;
    echo "</br>Tabella mazzetta : Utenti e aziende visibili : " . $strUtentiAziendeMaz;
    echo "</br>Tabella categoria : Utenti e aziende visibili : " . $strUtentiAziendeCat;
    echo "</br>Tabella gruppo : Utenti e aziende visibili : " . $strUtAzGruppo;
    echo "</br>Id utente prop del dato: " . $IdUtenteProp;
    echo "</br>Id azienda proprietaria del dato: " . $IdAzienda;
    echo "</br>##################################</br>Tabella prodotto:Aziende scrivibili: </br>";

    for ($i = 0; $i < count($arrayAziendeScrivibili); $i++) {

        echo $arrayAziendeScrivibili[$i]->getIdAzienda() . " " . $arrayAziendeScrivibili[$i]->getNomeAzienda() . "</br>";
    }
}
?>
                    </div>
                </div><!--mainContainer-->
            </body>
            </html>
