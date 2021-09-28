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
            include('../include/gestione_date.php');
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_formula.php');
            include('../sql/script_generazione_formula.php');

            $CodiceFormula = $_POST['CodiceFormula'];

//            $sqlAnFormula = findAnFormulaByCodice($CodiceFormula);
//            while ($rowFormula = mysql_fetch_array($sqlAnFormula)) {
//
//                $DataFormula = $rowFormula['dt_formula'];
//                $DescriFormula = $rowFormula['descri_formula'];
//                $NumSacchettiTot = $rowFormula['num_sac'];
//                $QtaSacchetto = $rowFormula['qta_sac'];
//                $Abilitato = $rowFormula['abilitato'];
//                $Data = $rowFormula['dt_abilitato'];
//                $IdAzienda = $rowFormula['id_azienda'];
//                $IdUtenteProp = $rowFormula['id_utente'];
//                $NumeroLotti = $rowFormula['num_lotti'];
//                $QtaMiscelaInserita = $rowFormula['qta_tot_miscela'];
//                $PesoLotto = $rowFormula['qta_lotto'];
//                $NumeroKitSacchetti = $rowFormula['num_sac_in_lotto'];
//                $MetodoCalcolo = $rowFormula['metodo_calcolo'];
//            }
//            $TotaleQtaKit = 0;
//            $sqlMtPr = findMaterieFormulaByCodice($CodiceFormula, "descri_mat");
//            while ($rowMtPr = mysql_fetch_array($sqlMtPr)) {
//                //Quantità di materia prima per kit chimico 
//                $TotaleQtaKit = $TotaleQtaKit + $rowMtPr['qta_kit'];
//            }
//################## Gestione degli errori ##################################
//Verifico che la materia sia stata settata e che non sia vuota
            $errore = false;
            $messaggio = '';

            if (!isset($_POST['MateriaPrima']) || trim($_POST['MateriaPrima']) == "") {

                $errore = true;
                $messaggio = $messaggio . " " . $msgErrSelectMateriaPrima . '<br />';
            }
            if (!is_numeric($_POST['Quantita'])) {
                $errore = true;
                $messaggio = $messaggio . " " . $msgErrQtaNumerica . "<br />";
            }
            if ($_POST['Quantita'] < 0) {
                $errore = true;
                $messaggio = $messaggio . " " . $msgErrQtaMagZero . "<br />";
            }

            $CodiceMateriaPrima = $_POST['MateriaPrima'];
            $QuantitaKit = $_POST['Quantita'];
            $QtaMiscela=0;//????
            

            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
            $insertGenForm = true;
            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {

                //Ricalcolo formula
//                $TotaleQtaKit = $TotaleQtaKit + $QuantitaKit;
//                //################ CHIMICA SFUSA ###########################################
//                if ($MetodoCalcolo == $valMetodoMiscelaTot) {
//
//                    if ($PesoLotto > 0)
//                        $NumeroLotti = number_format($QtaMiscelaInserita / $PesoLotto, 2, '.', '');
//                    if ($TotaleQtaKit > 0)
//                        $NumeroKitSacchetti = number_format($PesoLotto / $TotaleQtaKit, 1, '.', '');
//                    
//                    $QtaMiscela=($QtaMiscelaInserita*$QuantitaKit)/$TotaleQtaKit;
//                    //################ CHIMICA CLASSICA IN KIT E LOTTI #####################
//                } else if ($MetodoCalcolo == $valMetodoLottiKit) {
//
//                    $PesoLotto = $TotaleQtaKit * $NumeroKitSacchetti;
//                    $QtaMiscelaInserita = $TotaleQtaKit * $NumeroKitSacchetti * $NumeroLotti;
//                    $QtaMiscela = $QuantitaKit * $NumeroKitSacchetti * $NumeroLotti;
//                }
//                $NumSacchetti=$NumeroKitSacchetti*$NumeroLotti;
                //Inserisco nella tabella generazione_formula
                // la nuova mat prima solo la qta per kit
                begin();
                $insertGenForm = inserisciGenerazioneFormula(
                        $CodiceMateriaPrima, $CodiceFormula, $QtaMiscela, $QuantitaKit, dataCorrenteInserimento(), $valAbilitato, dataCorrenteInserimento());

//                //TO DO: aggiornare la qta tot di miscela nella tabella formula
//                $updateFormula = updateFormulaByCodice($CodiceFormula, $DescriFormula, $NumSacchetti, $TotaleQtaKit, 
//                        $NumeroKitSacchetti,$NumeroLotti,$PesoLotto,$QtaMiscelaInserita,"1", dataCorrenteInserimento(),$MetodoCalcolo,$IdAzienda);

                if (!$insertGenForm) {
                    rollback();
                    echo $msgTransazioneFallita . ' <a href="javascript:history.back()">' . $msgErrContactAdmin . '</a><br/>';
                } else {
                    commit();
                    ?>
                    <script type="text/javascript">
                        location.href = "modifica_formula.php?CodiceFormula=<?php echo $CodiceFormula ?>";
                    </script>
                    <?php
                }
            }//fine primo if($errore) controllo degli input relativo al prodotto 
            ?>

        </div>
    </body>
</html>
