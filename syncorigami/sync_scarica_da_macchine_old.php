<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <?php include('../include/validator.php'); ?>
  <head>
    <?php include('../include/header.php'); ?>
  </head>
    <script language="javascript">             
        
        function ScaricaDaMacchine(){
          document.forms["AggiornaServer"].action = "sync_scarica_da_macchine.php";
          document.forms["AggiornaServer"].submit();
        }
        function ScaricaBckDaMacchine(){
    
          document.forms["AggiornaServer"].action = "sync_scarica_da_macchine.php?ScaricaBkp=1";
          document.forms["AggiornaServer"].submit();
        }
      </script>
    
    <?php     
    //################## NUOVA GESTIONE UTENTI #########################
    
    if($DEBUG) ini_set('display_errors', 1);
    //################## GESTIONE UTENTI #########################
    $actionOnLoad = "";
    $elencoFunzioni=array("59","60");    
    $actionOnLoad=gestisciPermessiUtenteOnLoad($elencoFunzioni,$_SESSION['objPermessiVis']);    
       
    ?>
    
  <body onLoad="<?php echo $actionOnLoad ?>">
      <div id="mainContainer">
          
      <?php
      include('../include/menu.php');
      include('../include/precisione.php');
      include('../Connessioni/serverdb.php');
      include('../sql/script_aggiornamento.php');

      if (!isset($_POST['ScaricaAggiornamenti']) && !isset($_GET['ScaricaBkp'])) {
        ?>

        <div id="container" style="width:80%; margin:15px auto;">
          <form id="AggiornaMacchine" name="AggiornaServer" method="POST" action="sync_carica_verso_macchina.php">
            <table width="100%">
              <tr>
                <td class="cella3" colspan="2"><?php echo $titoloPagScaricaAggDaStab ?></td>
              </tr>
              <input type="hidden" name="ScaricaAggiornamenti" id="ScaricaAggiornamenti" value="1"/>
              <tr >  
                <td class="cella22"><?php echo $filtroOttieniAgg ?></td>
                <td class="cella111"><input type="submit" title="<?php echo $titleOttAgg ?>" value="<?php echo $valueButtonScarica ?>" onClick="javascript:ScaricaDaMacchine();"/></td>
              </tr>
              <tr>
                <td class="cella22"><?php echo $filtroOttieniBkp ?></td>
                <td class="cella111"><input type="submit" id="60" title="<?php echo $titleOttBkp ?>" value="<?php echo $valueButtonScarica ?>" onClick="javascript:ScaricaBckDaMacchine();"/></td>
              </tr>
              <tr>
                <td class="cella111" style="text-align: right " colspan="2" >
                  <input type="reset" value="<?php echo $valueButtonAnnulla?>" onClick="javascript:history.back();"/>
                </td>
              </tr>
            </table>
          </form>
        </div>

        <?php
      } else if (isset($_POST['ScaricaAggiornamenti']) && !isset($_GET['ScaricaBkp'])) {

        //######################################################################
        //##### DOWNLOAD DEGLI AGGIORNAMENTI PROVENIENTI DALLE MACCHINE ########
        //######################################################################   
        // SI RECUPERA DAL DB IL NUMERO DI AGGIORNAMENTI DI TIPO 'IN' SALVATI NELLA TABELLA aggiornamento 
        $sqlAggOld = countAgg($tipoAggIn);
        while ($rowAggOld = mysql_fetch_array($sqlAggOld)) {

          $dtUltAgg = $rowAggOld['dt_ult_agg'];
        }

        //SI SCARICANO GLI AGGIORNAMENTI
        //ISTRUZIONE LINUX
        $log = shell_exec('sh startSync.sh dist/SyncOrigami.jar downloadAggiornamentiDaMacchine');

        //ISTRUZIONE WINDOWS
//                $log = shell_exec('startSyncWin.bat dist/SyncOrigami.jar downloadAggiornamentiDaMacchine');
        
        //SI VERIFICA IL  DOWNLOAD MEDIANTE UNA SELECT FROM TABELLA aggiornamento 
        $sqlAgg = findAggByTipoDtUltAgg($tipoAggIn,$dtUltAgg);
        
        echo "</br><div style='color: darkgreen'>".$msgInfoNumAggScaricati . mysql_num_rows($sqlAgg) . "</div>";
        
        while ($rowAgg = mysql_fetch_array($sqlAgg)) {

          //################# VISUALIZZAZIONE RISULTATI ########################

          if (mysql_num_rows($sqlAgg) > 0) {

            //CASO 1: AGGIORNAMENTI SCARICATI
              echo $filtroIdMacchina. " : " . $rowAgg['id_macchina'] . "</br>";
              echo $filtroStabilimento." : " . $rowAgg['descri_stab'] . "</br>";
              echo $filtroCodStab." : " . $rowAgg['cod_stab'] . "</br>";
              echo $filtroNomeFile." : " . $rowAgg['nome_file'] . "</br>";
              echo $filtroVersioneEntrata." : " . $rowAgg['versione'] . "</br>";
              echo $filtroDtOraAgg." : " . $rowAgg['dt_aggiornamento'] . "</br></br>";

            
          }
        }
        if (mysql_num_rows($sqlAgg) == 0) {

          $pos = strpos($log, "FileToDownloadNotFoundException");

          if ($pos == true) {

            //CASO 2: NON CI SONO AGGIORNAMENTI DA SCARICARE
            echo "<div style='color: darkgreen'>".$msgInfoNotAggPerServer."</br></div>";
            
          } else {

            //CASO 3: ERRORI DURANTE IL DOWNLOAD
            echo "<div style='color: #FF0000'>".$msgErrAgg."</div>";
           

//                //INVIO MAIL DI NOTIFICA
//                $a = "marilisa.tassone@isolmix.com";
//                $oggetto="AGGIORNAMENTO SERVER";
//                $messaggio = "ERRORE NEL DOWNLOAD : ".$rowAgg['descri_stab'];
//                mail($a,$oggetto,$messaggio);
          }
        }
        echo '<a href="/CloudFab/index.php">'. $filtroTornaHome.'</a>';
//        echo '<a href="visualizza_log.php">'.$msgInfoVediLog.'</a>';

        //######################################################################
        //########## DOWNLOAD DEI FILE DI BACKUP ###############################
        //######################################################################   
      } else if (isset($_GET['ScaricaBkp'])) {

//      //ISTRUZIONE LINUX
        $log = shell_exec('sh startSync.sh dist/SyncOrigami.jar downloadBackupDaMacchine');
       
        //ISTRUZIONE WINDOWS
//        $log = shell_exec('startSyncWin.bat dist/SyncOrigami.jar downloadBackupDaMacchine');

        if (strpos($log, "DOWNLOAD_COMPLETATO") == true) {
          //CASO 1: FILE SCARICATI TUTTO OK
          echo "</br><div style='color: darkgreen' >".$msgInfoDownloadCompleto."</div>";
        }

        if (strpos($log, "FileToDownloadNotFoundException") == true) {

          //CASO 2: NON CI SONO BACKUP DA SCARICARE
          echo "</br><div style='color: darkgreen' >".$msgInfoNotBkpToDownload."</br></div>";
        }
        if (strpos($log, "ERROR") == true) {

          //CASO 3: ERRORI DURANTE IL DOWNLOAD
         echo "<div style='color: #FF0000'>".$msgErrAgg."</div>";
         
//                //INVIO MAIL DI NOTIFICA
//                $a = "marilisa.tassone@isolmix.com";
//                $oggetto="AGGIORNAMENTO SERVER";
//                $messaggio = "ERRORE NEL DOWNLOAD : ".$rowAgg['descri_stab'];
//                mail($a,$oggetto,$messaggio);
        }


//         echo '<a href="visualizza_log.php">'.$msgInfoVediLog.'</a>';
        echo '<a href="/CloudFab/index.php">'. $filtroTornaHome.'</a>';
      }
      ?>
<div id="msgLog">
               <?php if ($DEBUG) {
       
//        echo "</br>actionOnLoad :" . $actionOnLoad;
        
    }
                ?>
            </div>
          
    </div><!--mainContainer-->

  </body>
</html>
