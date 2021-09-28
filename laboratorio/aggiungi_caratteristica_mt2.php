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
        include('../include/funzioni.php');
        include('../Connessioni/serverdb.php');
        include('sql/script.php');
        include('sql/script_lab_matpri_car.php');
        include('sql/script_lab_allegato.php');
        
        ini_set("display_errors", "1");        
       
//Gestione degli errori
//Verifico che il componente sia stata settata e che non sia vuota
            $errore = false;
            $messaggio = $msgErroreVerificato . '<br />';
            $msgFine="";

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
                
                $IdMateria = $_POST['IdMateria'];
                $TipoValore = $_POST['TipoValore'];

                $ValDimensione = "0";
                $Note="";
                //##############################################################
                //#################### SALVATAGGIO RISULTATO ###################
                //##############################################################

                if ((isset($_POST['ValoreCar']) AND trim($_POST['ValoreCar']) != "")) {

                    $ValoreCar = str_replace("'", "''",$_POST['ValoreCar']);
                    
                    if (isset($_POST['ValDimensione'])) {
                        $ValDimensione = str_replace("'", "''",$_POST['ValDimensione']);
                    }

                    if (isset($_POST['Note']))
                        $Note = str_replace("'", "''", $_POST['Note']);
                    
                    $insertCar = true;
                    begin();
                    $insertCar = inserisciCaratteristica($IdMateria, $IdCar, $ValoreCar, $ValDimensione,$Note);

                    if (!$insertCar) {
                        rollback();
                        echo '<div id="msgErr">' . $msgErroreVerificato . '' . $msgErrContattareAdmin . ' <a href="gestione_lab_caratteristiche.php">' . $msgOk . '</a></div>';
                    } else {

                        commit();
                        $msgFine=$msgFine." ". $msgLabCarDefinita;
                    }
                }
                
                //##############################################################
                //########### UPLOAD DEL FILE ##################################
                //##############################################################

                $uploadEffettuato = true;
                $destFileName = "";
                
                if (isset($_FILES['user_file']) AND $_FILES['user_file']['name'] != "") {
                   
                    $Descri = "";
                    if(isset($_POST['Descri'])) $Descri= str_replace("'", "''", $_POST['Descri']);
                    $NoteFile ="";
                    if(isset($_POST['NoteFile'])) $NoteFile=str_replace("'", "''", $_POST['NoteFile']);
                    
                    $destFileName = $preFileLab . "_" . dataCorrenteFile() . "_" . $_FILES['user_file']['name'];

                    //GENERAZIONE DEL NOME DEL FILE DA CARICARE SUL SERVER
                    $uploadEffettuato = uploadFile($_FILES['user_file'], $destLabUploadDir, $destFileName, "");
                    //Se il file viene caricato si salva il link nella tabella lab_allegato
                    if ($uploadEffettuato) {

                        inserisciNuovoAllegato($IdCar, $IdMateria, $Descri, $destFileName, $valRifMateriaPrima,$NoteFile);
                        $msgFine=$msgFine."</br>".$msgInfoDocCaricato;
                    } else {
                        $destNomeFile = "";
                        $msgFine=$msgFine."</br>".$msgErrDocNonCaricato;
//                        echo "</br>".$msgErrDocNonCaricato;
                    }
                }
                
                 echo '</br> '.$msgFine.' <a href="modifica_lab_materia.php?IdMateria=' . $IdMateria . '">' . $msgOk . ' </a>';
            }//fine primo if($errore) controllo degli input relativo al prodotto 
            ?>

        </div>
    </body>
</html>
