<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php
    include('../object/OrdineOri.php');
    include('../include/validator.php');
    ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <script language="javascript">
                function Carica() {
                    document.forms["InserisciOrdine"].action = "carica_programma_ori2.php";
                    document.forms["InserisciOrdine"].submit();
                }
                function AggiornaCalcoli() {
                    document.forms["InserisciOrdine"].action = "carica_programma_ori1.php";
                    document.forms["InserisciOrdine"].submit();
                }
            </script>
            <?php
            if ($DEBUG)
                ini_set('display_errors', '1');

            //############# STRINGHE UTENTI - AZIENDE VISIBILI###########################
            //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
            //dall'utente loggato   
            $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'macchina');
            $strUtentiAziendeProd = getStrUtAzVisib($_SESSION['objPermessiVis'], 'prodotto');
            $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'ordine_elenco');

            include('../include/menu.php');

            include('../Connessioni/serverdb.php');
            include('../include/gestione_date.php');
            include('../include/precisione.php');
            include('../include/funzioni.php');

            /////////////////////////////////////////////////////////

            include('../sql/script.php');
            include('../sql/script_macchina.php');
            include('../sql/script_prodotto.php');
            include('../sql/script_mazzetta.php');
            include('../sql/script_categoria.php');
            include('../sql/script_componente_prodotto.php');
            include('../sql/script_componente_pesatura.php');
            include('../sql/script_valore_par_sing_mac.php');
            include('../sql/script_dizionario.php');
            include('../sql/script_componente.php');
            include('../sql/script_parametro_glob_mac.php');

            $Pagina = "carica_programma_ori1";

            //########### FILTRI SULLA VISUALIZZAZIONE MATERIE PRIME ###########
            $_SESSION['IdProdotto'] = "";
            $_SESSION['CodProdotto'] = "";
            $_SESSION['NomeProdotto'] = "";

            if (isset($_POST['IdProdotto'])) {
                $_SESSION['IdProdotto'] = trim($_POST['IdProdotto']);
            }
            if (isset($_POST['CodProdotto'])) {
                $_SESSION['CodProdotto'] = trim($_POST['CodProdotto']);
            }
            if (isset($_POST['NomeProdotto'])) {
                $_SESSION['NomeProdotto'] = trim($_POST['NomeProdotto']);
            }

            $_SESSION['Filtro'] = "cod_prodotto";



//##############################################################################
//#################### INIZIO AGGIORNAMENTO SCRIPT #############################
//##############################################################################  

            $_SESSION['CodProdotto'] = "";
            if (isset($_POST['CodProdotto'])) {
                $_SESSION['CodProdotto'] = trim($_POST['CodProdotto']);
            }
            $_SESSION['NomeProdotto'] = "";
            if (isset($_POST['NomeProdotto'])) {
                $_SESSION['NomeProdotto'] = trim($_POST['NomeProdotto']);
            }

            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);

            $Note = str_replace("'", "''", $_POST['Note']);

            $DtOrdine = $_POST['AnnoOrdine'] . "-" . $_POST['MeseOrdine'] . "-" . $_POST['GiornoOrdine'];

            $valAnno = substr($DtOrdine, 0, 4);
            $valGiorno = substr($DtOrdine, 8, 9);
            $numMese = substr($DtOrdine, 5, -3);
            $valMese = trasformaMeseInLettere($numMese, $arrayFiltroMese);

            $_SESSION['Filtro'] = "cod_prodotto";
            $k = $_POST['k'];


            $defaultCliente = "";
            $parSeparatore = "";
            $parCarSeparazione2="";
            $parIdCompChimica = "";
            $tipoProdotto = "";
            $tipoColore = "";
            $tipoAdditivo = "";


            $sqlParGlob = findParGlobMac();

            while ($rowParGlob = mysql_fetch_array($sqlParGlob)) {

                switch ($rowParGlob['id_par_gm']) {
                    
                    case 22:
                        // _ PARAMETRO SEPARAZIONE 2
                        $parCarSeparazione2 = $rowParGlob['valore_variabile'];
                        break;
                    
                    case 25:
                        //Cliente sconosciutio
                        $parIdCompChimica = $rowParGlob['valore_variabile'];
                        break;

                    case 40:
                        //Cliente sconosciutio
                        $defaultCliente = $rowParGlob['valore_variabile'];
                        break;

                    case 152:
                        //PRODUCT
                        $tipoProdotto = $rowParGlob['valore_variabile'];
                        break;
                    case 153:
                        //COLOR
                        $tipoColore = $rowParGlob['valore_variabile'];
                        break;

                    case 154:
                        //ADDITIVE
                        $tipoAdditivo = $rowParGlob['valore_variabile'];
                        break;

                    case 155:
                        //NONE
                        $serieColoreDefault = $rowParGlob['valore_variabile'];
                        $serieAdditivoDefault = $rowParGlob['valore_variabile'];
                        break;

                    case 156:
                        //,
                        $parSeparatore = $rowParGlob['valore_variabile'];
                        break;

                    default:
                        break;
                }
            }





