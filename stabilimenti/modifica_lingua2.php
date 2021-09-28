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

$IdLingua = $_POST['IdLingua'];
$Lingua = str_replace("'","''",$_POST['Lingua']); 

//gestione degli errori relativa ai nuovi dati modificati
$errore=false;
$messaggio = $msgErroreVerificato.'<br />';


if(!isset($Lingua) || trim($Lingua) =="" ){

	$errore=true;
	$messaggio = $messaggio . ' '.$msgErrCampoLinguaVuoto.'<br />';
}


//Verifica esistenza 
//Verifico che non ci sia in tabella un record con gli stessi valori(descrizioni) e con Id diverso da quello che si sta modificando
include('../Connessioni/serverdb.php');
include('../sql/script_lingua.php');

	/*
	$query="SELECT * FROM lingua 
				WHERE 
					lingua = '".$Lingua."'
				AND 
					id_lingua<>".$IdLingua;
  	$result=mysql_query($query,$connessione) or die(" Errore: 120 ".mysql_error());  
  	*/
  	$result = selectLinguaByLinguaAndID($Lingua, $IdLingua, $connessione);
	if(mysql_num_rows($result)!=0)
	{	
		//Se entro nell'if vuol dire che il valore inserito esiste gi� nel db
		$errore=true;
        $messaggio = $messaggio . ' '.$msgDuplicaRecord.'<br />';
	}
	mysql_close();
	
      	$messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';
		
	if($errore){
		//Ci sono errori quindi non salvo
		echo $messaggio;
	}else{
//Inserisco il vecchio record nello storico  prima di modificarlo nella tabella corrente su serverdb
		include('../Connessioni/storico.php');
		include('../Connessioni/serverdb.php');
		/*
		mysql_query("INSERT INTO storico.lingua						 										
				(id_lingua,lingua,abilitato,dt_abilitato) 
					SELECT 
						id_lingua,
						lingua,
						abilitato,
						dt_abilitato
					FROM 
						serverdb.lingua
					WHERE
						id_lingua='".$IdLingua."'") 
					  
		or die("Query fallita: " . mysql_error());
		*/
		insertStoricoLingua($IdLingua);

//Modifico il record nella tabella corrente [colore] di serverdb
/*
		mysql_query("UPDATE serverdb.lingua 
						SET 
							lingua='".$Lingua."',
							dt_abilitato='".dataCorrenteInserimento()."'
						WHERE 
							id_lingua='".$IdLingua."'") 
		or die("Query fallita: " . mysql_error());
		*/
		updateServerDBLingua($Lingua, $IdLingua, dataCorrenteInserimento());
	
		mysql_close();
	
        echo($msgModificaCompletata.'</br><a href="gestione_lingue.php">'.$msgTornaAlleLingue.'</a>');
	}
?>