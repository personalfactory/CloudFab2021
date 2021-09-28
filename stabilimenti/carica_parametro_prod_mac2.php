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
        


//############ VARIABILI UTILI ALLA GESTIONE DEGLI ERRORI SULLE QUERY ##########
            $insertParProdMac = true;
            $insertValoreParProdMac = true;

//####################### CONTROLLO INPUT ######################################

            $errore = false;
            $erroreEs=false;
      		$messaggio = $msgErroreVerificato.'<br/>';
      		$messaggioEs = $msgErroreVerificato.'<br/>';
            
            if (!isset($_POST['IdParametro']) || trim($_POST['IdParametro']) == "") {

                $errore = true;
        		$messaggio = $messaggio . $msgErrCampoIdParVuoto.'<br />';
            }
            if (!isset($_POST['NomeParametro']) || trim($_POST['NomeParametro']) == "") {

                $errore = true;
        		$messaggio = $messaggio . $msgErrCampoNomeParVuoto.'<br />';
            }
            if (!isset($_POST['DescriParametro']) || trim($_POST['DescriParametro']) == "") {

                $errore = true;
                $messaggio = $messaggio . $msgErrCampoDescriParVuoto.'<br />';
            }
            if (!isset($_POST['ValoreBase']) || trim($_POST['ValoreBase']) == "") {

                $errore = true;
                $messaggio = $messaggio . $msgErrCampoValBaseVuoto.'<br />';
            }
            //Verifica tipo di dati
            if (!is_numeric($_POST['IdParametro'])) {

                $errore = true;
                $messaggio = $messaggio . ' - '.$filtroId .$msgErrDeveEssereIntero.'<br />';
            }


            	include('../Connessioni/serverdb.php');
            	include('../sql/script.php');                
                
                include('../sql/script_parametro_prod_mac.php');
            	include('../sql/script_valore_par_prod_mac.php');
    

            if ($errore) {
            	
            	//####################### RECUPERO POST ########################################
                //Ci sono errori quindi non salvo
                echo  $messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';
                
            } else { //Non ci sono errori quindi salvo
                
            	$IdParametro = $_POST['IdParametro'];
            	$NomeParametro = str_replace("'", "''", $_POST['NomeParametro']);
            	$DescriParametro = str_replace("'", "''", $_POST['DescriParametro']);
            	$ValoreBase = str_replace("'", "''", $_POST['ValoreBase']);
            	 
            	 
            	$result = findParProdMacByIdOrNome($IdParametro, $NomeParametro);
            	
            	if (mysql_num_rows($result) != 0) {
            		//Se entro nell'if vuol dire che esiste
            		$erroreEs = true;
            		$messaggioEs = $messaggioEs . $msgDuplicaRecord .'<br />';
            	}
            	
            	if($erroreEs){
            		
            		echo $messaggioEs. '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';
            		
            		
            	} else {
            	
//############## INIZIO TRANSAZIONE SALVATAGGIO DATI ###########################        
                            

                begin();


                $insertParProdMac = insertNewParProdMac($IdParametro, $NomeParametro, $DescriParametro, $ValoreBase, dataCorrenteInserimento());
                
                //NOTA BENE:
                //La seguente funzione aggiunge un nuovo parametro nella tabella valore_par_prod_mac, 
                // per tutte le macchine ed i prodotti già presenti nella tabella
                $insertValoreParProdMac= insertNewValoreParxProdxMac($IdParametro, $ValoreBase, dataCorrenteInserimento());

                if ( !$insertParProdMac OR !$insertValoreParProdMac) {

                    rollback();
                    
                    echo "</br>insertParProdMac:" .$insertParProdMac;
                    echo "</br>insertValoreParProdMac:" .$insertValoreParProdMac;
                    
                    echo "</br>".$msgTransazioneFallita." ".$msgErrContattareAdmin;
                    echo ' <a href="gestione_parametri_prod_mac.php">' . $msgOk . '</a>';
                    } else {

                    commit();
                    mysql_close();
                    
                   echo "</br>".$msgInserimentoParProdMac;
                   echo "</br>".$msgInserimentoValParProdMac;
                   
                   echo '</br><a href="gestione_parametri_prod_mac.php">' . $msgOk . '</a>';

                    
                    }
            	} 
                }
            
            ?>

        </div>
    </body>
</html>
