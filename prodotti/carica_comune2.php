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

$Cap = str_replace("'","''",$_POST['Cap']); 
$CodiceCatastale = str_replace("'","''",$_POST['CodiceCatastale']); 
$CodiceIstat = str_replace("'","''",$_POST['CodiceIstat']); 
$Comune = str_replace("'","''",$_POST['Comune']); 
$CodiceProvincia = str_replace("'","''",$_POST['CodiceProvincia']); 
$Provincia = str_replace("'","''",$_POST['Provincia']); 
$CodiceRegione = str_replace("'","''",$_POST['CodiceRegione']); 
$Regione = str_replace("'","''",$_POST['Regione']); 
$CodiceStato = str_replace("'","''",$_POST['CodiceStato']); 
$Stato = str_replace("'","''",$_POST['Stato']); 
$Continente = str_replace("'","''",$_POST['Continente']); 

//gestione degli errori
$errore=false;
$messaggio=$msgErroreVerificato.'<br />';

if(!isset($Cap) || trim($Cap) =="" ){
	$Cap="_";
	
}
if(!isset($CodiceCatastale) || trim($CodiceCatastale) =="" ){
	$CodiceCatastale="_";

}
if(!isset($CodiceIstat) || trim($CodiceIstat) =="" ){
	$CodiceIstat="_";
	
}
if(!isset($Comune) || trim($Comune) =="" ){
	
	$errore=true;
	$messaggio=$messaggio.' - '.$msgCampoVuoto.' : '.$filtroComune.'!<br />';
	
}
if(!isset($CodiceProvincia) || trim($CodiceProvincia) =="" ){
	$CodiceProvincia="_";
	
}
if(!isset($Provincia) || trim($Provincia) =="" ){
	
	$errore=true;
	$messaggio=$messaggio.' - '.$msgCampoVuoto.' : '.$filtroProvincia.'!<br />';
	
}
if(!isset($CodiceRegione) || trim($CodiceRegione) =="" ){
	$CodiceRegione="_";
	
}
if(!isset($Regione) || trim($Regione) =="" ){
	$errore=true;	
	$messaggio=$messaggio.' - '.$msgCampoVuoto.' : '.$filtroRegione.'!<br />';
	
}
if(!isset($CodiceStato) || trim($CodiceStato) =="" ){
	$CodiceStato="_";
	
}
if(!isset($Stato) || trim($Stato) =="" ){
	$errore=true;	
	$messaggio=$messaggio.' - '.$msgCampoVuoto.' : '.$filtroStato.'!<br />';
	
}
if(!isset($Continente) || trim($Continente) =="" ){
	$errore=true;	
	$messaggio=$messaggio.' - '.$msgCampoVuoto.' : '.$filtroContinente.'!<br />';
	
}


//Verifica esistenza
//Apro la connessione al db
	include('../Connessioni/serverdb.php');
	include('../sql/script_comune.php');
	include('../sql/script.php');
	
	
	$result=findComuneByNome($Comune, $connessione);
	
//	$query="SELECT * FROM comune WHERE comune = '".$Comune."'" ;
									
//  	$result=mysql_query($query,$connessione) or die(mysql_error());  
	
	if(mysql_num_rows($result)!=0)
	{	
		//Se entro nell'if vuol dire che esiste
		$errore=true;
		$messaggio=$messaggio.' '.$msgComuneEsiste.'<br />';
	}

	$messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';
	$insCom = true;
	
	if($errore){
		//Ci sono errori quindi non salvo
		echo $messaggio;
	}else{
		//Inserisco perch� non ci sono errori
		begin();
		
		$insCom=inserisciComune($Cap, $CodiceCatastale, $CodiceIstat, $Comune, $CodiceProvincia, $Provincia, $CodiceRegione, $Regione, $CodiceStato, $Stato, $Continente, dataCorrenteInserimento());
		
/*		$query="INSERT INTO comune (cap,cod_cat,cod_istat,comune,cod_prov,provincia,cod_reg,regione,cod_stat,stato,continente,mondo,abilitato,dt_abilitato) 
				VALUES ( '".$Cap.
						"','".$CodiceCatastale.
						"','".$CodiceIstat.
						"','".$Comune.
						"','".$CodiceProvincia.
						"','".$Provincia.
						"','".$CodiceRegione.
						"','".$Regione.
						"','".$CodiceStato.
						"','".$Stato.
						"','".$Continente.
						"','Mondo',
						1,
						'".dataCorrenteInserimento()."')";
  		$result=mysql_query($query,$connessione) or die(mysql_error());  
 */	
		
		if (!$insCom) {
		
			rollback();
			echo '<div id="msgErr">'. $msgTransazioneFallita.'! '.$msgErrContactAdmin .'!</div>';
			echo '<a href="gestione_comuni.php">'.$msgTornaAiRiferimenti.'</a>';
				
		} else {
		
			commit();
			mysql_close();
			echo($msgInserimentoCompletato.' <a href="gestione_comuni.php">'.$msgTornaAiRiferimenti.'</a>');
		
			}
	}
?>
</div>
</body>
</html>
