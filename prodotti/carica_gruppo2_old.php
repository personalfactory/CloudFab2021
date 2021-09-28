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
include('../sql/script_gruppo.php');
include('../sql/script.php');


$PrimoLivello = str_replace("'","''",$_POST['PrimoLivello']); 
$SecondoLivello = str_replace("'","''",$_POST['SecondoLivello']); 
$TerzoLivello = str_replace("'","''",$_POST['TerzoLivello']); 
$QuartoLivello = str_replace("'","''",$_POST['QuartoLivello']); 
$QuintoLivello = str_replace("'","''",$_POST['QuintoLivello']); 
$SestoLivello = str_replace("'","''",$_POST['SestoLivello']); 


//############## Gestione degli errori #######################################
$errore=false;
$messaggio=$msgErroreVerificato.'<br />';

if(!isset($PrimoLivello) || trim($PrimoLivello) =="" ){

	$errore=true;
	$messaggio=$messaggio.' - '.$msgCampoVuoto.' : '.$filtroPrimoLivello.'!<br />';
	
}
if(!isset($SecondoLivello) || trim($SecondoLivello) =="" ){

	$errore=true;
	$messaggio=$messaggio.' - '.$msgCampoVuoto.' : '.$filtroSecondoLivello.'!<br />';
	
}
if(!isset($TerzoLivello) || trim($TerzoLivello) =="" ){

	$errore=true;
	$messaggio=$messaggio.' - '.$msgCampoVuoto.' : '.$filtroTerzoLivello.'!<br />';
	
}
if(!isset($QuartoLivello) || trim($QuartoLivello) =="" ){

	$errore=true;
	$messaggio=$messaggio.' - '.$msgCampoVuoto.' : '.$filtroQuartoLivello.'!<br />';
	
}
if(!isset($QuintoLivello) || trim($QuintoLivello) =="" ){

	$errore=true;
	$messaggio=$messaggio.' - '.$msgCampoVuoto.' : '.$filtroQuintoLivello.'!<br />';
	
}
if(!isset($SestoLivello) || trim($SestoLivello) =="" ){

	$errore=true;
	$messaggio=$messaggio.' - '.$msgCampoVuoto.' : '.$filtroSestoLivello.'!<br />';
	
}
list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);

	//VERIFICA ESISTENZA
	$result=findGruppoByLiv($PrimoLivello, $connessione);

	
	if(mysql_num_rows($result)!=0)
	{	
		//Se entro nell'if vuol dire che esiste
		$errore=true;
		$messaggio=$messaggio.' '.$msgDuplicaRecord.'!<br />';
	}

	$messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.' </a>';
	
	$insGroup = true;
	if($errore){
		//Ci sono errori quindi non salvo
		echo $messaggio;
	} else {
		//Inserisco perchè non ci sono errori
		begin();
		
		$insGroup=insertGroup($PrimoLivello, $SecondoLivello, $TerzoLivello, $QuartoLivello, $QuintoLivello, $SestoLivello, dataCorrenteInserimento(),$_SESSION['id_utente'], $IdAzienda );

		if (!$insGroup) {
		
			rollback();
			echo '<div id="msgErr">'. $msgTransazioneFallita.'! '.$msgErrContactAdmin .'!</div>';
			echo ' <a href="gestione_gruppi.php">'.$msgTornaAiGruppi.'</a>';
			
		} else {
				
			commit();
			mysql_close();
			echo($msgInserimentoCompletato.' <a href="gestione_gruppi.php">'.$msgTornaAiGruppi.'</a>');
				
		    }
	}
?>
</div>
</body>
</html>
