<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
<body>
<div id="mainContainer">
<?php include('../include/menu.php'); 
$IdGruppoUtente=$_GET['IdGruppoUtente'];
?>
<table class="table3">
	<tr>
    	<th class="cella3"><?php echo $msgConfermaCancellazione ?></th>
    </tr>
    <tr>
    	<td class="cella6">
        <a href="javascript:history.back();"><img src="/CloudFab/images/icone/no.png" class="images2" /></a>  
        <a href="cancella_utente_gruppo2.php?IdGruppoUtente=<?php echo($IdGruppoUtente)?>"><img src="/CloudFab/images/icone/si.png" class="images2" /></a></td>
    </tr>
</table>
</div>
</body>
</html>
