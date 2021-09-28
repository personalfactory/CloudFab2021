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
      include('../Connessioni/serverdb.php');
      include('../sql/script_messaggio_macchina.php');
      
      $IdMessaggio = $_GET['Messaggio'];

//visualizzo il record che intendo modificare all'interno della form
	/*
      $sql = mysql_query("SELECT * FROM messaggio_macchina WHERE id_messaggio=" . $IdMessaggio)
              or die("ERRORE SELECT FROM messaggio_macchina : " . mysql_error());
              */
      $sql = findMessaggioByID($IdMessaggio);
      while ($row = mysql_fetch_array($sql)) {
        $MessaggioMacchina = $row['messaggio'];
        $Abilitato = $row['abilitato'];
        $Data = $row['dt_abilitato'];
      }
      mysql_close();
      ?>
      <div id="container" style="width:700px; margin:15px auto;">
        <form id="ModificaMessaggio" name="ModificaMessaggio" method="post" action="modifica_messaggio2.php">
          <table style="width:700px;">
           
            <th class="cella3" colspan="2"><?php echo $titoloPaginaModificaMessaggio ?></th>
            <input type="hidden" name="MessaggioOld" id="MessaggioOld" value="<?php echo $MessaggioMacchina; ?>"/>
            <tr>
              <td class="cella2"><?php echo $filtroId ?> </td>
              <td class="cella1"><input type="hidden" name="IdMessaggio" id="IdMessaggio" value="<?php echo $IdMessaggio; ?>"><?php echo $IdMessaggio; ?></input></td>
            </tr>
            <tr>
              <td class="cella2"><?php echo $filtroMessaggio ?> </td>
              <td class="cella1"><textarea name="MessaggioMacchina" id="MessaggioMacchina" ROWS="3" COLS="45" value="<?php echo $MessaggioMacchina; ?>"><?php echo $MessaggioMacchina; ?></textarea></td>
            </tr>
            <tr>
              <td class="cella2"><?php echo $filtroAbilitato ?></td>
              <td class="cella1"><?php echo $Abilitato; ?></td>
            </tr>
            <tr>
              <td class="cella2"><?php echo $filtroDtAbilitato ?></td>
              <td class="cella1"><?php echo $Data; ?></td>
            </tr>
           <?php include('../include/tr_reset_submit.php'); ?>
          </table>
        </form>
      </div>

    </div><!--mainContainer-->

  </body>
</html>
