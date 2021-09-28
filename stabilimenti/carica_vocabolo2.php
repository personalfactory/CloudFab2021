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


//Ricavo l'id del tipo di dizionario scelto
$TipoDizionario = $_POST['scegli_dizionario'];

//Gestione degli errori
//Verifico che il tipo dizionario sia stato settato e che non sia vuoto

$errore=false;
$messaggio='Si sono verificati degli errori:<br />';

if(!isset($TipoDizionario) || trim($TipoDizionario) =="" ){

	$errore=true;
	$messaggio=$messaggio.' - Campo Tipo Dizionario vuoto!<br />';

}

$messaggio = $messaggio . '<a href="javascript:history.back()">Ricontrollare i dati</a>';

if($errore){
	//Ci sono errori quindi non salvo
	echo $messaggio;
}else{
		$SalvaVocabolo=false;
		//Estraggo l'id_lingua corrispondente all'italiano per inserire nel dizionario i vocaboli in italiano
		include('../Connessioni/serverdb.php');
		$sqlIdItaliano = mysql_query("SELECT id_lingua FROM lingua 
							  			WHERE 
											lingua='Italiano'") 
               			or die("Errore 65: " . mysql_error());
        while($rowIdItaliano=mysql_fetch_array($sqlIdItaliano)){
           		$IdItaliano = $rowIdItaliano['id_lingua'];
		}
		
		//Se il tipo dizionario � il codice prodotto	
		if($TipoDizionario=="CodiceProdotto"){
				$IdVocabolo = $_POST['CodiceProdotto'];
				
				//Estraggo l'id_diz_tipo corrispondente al tipo di dizionario selezionato
				$sqlDizTipo = mysql_query("SELECT id_diz_tipo FROM dizionario_tipo 
												WHERE 
													dizionario_tipo='CodiceProdotto'") 
								or die("Errore 30: " . mysql_error());
				while($rowIdDizTipo=mysql_fetch_array($sqlDizTipo)){
						$IdDizTipo = $rowIdDizTipo['id_diz_tipo'];
				}
				
				//Estraggo il codice prodotto corrispondente all'id_prodotto arrivato tramite POST
				//E' il vocabolo da inserire nel dizionario dove la lingua � Italiano
				$sqlCodProdotto = mysql_query("SELECT cod_prodotto FROM prodotto 
												WHERE 
													id_prodotto=".$IdVocabolo) 
								or die("Errore 65: " . mysql_error());
				
		}//End if codice prodotto
		
		//Se il tipo dizionario � la descrizione del codice
		else if($TipoDizionario=="DescriCodiceProdotto"){
				$IdVocabolo = $_POST['DescriCodiceProdotto'];
				
				//Estraggo l'id corrispondente al tipo di dizionario nome componente
				$sqlDizTipo = mysql_query("SELECT id_diz_tipo FROM dizionario_tipo 
												WHERE 
													dizionario_tipo='DescriCodiceProdotto'") 
								or die("Errore 31: " . mysql_error());
				while($rowIdDizTipo=mysql_fetch_array($sqlDizTipo)){
						$IdDizTipo = $rowIdDizTipo['id_diz_tipo'];
				}
				//Estraggo la descrizione del codice corrispondente all'id arrivato tramite POST
				//E' il vocabolo da inserire nel dizionario dove la lingua � Italiano
				$sqlCodice = mysql_query("SELECT descrizione FROM codice 
												WHERE 
													id_codice=".$IdVocabolo) 
								or die("Errore 65: " . mysql_error());
				while($rowCodice=mysql_fetch_array($sqlCodice)){
						$Vocabolo = $rowCodice['descrizione'];
						}
		}//End if descrizione codice
		
		//Se il tipo dizionario � il nome componente 
		else if($TipoDizionario=="NomeComponente"){
				$IdVocabolo = $_POST['NomeComponente'];
				
				//Estraggo l'id corrispondente al tipo di dizionario nome componente
				$sqlDizTipo = mysql_query("SELECT id_diz_tipo FROM dizionario_tipo 
												WHERE 
													dizionario_tipo='NomeComponente'") 
								or die("Errore 31: " . mysql_error());
				while($rowIdDizTipo=mysql_fetch_array($sqlDizTipo)){
						$IdDizTipo = $rowIdDizTipo['id_diz_tipo'];
				}
				//Estraggo la descrizione del componente corrispondente all'id arrivato tramite POST
				//E' il vocabolo da inserire nel dizionario dove la lingua � Italiano
				$sqlComponente = mysql_query("SELECT descri_comp FROM parametro_comp_prod 
												WHERE 
													id_par_comp=".$IdVocabolo) 
								or die("Errore 65: " . mysql_error());
				while($rowComponente=mysql_fetch_array($sqlComponente)){
						$Vocabolo = $rowComponente['descri_comp'];
						}
		}//End if nome componente
		
	//Se il tipo dizionario � nome colore base	
	else if($TipoDizionario=="NomeColoreBase"){
				$IdVocabolo = $_POST['NomeColoreBase'];
				
				//Estraggo l'id corrispondente al tipo di dizionario nome colore base
				$sqlDizTipo = mysql_query("SELECT id_diz_tipo FROM dizionario_tipo 
												WHERE 
													dizionario_tipo='NomeColoreBase'") 
								or die("Errore 32: " . mysql_error());
				while($rowIdDizTipo=mysql_fetch_array($sqlDizTipo)){
						$IdDizTipo = $rowIdDizTipo['id_diz_tipo'];
				}
				//Estraggo il nome del colore base corrispondente all'id arrivato tramite POST
				//E' il vocabolo da inserire nel dizionario dove la lingua � Italiano
				$sqlColoreBase = mysql_query("SELECT nome_colore_base FROM colore_base 
												WHERE 
													id_colore_base=".$IdVocabolo) 
								or die("Errore 65: " . mysql_error());
				while($rowColoreBase=mysql_fetch_array($sqlColoreBase)){
						$Vocabolo = $rowColoreBase['nome_colore_base'];
						}
		}//End if colore base
	//Se il tipo dizionario � messaggio macchina	
	else if($TipoDizionario=="MessaggioMacchina"){
				$IdVocabolo = $_POST['MessaggioMacchina'];
				
				//Estraggo l'id corrispondente al tipo di dizionario messaggio macchina
				include('../Connessioni/serverdb.php');
				$sqlDizTipo = mysql_query("SELECT id_diz_tipo FROM dizionario_tipo 
												WHERE 
													dizionario_tipo='MessaggioMacchina'") 
								or die("Errore 33: " . mysql_error());
				while($rowIdDizTipo=mysql_fetch_array($sqlDizTipo)){
						$IdDizTipo = $rowIdDizTipo['id_diz_tipo'];
				}
				//Estraggo il messaggio corrispondente all'id arrivato tramite POST
				//E' il vocabolo da inserire nel dizionario dove la lingua � Italiano
				$sqlMessaggio = mysql_query("SELECT messaggio FROM messaggio_macchina 
												WHERE 
													id_messaggio=".$IdVocabolo) 
								or die("Errore 65: " . mysql_error());
				while($rowMessaggio=mysql_fetch_array($sqlMessaggio)){
						$Vocabolo = $rowMessaggio['messaggio'];
						}
	}//End if messaggio macchina

	//Ho ottenuto cos� un IdVocabolo, un Vocabolo ed un IdDizTipo	
	
	//Verifica esistenza
	$errore2=false;
	$errorelingua=false;
	$messaggio2="";
	
	/*controllare $queryDizionario="SELECT * FROM dizionario WHERE id_diz_tipo = '".$IdDizTipo."' AND (vocabolo = '".$Vocabolo."' OR id_vocabolo='".$IdVocabolo."')";
  	$result=mysql_query($queryDizionario,$connessione) or die("Errore 119 :" .mysql_error());  
	
	if(mysql_num_rows($result)!=0)
	{	
		//Se entro nell'if vuol dire che esiste
		$errore2=true;
		$messaggio2=$messaggio2.' - Il vocabolo � gi� presente nel dizionario!<br />';
	}*/
	if($errore2){
		echo $messaggio2;
	}else {
	//Se si effettua l'aggiornamento non serve 
	//Inserisco nel dizionario prima il vocabolo in italiano
		/*	mysql_query("INSERT INTO dizionario 
											(
												id_diz_tipo,
												id_lingua,
												id_vocabolo,
												vocabolo,
												abilitato,
												dt_abilitato)
											VALUES(
													".$IdDizTipo.",
													".$IdItaliano.",
													".$IdVocabolo.",
													'".$Vocabolo."',
													1,
											'".dataCorrenteInserimento()."')")
			or die("Errore 70: " . mysql_error());*/
			
			$NLin=1;
			$sqlLingua = mysql_query("SELECT * FROM lingua 
										  	WHERE 
												lingua<>'Italiano'
										  	ORDER BY 
												lingua") 
                 	or die("Errore 68: " . mysql_error());
            while($rowLingua=mysql_fetch_array($sqlLingua)){
                
					//$errorelingua=false;
					$VocaboloLingua = $_POST['Lingua'.$NLin];
				
					//Controllo degli input vocaboli
					if(!isset($VocaboloLingua) || trim($VocaboloLingua) =="" ){
						
							$errorelingua=true;
							$messaggio=$messaggio." Campo Lingua ".$row['lingua']." vuoto!<br />";
					
					}
					//Verifica esistenza
					$query="SELECT * FROM dizionario 
							WHERE 
								vocabolo = '".$VocaboloLingua."' 
							AND 
								id_lingua=".$rowLingua['id_lingua'];
					$result=mysql_query($query,$connessione) or die("Errore 69: " . mysql_error());
		
					if(mysql_num_rows($result)!=0)
					{	
					//Se entro nell'if vuol dire che il valore inserito esiste gi� nel db
						$errorelingua=true;
						$messaggio=$messaggio.' - Si sta tendando di duplicare un record!<br />';
					}
					
					if($errorelingua){
					//Ci sono errori quindi non salvo e visualizzo il messaggio di errore
						echo $messaggio;
						break;//Esco dal while altrimenti la variabile $errorelingua torna ad essere false
					}else{// Non ci sono errori quindi posso andare avanti
					
												
						//Inserisco la traduzione dei vocaboli in tutte le lingue
						mysql_query("INSERT INTO dizionario 
										(
											id_diz_tipo,
											id_lingua,
											id_vocabolo,
											vocabolo,
											abilitato,
											dt_abilitato)
										VALUES(
												".$IdDizTipo.",
												".$rowLingua['id_lingua'].",
												".$IdVocabolo.",
												'".$VocaboloLingua."',
												1,
												'".dataCorrenteInserimento()."')")
								or die("Errore 71: " . mysql_error());
						
							}//fine  if($errore) interno: controllo degli input quantit� e presa
					
					$NLin++;
					}// End while finiti le lingue
		
		mysql_close();	
}
if($errore==false && $errorelingua==false){			
echo 'Modifica completata con successo! <a href="gestione_dizionario.php">Torna alla gestione del dizionario</a>';
	}
}//end if errore2
?>

</div>
</body>
</html>
