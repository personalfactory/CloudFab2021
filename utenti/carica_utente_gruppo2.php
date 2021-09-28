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


$NomeGruppo = str_replace("'","''",$_POST['NomeGruppo']); 
$Tipo = str_replace("'","''",$_POST['Tipo']); 
$Descrizione = str_replace("'","''",$_POST['Descrizione']); 

//Gestione degli errori
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

//Verifica esistenza
//Apro la connessione al db
	include('../Connessioni/serverdb.php');
	
	$query="SELECT * FROM utente_gruppo WHERE (nome_gruppo_utente = '".$NomeGruppo."' AND tipo_gruppo_utente='".$Tipo."')"; 
									
  	$result=mysql_query($query,$connessione) or die(mysql_error());  
	
	if(mysql_num_rows($result)!=0)
	{	
		//Se entro nell'if vuol dire che esiste
		$errore=true;
		$messaggio=$messaggio.' Si sta tendando di duplicare un record!<br />';
	}

	mysql_close();

	$messaggio = $messaggio . '<a href="javascript:history.back()">Ricontrollare i dati</a>';
	
	
	if($errore){
		//Ci sono errori quindi non salvo
		echo $messaggio;
	}else{
		//Inserisco perch� non ci sono errori
		include('../Connessioni/serverdb.php');

		$query="INSERT INTO utente_gruppo 
					(nome_gruppo_utente,
						tipo_gruppo_utente,
						descri_gruppo_utente,
						abilitato,
						dt_abilitato) 
				VALUES ( '".$NomeGruppo."',
						'".$Tipo."',
						'".$Descrizione."',
						1,
						'".dataCorrenteInserimento()."')";
  		$result=mysql_query($query,$connessione) or die(mysql_error());  
 	
		mysql_close();
		echo('Inserimento completato con successo! <a href="gestione_utenti_gruppi.php">Torna ai Gruppi Utente</a>');
	}
?>
</div>
</body>
</html>
