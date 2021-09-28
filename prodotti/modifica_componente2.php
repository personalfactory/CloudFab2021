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
            include('../Connessioni/storico.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_componente.php');
            include('../sql/script_dizionario.php');
            include('../sql/script_materia_prima.php');
            include('../laboratorio/sql/script_lab_materie_prime.php');

            if ($DEBUG) ini_set(display_errors, 1);

            $IdComponente = $_POST['Componente'];
            $CodiceComponente = $_POST['CodiceComponente'];
            $DescriComponente = $_POST['DescriComponente'];
            $DescrizioneOld = $_POST['DescrizioneOld'];

//################### Gestione errori sulle query #############################
            
            $insertStoricoComp = true;
            $updateServerdbComp = true;
            $updateServerdbDizionario = true;
            $updateMatInProduzione = true;
            $updateDescriMatLab = true;

//############## Gestione degli errori sull'input #############################
            $errore = false;
            $messaggio = $msgErroreVerificato . '<br />';

            if (!isset($CodiceComponente) || trim($CodiceComponente) == "") {

                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrCodice . '<br />';
            }
            if (!isset($DescriComponente) || trim($DescriComponente) == "") {

                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrDescri . '<br />';
            }

//Verifica esistenza 
//Verifico che non ci sia in tabella un record con gli stessi valori(descrizioni) e con Id diverso da quello che si sta modificando
            
            $result=verificaEsistenzaModificaComp($IdComponente,$CodiceComponente, $DescriComponente);
            if (mysql_num_rows($result) != 0) {
                //Se entro nell'if vuol dire che il valore inserito esiste gi� nel db
                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrMatPrimaEsistente . ' <br />';
            }
           
            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {
                               

                begin();
                
                //############### STORICIZZO ###################################
                $insertStoricoComp = inserisciComponenteStorico($IdComponente);
                                         
                //########### MODIFICO SU SERVERDB #############################
                $updateServerdbComp = modificaComponente($IdComponente,$CodiceComponente,$DescriComponente);
                
                //########### AGGIORNO DESCRIZIONE #############################
                if ($DescrizioneOld != $DescriComponente) {
                    //############### OPERAZIONI SUL DIZIONARIO ################
                    //Se la descrizione modificata era già stata caricata sul dizionario, 
                    //allora bisogna andare a modificarla anke nel dizionario 
                    //il vocabolo deve essere modificato e coincide in tutte le lingue 
                    //finchè non verrà nuovamente tradotto            
                    $updateServerdbDizionario = updateServerDBDizionario($IdComponente, $DescriComponente, 4);
                    
                    //########## MODIFICA MAT PRIMA IN PRODUZIONE ##############
                    $updateMatInProduzione = aggiornaDescriMat($CodiceComponente, $DescriComponente);
                    
                    //############# MODIFICA MAT PRIMA IN LABORATORIO ##########
                    $updateDescriMatLab = aggiornaLabDescriMat($CodiceComponente, $DescriComponente);
                }


                if ( !$insertStoricoComp  OR !$updateServerdbComp OR !$updateServerdbDizionario OR !$updateMatInProduzione OR !$updateDescriMatLab) {

                    rollback();
                    echo '<div id="msgErr">' . $msgErroreVerificato . '' . $msgErrContattareAdmin . ' <a href="gestione_componenti.php">' . $msgOk . '</a></div>';
                    echo "</br>insertStoricoComp : " . $insertStoricoComp;
                    echo "</br>updateServerdbComp : " . $updateServerdbComp;
                    echo "</br>updateServerdbDizionario : " . $updateServerdbDizionario;
                    echo "</br>updateMatInProduzione : " . $updateMatInProduzione;
                    echo "</br>updateDescriMatLab : " . $updateDescriMatLab;
                } else {

                    commit();
                    mysql_close();
                    echo $msgModificaCompletata . ' <a href="gestione_componenti.php">' . $msgOk . '</a>';
                }
            }
            ?>
        </div>
    </body>
</html>

