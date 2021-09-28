<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <?php include('../include/validator.php'); ?>
  <head>
    <?php include('../include/header.php'); ?>
  </head>

  <?php
  include('../Connessioni/serverdb.php');
   include('../sql/script_chimica.php');
  
  $erroreCodChimica = false;
  $messaggioChimica = "";
  $CodiceChimica="";
//##############################################################################     
//################ VARIABILI DI SESSIONE #######################################
//##############################################################################

  $Contenitore = $_SESSION['Contenitore'];
  $DataMiscela = $_SESSION['DataMiscela'];
  $IdMiscela = $_SESSION['IdMiscela'];
  $CodFormula = $_SESSION['CodFormula'];
  $DescriFormula = $_SESSION['DescriFormula'];
  $CodFormulaDescri = $_SESSION['CodFormulaDescri'];
  $CodProdotto = substr($CodFormula, 1, 5);

//##############################################################################     
//################ CONTROLLO CODICI CHIMICA ####################################
//##############################################################################

  if (isset($_POST['CodiceChimica']) AND $_POST['CodiceChimica'] != "") {

    $CodiceChimica = str_replace("'", "''", $_POST['CodiceChimica']);
	
//##############################################################################   
//######### CONTROLLO CORRISPONDENZA CODICE CHIMICA E COD PRODOTTO #############
//##############################################################################
    $PrefissoCodChimica = substr($CodiceChimica, 1, 5);

    if ($PrefissoCodChimica != $CodProdotto AND $CodiceChimica != "") {
      $erroreCodChimica = true;
      $messaggioChimica = $messaggioChimica . ' '.$msgErrCodKitDiversoCodProd.'<br />
                                      -- '.$filtroCodProdotto .': '.  $CodProdotto . '<br />
                                      -- '.$filtroPrefCodKit .': '.  $PrefissoCodChimica . '<br />';
    }
//CONTROLLO PRIMO CARATTERE
//Il primo carattere di un codice chimica sfuso corrisponde con il primo caattere del codice lotto
        if (substr($CodiceChimica, 0, 1)!="L") {

          $erroreCodChimica = true;
          $messaggioChimica = $messaggioChimica . ' '.$msgErrCodChimSfusaInizio.'<br />';
        }

//##############################################################################   
//######### CONTROLLO COMPOSIZIONE CODICE CHIMICA SFUSA ########################
//##############################################################################
    //Controllo che la seconda parte del codice contenga il numero di sacchetti corretto
    // e che la terza parte contenga la qta totale dell'intero lotto.
    list($CodLotto, $NumSacchetti, $Qta) = explode(".", $CodiceChimica);
//  echo $CodLotto."</br>";
//  echo $NumSacchetti."</br>";
//  echo $Qta."</br>";
//  if($NumSacchetti!=$_SESSION['NumSacchetti']){
//    
//    $erroreCodChimica = true;
//    $messaggioChimica = $messaggioChimica . ' - Numero di sacchetti presente sul codice errato!<br />';
//    
//  }
//  if( $Qta!=($_SESSION['PesoRealeMiscela']/$_SESSION['NumLottiTot'])){
//    
//    $erroreCodChimica = true;
//    $messaggioChimica = $messaggioChimica . ' - Quantita di chimica sfusa presente sul codice errata!<br />';
//    
//  }
//##############################################################################   
//######### VERIFICA ESISTENZA CODICE NELLA TABELLA CHIMICA DI SERVERDB ########
//##############################################################################

    $sqlCodChimica = findChimicaByCodice($_POST['CodiceChimica']);
    
//    $sqlCodChimica = mysql_query("SELECT cod_chimica 
//                                          FROM 
//                                            serverdb.chimica 
//                                         WHERE 
//                                          cod_chimica='" . $_POST['CodiceChimica'] . "'")
//            or die("Errore 4: " . mysql_error());
    if (mysql_num_rows($sqlCodChimica) > 0) {
      $erroreCodChimica = true;
      $messaggioChimica = $messaggioChimica . ' ' .$msgErrCodKitInServerdb.'<br />';
    }
  }
  
  if (!$erroreCodChimica) {
        //SALVO IL CODICE CHIMICA NELL'ARRAY DI SESSIONE
        $_SESSION['CodiceChimica'] = $CodiceChimica;
  }
  ?>
   
  <body onLoad="focusBox();">

    
    <div id="tracciabilitaContainer">
      <?php include('../include/menu.php'); ?>

      <script language="javascript">
        
        function verificaCodice(campo,evento)
        {
          codice_tasto = evento.keyCode ? evento.keyCode : evento.which ? evento.which : evento.charCode;
          if (codice_tasto == 13)
          {
            document.forms["AssociaCodLottoCodChimica"].action = "tracciabilita_sfusa_carica_lotto1.php";
            document.AssociaCodLottoCodChimica.submit();
            return false;
          }
          else
          {
            return true;
          }
        }
        function focusBox()
        {
          var box = document.getElementById('CodiceChimica');
          box.focus();
        }

      </script>

      <?php if ($erroreCodChimica == true) {
        echo "<div id=msg>".$msgErrBreveCodKit."</br>" . $messaggioChimica. " ".$msgRicontrollaDati."</div>";
     
        } ?> 
      
      <div id="tracciabilitaContainer" style=" width:700px; margin:15px auto;">

        <form class="form" id="AssociaCodLottoCodChimica" name="AssociaCodLottoCodChimica" method="post" >
          <table width="700px">
            <tr>
              <td class="cella33" colspan="2"><?php echo $titoloPaginaInsChimSfusa ?></td>
            </tr>
            <tr>
              <td class="cella22"><?php echo $filtroCodKit ?></td>
              <td class="cella111"><input class="inputTracc" onkeypress="verificaCodice(this,event);" type="text" name="CodiceChimica" id="CodiceChimica" size="40" value="<?php echo $_SESSION['CodiceChimica']; ?>"/></td>
            </tr>
            <tr>
              <td class="cella22"><?php echo $filtroCodLotto ?></td>
              <td  class="cella22"><?php echo $_SESSION['CodiciLotto'][$_SESSION['NumLottiSalvati']]; ?></td>
              <input type="hidden" name="CodLotto" id="CodLotto" size="40" value="<?php echo $_SESSION['CodiciLotto'][$_SESSION['NumLottiSalvati']]; ?>"/>
            </tr>
            <tr>
              <td class="cella22"><?php echo $filtroLottiDaInser ?></td>
              <td  class="cella22"><?php echo $_SESSION['NumLottiTot'] - $_SESSION['NumLottiSalvati']; ?></td>
              <input type="hidden" name="NumLotti" id="NumLotti" size="40" value="<?php echo $_SESSION['NumLottiTot'] - $_SESSION['NumLottiSalvati']; ?>"/>
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
   
          </table>
        </form>
      </div>     
      <?php
            
        if( $_SESSION['CodiceChimica']!="") {?>
      
        <script type="text/javascript">
          location.href="tracciabilita_sfusa_carica_lotto2.php"
        </script>
      
          <?php 
      }
      

      echo "</br> NumLottiTot : " . $_SESSION['NumLottiTot'];
      echo "</br> NumLottiSalvati : " . $_SESSION['NumLottiSalvati'];

      echo "</br> NumCodiciChimicaTot : " . $_SESSION['NumCodiciChimicaTot'];
      echo "</br> NumCodiciChimicaInseriti : " . $_SESSION['NumCodiciChimicaInseriti'];


      echo "</br> CodiciChimica : " . print_r($_SESSION['CodiceChimica']);
      echo "</br> CodiciLotto : " . print_r($_SESSION['CodiciLotto']);
      ?>
    </div><!--mainConatainer-->
  </body>
</html>
