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
            include('../include/precisione.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../laboratorio/sql/script_lab_materie_prime.php');
            include('../sql/script_componente.php');
            include('../sql/script_valore_par_comp.php');
            
             ini_set("display_errors", "1");
 //################# Gestione degli errori sulle query #########################       
            
            $insertComponente = true;
            $sqlIdComp = true;
            $insertValComp = true;
            
//################# Gestione degli errori di input #############################

            $errore = false;
            $erroreEsistenza = false;
            $messaggio = $msgErroreVerificato.':<br />';
            $messaggioEsistenza = $msgErroreVerificato.':<br />';

            if (!isset($_POST['Componente']) || trim($_POST['Componente']) == "") {

                $errore = true;
                $messaggio = $messaggio . ' '.$msgErrSelectComponente.'<br />';
            }


            $messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';

            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {
                // Vado avanti 
                //Memorizzo il contenuto del POST nelle rispettive variabili
                if (isset($_POST['Componente']) || trim($_POST['Componente']) != "") {
                    list($Codice, $Descrizione) = explode(';', $_POST['Componente']);
                }

            $sqlComp=findComponenteByCod($Codice);

                if (mysql_num_rows($sqlComp) != 0) {
                    //Se entro nell'if vuol dire che esiste
                    $erroreEsistenza = true;
                    $messaggioEsistenza = $messaggioEsistenza . ' '.$msgErrCodCompEsiste.'<br />';
                }

                if ($erroreEsistenza) {
                    //Ci sono errori quindi non salvo
                    echo $messaggioEsistenza;
                } else {

                //##################### INIZIO TRANSAZIONE #####################
//NOTA: Per il momento l'utente e l'azienda vengono presi dalla tab lab_materie_prime
//valutare se possono essere diversi                    
//Recupero id_utente e id_azienda della materia prima nella tabella lab_materie_prime
                    $IdUtente=0;
                    $IdAzienda=0;
                    $sqlMatPri=findLabMatPrimaByCodice($Codice);
                    while ($rowMp = mysql_fetch_array($sqlMatPri)) {
                        $IdUtente=$rowMp['id_utente'];
                        $IdAzienda=$rowMp['id_azienda'];
                    }
                   begin();
                    
                    //Non è necessario modificare la data perchè il campo dt_abiltato è timestamp
                    $insertComponente = inserisciComponente($Codice,$Descrizione,$valAbilitato,$IdUtente,$IdAzienda);

//                    $sqlIdComp = findComponenteByCod($Codice);  
//                    while ($rowIdComp = mysql_fetch_array($sqlIdComp)) {
//                        $IdComp = $rowIdComp['id_comp'];
//                    }
//                    
//                    $insertValComp = inserisciValParComp($IdComp,dataCorrenteInserimento());
                    
                  if (!$insertComponente 
//                            OR !$sqlIdComp
//                            OR !$insertValComp
                          ) {

                      rollback();
                      
                       echo '<div id="msgErr">' . $msgErroreVerificato . ' ' . $msgErrContattareAdmin . ' <a href="gestione_componenti.php">' . $msgOk . '</a></div>';
                       echo "</br>insertComponente : ".$insertComponente;
//                       echo "</br>sqlIdComp : ".$sqlIdComp;
//                       echo "</br>insertValComp : ".$insertValComp;
                           
                    } else {

                        commit();
                        
                        ?>
                        <script language="javascript">
                            window.location.href="gestione_componenti.php";
                        </script>
                        <?php
                    }
                    
                }//End if erroreEsistenza
            }//End if errore
            ?>
        </div>
    </body>
</html>
