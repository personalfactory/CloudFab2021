<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <?php
            if($DEBUG) ini_set(display_errors, "1");
            
            include('../include/menu.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_componente_prodotto.php');
            include('../sql/script_componente_pesatura.php');
            
            $IdComponente = $_POST['Componente'];
            $IdProdotto = $_POST['IdProdotto'];
            $Quantita = $_POST['Quantita'];
            $linkRefBack=$_POST['RefBack'];

//Gestione degli errori
//Verifico che il componente sia stata settata e che non sia vuota
            $errore = false;
             $messaggio = $msgErroreVerificato . '<br />';


            if (!isset($IdComponente) || trim($IdComponente) == "") {

                $errore = true;
                $messaggio = $messaggio .' ' .$msgErrSelectMateriaPrima.' <br />';
            }
            if (!isset($Quantita) || trim($Quantita) == "" || !is_numeric($Quantita)) {

                $errore = true;
                $messaggio = $messaggio . ' '.$msgErrQtaNumerica.' <br />';
            }         
          

            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';


            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {
                $insertNewComp=true;
                $insertNewCompPesatura=true;
                begin();
                //Inserisco nella tabella componente_prodotto la nuova associazione componente prodotto con relative quantita e presa perch� non ci sono errori
               $insertNewComp=insertNuovoComponenteProd($IdProdotto,$IdComponente,$Quantita,"1",dataCorrenteInserimento());
               
               
               
               $insertNewCompPesatura=insertNuovoCompPesatura($IdProdotto,$IdComponente,$Quantita,"1",dataCorrenteInserimento());
             
                
                
                if(!$insertNewComp OR !$insertNewCompPesatura) {
                    
                    rollback();
                    echo '<div id="msgErr">' . $msgTransazioneFallita . '! ' . $msgErrContactAdmin . '!</div>';
                    echo '<a href="'.$linkRefBack.$IdProdotto .'">' . $msgOk . '</a><br/>';
                    
                } else {
                
                commit();
                   mysql_close();
                ?>
                <script type="text/javascript">
                    location.href = "<?php echo $linkRefBack.$IdProdotto ?>";
                </script>
                <?php
                }
            }//fine primo if($errore) controllo degli input relativo al prodotto 
            ?>

        </div>
    </body>
</html>
