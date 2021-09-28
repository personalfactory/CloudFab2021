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
include('../Connessioni/serverdb.php');
include('../sql/script_presa.php');

$IdPresa=$_GET['Presa'];

//visualizzo il record che intendo modificare all'interno della form
$sql=findPresaById($IdPresa);
//$sql = mysql_query("SELECT * FROM presa WHERE id_presa=".$IdPresa) 
//			or die("Query fallita: " . mysql_error());
	while($row=mysql_fetch_array($sql))
	{
		$NomePresa=$row['presa'];
		$Abilitato=$row['abilitato'];
		$Data=$row['dt_abilitato'];
		}
mysql_close();
?>

<div id="container" style="width:400px; margin:15px auto;">
<form id="ModificaPresa" name="ModificaPresa" method="post" action="modifica_presa2.php">
    <table style="width:400px;">
		<input type="hidden" name="IdPresa" id="IdPresa" value=<?php echo $IdPresa;?>></input>
	    <th class="cella3" colspan="2"><?php echo $titoloModPresa?></th>
        <tr>
            <td class="cella2"><?php echo $filtroPresa?> </td>
            <td class="cella1"><input type="text" name="NomePresa" id="NomePresa" value=<?php echo '"'.$NomePresa.'"';?>></input></td>
        </tr>
        <tr>
             <td class="cella2"><?php echo $filtroAbilitato?></td>
             <td class="cella1"><?php echo $Abilitato;?>
        </tr>
        <tr>
             <td class="cella2"><?php echo $filtroDt?></td>
             <td class="cella1"><?php echo $Data;?></td>
        </tr>
        <?php include('../include/tr_reset_submit.php'); ?>
 	</table>
</form>
</div>

</div><!--mainContainer-->

</body>
</html>
