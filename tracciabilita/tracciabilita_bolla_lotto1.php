<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <?php include('../include/validator.php'); ?>
  <head>
    <?php include('../include/header.php'); 
    include('../include/precisione.php');
    include('../Connessioni/serverdb.php');
    include('../sql/script_gaz_movmag.php');
    include('../sql/script_chimica.php');
    include('../sql/script_lotto.php');
    ?>
  </head>

  <?php
  //####################################################################
  //#################### CONTROLLO CODICI LOTTO ########################
  //####################################################################
  $erroreCodLotto = false;
  $messaggioLotto = "";
  $ChimicaSfusa = false;

  $NumDdt = $_SESSION['Bolla'][0];
  $DataEmi = $_SESSION['Bolla'][1];
  $CodStab = $_SESSION['Bolla'][2];
  $IdMacchina = $_SESSION['Bolla'][3];
  $NumLottiGazie = $_SESSION['Bolla'][4];

  

  for ($i = 0; $i < $_SESSION['NumCodiciLottoTot']; $i++) {
    if (isset($_POST['CodiceLotto' . $i]) AND $_POST['CodiceLotto' . $i] != "") {

      $CodiceLotto = str_replace("'", "''", $_POST['CodiceLotto' . $i]);

//#########################################################################################
// VERIFICO CHE IL PREFISSO DEL CODICE LOTTO INSERITO SIA ASSOCIATO ALLA BOLLA SU GAZMOVMAG
//#########################################################################################


        $sqlListaLotti = verificaPrefissoCodLottoDdt($NumDdt,$DataEmi,substr($CodiceLotto, 0, 6),$valCatMerLotti);
//                mysql_query("SELECT artico FROM serverdb.gaz_movmag	
//                                        WHERE 
//					num_doc ='" . $NumDdt . "'
//                                         AND 
//                                          dt_doc='" . $DataEmi . "'
//                                        AND 
//                                           artico='" . substr($CodiceLotto, 0, 6) . "'
//                                        AND 
//                                            cat_mer='" . $valCatMerLotti . "'")
//              or die("ERRORE 1 : " . mysql_error());    
                if (mysql_num_rows($sqlListaLotti) == 0) {

        $erroreCodLotto = true;
        $messaggioLotto = $messaggioLotto . ' '.$msgErrCodLottoNotInDdt.' <br />';
      }
//##############################################################################
//##### VERIFICA INSERIMENTO CODICI DI DUE UGUALI ##############################
//##############################################################################      

      for ($j = 0; $j < $_SESSION['NumCodiciLottoInseriti']; $j++) {

        if ($CodiceLotto == $_SESSION['CodLotto'][$j] AND $i != $j) {
          $erroreCodLotto = true;
          $messaggioLotto = $messaggioLotto . ' '.$msgErrCodiciUguali.' <br />';
        }
      }

//##############################################################################
//##### VERIFICA COD_LOTTO RELATIVO A CHIMICA SFUSA ############################
//##############################################################################           
      $sqlChimicaSfusa = findChimicaByCodice($CodiceLotto);
//              mysql_query("SELECT cod_chimica FROM serverdb.chimica
//                                      WHERE
//                                        cod_chimica LIKE '" . $CodiceLotto . "%' ")
//              or die("ERRORE 2 SELECT FROM serverdb.chimica : " . mysql_error());

      if (mysql_num_rows($sqlChimicaSfusa) != 0) {
        //Se entro nell'if vuol dire che il lotto è associato ad un codice chimica sfusa 
        //che comincia con il codice lotto stesso
        $ChimicaSfusa = true;
      }


//##############################################################################
//##### VERIFICA ESISTENZA COD_LOTTO NELLA TABELLA LOTTO DI SERVERDB ###########
//##############################################################################      

      $sqlEsisteLotto = findLottoByCodLotto($CodiceLotto);
              
//              mysql_query("SELECT * FROM serverdb.lotto
//                                      WHERE
//                                        cod_lotto='" . $CodiceLotto . "' ")
//              or die("ERRORE 3 SELECT FROM serverdb.lotto : " . mysql_error());
	
      if (mysql_num_rows($sqlEsisteLotto) == 0) {
        //Se entro nell'if vuol dire che il lotto non esiste nella tabella lotto
        $erroreCodLotto = true;
        $messaggioLotto = $messaggioLotto . ' ' . $CodiceLotto . ' - '.$msgErrCodLottoNotInServerdb.'<br />';
      }




      if (!$erroreCodLotto) {
        //SALVO IL CODICE LOTTO NELL'ARRAY DI SESSIONE
        $_SESSION['CodLotto'][$i] = $CodiceLotto;
      }
    }
  }

  if ($erroreCodLotto == false AND $_SESSION['CodLotto'][$_SESSION['NumCodiciLottoInseriti']] != "") {

//    echo "aaaaa" . $_SESSION['CodLotto'][$_SESSION['NumCodiciLottoInseriti']];

    $_SESSION['NumCodiciLottoInseriti'] = $_SESSION['NumCodiciLottoInseriti'] + 1;
  }
  ?>

  <body  onLoad="focusBox();">
    
    <div id="tracciabilitaContainer">
      <?php include('../include/menu.php'); ?>

      <script language="javascript">
        //        function Salva(){
        //          document.forms["AssociaBollaLotto"].action = "tracciabilita_bolla_lotto2.php";
        //          document.forms["AssociaBollaLotto"].submit();
        //        }
        function focusBox()
        {
          var box = document.getElementById('CodiceLotto<?php echo $_SESSION["NumCodiciLottoInseriti"]; ?>');
          box.focus();
        }
        function verificaCodice(campo,evento)
        {
          codice_tasto = evento.keyCode ? evento.keyCode : evento.which ? evento.which : evento.charCode;
          if (codice_tasto == 13)
          {
            document.forms["AssociaBollaLotto"].action = "tracciabilita_bolla_lotto1.php";
            document.AssociaBollaLotto.submit();
            return false;
          }
          else
          {
            return true;
          }
        }
      </script>
