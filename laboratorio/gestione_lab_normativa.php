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
    //1) Si verifica se l'utente ha il permesso di visualizzare la lista (112)--Per ora commentato
    //2) Si verifica se l'utente ha il permesso di modificare la tabella lab_normtiva (113)
    //3) Si verifica se l'utente ha il permesso di inserire dati nella tabella lab_normativa (123)
    //############# VERIFICA PERMESSI ##########################################
    $actionOnLoad="";
    $elencoFunzioni = array("113","123");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni,$_SESSION['objPermessiVis']);
    //############# STRINGHE UTENTI - AZIENDE VISIBILI###########################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
    $strUtentiAziendeNorm = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_normativa');   
        
    //##########################################################################
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">

<div id="labContainer" >
<?php 

            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('./sql/script.php');
            include('./sql/script_lab_normativa.php');
           

            $_SESSION['Normativa'] = "";
            $_SESSION['Descrizione'] = "";
            $_SESSION['Data'] = "";
            
             $_SESSION['NormativaList'] = "";
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

           

            //########### VARIABILE DI ORDINAMENTO DELLA QUERY #############################
            $_SESSION['Filtro'] = "normativa";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }

            $_SESSION['GroupBy'] = "normativa";


//            echo "</br>SESSION['Normativa'] : " . $_SESSION['Normativa'];
//            echo "</br>SESSION['Descrizione'] : " . $_SESSION['Descrizione'];
//            echo "</br>SESSION['Data']" . $_SESSION['Data'];
//            echo "</br>SESSION['Filtro'] : " . $_SESSION['Filtro'];
//            echo "</br>SESSION['nome_gruppo_utente'] : " . $_SESSION['nome_gruppo_utente'];
//            echo "</br>SESSION['username'] : " . $_SESSION['username'];


            begin();
            $sql = findAllNormeByFiltri($_SESSION['Filtro'], $_SESSION['GroupBy'], $_SESSION['Normativa'], $_SESSION['Descrizione'], $_SESSION['Data'],$strUtentiAziendeNorm);            
            $sqlLabNorma = findAllNormeByFiltri("normativa", "normativa", $_SESSION['Normativa'], $_SESSION['Descrizione'], $_SESSION['Data'],$strUtentiAziendeNorm);                       
            $sqlLabDescri = findAllNormeByFiltri("descri", "descri", "", "", "",$strUtentiAziendeNorm);
            $sqlLabData = findAllNormeByFiltri("dt_abilitato", "dt_abilitato", "", "", "",$strUtentiAziendeNorm);
            commit();


            $trovati = mysql_num_rows($sql);
            ?>

            <table class="table3">
                <tr>
                    <th colspan="5"><?php echo $titoloPaginaLabNormativa ?></th>
                </tr>
                <tr>
                    <td name="123" colspan="5" style="text-align:center;"><a href="carica_lab_normativa.php"> <?php echo $nuovaLabNormativa ?></a></td>
                </tr> 
            </table>


            <?php
            echo "</br>" . $msgLabRisultatiTrovati . $trovati . "</br>";
            echo "</br>" . $msgSelectListCriteriRicerca . "</br>";
            include('./moduli/visualizza_lab_normativa.php');
            ?> 
<div id="msgLog">
                <?php
                if ($DEBUG) {

                    echo "</br>actionOnLoad :" . $actionOnLoad;
                    echo "</br>Tab lab_normativa : Utenti e aziende visibili " . $strUtentiAziendeNorm;
                }
                ?>
            </div>
        </div>
    </body>
</html>
