<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <?php 
    if($DEBUG) ini_set('display_errors',1); 
    //##########################################################################            
    //NOTE GESTIONE UTENTI
    //1) Si verifica se l'utente ha il permesso di visualizzare la lista delle prove (114)
    //2) Si verifica se l'utente ha il permesso di visualizzare il dettaglio di una formula + le prove (115)
    //3) Si verifica se l'utente ha il permesso di editare la tabella lab_esperimenti (116)
    //4) Si verifica se l'utente ha il permesso di visualizzare il dettaglio del prodotto target (108)
    //############# VERIFICA PERMESSI ##########################################
    $actionOnLoad="";
    $elencoFunzioni = array("114","115","108","116");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni,$_SESSION['objPermessiVis']);
    //############# STRINGHE UTENTI - AZIENDE VISIBILI###########################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
    $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_esperimento');   
    
    //##########################################################################
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">
 
        <div id="labContainer" >
            <?php
//            ini_set(display_errors, "1");
            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('./sql/script.php');
            include('./sql/script_lab_formula.php');
            include('./sql/script_lab_esperimento.php');

            $_SESSION['ProdOb'] = "";
            $_SESSION['Normativa'] = "";
            $_SESSION['CodLabFormula'] = "";
            $_SESSION['CodBarre'] = "";
            $_SESSION['DtProva'] = "";
            $_SESSION['LabEspVisibilita'] = "";
            
            
            $_SESSION['ProdObList'] = "";
            $_SESSION['NormativaList'] = "";
            $_SESSION['CodLabFormulaList'] = "";
            $_SESSION['CodBarreList'] = "";
            $_SESSION['DtProvaList'] = "";
            $_SESSION['LabEspVisibilitaList'] = "";
                        
            if(isset($_POST['ProdOb'])) $_SESSION['ProdOb'] = trim($_POST['ProdOb']);
            if (isset($_POST['ProdObList']) AND $_POST['ProdObList'] != "") {
                $_SESSION['ProdOb'] = trim($_POST['ProdObList']);
            }
            
            if(isset($_POST['Normativa'])) $_SESSION['Normativa'] = trim($_POST['Normativa']);
            if (isset($_POST['NormativaList']) AND $_POST['NormativaList'] != "") {
                $_SESSION['Normativa'] = trim($_POST['NormativaList']);
            }

            if(isset($_POST['CodLabFormula'])) $_SESSION['CodLabFormula'] = trim($_POST['CodLabFormula']);
            if (isset($_POST['CodLabFormulaList']) AND $_POST['CodLabFormulaList'] != "") {
                $_SESSION['CodLabFormula'] = trim($_POST['CodLabFormulaList']);
            }

            if(isset($_POST['CodBarre'])) $_SESSION['CodBarre'] = trim($_POST['CodBarre']);
            if (isset($_POST['CodBarreList']) AND $_POST['CodBarreList'] != "") {
                $_SESSION['CodBarre'] = trim($_POST['CodBarreList']);
            }

            if(isset($_POST['DtProva'])) $_SESSION['DtProva'] = trim($_POST['DtProva']);
            if (isset($_POST['DtProvaList']) AND $_POST['DtProvaList'] != "") {
                $_SESSION['DtProva'] = trim($_POST['DtProvaList']);
            }
            
            if(isset($_POST['LabEspVisibilita'])){
            $_SESSION['LabEspVisibilita'] = trim($_POST['LabEspVisibilita']);
            }
            if (isset($_POST['LabEspVisibilitaList']) AND $_POST['LabEspVisibilitaList'] != "") {
                $_SESSION['LabEspVisibilita'] = trim($_POST['LabEspVisibilitaList']);
            }
            //########### VARIABILE DI ORDINAMENTO DELLA QUERY #############################
            $_SESSION['Filtro'] = "cod_lab_formula";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }

//            echo "</br>SESSION['ProdOb'] : ".$_SESSION['ProdOb'];
//            echo "</br>SESSION['CodLabFormula'] : ".$_SESSION['CodLabFormula'];
//            echo "</br>SESSION['CodBarre'] : ".$_SESSION['CodBarre'];
//            echo "</br>SESSION['NumProva'] : ".$_SESSION['NumProva'];
//            echo "</br>SESSION['DtProva']".$_SESSION['DtProva'];
//            echo "</br>SESSION['Filtro'] : ".$_SESSION['Filtro'];
//            echo "</br>SESSION['nome_gruppo_utente'] : ".$_SESSION['nome_gruppo_utente'];
//            echo "</br>SESSION['username'] : ".$_SESSION['username'];

//Filtro per la visibilita da usare nelle query
            //Se si digita la visibilità come criterio di ricerca ed  
            //il valore digitato è < della visibilità massima dell'utente
            //allora quel valore viene impostato come filtro per le query
            $varQueryVisibilita=$_SESSION['visibilita_utente'];
            if($_SESSION['LabEspVisibilita']>0 AND $_SESSION['LabEspVisibilita']<=$_SESSION['visibilita_utente']){
                $varQueryVisibilita=$_SESSION['LabEspVisibilita'];
            }

		begin();
                $sql = findEsperimentiAll($_SESSION['Filtro'],
                        "id_esperimento",
                        $_SESSION['CodLabFormula'],
                        $_SESSION['CodBarre'],
                        $_SESSION['ProdOb'],
                        $_SESSION['Normativa'],
                        $_SESSION['DtProva'],
                        "",
                        "",$strUtentiAziende,$varQueryVisibilita);
                    
                $sqlLabProdOb = findEsperimentiAll("prod_ob","prod_ob","","","","","","","",$strUtentiAziende,$varQueryVisibilita);
                $sqlLabFormula = findEsperimentiAll("cod_lab_formula","cod_lab_formula","","","","","","","",$strUtentiAziende,$varQueryVisibilita);
                $sqlLabNorma = findEsperimentiAll("normativa","normativa","","","","","","","",$strUtentiAziende,$varQueryVisibilita);
                $sqlCodBarre = findEsperimentiAll("cod_barre","cod_barre","","","","","","","",$strUtentiAziende,$varQueryVisibilita);
                $sqlLabDtProva = findEsperimentiAll("dt_prova","dt_prova","","","","","","","",$strUtentiAziende,$varQueryVisibilita);
                commit();


