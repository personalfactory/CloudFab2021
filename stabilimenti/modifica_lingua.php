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
include('../sql/script_lingua.php');

$IdLingua=$_GET['Lingua'];

//visualizzo il record che intendo modificare all'interno della form
/*
$sql = mysql_query("SELECT * FROM lingua WHERE id_lingua=".$IdLingua) 
			or die("Query fallita: " . mysql_error());
			*/
$sql = findLinguaByID($IdLingua);
	while($row=mysql_fetch_array($sql))
	{
		$Lingua=$row['lingua'];
		$Abilitato=$row['abilitato'];
		$Data=$row['dt_abilitato'];
		}
mysql_close();
?>
<div id="container" style="width:400px; margin:15px auto;">
<form id="ModificaColore" name="ModificaColore" method="post" action="modifica_lingua2.php">
    <table style="width:400px;">
		<input type="hidden" name="IdLingua" id="IdLingua" value=<?php echo $IdLingua;?>></input>
	    <th class="cella3" colspan="2"><?php echo $labelModLingua?></th>
        <tr>
            <td class="cella2"><?php echo $filtroNome.' '.$filtroLingua?> </td>
            <td class="cella1"><input type="text" name="Lingua" id="Lingua" value=<?php echo $Lingua;?>></input></td>
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
