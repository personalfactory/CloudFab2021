<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
<body>

<div id="mainContainer">
<?php include('../include/menu.php'); ?>
<?php include('../include/gestione_date.php'); ?>
<?php
include('../Connessioni/serverdb.php');

$IdParametro=$_GET['IdParametro'];
//Non storicizzo il record che intendo cancellare

$sql = mysql_query("DELETE FROM lab_parametro WHERE id_par=".$IdParametro) or die("Query fallita: " . mysql_error());
mysql_close();

echo 'Il parametro � stato eliminato! <a href="gestione_lab_parametri.php">Torna ai Parametri </a>';

?>
</div>
</body>
</html>
