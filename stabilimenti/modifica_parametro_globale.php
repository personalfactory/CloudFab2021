<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <?php include('../include/validator.php'); ?>
  <head>
    <?php include('../include/header.php'); ?>
  </head>
  <body>
    

    <div id="mainContainer">

      <?php
      include('../include/menu.php'); include('../Connessioni/serverdb.php');
      include('../sql/script_parametro_glob_mac.php');
//Id di origine del parametro ke può essere modificato
      $IdParametroOld = $_GET['Parametro'];

//visualizzo il record che intendo modificare all'interno della form

 //     $sql = mysql_query("SELECT * FROM parametro_glob_mac WHERE id_par_gm=" . $IdParametroOld)
 //             or die("ERRORE SELECT FROM parametro_glob_mac : " . mysql_error());
      
      $sql = findParGlobMacById($IdParametroOld);
      
      while ($row = mysql_fetch_array($sql)) {
        $NomeVariabile = $row['nome_variabile'];
        $DescriVariabile = $row['descri_variabile'];
        $ValoreVariabile = $row['valore_variabile'];
        $Abilitato = $row['abilitato'];
        $Data = $row['dt_abilitato'];
      }
      mysql_close();
      ?>

      <div id="container" style="width:600px; margin:15px auto;">
        <form id="ModificaParametro" name="ModificaParametro" method="post" action="modifica_parametro_globale2.php">
          <table style="width:600px;">
            <tr>
              <td height="42" colspan="2" class="cella3"><?php echo $titoloPaginaModificaParGlobale ?></td>
            </tr>
            <tr>
              <td class="cella2"><?php echo $filtroId ?> </td>
              <td class="cella1"><input style="width:95%" type="text" name="IdParametro" id="IdParametro"  value="<?php echo $IdParametroOld; ?>"/></td>
              <input type="hidden" name="IdParametroOld" id="IdParametroOld" value="<?php echo $IdParametroOld; ?>"/>
            </tr>
            <tr>
              <td class="cella2"><?php echo $filtroPar ?> </td>
              <td class="cella1"><input style="width:95%" type="text" name="NomeVariabile" id="NomeVariabile" value="<?php echo $NomeVariabile; ?>" /></td>
            </tr>
            <tr>
              <td class="cella2"><?php echo $filtroDescrizione ?></td>
              <td class="cella1"><textarea style="width:95%" name="DescriVariabile" id="DescriVariabile" ROWS="3" COLS="45" value="<?php echo $DescriVariabile; ?>"><?php echo $DescriVariabile; ?></textarea></td>
            </tr>
            <tr>
              <td class="cella2"><?php echo $filtroValore ?></td>
              <td class="cella1"><textarea style="width:95%" name="ValoreVariabile" id="ValoreVariabile" ROWS="3" COLS="45" value="<?php echo $ValoreVariabile; ?>"><?php echo $ValoreVariabile; ?></textarea></td>
            </tr>
            <tr>
              <td class="cella2"><?php echo $filtroAbilitato ?></td>
              <td class="cella1"><?php echo $Abilitato; ?></td>
            </tr>
            <tr>
              <td class="cella2"><?php echo $filtroDt ?></td>
              <td class="cella1"><?php echo $Data; ?></td>
            </tr>
            <?php include('../include/tr_reset_submit.php'); ?>
          </table>
        </form>
      </div>

    </div><!--mainContainer-->

  </body>
</html>
