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
     
        ?>

        <div id="container" style="width:500px; margin:15px auto ;">
          <form id="InserisciSacchetto" name="InserisciSacchetto" method="GET" action="/CloudFab/produzionechimica/dettaglio_sacchetto_pubblico.php">
            <table width="100%">
              <tr>
                <td class="cella3" colspan="2"><?php echo $titoloPaginaRicercaSacchetto ?></td>
              </tr>
              <tr>
                 <td class="cella2" style=""><input type="text" name="Sacco" id="Sacco" size="50" style="font-size: 20px;"/></td>
              </tr>
              <tr>
                <td class="cella2" style="text-align: right " colspan="2">
                  <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                  <input type="submit" value="<?php echo $valueButtonCerca ?>" /></td>
              </tr>
            </table>		
          </form>
        </div>



    </div><!-- mainContainer-->

  </body>
</html>
