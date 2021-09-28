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
        include('../sql/script_persona.php');
        include('../sql/script.php');
       

//########################################################################
//################### NUOVA PERSONA  #####################################
//########################################################################

            $errore = false;
            $messaggio = $msgErroreVerificato . '<br/>';
            
            
            $nome="";
            $descrizione="";
            $HrefBack=$_POST['HrefBack'];
            
            if (!isset($_POST['TipoEs']) AND !isset($_POST['TipoNu'])) {

                    $errore = true;
                    $messaggio = $messaggio . ' ' . $msgErrFamiglia . '<br />';
            }


            if (isset($_POST['Nome']) || trim($_POST['Nome']) != "") {

                $nome = str_replace("'", "''", $_POST['Nome']);
            }
            
            
            if (isset($_POST['Descrizione']) || trim($_POST['Descrizione']) != "") {
            
            	$descrizione = str_replace("'", "''", $_POST['Descrizione']);
            }

            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']); 

            //######### VERIFICA ESISTENZA #################################
            $result = verificaEsistenzaNominativo($nome);

            if (mysql_num_rows($result) > 0) {
                //Se entro nell'if vuol dire che esiste
                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrNominativoPresente . '<br />';
            }

            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

            if ($errore) {
                //Ci sono errori quindi non salvo
                echo '<div id="msgErr">' . $messaggio . '</div>';
            } else {
                                
                
                $tipoSelezionato = $_POST['scegli_tipo'];
                $tipo= "";
                if ($tipoSelezionato == "TipoEs") {
                    $tipo = $_POST['TipoEs'];
                } else if ($tipoSelezionato == "TipoNu") {
                    $tipo = str_replace("'", "''", $_POST['TipoNu']);
                }

                $insertPersona = true;
                
                begin();
                
                $insertPersona = insertPersona($tipo, $nome, $descrizione, dataCorrenteInserimento(),$_SESSION['id_utente'], $IdAzienda);

                if (!$insertPersona) {

                    rollback();

                    echo '<div id="msgErr">' . $msgErroreVerificato . '' . $msgErrContattareAdmin . ' <a href="gestione_lab_materie.php">' . $msgOk . '</a></div>';
                } else {

                    commit();

                    echo $msgInserimentoCompletato . '<a href="'.$HrefBack.'">' . $msgOk . '</a>';
                }
            }//End if errore
            ?>
        </div>
    </body>
</html>
