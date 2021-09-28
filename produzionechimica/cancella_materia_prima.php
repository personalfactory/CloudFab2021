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

$CodiceMatPrima=$_GET['CodiceMatPrima'];
$CodiceFormula=$_GET['CodiceFormula'];
$DescriMat=$_GET['DescriMat'];
?>
<table class="table3">
	<tr>
    	<th class="cella3"><?php echo $msgInfoConfermaEliminazione ." ".$DescriMat ."?"?></th>
    </tr>
    <tr>
    	<td class="cella1center">
        <a href="javascript:history.back();">
            <img src="/CloudFab/images/icone/no.png" class="images2" /></a>  
        <a href="cancella_materia_prima2.php?CodiceMatPrima=<?php echo($CodiceMatPrima)?>&CodiceFormula=<?php echo $CodiceFormula ?>">
            <img src="/CloudFab/images/icone/si.png" class="images2" /></a></td>
    </tr>
</table>
</div>
</body>
</html>
