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
        include('../include/precisione.php');
        include('../Connessioni/serverdb.php');
        include('../sql/script_materia_prima.php');
        include('../laboratorio/sql/script_lab_materie_prime.php');
        include('../sql/script.php');
        
//##############################################################################
//################### NUOVA MATERIA PRIMA ######################################
//##############################################################################
        
                $errore = false;
                $messaggio = $msgErroreVerificato . '<br/>';          
                
                //Si selezionano dal laboratorio le materie prime
                $Codice="";
                $Descrizione="";
                $Fornitore="";
                $Famiglia="";
                $Prezzo=$valDefaultPrezzo;
                if (isset($_POST['MatPrima']) AND trim($_POST['MatPrima']) != "") {
                    $IdMatLab = $_POST['MatPrima'];
                    $sqlLabMt=findMatPrimaById($IdMatLab);
                    while ($rowMtLab = mysql_fetch_array($sqlLabMt)) {
                         
                          $Codice=$rowMtLab['cod_mat'];
                          $Descrizione=$rowMtLab['descri_materia'];
                          $Fornitore=$rowMtLab['fornitore'];
                          $Prezzo=$rowMtLab['prezzo'];
                          $Famiglia=$rowMtLab['famiglia'];
                          $IdAzienda=$rowMtLab['id_azienda'];                          
                    }
                    
                }
                
                $Note="";
                if (isset($_POST['Note']) AND trim($_POST['Note']) != "") {
                    $Note = str_replace("'", "''", $_POST['Note']);
                }
                         
                $ScortaMinima = 0;
                if (isset($_POST['ScortaMinima']) AND trim($_POST['ScortaMinima']) != "") {
                    $ScortaMinima =$_POST['ScortaMinima'];
                    if(!is_numeric($ScortaMinima)){
                        
                        $errore = true;
                        $messaggio = $messaggio . ' ' .$filtroScortaMinima.' '. $msgErrValoreNumerico . '<br />';
                    }
                }
               
                    
                //######### VERIFICA ESISTENZA #################################
                $result = verificaEsistenzaMatPri($Codice);

                if (mysql_num_rows($result) != 0) {
                    //Se entro nell'if vuol dire che esiste
                    $errore = true;
                    $messaggio = $messaggio . ' ' . $msgErrMatPrimaEsistente . '<br />';
                }

                $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

                if ($errore) {
                    //Ci sono errori quindi non salvo
                    echo '<div id="msgErr">' . $messaggio . '</div>';
                    
                } else {                    
                    
                    $insertMatPrima = true;
                    //Valori di default
                    $PrezzoMedPon = $valDefaultPrezzo;
                    $GiacenzaAttuale = $valDefaultGiac;
                    $UnitaMisura = $valUniMisKg;
                    $Inventario=$valDefaultInv;
                    $DtInventario=$valDataDefault;
                    
                    begin();                                         
                                       
                    $insertMatPrima = insertMatPrima(
                                            $Famiglia,
                                            $Codice,
                                            $Descrizione,       
                                            $UnitaMisura, 
                                            $Prezzo, 
                                            $PrezzoMedPon, 
                                            $Fornitore,
                                            $ScortaMinima,
                                            $GiacenzaAttuale,
                                            $Note,
                                            $Inventario,
                                            $DtInventario,$_SESSION['id_utente'],$IdAzienda);

                    if (!$insertMatPrima) {

                        rollback();

                        echo '<div id="msgErr">' . $msgErroreVerificato . '' . $msgErrContattareAdmin . ' <a href="gestione_materie_prime.php">' . $msgOk . '</a></div>';
                    } else {

                        commit();

                        echo $msgInserimentoCompletato . '<a href="gestione_materie_prime.php">' . $msgOk . '</a>';
                    }
                }//End if errore
           
           
            ?>
        </div>
    </body>
</html>
