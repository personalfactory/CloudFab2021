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
            include('../sql/script.php');
            include('../sql/script_componente_pesatura.php');
            include('../sql/script_parametro_glob_mac.php');

            
      
            
            $IdComponente = $_POST['NuovoComponente'];
            $IdCompOld = $_POST['IdCompOld'];
            $IdProdotto = $_POST['IdProdotto'];
            $StringaComp=$_POST['StringaComp'];
            
            $sqlParSeparatore=findParGlobMacById("156");
            while ($row = mysql_fetch_array($sqlParSeparatore)) {
            
                $parSeparatore=$row['valore_variabile'];
            }
                                    
            $StringaCompNew= $StringaComp.$parSeparatore.$IdComponente;
            
            if($StringaComp =="") $StringaCompNew = $IdComponente;

//Gestione degli errori
//Verifico che il componente sia stata settata e che non sia vuota
            $errore = false;
            $messaggio = $msgErroreVerificato . '<br />';

            if (!isset($IdComponente) || trim($IdComponente) == "") {

                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrSelectMateriaPrima . ' <br />';
            }
            
            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';


            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {
                $aggiungiComp=true;
                
                begin();
                
                //Modifico nella tabella componente_pesatura
                $modificaStringa=modificaComponentiAlternativi($IdCompOld,$IdProdotto,$StringaCompNew);


                if(!$modificaStringa) {
                    
                    rollback();
                    echo '<div id="msgErr">' . $msgTransazioneFallita . '! ' . $msgErrContactAdmin . '!</div>';
                    echo '<a href="modifica_prodotto.php?Prodotto='.$IdProdotto .'">' . $msgOk . '</a><br/>';
                    
                } else {
                
                commit();
                   mysql_close();
                ?>
                <script type="text/javascript">
                    location.href = "modifica_prodotto.php?Prodotto=<?php echo $IdProdotto ?>";
                </script>
                <?php
                }

                
            }//fine primo if($errore) controllo degli input relativo al prodotto 
            ?>

        </div>
    </body>
</html>
