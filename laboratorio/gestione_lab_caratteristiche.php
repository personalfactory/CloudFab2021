<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
    <?php
     if($DEBUG) ini_set(display_errors, "1"); 
    //##########################################################################            
    //NOTE GESTIONE UTENTI
    //1) Si verifica se l'utente ha il permesso di visualizzare la lista delle carat (118)
    //2) Si verifica se l'utente ha il permesso di modificare la tabella lab_caterristica (119)
    //3) Si verifica se l'utente ha il permesso di inserire dati nella la tabella lab_caterristica (120)
    //############# VERIFICA PERMESSI ##########################################
    $actionOnLoad="";
    $elencoFunzioni = array("118","119","120");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni,$_SESSION['objPermessiVis']);
    //############# STRINGHE UTENTI - AZIENDE VISIBILI###########################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
    $strUtentiAziendeCar = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_caratteristica');   
    $strUtentiAziendeNorm = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_normativa');   
    
    //##########################################################################
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">

<div id="labContainer" >
<?php 
include('../include/menu.php'); 
include('../Connessioni/serverdb.php');
include('sql/script.php');
include('sql/script_lab_caratteristica.php');
include('./sql/script_lab_normativa.php');
            
            $_SESSION['Normativa'] = "";
            $_SESSION['Metodo'] = "";
            $_SESSION['Caratteristica'] = "";
            $_SESSION['Descrizione'] = "";
            $_SESSION['Data'] = "";
            $_SESSION['NormativaList'] = "";
            $_SESSION['MetodoList'] = "";
            $_SESSION['CaratteristicaList'] = "";
            $_SESSION['DescrizioneList'] = "";
            $_SESSION['DataList'] = "";

            if (isset($_POST['Normativa'])) {
                $_SESSION['Normativa'] = trim($_POST['Normativa']);
            }
            if (isset($_POST['NormativaList']) AND $_POST['NormativaList'] != "") {
                $_SESSION['Normativa'] = trim($_POST['NormativaList']);
            }

            if (isset($_POST['Descrizione'])) {
                $_SESSION['Descrizione'] = trim($_POST['Descrizione']);
            }
            if (isset($_POST['DescrizioneList']) AND $_POST['DescrizioneList'] != "") {
                $_SESSION['Descrizione'] = trim($_POST['DescrizioneList']);
            }

            if (isset($_POST['Data'])) {
                $_SESSION['Data'] = trim($_POST['Data']);
            }
            if (isset($_POST['DataList']) AND $_POST['DataList'] != "") {
                $_SESSION['Data'] = trim($_POST['DataList']);
            }

            if (isset($_POST['Metodo'])) {
                $_SESSION['Metodo'] = trim($_POST['Metodo']);
            }
            if (isset($_POST['MetodoList']) AND $_POST['MetodoList'] != "") {
                $_SESSION['Metodo'] = trim($_POST['MetodoList']);
            }
             if (isset($_POST['Caratteristica'])) {
                $_SESSION['Caratteristica'] = trim($_POST['Caratteristica']);
            }
            if (isset($_POST['CaratteristicaList']) AND $_POST['CaratteristicaList'] != "") {
                $_SESSION['Caratteristica'] = trim($_POST['CaratteristicaList']);
            }

            //########### VARIABILE DI ORDINAMENTO DELLA QUERY #############################
            $_SESSION['Filtro'] = "caratteristica";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }

            $_SESSION['GroupBy'] = "caratteristica";


//            echo "</br>SESSION['Normativa'] : " . $_SESSION['Normativa'];
//            echo "</br>SESSION['Descrizione'] : " . $_SESSION['Descrizione'];
//            echo "</br>SESSION['Metodo'] : " . $_SESSION['Metodo'];
//            echo "</br>SESSION['Caratteristica'] : " . $_SESSION['Caratteristica'];
//            echo "</br>SESSION['Data']" . $_SESSION['Data'];
//            echo "</br>SESSION['Filtro'] : " . $_SESSION['Filtro'];
//            echo "</br>SESSION['nome_gruppo_utente'] : " . $_SESSION['nome_gruppo_utente'];
//            echo "</br>SESSION['username'] : " . $_SESSION['username'];


            begin();
            $sql = findAllCarByFiltri($_SESSION['Filtro'], $_SESSION['GroupBy'], $_SESSION['Normativa'], $_SESSION['Descrizione'], $_SESSION['Metodo'], $_SESSION['Caratteristica'], $_SESSION['Data'],$strUtentiAziendeCar);            
            $sqlLabNorma = findAllNormativeVis($strUtentiAziendeNorm);            
            $sqlLabDescri = findAllCarByFiltri("descri_caratteristica", "descri_caratteristica", "", "", "", "","",$strUtentiAziendeCar);
            $sqlLabMetodo = findAllCarByFiltri("metodologia", "metodologia", "", "", "", "","",$strUtentiAziendeCar);
            $sqlLabCar = findAllCarByFiltri("caratteristica","caratteristica", "", "", "", "","",$strUtentiAziendeCar);
            $sqlLabData = findAllCarByFiltri("dt_abilitato", "dt_abilitato", "", "", "", "","",$strUtentiAziendeCar);
            commit();

            $trovati = mysql_num_rows($sql);
            ?>
            <table class="table3">
                <tr>
                    <th colspan="5"><?php echo $titoloPaginaLabCaratteristiche ?></th>
                </tr>
                <tr>
                    <td colspan="5" style="text-align:center;"><a name="120" href="carica_lab_caratteristica.php"> <?php echo $nuovaLabCar ?></a></td>
                </tr> 
            </table>

            <?php
            echo "</br>" . $msgLabCaratteristicheTrovate . $trovati . "</br>";
            echo "</br>" . $msgSelectListCriteriRicerca . "</br>";
            include('./moduli/visualizza_lab_caratteristiche.php');
            ?> 
 <div id="msgLog">
                <?php
                if ($DEBUG) {

                    echo "</br>actionOnLoad :" . $actionOnLoad;
                    echo "</br>Tab lab_caratteristica : Utenti e aziende visibili " . $strUtentiAziendeCar;
                    echo "</br>Tab lab_normativa : Utenti e aziende visibili " . $strUtentiAziendeNorm;
                }
                ?>
            </div>
        </div>
    </body>
</html>
