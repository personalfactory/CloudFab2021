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
    include('../Connessioni/serverdb.php'); 
    include('../sql/script.php'); 
    ini_set(display_errors, "1");
      
      //################### RICHIESTA DI CONFERMA ELIMINAZIONE ##############
      if (!isSet($_GET['Conferma'])) {
        
        $Tabella = $_GET['Tabella'];
        $IdRecord = $_GET['IdRecord'];
        $RefBack = $_GET['RefBack'];
        $NomeId = $_GET['NomeId'];
       ?>
        <table class="table3">
          <tr>
            <th class="cella3"><?php echo $msgConfermaCancellazione ?></th>
          </tr>
          <tr>
            <td class="cella6">
              <a href="javascript:history.back();">
                  <img src="/CloudFab/images/icone/no.png" class="images2" /></a>  
              <a href="elimina_dato.php?Conferma=SI&Tabella=<?php echo $Tabella ?>&NomeId=<?php echo $NomeId ?>&IdRecord=<?php echo $IdRecord ?>&RefBack=<?php echo $RefBack ?>">
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
        
        $delete=mysql_query("DELETE FROM serverdb." . $Tabella . " WHERE " . $NomeId . "='".$IdRecord."'")
                or die("SCRIPT elimina_dato.php - ERRORE : DELETE FROM serverdb." . $Tabella . " WHERE " . $NomeId . "=" . $IdRecord. "" . mysql_error());
                
        
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

