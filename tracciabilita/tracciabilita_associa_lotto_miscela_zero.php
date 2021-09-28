<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <?php include('../include/validator.php'); ?>
  <head>
    <?php include('../include/header.php'); ?>
  </head>
  <body onload="document.getElementById('CodLotto').focus()">
    
    <div id="tracciabilitaContainer">

      <script language="javascript">
        function Verifica(){
          document.forms["AssociaCodLottoCodChimica"].action = "tracciabilita_associa_lotto_miscela_zero.php";
          document.forms["AssociaCodLottoCodChimica"].submit();
        }
                        
      </script>

      <?php 
          include('../include/menu.php'); 
	  include('../Connessioni/serverdb.php');
          include('../sql/script_formula.php');
	  $errore = false;
	  ?>
      <!--########################################################################### -->     
      <!--####################### SCELTA FORMULA ################################### -->
      <!--########################################################################### -->
      <?php
      if (!isset($_POST['Formula']) || $_POST['Formula'] == "") {
        //Inizializzo le due variabili di sessione relative al numero di lotti corrente ed al num di codchimica corrente

        $_SESSION['NumLottiTot'] = 0;
        $_SESSION['NumLottiSalvati'] = 0;

        $_SESSION['NumCodiciChimicaTot'] = 0;
        $_SESSION['NumCodiciChimicaInseriti'] = 0;

        $_SESSION['CodiciChimica'] = array();
        $_SESSION['CodiciLotto'] = array();
        ?>        
        <div id="tracciabilitaContainer" style=" width:800px; margin:15px auto;">

          <form class="form" id="AssociaCodLottoCodChimica" name="AssociaCodLottoCodChimica" method="post" >
            <table width="100%">
              <tr>
                <td class="cella33" colspan="2"><?php echo $titoloPaginaAssLottoKit ?></td>
              </tr>
              <tr>
                <td class="cella22"><?php echo $filtroNumLotti ?></td>
                <td class="cella111"><input type="text" name="NumLottiTot" id="NumLottiTot" /></td>
              </tr>
              <tr>
                <td class="cella22"><?php echo $filtroNumKitPerLotto ?></td>
                <td class="cella111"><input type="text" name="NumCodiciChimicaTot" id="NumCodiciChimicaTot" /></td>
              </tr>
              <tr>
                <td class="cella22"><?php echo $filtroProdotto ?></td>
                <td class="cella111">
                  <select class="inputTracc" name="Formula" id="Formula" onchange="Verifica()">
                    <option value="0" selected="" ><?php echo $labelOptionSelectProdotto?></option>
                    <?php
                    //Viene data la possibilità di scelta tra i prodotti esistenti
                    $sqlFormula = findAllFormule("cod_formula");

                    while ($rowFormula = mysql_fetch_array($sqlFormula)) {
                      ?>
                      <option value="<?php echo($rowFormula['cod_formula'] . ":" . $rowFormula['descri_formula']) ?>" size="40"><?php echo($rowFormula['cod_formula'] . " : " . $rowFormula['descri_formula']) ?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              
            </table>
          </form>
        </div>

        <?php
      } else if (isset($_POST['Formula']) AND $_POST['Formula'] != "") {

        
        if (!isset($_POST['NumLottiTot']) || trim($_POST['NumLottiTot']) == "") {

          $errore = true;
          $messaggio = $messaggio .' '.$filtroNumLotti.' ' .$msgErrQtaNumerica.' <br />';
        }
        if (!isset($_POST['NumCodiciChimicaTot']) || trim($_POST['NumCodiciChimicaTot']) == "") {

          $errore = true;
          $messaggio = $messaggio . ' '.$filtroNumKitPerLotto.' ' .$msgErrQtaNumerica.' <br />';
        }
        //Verifica tipo di dati
        if (!is_numeric($_POST['NumCodiciChimicaTot'])) {

          $errore = true;
          $messaggio = $messaggio .' '.$filtroNumLotti.' ' .$msgErrQtaNumerica.' <br />';
        }
        if (!is_numeric($_POST['NumLottiTot'])) {

          $errore = true;
          $messaggio = $messaggio . ' '.$filtroNumKitPerLotto.' ' .$msgErrQtaNumerica.' <br />';
        }

        if ($errore) {

          echo $messaggio. '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';;
        } else {

          list($CodFormula, $DescriFormula) = explode(":", $_POST['Formula']);
                         
          $_SESSION['NumCodiciChimicaTot'] = $_POST['NumCodiciChimicaTot'];
          $_SESSION['NumLottiTot'] = $_POST['NumLottiTot'];
          $_SESSION['CodFormula'] = $_POST['Formula'];
          $_SESSION['DescriFormula'] = $DescriFormula;
          $_SESSION['CodFormulaDescri'] = $_POST['Formula'];
          
          
          $_SESSION['Contenitore'] = 0;
          $_SESSION['IdMiscela'] = 0;
          $_SESSION['DataMiscela'] = 0;
          ?>

          <script type="text/javascript">
            location.href="tracciabilita_associa_lotto_chimica.php"
          </script>

    <?php
  }
}
?>
    </div><!--mainContainer-->
  </body>
</html>

