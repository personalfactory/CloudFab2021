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

$IdParametro=$_POST['Parametro'];
$IdMacchina=$_POST['IdMacchina'];
$Valore=$_POST['Valore'];

//Gestione degli errori
//Verifico che il parametro sia stata settato e che non sia vuoto
$errore=false;
$messaggio='Si sono verificati degli errori:<br />';
if(!isset($IdParametro) || trim($IdParametro) =="" ){

	$errore=true;
	$messaggio=$messaggio.' - Selezionare il parametro da associare allo stabilimento!<br />';

}

if(!isset($Valore) || trim($Valore) =="" ){

	$errore=true;
	$messaggio=$messaggio.' - Digitare il valore  del nuovo parametro da associare al prodotto!<br />';

}
//Verifica esistenza
//Apro la connessione al db

include('../Connessioni/serverdb.php');
	
	$query="SELECT * FROM valore_par_sing_mac
				WHERE 
					id_par_sm = ".$IdParametro."
				AND
				 	id_macchina= ".$IdMacchina;
					
  	$result=mysql_query($query,$connessione) or die("Errore 114: " . mysql_error());
	
	if(mysql_num_rows($result)!=0)
	{	
		//Se entro nell'if vuol dire che il valore inserito esiste gi� nel db
		$errore=true;
		$messaggio=$messaggio.' - Il parametro � gi� stato associato allo stabilimento!<br />';
		
	}

	mysql_close();

	$messaggio = $messaggio . '<a href="javascript:history.back()">Ricontrollare i dati</a>';
		
		
	if($errore){
		//Ci sono errori quindi non salvo
		echo $messaggio;
	}else{
		//Inserisco nella tabella valore_par_sing_mac la nuova associazione parametro-stabilimento con relativo valore perch� non ci sono errori
		include('../Connessioni/serverdb.php');
		
		mysql_query("INSERT INTO valore_par_sing_mac 
						(id_macchina,
						 id_par_sm,
						 valore_variabile,
						 abilitato,
					 	dt_abilitato) 
					VALUES(
						".$IdMacchina.",
						".$IdParametro.",
						'".$Valore."',
						1,
						'".dataCorrenteInserimento()."')")
		or die("Errore 116: " . mysql_error());
									
		mysql_close();

	
echo 'Il nuovo parametro � stato aggiunto! <a href="gestione_macchine.php">Torna agli Stabilimenti</a>';
	
}//fine primo if($errore) controllo degli input relativo al prodotto 
?>

</div>
</body>
</html>
