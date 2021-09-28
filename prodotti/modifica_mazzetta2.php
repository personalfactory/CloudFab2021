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
include('../Connessioni/storico.php');
include('../sql/script_mazzetta.php');
include('../sql/script.php');

//Ricavo i nuovi valori mandati tramite POST
$IdMazzetta = $_POST['IdMazzetta'];
$NomeMazzetta = str_replace("'","''",$_POST['NomeMazzetta']); 
$CodiceMazzetta=str_replace("'","''",$_POST['CodiceMazzetta']);
list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);

//Gestione degli errori relativa ai nuovi dati modificati
$errore=false;
$messaggio=$msgErroreVerificato.' <br />';

if(!isset($CodiceMazzetta) || trim($CodiceMazzetta) =="" ){

	$errore=true;
	$messaggio=$messaggio.$msgCampoCodeMazzVuoto.'<br />';
}
if(!isset($NomeMazzetta) || trim($NomeMazzetta) =="" ){

	$errore=true;
	$messaggio=$messaggio.$msgCampoNomeMazzVuoto.'<br />';
	}

//Verifica esistenza 
//Verifico che non ci sia in tabella un record con gli stessi 
//valori(descrizioni) e con Id diverso da quello che si sta modificando

	/*
	$query="SELECT * FROM mazzetta 
				WHERE 
					cod_mazzetta = '".$CodiceMazzetta."' 
				AND 
					nome_mazzetta = '".$NomeMazzetta."'
				AND 
					id_mazzetta<>".$IdMazzetta;
  	$result=mysql_query($query,$connessione) or die(" Errore: 120 ".mysql_error());  
  	*/
 	$result = findMazzettaByCodAndNameAndID($IdMazzetta, $CodiceMazzetta, $NomeMazzetta);
  	
	if(mysql_num_rows($result)!=0)
	{	
		//Se entro nell'if vuol dire che il valore inserito esiste gi� nel db
		$errore=true;
		$messaggio=$messaggio.$msgDuplicaRecord.'<br />';
	}
	$messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';
	
	if($errore){
		//Ci sono errori quindi non salvo
		echo $messaggio;
	} else {
//Inserisco il vecchio record nello storico di [mazzetta] prima
// di modificarlo nella tabella corrente su serverdb
		
		begin();
		
		$insStoMazz = true;
		$insStoMazzCol = true;
		$sqlMazCol = true;
		$updateMazz = true;
		
		$insStoMazz = insertStoricoMazzetta($IdMazzetta);
	/*	
		mysql_query("INSERT INTO storico.mazzetta 						 										
				(id_mazzetta,cod_mazzetta,nome_mazzetta,abilitato,dt_abilitato) 
					SELECT 
						id_mazzetta,
						cod_mazzetta,
						nome_mazzetta,
						abilitato,
						dt_abilitato
					FROM 
						serverdb.mazzetta
					WHERE
						id_mazzetta='".$IdMazzetta."'") 
					  
		or die("Query fallita: " . mysql_error());
	*/	
// Seleziono ora i vecchi record presenti nella tabella [mazzetta_colorata] relativi all'�id_mazzetta� da modificare;
	
	$sqlMazCol = selectOldRecordMazzettaColorata($IdMazzetta);
	/*
	$sqlMazCol = mysql_query("SELECT   
                                    mazzetta_colorata.id_maz_col,
                                    mazzetta_colorata.id_mazzetta,
                                    mazzetta_colorata.id_colore,
                                    mazzetta_colorata.id_colore_base,
                                    mazzetta_colorata.quantita,
                                    mazzetta_colorata.dt_abilitato								
                            FROM 
                                    serverdb.mazzetta_colorata 
                            WHERE 
                                    id_mazzetta=".$IdMazzetta) 
		or die("Query fallita: " . mysql_error());
*/
		while($rowMazCol=mysql_fetch_array($sqlMazCol))
		{
			$IdMazzettaCol=$rowMazCol['id_maz_col'];
			$IdColore=$rowMazCol['id_colore'];
			$IdColoreBase=$rowMazCol['id_colore_base'];
			$Quantita=$rowMazCol['quantita'];
			$DataAbilitato=$rowMazCol['dt_abilitato'];


// Inserisco i vecchi record appena selezionati nello storico della tabella [mazzetta_colorata];
	/*	mysql_query("INSERT INTO storico.mazzetta_colorata 	
								(id_maz_col,id_mazzetta,id_colore,id_colore_base,quantita,dt_abilitato)
							VALUES(
								   ".$IdMazzettaCol.",
									".$IdMazzetta.",
									".$IdColore.",
									".$IdColoreBase.",
									".$Quantita.",
									'".$DataAbilitato."')")
			or die("Errore 122 : " . mysql_error());
		*/	
			
			$insStoMazzCol = insertStoricoMazzettaColorata($IdMazzettaCol, $IdMazzetta, $IdColore, $IdColoreBase, $Quantita, $DataAbilitato);
		}
	//########################QUI MI DA ERRORE##############################################
		
		

//Modifico il record nella tabella corrente [mazzetta] di serverdb
	/*	mysql_query("UPDATE serverdb.mazzetta 
						SET 
                                                 cod_mazzetta=if(cod_mazzetta!=".$CodiceMazzetta.",".$CodiceMazzetta.",cod_mazzetta),
                                                 nome_mazzetta=if(nome_mazzetta!=".$NomeMazzetta.",".$NomeMazzetta.",nome_mazzetta)
							
						WHERE 
							id_mazzetta='".$IdMazzetta."'")
		or die("Query fallita: " . mysql_error());

		*/
		$updateMazz = updateMazzetta($IdMazzetta, $CodiceMazzetta, $NomeMazzetta, $IdAzienda);
	
		
		if (!$insStoMazz || !$insStoMazzCol || !$updateMazz) {
		
			rollback();
			echo '<div id="msgErr">'. $msgTransazioneFallita.'! '.$msgErrContactAdmin .'!</div>';
			echo ' <a href="gestione_mazzette_colorate.php"> '.$msgTornaAlleMazzette.'</a>';
				
		} else {
		
			commit();
			mysql_close();
			echo($msgModificaCompletata.'! <a href="gestione_mazzette_colorate.php"> '.$msgTornaAlleMazzette.'</a>');
					
		}

	}
?>