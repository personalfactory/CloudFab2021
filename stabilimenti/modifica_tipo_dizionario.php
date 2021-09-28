<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
<body>

<div id="mainContainer">

<?php 
include('../include/menu.php'); include('../Connessioni/serverdb.php');

$IdTipoDizionario=$_GET['TipoDizionario'];

//visualizzo il record che intendo modificare all'interno della form

$sql = mysql_query("SELECT * FROM dizionario_tipo WHERE id_diz_tipo=".$IdTipoDizionario) 
			or die("Query fallita: " . mysql_error());
	while($row=mysql_fetch_array($sql))
	{
		$DizionarioTipo=$row['dizionario_tipo'];
		$Tabella=$row['tabella'];
		$Abilitato=$row['abilitato'];
		$Data=$row['dt_abilitato'];
		}
mysql_close();
?>
<div id="container" style="width:400px; margin:15px auto;">
<form id="ModificaDizionarioTipo" name="ModificaDizionarioTipo" method="post" action="modifica_tipo_dizionario2.php">
    <table style="width:400px;">
		<input type="hidden" name="IdTipoDizionario" id="IdTipoDizionario" value=<?php echo $IdTipoDizionario;?>></input>
	    <tr>
            <td class="cella2">Tipo Dizionario</td>
            <td><input type="text" name="DizionarioTipo" id="DizionarioTipo" value=<?php echo '"'.$DizionarioTipo.'"';?>></input></td>
        </tr>
        <tr>
            <td class="cella2">Tabella di Riferimento</td>
            <td><input type="text" name="Tabella" id="Tabella" value=<?php echo '"'.$Tabella.'"';?>></input></td>
        </tr>
        <tr>
             <td class="cella2">Abilitato</td>
             <td><?php echo $Abilitato;?>
        </tr>
        <tr>
             <td class="cella2">Data</td>
             <td><?php echo $Data;?></td>
        </tr>
        <?php include('../include/tr_reset_submit.php'); ?>
 	</table>
</form>
</div>

</div><!--mainContainer-->

</body>
</html>
