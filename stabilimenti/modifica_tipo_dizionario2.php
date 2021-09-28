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

$IdTipoDizionario = $_POST['IdTipoDizionario'];
$Tabella = str_replace("'","''",$_POST['Tabella']); 
$DizionarioTipo = str_replace("'","''",$_POST['DizionarioTipo']); 
//Gestione degli errori relativa ai nuovi dati modificati
$errore=false;
$messaggio='Si sono verificati degli errori:<br />';

if(!isset($DizionarioTipo) || trim($DizionarioTipo) =="" ){

	$errore=true;
	$messaggio=$messaggio.' - Campo Nome Tabella vuoto!<br />';
}

if(!isset($Tabella) || trim($Tabella) =="" ){

	$errore=true;
	$messaggio=$messaggio.' - Campo Nome Tabella vuoto!<br />';
}

//Verifica esistenza 
//verifico che non ci sia in tabella un record con gli stessi valori(descrizioni) e con Id diverso da quello che si sta modificando
include('../Connessioni/serverdb.php');
	
	$query="SELECT * FROM dizionario_tipo 
				WHERE 
					dizionario_tipo = '".$DizionarioTipo."' 
				AND 
					Tabella = '".$Tabella."'
				AND 
					id_diz_tipo<>".$IdTipoDizionario;
  	$result=mysql_query($query,$connessione) or die(" Errore: 1 ".mysql_error());  
	mysql_close();
	if(mysql_num_rows($result)!=0)
	{	
		//Se entro nell'if vuol dire che esiste
		$errore=true;
		$messaggio=$messaggio.' - Si sta tendando di duplicare un record!<br />';
	}


	$messaggio = $messaggio . '<a href="javascript:history.back()">Ricontrollare i dati</a>';
	
	if($errore){
		//Ci sono errori quindi non salvo
		echo $messaggio;
	}else{
//Inserisco il vecchio record nello storico delle categorie prima di modificarlo nella tabella corrente su serverdb
		include('../Connessioni/storico.php');
		include('../Connessioni/serverdb.php');
		mysql_query("INSERT INTO storico.dizionario_tipo 						 										
								(id_diz_tipo,
								dizionario_tipo,
								tabella,
								abilitato,
								dt_abilitato) 
							SELECT 
								id_diz_tipo,
								dizionario_tipo,
								tabella,
								abilitato,
								dt_abilitato
							FROM 
								serverdb.dizionario_tipo
							WHERE 
								id_diz_tipo='".$IdTipoDizionario."'") 
		
		or die("Errore 2: " . mysql_error());
		

	//Modifico il record nella tabella corrente [dizionario_tipo] di serverdb
		mysql_query("UPDATE serverdb.dizionario_tipo 
						SET 
							dizionario_tipo='".$DizionarioTipo."', 
							tabella='".$Tabella."',
							dt_abilitato='".dataCorrenteInserimento()."'
						WHERE 
							id_diz_tipo='".$IdTipoDizionario."'")
		or die("Errore 3: " . mysql_error());
		
	
		mysql_close();
	
	echo('Modifica completata con successo! <a href="gestione_tipi_dizionari.php">Torna alla gestione dei tipi di dizionario</a>');
	}
?>