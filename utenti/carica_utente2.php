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

$Cognome = str_replace("'","''",$_POST['Cognome']); 
$Nome = str_replace("'","''",$_POST['Nome']); 
//$IdGruppoUtente = str_replace("'","''",$_POST['GruppoUtenteScelto']); 
list($IdGruppoUtente, $NomeGruppoUtente, $TipoGruppoUtente) = explode(';',$_POST['GruppoUtenteScelto']);
$Username = str_replace("'","''",$_POST['Username']); 
$Password = str_replace("'","''",$_POST['Password']); 
$ConfermaPassword = str_replace("'","''",$_POST['ConfermaPassword']); 



//gestione degli errori
$errore=false;
$messaggio='Si sono verificati degli errori:<br />';

if(!isset($Cognome) || trim($Cognome) =="" ){

	$errore=true;
	$messaggio=$messaggio.' - Campo Cognome vuoto!<br />';

}
if(!isset($Nome) || trim($Nome) =="" ){

	$errore=true;
	$messaggio=$messaggio.' - Campo Nome vuoto!<br />';

}
if(!isset($IdGruppoUtente) || trim($IdGruppoUtente) =="" ){

	$errore=true;
	$messaggio=$messaggio.' - Campo Gruppo Utente vuoto!<br />';

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

//Verifica esistenza
//Apro la connessione al db
	include('../Connessioni/serverdb.php');
	
	$query="SELECT * FROM utente WHERE (cognome = '".$Cognome."' AND nome='".$Nome."')
									OR  (username = '".$Username."' AND pswd = '".$Password."')"; 
									
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
		
		$Salt="tupelle03";
		$Password = crypt($Password,$Salt);	
		
		$query="INSERT INTO utente (cognome,nome,username,id_gruppo_utente,pswd,abilitato,dt_abilitato) 
				VALUES ( '".$Cognome.
						"','".$Nome.
						"','".$Username.
						"','".$IdGruppoUtente.
						"','".$Password.
						"',1,
						   '".dataCorrenteInserimento()."')";
  		$result=mysql_query($query,$connessione) or die(mysql_error());  
 	
		mysql_close();
		echo('Inserimento completato con successo! <a href="gestione_utenti.php">Torna agli Utenti</a>');
	}
?>
</div>
</body>
</html>