//############ CONTROLLO INPUT ORDINE ##########################################
            //Inizializzo l'errore relativo ai campi della tabella lab_formula
            $errore = false;
            $messaggio = '';
            if (!isset($_POST['Stabilimento']) || trim($_POST['Stabilimento']) == "") {

                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrCodice . '<br />';
            }

            if ($errore) {
                echo '<div id="msgErr">' . $messaggio . '</div>';
            } else {

                list($IdMacchina, $DescriStab) = explode('-', $_POST['Stabilimento']);

                //################# QUERY AL DB ####################################
                begin();

                $arrayProdPerMac = trovaProdottiAssegnatiAMacchina($IdMacchina);

                $sqlMacchine = findAllMacchineVisAbilitate("descri_stab", $strUtentiAziende);
                $sqlProdotti = findProdottiAssegnatiByFiltri($_SESSION['Filtro'], "id_prodotto", $_SESSION['IdProdotto'], $_SESSION['CodProdotto'], $_SESSION['NomeProdotto'], $arrayProdPerMac, $tipoProdotto, $strUtentiAziendeProd);

                //findAllProdottiByFiltri($_SESSION['Filtro'], "id_prodotto", $_SESSION['IdProdotto'], $_SESSION['CodProdotto'], $_SESSION['NomeProdotto'], $strUtentiAziendeProd);

                commit();





//##############################################################################
//################# CONTROLLO INPUT PRODOTTI ###################################
//##############################################################################

                $NProd = 0;
                $messaggioNumPezzi = "";
                $NumErroreNumPezzi = 0;
                $messaggioOrdineProd = "";
                $NumErroreOrdineProd = 0;

                if (mysql_num_rows($sqlProdotti) > 0)
                    mysql_data_seek($sqlProdotti, 0);
                while ($rowProd = mysql_fetch_array($sqlProdotti)) {

                    $NProd = $rowProd['id_prodotto'];
                    $ordineDiProd = 0;
                    $NumPezzi = 0;

                    if (isset($_POST['NumPezzi' . $NProd])) {
                        list($NumPezzi, $PezzoKg) = explode(';', $_POST['NumPezzi' . $NProd]);
                        $moltiplicatore = 1;
                        if (isSet($_POST['moltiplicatore' . $NProd]))
                            $moltiplicatore = $_POST['moltiplicatore' . $NProd];
                    }

                    //Controllo input quantita prodotti
                    if (!is_numeric($NumPezzi) && $NumPezzi != "") {
                        $NumErroreNumPezzi++;
                        $messaggioNumPezzi = $messaggioNumPezzi . " " . $rowProd['nome_prodotto'] . " : " . $msgErrQtaNumerica . "<br/>";
                    }
                    if ($NumPezzi < 0) {
                        $NumErroreNumPezzi++;
                        $messaggioNumPezzi = $messaggioNumPezzi . " " . $rowProd['nome_prodotto'] . " : " . $msgErrQtaMagZero . "<br/>";
                    }


                    if (isset($_POST['OrdineProduzione' . $NProd])) {

                        $ordineDiProd = $_POST['OrdineProduzione' . $NProd];


                        //Controllo input quantita prodotti
                        if (!is_numeric($ordineDiProd) && $ordineDiProd != "") {
                            $NumErroreOrdineProd++;

                            $messaggioOrdineProd = $messaggioOrdineProd . " " . $rowProd['nome_prodotto'] . " : " . $msgErrQtaNumerica . "<br/>";
                        }
                        if ($ordineDiProd < 0) {
                            $NumErroreOrdineProd++;
                            $messaggioOrdineProd = $messaggioOrdineProd . " " . $rowProd['nome_prodotto'] . " : " . $msgErrQtaMagZero . "<br/>";
                        }
                    }
                }// End While prodotti 
                if ($NumErroreNumPezzi > 0) {
                    echo '<div id="msgErr">' . $messaggioNumPezzi . '</div>';
                }
                if ($NumErroreOrdineProd > 0) {
                    echo '<div id="msgErr">' . $messaggioOrdineProd . '</div>';
                }

                //##########################################################################
                //##############  CREAZIONE OGGETTO ORDINE #################################
                //##########################################################################
                //Recupero i prodotti selezionati
                $NProd = 0;
                if (mysql_num_rows($sqlProdotti) > 0)
                    mysql_data_seek($sqlProdotti, 0);
                while ($rowProdotti = mysql_fetch_array($sqlProdotti)) {

                    $NProd = $rowProdotti['id_prodotto'];

                    $NumPezzi = 0;
                    $PezzoKg = 0;
                    if (isset($_POST['NumPezzi' . $NProd]))
                        list($NumPezzi, $PezzoKg) = explode(';', $_POST['NumPezzi' . $NProd]);


                    $moltiplicatore = 1;
                    if (isSet($_POST['moltiplicatore' . $NProd]) AND $_POST['moltiplicatore' . $NProd] > 1)
                        $moltiplicatore = $_POST['moltiplicatore' . $NProd];

                    if (isset($_POST['OrdineProduzione' . $NProd]))
                        $ordineDiProd = $_POST['OrdineProduzione' . $NProd];

                    $tipoChimica = "false";
                    $descriTipoChimica = $filtroDesKitChimica;
                    if (isSet($_POST['TipoChimica' . $NProd]) AND $_POST['TipoChimica' . $NProd] != "false;$filtroDesKitChimica")
                        list($tipoChimica, $descriTipoChimica) = explode(';', $_POST['TipoChimica' . $NProd]);

                    $tipoConf = "false";
                    $descriTipoConf = $filtroDesConfSacco;
                    if (isSet($_POST['tipoConf' . $NProd]))
                        list($tipoConf, $descriTipoConf) = explode(';', $_POST['tipoConf' . $NProd]);


                    $stringaCompAlternativi = 0;

                    $ribalta = "false";
                    $descriRibalta = "Abilita ribalta confezione";
                    if (isSet($_POST['ribalta' . $NProd]) AND $_POST['ribalta' . $NProd] != "false;Abilita ribalta confezione")
                        list($ribalta, $descriRibalta) = explode(';', $_POST['ribalta' . $NProd]);


                    //Recupera default da parametro globale id=40
                    $cliente = $defaultCliente;
                    if (isSet($_POST['cliente' . $NProd]) AND $_POST['cliente' . $NProd] != $defaultCliente)
                        $cliente = $_POST['cliente' . $NProd];


                    $idRicettaColore = 0;
                    $nomeRicettaColore = "";
                    if (isSet($_POST['Colore' . $NProd]) AND $_POST['Colore' . $NProd] != "")
                        list($idRicettaColore, $nomeRicettaColore) = explode(';', $_POST['Colore' . $NProd]);

                    $idRicettaAdditivo = 0;
                    $nomeRicettaAdditivo = "";
                    if (isSet($_POST['Additivo' . $NProd]) AND $_POST['Additivo' . $NProd] != "")
                        list($idRicettaAdditivo, $nomeRicettaAdditivo) = explode(';', $_POST['Additivo' . $NProd]);


                    $cambioBilancia = "false";
                    $descriCambioBilancia = $filtroBilanciaStandard;
                    //Altra opzione bilancia : "OPEN MOUTH BAGS SCALE"
                    if (isSet($_POST['CambioBilancia' . $NProd]) AND $_POST['CambioBilancia' . $NProd] != "false;$filtroBilanciaStandard")
                        list($cambioBilancia, $descriCambioBilancia) = explode(';', $_POST['CambioBilancia' . $NProd]);
                    // }
                    //Componenti della formula
                    $nComp = 0;
                    $StringaIdCompNew = "";
                    $StringaDescriCompNew = "";
                    //$NProd = id prodotto
                    $sqlCompProd = selectComponentiPesByIdProdAbil($NProd, $valAbilitato);
                    while ($row = mysql_fetch_array($sqlCompProd)) {

                        if (isset($_POST['Componente' . $NProd . $nComp])) {
                            list($idComponente, $descriComp) = explode(";", $_POST['Componente' . $NProd . $nComp]);

                            $idCompOriginale=$_POST['IdCompOriginale' . $NProd . $nComp];

                            if ($nComp == 0) {
                                
                                $StringaIdCompNew = $idCompOriginale.$parCarSeparazione2.$idComponente;
                                $StringaDescriCompNew = $descriComp;
                            } else {

                                $StringaIdCompNew = $StringaIdCompNew . $parSeparatore . $idCompOriginale.$parCarSeparazione2.$idComponente;
                                $StringaDescriCompNew = $StringaDescriCompNew . ";" . $descriComp;
                            }
                        }

                        $nComp++;
                    }



                    //##### SALVO I PRODOTTI SELEZIONATI IN UN OGGETTO NELLA SESSIONE ######
                    if ($NumPezzi > 0) {
                        //Salvo le quantità nell' oggetto
                        //Verifico se il prodotto è già salvato nell'oggetto
                        //se si -> faccio un update dell'oggetto senza  incrementare k 
                        //se no -> creo un nuovo oggetto e incremento k
                        $updateObj = false;
                        for ($j = 0; $j < count($_SESSION['OrdineOri']); $j++) {

                            if ($_SESSION['OrdineOri'][$j]->getCodProdotto() == $rowProdotti['cod_prodotto']) {
                                $updateObj = true;

                                $_SESSION['OrdineOri'][$j]->setNumPezzi($NumPezzi);
                                $_SESSION['OrdineOri'][$j]->setPezzoKg($PezzoKg);
                                $_SESSION['OrdineOri'][$j]->setMoltiplicatore($moltiplicatore);
                                $_SESSION['OrdineOri'][$j]->setTipoChimica($tipoChimica);
                                $_SESSION['OrdineOri'][$j]->setDescriTipoChimica($descriTipoChimica);
                                $_SESSION['OrdineOri'][$j]->setTipoConfezione($tipoConf);
                                $_SESSION['OrdineOri'][$j]->setDescriTipoConfezione($descriTipoConf);
                                $_SESSION['OrdineOri'][$j]->setRibalta($ribalta);
                                $_SESSION['OrdineOri'][$j]->setDescriRibalta($descriRibalta);
                                $_SESSION['OrdineOri'][$j]->setCliente($cliente);
                                $_SESSION['OrdineOri'][$j]->setCambioBilancia($cambioBilancia);
                                $_SESSION['OrdineOri'][$j]->setDescriCambioBilancia($descriCambioBilancia);
                                $_SESSION['OrdineOri'][$j]->setOrdineProduzione($ordineDiProd);
                                $_SESSION['OrdineOri'][$j]->setStringaComponenti($StringaIdCompNew);
                                $_SESSION['OrdineOri'][$j]->setStringaDescriComponenti($StringaDescriCompNew);
                                $_SESSION['OrdineOri'][$j]->setIdRicettaColore($idRicettaColore);
                                $_SESSION['OrdineOri'][$j]->setNomeRicettaColore($nomeRicettaColore);
                                $_SESSION['OrdineOri'][$j]->setIdRicettaAdditivo($idRicettaAdditivo);
                                $_SESSION['OrdineOri'][$j]->setNomeRicettaAdditivo($nomeRicettaAdditivo);
                            }
                        }
                        if (!$updateObj) {

                            $_SESSION['OrdineOri'][$k] = new OrdineOri($rowProdotti['id_prodotto'], $rowProdotti['cod_prodotto'], $rowProdotti['nome_prodotto'], $NumPezzi, $PezzoKg, $moltiplicatore, $DtOrdine);
                            $_SESSION['OrdineOri'][$k]->setTipoChimica($tipoChimica);
                            $_SESSION['OrdineOri'][$k]->setDescriTipoChimica($descriTipoChimica);
                            $_SESSION['OrdineOri'][$k]->setTipoConfezione($tipoConf);
                            $_SESSION['OrdineOri'][$k]->setDescriTipoConfezione($descriTipoConf);
                            $_SESSION['OrdineOri'][$k]->setRibalta($ribalta);
                            $_SESSION['OrdineOri'][$k]->setDescriRibalta($descriRibalta);
                            $_SESSION['OrdineOri'][$k]->setCliente($cliente);
                            $_SESSION['OrdineOri'][$k]->setCambioBilancia($cambioBilancia);
                            $_SESSION['OrdineOri'][$k]->setDescriCambioBilancia($descriCambioBilancia);
                            $_SESSION['OrdineOri'][$k]->setOrdineProduzione($ordineDiProd);
                            $_SESSION['OrdineOri'][$k]->setStringaComponenti($StringaIdCompNew);
                            $_SESSION['OrdineOri'][$k]->setStringaDescriComponenti($StringaDescriCompNew);
                            $_SESSION['OrdineOri'][$k]->setIdRicettaColore($idRicettaColore);
                            $_SESSION['OrdineOri'][$k]->setNomeRicettaColore($nomeRicettaColore);
                            $_SESSION['OrdineOri'][$k]->setIdRicettaAdditivo($idRicettaAdditivo);
                            $_SESSION['OrdineOri'][$k]->setNomeRicettaAdditivo($nomeRicettaAdditivo);

                            $k++;
                        }
                    }
                }//End while prodotti
                //#####################################################################
                //####### TOTALI CALCOLATI SULLE MATERIE  PRESENTI NELL'OGGETTO #######
                //#####################################################################
                //Inizializzo le variabili numeriche
                $TotaleNumPezzi = 0;
                $TotalePezziKg = 0;

                //####### ORDINAMENTO DELL' ARRAY IN BASE AL PRIMO INDICE (COD_PRODOTTO) ######
// non c'è bisogno di ordinare l'array per codice in quanto l'ordine delle azioni è quello indicato dall'operatore    
//usort($_SESSION['OrdineOri'], array('OrdineOri', 'comparaCodProdotto'));
                ?>
                <div id="container" style="width:100%; margin:15px auto; font-size:12px">
                    <form id="InserisciOrdine" name="InserisciOrdine" method="POST" >
                        <table width="100%">
                            <tr>
                                <td height="42" colspan="2" class="cella3"><?php echo $filtroNuovoProgProduzione ?></td>
                            </tr>
                            <input type="hidden" name="primaEsecuzione" id="primaEsecuzione" value="1"/>

                            <!--#####################################################################-->
                            <!--####################  ORDINE ########################################-->
                            <!--#####################################################################-->
                            <tr>
                                <td class="cella4" ><?php echo $filtroStabilimento ?></td>
                                <td class="cella1">
                                    <select name="Stabilimento" id="Stabilimento">

                                        <option value="<?php echo $IdMacchina . " - " . $DescriStab ?>" selected="<?php echo $IdMacchina . " - " . $DescriStab ?>"><?php echo $DescriStab ?></option>
                                        <?php
                                        while ($row = mysql_fetch_array($sqlMacchine)) {
                                            ?>
                                            <option value="<?php echo $row['id_macchina'] . " - " . $row['descri_stab']; ?>"><?php echo $row['descri_stab']; ?></option>
                                        <?php } ?>
                                    </select>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroDtProdPrevista ?> </td>
                                <td class="cella1" colspan="4"><?php formModificaSceltaData("GiornoOrdine", "MeseOrdine", "AnnoOrdine", $arrayFiltroMese, $valGiorno, $numMese, $valMese, $valAnno) ?>                                  
                                </td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroDtInserimentoOrdine ?></td>
                                <td class="cella1"><?php echo dataCorrenteVisualizza(); ?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroNote ?></td>
                                <td class="cella1"><textarea  name="Note" id="Note" ROWS=4 COLS=40 value="<?php echo $Note; ?>"/><?php echo $Note; ?></textarea></td>
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
                        <!--######################################################################-->
                        <!--##############  VISUALIZZAZIONE OGGETTO ORDINE #######################-->
                        <!--######################################################################-->

                        <?php if (count($_SESSION['OrdineOri']) > 0) { ?>
                            <table width="100%">
                                <tr>
                                    <td class="cella3" width="5%"><?php echo $filtroOrdineDiProd ?></td>      
                                    <td class="cella3" width="50%" colspan="2"><?php echo $filtroProdotti ?></td>                                                 
                                    <td class="cella3" width="45%" colspan="2"><?php echo $filtroConfezionamento ?> </td>
                                </tr>  <?php
                            for ($i = 0; $i < count($_SESSION['OrdineOri']); $i++) {
                                $TotaleNumPezzi = $TotaleNumPezzi + $_SESSION['OrdineOri'][$i]->getNumPezzi() * $_SESSION['OrdineOri'][$i]->getMoltiplicatore();
                                $TotalePezziKg = $TotalePezziKg + $_SESSION['OrdineOri'][$i]->getPezzoKg() * $_SESSION['OrdineOri'][$i]->getNumPezzi() * $_SESSION['OrdineOri'][$i]->getMoltiplicatore();

                                $classeCella = "cella1";
                                $title = "";
                                $stringaNumPezzi = "";
                                if ($_SESSION['OrdineOri'][$i]->getNumPezzi() > 0)
                                    $stringaNumPezzi = $_SESSION['OrdineOri'][$i]->getMoltiplicatore() . " x " . $_SESSION['OrdineOri'][$i]->getNumPezzi() . " " . $filtroPz . " " . $filtroDa . " " . $_SESSION['OrdineOri'][$i]->getPezzoKg() . " " . $filtroKgBreve;
                                //if ($_SESSION['OrdineOri'][$i]->getOrdineProduzione() > 0)
                                //$stringaOrdineProduzione=
                                ?>
                                    <tr>
                                        <td class="<?php echo $classeCella ?>"><?php echo $_SESSION['OrdineOri'][$i]->getOrdineProduzione() ?></td> 
                                        <td class="<?php echo $classeCella ?>"><b><?php echo $_SESSION['OrdineOri'][$i]->getCodProdotto() . "<br/><br/> " . $_SESSION['OrdineOri'][$i]->getNomeProdotto() . "</b><br/><br/> " ?>

                                            <?php
                                            if ($_SESSION['OrdineOri'][$i]->getNomeRicettaColore() != "") {

                                                echo $filtroColore . ": " . $_SESSION['OrdineOri'][$i]->getNomeRicettaColore() . "<br/><br/> ";
                                            }

                                            if ($_SESSION['OrdineOri'][$i]->getNomeRicettaAdditivo() != "") {
                                                echo $filtroAdditivo . ": " . $_SESSION['OrdineOri'][$i]->getNomeRicettaAdditivo();
                                            }
                                            ?>

                                        </td> 
                                        <td class="<?php echo $classeCella ?>">



                                            <?php
                                            $arrayStringaDescriCompNew = array();

                                            $arrayStringaDescriCompNew = explode(";", $_SESSION['OrdineOri'][$i]->getStringaDescriComponenti());

                                            for ($t = 0; $t < count($arrayStringaDescriCompNew); $t++) {
                                                ?>

                                                <nobr><li><?php echo $arrayStringaDescriCompNew[$t] ?></li></nobr>

                                            <?php } ?>

                                        </td>
                                        <td class="<?php echo $classeCella ?>">
                                            <li><?php echo $stringaNumPezzi ?></li>

                                            <li><?php echo $_SESSION['OrdineOri'][$i]->getCliente() ?></li>

                                        </td> 
                                        <td class="<?php echo $classeCella ?>">
                                            <li><?php echo $_SESSION['OrdineOri'][$i]->getDescriTipoChimica() ?></li>
                                            <li><?php echo $_SESSION['OrdineOri'][$i]->getDescriTipoConfezione() ?></li>
                                            <li><?php echo $_SESSION['OrdineOri'][$i]->getDescriRibalta() ?></li>
                                            <li><?php echo $_SESSION['OrdineOri'][$i]->getDescriCambioBilancia() ?></li>

                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td class="dataRigWhite" colspan="3"><span style="font-size: 15px"><?php echo $filtroTotale ?></span></td>
                                    <td class="dataRigWhite" colspan="2"><span style="font-size: 15px"><?php echo $TotaleNumPezzi . " " . $filtroPz . "   " . number_format($TotalePezziKg, 0, ",", " ") . " " . $filtroKgBreve ?></span></td>
                                </tr>
                            </table>
                        <?php }
                        ?>
                        <!--#####################################################################-->
                        <!--####################  FILTRI SUI PRODOTTI  ##########################-->
                        <!--#####################################################################-->
                        <input type="hidden" name="k" value="<?php echo $k ?>"/>
                        <table width="100%">
                            <th class="cella3" ></th>      
                            <th class="cella3" width="30%" colspan="2" ><?php echo $filtroProdotti ?></th>                                                 
                            <td class="cella3" width="65%" colspan="4"><?php echo $filtroConfezionamento ?> </td>
                            </tr> 
                            <tr>
                                <td class="cella4" ><?php echo $filtroOrdineDiProd ?></td> 

                                <td class="cella4"><input type="text"  name="CodProdotto" value="<?php echo $_SESSION['CodProdotto'] ?>" onChange="javascript:AggiornaCalcoli();" placeholder="<?php echo $filtroCodice ?>"/></td>
                                <td class="cella4" ><?php echo $filtroMateriePrime ?></td>
                                <td class="cella4" style="text-align: right; " colspan="4"><input type="button" onclick="javascript:AggiornaCalcoli();"  value="<?php echo $valueButtonRefresh ?>" /></td>
                            </tr>
                            <?php
//Visualizzo l'elenco dei prodotti presenti nella 
//tabella [prodotto]
                            $NProd = 0;
                            if (mysql_num_rows($sqlProdotti) > 0)
                                mysql_data_seek($sqlProdotti, 0);
                            while ($rowProd = mysql_fetch_array($sqlProdotti)) {

                                $classeCella = "cella1";
                                $title = "";

                                $NProd = $rowProd['id_prodotto'];
                                $idCategoria = $rowProd['id_cat'];

                                $serieColore = $rowProd['serie_colore'];
                                $serieAdditivo = $rowProd['serie_additivo'];


                                $sqlColori = findColoriBySerieAbil($serieColore, $tipoColore);
                                $sqlAdditivi = findAdditiviBySerieAbil($serieAdditivo, $tipoAdditivo);


                                $NSac = 1;
                                $sqlSac = findNumSacByIdCat($idCategoria);

                                $possibileCambioCemento = false;

                                $totQtaMiscela = 0;

                                $numCompFormula = 0;
                                $sqlCompProd = selectComponentiPesByIdProdAbil($rowProd['id_prodotto'], $valAbilitato);
                                while ($row = mysql_fetch_array($sqlCompProd)) {
                                    $numCompFormula++;
                                    $totQtaMiscela = $totQtaMiscela + $row['quantita'];
                                }

                                $correttivoFormula = 0;

                                //Recupero il par sing mac con id 344 (è la qta da sottrarre al tot miscela per calcolare il numero dei sacchi)
                                $sqlValSm = selectValByIdByMac($valIdParCorrettivoFormula, $IdMacchina);
                                while ($rowPar = mysql_fetch_array($sqlValSm)) {
                                    $correttivoFormula = $rowPar['valore_variabile'];
                                }

                                $totQtaMiscela = $totQtaMiscela - $correttivoFormula;

                                $idRicettaColore = 0;
                                $nomeRicettaColore = "";

                                $idRicettaAdditivo = 0;
                                $nomeRicettaAdditivo = "";

                                $ordineDiProd = 0;
                                if (isSet($_POST['OrdineProduzione' . $NProd]))
                                    $ordineDiProd = $_POST['OrdineProduzione' . $NProd];
                                ?>
                                <tr>
                                    <td class="<?php echo $classeCella ?>" ><input type="text" name="OrdineProduzione<?php echo($NProd); ?>" value="<?php echo $ordineDiProd ?>" size="2px" /></td>
                                    <td class="<?php echo $classeCella ?>" title="<?php echo $title ?>"><b><?php echo($rowProd['cod_prodotto'] . "<br/><br/>" . $rowProd['nome_prodotto']) ?></b>
                                        <?php if (mysql_num_rows($sqlColori) > 0) {
                                            ?>
                                            <br/><br/> 
                                            <select name="Colore<?php echo $NProd ?>" id="Colore<?php echo $NProd ?>">

                                                <?php
                                                if (isset($_POST['Colore' . $NProd]) AND $_POST['Colore' . $NProd] != "") {

                                                    list($idRicettaColore, $nomeRicettaColore) = explode(";", $_POST['Colore' . $NProd]);
                                                    ?>
                                                    <option value="<?php $idRicettaColore . ";" . $nomeRicettaColore ?>" selected="<?php $idRicettaColore . ";" . $nomeRicettaColore ?>"><?php echo $nomeRicettaColore ?> </option>
                                                <?php } else {
                                                    ?>

                                                    <option value="" selected=""><?php echo $labelOptionSelectColore ?></option>

                                                <?php
                                                }
                                                while ($rowColori = mysql_fetch_array($sqlColori)) {
                                                    ?>

                                                    <option value="<?php echo ($rowColori['id_prodotto'] . ";" . $rowColori['nome_prodotto'] ); ?>"><?php echo ($rowColori['nome_prodotto']); ?></option>
            <?php } ?>
                                            </select> 
                                            <br/> 
        <?php } ?>


                                        <?php if (mysql_num_rows($sqlAdditivi) > 0) {
                                            ?>
                                            <br/><br/> 
                                            <select name="Additivo<?php echo $NProd ?>" id="Additivo<?php echo $NProd ?>">

                                                <?php
                                                if (isset($_POST['Additivo' . $NProd]) AND $_POST['Additivo' . $NProd] != "") {

                                                    list($idRicettaAdditivo, $nomeRicettaAdditivo) = explode(";", $_POST['Additivo' . $NProd]);
                                                    ?>
                                                    <option value="<?php $idRicettaAdditivo . ";" . $nomeRicettaAdditivo ?>" selected="<?php $idRicettaAdditivo . ";" . $nomeRicettaAdditivo ?>"><?php echo $nomeRicettaAdditivo ?> </option>
                                                <?php } else {
                                                    ?>

                                                    <option value="" selected=""><?php echo $labelOptionSelectAdditivo ?></option>

                                                <?php
                                                }
                                                while ($rowAdditivi = mysql_fetch_array($sqlAdditivi)) {
                                                    ?>

                                                    <option value="<?php echo ($rowAdditivi['id_prodotto'] . ";" . $rowAdditivi['nome_prodotto'] ); ?>"><?php echo ($rowAdditivi['nome_prodotto']); ?></option>
                                            <?php } ?>
                                            </select> 
                                            <br/> 
        <?php } ?>

                                    </td>
                                    <td class="<?php echo $classeCella ?>" > 
                                        <?php
                                        // Visualizzo la formula del prodotto 
                                        if (mysql_num_rows($sqlCompProd) > 0)
                                            mysql_data_seek($sqlCompProd, 0);
                                        $nComp = 0;
                                        $arrayCompAlternativi = array();
                                        $stringaCompAlternativi = "";
                                        while ($rowC = mysql_fetch_array($sqlCompProd)) {


                                            $idComp = $rowC['id_comp'];
                                            $descriComp = $rowC['descri_componente'];
                                            $quantitaComp = $rowC['quantita'];

                                            $stringaCompAlternativi = $rowC['info1'];

                                            $arrayCompAlternativi = explode($parSeparatore, $stringaCompAlternativi);
                                            //print_r($arrayCompAlternativi);

                                            if ($idComp != $parIdCompChimica) {
                                                $idCompSel = 0;
                                                $descriCompSel = "";
                                                ?>
                                        <input type="hidden" name="IdCompOriginale<?php echo $NProd . $nComp ?>" id="IdCompOriginale<?php echo $NProd . $nComp ?>"value="<?php echo $idComp?>" </input>
                                                <br/>
                                                <select name="Componente<?php echo $NProd . $nComp ?>" id="Componente<?php echo $NProd . $nComp ?>">
                                                    <?php
                                                    if (isset($_POST['Componente' . $NProd . $nComp])) {

                                                        list($idCompSel, $descriCompSel) = explode(";", $_POST['Componente' . $NProd . $nComp]);
                                                    }

                                                    if ($idCompSel != $idComp AND $idCompSel != 0) {
                                                        ?>
                                                        <option value="<?php echo ($idCompSel . ";" . $descriCompSel ); ?>" selected><?php echo $descriCompSel ?></option> 
                                                        <option value="<?php echo ($idComp . ";" . $descriComp ); ?>"  ><?php echo $descriComp ?></option> 
                                                    <?php } else { ?>
                                                        <option value="<?php echo ($idComp . ";" . $descriComp ); ?>" selected ><?php echo $descriComp ?></option> 
                                                        <?php
                                                    }
                                                    if ($stringaCompAlternativi != "") {
                                                        for ($i = 0; $i < count($arrayCompAlternativi); $i++) {

                                                            $idCompAlt = $arrayCompAlternativi[$i];
                                                            $descriCompAlt = "";
                                                            $sqlDescri = findComponenteById($idCompAlt);
                                                            while ($row = mysql_fetch_array($sqlDescri)) {
                                                                $descriCompAlt = $row['descri_componente'];
                                                            }
                                                            if ($idCompAlt != $idComp AND $idCompAlt != $idCompSel) {
                                                                ?>
                                                                <option value="<?php echo ($idCompAlt . ";" . $descriCompAlt ); ?>"><?php echo ($descriCompAlt); ?></option>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </select> <br/>
                                                <?php
                                            }
                                            $nComp++;
                                        }
                                        ?>
                                    </td>

                                    <td class="<?php echo $classeCella ?>" >                                   
                                        <?php
                                        //Se è stata impostata una quantità per il prodotto 
                                        $moltiplicatore = 1;
                                        if (isset($_POST['NumPezzi' . $NProd])) {
                                            list($NumPezzi, $PezzoKg) = explode(';', $_POST['NumPezzi' . $NProd]);

                                            if (isSet($_POST['moltiplicatore' . $NProd]) AND $_POST['moltiplicatore' . $NProd] > 1)
                                                $moltiplicatore = $_POST['moltiplicatore' . $NProd];
                                            ?>

                                            <nobr>
                                                <input type="text" name="moltiplicatore<?php echo($NProd); ?>" value="<?php echo $moltiplicatore ?>" size="2px" /> x
                                                <select name="NumPezzi<?php echo($NProd); ?>" id="NumPezzi<?php echo($NProd); ?>">
                                                    <option value="<?php echo $_POST['NumPezzi' . $NProd]; ?>" selected="<?php echo $_POST['NumPezzi' . $NProd]; ?>"><?php echo $NumPezzi . " pz da " . $PezzoKg; ?></option>
                                                    <?php
                                                    while ($rowSac = mysql_fetch_array($sqlSac)) {
                                                        $pezzoKg = $totQtaMiscela / $rowSac['num_sacchetti'];
                                                        //Approssimo il totale
                                                        $pezzoKg = round($pezzoKg, 0);
                                                        $pezzoKg = $pezzoKg - ($pezzoKg % 250);
                                                        ?>
                                                        <option value="<?php echo $rowSac['num_sacchetti'] . ";" . $pezzoKg; ?>"><?php echo $rowSac['num_sacchetti'] . " pz da " . number_format($pezzoKg, "0", ",", "") . " " . $filtroKgBreve ?></option>
                                                <?php } ?>
                                                </select>
                                            <?php echo $filtroPz ?>
                                            </nobr>
        <?php } else { ?>

                                            <nobr>
                                                <input type="text" name="moltiplicatore<?php echo ($NProd); ?>"  size="2px" value="<?php echo $moltiplicatore ?>" /> x
                                                <select  name="NumPezzi<?php echo($NProd); ?>" id="NumPezzi<?php echo($NProd); ?>" >
                                                    <option value="0;0" selected="0;0">0</option>
                                                    <?php
                                                    while ($rowSac = mysql_fetch_array($sqlSac)) {

                                                        $pezzoKg = $totQtaMiscela / $rowSac['num_sacchetti'];
                                                        //Approssimo il totale
                                                        $pezzoKg = round($pezzoKg, 0);
                                                        $pezzoKg = $pezzoKg - ($pezzoKg % $valApprosPesoSacchi);
                                                        ?>
                                                        <option value="<?php echo $rowSac['num_sacchetti'] . ";" . $pezzoKg; ?>"><?php echo $rowSac['num_sacchetti'] . " pz da " . number_format($pezzoKg, "0", ",", "") . " " . $filtroKgBreve ?></option>
                                                <?php } ?>
                                                </select>
                                                <?php echo $filtroPz ?> 

                                                <?php
                                            }
                                            ?>
                                        </nobr>





                                        <table>
                                            <tr>
                                                <?php
                                                $tipoChimica = "false";
                                                $descriTipoChimica = $filtroDesKitChimica;
                                                if (isSet($_POST['TipoChimica' . $NProd])) {
                                                    list($tipoChimica, $descriTipoChimica) = explode(';', $_POST['TipoChimica' . $NProd]);
                                                }
                                                if ($tipoChimica == "false") {
                                                    ?>
                                                    <td><input type="radio" checked name="TipoChimica<?php echo $NProd ?>" value="false;<?php echo $filtroDesKitChimica ?>"/><?php echo $filtroDesKitChimica ?></td>
                                                    <td><input type="radio" name="TipoChimica<?php echo $NProd ?>" value="true;<?php echo $filtroDesSfusa ?>" /><?php echo $filtroDesSfusa ?></td>
                                                <?php } else { ?>
                                                    <td><input type="radio"  name="TipoChimica<?php echo $NProd ?>" value="false;<?php echo $filtroDesKitChimica ?>"/><?php echo $filtroDesKitChimica ?></td>
                                                    <td><input type="radio" checked name="TipoChimica<?php echo $NProd ?>" value="true;<?php echo $filtroDesSfusa ?>" /><?php echo $filtroDesSfusa ?></td>
        <?php }
        ?>
                                            </tr>
                                            <tr>
                                                <?php
                                                $tipoConf = "false";
                                                $descriTipoConf = $filtroDesConfSacco;
                                                if (isSet($_POST['TipoConf' . $NProd])) {
                                                    list($tipoConf, $descriTipoConf) = explode(';', $_POST['TipoConf' . $NProd]);
                                                }
                                                if ($tipoConf == "false") {
                                                    ?>
                                                    <td><input type="radio" checked name="TipoConf<?php echo $NProd ?>" value="false;<?php echo $filtroDesConfSacco ?>" /><?php echo $filtroDesConfSacco ?></td>
                                                    <td><input type="radio" name="TipoConf<?php echo $NProd ?>" value="true;<?php echo $filtroDesConfSecchio ?>"/> <?php echo $filtroDesConfSecchio ?></td>
                                                <?php } else { ?>
                                                    <td><input type="radio"  name="TipoConf<?php echo $NProd ?>" value="false;<?php echo $filtroDesConfSacco ?>" /><?php echo $filtroDesConfSacco ?></td>
                                                    <td><input type="radio" checked name="TipoConf<?php echo $NProd ?>" value="true;<?php echo $filtroDesConfSecchio ?>"/> <?php echo $filtroDesConfSecchio ?></td>
        <?php }
        ?>
                                            </tr>
                                            <tr>
                                                <?php
                                                $ribalta = "false";
                                                $descriRibalta = $filtroDesAbilitaRibalta;
                                                if (isSet($_POST['ribalta' . $NProd])) {
                                                    list($ribalta, $descriRibalta) = explode(';', $_POST['ribalta' . $NProd]);
                                                }
                                                if ($tipoConf == "false") {
                                                    ?>
                                                    <td><input type="radio" checked name="ribalta<?php echo $NProd ?>" value="false;<?php echo $filtroDesAbilitaRibalta ?>" /><?php echo $filtroDesAbilitaRibalta ?></td>
                                                    <td><input type="radio" name="ribalta<?php echo $NProd ?>" value="true;<?php echo $filtroDesDisabilitaRibalta ?>" /><?php echo $filtroDesDisabilitaRibalta ?></td>
                                                <?php } else { ?>
                                                    <td><input type="radio"  name="ribalta<?php echo $NProd ?>" value="false;<?php echo $filtroDesAbilitaRibalta ?>" /><?php echo $filtroDesAbilitaRibalta ?></td>
                                                    <td><input type="radio" checked name="ribalta<?php echo $NProd ?>" value="true;<?php echo $filtroDesDisabilitaRibalta ?>" /><?php echo $filtroDesDisabilitaRibalta ?></td>
        <?php }
        ?>

                                            </tr>

                                            <tr>

                                                <?php
                                                $cambioBilancia = "false";
                                                $descriCambioBilancia = $filtroBilanciaStandard;
                                                if (isSet($_POST['CambioBilancia' . $NProd])) {
                                                    list($cambioBilancia, $descriCambioBilancia) = explode(';', $_POST['CambioBilancia' . $NProd]);
                                                }
                                                if ($cambioBilancia == "false") {
                                                    ?>
                                                    <td><input type="radio" checked name="CambioBilancia<?php echo $NProd ?>" value="false;<?php echo $filtroBilanciaStandard ?>" /><?php echo $filtroBilanciaStandard ?></td>
                                                    <td> <input type="radio" name="CambioBilancia<?php echo $NProd ?>" value="true;<?php echo $filtroBilanciaCambio ?>" /><?php echo $filtroBilanciaCambio ?></td>
                                                <?php } else { ?>
                                                    <td><input type="radio"  name="CambioBilancia<?php echo $NProd ?>" value="false;<?php echo $filtroBilanciaStandard ?>" /><?php echo $filtroBilanciaStandard ?></td>
                                                    <td> <input type="radio" checked name="CambioBilancia<?php echo $NProd ?>" value="true;<?php echo $filtroBilanciaCambio ?>" /><?php echo $filtroBilanciaCambio ?></td>
        <?php }
        ?>


                                            </tr>

                                            <?php
                                            $cliente = $defaultCliente;
                                            if (isSet($_POST['cliente' . $NProd]) AND $_POST['cliente' . $NProd] != $defaultCliente)
                                                $cliente = $_POST['cliente' . $NProd];
                                            ?>

                                            <tr><td><textarea name="cliente<?php echo $NProd; ?>" id="cliente<?php echo $NProd ?>" placeholder="<?php echo $filtroCliente ?>" ROWS=1 COLS=15 ><?php echo $cliente ?></textarea></td>
                                                <td></td>
                                            </tr>

                                            <br />

                                        </table>
                                        <br/>
                                    </td>
                                </tr>
                                <?php
                            }//End While prodotti
                            ?>

                            <tr>
                                <td class="cella2" style="text-align: right " colspan="5">
                                    <input type="reset"  onClick="javascript:history.back();" value="<?php echo $valueButtonAnnulla ?>"/>
                                    <input type="button" onClick="javascript:AggiornaCalcoli();"  value="<?php echo $valueButtonConferma ?>" />
                                    <input type="button" onClick="javascript:Carica();" value="<?php echo $valueButtonSalva ?>" />
                                </td>
                            </tr>
                        </table>
                    </form>      
                </div>


                <div id="msgLog">
                    <?php
                    if ($DEBUG) {

                        echo "</br>Tab prodotto : Utenti e aziende visibili " . $strUtentiAziende;


                        echo "</br>Tabella prodotto: AZIENDE SCRIVIBILI: ";
                        for ($i = 0; $i < count($arrayAziendeScrivibili); $i++) {

                            echo $arrayAziendeScrivibili[$i]->getIdAzienda() . " " . $arrayAziendeScrivibili[$i]->getNomeAzienda() . "</br>";
                        }
                    }
                }
                ?>
            </div>
        </div><!--mainContainer-->
    </body>
</html>
