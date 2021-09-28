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

$Gruppo=$_GET['Gruppo'];
?>

<table class="table3">
	<tr>
    	<th class="cella3"><?php echo $titoloSelezMod?></th>
    </tr>
    <tr>
    	<td class="cella6">
        <a href="modifica_gruppo.php?Gruppo=<?php echo $Gruppo; ?>"><?php echo $titoloModGruppoSing?></a><p>&nbsp;</p>
        <a href="modifica_livello.php?Gruppo=<?php echo $Gruppo; ?>"><?php echo $titoloModLiv?></a><p>&nbsp;</p>
        </td>
    </tr>
    	<td class="cella6">
            <input type="button" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"  /></td>
          
</td>
    <tr>
</table>

</div><!--mainContainer-->

</body>
</html>
