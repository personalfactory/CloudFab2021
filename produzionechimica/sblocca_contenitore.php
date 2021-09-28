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
    include('../Connessioni/serverdb.php'); 
    include('../sql/script.php');    
    include('../sql/script_miscela_contenitore.php'); 
    include('../sql/script_produzione_miscela.php'); 
    include('../sql/script_miscela.php'); 
   
     ini_set(display_errors, "1");
      
      //################### RICHIESTA DI CONFERMA ELIMINAZIONE ##############
      if (!isSet($_GET['Conferma'])) {
        
        $RefBack = $_GET['RefBack'];
        $Contenitore= $_GET['Contenitore'];
        $IdMiscela=$_GET['IdMiscela'];
       ?>
        <table class="table3">
          <tr>
            <th class="cella3"><?php echo $msgConfermaSbloccoCont ." ".$Contenitore ?></th>
          </tr>
          <tr>
            <td class="cella6">
              <a href="javascript:history.back();">
                  <img src="/CloudFab/images/icone/no.png" class="images2" /></a>  
              <a href="sblocca_contenitore.php?Conferma=SI&Contenitore=<?php echo $Contenitore ?>&IdMiscela=<?php echo $IdMiscela?>&RefBack=<?php echo $RefBack ?>">
                <img src="/CloudFab/images/icone/si.png" class="images2" /></a>
            </td>
          </tr>
        </table>

        <?php

        //################### ELIMINAZIONE ##################################
        
        } else {
          
        $RefBack = $_GET['RefBack'];
        $Contenitore = $_GET['Contenitore'];
        $IdMiscela=$_GET['IdMiscela'];               
        
        $updateCont=true;
        $deleteProMis=true;
        $updateMis=true;
        begin();
        //Sblocco il contenitore      
        $updateCont= updateContenitore($valContLibero,$Contenitore);
        
        //Svuoto la tabella produzione miscela 
        $deleteProMis=deleteProdMiscela($Contenitore);
        
        //Se la miscela è incompleta modifico la qta reale da zero ad uno
        //in modo che il produzione chimica non dia problemi
        $updateMis=updatePesoMiscela($IdMiscela,$valPesoMisInit,$valPesoMisIncompleta);
        
        if (!$updateCont OR !$deleteProMis OR !$updateMis) {

                    rollback();

                    echo '<div id="msgErr">' . $msgErroreVerificato . '' . $msgErrContattareAdmin . ' <a href="gestione_contenitore.php">' . $msgOk . '</a></div>';
                } else {

                    commit();
?>
                  
           <script type="text/javascript">
          location.href="<?php echo $RefBack ?>";
        </script>
       <?php         }
        
        } ?>

    </div>
  </body>
</html>

