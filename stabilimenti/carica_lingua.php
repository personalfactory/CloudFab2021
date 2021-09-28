<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
<body>


<div id="mainContainer">

	<?php include('../include/menu.php'); ?>
    
    <div id="container" style="width:400px; margin:15px auto;">
        <form id="InserisciLingua" name="InserisciLingua" method="post" action="carica_lingua2.php">
          <table width="400px">
            <tr>
              <td class="cella3" colspan="2"><?php echo $titoloInserimentoLingua?></td>
            </tr>
            <tr>
              <td class="cella2"><?php echo $filtroLingua?> :</td>
              <td class="cella1"><input type="text" name="Lingua" id="Lingua" /></td>
            </tr>
            <?php include('../include/tr_reset_submit.php'); ?>
          </table>		
        </form>
    </div>
 
</div><!-- mainContainer-->

</body>
</html>
