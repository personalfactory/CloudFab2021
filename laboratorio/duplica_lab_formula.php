<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php
    include('./oggetti/LabMatpriTeoria.php');
    include('./oggetti/LabParTeoria.php');
    include('../include/validator.php');
    ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <div id="labContainer">

        <script language="javascript">
            function Carica() {
                document.forms["DuplicaLabFormula"].action = "duplica_lab_formula2.php";
                document.forms["DuplicaLabFormula"].submit();
            }
            function AggiornaCalcoli() {
                document.forms["DuplicaLabFormula"].action = "duplica_lab_formula.php";
                document.forms["DuplicaLabFormula"].submit();
            }
            //Funzioni per la visualizzazione del form relativo al prodotto obiettivo
            function visualizzaListBoxProbObEsistente() {
                document.getElementById("NomeProdObEs").style.visibility = "visible";
                document.getElementById("NomeProdObNuovo").style.visibility = "hidden";
            }
            function visualizzaFormNuovoProdOb() {
                document.getElementById("NomeProdObEs").style.visibility = "hidden";
                document.getElementById("NomeProdObNuovo").style.visibility = "visible";
            }
        </script>
        <?php
        ///////////////////////////////////////////////////////////////////////
       
/////////////////////////////////////////////////////////////////////////7
        if ($DEBUG)
            ini_set('display_errors', 1);

        //############# STRINGHE UTENTI - AZIENDE VISIBILI###########################
        //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
        //dall'utente loggato   
        $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_formula');
        $strUtentiAziendeNorm = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_normativa');
        $strUtentiAziendeMatPri = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_materie_prime');
        $strUtentiAziendeParam = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_parametro');

        $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'lab_formula');

        include('../include/menu.php');
        include('../Connessioni/serverdb.php');
        include('../include/gestione_date.php');
        include('../include/precisione.php');
        include('./sql/script.php');
        include('./sql/script_lab_normativa.php');
        include('./sql/script_lab_materie_prime.php');
        include('./sql/script_lab_parametro.php');
        include('./sql/script_lab_formula.php');
        include('./sql/script_lab_matpri_teoria.php');
        include('./sql/script_lab_parametro_teoria.php');

        $Pagina = "duplica_lab_formula";
        //######################################################################
        //########### FILTRI SULLA VISUALIZZAZIONE MATERIE PRIME ###############
        //######################################################################

        $_SESSION['CodMat'] = "";
        $_SESSION['DescriMat'] = "";
        $_SESSION['TipoMat'] = "";

        if (isset($_POST['TipoMat'])) {
            $_SESSION['TipoMat'] = trim($_POST['TipoMat']);
        }
        if (isset($_POST['TipoMat'])) {
            $_SESSION['TipoMat'] = trim($_POST['TipoMat']);
        }
        if (isset($_POST['CodMat'])) {
            $_SESSION['CodMat'] = trim($_POST['CodMat']);
        }
        if (isset($_POST['DescriMat'])) {
            $_SESSION['DescriMat'] = trim($_POST['DescriMat']);
        }
        $_SESSION['Filtro'] = "cod_mat";

        //######################################################################
        //########### FILTRI SULLA VISUALIZZAZIONE PARAMETRI ###################
        //######################################################################

        $_SESSION['NomePar'] = "";
        $_SESSION['TipoPar'] = "";

        if (isset($_POST['NomePar'])) {
            $_SESSION['NomePar'] = trim($_POST['NomePar']);
        }
        if (isset($_POST['TipoPar'])) {
            $_SESSION['TipoPar'] = trim($_POST['TipoPar']);
        }

        $_SESSION['FiltroPar'] = "nome_parametro";

        //######################################################################
        //################## QUERY AL DB NUOVA FORMULA - MAT - COMP ############
        //######################################################################

        begin();
        $sqlProdOb = "";
//        if ($_SESSION['nome_gruppo_utente'] == 'Amministrazione') {
        $sqlProdOb = findAllFormule("prod_ob", "prod_ob", "", "", "", "", "", "", $strUtentiAziende, $_SESSION['visibilita_utente']);
//        } else {
//            $sqlProdOb = findFormuleByGruppo($_SESSION['username'], $_SESSION['nome_gruppo_utente'], "prod_ob", "prod_ob", "", "", "", "", "", $strUtentiAziende);
//        }
        $sqlNorma = findAllNormativeVis($strUtentiAziendeNorm);
        $sqlMatPrime = selectAllLabMatByFiltri($_SESSION['Filtro'], $_SESSION['TipoMat'], $_SESSION['CodMat'], $_SESSION['DescriMat'], $strUtentiAziendeMatPri);
//        $sqlParAc = findParametriByTipoVis($PercentualeSI, "nome_parametro", $strUtentiAziendeParam);
//        $sqlPar = findParametriByTipoVis($PercentualeNO, "nome_parametro", $strUtentiAziendeParam);

        $sqlTipo = findAllTipiMatPrime($strUtentiAziendeMatPri);
        $sqlPar = findAllParametriVisByNomeAndTipo($_SESSION['NomePar'], $_SESSION['TipoPar'], $_SESSION['FiltroPar'], "id_par", $strUtentiAziende);
        commit();



