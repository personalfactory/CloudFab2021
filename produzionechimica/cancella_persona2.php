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
            include('../Connessioni/storico.php');
            include('../sql/script.php');
            include('../sql/script_generazione_formula.php');

            $CodiceMatPrima = $_GET['CodiceMatPrima'];
            $CodiceFormula = $_GET['CodiceFormula'];
//Storicizzo la materia prima che intendo cancellare

            $insertStorico = true;
            $deleteMateriaPrima = true;

//1.	Seleziono la vecchia materia prima dalla tabella corrente [generazione formula] di  serverdb;
            $sqlMatPrima = findMatPrimaByFormulaAndCod($CodiceFormula, $CodiceMatPrima);


            while ($rowMatPrima = mysql_fetch_array($sqlMatPrima)) {
                $id_gen_form = $rowMatPrima['id_gen_form'];
                $cod_mat = $rowMatPrima['cod_mat'];
                $cod_formula = $rowMatPrima['cod_formula'];
                $quantita = $rowMatPrima['quantita'];
                $dt_inser = $rowMatPrima['dt_inser'];
            }

            
            begin();
            
//2.	Inserisco la vecchia materia prima appena selezionato nella tabella storica 
//[generazione formula], ponendo il campo abilitato uguale a zero e aggiornando 
//il campo dt_abilitato con data corrente;
            $insertStorico = storicizzaGenerazioneFormula($id_gen_form, $cod_formula, $cod_mat, $quantita, $dt_inser, $valDisabilitato, dataCorrenteInserimento());


//5.	Cancello il componente dalla tabella corrente [componente_prodotto] di serverdb.
            $deleteMateriaPrima = eliminaRecordGenFormulaById($id_gen_form);

            if (!$insertStorico OR !$deleteMateriaPrima) {

                rollback();
                echo $msgTransazioneFallita . ' <a href="modifica_formula.php?CodiceFormula=' . $CodiceFormula . '">' . $msgErrContactAdmin . '</a><br/>';
            } else {

                commit();
                mysql_close();
                echo $msgModificaCompletata . ' <a href="modifica_formula.php?CodiceFormula=' . $CodiceFormula . '">' . $msgOk . '</a><br/>';
            }
            ?>

        </div>
    </body>
</html>