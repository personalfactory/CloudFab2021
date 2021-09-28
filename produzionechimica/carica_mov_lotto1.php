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
            document.forms["ScaricaCodLotto"].action = "carica_mov_lotto1.php";
            document.forms["ScaricaCodLotto"].submit();
            return false;
          }
          else
          {
            return true;
          }
        }
        
      </script>

      <?php 
      if ($DEBUG) ini_set("display_errors", "1");
      
      include('../include/menu.php'); 
      
      
      $erroreCodLotto = false;
      $messaggioLotto = "";


      if (!isset($_POST['CodLotto']) OR $_POST['CodLotto'] == "") {
                    
            
//##############################################################################     
//############### LETTURA CODICE LOTTO #########################################
//##############################################################################

        ?>
 
        <div id="tracciabilitaContainer" style=" width:900px; margin:50px auto;">

          <form class="form" id="ScaricaCodLotto" name="ScaricaCodLotto" method="post" >
            <table width="100%">
              <tr>
                <td class="cella22" colspan="2"><?php echo $filtroInserireCodScaricare?></td>
              </tr>
              <tr>
                <td class="cella111"><?php echo $filtroCodLotto ?> </td>
                <td  class="cella111"><input class="inputTracc" onkeypress="inviaCodice(this,event);" type="text" name="CodLotto" id="CodLotto" size="40" />&nbsp;<input type="submit" onkeypress="inviaCodice(this,event);"  value="SCARICA" /></td>
              </tr>
             <tr>
                <td class="cella111"><?php echo $filtroLottiDaInser ?></td>
                <td  class="cella111"><?php echo ($_SESSION['NumLottiTot'] - $_SESSION['NumLottiSalvati'])." ". $filtroPz ?></td>
                <input type="hidden" name="NumLotti" id="NumLotti" size="40" value="<?php echo $_SESSION['NumLottiTot'] - $_SESSION['NumLottiSalvati']; ?>"/>
              </tr>
              <?php 
              if ($_SESSION['NumLottiSalvati'] > 0) { ?>
                <tr> 
                  <td class="cella111" colspan="2"><?php echo $filtroLottiScaricati ?></td>
                </tr>
                <?php for ($i = 0; $i < $_SESSION['NumLottiSalvati']; $i++) { ?>
                  <tr>
                      <td class="cella111" ><?php echo $_SESSION['Prodotto'] ?></td>
                      <td  class="cella111" colspan="2"><?php echo $_SESSION['CodiciLotto'][$i] ?></td>
                  </tr>
                  <?php
                }
              }
              ?>
                
            </table>
          </form>
        </div>     

        <?php
//        echo "</br> NumLottiTot : " . $_SESSION['NumLottiTot'];
//        echo "</br> NumLottiSalvati : " . $_SESSION['NumLottiSalvati'];
//
//        echo "</br> #####################################################</br>";
//        echo "</br> CodiciLotto : " . print_r($_SESSION['CodiciLotto']);
        
//##############################################################################     
//################ CONTROLLO CODICE LOTTO ######################################
//##############################################################################
        
      } else if ((isset($_POST['CodLotto']) AND $_POST['CodLotto'] != "")) {
        
        include('../Connessioni/serverdb.php'); 
        include('../sql/script_lotto.php');
        include('../sql/script_chimica.php');
        include('../sql/script_prodotto.php');
        include('../include/precisione.php');
        
        $CodLotto = str_replace("'", "''", $_POST['CodLotto']);
        $PrefissoCodLotto = substr($CodLotto, 1, 5);

       
        $sqlProd= findProdottoByCodice($PrefissoCodLotto);
        while ($rowProd = mysql_fetch_array($sqlProd)) {
            $_SESSION['Prodotto']=$rowProd['nome_prodotto'];
        }
        
        //CONTROLLO ESISTENZA COD_LOTTO DISPONIBILE NELLA TABELLA LOTTO DI SERVERDB
        $sqlCodLotto = findLottoByStato($CodLotto,$valStatoLottoDisponibile);
         while ($rowDes = mysql_fetch_array($sqlCodLotto)) {
            $_SESSION['DescriLotto']=$rowDes['descri_lotto'];
        }
        
        if (mysql_num_rows($sqlCodLotto) == 0) {
          $erroreCodLotto = true;
          $messaggioLotto = $messaggioLotto . ' - '.$msgErrTracc7.'<br />';
       }
        
        //CONTROLLO ESISTENZA COD_LOTTO NELLA TABELLA CHIMICA DI SERVERDB
        $sqlTabChimica = findKitChimiciByCodLotto($CodLotto);

        if (mysql_num_rows($sqlTabChimica) == 0) {
          $erroreCodLotto = true;
          $messaggioLotto = $messaggioLotto . ' - '.$msgErrTracc8.'<br />';
        }
        
        
        //CONTROLLO PRIMO CARATTERE
        if (substr($CodLotto, 0, 1)!="L") {

          $erroreCodLotto = true;
          $messaggioLotto = $messaggioLotto . ' - '.$msgErrTracc4.'<br />';
        }
        //CONTROLLO LUNGHEZZA CODICE
	if (strlen($CodLotto)>30 OR strlen($CodLotto)<17) {
	    $erroreCodLotto = true;
            $messaggioLotto = $messaggioLotto . ' - '.$msgErrTracc5.': '.strlen ($CodLotto).'<br />';
        }
        
        for ($i = 0; $i < $_SESSION['NumLottiSalvati']; $i++) { 
             if( $CodLotto==$_SESSION['CodiciLotto'][$i]) 
                  $erroreCodLotto = true;
            $messaggioLotto = $messaggioLotto . ' - '.$msgErrTracc9.': '.$CodLotto.'<br />';
                }
 //##############################################################################       
                
        if ($erroreCodLotto) {
          echo $messaggioLotto . '<a href="carica_mov_lotto1.php">'.$msgRicontrollaDati.'</a>';
        } else {

          //SALVO IL CODICE LOTTO NELL'ARRAY DI SESSIONE
          $_SESSION['CodiciLotto'][$_SESSION['NumLottiSalvati']] = $CodLotto;
          ?>
          <script type="text/javascript">         
                location.href="carica_mov_lotto2.php"
          </script>
          <?php
          
//        echo "</br> NumLottiTot : " . $_SESSION['NumLottiTot'];
//        echo "</br> NumLottiSalvati : " . $_SESSION['NumLottiSalvati'];
//
//        echo "</br> #####################################################</br>";
//        echo "</br> CodiciLotto : " . print_r($_SESSION['CodiciLotto']);
        }
      }
      ?>

    </div><!--mainContainer-->
  </body>
</html>

