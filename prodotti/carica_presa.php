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
        <form id="InserisciPresa" name="InserisciPresa" method="post" action="carica_presa2.php">
        <table width="400px">
            <tr>
              <td class="cella3" colspan="2"><?php echo $linkPaginaPresa?> </td>
            </tr>
            <tr>
                <td class="cella2"><?php echo $filtroPresa.' :'?></td>
                <td class="cella1"><input type="text" name="NomePresa" id="NomePresa" /></td>
            </tr>
            <?php include('../include/tr_reset_submit.php'); ?>
        
        </table>
        </form>
    </div>
 
</div><!--mainContainer-->
</body>
</html>
