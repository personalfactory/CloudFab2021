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
        include('../sql/script_lotto_artico.php');
        include('../sql/script.php');
       
            ini_set(display_errors, "1");

//##############################################################################
//################### NUOVO ARTICOLO LOTTO #####################################
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
                
                        
                
                //######### VERIFICA ESISTENZA #################################
                $result = verificaEsistenzaLottoArtico($Codice, $Descrizione);

                if (mysql_num_rows($result) != 0) {
                    //Se entro nell'if vuol dire che esiste
                    $errore = true;
                    $messaggio = $messaggio . ' ' . $msgErrEsisteCodLottoArtico . '<br />';
                }

                $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

                if ($errore) {
                    //Ci sono errori quindi non salvo
                    echo '<div id="msgErr">' . $messaggio . '</div>';
                } else {                    
                    
                    $insertLottoArtico = true;
                    //Valori di default
                    $Costo = 0.00000; 
                    $UnitaMisura = "Pz";
                    $ScortaMinima = 0;
                    $Inventario = 0;
                    $GiacenzaAttuale = 0;
                    $DtInventario=  dataCorrenteInserimento();
                    
                    begin();                                         
                                       
                    $insertLottoArtico = insertLottoArtico($Codice,
                                            $Descrizione,       
                                            $UnitaMisura, 
                                            $Costo, 
                                            $ScortaMinima,
                                            $Inventario,
                                            $GiacenzaAttuale,
                                            $DtInventario);

                    if (!$insertLottoArtico) {

                        rollback();

                        echo '<div id="msgErr">' . $msgErroreVerificato . '' . $msgErrContattareAdmin . ' <a href="gestione_lotti.php">' . $msgOk . '</a></div>';
                                            
                    } else {

                        commit();

                        echo $msgInserimentoCompletato . ' <a href="gestione_lotti.php">' . $msgOk . '</a>';
                    }
                }//End if errore
           
            ?>
        </div>
    </body>
</html>
