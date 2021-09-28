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


$TipoDizionario= str_replace("'","''",$_POST['TipoDizionario']); 
$Tabella = str_replace("'","''",$_POST['Tabella']); 

//gestione degli errori
$errore=false;
$messaggio=$msgErroreVerificato.'<br />';

if(!isset($TipoDizionario) || trim($TipoDizionario) =="" ){

	$errore=true;
	$messaggio=$messaggio.' '.$msgErrCampoTipoDizVuoto.'<br />';

}
if(!isset($Tabella) || trim($Tabella) =="" ){

	$errore=true;
	$messaggio=$messaggio.' '.$msgErrCampoTabRifVuoto.'<br />';

}

//Verifica esistenza
//Apro la connessione al db
	include('../Connessioni/serverdb.php');
	include('../sql/script_dizionario_tipo.php');
	/*
	$query="SELECT * FROM dizionario_tipo WHERE dizionario_tipo = '".$TipoDizionario."'";
  	$result=mysql_query($query,$connessione) or die(mysql_error());  
  	*/
  	$result = findAllDizionarioTipoByTipoDiz($TipoDizionario, $connessione);
	
	if(mysql_num_rows($result)!=0)
	{	
		//Se entro nell'if vuol dire che esiste
		$errore=true;
		$messaggio=$messaggio.' '.$msgDuplicaRecord.'<br />';
	}

	mysql_close();

	$messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';
	
	
	if($errore){
		//Ci sono errori quindi non salvo
		echo $messaggio;
	}else{
		//Inserisco perch� non ci sono errori
		include('../Connessioni/serverdb.php');
		/*
		$query="INSERT INTO dizionario_tipo (dizionario_tipo, tabella,abilitato,dt_abilitato) 
				VALUES ( '".$TipoDizionario."',
						 '".$Tabella."',
						 1,
						 '".dataCorrenteInserimento()."')";
  		$result=mysql_query($query,$connessione) or die(mysql_error());
		*/
  		$result = insertDizionarioTipo($TipoDizionario, $Tabella, dataCorrenteInserimento(), $connessione);
 	
		mysql_close();
		echo($msgInserimentoCompletato.'<a href="gestione_tipi_dizionari.php">'.$msgTornaAiTipiDiDizionari.'</a>');
	}
?>
</div>
</body>
</html>
