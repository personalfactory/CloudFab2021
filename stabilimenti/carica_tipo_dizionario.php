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
	<form id="InserisciTipo" name="InserisciTipo" method="post" action="carica_tipo_dizionario2.php">
    <table style="width:500px;">
    <tr>
      <td class="cella3" colspan="2"><?php echo $titoloInserimentoDizionario?></td>
    </tr>
    <tr>
    	<td class="cella2"><?php echo $labelTipoDiz?>:</td>
        <td class="cella1"><input type="text" name="TipoDizionario" id="TipoDizionario" /></td>
    </tr>
    <tr>
        <td class="cella2"><?php echo $labelTabDiRif?> :</td>
        <td class="cella1"><input type="text" name="Tabella" id=	    					"Tabella" /></td>
    </tr>
    <?php include('../include/tr_reset_submit.php'); ?>
    
    </table>
    </form>
    </div>

</div><!--mainContainer-->

</body>
</html>
