<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
<body>
<div id="mainContainer">
<?php include('../include/menu.php');  
include('../include/gestione_date.php'); 

$IdGruppoUtente=$_GET['IdGruppoUtente'];

//Storicizzo il gruppo che intendo cancellare

include('../Connessioni/storico.php');

$sql = mysql_query("INSERT INTO storico.utente_gruppo 
							(id_gruppo_utente,
							 nome_gruppo_utente,
							 tipo_gruppo_utente,
							 descri_gruppo_utente,
							 abilitato,
							 dt_abilitato) 
						SELECT 
							id_gruppo_utente,
							nome_gruppo_utente,
							tipo_gruppo_utente,
							descri_gruppo_utente,
							0,
							dt_abilitato
						FROM 
							serverdb.utente_gruppo
						WHERE 
							id_gruppo_utente='".$IdGruppoUtente."'")
or die("Query fallita: " . mysql_error());
mysql_close();

include('../Connessioni/serverdb.php');
$sql = mysql_query("DELETE FROM utente_gruppo WHERE id_gruppo_utente=".$IdGruppoUtente) 
or die("Query fallita: " . mysql_error());
mysql_close();


echo '<div id="container"><br />
Il Gruppo Utente � stato eliminato! <a href="gestione_utenti_gruppi.php">Torna ai Gruppi Utenti</a></div>';

?>