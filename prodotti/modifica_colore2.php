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

//Ricavo i nuovi valori dei campi mandati tramite POST
$IdColore = $_POST['IdColore'];
$CodiceColore = $_POST['CodiceColore'];
$NomeColore = str_replace("'","''",$_POST['NomeColore']); 
list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);
//############ Gestione degli errori sulle query ###############################
$insertStoricoColore = true;
$updateServerdbColore = true;

//############ Gestione degli errori relativa ai nuovi dati modificati #########
//Verifico che i nuovi valori siano stati settati e non nulli
$errore=false;
$messaggio=$msgErroreVerificato.' <br />';


if(!isset($NomeColore) || trim($NomeColore) =="" ){

	$errore=true;
	$messaggio=$messaggio.$msgCampoNomeColVuoto.'!<br />';
}
if(!isset($CodiceColore) || trim($CodiceColore) =="" ){

	$errore=true;
	$messaggio=$messaggio.$msgCampoColVuoto.'!<br />';
}

//Verifica esistenza 
//Verifico che non ci sia in tabella un record con gli stessi valori
//(descrizioni) e con Id diverso da quello che si sta modificando
include('../Connessioni/serverdb.php');
include('../sql/script_colore.php');

	$result = findColoreByCodiceAndName($IdColore, $NomeColore, $CodiceColore, $connessione);
/*
	$query="SELECT * FROM colore 
				WHERE 
					cod_colore = '".$CodiceColore."' 
				AND 
					nome_colore = '".$NomeColore."'
				AND 
					id_colore<>".$IdColore;
  	$result=mysql_query($query,$connessione) or die(" Errore: 120 ".mysql_error());  
*/	
  		if(mysql_num_rows($result)!=0)
	{	
		//Se entro nell'if vuol dire che esiste
		$errore=true;
		$messaggio=$messaggio.$msgDuplicaRecord.'!<br />';
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
		include('../sql/script.php');
                
//##################### INIZIO TRANSAZIONE #####################################              
        begin();

        $insertStoricoColore = insertStoricoColore($IdColore);
        
////NON SERVE STORICIZZARE LA MAZZETTA COLORATA !!!!!!!!!!!!!!!!!!!!!!!!!!
//Seleziono ora i vecchi record presenti nella tabella 
////[mazzetta_colorata] relativi all'id_colore da modificare;
//
//                $sqlMazCol = mysql_query("SELECT   
//                                                mazzetta_colorata.id_maz_col,
//                                                mazzetta_colorata.id_mazzetta,
//                                                mazzetta_colorata.id_colore_base,
//                                                mazzetta_colorata.quantita,
//                                                mazzetta_colorata.dt_abilitato								
//                                        FROM 
//                                                serverdb.mazzetta_colorata 
//                                        WHERE 
//                                                id_colore=".$IdColore) 
//		or die("ERRORE SELECT FROM serverdb.mazzetta_colorata : " . mysql_error());
//
//		while($rowMazCol=mysql_fetch_array($sqlMazCol))
//		{
//			$IdMazzettaCol=$rowMazCol['id_maz_col'];
//			$IdMazzetta=$rowMazCol['id_mazzetta'];
//			$IdColoreBase=$rowMazCol['id_colore_base'];
//			$Quantita=$rowMazCol['quantita'];
//			$DataAbilitato=$rowMazCol['dt_abilitato'];
//
//
//// Inserisco i vecchi record appena selezionati nello storico della tabella [mazzetta_colorata];
//			$insertStoricoMazCol = mysql_query("INSERT INTO storico.mazzetta_colorata 	
//								(id_maz_col,id_mazzetta,id_colore,id_colore_base,quantita,dt_abilitato)
//							VALUES(
//								   ".$IdMazzettaCol.",
//									".$IdMazzetta.",
//									".$IdColore.",
//									".$IdColoreBase.",
//									".$Quantita.",
//									'".$DataAbilitato."')")
//			or die("Errore 122 : " . mysql_error());
//			
//				}

//Modifico il record nella tabella corrente [colore] di serverdb, salvando i nuovi valori dei campi mandati tramite POST e aggiornando il campo �dt_abilitato � con data corrente.
		
        $updateServerdbColore = updateServerDBColore($IdColore, $NomeColore, $CodiceColore,$IdAzienda);
		
	
		if (!$updateServerdbColore
                        OR 
                        !$insertStoricoColore) {

                    rollback();
                    echo $msgTransazioneFallita.'! '.$msgErrContattareAdmin.'!';
                    
//                    echo "<br/>updateServerdbColore " . $updateServerdbColore;
//                    echo "<br/>insertStoricoColore " . $insertStoricoColore;
                    
                } else {

                    commit();
                    mysql_close();

                    ?>
                   <script language="javascript">
                        window.location.href="gestione_colori.php";
                    </script>
  <?php              }
	}
?>

    </div>
</body>
</html>