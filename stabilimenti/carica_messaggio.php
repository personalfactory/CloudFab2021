<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <?php include('../include/validator.php'); ?>
  <head>
    <?php include('../include/header.php'); ?>
  </head>
  <body>
    

    <div id="mainContainer">

      <?php include('../include/menu.php'); ?>

      <div id="container" style="width:500px; margin:15px auto;">
        <form id="InserisciMessaggio" name="InserisciMessaggio" method="post" action="carica_messaggio2.php">
          <table width="500px">
            <tr>
              <td class="cella3" colspan="2"><?php echo $nuovoMessaggio ?></td>
            </tr>
            <tr>
              <td class="cella2" ><?php echo $filtroMessaggio ?> </td>
              <td class="cella1"><textarea name="Messaggio" id="Messaggio" ROWS="3" COLS="45"></textarea></td>
            </tr>
           <?php include('../include/tr_reset_submit.php'); ?>
          </table>
        </form>
      </div>

    </div><!--mainContainer-->

  </body>
</html>
