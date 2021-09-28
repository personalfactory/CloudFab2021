<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <?php include('../include/validator.php'); ?>
  <head>
    <?php include('../include/header.php'); ?>
  </head>
  <body>
    

    <div id="mainContainer">

      <?php include('../include/menu.php'); ?>

      <div id="container" style="width:600px; margin:15px auto;">
        <form id="InserisciParametro" name="InserisciParametro" method="post" action="carica_parametro_globale2.php">
          <table width="600px">
            <tr>
              <td class="cella3" colspan="2"><?php echo $labelNuovoParGlob?></td>
            </tr>
            <tr>
              <td class="cella2"><?php echo $filtroId?> </td>
              <td class="cella1"><input style="width:95%" type="text" name="IdParametro" id="IdParametro" /></td>
            </tr>
            <tr>
              <td class="cella2"><?php echo $filtroNome?></td>
              <td  class="cella1"><input style="width:95%" type="text" name="NomeParametro" id="NomeParametro" /></td>
            </tr>
            <tr>
              <td class="cella2"><?php echo $filtroDescrizione?></td>
              <td class="cella1"><textarea style="width:95%" name="DescriParametro" id="DescriParametro" ROWS="3" COLS="45"></textarea></td>
            </tr>
            <tr>
              <td class="cella2"><?php echo $filtroValore?></td>
              <td class="cella1"><textarea style="width:95%" name="Valore" id="Valore" ROWS="3" COLS="45"></textarea></td>
            </tr>
             <?php include('../include/tr_reset_submit.php'); ?>

          </table>
        </form>
      </div>

    </div><!--mainContainer-->

  </body>
</html>
