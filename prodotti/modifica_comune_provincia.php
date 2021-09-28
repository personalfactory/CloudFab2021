<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
<body>


<div id="mainContainer">

<?php 
include('../include/menu.php'); $Comune=$_GET['Comune'];
?>

<table class="table3">
	<tr>
    	<th class="cella3"><?php echo $titoloTipoModifica?></th>
    </tr>
    <tr>
    	<td class="cella6">
        	<a href="modifica_comune.php?Comune=<?php echo $Comune; ?>"><?php echo $titoloModificaRecord?></a><p>&nbsp;</p>
          	<a href="modifica_provincia.php?Comune=<?php echo $Comune; ?>"><?php echo $titoloModificaLivelli?></a><p>&nbsp;</p>
         </td>
    </tr>
    	<td class="cella6"><a href="javascript:history.back();"><?php echo $msgTornaIndietro?></a></td>
    <tr>
</table>

</div><!--mainContainer-->

</body>
</html>
