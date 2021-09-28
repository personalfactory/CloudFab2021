<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <?php include('../include/validator.php'); ?>
  <head>
    <?php include('../include/header.php'); ?>
  </head>
  <body onload="document.getElementById('NumDdt').focus()">
    
    <div id="tracciabilitaContainer">

      <script language="javascript">
        function ControllaDdt(){
          document.forms["Ddt"].action = "tracciabilita_bolla_lotto.php";
          document.forms["Ddt"].submit();
        }
        function VisualizzaData(){
          document.forms["Ddt"].action = "tracciabilita_bolla.php";
          document.forms["Ddt"].submit();
        }
      </script>
      <?php 
      include('../include/menu.php'); 
      include('../include/precisione.php');
      include('../Connessioni/serverdb.php');
      include('../sql/script.php');
      include('../sql/script_gaz_movmag.php');
      
      //########################################################################
      //############## INSERIMENTO NUMERO DDT ##################################
      //########################################################################

      if (!isset($_POST['NumDdt']) OR $_POST['NumDdt'] == "") {

        $_SESSION['NumCodiciLottoTot'] = 0;
        $_SESSION['NumCodiciLottoInseriti'] = 0;

        $_SESSION['CodLotto'] = array();
        $_SESSION['Bolla'] = array();

        echo "</br> NumCodiciLottoTot : " . $_SESSION['NumCodiciLottoTot'];
        echo "</br> NumCodiciLottoInseriti : " . $_SESSION['NumCodiciLottoInseriti'];
        echo "</br> CodiciLotto : " . print_r($_SESSION['CodLotto']);
        echo "</br> Bolla : " . print_r($_SESSION['Bolla']);
        ?>

        <div id="tracciabilitaContainer" style=" width:600px; margin:45px auto;">

          <form class="form" id="Ddt" name="Ddt" method="POST">
            <table width="600px">
              <tr>
                <td class="cella33" colspan="2"><?php echo $titoloPaginaAssDdt  ?></td>
              </tr>
              <tr>
                <td class="cella22"><?php echo $filtroNumDdt  ?> </td>
                <td  class="cella111">
                    <input class="inputTracc" type="text" name="NumDdt" id="NumDdt" onchange="VisualizzaData()"/></td>
              </tr>
            </table>
          </form>          
        </div>

        <?php
      } else {
        //######################################################################
        //############## SCELTA DATA DDT #######################################
        //######################################################################

        $NumDdt = str_replace("'", "''", $_POST['NumDdt']);
        ?>

        <div id="tracciabilitaContainer" style=" width:600px; margin:45px auto;">
          <form class="form" id="Ddt" name="Ddt" method="post" >
            
            <table width="600px">
              <tr>
                <td class="cella33" colspan="2"><?php echo $titoloPaginaAssDdt  ?></td>
              </tr>
              <tr>
                <td class="cella22"><?php echo $filtroNumDdt  ?></td>
                <td  class="cella22"><?php echo $NumDdt; ?></td>
                <input type="hidden" name="NumDdt" id="NumDdt" value="<?php echo $NumDdt; ?>" />
              </tr>
              <tr>
                <td class="cella22"><?php echo $filtroDtDdt  ?> </td>
                <td  class="cella111">
                    <select class="inputTracc" name="DataEmi" id="DataEmi" onchange="ControllaDdt()">
                    <option value="" selected=""><?php echo $labelOptionSelectDataDdt  ?></option>
                    <?php
                    //Viene data la possibilità di scelta tra le date dei ddt disponibili
                                      
                    $sqlDataEmi=selectDataDdtByNumDoc($NumDdt,$valCatMerLotti);

                    while ($rowDataEmi = mysql_fetch_array($sqlDataEmi)) {
                      ?>
                      <option value="<?php echo $rowDataEmi['dt_doc'] ?>" ><?php echo $rowDataEmi['dt_doc'] ?></option>
                    <?php } ?>
                  </select></td>
              </tr>
            </table>
            
          </form>
        </div>
      <?php } ?>
    </div><!--mainConatainer-->
  </body>
</html>