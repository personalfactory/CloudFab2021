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
        include('../include/funzioni.php');
        include('../include/precisione.php');
        include('../Connessioni/serverdb.php');
        include('sql/script.php');
        include('sql/script_lab_allegato.php');
        include('sql/script_lab_caratteristica.php');
        include('sql/script_lab_risultato_car.php');

        if($DEBUG) ini_set('display_errors', "1");
        
//###################Gestione degli errori##################################

            $errore = false;
            $messaggio = $msgErroreVerificato . '<br />';

            if (!isset($_POST['Caratteristica']) || trim($_POST['Caratteristica']) == "") {

                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrSelectCaratteristica . '<br />';
            }

            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

            if ($errore) {
                //Ci sono errori quindi non salvo
                echo '<div id="msgErr">' . $messaggio . '</div>';
            } else {


                list($IdCar, $NomeCar) = explode(";", $_POST['Caratteristica']);
                $IdEsperimento = $_POST['IdEsperimento'];
                $TipoValore = $_POST['TipoValore'];

                $ValDimensione = "0";
                $ValoreCar = 0;
                //##############################################################
                //#################### SALVATAGGIO RISULTATO ###################
                //##############################################################

                if ((isset($_POST['ValoreCar']) AND trim($_POST['ValoreCar']) != "")) {

                    $ValoreCar = str_replace("'", "''", $_POST['ValoreCar']);
                    
                    if (isset($_POST['Note']))
                        
                        $Note = str_replace("'", "''", $_POST['Note']);

                    if (isset($_POST['ValDimensione'])) {
                        $ValDimensione = str_replace("'", "''", $_POST['ValDimensione']);
                    }
                    $insertCar = true;



                    //########## TRANSAZIONE ##################################
                    begin();
                    $insertCar = inserisciCaratteristicaProva($IdEsperimento, $IdCar, $ValoreCar, $ValDimensione, $Note);

                    if (!$insertCar) {
                        rollback();
                        echo '<div id="msgErr">' . $msgErroreVerificato . '' . $msgErrContattareAdmin . ' <a href="modifica_lab_risultati.php?IdEsperimento=' . $IdEsperimento . '">' . $msgOk . '</a></div>';
                    } else {

                        commit();
                        echo $msgLabCarDefinita . "</br>";
                    }
                }
                //##############################################################
                //########### UPLOAD DEL FILE ##################################
                //##############################################################

                $uploadEffettuato = true;
                $destFileName = "";

                if (isset($_FILES['user_file']['name']) AND $_FILES['user_file']['name'] != "") {

                        $Descri = "";
                        if (isset($_POST['Descri']))
                            $Descri = str_replace("'", "''", $_POST['Descri']);
                        $NoteFile = "";
                        if (isset($_POST['NoteFile']))
                            $NoteFile = str_replace("'", "''", $_POST['NoteFile' ]);

                        $destFileName = $preFileLab . "_" . dataCorrenteFile() . "_" . $_FILES['user_file']['name'];
                       

                        //GENERAZIONE DEL NOME DEL FILE DA CARICARE SUL SERVER
                        $uploadEffettuato = uploadFile($_FILES['user_file'], $destLabUploadDir, $destFileName, "");
                        //Se il file viene caricato si salva il link nella tabella lab_allegato
                        if ($uploadEffettuato) {

                            inserisciNuovoAllegato($IdCar, $IdEsperimento, $Descri, $destFileName, $valRifEsperimento, $NoteFile);
                            echo $msgInfoDocCaricato;
                            
                        } else {
                            
                            $destNomeFile = "";
                            echo $msgErrDocNonCaricato;
                        }
                       
                }
            }//fine primo if($errore) controllo degli input relativo alla car 

            echo '</br> <a href="modifica_lab_risultati.php?IdEsperimento=' . $IdEsperimento . '">' . $msgTornaAllaProva . ' </a>';
            ?>

        </div>
    </body>
</html>
