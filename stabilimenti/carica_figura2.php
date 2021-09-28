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
            include('../sql/script_figura.php');
            include('../sql/script_utente_figura.php');
            include('../sql/script.php');

            $Nome = str_replace("'", "''", $_POST['Nome']);
            $Cognome = str_replace("'", "''", $_POST['Cognome']);
//            $Codice = str_replace("'", "''", $_POST['Codice']);
            $FiguraTipo = str_replace("'", "''", $_POST['FiguraTipo']);
            $UtenteInephos=$_SESSION['id_utente'];
//            $UtenteInephos = str_replace("'", "''", $_POST['UtenteInephos']);
            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);

//Ricavo il valore dei campi tipo_riferimento e geografico mandati tramite POST
            $TipoRiferimento = $_POST['scegli_geografico'];

            $Geografico = "";
            if ($TipoRiferimento == "Mondo") {
                $Geografico = "Mondo";
            } else if ($TipoRiferimento == "Continente") {
                $Geografico = $_POST['Continente'];
            } else if ($TipoRiferimento == "Stato") {
                $Geografico = $_POST['Stato'];
            } else if ($TipoRiferimento == "Regione") {
                $Geografico = $_POST['Regione'];
            } else if ($TipoRiferimento == "Provincia") {
                $Geografico = $_POST['Provincia'];
            } else if ($TipoRiferimento == "Comune") {
                $Geografico = $_POST['Comune'];
            }

//Ricavo il valore dei campi livello_gruppo e gruppo mandati tramite POST
            $LivelloGruppo = $_POST['scegli_gruppo'];
            $Gruppo = "";
            if ($LivelloGruppo == "PrimoLivello") {
                $Gruppo = $_POST['PrimoLivello'];
            } else if ($LivelloGruppo == "SecondoLivello") {
                $Gruppo = $_POST['SecondoLivello'];
            } else if ($LivelloGruppo == "TerzoLivello") {
                $Gruppo = $_POST['TerzoLivello'];
            } else if ($LivelloGruppo == "QuartoLivello") {
                $Gruppo = $_POST['QuartoLivello'];
            } else if ($LivelloGruppo == "QuintoLivello") {
                $Gruppo = $_POST['QuintoLivello'];
            } else if ($LivelloGruppo == "SestoLivello") {
//                $Gruppo = $_POST['SestoLivello'];
                $Gruppo = "Universale";
            }
            

//Gestione degli errori
//Inizializzazione dell'errore e del messaggio di errore
            $errore = false;
            $messaggio = $msgErroreVerificato.'<br/>';

            if (!isset($Nome) || trim($Nome) == "") {

                $errore = true;
                $messaggio = $messaggio . $msgErroreNome.'<br/>';
            }
            if (!isset($Cognome) || trim($Cognome) == "") {

                $errore = true;
                $messaggio = $messaggio . $msgErroreCognome.'<br />';
            }
             if (!isset($FiguraTipo) || trim($FiguraTipo) == "") {

                $errore = true;
                $messaggio = $messaggio . $msgErroreFiguraTipo.'<br />';
            }
            

//            //Controllo sulla variabile errore
//            if ($errore) {
//                //Ci sono errori quindi non salvo
//                echo $messaggio;
//            } else {
            //############# GENERAZIONE DEL CODICE #################################
            
            $Codice = "";
            $sqlCod = generaCodice();
            $rowCod = mysql_fetch_array($sqlCod);      
            $Codice = $rowCod['codice'];
            
            $sqlEsisteCod = findFiguraByCodice($Codice);
            //Se nella tabella è presente un'altra figura con lo stesso codice, viene generato
            //un nuovo codice finchè non risulta diverso da tutti quelli già associati agli operatori
            while (mysql_num_rows($sqlEsisteCod) > 0) {
                $sqlCod = generaCodice();
                $rowCod = mysql_fetch_array($sqlCod);
                $Codice = $rowCod['codice'];
                $sqlEsisteCod = findFiguraByCodice($Codice);
            }

//################ SALVATAGGIO NEL DB ##########################################
            //INIZIO TRANSAZIONE!!!!!
            begin();

            $resultInsertFigura = insertNuovaFigura($FiguraTipo, 
                    $Nome, 
                    $Cognome, 
                    $Codice, 
                    $Geografico, 
                    $TipoRiferimento, 
                    $Gruppo, 
                    $LivelloGruppo,$_SESSION['id_utente'], $IdAzienda);
            //Inizializzo la var relativa all'inserimento dell'associazione id_utente-operatore
            //nel caso in cui la query non venga eseguita affatto
            $resultAssociaUtente =1;            
            //Salvo l'associazione con la figura e utente inephos
                          
                //Recupero l'id della figura appena inserita
                $sqlIdFigura = selectMaxIdFiguraFromFigura();
                $idFigura="";
                while ($rowIdFig = mysql_fetch_array($sqlIdFigura)) {
                    $idFigura = $rowIdFig['id_figura'];
                }
                
                //Verifico che l'utente inephos selezionato non sia già 
                //associato ad un altro operatore
//                if(mysql_num_rows(selectOperByIdUtente($UtenteInephos))>0){
//                
//                    $errore = true;
//                    $messaggio = $messaggio . $msgUtenteAssociato.'<br />';
//                }
//                            
               $resultAssociaUtente = insertNuovoUtenteFigura($idFigura, $UtenteInephos);           

            $messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';
            
            if ($errore 
                    OR !$resultInsertFigura 
                    OR !$resultAssociaUtente
            ){
                rollback();
                
                echo $msgTransazioneFallita.'<br />';
                echo $messaggio;
               
//                echo "</br>resultInsertFigura : ".$resultInsertFigura;
//                echo "</br>resultAssociaUtente : ".$resultAssociaUtente;
            } else {
                
                commit();
                ?>
                <script type="text/javascript">
                    location.href = "gestione_figure.php"
                </script>
<?php } ?>

        </div>
    </body>
</html>
