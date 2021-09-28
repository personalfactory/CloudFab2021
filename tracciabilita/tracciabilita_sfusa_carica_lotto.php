<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <?php include('../include/validator.php'); ?>
  <head>
    <?php include('../include/header.php'); ?>
  </head>
  <body onload="document.getElementById('CodLotto').focus()">
    
    <div id="tracciabilitaContainer">

      <script language="javascript">
            
        function inviaCodice(campo,evento)
        {
          codice_tasto = evento.keyCode ? evento.keyCode : evento.which ? evento.which : evento.charCode;
          if (codice_tasto == 13)
          {
            document.forms["AssociaCodLottoCodChimica"].action = "tracciabilita_sfusa_carica_lotto.php";
            document.forms["AssociaCodLottoCodChimica"].submit();
            return false;
          }
          else
          {
            return true;
          }
        }
        
      </script>

      <?php 
      include('../include/menu.php'); 
      
      $erroreCodLotto = false;
      $messaggioLotto = "";

      $Contenitore = $_SESSION['Contenitore'];
      $IdMiscela = $_SESSION['IdMiscela'];
      $DataMiscela = $_SESSION['DataMiscela'];
      $CodFormula = $_SESSION['CodFormula'];
      $DescriFormula = $_SESSION['DescriFormula'];
      $CodFormulaDescri = $_SESSION['CodFormulaDescri'];
      $CodProdotto = substr($CodFormula, 1, 5);

      if (!isset($_POST['CodLotto']) OR $_POST['CodLotto'] == "") {

//##############################################################################     
//############### LETTURA CODICE LOTTO #########################################
//##############################################################################
        ?>

        <div id="tracciabilitaContainer" style=" width:700px; margin:15px auto;">

          <form class="form" id="AssociaCodLottoCodChimica" name="AssociaCodLottoCodChimica" method="post" >
            <table width="700px">
              <tr>
                <td class="cella33" colspan="2"><?php echo $titoloPaginaInserCodLotto ?> </td>
              </tr>
              <tr>
                <td class="cella22"><?php echo $filtroCodLotto ?></td>
                <td  class="cella111"><input class="inputTracc" onkeypress="inviaCodice(this,event);" type="text" name="CodLotto" id="CodLotto" size="40" /></td>
              </tr>
              <tr>
                <td class="cella22"><?php echo $filtroContenitore ?></td>
                <td class="cella22"><?php echo $Contenitore; ?></td>
                <input type="hidden" name="Contenitore" id="Contenitore" value="<?php echo $Contenitore; ?>"/>
              </tr>
              <tr>
                <td class="cella22"><?php echo $filtroDtMiscela ?></td>
                <td class="cella22"><?php echo $DataMiscela; ?></td>
                <input type="hidden" name="DataMiscela" id="DataMiscela" value="<?php echo $DataMiscela; ?>"/>
                <input type="hidden" name="IdMiscela" id="IdMiscela" value="<?php echo $IdMiscela; ?>"/>
              </tr>
              <tr>
                <td class="cella22"><?php echo $filtroMiscela ?></td>
                <td class="cella22"><?php echo $CodFormulaDescri; ?></td>
                <input type="hidden" name="CodFormulaDescri" id="CodFormulaDescri" value="<?php echo $CodFormulaDescri; ?>"/>
              </tr>
              <tr>
                <td class="cella22"><?php echo $filtroLottiDaInser ?></td>
                <td  class="cella22"><?php echo $_SESSION['NumLottiTot'] - $_SESSION['NumLottiSalvati']; ?></td>
                <input type="hidden" name="NumLotti" id="NumLotti" size="40" value="<?php echo $_SESSION['NumLottiTot'] - $_SESSION['NumLottiSalvati']; ?>"/>
              </tr>
              <?php if ($_SESSION['NumLottiSalvati'] > 0) { ?>
                <tr> 
                  <td class="cella22" colspan="2"><?php echo $filtroLottiSalvati ?></td>
                </tr>
                <?php for ($i = 0; $i < $_SESSION['NumLottiSalvati']; $i++) { ?>
                  <tr><td  class="cella22" colspan="2"><?php echo $_SESSION['CodiciLotto'][$i] ?></td></tr>
                  <?php
                }
              }
              ?>
            </table>
          </form>
        </div>     

        <?php
        echo "</br> NumLottiTot : " . $_SESSION['NumLottiTot'];
        echo "</br> NumLottiSalvati : " . $_SESSION['NumLottiSalvati'];       
        echo "</br> CodiceChimica : " .$_SESSION['CodiceChimica'];
        echo "</br> CodiciLotto : " . print_r($_SESSION['CodiciLotto']);
       
        
//##############################################################################     
//################ CONTROLLO CODICE LOTTO ######################################
//##############################################################################
        
      } else if ((isset($_POST['CodLotto']) AND $_POST['CodLotto'] != "")) {
        
        include('../Connessioni/serverdb.php'); 
        include('../sql/script_lotto.php');
        include('../sql/script_chimica.php');
        

        $CodLotto = str_replace("'", "''", $_POST['CodLotto']);
        $PrefissoCodLotto = substr($CodLotto, 1, 5);

//CONTROLLO ESISTENZA COD_LOTTO NELLA TABELLA LOTTO DI SERVERDB
        $sqlCodLotto = findLottoByCodLotto($CodLotto);

        if (mysql_num_rows($sqlCodLotto) > 0) {
          $erroreCodLotto = true;
          $messaggioLotto = $messaggioLotto . ' '.$msgErrCodLottoInServerdb.'<br />';
        }
//CONTROLLO ESISTENZA COD_LOTTO NELLA TABELLA CHIMICA DI SERVERDB
        $sqlTabChimica = findKitChimiciByCodLotto($CodLotto);


        if (mysql_num_rows($sqlTabChimica) > 0) {
          $erroreCodLotto = true;
          $messaggioLotto = $messaggioLotto . ' ' .$msgErrCodLottoInChimServerdb.' <br />';
        }
//CONTROLLO CORRISPONDENZA COD LOTTO - COD PRODOTTO
        if ($PrefissoCodLotto != $CodProdotto) {

          $erroreCodLotto = true;
          $messaggioLotto = $messaggioLotto . ' '. $msgErrCodLottoDiversoCodProd.'<br />
                                      -- '.$filtroCodProdotto.' : ' . $CodProdotto . '<br />
                                      -- '.$filtroPrefCodLotto.' : ' . $PrefissoCodLotto . '<br />';
        }
//CONTROLLO PRIMO CARATTERE
        if (substr($CodLotto, 0, 1)!="L") {

          $erroreCodLotto = true;
          $messaggioLotto = $messaggioLotto . ' ' .$msgErrCodLottoPrimaLettera.'<br />';
        } 

//CONTROLLO LUNGHEZZA CODICE
        if (strlen ($CodLotto)>30){

          $erroreCodLotto = true;
          $messaggioLotto = $messaggioLotto .' '.$msgErrLunghCodiceLotto.'<br />';
        }
        
        if ($erroreCodLotto) {

          echo $messaggioLotto . '<a href="tracciabilita_sfusa_carica_lotto.php">'.$msgRicontrollaDati.'</a>';
        } else {
          
          $_SESSION['CodLotto']=$CodLotto;
          
          //SALVO IL CODICE LOTTO NELL'ARRAY DI SESSIONE
          $_SESSION['CodiciLotto'][$_SESSION['NumLottiSalvati']] = $CodLotto;
          
          ?>
      
          <script type="text/javascript">         
            location.href="tracciabilita_sfusa_carica_lotto1.php"
          </script>
      
          <?php
          
          echo "</br> NumLottiTot : " . $_SESSION['NumLottiTot']."</br>";
          echo "</br> NumLottiSalvati : " . $_SESSION['NumLottiSalvati']."</br>";
 
          
          echo "</br> CodiceChimica : " . $_SESSION['CodiceChimica']."</br>";
          echo "</br> CodiciLotto : " . print_r($_SESSION['CodiciLotto'])."</br>";
        }
      }
      ?>

    </div><!--mainConatainer-->
  </body>
</html>

