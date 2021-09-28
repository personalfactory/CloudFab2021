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
        
            $CodiceColoreBase = str_replace("'", "''", $_POST['CodiceColoreBase']);
            $NomeColoreBase = str_replace("'", "''", $_POST['NomeColoreBase']);
            $CostoColoreBase = str_replace("'", "''", $_POST['CostoColoreBase']);
            $Tolleranza = str_replace("'", "''", $_POST['Tolleranza']);
            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);
//############ Gestione degli errori query #####################################

            $insertColoreBase = true;

//############ Gestione degli errori input #####################################
            $errore = false;
            $messaggio = $msgErroreVerificato.'<br />';

            if (!isset($CodiceColoreBase) || trim($CodiceColoreBase) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - '.$msgCodColBaseVuoto.'!<br />';
            }
            if (!isset($NomeColoreBase) || trim($NomeColoreBase) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - '.$msgNomeColBaseVuoto.'!<br />';
            }
            if (!isset($CostoColoreBase) || trim($CostoColoreBase) == "" || !is_numeric($CostoColoreBase)) {

                $errore = true;
                $messaggio = $messaggio . ' - '.$msgCampoCostoColBaseInvalido.'!<br />';
            }
            if (!isset($Tolleranza) || trim($Tolleranza) == "" || !is_numeric($Tolleranza)) {

                $errore = true;
                $messaggio = $messaggio . ' - '.$msgCampoTollInvalido.'!<br />';
            }
//Verifica esistenza
//Apro la connessione al db
            include('../Connessioni/serverdb.php');
            include('../sql/script_colore_base.php');
            include('../sql/script.php');
            
/*
            $query = "SELECT * FROM colore_base 
                WHERE 
                    nome_colore_base = '" . $NomeColoreBase . "'
                   OR 
                    cod_colore_base = '" . $CodiceColoreBase . "'";
            $result = mysql_query($query, $connessione) or die("ERRORE SELECT FROM colore_base : " . mysql_error());
*/
            
            $result = findColoreBaseByNameOrCod($NomeColoreBase, $CodiceColoreBase, $connessione);
            
            if (mysql_num_rows($result) != 0) {
                //Se entro nell'if vuol dire che esiste
                $errore = true;
                $messaggio = $messaggio . ' '.$msgRicontrollaDati.'!<br />';
            }

           

            $messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';


            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {
                
                //################ INIZIO TRANSAZIONE ##########################
                
                begin();              
				
                $insertColoreBase = insertColoreBase($CodiceColoreBase, $NomeColoreBase, $CostoColoreBase,
                        $Tolleranza, dataCorrenteInserimento(),$_SESSION['id_utente'],$IdAzienda );
                /*
                $insertColoreBase = mysql_query("INSERT INTO colore_base (
                                        cod_colore_base, 
                                        nome_colore_base,
                                        costo_colore_base,
                                        toll_perc,
                                        abilitato,
                                        dt_abilitato) 
				VALUES ( '" . $CodiceColoreBase . "',
                                        '" . $NomeColoreBase . "',
                                        '" . $CostoColoreBase . "',
                                        '" . $Tolleranza . "',
                                        1,
                                        '" . dataCorrenteInserimento() . "')");
//  		or die("ERRORE INSERT INTO colore_base : ".mysql_error());  
				*/
                if (!$insertColoreBase) {

                    rollback();
                    echo $msgTransazioneFallita.'! '.$msgErrContattareAdmin.'!';

                    echo "<br/>$insertColoreBase" . $insertColoreBase;
                } else {

                    commit();
                    mysql_close();
                    ?>
                    <script language="javascript">
                        window.location.href="gestione_colori_base.php";
                    </script>
                <?php
                }
            }
            ?>
        </div>
    </body>
</html>
