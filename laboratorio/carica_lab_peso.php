<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <?php include('../include/validator.php'); ?>
  <head>
    <?php include('../include/header.php');
    ?>
  </head>
  <script language="javascript">
    function RegistraPeso() {
      document.forms["PesaMateriePrime"].action = "carica_lab_peso2.php";
      document.forms["PesaMateriePrime"].submit();
    }
    function Aggiorna() {
      document.forms["PesaMateriePrime"].action = "carica_lab_peso.php";
      document.forms["PesaMateriePrime"].submit();
    }
    
    </script>
  <!-- posiziona il cursore nell'input text -->
  <body onload="document.getElementById('CodiceMatReale').focus()" onBlur="self.focus();">

    
    <?php
    include('../include/precisione.php');
    include('../Connessioni/serverdb.php');
//#################################################################
//############### LETTURA CODICE MATERIA PRIMA ####################
//#################################################################
//Se non e' ancora stato letto il codice della scatola di materia prima compare 
//il form di inserimento vuoto
//Vengono memorizzati nelle rispettive variabili i dati relativi alla pesa 
//da effettuare che sono arrivati tramite GET
//Vengono inoltre mandati tramite POST all'aggiornamento della pagina stessa
    if (!isset($_POST['CodiceMatReale'])) {

      list($Descri, $Codice, $QtaTeo, $tipoDaPesare) = explode(';', $_GET['DatiPesa']);
      if ($tipoDaPesare == $valMateriaPrima) {
        ?>

        <h1><img src="/CloudFab/images/pittogrammi/bilancia_media_R.png" class="icone2"/><?php echo " " . $Descri; ?></h1>
        <div id="container" style="width:90%; margin:15px ;">
          <form id="PesaMateriePrime" name="PesaMateriePrime" method="post" >
            
            <table style="width:100%;">
              <tr>
                <td class="cella3" colspan="2"><?php echo $msgLabLeggereCod ?></td>
              </tr>
              <tr>
                <td class="cella2"><?php echo $filtroLabCodice ?></td>
                <td class="cella1"><input type="text" name="CodiceMatReale" id="CodiceMatReale" /></td>
              </tr>
              <tr>
                <td class="cella2"><?php echo $filtroLabQta ?></td>
                <td class="cella1"><?php echo $QtaTeo . " " . $filtrogBreve; ?></td>
              </tr>
              <!--mando i campi utili all'aggiornameto della pagina  -->
              <input type="hidden" name="Descri" id="Descri" value="<?php echo $Descri; ?>"/>
              <input type="hidden" name="Codice" id="Codice" value="<?php echo $Codice; ?>"/>
              <input type="hidden" name="QtaTeo" id="QtaTeo" value="<?php echo $QtaTeo; ?>"/>
              <tr class="cella2" style="text-align: right;">
                <td colspan="2"><input type="button" onClick="javascript:Aggiorna();" value="<?php echo $valueButtonConferma ?>"/></td>
              </tr>  
            </table>  
          </form>
        </div>
        <?php
      }//End if not acqua	
      //#################################################################
      //################### PESA DEI PARAMETRI ##########################
      //#################################################################
      if ($tipoDaPesare == $valParametro) {
        //Se si deve effettuare la pesa 
        //1)Bisogna scegliere la bilancia da cui leggere il peso 
        //in base alla qta teorica e stampare un messaggio che informa 
        //l'utente sulla bilancia da usare
        ?>
        <div id="container" style="width:80%px; margin:15px;">
          <img src="/CloudFab/images/pittogrammi/bilancia_piccola_G.png" class="icone2" title="<?php echo $titleLabCliccaPesa ?>"/><?php echo $filtroBilancia1 ?>
          <img src="/CloudFab/images/pittogrammi/bilancia_media_G.png" class="icone2" title="<?php echo $titleLabCliccaPesa ?>"/><?php echo $filtroBilancia2 ?>
          <img src="/CloudFab/images/pittogrammi/bilancia_grande_G.png" class="icone2" title="<?php echo $titleLabCliccaPesa ?>"/><?php echo $filtroBilancia3 ?><br/>
        </div>
        <div id="container" style="width:80%; margin:15px;">

          <?php
          //Scelta della bilancia
          if ($QtaTeo > 0 && $QtaTeo <= 10) {
            $Bilancia = 1;
            echo '<div id="msg">' . $msgLabUtilizzaBilancia1 . '</div>';
          }
          if ($QtaTeo >= 11 && $QtaTeo <= 1000) {
            $Bilancia = 2;
            echo '<div id="msg">' . $msgLabUtilizzaBilancia2 . '</div>';
          }
          if ($QtaTeo > 1000) {
            $Bilancia = 3;
            echo '<div id="msg">' . $msgLabUtilizzaBilancia3 . '</div>';
          }
          ?>
          <div id="msg"><?php echo $filtroLabPesare . " " . $QtaTeo . " " . $filtroLabgDi . " " . $CodiceMatReale; ?></div><br/>
          <form id="PesaMateriePrime" name="PesaMateriePrime" method="post" >
            <input type="hidden" name="Descri" id="Descri" value="<?php echo $Descri; ?>"/>
            <input type="hidden" name="Codice" id="Codice" value="<?php echo $Codice; ?>"/>
            <input type="hidden" name="QtaTeo" id="QtaTeo" value="<?php echo $QtaTeo; ?>"/>
            <input type="button" onClick="javascript:RegistraPeso();
    //                          window.close();window.opener.location.reload();" 
                   value="<?php echo $valueButtonRegistraPeso ?>" />
          </form>

          <?php
        }//End if ACQUA
      }//End if not CodiceMatReale
