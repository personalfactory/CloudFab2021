<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
<div id="mainContainer">
        <?php 
        if($DEBUG) ini_set(display_errors, "1"); 
        
        include('../include/menu.php'); 
        include('../include/gestione_date.php');
        include('../Connessioni/serverdb.php');
        include('sql/script_lab_caratteristica.php');
        include('sql/script.php');
       
            //################## CONTROLLO INPUT ###############################
            $insertCar=true;
            $errore = false;
            $messaggio = $msgErroreVerificato.'<br />';

            if (!isset($_POST['Caratteristica']) || trim($_POST['Caratteristica']) == "") {

                $errore = true;
                $messaggio = $messaggio . ' '.$msgErrCaratteristica.'<br />';
            }
            if (!isset($_POST['Normativa']) || trim($_POST['Normativa']) == "") {

                $errore = true;
                $messaggio = $messaggio . " " . $msgErrSelectNormativa . '<br/>';
            }
            begin();
            //Verifica esistenza
            $result = verificaEsistenzaCar($_POST['Caratteristica']);

            if (mysql_num_rows($result) != 0) {
                //Se entro nell'if vuol dire che esiste
                $errore = true;
                $messaggio = $messaggio . ' '.$msgErrEsistenzaCar.'<br />';
            }
            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);

            $messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';


            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {

                $Caratteristica = str_replace("'", "''", $_POST['Caratteristica']);
                $UniMisCar = str_replace("'", "''", $_POST['UniMisCar']);
                $TipoDato = str_replace("'", "''", $_POST['TipoDato']);
                $Normativa = str_replace("'", "''", $_POST['Normativa']);
                $Abilitato=1;
                
                $Dimensione = "";
                $UniMisDim = "";
                $Metodologia = "";
                $Descrizione = "";
                if(isset($_POST['Descrizione']) AND $_POST['Descrizione']!="")
                $Descrizione = str_replace("'", "''", $_POST['Descrizione']);
                if(isset($_POST['Dimensione']) AND $_POST['Dimensione']!="")
                $Dimensione = str_replace("'", "''", $_POST['Dimensione']);
                if(isset($_POST['UniMisDim']) AND $_POST['UniMisDim']!="")
                $UniMisDim = str_replace("'", "''", $_POST['UniMisDim']);
                if(isset($_POST['Metodologia']) AND $_POST['Metodologia']!="")
                $Metodologia = str_replace("'", "''", $_POST['Metodologia']);

                
                $insertCar = inserisciNuovaCaratteristica($Caratteristica, 
                        $Descrizione, 
                        $UniMisCar, 
                        $TipoDato, 
                        $Dimensione, 
                        $UniMisDim, 
                        $Metodologia,
                        $Normativa,
                        $Abilitato, 
                        dataCorrenteInserimento(),$_SESSION['id_utente'], $IdAzienda);
                
                if(!$insertCar){
                    rollback();
                    echo $msgErroreVerificato.'<a href="gestione_lab_caratteristiche.php">'.$msgErrContactAdmin.'</a><br/>';
                } else {
                    commit();
                echo $msgInserimentoCompletato.'<a href="gestione_lab_caratteristiche.php">'.$msgOk.'</a><br/>';
                }
            }
            ?>
        </div>
    </body>
</html>
