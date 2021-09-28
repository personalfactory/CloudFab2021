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
include('../include/gestione_date.php'); 
include('../Connessioni/serverdb.php');

$IdMateria=$_GET['IdMateria'];
//Non storicizzo il record che intendo cancellare

$sql = mysql_query("DELETE FROM lab_materie_prime WHERE id_mat=".$IdMateria) or die("Query fallita: " . mysql_error());
mysql_close();

echo 'La materia prima � stata eliminata! <a href="gestione_lab_materie.php">Torna alla gestione delle Materie Prime</a>';
?>
</div>
</body>
</html>