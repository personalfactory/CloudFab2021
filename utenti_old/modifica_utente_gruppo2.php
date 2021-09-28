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

$IdGruppoUtente = $_POST['IdGruppoUtente'];
$NomeGruppo = str_replace("'","''",$_POST['NomeGruppo']);
$Tipo = str_replace("'","''",$_POST['Tipo']);
$Descrizione = str_replace("'","''",$_POST['Descrizione']);

//gestione degli errori relativa ai nuovi dati modificati
$errore=false;
$messaggio='Si sono verificati degli errori:<br />';

if(!isset($NomeGruppo) || trim($NomeGruppo) =="" ){

	$errore=true;
	$messaggio=$messaggio.' - Campo Nome Gruppo vuoto!<br />';
}
if(!isset($Tipo) || trim($Tipo) =="" ){

	$errore=true;
	$messaggio=$messaggio.' - Campo Tipo vuoto!<br />';
}
if(!isset($Descrizione) || trim($Descrizione) =="" ){

	$errore=true;
	$messaggio=$messaggio.' - Campo Descrizione vuoto!<br />';
}

//la Verifica esistenza assente va approfondita!
	$messaggio = $messaggio . '<a href="javascript:history.back()">Ricontrollare i dati</a>';
	
	if($errore){
		//Ci sono errori quindi non salvo
		echo $messaggio;
	}else{
//Inserisco il vecchio record nello storico  prima di modificarlo nella tabella corrente su serverdb
		include('../Connessioni/storico.php');
		include('../Connessioni/serverdb.php');
		
		mysql_query("INSERT INTO storico.utente_gruppo 
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
							abilitato,
							dt_abilitato
						FROM 
							serverdb.utente_gruppo
						WHERE 
							id_gruppo_utente='".$IdGruppoUtente."'") 
		
		or die("Query 1 fallita: " . mysql_error());
		
		//Modifico il record nella tabella corrente [utente] di serverdb
		mysql_query("UPDATE serverdb.utente_gruppo 
						SET 
							nome_gruppo_utente='".$NomeGruppo."',
							tipo_gruppo_utente='".$Tipo."',
							descri_gruppo_utente='".$Descrizione."',
							dt_abilitato='".dataCorrenteInserimento()."'
						WHERE 
							id_gruppo_utente='".$IdGruppoUtente."'")
		or die("Query 2 fallita: " . mysql_error());
			
		mysql_close();
	
	echo('Modifica completata con successo! <a href="gestione_utenti_gruppi.php">Torna ai Gruppi di Utenti</a>');
	}
?>