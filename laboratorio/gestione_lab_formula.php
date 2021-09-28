<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
     <?php
    if($DEBUG) ini_set('display_errors', 1);
    //##########################################################################            
    //NOTE GESTIONE UTENTI
    //1) Si verifica se l'utente ha il permesso di visualizzare la lista delle formule (106)
    //2) Si verifica se l'utente ha il permesso di visualizzare il dettaglio di una formula (107)
    //3) Si verifica se l'utente ha il permesso di editare la tabella formula (108)
    //4) Si verifica se l'utente ha il permesso di visualizzare il dettaglio del prodotto target (109)
    //############# VERIFICA PERMESSI ##########################################
    $actionOnLoad="";
    $elencoFunzioni = array("106","107","108","109");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni,$_SESSION['objPermessiVis']);
    //############# STRINGHE UTENTI - AZIENDE VISIBILI##########################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
    $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_formula');       
    //##########################################################################
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="labContainer">
       <?php 
              
            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('./sql/script.php');
            include('./sql/script_lab_formula.php');

            $_SESSION['ProdOb'] = "";
            $_SESSION['Normativa'] = "";
            $_SESSION['CodLabFormula'] = "";
            $_SESSION['DtLabForm'] = "";
            $_SESSION['LabFormVisibilita'] = "";
            $_SESSION['LabUtente'] = "";
            $_SESSION['LabGruppo'] = "";
            $_SESSION['ProdObList'] = "";
            $_SESSION['NormativaList'] = "";
            $_SESSION['CodLabFormulaList'] = "";
            $_SESSION['DtLabFormList'] = "";
            $_SESSION['LabFormVisibilitaList'] = "";
            $_SESSION['LabUtenteList'] = "";
            $_SESSION['LabGruppoList'] = "";
            
            if(isset($_POST['ProdOb'])){
                $_SESSION['ProdOb'] = trim($_POST['ProdOb']);}    
            if (isset($_POST['ProdObList']) AND $_POST['ProdObList'] != "") {
                $_SESSION['ProdOb'] = trim($_POST['ProdObList']);
            }
            
            if(isset($_POST['Normativa'])){
                $_SESSION['Normativa'] = trim($_POST['Normativa']);}
            if (isset($_POST['NormativaList']) AND $_POST['NormativaList'] != "") {
                $_SESSION['Normativa'] = trim($_POST['NormativaList']);
            }
            
            if(isset($_POST['CodLabFormula'])){
            $_SESSION['CodLabFormula'] = trim($_POST['CodLabFormula']);}
            if (isset($_POST['CodLabFormulaList']) AND $_POST['CodLabFormulaList'] != "") {
                $_SESSION['CodLabFormula'] = trim($_POST['CodLabFormulaList']);
            }
            
            if(isset($_POST['DtLabForm'])){
            $_SESSION['DtLabForm'] = trim($_POST['DtLabForm']);}
            if (isset($_POST['DtLabFormList']) AND $_POST['DtLabFormList'] != "") {
                $_SESSION['DtLabForm'] = trim($_POST['DtLabFormList']);
            }
            if(isset($_POST['LabFormVisibilita'])){
            $_SESSION['LabFormVisibilita'] = trim($_POST['LabFormVisibilita']);
            }
            if (isset($_POST['LabFormVisibilitaList']) AND $_POST['LabFormVisibilitaList'] != "") {
                $_SESSION['LabFormVisibilita'] = trim($_POST['LabFormVisibilitaList']);
            }
            
            if(isset($_POST['LabUtente'])){
            $_SESSION['LabUtente'] = trim($_POST['LabUtente']);}
            if (isset($_POST['LabUtenteList']) AND $_POST['LabUtenteList'] != "") {
                $_SESSION['LabUtente'] = trim($_POST['LabUtenteList']);
            }

            if(isset($_POST['LabGruppo'])){
            $_SESSION['LabGruppo'] = trim($_POST['LabGruppo']);}
            if (isset($_POST['LabGruppoList']) AND $_POST['LabGruppoList'] != "") {
                $_SESSION['LabGruppo'] = trim($_POST['LabGruppoList']);
            }
            //########### VARIABILE DI ORDINAMENTO DELLA QUERY #############################
            $_SESSION['Filtro'] = "cod_lab_formula";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }

//            echo "</br>SESSION['CodLabFormula'] : ".$_SESSION['CodLabFormula'];
//            echo "</br>SESSION['DtLabForm'] : ".$_SESSION['DtLabForm'];
//            echo "</br>SESSION['LabUtente'] : ".$_SESSION['LabUtente'];
//            echo "</br>SESSION['LabGruppo']".$_SESSION['LabGruppo'];
//            echo "</br>SESSION['Filtro'] : ".$_SESSION['Filtro'];
//            echo "</br>SESSION['nome_gruppo_utente'] : ".$_SESSION['nome_gruppo_utente'];
//            echo "</br>SESSION['username'] : ".$_SESSION['username'];
            
            //Filtro per la visibilita da usare nelle query
            //Se si digita la visibilità come criterio di ricerca ed  
            //il valore digitato è < della visibilità massima dell'utente
            //allora quel valore viene impostato come filtro per le query
            $varQueryVisibilita=$_SESSION['visibilita_utente'];
            if($_SESSION['LabFormVisibilita']>0 AND $_SESSION['LabFormVisibilita']<=$_SESSION['visibilita_utente']){
                $varQueryVisibilita=$_SESSION['LabFormVisibilita'];
            }

                begin();
                $sql = findAllFormule($_SESSION['Filtro'], "cod_lab_formula", $_SESSION['CodLabFormula'], $_SESSION['DtLabForm'], $_SESSION['ProdOb'], $_SESSION['Normativa'], $_SESSION['LabUtente'], $_SESSION['LabGruppo'],$strUtentiAziende, $varQueryVisibilita);
                $sqlLabNorma = findAllFormule("normativa", "normativa", "", "", "", "", "", "",$strUtentiAziende,$varQueryVisibilita);
                $sqlLabProdOb = findAllFormule("prod_ob", "prod_ob", "", "", "", "", "", "",$strUtentiAziende,$varQueryVisibilita);
                $sqlLabCodForm = findAllFormule("cod_lab_formula", "cod_lab_formula", "", "", "", "", "", "",$strUtentiAziende,$varQueryVisibilita);
                $sqlLabDtForm = findAllFormule("dt_lab_formula", "dt_lab_formula", "", "", "", "", "", "",$strUtentiAziende,$varQueryVisibilita);
                $sqlLabVis = findAllFormule("visibilita", "visibilita", "", "", "", "", "", "",$strUtentiAziende,$varQueryVisibilita);
                $sqlLabUtente = findAllFormule("utente", "utente", "", "", "", "", "", "",$strUtentiAziende,$varQueryVisibilita);
                $sqlLabGruppo = findAllFormule("gruppo_lavoro", "gruppo_lavoro", "", "", "", "", "", "",$strUtentiAziende,$varQueryVisibilita);
                commit();


