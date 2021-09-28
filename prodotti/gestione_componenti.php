<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    
    <?php
    //##########################################################################            
    //NOTE GESTIONE UTENTI
    //1) Si verifica se l'utente ha il permesso di visualizzare la lista dei componenti
    //2)  Si verifica se l'utente ha il permesso di creare nuovi componenti 
    //In questo caso vedere il dettaglio coincide col vedere la lista quindi  //si fa un unico controllo
    
    if ($DEBUG)  ini_set('display_errors', 1);
    
    //########################### GESTIONE UTENTI ##############################            
    //1) Si verifica se l'utente ha il permesso di visualizzare la lista delle famiglie
    //2) Si verifica se l'utente ha il persmesso di editare la famiglia
    $actionOnLoad = "";
    $elencoFunzioni = array("7", "8");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);

    //############# STRINGA UTENTI - AZIENDE VIS ###############################
    $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'componente');    
    //##########################################################################
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">      

        <div id="mainContainer">

            <?php
            include('../include/menu.php');
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_componente.php');
            
            $_SESSION['Id'] = "";
            $_SESSION['Codice'] = "";
            $_SESSION['Descrizione'] = "";
            $_SESSION['Abilitato'] = "";
            $_SESSION['DtAbilitato'] = "";
            

            $_SESSION['IdList'] = "";
            $_SESSION['CodiceList'] = "";
            $_SESSION['DescrizioneList'] = "";
            $_SESSION['AbilitatoList'] = "";            
            $_SESSION['DtAbilitatoList'] = "";
            


            if (isset($_POST['Id'])) {
                $_SESSION['Id'] = trim($_POST['Id']);
            }
            if (isset($_POST['IdList']) AND $_POST['IdList'] != "") {
                $_SESSION['Id'] = trim($_POST['IdList']);
            }
            if (isset($_POST['Codice'])) {
                $_SESSION['Codice'] = trim($_POST['Codice']);
            }
            if (isset($_POST['CodiceList']) AND $_POST['CodiceList'] != "") {
                $_SESSION['Codice'] = trim($_POST['CodiceList']);
            }
            if (isset($_POST['Descrizione'])) {
                $_SESSION['Descrizione'] = trim($_POST['Descrizione']);
            }
            if (isset($_POST['DescrizioneList']) AND $_POST['DescrizioneList'] != "") {
                $_SESSION['Descrizione'] = trim($_POST['DescrizioneList']);
            }
            if (isset($_POST['Abilitato'])) {
                $_SESSION['Abilitato'] = trim($_POST['Abilitato']);
            }
            if (isset($_POST['AbilitatoList']) AND $_POST['AbilitatoList'] != "") {
                $_SESSION['Abilitato'] = trim($_POST['AbilitatoList']);
            }
            
            if (isset($_POST['DtAbilitato'])) {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitato']);
            }
            if (isset($_POST['DtAbilitatoList']) AND $_POST['DtAbilitatoList'] != "") {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitatoList']);
            }
            

            //########### VARIABILE DI ORDINAMENTO DELLA QUERY #################
            $_SESSION['Filtro'] = "cod_componente";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }
            
            
            //######################## CONDIZIONE DELLA SELECT ########################################
            $_SESSION['condizioneSelect'] = "1=1";
            if (isset($_POST['condizioneSelect']) AND $_POST['condizioneSelect'] != "") {
                $_SESSION['condizioneSelect'] = trim($_POST['condizioneSelect']);
            }     
           
            if (isset($_GET['condizioneSelect']) AND $_GET['condizioneSelect'] != "") {                
                switch ($_GET['condizioneSelect']) {
                    
                    case 1:
                        //Seleziona solo i drymix
                        $_SESSION['condizioneSelect'] = "tipo3='$valTipo3Drymix' AND tipo2='$valTipo2RawMaterial'";
                        break;
                    case 2:
                        //Seleziona solo i colori
                        $_SESSION['condizioneSelect'] = "tipo2='$valTipo2Pigment'";
                        break;
                    case 3:
                        //Seleziona solo i colori
                        $_SESSION['condizioneSelect'] = "tipo2='$valTipo2Additivo'";
                        break;
                    case 4:
                        //Seleziona tutto
                        $_SESSION['condizioneSelect'] = "1=1";
                        break;
                    
                }
            }
            

            begin();
            $sql=findAllComponentiVisByFiltri("id_comp",$_SESSION['Filtro'],$strUtentiAziende,$_SESSION['Id'],$_SESSION['Codice'],$_SESSION['Descrizione'],$_SESSION['Abilitato'],$_SESSION['DtAbilitato'],$_SESSION['condizioneSelect']);
            $sqlId=findAllComponentiVisByFiltri("id_comp","id_comp",$strUtentiAziende,$_SESSION['Id'],$_SESSION['Codice'],$_SESSION['Descrizione'],$_SESSION['Abilitato'],$_SESSION['DtAbilitato'],$_SESSION['condizioneSelect']);
            $sqlCodice=findAllComponentiVisByFiltri("cod_componente","cod_componente",$strUtentiAziende,$_SESSION['Id'],$_SESSION['Codice'],$_SESSION['Descrizione'],$_SESSION['Abilitato'],$_SESSION['DtAbilitato'],$_SESSION['condizioneSelect']);
            $sqlDescri=findAllComponentiVisByFiltri("descri_componente","descri_componente",$strUtentiAziende,$_SESSION['Id'],$_SESSION['Codice'],$_SESSION['Descrizione'],$_SESSION['Abilitato'],$_SESSION['DtAbilitato'],$_SESSION['condizioneSelect']);
            $sqlAb=findAllComponentiVisByFiltri("c.abilitato","c.abilitato",$strUtentiAziende,$_SESSION['Id'],$_SESSION['Codice'],$_SESSION['Descrizione'],$_SESSION['Abilitato'],$_SESSION['DtAbilitato'],$_SESSION['condizioneSelect']);
            $sqlDtAb=findAllComponentiVisByFiltri("c.dt_abilitato","c.dt_abilitato",$strUtentiAziende,$_SESSION['Id'],$_SESSION['Codice'],$_SESSION['Descrizione'],$_SESSION['Abilitato'],$_SESSION['DtAbilitato'],$_SESSION['condizioneSelect']);
            commit();
            $trovati = mysql_num_rows($sql);
            include('./moduli/visualizza_componenti.php');
            ?> 
 <div id="msgLog">
                <?php
                if ($DEBUG) {

                    echo "</br>actionOnLoad :" . $actionOnLoad;
                    echo "</br>Tab componente : Utenti e aziende visibili " . $strUtentiAziende;
                }
                ?>
            </div>
        </div>
    </body>
</html>
