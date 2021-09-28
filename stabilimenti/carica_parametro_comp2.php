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
        
//####################### RECUPERO POST ########################################

           /* $IdParametro = $_POST['IdParametro'];
            $NomeParametro = str_replace("'", "''", $_POST['NomeParametro']);
            $DescriParametro = str_replace("'", "''", $_POST['DescriParametro']);
            $ValoreBase = str_replace("'", "''", $_POST['ValoreBase']);*/

//############ VARIABILI UTILI ALLA GESTIONE DEGLI ERRORI SULLE QUERY ##########
            $insertParComp = true;
            $insertValoreParComp = true;

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

//Verifica esistenza
//Apro la connessione al db
           
/*
            $query = "SELECT * FROM parametro_comp_prod 
                WHERE 
                  id_par_comp=" . $IdParametro . " 
                OR 
                  nome_variabile = '" . $NomeParametro . "'";

            $result = mysql_query($query, $connessione)
                    or die("ERRORE 1 SELECT FROM serverdb.parametro_comp_prod : " . mysql_error());
                    
 */           
            	include('../Connessioni/serverdb.php');
            	include('../sql/script_parametro_comp_prod.php');
            	include('../sql/script.php');
            	include('../sql/script_valore_par_comp.php');
    

            if ($errore) {
            	
            	//####################### RECUPERO POST ########################################
                //Ci sono errori quindi non salvo
                echo  $messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';
                
            } else { //Non ci sono errori quindi salvo
                
            	$IdParametro = $_POST['IdParametro'];
            	$NomeParametro = str_replace("'", "''", $_POST['NomeParametro']);
            	$DescriParametro = str_replace("'", "''", $_POST['DescriParametro']);
            	$ValoreBase = str_replace("'", "''", $_POST['ValoreBase']);
            	 
            	 
            	$result = findParCompByIdOrNome($IdParametro, $NomeParametro, $connessione);
            	
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
/*
                $insertParComp = mysql_query("INSERT INTO parametro_comp_prod 
                                    (id_par_comp,
                                    nome_variabile,
                                    descri_variabile,
                                    valore_base,
                                    abilitato,
                                    dt_abilitato) 
				VALUES ( 
                                        " . $IdParametro . ",
                                        '" . $NomeParametro . "',
                                        '" . $DescriParametro . "',
                                        '" . $ValoreBase . "',
                                        1,
                                        '" . dataCorrenteInserimento() . "')");
//                or die("ERRORE 2 INSERT INTO serverdb.parametro_comp_prod : " . mysql_error());
 * 
 */

                $insertParComp = insertNewParComp($IdParametro, $NomeParametro, $DescriParametro, $ValoreBase, dataCorrenteInserimento());
/*
                $insertValoreParComp = mysql_query("INSERT INTO valore_par_comp 
                    (id_comp,id_par_comp,valore_variabile,id_macchina,abilitato,dt_abilitato) 
                    SELECT  
                            componente.id_comp,
                            parametro_comp_prod.id_par_comp,
                            '" . $ValoreBase . "',
                            macchina.id_macchina,
                            1,
                            '" . dataCorrenteInserimento() . "'
                    FROM 
                            parametro_comp_prod,componente,macchina
                    WHERE 
                            parametro_comp_prod.nome_variabile='" . $NomeParametro . "'");
//                or die("ERRORE 3 INSERT INTO serverdb.valore_par_comp : " . mysql_error());
 * 
 */

                $insertValoreParComp = insertNewValoreParComp($NomeParametro, $ValoreBase, dataCorrenteInserimento());

                if ( !$insertParComp OR !$insertValoreParComp) {

                    rollback();
                    echo $msgTransazioneFallita." ".$msgErrContattareAdmin;
                    } else {

                    commit();
                    mysql_close();
                    ?>

                    <script language="javascript">
                        window.location.href="/CloudFab/stabilimenti/gestione_parametri_componenti.php";
                    </script>

                    <?php
                    }
            	} 
                }
            
            ?>

        </div>
    </body>
</html>