/*

            if ($_SESSION['nome_gruppo_utente'] == 'Amministrazione') {
                //Se l'utente appartiene al gruppo amministrazione 
                //ha accesso a tutte le formule di tutti 
                begin();
                $sql = findAllFormule($_SESSION['Filtro'], "cod_lab_formula", $_SESSION['CodLabFormula'], $_SESSION['DtLabForm'], $_SESSION['ProdOb'], $_SESSION['Normativa'], $_SESSION['LabUtente'], $_SESSION['LabGruppo'],$strUtentiAziende);
                $sqlLabNorma = findAllFormule("normativa", "normativa", "", "", "", "", "", "",$strUtentiAziende);
                $sqlLabProdOb = findAllFormule("prod_ob", "prod_ob", "", "", "", "", "", "",$strUtentiAziende);
                $sqlLabCodForm = findAllFormule("cod_lab_formula", "cod_lab_formula", "", "", "", "", "", "",$strUtentiAziende);
                $sqlLabDtForm = findAllFormule("dt_lab_formula", "dt_lab_formula", "", "", "", "", "", "",$strUtentiAziende);
                $sqlLabUtente = findAllFormule("utente", "utente", "", "", "", "", "", "",$strUtentiAziende);
                $sqlLabGruppo = findAllFormule("gruppo_lavoro", "gruppo_lavoro", "", "", "", "", "", "",$strUtentiAziende);
                commit();
            } else {
                //Gli utenti che NON appartengono al gruppo Amministrazione 
                //hanno accesso solo alle proprie formule e a quelle del proprio gruppo
                begin();
                $sql = findFormuleByGruppo($_SESSION['username'], $_SESSION['nome_gruppo_utente'], $_SESSION['Filtro'], "cod_lab_formula", $_SESSION['CodLabFormula'], $_SESSION['DtLabForm'], $_SESSION['ProdOb'], $_SESSION['Normativa'], $_SESSION['LabUtente'],$strUtentiAziende);
                $sqlLabNorma = findFormuleByGruppo($_SESSION['username'], $_SESSION['nome_gruppo_utente'], "normativa", "normativa", "", "", "", "", "",$strUtentiAziende);
                $sqlLabProdOb = findFormuleByGruppo($_SESSION['username'], $_SESSION['nome_gruppo_utente'], "prod_ob", "prod_ob", "", "", "", "", "",$strUtentiAziende);
                $sqlLabCodForm = findFormuleByGruppo($_SESSION['username'], $_SESSION['nome_gruppo_utente'], "cod_lab_formula", "cod_lab_formula", "", "", "", "", "",$strUtentiAziende);
                $sqlLabDtForm = findFormuleByGruppo($_SESSION['username'], $_SESSION['nome_gruppo_utente'], "dt_lab_formula", "dt_lab_formula", "", "", "", "", "",$strUtentiAziende);
                $sqlLabUtente = findFormuleByGruppo($_SESSION['username'], $_SESSION['nome_gruppo_utente'], "utente", "utente", "", "", "", "", "",$strUtentiAziende);
                $sqlLabGruppo = findFormuleByGruppo($_SESSION['username'], $_SESSION['nome_gruppo_utente'], "gruppo_lavoro", "gruppo_lavoro", "", "", "", "", "",$strUtentiAziende);
                commit();
            }
*/
            $trovati = mysql_num_rows($sql);
            ?>

            <table class="table3">
                <tr>
                    <th colspan="8"><?php echo $titoloPaginaLabFormule ?></th>
                </tr>
                <tr>
                    <td colspan="8" style="text-align:center;"><a name="109" href="carica_lab_formula.php"> <?php echo $nuovaLabForm ?></a></td>
                </tr> 
            </table>

            <?php
            echo "</br>" . $msgLabFormuleTrovate . $trovati . "</br>";
            echo "</br>" . $msgSelectListCriteriRicerca . "</br>";
            include('./moduli/visualizza_lab_formula.php');
            ?> 
<div id="msgLog">
                <?php
                  if ($DEBUG) {
                        echo "actionOnLoad :" . $actionOnLoad;
                        echo "</br>Tab lab_formula : Nuova stringa unica utenti e aziende visibili : " . $strUtentiAziende;
                        echo "</br>visibilita :" . $_SESSION['visibilita_utente'];
                    }
                 ?>
            </div>
        </div>
    </body>
</html>