<?php if ($erroreCodLotto) {

              echo "<div id=msg>".$msgErrBreveCodLotto."<br />" . $messaggioLotto . " </div>";
            }
?>

      <div id="tracciabilitaContainer" style=" width:600px; margin:15px auto;">

        <form class="form" id="AssociaBollaLotto" name="AssociaBollaLotto" method="post" >
          <table width="600px">
            <tr>
              <td class="cella33" colspan="2"><?php echo $titoloPaginaAssBollaLotti ?></td>
            </tr>
            <?php
            for ($i = 0; $i < $_SESSION['NumCodiciLottoTot']; $i++) {
              //VISUALIZZO I CODICI SALVATI NELL'ARRAY $_SESSION['CodLotto']
              if (isset($_POST['CodiceLotto' . $i]) AND $_POST['CodiceLotto' . $i] != "") {
                ?>
                <tr>
                  <td class="cella22"><?php echo $filtroCodLotto . " " .($i + 1); ?></td>
                  <td class="cella111"><input class="inputTracc" type="text" onkeypress="verificaCodice(this,event);" name="CodiceLotto<?php echo $i; ?>" id="CodiceLotto<?php echo $i; ?>"  value="<?php echo $_SESSION['CodLotto'][$i]; ?>"/></td>
                </tr>
              <?php } else { ?>
                <tr>
                  <td class="cella22"><?php echo $filtroCodLotto . " " .($i + 1); ?>  :</td>
                  <td class="cella111"><input class="inputTracc" type="text"  onkeypress="verificaCodice(this,event);" name="CodiceLotto<?php echo $i; ?>" id="CodiceLotto<?php echo $i; ?>"  /></td>
                </tr>	
                <?php
              }
            }
            ?>
            <tr>
              <td class="cella22"><?php echo $filtroNumDdt ?> </td>
              <td  class="cella22"><?php echo $NumDdt; ?></td>
              <input type="hidden" name="NumDdt" id="NumDdt"  value="<?php echo $NumDdt; ?>"/>
            </tr>
            <tr>
              <td class="cella22"><?php echo $filtroDtDdt ?></td>
              <td  class="cella22"><?php echo $DataEmi; ?></td>
              <input type="hidden" name="DataEmi" id="DataEmi"  value="<?php echo $DataEmi; ?>"/>
            </tr>
            <tr>
              <td class="cella22"><?php echo $filtroCodStab ?> </td>
              <td  class="cella22"><?php echo $CodStab; ?></td>
              <input type="hidden" name="CodStab" id="CodStab"  value="<?php echo $CodStab; ?>"/>
              <input type="hidden" name="IdMacchina" id="IdMacchina"  value="<?php echo $IdMacchina; ?>"/>
            </tr>
            <tr>
              <td class="cella22"><?php echo $filtroLottiDaInser ?></td>
              <td  class="cella22"><?php echo $NumLottiGazie; ?></td>
              <input type="hidden" name="NumLottiGazie" id="NumLottiGazie"  value="<?php echo $NumLottiGazie; ?>"/>
            </tr>

            <?php
            if ($_SESSION['NumCodiciLottoInseriti'] == $_SESSION['NumCodiciLottoTot']) {
				
              ?>
  
              <script type="text/javascript">
                location.href="tracciabilita_bolla_lotto2.php"
              </script>

            <?php 
            }

//            if ($erroreCodLotto) {
//
//              echo "<div id=msg>ERRORE CODICE LOTTO : <br />" . $messaggioLotto . " </div>";
//            }


         //   echo "</br> NumCodiciLottoTot : " . $_SESSION['NumCodiciLottoTot'];
           // echo "</br> NumCodiciLottoInseriti : " . $_SESSION['NumCodiciLottoInseriti'] . "</br>";

            //echo "</br> --CodiciLotto : " . print_r($_SESSION['CodLotto']) . "</br>";
            //echo "</br> --Bolla : " . print_r($_SESSION['Bolla']) . "</br>";
            ?>

          </table>
        </form>
      </div>


    </div><!--mainConatainer-->
  </body>
</html>


