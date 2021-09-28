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

$IdUtente=$_GET['Utente'];
//storicizzo l'utente che intendo cancellare
$sql = mysql_query("SELECT * FROM utente WHERE id_utente=".$IdUtente) or die("Query fallita: " . mysql_error());

while($row=mysql_fetch_array($sql))
{
	$cognome=$row['cognome'];
	$nome=$row['nome'];
	$id_gruppo_utente=$row['id_gruppo_utente'];
	$username=$row['username'];
	$password=$row['pswd'];
	$abilitato=$row['abilitato'];
	$dt_abilitato=$row['dt_abilitato'];
	}

mysql_close();

include('../Connessioni/storico.php');

$sql = mysql_query("INSERT INTO utente 						 										
						(id_utente,
				 		cognome,
				 		nome,
						id_gruppo_utente,
						username,
						pswd,
				 		abilitato,
				 		dt_abilitato) 
					VALUES(".$IdUtente.",
						   '".$cognome."',
						   '".$nome."',
						   '".$id_gruppo_utente."',
						   '".$username."',
						   '".$password."',
						   0,
						   '".dataCorrenteInserimento()."')"
					  
					) or die("Query fallita: " . mysql_error());
mysql_close();

include('../Connessioni/serverdb.php');
$sql = mysql_query("DELETE FROM utente WHERE id_utente=".$IdUtente) or die("Query fallita: " . mysql_error());
mysql_close();


echo '<div id="container">L\'utente � stato eliminato! <a href="gestione_utenti.php">Torna alla gestione degli Utenti</a></div>';

?>