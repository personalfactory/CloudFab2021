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


//################# CONTROLLO ERRORI SULLE QUERY ###############################

            $insertParProdotto = true;
            $insertParametroProdNew =true;
            $insertValoreProdotto = true;

//####################### CONTROLLO INPUT ######################################

            $errore = false;
            $erroreEs = false;
            $messaggio = $msgErroreVerificato . '<br/>';
            $messaggioEs = $msgErroreVerificato . '<br/>';

            if (!isset($_POST['IdParametro']) || trim($_POST['IdParametro']) == "") {

                $errore = true;
                $messaggio = $messaggio . $msgErrCampoIdParVuoto . '<br />';
            }
            if (!isset($_POST['NomeParametro']) || trim($_POST['NomeParametro']) == "") {

                $errore = true;
                $messaggio = $messaggio . $msgErrCampoNomeParVuoto . '<br />';
            }
            if (!isset($_POST['DescriParametro']) || trim($_POST['DescriParametro']) == "") {

                $errore = true;
                $messaggio = $messaggio . $msgErrCampoDescriParVuoto . '<br />';
            }
            if (!isset($_POST['ValoreBase']) || trim($_POST['ValoreBase']) == "") {

                $errore = true;
                $messaggio = $messaggio . $msgErrCampoValBaseVuoto . '<br />';
            }
            //Verifica tipo di dati
            if (!is_numeric($_POST['IdParametro'])) {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $filtroId . $msgErrDeveEssereIntero . '<br />';
            }


            if ($errore) {

                //####################### RECUPERO POST ########################################
                //Ci sono errori quindi non salvo
                echo $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
            } else { //Non ci sono errori quindi salvo
                include('../Connessioni/serverdb.php');
                include('../sql/script_parametro_prodotto.php');
                include('../sql/script.php');
                include('../sql/script_parametro_prod.php');
                include('../sql/script_valore_prodotto.php');

//####################### RECUPERO POST ########################################

                $IdParametro = $_POST['IdParametro'];
                $NomeParametro = str_replace("'", "''", $_POST['NomeParametro']);
                $DescriParametro = str_replace("'", "''", $_POST['DescriParametro']);
                $ValoreBase = str_replace("'", "''", $_POST['ValoreBase']);
                
                //Verifica Esistenza
                //$result = findParProdByIdOrNome($IdParametro, $NomeParametro, $connessione);

               // if (mysql_num_rows($result) != 0) {
                    //Se entro nell'if vuol dire che esiste
                  //  $erroreEs = false;
               //     $messaggioEs = $messaggioEs . $msgDuplicaRecord . '<br />';
                //}
                
                //######### NUOVE TABELLE ######################################
                $result2=findParametroProdByIdOrNome($IdParametro, $NomeParametro);
                if (mysql_num_rows($result2) != 0) {
                    //Se entro nell'if vuol dire che esiste
                    $erroreEs = true;
                    $messaggioEs = $messaggioEs . $msgDuplicaRecord . '<br />';
                }
                //##############################################################
                
                if ($erroreEs) {

                    echo $messaggioEs . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                } else {
                    //################### INIZIO TRANSAZIONE SALVATAGGIO NEL DB #################            
                    begin();

                   
                    //$insertParProdotto = insertNewParProdotto($IdParametro, $NomeParametro, $DescriParametro, $ValoreBase, dataCorrenteInserimento());
                    
                    //##################################################################
                    //########## NUOVI PARAMETRI DEL PRODOTTO ##########################
                    //##################################################################
                        //PARTE NUOVA : 5 ottobre 2015
                        //Inserimento del nuovo parametro nella nuova tabella parametro_prod 
                        $insertParametroProdNew=insertNewParametroProd($IdParametro, $NomeParametro, $DescriParametro, $ValoreBase, dataCorrenteInserimento());
                                         
                        //Creazione dei valori_prodotto relativi al nuovo parametro tutti i prodotti esistenti                        
                        $insertValoreProdotto=generaValoriProdDaProdotto($IdParametro,$ValoreBase);
                    //##################################################################
                    
                    if (!$insertParProdotto OR !$insertParametroProdNew OR !$insertValoreProdotto) {

                        rollback();
                        echo $msgTransazioneFallita . " " . $msgErrContattareAdmin;

                        
                    } else {

                        commit();
                        mysql_close();
                        ?>
                        <!--<script language="javascript">
                            window.location.href = "/CloudFab/stabilimenti/associa_parametro_categorie.php?ParametroProdotto=<?php echo $IdParametro . ";" . $DescriParametro . ";" . $ValoreBase ?>";
                        </script>-->
                        <?php
                    echo 'INSERIMENTO AVVENUTO CON SUCCESSO!<br/>';
//           	 <a href="associa_parametro_categorie.php">ASSOCIA IL NUOVO PARAMETRO ALLE CATEGORIE </a>';
                    }
                }
            }
            ?>
        </div>
    </body>
</html>
