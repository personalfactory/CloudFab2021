<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <script language="javascript">
//        function disabilitaAction86() {
//            //PERMESSO VISTA LISTA FIGURE
//            location.href = '../permessi/avviso_permessi_visualizzazione.php'
//
//        }
//        function disabilitaAction87() {
//            //PERMESSO EDITARE FIGURE
//            //Disabilita il link alla pagina di creazione
//            document.getElementById('Nuova').removeAttribute('href');
//        }
    </script>
    <?php
  
    if ($DEBUG)
        ini_set('display_errors', 1);
    //################ GETIONE UTENTI ##########################################
    $elencoFunzioni = array("86", "87");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);

    //############# STRINGA UTENTI-AZIENDE VISIBILI ############################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
//    $strUtAziendeGruppo = getStrUtAzVisib($_SESSION['objPermessiVis'], 'gruppo');
    $strUtAziendeFigura = getStrUtAzVisib($_SESSION['objPermessiVis'], 'figura');
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_figura.php');

//############ INIZIALIZZAZIONE DELLE VARIABILI DI SESSIONE ####################

            $_SESSION['Codice'] = "";
            $_SESSION['Figura'] = "";
            $_SESSION['Gruppo'] = "";
            $_SESSION['Geografico'] = "";
            $_SESSION['Nominativo'] = "";
            $_SESSION['DtAbilitato'] = "";
            $_SESSION['Filtro'] = "";

            $_SESSION['CodiceList'] = "";
            $_SESSION['FiguraList'] = "";
            $_SESSION['NominativoList'] = "";
            $_SESSION['DtAbilitatoList'] = "";


//##############################################################################
//Se e' il parametro e' stato scelto da list box lo memorizzo nella variabile di
//sessione altrimentri memorizzo il contenuto dell'input text      
            if (isset($_POST['Nominativo'])) {
                $_SESSION['Nominativo'] = trim($_POST['Nominativo']);
            }
            if (isset($_POST['NominativoList']) AND $_POST['NominativoList'] != "") {
                $_SESSION['Nominativo'] = trim($_POST['NominativoList']);
            }

            if (isset($_POST['Figura'])) {
                $_SESSION['Figura'] = trim($_POST['Figura']);
            }
            if (isset($_POST['FiguraList']) AND $_POST['FiguraList'] != "") {
                $_SESSION['Figura'] = trim($_POST['FiguraList']);
            }
            if (isset($_POST['Codice'])) {
                $_SESSION['Codice'] = trim($_POST['Codice']);
            }
            if (isset($_POST['CodiceList'])) {
                $_SESSION['Codice'] = trim($_POST['CodiceList']);
            }
            if (isset($_POST['DtAbilitato'])) {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitato']);
            }
            if (isset($_POST['DtAbilitatoList']) AND $_POST['DtAbilitatoList'] != "") {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitatoList']);
            }

//##### VALORI DI DEFAULT PER Gruppo,Rif geografico e Filtro ordinamento #######

            if (isset($_POST['Gruppo']) AND $_POST['Gruppo'] != "") {
                $_SESSION['Gruppo'] = trim($_POST['Gruppo']);
            } else {
                //VALORE DI DEFAULT
                $_SESSION['Gruppo'] = "Universale";
            }
            if (isset($_POST['Geografico']) AND $_POST['Geografico'] != "") {
                $_SESSION['Geografico'] = trim($_POST['Geografico']);
            } else {
                //VALORE DI DEFAULT
                $_SESSION['Geografico'] = "Mondo";
            }
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            } else {
                //VALORE DI DEFAULT
                $_SESSION['Filtro'] = "nominativo";
            }

            begin();
            $sqlGruppo = selectFromFigura("gruppo", "gruppo", $strUtAziendeFigura);
            $sqlGeo = selectFromFigura("geografico", "geografico", $strUtAziendeFigura);
            $sqlNome = selectFromFigura("nominativo", "nominativo", $strUtAziendeFigura);
            $sqlFigura = selectFromFigura("figura", "figura", $strUtAziendeFigura);
            $sqlCodice = selectFromFigura("codice", "codice", $strUtAziendeFigura);
            $sqlDt = selectFromFigura("f.dt_abilitato", "f.dt_abilitato", $strUtAziendeFigura);
            //Attenzione la procedura selectFigureSp va eseguita dopo le altre query
            $sql = selectFigureSp($_SESSION['Nominativo'], $_SESSION['Codice'], $_SESSION['Figura'], $_SESSION['Gruppo'], $_SESSION['Geografico'], $_SESSION['DtAbilitato'], $_SESSION['Filtro'], $strUtAziendeFigura);
            commit();
//  
//      echo "</br>SESSION['Nominativo'] : " . $_SESSION['Nominativo'];
//      echo "</br>SESSION['Codice'] : " . $_SESSION['Codice'];
//      echo "</br>SESSION['Figura'] : " . $_SESSION['Figura'];
//      echo "</br>SESSION['Gruppo'] : " . $_SESSION['Gruppo'];
//      echo "</br>SESSION['Geografico'] : " . $_SESSION['Geografico'];
//      echo "</br>SESSION['DtAbilitato'] : " . $_SESSION['DtAbilitato'];
//      echo "</br>SESSION['Filtro'] : " . $_SESSION['Filtro'];

            include('./moduli/visualizza_figure.php');
            ?>
            <div id="msgLog">
            <?php
            if ($DEBUG) {

                echo "</br>ActionOnLoad : " . $actionOnLoad;
//                echo "</br>Tabella gruppo utenti e aziende visibili : " . $strUtAziendeGruppo;
                echo "</br>Tabella figura utenti e aziende visibili : " . $strUtAziendeFigura;
            }
            ?>
            </div>
        </div>
    </body>
</html>
