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
        include('../Connessioni/serverdb.php');
        include('../sql/script_accessorio.php');
        include('../sql/script.php');
       
            if($DEBUG) ini_set(display_errors, "1");

//##############################################################################
//################### NUOVO ACCESSORIO #########################################
//##############################################################################
        
                $errore = false;
                $messaggio = $msgErroreVerificato . '<br/>';
          
                if (isset($_POST['Codice']) || trim($_POST['Codice']) != "") {
                    $Codice = str_replace("'", "''", $_POST['Codice']);
                } else {
                    $errore = true;
                    $messaggio = $messaggio . ' ' . $msgErrCodice . '<br />';
                }             
                
                $Descrizione="";
                if (isset($_POST['Descrizione']) || trim($_POST['Descrizione']) != "") {

                    $Descrizione = str_replace("'", "''", $_POST['Descrizione']);
                }
                
                $UnitaMisura="";
                if (isset($_POST['UnitaMisura']) || trim($_POST['UnitaMisura']) != "") {

                    $UnitaMisura = str_replace("'", "''", $_POST['UnitaMisura']);
                }                
                
                list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);             
                //######### VERIFICA ESISTENZA #################################
                $result = verificaEsistenzaAccessorio($Codice);

                if (mysql_num_rows($result) != 0) {
                    //Se entro nell'if vuol dire che esiste
                    $errore = true;
                    $messaggio = $messaggio . ' ' . $msgErrAccessorioEsistente . '<br />';
                }

                $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

                if ($errore) {
                    //Ci sono errori quindi non salvo
                    echo '<div id="msgErr">' . $messaggio . '</div>';
                } else {                    
                    
                    $insertAccessorio = true;
                    //Valori di default
                    $PrezzoAcq = 0.00000; 
                                      
                    begin();                                         
                                       
                    $insertAccessorio = insertAccessorio($Codice,
                                            $Descrizione,       
                                            $UnitaMisura, 
                                            $PrezzoAcq,$_SESSION['id_utente'], $IdAzienda);

                    if (!$insertAccessorio) {

                        rollback();

                        echo '<div id="msgErr">' . $msgErroreVerificato . '' . $msgErrContattareAdmin . ' <a href="gestione_accessori.php">' . $msgOk . '</a></div>';
                    } else {

                        commit();

                        echo $msgInserimentoCompletato . ' <a href="gestione_accessori.php">' . $msgOk . '</a>';
                    }
                }//End if errore
           
           
            ?>
        </div>
    </body>
</html>
