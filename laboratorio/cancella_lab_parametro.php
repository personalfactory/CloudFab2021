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
$IdParametro=$_GET['IdParametro'];
?>
<table class="table3">
	<tr>
    	<th class="cella3">Sicuri di voler cancellare il record selezionato?</th>
    </tr>
    <tr>
    	<td class="cella1">
        <a href="javascript:history.back();"><img src="/CloudFab/images/icone/no.png" class="images2" /></a>  
        <a href="cancella_lab_parametro2.php?IdParametro=<?php echo($IdParametro)?>"><img src="/CloudFab/images/icone/si.png" class="images2" /></a>
        </td>
    </tr>
</table>
</div>
</body>
</html>