//##################################################################
      //AGGIORNAMENTO//////////////////////////////////////////
      //Se e' stato letto il codice della materia prima 
      //1)bisogna verificare che questo coincida con il codice teorico 
      //2)bisogna scegliere la bilancia da cui leggere il peso in base 
      //alla qta teorica della materia prima e stampare un messaggio
      // che informa l'utente sulla bilancia da usare

      if (isset($_POST['CodiceMatReale'])) {


        $CodiceMatReale = str_replace("'", "''", $_POST['CodiceMatReale']);

        $CodiceFormula = str_replace("'", "''", $_POST['Formula']);
        $Descri = str_replace("'", "''", $_POST['Descri']);
        $Codice = str_replace("'", "''", $_POST['Codice']);
        $QtaTeo = str_replace("'", "''", $_POST['QtaTeo']);

        if ($CodiceMatReale == $Codice) {
          ?>

          <div id="container" style="width:80%; margin:15px ;">
            <table width="80%">
              <tr>
                <td><?php echo $filtroBilancia1 ?></td>
                <td><?php echo $filtroBilancia2 ?></td>
                <td><?php echo $filtroBilancia3 ?></td>
              </tr> 
              <tr>
                <td><img src="/CloudFab/images/pittogrammi/bilancia_piccola_G.png" class="icone2" title="<?php echo $titleLabCliccaPesa ?>"/></td>
                <td><img src="/CloudFab/images/pittogrammi/bilancia_media_G.png" class="icone2" title="<?php echo $titleLabCliccaPesa ?>"/></td>
                <td><img src="/CloudFab/images/pittogrammi/bilancia_grande_G.png" class="icone2" title="<?php echo $titleLabCliccaPesa ?>"/></td>
              </tr>
            </table>
          </div>
          <div id="container" style="width:80%; margin:15px ;">
            <?php
//                            echo '<h1>'.$CodiceMatReale.' '.$Descri.'</h1>';
            //Scelta della bilancia
            if ($QtaTeo > 0 && $QtaTeo <= 10) {
              $Bilancia = 1;
              echo '<div id="msg">' . $msgLabUtilizzaBilancia1 . '</div>';
            }
            if ($QtaTeo >= 11 && $QtaTeo <= 1000) {
              $Bilancia = 2;
              echo '<div id="msg">' . $msgLabUtilizzaBilancia2 . '</div>';
            }
            if ($QtaTeo > 1000) {
              $Bilancia = 3;
              echo '<div id="msg">' . $msgLabUtilizzaBilancia3 . '</div>';
            }
            ?>

            <div id="msg"><?php echo $filtroLabPesare . " " . $QtaTeo . " " . $filtroLabgDi . " " . $CodiceMatReale; ?></div><br/>
            <form id="PesaMateriePrime" name="PesaMateriePrime" method="post" >
              <input type="hidden" name="Descri" id="Descri" value="<?php echo $Descri; ?>"/>
              <input type="hidden" name="Codice" id="Codice" value="<?php echo $Codice; ?>"/>
              <input type="hidden" name="QtaTeo" id="QtaTeo" value="<?php echo $QtaTeo; ?>"/>
              <input style="text-align:right" type="button" 
                     onclick="javascript:RegistraPeso();" 
                     value="<?php echo $valueButtonRegistraPeso ?>" />
            </form>
          </div>
          <?php
        }// End if codici uguali

        if ($CodiceMatReale != $Codice) {
          echo '<h1>' . $Descri . '</h1>';
          echo '<div id="container">' . $filtroLabCodInserito . ': ' . $CodiceMatReale . '<br/>' . $filtroLabCodTeo . ': ' . $Codice . '</div>';
          echo '<div id="msg">' . $mgsErrCodiceErrato . '</div>';
          ?>

          <table>
            <tr>
              <td><input type="reset"  onClick="window.close()" value="<?php echo $valueButtonRiprova ?>"/></td>
            </tr>  
          </table> 
        </div>
        <?php
      }//End if codici diversi 
    }//End Aggiornamento
    ?>

  </body>
</html> 
