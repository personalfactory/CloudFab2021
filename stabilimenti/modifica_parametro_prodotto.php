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
      include('../sql/script_parametro_prod.php');
//Id di origine del parametro ke può essere modificato
      $IdParametroOld = $_GET['Parametro'];

//Visualizzo il record che intendo modificare all'interno della form

//      $sql = mysql_query("SELECT * FROM parametro_prodotto WHERE id_par_prod=" . $IdParametroOld)
//              or die("ERRORE 1 SELECT FROM serverdb.parametro_prodotto: " . mysql_error());
      
      $sql = findParametroProdById($IdParametroOld);
      
      while ($row = mysql_fetch_array($sql)) {
        $NomeVariabile = $row['nome_variabile'];
        $DescriVariabile = $row['descri_variabile'];
        $ValoreBase = $row['valore_base'];
        $Abilitato = $row['abilitato'];
        $Data = $row['dt_abilitato'];
      }
      mysql_close();
      ?>
      <div id="container" style="width:600px; margin:15px auto;">
        <form id="ModificaParametro" name="ModificaParametro" method="post" action="modifica_parametro_prodotto2.php">
          <table style="width:600px;">
            <tr>
              <td height="42" colspan="2" class="cella3"><?php echo $titoloPaginaModParProdotto ?></td>
            </tr>
            <tr>
              <td class="cella2"><?php echo $filtroId ?> </td>
              <td class="cella1"><input type="text" name="IdParametro" id="IdParametro" size="40" value="<?php echo $IdParametroOld; ?>"/></td>
              <input type="hidden" name="IdParametroOld" id="IdParametroOld" value="<?php echo $IdParametroOld; ?>"/>
            </tr>
            <tr>
              <td class="cella2"><?php echo $filtroPar ?>   </td>
              <td class="cella1"><input type="text"  size="40" name="NomeVariabile" id="NomeVariabile" value="<?php echo $NomeVariabile; ?>"/></td>
            </tr>
            <tr>
              <td class="cella2"><?php echo $filtroDescrizione ?></td>
              <td class="cella1"><textarea name="DescriVariabile" id="DescriVariabile" ROWS="3" COLS="45" value="<?php echo $DescriVariabile; ?>"><?php echo $DescriVariabile; ?></textarea></td>
            </tr>
            <tr>
              <td class="cella2"><?php echo $filtroValoreBase ?></td>
              <td class="cella1"><input type="text" name="ValoreBase" id="ValoreBase" size="40" value="<?php echo $ValoreBase; ?>"/></td>
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