/*

            if ($_SESSION['nome_gruppo_utente'] == 'Amministrazione') {
                //Se l'utente appartiene al gruppo amministrazione 
                //ha accesso a tutte le formule di tutti 
                begin();
                $sql = findEsperimentiAll($_SESSION['Filtro'],
                        "id_esperimento",
                        $_SESSION['CodLabFormula'],
                        $_SESSION['CodBarre'],
                        $_SESSION['ProdOb'],
                        $_SESSION['Normativa'],
                        $_SESSION['DtProva'],
                        "",
                        "",$strUtentiAziende);
                    
                $sqlLabProdOb = findEsperimentiAll("prod_ob","prod_ob","","","","","","","",$strUtentiAziende);
                $sqlLabFormula = findEsperimentiAll("cod_lab_formula","cod_lab_formula","","","","","","","",$strUtentiAziende);
                $sqlLabNorma = findEsperimentiAll("normativa","normativa","","","","","","","",$strUtentiAziende);
                $sqlCodBarre = findEsperimentiAll("cod_barre","cod_barre","","","","","","","",$strUtentiAziende);
                $sqlLabDtProva = findEsperimentiAll("dt_prova","dt_prova","","","","","","","",$strUtentiAziende);
                commit();
            } else {
                //Gli utenti che non appartengono al gruppo Amministrazione 
                //hanno accesso solo alle proprie formule e a quelle del proprio gruppo
                begin();
                $sql = findEsperimentiByGruppo($_SESSION['username'], 
                        $_SESSION['nome_gruppo_utente'], 
                        $_SESSION['Filtro'],
                         "id_esperimento", 
                        $_SESSION['CodLabFormula'], 
                        $_SESSION['CodBarre'],
                        $_SESSION['ProdOb'],
                        $_SESSION['Normativa'],
                        $_SESSION['DtProva'],$strUtentiAziende);

                $sqlLabFormula = findEsperimentiByGruppo($_SESSION['username'],$_SESSION['nome_gruppo_utente'],"cod_lab_formula","cod_lab_formula","","","","","",$strUtentiAziende);
    
            $sqlLabProdOb = findEsperimentiByGruppo($_SESSION['username'],$_SESSION['nome_gruppo_utente'],"prod_ob","prod_ob","","","","","",$strUtentiAziende);
               $sqlLabNorma = findEsperimentiByGruppo($_SESSION['username'],$_SESSION['nome_gruppo_utente'],"normativa", "normativa","","","","","",$strUtentiAziende);
                $sqlCodBarre = findEsperimentiByGruppo($_SESSION['username'],$_SESSION['nome_gruppo_utente'],"cod_barre","cod_barre","","","","","",$strUtentiAziende);
 
             $sqlLabDtProva = findEsperimentiByGruppo($_SESSION['username'], $_SESSION['nome_gruppo_utente'], "dt_prova", "dt_prova","","","","","",$strUtentiAziende);
                
                commit();
            }
*/
            $trovati = mysql_num_rows($sql);
            ?>
            
            <table class="table3" >
                <tr>
                    <th colspan="8"><?php echo $titoloPaginaLabProve ?></th>
                </tr>
                <tr>
                    <td  colspan="8" style="text-align:center;"> 
 <?php 
 //#######################################################################
 //####################### SCELTA DELLA ROSETTA #########################
 //#######################################################################
 
if(isset($_SESSION['lab_macchina']) AND $_SESSION['lab_macchina']!=''){ ?>
                        
                        <p><a name="116" href="carica_lab_primo_esperimento.php"><?php echo $filtroLabPrimaProva ?></a></p>
                        <p>&nbsp;</p>
                        <p><a name="116"href="carica_lab_esperimento.php"><?php echo $filtroLabNuovaProva ?></a></p>
                        <p>&nbsp;</p>
 <?php } else { ?>
                        <p><a name="116" href="lab_scegli_macchina.php?Redirect=carica_lab_primo_esperimento.php"><?php echo $filtroLabPrimaProva ?></a></p>
                        <p>&nbsp;</p>
                        <p><a name="116" href="lab_scegli_macchina.php?Redirect=carica_lab_esperimento.php"><?php echo $filtroLabNuovaProva ?></a></p>
                        <p>&nbsp;</p>
 <?php } ?>
                    </td>
                </tr>
            </table>


<?php
echo "</br>" . $msgLabProveTrovate . $trovati . "</br>";
echo "</br>" . $msgSelectListCriteriRicerca . "</br>";
include('./moduli/visualizza_lab_esperimenti.php');
?> 
<div id="msgLog">
                <?php
                  if ($DEBUG) {
                        echo "actionOnLoad :" . $actionOnLoad;
                        echo "</br>Tab lab_esperimento : Nuova stringa unica utenti e aziende visibili : " . $strUtentiAziende;
                    }
                 ?>
            </div>
        </div>
    </body>
</html>




