<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <?php include('../include/validator.php'); ?>
  <head>
    <?php include('../include/header.php'); ?>
  </head>
  
    <?php 
   if ($DEBUG)
        ini_set('display_errors', 1);
    include('../Connessioni/serverdb.php'); 
    include('../sql/script.php'); 
    include('../sql/script_bs_riepilogo.php'); 
    include('../sql/script_bs_valore_dato.php'); 
    include('../sql/script_bs_prodotto_cliente.php'); 
    include('../sql/script_bs_altri_prodotti_cliente.php'); 
         
      //################### RICHIESTA DI CONFERMA ELIMINAZIONE ##############
      if (!isSet($_GET['Conferma'])) {       
       
        $IdCliente=$_GET['IdCliente'];
        $Anno=$_GET['Anno'];
        //######################################################################
        //#################### GESTIONE UTENTI #################################
        //######################################################################            
        //Si recupera il proprietario del dato e si verifica se l'utente 
        //corrente ha il permesso di editare  i dati di quell'utente proprietario 
        //nelle tabella
        //Se non ha il permesso bisogna disabilitare i pulsanti di salvataggio...
        //############# VERIFICA PERMESSO DI SCRITTURA E MODIFICA ##############
        $actionOnLoad = "";
//        $arrayTabelleCoinvolte = array($Tabella);
//        if ($IdUtenteProp != $_SESSION['id_utente']) {
//            //Se il proprietario del dato è un utente diverso dall'utente 
//            //corrente si verifica il permesso 3
//            echo "</br>Eseguita verifica permesso di tipo 3";
////            $permessoModifica = verificaPermessoModifica3($_SESSION['objPermessiVis'], $arrayTabelleCoinvolte, $IdUtenteProp);
//            $actionOnLoad = $actionOnLoad . verificaPermModifica3($_SESSION['objPermessiVis'], $arrayTabelleCoinvolte, $IdUtenteProp, $IdAzienda);
//        }

        //######################################################################
        ?>
        <body onLoad="<?php echo $actionOnLoad ?>">
            <div id="mainContainer">
                <?php include('../include/menu.php'); ?>
        <table class="table3">
          <tr>
            <th class="cella3"><?php echo $msgEliminaSimulazione ?></th>
          </tr>
          <tr>
            <td class="cella6">
              <a href="javascript:history.back();">
                  <img src="/CloudFab/images/icone/no.png" class="images2" /></a>  
              <a href="elimina_bs_simulazione.php?Conferma=SI&IdCliente=<?php echo $IdCliente ?>&Anno=<?php echo $Anno ?>">
                <img src="/CloudFab/images/icone/si.png" class="images2" /></a>
            </td>
          </tr>
        </table>

        <?php
        //################### ELIMINAZIONE ##################################
        
        } else {
          
        $IdCliente = $_GET['IdCliente'];
        $Anno = $_GET['Anno'];
        
        
        
        $delete1=true;
        $delete2=true;
        $delete3=true;
        $delete4=true;
        
        //Attenzione verificare ke se l'id è un intero la query non dia errore
        begin(); 
        
        //bs_riepilogo
        //bs_valore_dato d qui non bisogna eliminare
        //bs_prodotto_cliente
        //bs_altri_prodotti_cliente
        
        $delete1=eliminaDatiRiepilogo($IdCliente,$Anno);
        
//        $delete2=eliminaValoriDatiByCliente($IdCliente);
        
        $delete3=eliminaBsProdottiCliente($IdCliente,$Anno);
        
        $delete4=eliminaBsAltriProdottiCliente($IdCliente,$Anno);       
                        
        
        
        
        
        if (!$delete1 
//                || !$delete2 
                || !$delete3 || !$delete4) {

                rollback();
                echo "</br>" . $msgTransazioneFallita; 
                echo '<div id="msgErr">' . $msgTransazioneFallita . '! ' . $msgErrContactAdmin . '!</div>';
                echo '<a href="'.$RefBack.'">' . $msgOk . '</a><br/>';
                ?>
                
                
      <?php  } else {

                commit();       
                mysql_close();
                ?>
                
                <script type="text/javascript">
          location.href="gestione_info_bs.php";
        </script>
         <?php } } ?>

    </div>
  </body>
</html>