//##############################################################################
//################# INIZIO CARICAMENTO #########################################
//##############################################################################
//Se il codice formula non e' stato settato allora viene visualizzato 
//il form di inserimento con i valori della vecchia formula
        if ((!isset($_POST['CodiceFormula']) || $_POST['CodiceFormula'] == "") && isset($_GET['CodiceFormulaOld'])) {

//La variabile CodiceFormulaOld si riferisce al codice della formula vecchia 
//ovvero la formula dalla quale parte la duplicazione
//La variabile CodiceFormula e' il codice della nuova formula 
//che verra mandata in post alla pagina duplica_formula_2 per essere salvata
            $CodiceFormulaOld = $_GET['CodiceFormulaOld'];

            //##################################################################
            //############# QUERY AL DB VECCHIA FORMULA ########################
            //##################################################################

            begin();
            $sqlProdOb = "";
            $sqlProdOb = findAllFormule("prod_ob", "prod_ob", "", "", "", "", "", "", $strUtentiAziende, $_SESSION['visibilita_utente']);
//            if ($_SESSION['nome_gruppo_utente'] == 'Amministrazione') {
//            $sqlProdOb = findAllFormule("prod_ob", "prod_ob", "", "", "", "", "", "", $strUtentiAziende);
//            } else {
//                $sqlProdOb = findFormuleByGruppo($_SESSION['username'], $_SESSION['nome_gruppo_utente'], "prod_ob", "prod_ob", "", "", "", "", "", $strUtentiAziende);
//            }
            $sqlFormulaOld = findFormulaByCodice($CodiceFormulaOld);
            $sqlNormaOld = findAllNormativeVis($strUtentiAziendeNorm);
            $sqlMtCompOld = findMatCompFormulaByCodice($CodiceFormulaOld);
            $sqlMatPrimeOld = findMatPriFormulaByCodice($CodiceFormulaOld);
            $sqlCompOld = findCompFormulaByCodice($CodiceFormulaOld, $strUtentiAziendeMatPri);
//            $sqlParAcOld = findParFormulaByCodice($CodiceFormulaOld);
            $sqlParOld = findParFormulaByCodice($CodiceFormulaOld);
            commit();

            //##################################################################
            //############### CALCOLO QTA MAT PRIME E COMP #####################
            //##################################################################
            //Inizializzo le variabili numeriche
            $TotaleQta = 0;
            $CostoTotale = 0;
            //La variabile seguente serve per calcolare subito il totale ai fini del calcolo 
            //della percentuale ma alla fine di tutti i  cicli coincide con la variabile precedente
            $CostoPercentuale = 0;
            $CostoTotalePerc = 0;

            $QuantitaPercentuale = 0;
            $TotalePercentuale = 0;
            $CostoTotalePercentuale = 0;

            //Calcolo il totale delle quantita e del costo delle vecchie quantita 
            //di materie prime e componenti per poter calcolare il valore 
            //ed il costo percentuale di ogni singola qta 
            $NMtComp = 1;
            while ($rowMtComp = mysql_fetch_array($sqlMtCompOld)) {

                //Serve per il calcolo delle quantita in percentuale
                $TotaleQta = $TotaleQta + $rowMtComp['qta_teo'];
                //Serve per il calcolo del costo in percentuale
                $CostoTotalePerc = $CostoTotalePerc + ($rowMtComp['qta_teo'] * $rowMtComp['prezzo'] / $fatConvKgGrammi);

                $NMtComp++;
            }//End while totale quantita
            //##################################################################
            //############### ANAGRAFE FORMULA #################################
            //##################################################################
            while ($rowFormula = mysql_fetch_array($sqlFormulaOld)) {
                $DataFormula = $rowFormula['dt_lab_formula'];
                $Utente = $rowFormula['utente'];
                $GruppoLavoro = $rowFormula['gruppo_lavoro'];
                $Normativa = $rowFormula['normativa'];
                $ProdOb = $rowFormula['prod_ob'];
                $TipoProdOb = "NomeProdObEs";
                $IdAzienda = $rowFormula['id_azienda'];
                $IdUtenteProp = $rowFormula['id_utente'];
                $Visibilita = $rowFormula['visibilita'];
            }
            $NomeAzienda = getNomeAziendaById($_SESSION['objUtility'], $IdAzienda);

            //##################################################################
            //#################### GESTIONE UTENTI #############################
            //##################################################################            
            //Si recupera il proprietario della formula e si verifica se l'utente 
            //corrente ha il permesso di editare  i dati di quell'utente proprietario 
            //nelle tabella lab_formula
            //Se non ha il permesso bisogna disabilitare i pulsanti di salvataggio...
            //############# VERIFICA PERMESSO DI SCRITTURA E MODIFICA ##########
            $actionOnLoad = "";
            $arrayTabelleCoinvolte = array("lab_formula");
            if ($IdUtenteProp != $_SESSION['id_utente']) {
                //Se il proprietario del dato è un utente diverso dall'utente 
                //corrente si verifica il permesso 3
                if ($DEBUG)
                    echo "</br>Eseguita verifica permesso di tipo 3";
                $actionOnLoad = $actionOnLoad . verificaPermModifica3($_SESSION['objPermessiVis'], $arrayTabelleCoinvolte, $IdUtenteProp, $IdAzienda);
            }


            //##################################################################
            //##############  CREAZIONE OGGETTO LAB MAT PRIME ##################
            //##################################################################

            $_SESSION['LabMatpriTeoria'] = array();
            //Contatore delle materie prime con qta >0 
            //da aggiungere alla formula e salvare nell'oggetto
            $k = 0;
//                echo "########### k: " . $k;
            //Recupero tutte  le materie prime della vecchia formula
            $NMatPri = 0;
            if (mysql_num_rows($sqlMtCompOld))
                mysql_data_seek($sqlMtCompOld, 0);
            while ($rowMatPrime = mysql_fetch_array($sqlMtCompOld)) {
                $NMatPri = $rowMatPrime['id_mat'];

                $QuantitaMatPrima = $rowMatPrime['qta_teo'];
                $CostoUnitarioMt = $rowMatPrime['prezzo'];
                $CostoGrammiMt = 0;
                if ($rowMatPrime['unita_misura'] == $valUniMisKg)
                    $CostoGrammiMt = $rowMatPrime['prezzo'] / $fatConvKgGrammi;
                $CostoMt = $QuantitaMatPrima * $CostoGrammiMt;

                //##### SALVO LE MATERIE PRIME IN UN OGGETTO NELLA SESSIONE ###
                if ($QuantitaMatPrima > 0) {//FIX
                    //Salvo le quantità nell' oggetto
                    $_SESSION['LabMatpriTeoria'][$k] = new LabMatpriTeoria($CodiceFormulaOld, $rowMatPrime['cod_mat'], $rowMatPrime['id_mat'], 'FIX', $QuantitaMatPrima, "0");
                    $_SESSION['LabMatpriTeoria'][$k]->setDescriMat($rowMatPrime['descri_materia']);
                    $_SESSION['LabMatpriTeoria'][$k]->setUniMis($rowMatPrime['unita_misura']);
                    $_SESSION['LabMatpriTeoria'][$k]->setCostoUnit($rowMatPrime['prezzo']);
                    $_SESSION['LabMatpriTeoria'][$k]->setCosto($CostoMt);
                    $k++;
                } else if ($QuantitaMatPrima == 0) {//VAR
                    //Salvo in un array di sessione l'oggetto materia prima oggetto di variazione 
                    //selezionata tramite checkbox con qta=0
                    $_SESSION['LabMatpriTeoria'][$k] = new LabMatpriTeoria($CodiceFormulaOld, $rowMatPrime['cod_mat'], $rowMatPrime['id_mat'], "VAR", "0", "0");
                    $_SESSION['LabMatpriTeoria'][$k]->setDescriMat($rowMatPrime['descri_materia']);
                    $_SESSION['LabMatpriTeoria'][$k]->setUniMis($rowMatPrime['unita_misura']);
                    $_SESSION['LabMatpriTeoria'][$k]->setCostoUnit($rowMatPrime['prezzo']);
                    $_SESSION['LabMatpriTeoria'][$k]->setCosto($CostoMt);
                    $k++;
                }//End if
            }//End While Materie Prime
            
            
            //#####################################################################
            //####### TOTALI CALCOLATI SULLE MATERIE  PRESENTI NELL'OGGETTO #######
            //#####################################################################
            //Inizializzo le variabili numeriche
            $TotaleQtaMt = 0;
            $CostoTotaleMt = 0;

            $TotaleQtaComp = 0;
            $CostoTotaleComp = 0;

            $TotaleQta = 0;
            $CostoTotale = 0;

            $TotalePercentuale = 0;

            $CostoTotalePercentuale = 0;

            $QuantitaPercentualeMt = 0;
            $CostoPercentualeMt = 0;

            $QuantitaPercentualeComp = 0;
            $CostoPercentualeComp = 0;

            $qtaTotPercMt = 0;
            $costoTotPerMt = 0;
            $qtaTotPercComp = 0;
            $costoTotPerComp = 0;
            //Calcolo il totale delle quantita e del costo per poter calcolare 
            //il valore ed il costo percentuale di ogni singola qta inserita
            for ($j = 0; $j < count($_SESSION['LabMatpriTeoria']); $j++) {
                if (substr($_SESSION['LabMatpriTeoria'][$j]->getCodMat(), 0, 4) == $prefissoCodComp) {

                    $TotaleQtaComp = $TotaleQtaComp + $_SESSION['LabMatpriTeoria'][$j]->getQtaTeo();
                    $CostoTotaleComp = $CostoTotaleComp + ($_SESSION['LabMatpriTeoria'][$j]->getQtaTeo() * ($_SESSION['LabMatpriTeoria'][$j]->getCostoUnit() / $fatConvKgGrammi));
                } else {

                    $TotaleQtaMt = $TotaleQtaMt + $_SESSION['LabMatpriTeoria'][$j]->getQtaTeo();
                    $CostoTotaleMt = $CostoTotaleMt + ($_SESSION['LabMatpriTeoria'][$j]->getQtaTeo() * ($_SESSION['LabMatpriTeoria'][$j]->getCostoUnit() / $fatConvKgGrammi));
                }
            }
            //Totali di Materie prime + componenti prodotto		
            $TotaleQta = $TotaleQtaMt + $TotaleQtaComp;
            $CostoTotale = $CostoTotaleMt + $CostoTotaleComp;

            //Calcolo le percentuali sulle materie prime dell'oggetto
            for ($j = 0; $j < count($_SESSION['LabMatpriTeoria']); $j++) {

                if (substr($_SESSION['LabMatpriTeoria'][$j]->getCodMat(), 0, 4) == $prefissoCodComp) {

                    $QuantitaComp = $_SESSION['LabMatpriTeoria'][$j]->getQtaTeo();
                    $CostoUnitarioComp = $_SESSION['LabMatpriTeoria'][$j]->getCostoUnit();
                    $CostoGrammiComp = $CostoUnitarioComp / $fatConvKgGrammi;

                    $CostoComp = $QuantitaComp * $CostoGrammiComp;
//                    $CostoTotaleComp = $CostoTotaleComp + $CostoComp;
                    //Trasformo le qta in percentuale
                    if ($TotaleQta > 0)
                        $QuantitaPercentualeComp = ($QuantitaComp * 100) / $TotaleQta;
                    $TotalePercentuale = $TotalePercentuale + $QuantitaPercentualeComp;


                    //Trasformo i costi in percentuale
                    if ($CostoTotale > 0)
                        $CostoPercentualeComp = ($CostoComp * 100) / $CostoTotale;
                    $CostoTotalePercentuale = $CostoTotalePercentuale + $CostoPercentualeComp;

                    //Utili solo per la visualizzazione
                    $qtaTotPercComp = $qtaTotPercComp + $QuantitaPercentualeComp;
                    $costoTotPerComp = $costoTotPerComp + $CostoPercentualeComp;
                    //Aggiorno il costo perc e la qta perc
                    $_SESSION['LabMatpriTeoria'][$j]->setCostoPerc($CostoPercentualeComp);
                    $_SESSION['LabMatpriTeoria'][$j]->setQtaTeoPerc($QuantitaPercentualeComp);
                } else {

                    $QuantitaMatPrima = $_SESSION['LabMatpriTeoria'][$j]->getQtaTeo();
                    $CostoUnitarioMt = $_SESSION['LabMatpriTeoria'][$j]->getCostoUnit();
                    $CostoGrammiMt = $CostoUnitarioMt / $fatConvKgGrammi;


                    $CostoMt = $QuantitaMatPrima * $CostoGrammiMt;
                    //Trasformo le qta in percentuale
                    if ($TotaleQta > 0)
                        $QuantitaPercentualeMt = ($QuantitaMatPrima * 100) / $TotaleQta;
                    $TotalePercentuale = $TotalePercentuale + $QuantitaPercentualeMt;

                    //Trasformo i costi in percentuale
                    if ($CostoTotale > 0)
                        $CostoPercentualeMt = ($CostoMt * 100) / $CostoTotale;
                    $CostoTotalePercentuale = $CostoTotalePercentuale + $CostoPercentualeMt;

                    //Utili solo per la visualizzazione
                    $qtaTotPercMt = $qtaTotPercMt + $QuantitaPercentualeMt;
                    $costoTotPerMt = $costoTotPerMt + $CostoPercentualeMt;

                    $_SESSION['LabMatpriTeoria'][$j]->setCostoPerc($CostoPercentualeMt);
                    $_SESSION['LabMatpriTeoria'][$j]->setQtaTeoPerc($QuantitaPercentualeMt);
                }
            }

            //####### ORDINAMENTO DELL' ARRAY IN BASE AL PRIMO INDICE (COD_MAT) ###############
//            sort($_SESSION['LabMatpriTeoria']);
                usort ( $_SESSION['LabMatpriTeoria'], array( 'LabMatpriTeoria', 'comparaCodMat' ) );
            //##################################################################
            //############## CREAZIONE OGGETTO LAB PARAMETRO TEORIA ############
            //##################################################################
            $_SESSION['LabParTeoria'] = array();
            //Contatore dei parametri con qta > 0 
            //da aggiungere alla formula e salvare nell'oggetto
            $p = 0;
//                echo "########### p: " . $p;
            //Recupero i parametri della vecchia formula
            $NPar = 0;
            if (mysql_num_rows($sqlParOld))
                mysql_data_seek($sqlParOld, 0);
            while ($rowPar = mysql_fetch_array($sqlParOld)) {
                $ValoreTeo = 0;
                $ValoreTeoPerc = 0;

                $NPar = $rowPar['id_par'];

                if ($rowPar['tipo'] == $PercentualeNO) {
                    $ValoreTeo = $rowPar['valore_teo'];
                    $ValoreTeoPerc = 0;
                } else if ($rowPar['tipo'] == $PercentualeSI) {
                    //Poichè la quantità d'acqua viene salvata in percentuale, 
                    //calcolo la formula inversa e visualizzo la quantita in valore assoluto
                    $ValoreTeo = number_format(($rowPar['valore_teo'] * $TotaleQta) / 100, $PrecisioneQta, '.', '');
                    $ValoreTeoPerc = number_format($rowPar['valore_teo'], $PrecisioneQta, '.', '');
                }

                //##### SALVO I PARAMETRI NELL' OGGETTO ########################               
                //Salvo le quantità relative alla vecchia formula nell' oggetto
                $_SESSION['LabParTeoria'][$p] = new LabParTeoria($CodiceFormulaOld, $rowPar['nome_parametro'], $rowPar['id_par'], $rowPar['unita_misura'], $rowPar['tipo'], $ValoreTeo, $ValoreTeoPerc);
                $p++;
            }//End While Parametri
//            echo "</br>##### p :" . $p;
//            for ($j = 0; $j < $p; $j++) {
//                echo "</br>j: " . $j;
//                echo " - p: " . $p . "</br>";
//                echo print_r($_SESSION['LabParTeoria'][$j]);
//            }
//            sort($_SESSION['LabParTeoria']);
           usort ( $_SESSION['LabParTeoria'], array( 'LabParTeoria', 'comparaNomePar' ) );
            ?>
            <body onLoad="<?php echo $actionOnLoad ?>">
                <div id="container" style="width:95%; margin:15px auto;">
                    <form id = "DuplicaLabFormula" name = "DuplicaLabFormula" method = "POST">
                        <input type="hidden" name="k" value="<?php echo $k ?>"/>
                        <input type="hidden" name="p" value="<?php echo $p ?>"/>
                        <table width = "100%">
                            <tr>
                                <td colspan = "2" class = "cella3"><?php echo $titoloPaginaLabDuplica . " " . $CodiceFormulaOld; ?></td>
                            </tr>
                            <input type="hidden" name="CodiceFormulaOld" id="CodiceFormulaOld" value="<?php echo $CodiceFormulaOld; ?>"/>
                            <?php include('moduli/visualizza_lab_form_mod_prod_ob.php'); ?>
                            <tr>
                                <td width="300" class="cella4"><?php echo $filtroLabNorma ?></td>
                                <td class="cella1">
                                    <select name="Normativa" id="Normativa">
                                        <option value="" selected=""><?php echo $labelOptionSelectNormativa ?> </option>
                                        <option value="<?php echo $Normativa ?>" selected="<?php echo $Normativa ?>"><?php echo $Normativa ?></option>
                                        <?php
                                        if (mysql_num_rows($sqlNorma))
                                            mysql_data_seek($sqlNorma, 0);
                                        while ($rowNorma = mysql_fetch_array($sqlNorma)) {
                                            ?>
                                            <option value="<?php echo $rowNorma['normativa']; ?>"><?php echo $rowNorma['normativa']; ?></option>
                                        <?php } ?>
                                    </select> 
                                </td>
                            </tr>    
                            <tr>
                                <td width="300px" class="cella4"><?php echo $filtroLabCodice ?></td>
                                <td class="cella1"><input type="text" name="CodiceFormula" id="CodiceFormula"/></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroLabData ?></td>
                                <td class="cella1"><?php echo dataCorrenteVisualizza(); ?></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroLabUtente ?></td>
                                <td class="cella1"><?php echo $_SESSION['username'] ?></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroLabGruppo ?></td>
                                <td class="cella1"><?php echo $_SESSION['nome_gruppo_utente'] ?></td>
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
                            <tr>
                                <td class="cella4"><?php echo $filtroVisibilita . " " . $filtroLabFormula ?></td>
                                <td class="cella1" ><input type="text" name="VisibilitaFormula" id="VisibilitaFormula" value="<?php echo $_SESSION['visibilita_utente'] ?>"/><span class="commentiStyle"><?php echo $titleVisibilita.' '.$_SESSION['visibilita_utente'].' '.$titleVisibilita2 ?></span></td>
                            </tr>
                        </table>
                        <!--######################################################################-->
                        <!--##############  VISUALIZZAZIONE OGGETTO LAB MATERIE PRIME ############-->
                        <!--######################################################################-->
                        <?php
                        if (count($_SESSION['LabMatpriTeoria']) > 0) {
//        echo "oggetto pieno count: " . count($_SESSION['LabMatpriTeoria']) 
                            ?>
                            <table width="100%">
                                <tr>
                                    <th class="cella3"  colspan="2"><?php echo $filtroLabMateriePrimeFormula ?></th>
                                    <td class="cella3"><?php echo $filtroLabUnMisura ?></td>
                                    <td class="cella3" title="<?php echo $filtroCostoKilo ?>"><?php echo $filtroLabCostoUnit ?></td>
                                    <td class="cella3"><?php echo $filtroLabQta ?></td>           
                                    <td class="cella3"><?php echo $filtroLabCosto ?> </td>
                                    <td class="cella3"><?php echo $filtroLabQta . " " . $filtroLabPerc ?></td>
                                    <td class="cella3"><?php echo $filtroLabCosto . " " . $filtroLabPerc ?></td>
                                    <td class="cella3" title="<?php echo $titleLabCampoVar ?>"><?php echo $filtroLabVariabile ?></td>
                                    <td class="cella3" width="3%"><img src="/CloudFab/images/pittogrammi/patumiera_G.png" class="icone"  title="<?php echo $titleElimina ?> " onClick="javascript:AggiornaCalcoli();"/></td>
                                </tr> 
                                <?php
                                for ($i = 0; $i < count($_SESSION['LabMatpriTeoria']); $i++) {
                                    $classeCella = "cella1";
                                    $title = $filtroMtCompound;
                                    if (substr($_SESSION['LabMatpriTeoria'][$i]->getCodMat(), 0, 4) == $prefissoCodComp) {
                                        $classeCella = "cella4";
                                        $title = $filtroMtDrymix;
                                    }
                                    ?>
                                    <tr>
                                        <td class="<?php echo $classeCella ?>" title="<?php echo $title ?>"><?php echo $_SESSION['LabMatpriTeoria'][$i]->getCodMat() ?> </td> 
                                        <td class="<?php echo $classeCella ?>" title="<?php echo $title ?>"><?php echo $_SESSION['LabMatpriTeoria'][$i]->getDescriMat() ?></td> 
                                        <td class="<?php echo $classeCella ?>"><?php echo $_SESSION['LabMatpriTeoria'][$i]->getUniMis() ?></td> 
                                        <td class="<?php echo $classeCella ?>"><?php echo $_SESSION['LabMatpriTeoria'][$i]->getCostoUnit() . " " . $filtroEuro ?></td> 
                                        <td class="<?php echo $classeCella ?>"><?php echo number_format($_SESSION['LabMatpriTeoria'][$i]->getQtaTeo(), $PrecisioneQta, '.', '') . " " . $filtrogBreve ?> </td> 
                                        <td class="<?php echo $classeCella ?>"><?php echo number_format($_SESSION['LabMatpriTeoria'][$i]->getCosto(), $PrecisioneQta, '.', '') . " " . $filtroEuro ?></td>
                                        <td class="<?php echo $classeCella ?>"><?php echo number_format($_SESSION['LabMatpriTeoria'][$i]->getQtaTeoPerc(), $PrecisioneQta, '.', '') . " " . $filtroPerc ?> </td> 
                                        <td class="<?php echo $classeCella ?>"><?php echo number_format($_SESSION['LabMatpriTeoria'][$i]->getCostoPerc(), $PrecisioneQta, '.', '') . " " . $filtroPerc ?></td>  
                                        <td class="<?php echo $classeCella ?>"><?php echo $_SESSION['LabMatpriTeoria'][$i]->getTipo() ?></td>  
                                        <td class="<?php echo $classeCella ?>"><input type="checkbox" name="EliminaMat<?php echo $_SESSION['LabMatpriTeoria'][$i]->getIdMat() ?>" title="<?php echo $titleElimina ?>" /></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td class="dataRigWhite" colspan="4"><?php echo $filtroLabTotaleMatPri ?></td>
                                    <td class="dataRigWhite"><?php echo number_format($TotaleQtaMt, $PrecisioneQta, '.', '') . " " . $filtroLabGrammo ?></td>
                                    <td class="dataRigWhite"><?php echo number_format($CostoTotaleMt, $PrecisioneCosti, '.', '') . " " . $filtroLabEuro ?></td>
                                    <td class="dataRigWhite"><?php echo number_format($qtaTotPercMt, $PrecisioneQta, '.', '') . " " . $filtroLabPerc ?></td>
                                    <td class="dataRigWhite"><?php echo number_format($costoTotPerMt, $PrecisioneCosti, '.', '') . " " . $filtroLabPerc ?></td>
                                    <td class="dataRigWhite" colspan="2"></td>
                                </tr>
                                <tr>
                                    <td class="dataRigWhite" colspan="4"><?php echo $filtroLabTotaleDryMix ?></td>
                                    <td class="dataRigWhite"><?php echo number_format($TotaleQtaComp, $PrecisioneQta, '.', '') . " " . $filtroLabGrammo ?></td>
                                    <td class="dataRigWhite"><?php echo number_format($CostoTotaleComp, $PrecisioneCosti, '.', '') . " " . $filtroLabEuro ?></td>
                                    <td class="dataRigWhite"><?php echo number_format($qtaTotPercComp, $PrecisioneQta, '.', '') . " " . $filtroLabPerc ?></td>
                                    <td class="dataRigWhite"><?php echo number_format($costoTotPerComp, $PrecisioneCosti, '.', '') . " " . $filtroLabPerc ?></td>
                                    <td class="dataRigWhite" colspan="2"></td>
                                </tr>
                                <tr>
                                    <td class="dataRigWhite" colspan="4"><?php echo $filtroLabTotaleCompDry ?></td>
                                    <td class="dataRigWhite"><?php echo number_format($TotaleQta, $PrecisioneQta, '.', '') . " " . $filtroLabGrammo ?></td>
                                    <td class="dataRigWhite"><?php echo number_format($CostoTotale, $PrecisioneCosti, '.', '') . " " . $filtroLabEuro ?></td>
                                    <td class="dataRigWhite"><?php echo number_format($TotalePercentuale, $PrecisioneQta, '.', '') . " " . $filtroLabPerc ?></td>
                                    <td class="dataRigWhite"><?php echo number_format($CostoTotalePercentuale, $PrecisioneCosti, '.', '') . " " . $filtroLabPerc ?></td>
                                    <td class="dataRigWhite" colspan="2"></td>
                                </tr>
                            </table>
                            <?php
                        }

                        //##########################################################################
                        //##############  VISUALIZZAZIONE OGGETTO LAB PARAMETRI ####################
                        //##########################################################################
                        if (count($_SESSION['LabParTeoria']) > 0) {
//        echo "oggetto pieno count: " . count($_SESSION['LabParTeoria']) 
                            ?>

                            <table width="100%">
                                <tr>
                                    <th class="cella3"><?php echo $filtroLabParametri ?> </th>
                                    <td class="cella3"><?php echo $filtroLabTipo ?></td>
                                    <td class="cella3"><?php echo $filtroLabUnMisura ?></td>
                                    <td class="cella3"><?php echo $filtroLabQta ?></td>
                                    <td class="cella3"><?php echo $filtroLabQta . " " . $filtroLabPerc ?></td>

                                    <td class="cella3" width="3%"><img src="/CloudFab/images/pittogrammi/patumiera_G.png" class="icone"  title="<?php echo $titleElimina ?> " onClick="javascript:AggiornaCalcoli();"/></td>
                                </tr> 
                                <?php
                                for ($i = 0; $i < count($_SESSION['LabParTeoria']); $i++) {
                                    $classeCella = "cella1";

                                    if ($_SESSION['LabParTeoria'][$i]->getTipo() == $PercentualeNO) {
                                        $classeCella = "cella4";
                                    }
                                    ?>
                                    <tr>
                                        <td class="<?php echo $classeCella ?>"><?php echo $_SESSION['LabParTeoria'][$i]->getNomePar() ?> </td> 
                                        <td class="<?php echo $classeCella ?>"><?php echo $_SESSION['LabParTeoria'][$i]->getTipo() ?></td>  
                                        <td class="<?php echo $classeCella ?>"><?php echo $_SESSION['LabParTeoria'][$i]->getUniMis() ?></td> 
                                        <td class="<?php echo $classeCella ?>"><?php echo number_format($_SESSION['LabParTeoria'][$i]->getValoreTeo(), $PrecisioneQta, '.', '') ?> </td> 
                                        <td class="<?php echo $classeCella ?>"><?php echo number_format($_SESSION['LabParTeoria'][$i]->getValoreTeoPerc(), $PrecisioneQta, '.', '') . " " . $filtroPerc ?> </td> 

                                        <td class="<?php echo $classeCella ?>"><input type="checkbox" name="EliminaPar<?php echo $_SESSION['LabParTeoria'][$i]->getIdPar() ?>" title="<?php echo $titleElimina ?>" /></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>                        </table>
                        <!--#####################################################################-->
                        <!--####################  MATERIE PRIME #################################-->
                        <!--#####################################################################-->
                        <table width="100%">
                            <tr>
                                <th class="cella3" colspan="3" width="50%"><?php echo $filtroLabMatPrimeSel ?></th>
                                <td class="cella3" width="20%"><?php echo $filtroLabTipo ?></td>
                                <td class="cella3" width="5%"><?php echo $filtroLabUnMisura ?></td>
                                <td class="cella3" width="5%"><?php echo $filtroLabCostoUnit ?></td>
                                <td class="cella3" width="10%"><?php echo $filtroLabQta ?> </td>
                                <td class="cella3" width="3%" title="<?php echo $titleLabCampoVar ?>"><?php echo $filtroLabVariabile ?></td>
                            </tr> 

                            <!--#####################################################################-->
                            <!--#########  FILTRI SELEZIONE MATERIE PRIME ###########################-->
                            <!--#####################################################################-->
                            <tr>
                                <td class="cella4" colspan="2" ><input type="text"  name="CodMat" value="<?php echo $_SESSION['CodMat'] ?>" onChange="javascript:AggiornaCalcoli();"/></td>
                                <td class="cella4" ><input type="text"  name="DescriMat" value="<?php echo $_SESSION['DescriMat'] ?>" onChange="javascript:AggiornaCalcoli();" /></td>

                                <td class="cella4" colspan="3" >                            
                                    <select  name="TipoMat" id="TipoMat"  onChange="javascript:AggiornaCalcoli();" title="<?php echo $titleLabSelectTipoMat ?>">
                                        <option value="<?php echo $_SESSION['TipoMat'] ?>" selected="<?php echo $_SESSION['TipoMat'] ?>"><?php echo $_SESSION['TipoMat'] ?></option>
                                        <?php
                                        while ($rowTipo = mysql_fetch_array($sqlTipo)) {
                                            ?>
                                            <option value="<?php echo $rowTipo['tipo']; ?>"><?php echo $rowTipo['tipo']; ?></option>
                                        <?php } ?>
                                    </select></td>  
                                <td class="cella4" style="text-align: right" colspan="2"><input type="button" onclick="javascript:AggiornaCalcoli();"  value="<?php echo $valueButtonAggiorna ?>" /></td>
                            </tr>




                            <?php
                            
                            //Visualizzo l'elenco materie prime presenti nella tabella lab_materie_prime
                            $NMatPri = 0;
                            while ($rowMatPri = mysql_fetch_array($sqlMatPrime)) {
                                
                                $classeCella = "cella1";
                                $title = $filtroMtCompound;
                            
                                if (substr($rowMatPri['cod_mat'], 0, 4) == $prefissoCodComp) {
                                    $classeCella = "cella2";
                                    $title = $filtroMtDrymix;
                                }
                                $NMatPri = $rowMatPri['id_mat'];
                                $CostoUnitarioMt = number_format($rowMatPri['prezzo'], $PrecisioneCosti, '.', '');
                                ?>
                                <tr>
                                    <td class="<?php echo $classeCella ?>" width="30px">
                                        <a target="_blank" href="modifica_lab_materia.php?IdMateria=<?php echo($rowMatPri['id_mat']) ?>&Pagina=<?php echo $Pagina; ?>" title="<?php echo $titleLabInsNota ?>">
                                            <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="<?php echo $titleLabInsNota ?>"/> 
                                        </a>
                                    </td>
                                    <td class="<?php echo $classeCella ?>" title="<?php echo $title ?>" width="100px"><?php echo $rowMatPri['cod_mat'] ?></td>
                                    <td class="<?php echo $classeCella ?>" title="<?php echo $title ?>" width="350px"><?php echo $rowMatPri['descri_materia'] ?></td>
                                    <td class="<?php echo $classeCella ?>" width="350px"><?php echo $rowMatPri['tipo'] ?></td>
                                    <td class="<?php echo $classeCella ?>" width="50px"><?php echo $rowMatPri['unita_misura'] ?></td>
                                    <td class="<?php echo $classeCella ?>" width="50px"><?php echo $rowMatPri['prezzo'] . " " . $filtroLabEuro; ?></td>
                                    <td class="<?php echo $classeCella ?>" width="150px"><input  style="width:90px" type="text"  name="QtaMt<?php echo($NMatPri); ?>" id="QtaMt<?php echo($NMatPri); ?>" value="0"  /><?php echo $filtroLabGrammo ?></td>
                                    <td class="<?php echo $classeCella ?>" width="30px"><input type="checkbox" id="MatKeVaria<?php echo($NMatPri); ?>" name="MatKeVaria<?php echo($NMatPri); ?>" value="" title="<?php echo $titleLabCampoVar ?>"/></td>
                                </tr>
                                <?php
                            }//End While materie prime 
                            ?>

                        </table>
                        <!--#####################################################################-->
                        <!--######################## PARAMETRI  #################################-->
                        <!--#####################################################################-->

                        <!-- Le variabili contenenti la stringa Ac si riferiscono ai parametri di tipo PercentualeSI -->
                        <table width="100%">
                            <tr>
                                <th class="cella3"><?php echo $filtroLabParametri ?> </th>
                                <td class="cella3"><?php echo $filtroLabTipo ?></td>
                                <td class="cella3"><?php echo $filtroLabUnMisura ?></td>
                                <td class="cella3"><?php echo $filtroLabQta ?></td>                                
                                <td class="cella3"><?php echo $filtroLabQta . " " . $filtroLabPerc ?></td>

                            </tr> 
                            <!--#####################################################################-->
                            <!--######################## FILTRI SELEZIONE PARAMETRI  ################-->
                            <!--#####################################################################-->
                            <tr>
                                <td class="cella4" ><input type="text"  name="NomePar" value="<?php echo $_SESSION['NomePar'] ?>" onChange="javascript:AggiornaCalcoli();"/></td>
                                <td class="cella4" ><input type="text"  name="TipoPar" value="<?php echo $_SESSION['TipoPar'] ?>" onChange="javascript:AggiornaCalcoli();"/></td>
                                <td class="cella4" style="text-align: right" colspan="3"><input type="button" onclick="javascript:AggiornaCalcoli();"  value="<?php echo $valueButtonAggiorna ?>" /></td>
                            </tr>
                            <?php
                            $NPar = 0;
                            while ($rowPar = mysql_fetch_array($sqlPar)) {
                                $NPar = $rowPar['id_par'];
                                $nomeClassePar = "cella1";

                                if ($rowPar['id_par'] == $PercentualeNO) {
                                    $nomeClassePar = "cella4";
                                }
                                ?>
                                <tr>
                                    <td class="<?php echo $nomeClassePar ?>"><?php echo ($rowPar['nome_parametro']); ?></td>
                                    <td class="<?php echo $nomeClassePar ?>"><?php echo ($rowPar['tipo']); ?></td>
                                    <td class="<?php echo $nomeClassePar ?>"><?php echo ($rowPar['unita_misura']); ?></td>
                                    <td class="<?php echo $nomeClassePar ?>"><input type="text" name="QtaPar<?php echo($NPar); ?>" id="QtaPar<?php echo($NPar); ?>" value="0" /></td>
                                    <td class="<?php echo $nomeClassePar ?>"><input type="text" name="QtaParPerc<?php echo($NPar); ?>" id="QtaParPerc<?php echo($NPar); ?>" value="0" /></td>
                                </tr>
                                <?php
                            }//End While parametri
                            ?>

                            <tr>
                                <td class="cella2" style="text-align: right;" colspan="5">
                                    <input type="reset"  onclick="javascript:history.back();" value="<?php echo $valueButtonAnnulla ?>"/>
                                    <input type="button" onclick="javascript:AggiornaCalcoli();" title ="<?php echo $valueButtonAggiorna ?>" value="<?php echo $valueButtonAggiorna ?>" />
                            </tr>                      </table>
                    </form>
                </div>

                <?php
            } else {
//##############################################################################
//#################### INIZIO AGGIORNAMENTO SCRIPT #############################
//##############################################################################  
                //########### FILTRI SULLA VISUALIZZAZIONE MATERIE PRIME ###################
                $_SESSION['TipoMat'] = "";
                if (isset($_POST['TipoMat'])) {
                    $_SESSION['TipoMat'] = trim($_POST['TipoMat']);
                }
                $_SESSION['CodMat'] = "";
                if (isset($_POST['CodMat'])) {
                    $_SESSION['CodMat'] = trim($_POST['CodMat']);
                }
                $_SESSION['DescriMat'] = "";
                if (isset($_POST['DescriMat'])) {
                    $_SESSION['DescriMat'] = trim($_POST['DescriMat']);
                }
                list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);



                $_SESSION['Filtro'] = "cod_mat";
//                echo "</br>SESSION['TipoMat'] : " . $_SESSION['TipoMat'];
//                echo "</br>SESSION['CodMat'] : " . $_SESSION['CodMat'];
//                echo "</br>SESSION['DescriMat'] : " . $_SESSION['DescriMat'];


                $k = $_POST['k'];
//                echo "</br>##### K :" . $k;
//                for ($j = 0; $j < $k; $j++) {
//                    echo "</br>j: " . $j;
//                    echo " - k: " . $k . "</br>";
//                    echo print_r($_SESSION['LabMatpriTeoria'][$j]);
//                }
//                
                //########### FILTRI SULLA VISUALIZZAZIONE PARAMETRI #######################
                $_SESSION['NomePar'] = "";
                $_SESSION['TipoPar'] = "";

                if (isset($_POST['NomePar'])) {
                    $_SESSION['NomePar'] = trim($_POST['NomePar']);
                }
                if (isset($_POST['TipoPar'])) {
                    $_SESSION['TipoPar'] = trim($_POST['TipoPar']);
                }

                $_SESSION['FiltroPar'] = "nome_parametro";


                $p = $_POST['p'];

//    echo "</br>##### p :" . $p;
//    for ($j = 0; $j < $p; $j++) {
//        echo "</br>j: " . $j;
//        echo " - p: " . $p . "</br>";
//        echo print_r($_SESSION['LabParTeoria'][$j]);
//    }
                //############ CONTROLLO INPUT ANAGRAFE FORMULA ############################
                //Inizializzo l'errore relativo ai campi della tabella lab_formula
                $errore = false;
                $messaggio = '';
                if (!isset($_POST['CodiceFormula']) || trim($_POST['CodiceFormula']) == "") {

                    $errore = true;
                    $messaggio = $messaggio . ' ' . $msgErrCodice . '<br />';
                }
                if (!isset($_POST['Normativa']) || trim($_POST['Normativa']) == "") {

                    $errore = true;
                    $messaggio = $messaggio . ' ' . $msgErrSelectNormativa . '<br />';
                }
                if (
                        (!isset($_POST['NomeProdObEs']) OR $_POST['NomeProdObEs'] == "")
                        AND ( !isset($_POST['NomeProdObNuovo']) OR $_POST['NomeProdObNuovo'] == "")) {

                    $errore = true;
                    $messaggio = $messaggio . ' ' . $msgErrProdOb . '<br />';
                }

                if (!isset($_POST['scegli_target']) OR $_POST['scegli_target'] == "") {
                    $errore = true;
                    $messaggio = $messaggio . ' ' . $msgErrProdOb . '<br />';
                }

                $CodiceFormula = str_replace("'", "''", $_POST['CodiceFormula']);
                $CodiceFormula = trim($_POST['CodiceFormula']);

                $CodiceFormulaOld = $_POST['CodiceFormulaOld'];

                $Normativa = $_POST['Normativa'];

                $TipoProdOb = $_POST['scegli_target'];
                $ProdOb = "";
                if ($TipoProdOb == "NomeProdObEs") {
                    $ProdOb = $_POST['NomeProdObEs'];
                } else if ($TipoProdOb == "NomeProdObNuovo") {
                    $ProdOb = $_POST['NomeProdObNuovo'];
                }

                if (!isset($_POST['VisibilitaFormula']) OR $_POST['VisibilitaFormula'] == "" OR $_POST['VisibilitaFormula'] > $_SESSION['visibilita_utente']) {
                    $errore = true;
                    $messaggio = $messaggio . ' ' . $msgErrVisibilita . ' ' . $titleVisibilita . ' ' . $_SESSION['visibilita_utente'] . '<br />';
                }
                
                //########### Verifica esistenza codice formula ############################
                $result = verificaEsistenzaFormula($CodiceFormula);

                if (mysql_num_rows($result) != 0) {
                    //Se entro nell'if vuol dire che il valore inserito esiste gia nel db
                    $errore = true;
                    $messaggio = $messaggio . " " . $msgErrCodiceEsiste . "<br />";
                }
                if ($errore) {
                    echo '<div id="msgErr">' . $messaggio . '</div>';
                }

                $VisibilitaFormula = str_replace("'", "''", $_POST['VisibilitaFormula']);
                //##########################################################################
                //################# CONTROLLO INPUT MATERIE PRIME ##########################
                //##########################################################################

                $NMatPri = 0;
                $messaggioQtaMatPri = "";
                $NumErroreMt = 0;
                if (mysql_num_rows($sqlMatPrime) > 0)
                    mysql_data_seek($sqlMatPrime, 0);
                while ($rowMatPrime = mysql_fetch_array($sqlMatPrime)) {

                    $NMatPri = $rowMatPrime['id_mat'];
                    $QuantitaMatPrima = 0;
                    //Memorizzo nelle rispettive variabili le quantita' di materia_prime
                    if (isset($_POST['QtaMt' . $NMatPri]))
                        $QuantitaMatPrima = $_POST['QtaMt' . $NMatPri];

                    //Controllo input quantita materie prime
                    if (!is_numeric($QuantitaMatPrima) && $QuantitaMatPrima != "") {
                        $NumErroreMt++;
                        $messaggioQtaMatPri = $messaggioQtaMatPri . " " . $rowMatPrime['descri_materia'] . " : " . $msgErrQtaNumerica . "<br/>";
                    }
                    if ($QuantitaMatPrima < 0) {
                        $NumErroreMt++;
                        $messaggioQtaMatPri = $messaggioQtaMatPri . " " . $rowMatPrime['descri_materia'] . " : " . $msgErrQtaMagZero . "<br/>";
                    }
                }// End While finite le materie prime 
                if ($NumErroreMt > 0) {
                    echo '<div id="msgErr">' . $messaggioQtaMatPri . '</div>';
                }



//##############################################################################
//######## CONTROLLO INPUT PARAMETRI ###########################################
//##############################################################################
                //Estraggo l'elenco dei parametri presenti nella tabella lab_parametro
                $NPar = 0;
                $messaggioQtaPar = "";
                $NumErrorePar = 0;
                if (mysql_num_rows($sqlPar))
                    mysql_data_seek($sqlPar, 0);
                while ($rowPar = mysql_fetch_array($sqlPar)) {
                    $NPar = $rowPar['id_par'];
                    //Memorizzo nelle rispettive variabili le Quantità di materia_prime
                    $QuantitaParametro = $_POST['QtaPar' . $NPar];

                    //Controllo input Quantità parametri
                    if (!is_numeric($QuantitaParametro) && $QuantitaParametro != "") {
                        $NumErrorePar++;
                        $messaggioQtaPar = $messaggioQtaPar . " " . $rowPar['nome_parametro'] . " : " . $msgErrQtaNumerica . "<br/>";
                    }
                    if ($QuantitaParametro < 0) {
                        $NumErrorePar++;
                        $messaggioQtaPar = $messaggioQtaPar . " " . $rowPar['nome_parametro'] . " : " . $msgErrQtaMagZero . "<br/>";
                    }
                }// End While finiti i parametri

                if ($NumErrorePar > 0) {
                    echo '<div id="msgErr">' . $messaggioQtaPar . '</div>';
                }


                //##########################################################################
                //########### AGGIORNAMENTO OGGETTO LAB MATERIE PRIME ######################
                //##########################################################################
                //Recupero le materie prime selezionate
                $NMatPri = 0;
                if (mysql_num_rows($sqlMatPrime) > 0)
                    mysql_data_seek($sqlMatPrime, 0);
                while ($rowMatPrime = mysql_fetch_array($sqlMatPrime)) {

                    $NMatPri = $rowMatPrime['id_mat'];

                    $QuantitaMatPrima = 0;
                    if (isset($_POST['QtaMt' . $NMatPri]))
                        $QuantitaMatPrima = $_POST['QtaMt' . $NMatPri];
                    $CostoUnitarioMt = $rowMatPrime['prezzo'];
                    $CostoGrammiMt = 0;
                    if ($rowMatPrime['unita_misura'] == $valUniMisKg)
                        $CostoGrammiMt = $rowMatPrime['prezzo'] / $fatConvKgGrammi;
                    $CostoMt = $QuantitaMatPrima * $CostoGrammiMt;

                    //##### SALVO LE MATERIE PRIME SELEZIONATE IN UN OGGETTO NELLA SESSIONE ####
                    if ($QuantitaMatPrima > 0) {
                        //Salvo le quantità nell' oggetto
                        //Verifico se la materia prima è già salvata nell'oggetto
                        //se si -> faccio un update dell'oggetto senza  incrementare k 
                        //se no -> creo un nuovo oggetto e incremento k
                        $updateFixObj = false;
                        for ($j = 0; $j < count($_SESSION['LabMatpriTeoria']); $j++) {

                            if ($_SESSION['LabMatpriTeoria'][$j]->getCodMat() == $rowMatPrime['cod_mat']) {
                                $updateFixObj = true;

                                $_SESSION['LabMatpriTeoria'][$j]->setQtaTeo($QuantitaMatPrima);
                                $_SESSION['LabMatpriTeoria'][$j]->setCosto($CostoMt);
                            }
                        }
                        if (!$updateFixObj) {

                            $_SESSION['LabMatpriTeoria'][$k] = new LabMatpriTeoria($CodiceFormula, $rowMatPrime['cod_mat'], $rowMatPrime['id_mat'], 'FIX', $QuantitaMatPrima, "0");
                            $_SESSION['LabMatpriTeoria'][$k]->setDescriMat($rowMatPrime['descri_materia']);
                            $_SESSION['LabMatpriTeoria'][$k]->setUniMis($rowMatPrime['unita_misura']);
                            $_SESSION['LabMatpriTeoria'][$k]->setCostoUnit($rowMatPrime['prezzo']);
                            $_SESSION['LabMatpriTeoria'][$k]->setCosto($CostoMt);
                            $k++;
                        }
                    }

                    $updateVarObj = false;
                    if (isset($_POST['MatKeVaria' . $NMatPri])) {

                        for ($j = 0; $j < count($_SESSION['LabMatpriTeoria']); $j++) {

                            if ($_SESSION['LabMatpriTeoria'][$j]->getCodMat() == $rowMatPrime['cod_mat']) {
                                $updateVarObj = true;

                                $_SESSION['LabMatpriTeoria'][$j]->setQtaTeo($QuantitaMatPrima);
                                $_SESSION['LabMatpriTeoria'][$j]->setCosto($CostoMt);
                            }
                        }
                        if (!$updateVarObj) {
                            //Salvo in un array di sessione l'oggetto materia prima oggetto di variazione 
                            //selezionata tramite checkbox con qta=0
                            $_SESSION['LabMatpriTeoria'][$k] = new LabMatpriTeoria($CodiceFormula, $rowMatPrime['cod_mat'], $rowMatPrime['id_mat'], "VAR", "0", "0");
                            $_SESSION['LabMatpriTeoria'][$k]->setDescriMat($rowMatPrime['descri_materia']);
                            $_SESSION['LabMatpriTeoria'][$k]->setUniMis($rowMatPrime['unita_misura']);
                            $_SESSION['LabMatpriTeoria'][$k]->setCostoUnit($rowMatPrime['prezzo']);
                            $_SESSION['LabMatpriTeoria'][$k]->setCosto($CostoMt);
                            $k++;
                        }
                    }//End if
                }//End While Materie Prime
                //##########################################################################
                //############## EVENTUALE ELIMINAZIONE MATERIE ############################
                //##########################################################################
//                echo "</br>countObj PRIMA eliminazione : " . count($_SESSION['LabMatpriTeoria']);
                $deleteMat = false;
                $elim = 0;
                for ($j = 0; $j < count($_SESSION['LabMatpriTeoria']); $j++) {
                    if (isset($_POST['EliminaMat' . $_SESSION['LabMatpriTeoria'][$j]->getIdMat()])) {
                        $deleteMat = true;
                        $elim = $j;
//                        echo "</br>############## ELIMINAZIONE ####################</br>";
//                        echo "</br>" . $_SESSION['LabMatpriTeoria'][$j]->getCodMat() . "</br>";
                    }
                }

                if ($deleteMat) {

                    for ($j = $elim; $j < count($_SESSION['LabMatpriTeoria']) - 1; $j++) {
                        $_SESSION['LabMatpriTeoria'][$j] = $_SESSION['LabMatpriTeoria'][$j + 1];
                    }

                    array_pop($_SESSION['LabMatpriTeoria']);
                    $k = $k - 1;

//                    echo "</br>countObj DOPO eliminazione : " . count($_SESSION['LabMatpriTeoria']);
//                    for ($j = 0; $j < count($_SESSION['LabMatpriTeoria']); $j++) {
//                        echo "</br>j: " . $j;
//                        echo " - k: " . $k . "</br>";
//                        echo print_r($_SESSION['LabMatpriTeoria'][$j]);
//                    }
                }
                
                
                //##############################################################
                //################ STAMPA A VIDEO L'OGGETTO LabMatpriTeoria ########     
//                echo "</br>##### K :" . $k;
//                for ($j = 0; $j < count($_SESSION['LabMatpriTeoria']); $j++) {
//                    echo "</br>j: " . $j;
//                    echo " - k: " . $k . "</br>";
//                    echo print_r($_SESSION['LabMatpriTeoria'][$j]);
////                                $_SESSION['LabMatpriTeoria'][$j]->toString();
//                }
//                        echo "FINE : ".$j." k: ".$k;
                //#####################################################################
                //####### TOTALI CALCOLATI SULLE MATERIE  PRESENTI NELL'OGGETTO #######
                //#####################################################################
                //Inizializzo le variabili numeriche
                $TotaleQtaMt = 0;
                $CostoTotaleMt = 0;

                $TotaleQtaComp = 0;
                $CostoTotaleComp = 0;

                $TotaleQta = 0;
                $CostoTotale = 0;

                $TotalePercentuale = 0;

                $CostoTotalePercentuale = 0;

                $QuantitaPercentualeMt = 0;
                $CostoPercentualeMt = 0;

                $QuantitaPercentualeComp = 0;
                $CostoPercentualeComp = 0;

                $qtaTotPercMt = 0;
                $costoTotPerMt = 0;
                $qtaTotPercComp = 0;
                $costoTotPerComp = 0;
                //Calcolo il totale delle quantita e del costo per poter calcolare 
                //il valore ed il costo percentuale di ogni singola qta inserita
                for ($j = 0; $j < count($_SESSION['LabMatpriTeoria']); $j++) {
                    if (substr($_SESSION['LabMatpriTeoria'][$j]->getCodMat(), 0, 4) == $prefissoCodComp) {

                        $TotaleQtaComp = $TotaleQtaComp + $_SESSION['LabMatpriTeoria'][$j]->getQtaTeo();
                        $CostoTotaleComp = $CostoTotaleComp + ($_SESSION['LabMatpriTeoria'][$j]->getQtaTeo() * ($_SESSION['LabMatpriTeoria'][$j]->getCostoUnit() / $fatConvKgGrammi));
                    } else {


                        $TotaleQtaMt = $TotaleQtaMt + $_SESSION['LabMatpriTeoria'][$j]->getQtaTeo();
                        $CostoTotaleMt = $CostoTotaleMt + ($_SESSION['LabMatpriTeoria'][$j]->getQtaTeo() * ($_SESSION['LabMatpriTeoria'][$j]->getCostoUnit() / $fatConvKgGrammi));
                    }
                }
                //Totali di Materie prime + componenti prodotto		
                $TotaleQta = $TotaleQtaMt + $TotaleQtaComp;
                $CostoTotale = $CostoTotaleMt + $CostoTotaleComp;

                //Calcolo le percentuali sulle materie prime dell'oggetto
                for ($j = 0; $j < count($_SESSION['LabMatpriTeoria']); $j++) {

                    if (substr($_SESSION['LabMatpriTeoria'][$j]->getCodMat(), 0, 4) == $prefissoCodComp) {

                        $QuantitaComp = $_SESSION['LabMatpriTeoria'][$j]->getQtaTeo();
                        $CostoUnitarioComp = $_SESSION['LabMatpriTeoria'][$j]->getCostoUnit();
                        $CostoGrammiComp = $CostoUnitarioComp / $fatConvKgGrammi;

                        $CostoComp = $QuantitaComp * $CostoGrammiComp;
//                    $CostoTotaleComp = $CostoTotaleComp + $CostoComp;
                        //Trasformo le qta in percentuale
                        if ($TotaleQta > 0)
                            $QuantitaPercentualeComp = ($QuantitaComp * 100) / $TotaleQta;
                        $TotalePercentuale = $TotalePercentuale + $QuantitaPercentualeComp;


                        //Trasformo i costi in percentuale
                        if ($CostoTotale > 0)
                            $CostoPercentualeComp = ($CostoComp * 100) / $CostoTotale;
                        $CostoTotalePercentuale = $CostoTotalePercentuale + $CostoPercentualeComp;

                        //Utili solo per la visualizzazione
                        $qtaTotPercComp = $qtaTotPercComp + $QuantitaPercentualeComp;
                        $costoTotPerComp = $costoTotPerComp + $CostoPercentualeComp;
                        //Aggiorno il costo perc e la qta perc
                        $_SESSION['LabMatpriTeoria'][$j]->setCostoPerc($CostoPercentualeComp);
                        $_SESSION['LabMatpriTeoria'][$j]->setQtaTeoPerc($QuantitaPercentualeComp);
                    } else {

                        $QuantitaMatPrima = $_SESSION['LabMatpriTeoria'][$j]->getQtaTeo();
                        $CostoUnitarioMt = $_SESSION['LabMatpriTeoria'][$j]->getCostoUnit();
                        $CostoGrammiMt = $CostoUnitarioMt / $fatConvKgGrammi;


                        $CostoMt = $QuantitaMatPrima * $CostoGrammiMt;
                        //Trasformo le qta in percentuale
                        if ($TotaleQta > 0)
                            $QuantitaPercentualeMt = ($QuantitaMatPrima * 100) / $TotaleQta;
                        $TotalePercentuale = $TotalePercentuale + $QuantitaPercentualeMt;

                        //Trasformo i costi in percentuale
                        if ($CostoTotale > 0)
                            $CostoPercentualeMt = ($CostoMt * 100) / $CostoTotale;
                        $CostoTotalePercentuale = $CostoTotalePercentuale + $CostoPercentualeMt;

                        //Utili solo per la visualizzazione
                        $qtaTotPercMt = $qtaTotPercMt + $QuantitaPercentualeMt;
                        $costoTotPerMt = $costoTotPerMt + $CostoPercentualeMt;

                        $_SESSION['LabMatpriTeoria'][$j]->setCostoPerc($CostoPercentualeMt);
                        $_SESSION['LabMatpriTeoria'][$j]->setQtaTeoPerc($QuantitaPercentualeMt);
                    }
                }

                //####### ORDINAMENTO DELL' ARRAY IN BASE AL PRIMO INDICE (COD_MAT) ########
//                sort($_SESSION['LabMatpriTeoria']);
                usort ( $_SESSION['LabMatpriTeoria'], array( 'LabMatpriTeoria', 'comparaCodMat' ));
                //##########################################################################
                //##############  CREAZIONE OGGETTO LAB PARAMETRO ##########################
                //##########################################################################
                //Recupero i parametri selezionati
                $NPar = 0;
                if (mysql_num_rows($sqlPar) > 0)
                    mysql_data_seek($sqlPar, 0);
                while ($rowPar = mysql_fetch_array($sqlPar)) {

                    $NPar = $rowPar['id_par'];

                    $QuantitaPar = 0;
                    $QuantitaParPerc = 0;

                    if (isset($_POST['QtaPar' . $NPar])) {
                        $QuantitaPar = $_POST['QtaPar' . $NPar];

                        if ($rowPar['tipo'] == $PercentualeSI AND $TotaleQta > 0)

                        //Calcolo la percentuale 
                            $QuantitaParPerc = number_format(($_POST['QtaPar' . $NPar] * 100) / $TotaleQta, $PrecisioneQta, '.', '');

                        //##### SALVO LE MATERIE PRIME SELEZIONATE IN UN OGGETTO NELLA SESSIONE ###
                        if ($QuantitaPar > 0) {

                            //Salvo le quantità nell' oggetto
                            //Verifico se il parametro è già salvato nell'oggetto
                            //se si -> faccio un update dell'oggetto senza  incrementare p 
                            //se no -> creo un nuovo oggetto e incremento p
                            $updateParObj = false;
                            for ($j = 0; $j < count($_SESSION['LabParTeoria']); $j++) {

                                if ($_SESSION['LabParTeoria'][$j]->getNomePar() == $rowPar['nome_parametro']) {

                                    $updateParObj = true;
                                    $_SESSION['LabParTeoria'][$j]->setCodLabFormula($CodiceFormula);
                                    $_SESSION['LabParTeoria'][$j]->setValoreTeo($QuantitaPar);
                                    $_SESSION['LabParTeoria'][$j]->setValoreTeoPerc($QuantitaParPerc);
                                }
                            }
                            if (!$updateParObj) {
//                echo "nuovo oggetto parametro";

                                $_SESSION['LabParTeoria'][$p] = new LabParTeoria($CodiceFormula, $rowPar['nome_parametro'], $rowPar['id_par'], $rowPar['unita_misura'], $rowPar['tipo'], $QuantitaPar, $QuantitaParPerc);

                                $p++;
                            }
                        }
                    }
                }//End While par
                //##############################################################
                //############## EVENTUALE ELIMINAZIONE PARAMETRI ##############
                //##############################################################
//                echo "</br>countObj PRIMA eliminazione : " . count($_SESSION['LabParTeoria']);
                $deletePar = false;
                $elimP = 0;
                for ($j = 0; $j < count($_SESSION['LabParTeoria']); $j++) {
                    if (isset($_POST['EliminaPar' . $_SESSION['LabParTeoria'][$j]->getIdPar()])) {
                        $deletePar = true;
                        $elimP = $j;
//                        echo "</br>############## ELIMINAZIONE ####################</br>";
//                        echo "</br>" . $_SESSION['LabParTeoria'][$j]->getNomePar() . "</br>";
                    }
                }

                if ($deletePar) {

                    for ($j = $elimP; $j < count($_SESSION['LabParTeoria']) - 1; $j++) {
                        $_SESSION['LabParTeoria'][$j] = $_SESSION['LabParTeoria'][$j + 1];
                    }

                    array_pop($_SESSION['LabParTeoria']);
                    $p = $p - 1;
                }

                //####### ORDINAMENTO DELL' ARRAY IN BASE AL PRIMO INDICE (COD_MAT) ########
//                sort($_SESSION['LabParTeoria']);
                usort ( $_SESSION['LabParTeoria'], array( 'LabParTeoria', 'comparaNomePar' ));

//    echo "</br>countObj DOPO aggiornamento : " . count($_SESSION['LabParTeoria']);
//    for ($j = 0; $j < count($_SESSION['LabParTeoria']); $j++) {
//        echo "</br>j: " . $j;
//        echo " - p: " . $p . "</br>";
//        echo print_r($_SESSION['LabParTeoria'][$j]);
//    }
                //################# FINE OGGETTO LAB PARAMETRO TEORIA ######################
                ?>
                <div id="container" style="width:95%; margin:15px auto;">
                    <form id="DuplicaLabFormula" name="DuplicaLabFormula" method="POST" >

                        <table width="100%" >
                            <tr>
                                <td height="42" colspan="2" class="cella3"><?php echo $titoloPaginaLabDuplica . " " . $CodiceFormulaOld; ?></td>
                            </tr>
                            <!--#####################################################################-->
                            <!--####################  ANAGRAFE FORMULA ##############################-->
                            <!--#####################################################################-->
                            <?php include('moduli/visualizza_lab_form_mod_prod_ob.php'); ?>
                            <tr>
                                <td width="300" class="cella4"><?php echo $filtroLabNorma ?></td>
                                <td class="cella1" >
                                    <select name="Normativa" id="Normativa">
                                        <option value="" selected=""><?php echo $labelOptionSelectNormativa ?> </option>
                                        <option value="<?php echo $_POST['Normativa'] ?>" selected="<?php echo $_POST['Normativa'] ?>"><?php echo $Normativa ?></option>
                                        <?php
                                        if (mysql_num_rows($sqlNorma) > 0)
                                            mysql_data_seek($sqlNorma, 0);
                                        while ($rowNorma = mysql_fetch_array($sqlNorma)) {
                                            ?>
                                            <option value="<?php echo $rowNorma['normativa']; ?>"><?php echo $rowNorma['normativa']; ?></option>
                                        <?php } ?>
                                    </select> 
                                </td>
                            </tr>    
                            <tr>
                                <td width="300" class="cella4"><?php echo $filtroLabCodice ?></td>
                                <td class="cella1"><input type="text" name="CodiceFormula" id="CodiceFormula" value="<?php echo $CodiceFormula; ?>"/></td>
                            </tr>
                            <input type="hidden" name="CodiceFormulaOld" id="CodiceFormulaOld" value="<?php echo $CodiceFormulaOld; ?>"/>
                            <tr>
                                <td class="cella4"><?php echo $filtroLabData ?></td>
                                <td class="cella1"><?php echo dataCorrenteVisualizza(); ?></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroLabUtente ?></td>
                                <td class="cella1"><?php echo $_SESSION['username'] ?></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroLabGruppo ?></td>
                                <td class="cella1"><?php echo $_SESSION['nome_gruppo_utente'] ?></td>
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
                            <tr>
                                <td class="cella4"><?php echo $filtroVisibilita ." ".$filtroLabFormula ?></td>
                                <td class="cella1" ><input type="text" name="VisibilitaFormula" id="VisibilitaFormula" value="<?php echo $VisibilitaFormula ?>"/><span class="commentiStyle"><?php echo $titleVisibilita.' '.$_SESSION['visibilita_utente'].' '.$titleVisibilita2 ?></span></td>
                            </tr>
                        </table>
                        <!--######################################################################-->
                        <!--##############  VISUALIZZAZIONE OGGETTO FORMULA ######################-->
                        <!--######################################################################-->
                        <?php if (count($_SESSION['LabMatpriTeoria']) > 0) { ?>
                            <table width="100%">
                                <tr>
                                    <th class="cella3" width="400px" colspan="2"><?php echo $filtroLabMateriePrimeFormula ?></th>
                                    <td class="cella3" width="10px"><?php echo $filtroLabUnMisura ?></td>
                                    <td class="cella3" width="80px" title="<?php echo $filtroCostoKilo ?>"><?php echo $filtroLabCostoUnit ?></td>
                                    <td class="cella3"><?php echo $filtroLabQta ?></td>           
                                    <td class="cella3"><?php echo $filtroLabCosto ?> </td>
                                    <td class="cella3"><?php echo $filtroLabQta . " " . $filtroLabPerc ?></td>
                                    <td class="cella3"><?php echo $filtroLabCosto . " " . $filtroLabPerc ?></td>
                                    <td class="cella3" title="<?php echo $titleLabCampoVar ?>"><?php echo $filtroLabVariabile ?></td>
                                    <td class="cella3" width="3%"><img src="/CloudFab/images/pittogrammi/patumiera_G.png" class="icone"  title="<?php echo $titleElimina ?> " onClick="javascript:AggiornaCalcoli();"/></td>
                                </tr> <?php
                                for ($i = 0; $i < count($_SESSION['LabMatpriTeoria']); $i++) {
                                    $classeCella = "cella1";
                                    $title = $filtroMtCompound;
                                    if (substr($_SESSION['LabMatpriTeoria'][$i]->getCodMat(), 0, 4) == $prefissoCodComp) {
                                        $classeCella = "cella4";
                                        $title = $filtroMtDrymix;
                                    }
                                    ?>
                                    <tr>
                                        <td class="<?php echo $classeCella ?>" title="<?php echo $title ?>"><?php echo $_SESSION['LabMatpriTeoria'][$i]->getCodMat() ?> </td> 
                                        <td class="<?php echo $classeCella ?>" title="<?php echo $title ?>"><?php echo $_SESSION['LabMatpriTeoria'][$i]->getDescriMat() ?></td> 
                                        <td class="<?php echo $classeCella ?>" width="5%"><?php echo $_SESSION['LabMatpriTeoria'][$i]->getUniMis() ?></td> 
                                        <td class="<?php echo $classeCella ?>"><?php echo $_SESSION['LabMatpriTeoria'][$i]->getCostoUnit() . " " . $filtroEuro ?></td> 
                                        <td class="<?php echo $classeCella ?>"><?php echo number_format($_SESSION['LabMatpriTeoria'][$i]->getQtaTeo(), $PrecisioneQta, '.', '') . " " . $filtrogBreve ?> </td> 
                                        <td class="<?php echo $classeCella ?>"><?php echo number_format($_SESSION['LabMatpriTeoria'][$i]->getCosto(), $PrecisioneQta, '.', '') . " " . $filtroEuro ?></td>
                                        <td class="<?php echo $classeCella ?>"><?php echo number_format($_SESSION['LabMatpriTeoria'][$i]->getQtaTeoPerc(), $PrecisioneQta, '.', '') . " " . $filtroPerc ?> </td> 
                                        <td class="<?php echo $classeCella ?>"><?php echo number_format($_SESSION['LabMatpriTeoria'][$i]->getCostoPerc(), $PrecisioneQta, '.', '') . " " . $filtroPerc ?></td>  
                                        <td class="<?php echo $classeCella ?>"><?php echo $_SESSION['LabMatpriTeoria'][$i]->getTipo() ?></td>  
                                        <td class="<?php echo $classeCella ?>"><input type="checkbox" name="EliminaMat<?php echo $_SESSION['LabMatpriTeoria'][$i]->getIdMat() ?>" title="<?php echo $titleElimina ?>" /></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td class="dataRigWhite" colspan="4"><?php echo $filtroLabTotaleMatPri ?></td>
                                    <td class="dataRigWhite"><?php echo number_format($TotaleQtaMt, $PrecisioneQta, '.', '') . " " . $filtroLabGrammo ?></td>
                                    <td class="dataRigWhite"><?php echo number_format($CostoTotaleMt, $PrecisioneCosti, '.', '') . " " . $filtroLabEuro ?></td>
                                    <td class="dataRigWhite"><?php echo number_format($qtaTotPercMt, $PrecisioneQta, '.', '') . " " . $filtroLabPerc ?></td>
                                    <td class="dataRigWhite"><?php echo number_format($costoTotPerMt, $PrecisioneCosti, '.', '') . " " . $filtroLabPerc ?></td>
                                    <td class="dataRigWhite" colspan="2"></td>
                                </tr>
                                <tr>
                                    <td class="dataRigWhite" colspan="4"><?php echo $filtroLabTotaleDryMix ?></td>
                                    <td class="dataRigWhite"><?php echo number_format($TotaleQtaComp, $PrecisioneQta, '.', '') . " " . $filtroLabGrammo ?></td>
                                    <td class="dataRigWhite"><?php echo number_format($CostoTotaleComp, $PrecisioneCosti, '.', '') . " " . $filtroLabEuro ?></td>
                                    <td class="dataRigWhite"><?php echo number_format($qtaTotPercComp, $PrecisioneQta, '.', '') . " " . $filtroLabPerc ?></td>
                                    <td class="dataRigWhite"><?php echo number_format($costoTotPerComp, $PrecisioneCosti, '.', '') . " " . $filtroLabPerc ?></td>
                                    <td class="dataRigWhite" colspan="2"></td>
                                </tr>
                                <tr>
                                    <td class="dataRigWhite" colspan="4"><?php echo $filtroLabTotaleCompDry ?></td>
                                    <td class="dataRigWhite"><?php echo number_format($TotaleQta, $PrecisioneQta, '.', '') . " " . $filtroLabGrammo ?></td>
                                    <td class="dataRigWhite"><?php echo number_format($CostoTotale, $PrecisioneCosti, '.', '') . " " . $filtroLabEuro ?></td>
                                    <td class="dataRigWhite"><?php echo number_format($TotalePercentuale, $PrecisioneQta, '.', '') . " " . $filtroLabPerc ?></td>
                                    <td class="dataRigWhite"><?php echo number_format($CostoTotalePercentuale, $PrecisioneCosti, '.', '') . " " . $filtroLabPerc ?></td>
                                    <td class="dataRigWhite" colspan="2"></td>
                                </tr>
                            </table>
                            <?php
                        }


                        //######################################################################
                        //##############  VISUALIZZAZIONE OGGETTO LAB PARAMETRI ################
                        //######################################################################
                        if (count($_SESSION['LabParTeoria']) > 0) {
//        echo "oggetto pieno count: " . count($_SESSION['LabParTeoria']) 
                            ?>
                            <table width="100%">
                                <tr>
                                    <th class="cella3"><?php echo $filtroLabParametri ?> </th>
                                    <td class="cella3"><?php echo $filtroLabTipo ?></td>
                                    <td class="cella3"><?php echo $filtroLabUnMisura ?></td>
                                    <td class="cella3"><?php echo $filtroLabQta ?></td>
                                    <td class="cella3"><?php echo $filtroLabQta . " " . $filtroLabPerc ?></td>

                                    <td class="cella3" width="3%"><img src="/CloudFab/images/pittogrammi/patumiera_G.png" class="icone"  title="<?php echo $titleElimina ?> " onClick="javascript:AggiornaCalcoli();"/></td>
                                </tr> 
                                <?php
                                for ($i = 0; $i < count($_SESSION['LabParTeoria']); $i++) {
                                    $classeCella = "cella1";

                                    if ($_SESSION['LabParTeoria'][$i]->getTipo() == $PercentualeNO) {
                                        $classeCella = "cella4";
                                    }
                                    ?>
                                    <tr>
                                        <td class="<?php echo $classeCella ?>"><?php echo $_SESSION['LabParTeoria'][$i]->getNomePar() ?> </td>
                                        <td class="<?php echo $classeCella ?>"><?php echo $_SESSION['LabParTeoria'][$i]->getTipo() ?></td>
                                        <td class="<?php echo $classeCella ?>" width="5%"><?php echo $_SESSION['LabParTeoria'][$i]->getUniMis() ?></td> 
                                        <td class="<?php echo $classeCella ?>"><?php echo number_format($_SESSION['LabParTeoria'][$i]->getValoreTeo(), $PrecisioneQta, '.', '') ?> </td> 
                                        <td class="<?php echo $classeCella ?>"><?php echo number_format($_SESSION['LabParTeoria'][$i]->getValoreTeoPerc(), $PrecisioneQta, '.', '') . " " . $filtroPerc ?> </td> 
                                        <td class="<?php echo $classeCella ?>"><input type="checkbox" name="EliminaPar<?php echo $_SESSION['LabParTeoria'][$i]->getIdPar() ?>" title="<?php echo $titleElimina ?>" /></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </table>


                        <!--#####################################################################-->
                        <!--####################  MATERIE PRIME #################################-->
                        <!--#####################################################################-->
                        <input type="hidden" name="k" value="<?php echo $k ?>"  />
                        <table width="100%">
                            <tr>
                                <th class="cella3" width="50%" colspan="3"><?php echo $filtroLabMatPrimeSel ?></th>
                                <td class="cella3" width="20%"><?php echo $filtroLabTipo ?></td>
                                <td class="cella3" width="5%"><?php echo $filtroLabUnMisura ?></td>
                                <td class="cella3" width="5%" title="<?php echo $titleLabCostoKgMat ?>"><?php echo $filtroLabCostoUnit ?></td>           
                                <td class="cella3" width="10%"><?php echo $filtroLabQta ?> </td>                                           
                                <td class="cella3" width="5%" title="<?php echo $titleLabCampoVar ?>"><?php echo $filtroLabVariabile ?></td>
                            </tr>
                            <!--#####################################################################-->
                            <!--#########  FILTRI SELEZIONE MATERIE PRIME ###########################-->
                            <!--#####################################################################-->
                            <tr>
                                <td class="cella4" colspan="2"><input type="text"  name="CodMat" value="<?php echo $_SESSION['CodMat'] ?>" onChange="javascript:AggiornaCalcoli();"/></td>
                                <td class="cella4" ><input type="text"  name="DescriMat" value="<?php echo $_SESSION['DescriMat'] ?>" onChange="javascript:AggiornaCalcoli();"/></td>
                                <td class="cella4" colspan="3">
                                    <select style="width:50%" name="TipoMat" id="TipoMat"  onChange="javascript:AggiornaCalcoli();" title="<?php echo $titleLabSelectTipoMat ?>">
                                        <option value="<?php echo $_SESSION['TipoMat'] ?>" selected="<?php echo $_SESSION['TipoMat'] ?>"><?php echo $_SESSION['TipoMat'] ?></option>
                                        <?php
                                        if (mysql_num_rows($sqlTipo))
                                            mysql_data_seek($sqlTipo, 0);
                                        while ($rowTip = mysql_fetch_array($sqlTipo)) {
                                            ?>
                                            <option value="<?php echo $rowTip['tipo']; ?>"><?php echo $rowTip['tipo']; ?></option>
                                        <?php } ?>
                                    </select></td> 
                                <td class="cella4" style="text-align: right" colspan="2"><input type="button" onclick="javascript:AggiornaCalcoli();"  value="<?php echo $valueButtonAggiorna ?>" /></td>

                            </tr>
                            <?php
                            $classeCella = "cella1";
                            $title = $filtroMtCompound;
                            //Visualizzo l'elenco delle materie prime presenti nella 
                            //tabella [lab_materia_prima]
                            $NMatPri = 0;
                            if (mysql_num_rows($sqlMatPrime) > 0)
                                mysql_data_seek($sqlMatPrime, 0);
                            while ($rowMatPrime = mysql_fetch_array($sqlMatPrime)) {

                                if (substr($rowMatPrime['cod_mat'], 0, 4) == $prefissoCodComp) {
                                    $classeCella = "cella2";
                                    $title = $filtroMtDrymix;
                                }

                                $NMatPri = $rowMatPrime['id_mat'];
                                $CostoUnitarioMt = $rowMatPrime['prezzo']; //costo al kilo
                                ?>
                                <tr>
                                    <td class="<?php echo $classeCella ?>" >
                                        <a target="_blank" href="modifica_lab_materia.php?IdMateria=<?php echo($rowMatPrime['id_mat']) ?>&Pagina=<?php echo $Pagina; ?>" title="<?php echo $titleLabInsNota ?>">
                                            <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="<?php echo $titleLabInsNota ?>"/> 
                                        </a>
                                    </td>                       
                                    <td class="<?php echo $classeCella ?>" title="<?php echo $title ?>" width="90px"><?php echo($rowMatPrime['cod_mat']) ?></td>
                                    <td class="<?php echo $classeCella ?>" title="<?php echo $title ?>"><?php echo($rowMatPrime['descri_materia']) ?></td>
                                    <td class="<?php echo $classeCella ?>"><?php echo($rowMatPrime['tipo']) ?></td>
                                    <td class="<?php echo $classeCella ?>"><?php echo $rowMatPrime['unita_misura'] ?></td>

                                    <?php
                                    //Se è stata impostata una quantità per la materia prima o è stata definita variabile
                                    if (isset($_POST['QtaMt' . $NMatPri])) {
                                        ?>
                                        <td class="<?php echo $classeCella ?>"><?php echo number_format($CostoUnitarioMt, $PrecisioneCosti, '.', '') . " " . $filtroLabEuro; ?> </td>
                                        <td class="<?php echo $classeCella ?>" width="100px"><input type="text" style="width:80%" name="QtaMt<?php echo($NMatPri); ?>" id="QtaMt<?php echo($NMatPri); ?>" value="<?php echo $_POST['QtaMt' . $NMatPri]; ?>"/><?php echo $filtroLabGrammo ?></td>
                                    <?php } else { ?>
                                        <td class="<?php echo $classeCella ?>" ><?php echo number_format($CostoUnitarioMt, $PrecisioneCosti, '.', '') . " " . $filtroLabEuro; ?></td>
                                        <td class="<?php echo $classeCella ?>" width="100px"><input type="text" style="width:80%" name="QtaMt<?php echo($NMatPri); ?>" id="QtaMt<?php echo($NMatPri); ?>" value="0"/><?php echo $filtroLabGrammo ?></td>

                                        <?php
                                    }

                                    if (isset($_POST['MatKeVaria' . $NMatPri])) {
                                        ?>
                                        <td class="<?php echo $classeCella ?>" ><input type="checkbox" name="MatKeVaria<?php echo($NMatPri); ?>" value="<?php echo $_POST['MatKeVaria' . $NMatPri]; ?>" checked="checked" title="<?php echo $titleLabCampoVar ?>"/></td>

                                        <?php
                                    } else {
                                        ?>
                                        <td class="<?php echo $classeCella ?>" >
                                            <input type="checkbox" name="MatKeVaria<?php echo($NMatPri); ?>" value="" title="<?php echo $titleLabCampoVar ?>"/></td>

                                        <?php
                                    }
                                    ?>
                                </tr>
                                <?php
                            }//End While Materie Prima
                            ?>
                        </table>

                        <!--#####################################################################-->
                        <!--####################  PARAMETRI #####################################-->
                        <!--#####################################################################-->
                        <input type="hidden" name="p" value="<?php echo $p ?>"  />                        
                        <table width="100%">
                            <tr>
                                <th class="cella3"><?php echo $filtroLabParametri ?> </th>
                                <th class="cella3"><?php echo $filtroLabTipo ?> </th>
                                <td class="cella3"><?php echo $filtroLabUnMisura ?></td>
                                <td class="cella3"><?php echo $filtroLabQta ?></td>
                                <td class="cella3"><?php echo $filtroLabQta . " " . $filtroLabPerc ?></td>
                            </tr> 
                            <tr>
                                <td class="cella4" ><input type="text"  name="NomePar" value="<?php echo $_SESSION['NomePar'] ?>" onChange="javascript:AggiornaCalcoli();"/></td>
                                <td class="cella4" ><input type="text"  name="TipoPar" value="<?php echo $_SESSION['TipoPar'] ?>" onChange="javascript:AggiornaCalcoli();"/></td>
                                <td class="cella4" style="text-align: right" colspan="3"><input type="button" value="<?php echo $valueButtonAggiorna ?>" onclick="javascript:AggiornaCalcoli();"/></td>
                            </tr>

                            <?php
                            //Visualizzo i parametri
                            $NPar = 0;
                            if (mysql_num_rows($sqlPar))
                                mysql_data_seek($sqlPar, 0);
                            while ($rowPar = mysql_fetch_array($sqlPar)) {
                                $NPar = $rowPar['id_par'];
                                $QtaNew = 0;
                                if ($TotaleQta > 0)
                                //Calcolo la percentuale e mando direttamente il risultato al post
                                    $QtaNew = number_format(($_POST['QtaPar' . $NPar] * 100) / $TotaleQta, $PrecisioneQta, '.', '');

                                $nomeClassePar = "cella1";

                                if ($rowPar['tipo'] == $PercentualeNO) {
                                    $nomeClassePar = "cella4";
                                }
                                $qtaPar=0;
                                if(isSet($_POST['QtaPar' . $NPar]) AND $_POST['QtaPar' . $NPar]!=""){
                                    $qtaPar=$_POST['QtaPar' . $NPar];
                                }
                                ?>
                                <tr>
                                    <td class="<?php echo $nomeClassePar ?>"><?php echo($rowPar['nome_parametro']); ?></td>
                                    <td class="<?php echo $nomeClassePar ?>"><?php echo($rowPar['tipo']); ?></td>
                                    <td class="<?php echo $nomeClassePar ?>"><?php echo ($rowPar['unita_misura']); ?></td>
                                    <td class="<?php echo $nomeClassePar ?>"><input type="text" name="QtaPar<?php echo($NPar); ?>" id="QtaPar<?php echo($NPar); ?>" value="<?php echo $qtaPar; ?>" /></td>
                                    <td class="<?php echo $nomeClassePar ?>"><input type="text" name="QtaParPerc<?php echo($NPar); ?>" id="QtaParPerc<?php echo($NPar); ?>" value="<?php echo $QtaNew; ?>" /></td>
                                </tr>

                                <?php
                             
                            }//End While parametri
                            //###############################################################################
                            //###############################################################################
                            ?>
                            <tr>
                                <td class="cella2" style="text-align: right " colspan="5">
                                    <input type="reset"  onClick="javascript:history.back();" value="<?php echo $valueButtonAnnulla ?>"/>
                                    <input type="button" onClick="javascript:AggiornaCalcoli();" title ="<?php echo $titleAggiorna ?>" value="<?php echo $valueButtonAggiorna ?>"/>
                                    <input type="button" onClick="javascript:Carica();" value="<?php echo $valueButtonSalva ?>"/>
                                </td>
                            </tr>
                        </table>
                    </form>      
                </div>

                <?php
//           }//End if errore sull'aggiornamento
            }//End Aggiornamento
            ?>
            <div id="msgLog">
                <?php
                if ($DEBUG) {

                    echo "</br>Tab lab_formula : Utenti e aziende visibili " . $strUtentiAziende;
                    echo "</br>Tab lab_materie_prime : Utenti e aziende visibili " . $strUtentiAziendeMatPri;
                    echo "</br>Tab lab_normativa : Utenti e aziende visibili " . $strUtentiAziendeNorm;
                    echo "</br>Tab lab_parametro : Utenti e aziende visibili " . $strUtentiAziendeParam;
                    echo "</br>Tabella lab_formula: AZIENDE SCRIVIBILI: ";
                    for ($i = 0; $i < count($arrayAziendeScrivibili); $i++) {

                        echo $arrayAziendeScrivibili[$i]->getIdAzienda() . " " . $arrayAziendeScrivibili[$i]->getNomeAzienda() . "</br>";
                    }
                }
                ?>
            </div>
    </div><!--labContainer-->
</body>
</html>
