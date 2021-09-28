<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
        <?php include('../include/menu.php'); 
        include('../include/gestione_date.php'); 
        
            $Messaggio = str_replace("'", "''", $_POST['Messaggio']);

//############ CONTROLLO ERRORI SULLE QUERY ####################################
            
            $insertMessaggio =true;
                        
//############## CONTROLLO INPUT ##############################################
            $errore = false;
            $messaggio = $msgErroreVerificato.'<br />';

            if (!isset($Messaggio) || trim($Messaggio) == "") {

                $errore = true;
                $messaggio = $messaggio . ' '.$msgErrCampoMsgVuoto.'<br />';
            }


////Verifica esistenza
////Apro la connessione al db
//      include('../Connessioni/serverdb.php');
//
//      $query = "SELECT * FROM messaggio_macchina WHERE messaggio = '" . $Messaggio . "'";
//      $result = mysql_query($query, $connessione) or die(mysql_error());
//
//      if (mysql_num_rows($result) != 0) {
//        //Se entro nell'if vuol dire che esiste
//        $errore = true;
//        $messaggio = $messaggio . ' - Si sta tendando di duplicare un record!<br />';
//      }
//
//      mysql_close();

            $messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';

            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {
                //Inserisco perch� non ci sono errori
                include('../Connessioni/serverdb.php');
                include('../sql/script_messaggio_macchina.php');
                include('../sql/script.php');
                
                //##################### INIZIO TRANSAZIONE #####################
                
                begin();   
				/*
                $insertMessaggio = mysql_query("INSERT INTO messaggio_macchina 
                                        (messaggio,
                                        abilitato,
                                        dt_abilitato) 
				VALUES ( 
                                        '" . $Messaggio .
                                        "',1,
                                        '" . dataCorrenteInserimento() . "')");
//                or die(mysql_error());
				*/
                $insertMessaggio = insertNewMessaggio($Messaggio, dataCorrenteInserimento());

                 if (!$insertMessaggio) {

                    rollback();
                    echo $msgTransazioneFallita."! ".$msgErrContattareAdmin;
                } else {

                    commit();
                    mysql_close();
                    ?>

      <script language="javascript">
        window.location.href="/CloudFab/stabilimenti/gestione_messaggi.php";
      </script>
        
      <?php } 
      
      } ?>
        </div>
    </body>
</html>
