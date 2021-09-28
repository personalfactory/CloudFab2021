<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <?php include('../include/validator.php'); ?>
  <head>
    <?php include('../include/header.php'); ?>
  </head>
  <body>  
       <div id="mainContainer">
    <?php include('../include/menu.php');
    include('../Connessioni/serverdb.php'); 
   
      
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
        
        //Attenzione verificare ke se l'id è un intero la query non dia errore
              
        mysql_query("DELETE FROM " . $Tabella . " WHERE " . $NomeId . "='".$IdRecord."'")
                or die("SCRIPT elimina_lab_dato.php - ERRORE : DELETE FROM " . $Tabella . " WHERE " . $NomeId . "=" . $IdRecord. "" . mysql_error());
        
        ?>
      
        <script type="text/javascript">
          location.href="<?php echo $RefBack ?>";
        </script>

      <?php } ?>

    </div>
  </body>
</html>

