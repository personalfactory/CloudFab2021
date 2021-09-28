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

$IdUtente = $_POST['IdUtente'];
$Nome = str_replace("'","''",$_POST['Nome']);
$Cognome = str_replace("'","''",$_POST['Cognome']);
$Username = str_replace("'","''",$_POST['Username']);
$Password = str_replace("'","''",$_POST['Password']);//Nuova password modificata
$PasswordOld = str_replace("'","''",$_POST['PasswordOld']);//Vecchia Password
$ConfermaPassword = str_replace("'","''",$_POST['ConfermaPassword']); 
$IdGruppoUtente = str_replace("'","''",$_POST['IdGruppoUtente']);

//gestione degli errori relativa ai nuovi dati modificati
$errore=false;
$messaggio='Si sono verificati degli errori:<br />';

if(!isset($Nome) || trim($Nome) =="" ){

	$errore=true;
	$messaggio=$messaggio.' - Campo Nome vuoto!<br />';
}
if(!isset($Cognome) || trim($Cognome) =="" ){

	$errore=true;
	$messaggio=$messaggio.' - Campo Cognome vuoto!<br />';
}
if(!isset($Username) || trim($Username) =="" ){

	$errore=true;
	$messaggio=$messaggio.' - Campo Username vuoto!<br />';
}
if(!isset($Password) || trim($Password) =="" ){

	$errore=true;
	$messaggio=$messaggio.' - Campo Password vuoto!<br />';
}
if(!isset($ConfermaPassword) || trim($ConfermaPassword) =="" ){

	$errore=true;
	$messaggio=$messaggio.' - Campo Conferma Password vuoto!<br />';

}
if( $Password!= $ConfermaPassword){

	$errore=true;
	$messaggio=$messaggio.' - Campo Conferma Password errata!<br />';

}
if(!isset($IdGruppoUtente) || trim($IdGruppoUtente) =="" ){

	$errore=true;
	$messaggio=$messaggio.' - Campo Gruppo Utente vuoto!<br />';

}

//la Verifica esistenza assente va approfondita!
	$messaggio = $messaggio . '<a href="javascript:history.back()">Ricontrollare i dati</a>';
	
	if($errore){
		//Ci sono errori quindi non salvo
		echo $messaggio;
	}else{
//Inserisco il vecchio record nello storico delle categorie prima di modificarlo nella tabella corrente su serverdb
		include('../Connessioni/storico.php');
		include('../Connessioni/serverdb.php');
		
		mysql_query("INSERT INTO storico.utente						 										
								(id_utente,
								cognome,
								nome,
								id_gruppo_utente,
								username,
								pswd,
								abilitato,
								dt_abilitato) 
							SELECT 
								id_utente,
								cognome,
								nome,
								id_gruppo_utente,
								username,
								pswd,
								abilitato,
								dt_abilitato
							FROM 
								serverdb.utente
							WHERE 
								id_utente='".$IdUtente."'") 
		
		or die("Query 5 fallita: " . mysql_error());
		
		if($Password!=$PasswordOld){
			$Salt="tupelle03";
			$Password = crypt($Password,$Salt);	
		}
		
		//Modifico il record nella tabella corrente [utente] di serverdb
		mysql_query("UPDATE serverdb.utente 
						SET 
							nome='".$Nome."',
							cognome='".$Cognome."',
							id_gruppo_utente='".$IdGruppoUtente."',
							username='".$Username."',
							pswd='".$Password."',
							dt_abilitato='".dataCorrenteInserimento()."'
						WHERE 
							id_utente='".$IdUtente."'")
		or die("Query 6 fallita: " . mysql_error());
			
		mysql_close();
	
	echo('Modifica completata con successo! <a href="gestione_utenti.php">Torna alla gestione degli Utenti</a>');
	}
?>