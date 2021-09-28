<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <?php include('../include/validator.php'); ?>
  <head>
    <?php include('../include/header.php'); ?>
  </head>
   <script language="javascript">

        function disabilitaOperazioni() {
            location.href = '../permessi/avviso_permessi_visualizzazione.php'
        }

    </script>   
    <?php 
    
    include('../Connessioni/serverdb.php'); 
    include('sql/script.php'); 
    
      
      //################### RICHIESTA DI CONFERMA ELIMINAZIONE ##############
      if (!isSet($_GET['Conferma'])) {
        
        $Tabella = $_GET['Tabella'];
        $IdRecord = $_GET['IdRecord'];
        $RefBack = $_GET['RefBack'];
        $NomeId = $_GET['NomeId'];
        
        
        $sqlUtProp = mysql_query("SELECT * FROM " . $Tabella . " WHERE " . $NomeId . "='".$IdRecord."'")
                 or die("SCRIPT elimina_lab_dato.php - ERRORE : DELETE FROM " . $Tabella . " WHERE " . $NomeId . "=" . $IdRecord. "" . mysql_error());
        while ($row = mysql_fetch_array($sqlUtProp)) {

            $IdUtenteProp = $row['id_utente'];
            $IdAzienda = $row['id_azienda'];
        }
        //######################################################################
        //#################### GESTIONE UTENTI #################################
        //######################################################################            
        //Si recupera il proprietario del prodotto e si verifica se l'utente 
        //corrente ha il permesso di editare  i dati di quell'utente proprietario 
        //nelle tabella
        //Se non ha il permesso bisogna disabilitare i pulsanti di salvataggio...
        //############# VERIFICA PERMESSO DI SCRITTURA E MODIFICA ##############
        $actionOnLoad = "";
        $arrayTabelleCoinvolte = array($Tabella);
        if ($IdUtenteProp != $_SESSION['id_utente']) {
            //Se il proprietario del dato è un utente diverso dall'utente 
            //corrente si verifica il permesso 3
            echo "</br>Eseguita verifica permesso di tipo 3";
//            $permessoModifica = verificaPermessoModifica3($_SESSION['objPermessiVis'], $arrayTabelleCoinvolte, $IdUtenteProp);
            $actionOnLoad = $actionOnLoad . verificaPermModifica3($_SESSION['objPermessiVis'], $arrayTabelleCoinvolte, $IdUtenteProp, $IdAzienda);
        }

        //######################################################################
        ?>
        <body onLoad="<?php echo $actionOnLoad ?>">
            <div id="mainContainer">
                <?php include('../include/menu.php');
        
       ?>
        <table class="table3">
          <tr>
            <th class="cella3"><?php echo $msgConfermaCancellazione ?></th>
          </tr>
          <tr>
            <td class="cella6">
              <a href="javascript:history.back();">
                  <img src="/CloudFab/images/icone/no.png" class="images2" /></a>  
              <a href="elimina_lab_dato.php?Conferma=SI&Tabella=<?php echo $Tabella ?>&NomeId=<?php echo $NomeId ?>&IdRecord=<?php echo $IdRecord ?>&RefBack=<?php echo $RefBack ?>">
                <img src="/CloudFab/images/icone/si.png" class="images2" /></a>
            </td>
          </tr>
        </table>

        <?php

        //################### ELIMINAZIONE ##################################
        
        } else {
          
        $Tabella = $_GET['Tabella'];
        $IdRecord = $_GET['IdRecord'];
        $RefBack = $_GET['RefBack'];
        $NomeId = $_GET['NomeId'];
        
        $delete=true;
        
        //Attenzione verificare ke se l'id è un intero la query non dia errore
        begin(); 
        
        $delete=mysql_query("DELETE FROM " . $Tabella . " WHERE " . $NomeId . "='".$IdRecord."'")
                or die("SCRIPT elimina_lab_dato.php - ERRORE : DELETE FROM " . $Tabella . " WHERE " . $NomeId . "=" . $IdRecord. "" . mysql_error());
                
        
        if (!$delete) {

                rollback();
                echo "</br>" . $msgTransazioneFallita;
            
                
        } else {

                commit();       
        ?>
      
        <script type="text/javascript">
          location.href="<?php echo $RefBack ?>";
        </script>

        <?php } } ?>

    </div>
  </body>
</html>

