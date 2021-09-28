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
            include ('../sql/script_bs_altri_prodotti.php');
            include ('../sql/script.php');
            include('../include/funzioni.php');
            include('../include/precisione.php');

            $ToDo = $_POST['ToDo'];
            $IdProdotto=0;
            $CodProdotto = str_replace("'", "''", $_POST['CodProdotto']);
            $NomeProdotto = str_replace("'", "''", $_POST['NomeProdotto']);
            $Classificazione = str_replace("'", "''", $_POST['Classificazione']);
            $Rating = str_replace("'", "''", $_POST['Rating']);
//            $LinkPresentazioneProd = str_replace("'", "''", $_POST['LinkPresentazioneProd']);
            $Costo = str_replace("'", "''", $_POST['Costo']);
            $Features = str_replace("'", "''", $_POST['Features']);
            $Corrispettivo1 = str_replace("'", "''", $_POST['Corrispettivo1']);
            $Prezzo1 = str_replace("'", "''", $_POST['Prezzo1']);
            $Note1 = str_replace("'", "''", $_POST['Note1']);
            $Corrispettivo2 = str_replace("'", "''", $_POST['Corrispettivo2']);
            $Prezzo2 = str_replace("'", "''", $_POST['Prezzo2']);
            $Note2 = str_replace("'", "''", $_POST['Note2']);
            $Corrispettivo3 = str_replace("'", "''", $_POST['Corrispettivo3']);
            $Prezzo3 = str_replace("'", "''", $_POST['Prezzo3']);
            $Note3 = str_replace("'", "''", $_POST['Note3']);

            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);

//Gestione degli errori
//Inizializzazione dell'errore e del messaggio di errore
            $errore = false;
            $messaggio = $msgErroreVerificato . '<br />';
            if (!is_numeric($Costo)) {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $filtroCostoProduzione . ' : ' . $msgNumerico . ' !<br/>';
            }
            if (!is_numeric($Prezzo1)) {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $filtroPrezzo1 . ' : ' . $msgNumerico . ' !<br/>';
            }

            if (!is_numeric($Prezzo2)) {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $filtroPrezzo2 . ' : ' . $msgNumerico . ' !<br/>';
            }
            if (!is_numeric($Prezzo3)) {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $filtroPrezzo3 . ' : ' . $msgNumerico . ' !<br/>';
            }

            $verificaCod=true;
            if ($ToDo == "NuovoProdotto") {

                //Verifica esistenza del codice prodotto nel caso di inserimento
                $verificaCod = findBSAltroProdottoByCodice($CodProdotto);
                if(mysql_num_rows($verificaCod)>0) { 
                    
                    $errore=true;                    
                    $messaggio = $messaggio. ' - '. $msgErrBsCodProd;     
                
                }
            } else if ($ToDo == "ModificaProdotto") {
                
                $IdProdotto = str_replace("'", "''", $_POST['IdProdotto']);
                
                //Verifica esistenza del codice prodotto nel caso di una modifica
                $verificaCod = findBSAltroProdCodiceUpdate($IdProdotto,$CodProdotto);
                if(mysql_num_rows($verificaCod)>0) { 
                    
                    $errore=true;                    
                    $messaggio = $messaggio. ' - '. $msgErrBsCodProd;     
                
                }
                
            }

            $messaggio = $messaggio . '<a href="javascript:history.back()">  ' . $msgRicontrollaDati . '</a>';


            //Controllo sulla variabile errore
            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {

                begin();
                if ($ToDo == "NuovoProdotto") {


                    $LinkPresentazioneProd = "";

                    //########### UPLOAD DEL FILE ##################################
                    if (isset($_FILES['user_file']) AND $_FILES['user_file'] != "") {
                        //NOME DEL FILE DDT DA CARICARE SUL SERVER
                        $LinkPresentazioneProd = $_FILES['user_file']['name'];

                        $uploadEffettuato = uploadFile($_FILES['user_file'], $destPresProdUploadDir, $LinkPresentazioneProd, "");
                        //Se il file non viene caricato in tabella si salva un valore vuoto
                        if ($uploadEffettuato)
                            echo $msgInfoFileCaricato . "</br>";
                        else
                            $destNomeFile = '';
                    }

                    $insProdottoBs = insertNewAltroProdottoBs($CodProdotto, $NomeProdotto, $Classificazione, $Costo, $Rating, $LinkPresentazioneProd, $Features, $Corrispettivo1, $Prezzo1, $Note1, $Corrispettivo2, $Prezzo2, $Note2, $Corrispettivo3, $Prezzo3, $Note3, $valBsTipoProdNotPf, $_SESSION['id_utente'], $IdAzienda);
                
                    
                    } else if ($ToDo == "ModificaProdotto") {

//                    $IdProdotto = str_replace("'", "''", $_POST['IdProdotto']);
                    

                    if (isSet($_POST['LinkPresentazioneProd']) AND $_POST['LinkPresentazioneProd'] != '')
                        $LinkPresentazioneProd = str_replace("'", "''", $_POST['LinkPresentazioneProd']);


                    //########### UPLOAD DEL FILE ##################################
                    if (isset($_FILES['user_file']) AND $_FILES['user_file']['name'] != "") {

                        //NOME DEL FILE DDT DA CARICARE SUL SERVER
                        $LinkPresentazioneProd = $_FILES['user_file']['name'];

                        $uploadEffettuato = uploadFile($_FILES['user_file'], $destPresProdUploadDir, $LinkPresentazioneProd, "");
                        //Se il file non viene caricato in tabella si salva un valore vuoto
                        if ($uploadEffettuato)
                            echo $msgInfoFileCaricato . "</br>";
                        else
                            $destNomeFile = '';
                    }

                    $insProdottoBs = updateBSAltroProdottoById($IdProdotto, $CodProdotto, $NomeProdotto, $Classificazione, $Costo, $Rating, $LinkPresentazioneProd, $Features, $Corrispettivo1, $Prezzo1, $Note1, $Corrispettivo2, $Prezzo2, $Note2, $Corrispettivo3, $Prezzo3, $Note3, $IdAzienda);
                }


                if (!$insProdottoBs) {

                    rollback();
                    echo '<div id="msgErr">' . $msgTransazioneFallita . '! ' . $msgErrContactAdmin . '!</div>';
                    echo '<a href="gestione_info_bs.php">' . $msgTornaAiCodici . '</a><br/>';
                } else {

                    commit();
                    mysql_close();
                    echo($msgInserimentoCompletato . ' <a href="gestione_prodotti_bs.php">' . $msgOk . '</a><br/>');
                }
            }
            ?>
        </div>
    </body>
</html>
