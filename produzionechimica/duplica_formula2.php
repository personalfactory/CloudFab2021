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
include('../Connessioni/gazie.php');

$Pagina="duplica_formula2";

/*Ricalcolo il codice formula 
Estraggo le prime quattro lettere del codice CodiceFormulaNew arrivato tramite POST es KCOL*/

$LettereCodice = $_POST['CodiceFormulaNew'];

$QuattroLettere=substr($LettereCodice,0,4);
/*Seleziono dalla tabella formula il massimo codice  che corrisponde al tipo codice selezionato dall utente  ovvero $QuattroLettere
La variabile CodiceFormula � il codice della nuova formula che viene ricalcolato utilizzando CodiceFormulaNew*/
$sqlMaxCodice=mysql_query("SELECT MAX(cod_formula) AS cod_max
							FROM 
								serverdb.formula
							WHERE 
								MID(cod_formula,1,4 )='".$QuattroLettere."'")
						or die("Errore 700: " . mysql_error());
						while ($rowMaxCodice=mysql_fetch_array($sqlMaxCodice)){
							
							//Seleziono la parte numerica del codice togliendo i primi 4 caratteri
							$MaxNumCodice=substr($rowMaxCodice['cod_max'],4);
							
							}
						//Se la parte numerica del codice � <10 devo aggiungere prima uno zero	
						if(intval($MaxNumCodice)<9){
							
							$NumCodice=intval($MaxNumCodice)+1;
							$CodiceFormula=$QuattroLettere.'0'.$NumCodice;
						}
						if(intval($MaxNumCodice)>=9)	{
							
							$NumCodice=intval($MaxNumCodice)+1;
							$CodiceFormula=$QuattroLettere.$NumCodice;	
						}	
						
//Ricavo il valore dei campi tramite POST
//La variabile CodiceFormulaOld si riferisce al codice della formula da cui � partita la duplicazione e mi serve per selezionarne le quantit� di accessori e di aterie prime

$CodiceFormulaOld=$_POST['CodiceFormula'];

$DescriFormula = str_replace("'","''",$_POST['DescriFormula']);
$NumSacchetti=str_replace("'","''",$_POST['NumSacchetti']);
$QtaSacchetto = str_replace("'","''",$_POST['QtaSacchetto']);

//Ricalcolo la data corrente  
$DataFormula=dataCorrenteInserimento();

//Ricavo e ricalcolo le quantit� degli accessori singoli
$ScatolaPerLotto = str_replace("'","''",$_POST['ScatolaPerLotto']);
$EtichettaLotto = $ScatolaPerLotto;
$EtichettaChimica=$NumSacchetti*$ScatolaPerLotto;
$SacchettoPolietilene = $NumSacchetti*$ScatolaPerLotto;
$Operatore = str_replace("'","''",$_POST['Operatore']);

//Gestione degli errori

//Inizializzo l'errore relativo ai campi della tabella formula e agli accessori singoli
$errore=false; 
//Inizializzo le variabile che contano il numero di errori fatti sui campi quantita accessori e qta materia prima
$NumErroreAcc=0;
$NumErroreAccNp=0;
$NumErroreMt=0;
$NumErroreMtNp=0;

include('./include/controllo_input_formula.php');

	if($errore){
		//Ci sono errori quindi non salvo
		$messaggio = $messaggio . '<a href="javascript:history.back()">Ricontrollare i dati</a>';
		echo $messaggio;
	}else{
		//Vado avanti  perchè non ci sono errori
		//Estraggo l'elenco degli accessori presenti nella tabella accessorio_formula  
                //associati alla formula vecchia che esclusi quelli singoli
		 $NAcc = 1;
		 $messaggioQtaAcc="";
		 $sqlAccessori = mysql_query("SELECT 	
                                        accessorio_formula.accessorio,
                                        accessorio_formula.quantita,
                                        gaz_001artico.descri
                                FROM 
                                        serverdb.accessorio_formula
                                INNER JOIN 
                                        gazie.gaz_001artico 
                                ON 	
                                        accessorio_formula.accessorio=gaz_001artico.codice
                                WHERE 
                                        cod_formula='".$CodiceFormulaOld."'
                                        AND
                                                accessorio<>'scatLot'
                                        AND 
                                                accessorio<>'eticCh'
                                        AND 
                                                accessorio<>'sacCh'
                                        AND 
                                                accessorio<>'eticLot'
                                        AND 
                                                accessorio<>'OPER'
                                ORDER BY 
                                        gaz_001artico.descri") 
			 or die("Errore 701: " . mysql_error());
			while($rowAccessori=mysql_fetch_array($sqlAccessori)){
				
				//Memorizzo nelle rispettive variabili le quantit� degli accessori prese dal POST
				$QuantitaAccessorio = $_POST['QtaAcc'.$NAcc];
							
				//Controllo input quantit� accessori
				if(!is_numeric($QuantitaAccessorio)){
					$NumErroreAcc++;
					$messaggioQtaAcc=$messaggioQtaAcc."Campo Quantit� di ".$rowAccessori['descri']." deve essere di tipo numerico!<br/>";
					}
				if($QuantitaAccessorio<0){
					$NumErroreAcc++;
					$messaggioQtaAcc=$messaggioQtaAcc."Campo Quantit� di ".$rowAccessori['descri']." deve essere maggiore di zero!<br/>";
					}	
							
				$NAcc++;
			}//End While Accessori di accessori_formula
			//Effettuo il controllo sulla variabile NumErroreAcc
			if( $NumErroreAcc>0){
				$messaggioQtaAcc = $messaggioQtaAcc . '<a href="javascript:history.back()">Ricontrollare i dati</a>';
				echo $messaggioQtaAcc;
			}else{
					////////////////////////Vado avanti perch� non ci sono errori sulle quantit� di accessori
				//Visualizzo l'elenco degli accessori NON PRESENTI nella tabella accessorio_formula ma presenti su gazie
				
				$NAccNp = $NAcc; //Contatore degli accessori presenti su gazie ma non in accessori_formula
				$messaggioQtaAccNp="";
				$sqlAccessoriNp = mysql_query("SELECT descri 
												FROM 
													gazie.gaz_001artico 
												WHERE 
														catmer =4 
													AND 
														descri IS NOT NULL
													AND 
														codice IS NOT NULL
													AND 
														codice<>'scatLot'
													AND 
														codice<>'eticCh'
													AND 
														codice<>'sacCh'
													AND 
														codice<>'eticLot'
													AND 
														codice<>'OPER'
													AND 
														codice NOT IN (SELECT accessorio 
																		   FROM 
																				serverdb.accessorio_formula 
																			WHERE 
																				cod_formula='".$CodiceFormulaOld."')
												ORDER BY descri") 
						  or die("Errore 702: " . mysql_error());
			
				while($rowAccessoriNp=mysql_fetch_array($sqlAccessoriNp)){
						
						//Memorizzo nelle rispettive variabili le quantit� di accessori prese dal POST
						$QuantitaAccessorioNp = $_POST['QtaAcc'.$NAccNp];
						
						if(!is_numeric($QuantitaAccessorioNp)){
							$NumErroreAccNp++;
							$messaggioQtaAccNp=$messaggioQtaAccNp."Campo Quantit� di ".$rowAccessoriNp['descri']." deve essere di tipo numerico!<br/>";
							}
						if($QuantitaAccessorioNp<0){
							$NumErroreAccNp++;
							$messaggioQtaAccNp=$messaggioQtaAccNp."Campo Quantit� di ".$rowAccessoriNp['descri']." deve essere maggiore di zero!<br/>";
							}	
						$NAccNp++;
					}//End While Accessori di gazie
					//Effettuo il controllo sulla variabile NumErroreAcc
					if( $NumErroreAccNp>0){
						$messaggioQtaAccNp = $messaggioQtaAccNp . '<a href="javascript:history.back()">Ricontrollare i dati</a>';
						echo $messaggioQtaAccNp;
					}else{	
			
						//Estraggo l'elenco delle materie prime presenti nella generazione_formula 
						$NMatPri = 1;
						$messaggioQtaMatPri="";	
						$sqlMatPrime = mysql_query("SELECT 	
															generazione_formula.id_gen_form,
															generazione_formula.quantita,
															generazione_formula.cod_mat,
															materia_prima.descri_mat
														FROM 
															serverdb.generazione_formula 
														LEFT JOIN 
															serverdb.materia_prima 
															ON 
															generazione_formula.cod_mat=materia_prima.cod_mat
														WHERE
															cod_formula='".$CodiceFormulaOld."'
														ORDER BY descri_mat") 
										or die("Errore 703: " . mysql_error());
							while($rowMatPrime=mysql_fetch_array($sqlMatPrime)){
							
							//Memorizzo nelle rispettive variabili le quantit� di materia_prime
								
								$QuantitaMatPrima = $_POST['Qta'.$NMatPri];
																
								if(!is_numeric($QuantitaMatPrima)){
									$NumErroreMt++;
									$messaggioQtaMatPri=$messaggioQtaMatPri."Campo Quantit� di ".$rowMatPrime['descri_mat']." deve essere di tipo numerico!<br/>";
									}
								if($QuantitaMatPrima<0){
									$NumErroreMt++;
									$messaggioQtaMatPri=$messaggioQtaMatPri."Campo Quantit� di ".$rowMatPrime['descri_mat']." deve essere maggiore di zero!<br/>";
									}	
								$NMatPri++;
							}// End While finite le materie prime di generazione formula
							if($NumErroreMt>0){	
								$messaggioQtaMatPri = $messaggioQtaMatPri . '<a href="javascript:history.back()">Ricontrollare i dati</a>';											      			echo $messaggioQtaMatPri;
							}else{
	////////////////////////Vado avanti perch� non ci sono errori sulle quantit� di materie prime	
			
			
							//Estraggo l'elenco delle materie prime NON presenti nella tabella generazione_formula ma PRESENTI nella tabella materia_prima 
			
			
						$NMatPriNp = $NMatPri;
						$messaggioQtaMatPriNp="";
						$sqlMatPrimeNp = mysql_query("SELECT * FROM serverdb.materia_prima WHERE cod_mat NOT IN 
												 (SELECT 
														cod_mat
													FROM 
														serverdb.generazione_formula 
													WHERE
														cod_formula='".$CodiceFormulaOld."')
												ORDER BY descri_mat") 
						or die("Errore 704: " . mysql_error());
						while($rowMatPrimeNp=mysql_fetch_array($sqlMatPrimeNp)){
							//Memorizzo nelle rispettive variabili le quantit� di materia_prime
								
								$QuantitaMatPrimaNp = $_POST['Qta'.$NMatPriNp];
															
								if(!is_numeric($QuantitaMatPrimaNp)){
									$NumErroreMtNp++;
									$messaggioQtaMatPriNp=$messaggioQtaMatPriNp."Campo Quantit� di ".$rowMatPrimeNp['descri_mat']." deve essere di tipo numerico!<br/>";
									}
								if($QuantitaMatPrimaNp<0){
									$NumErroreMtNp++;
									$messaggioQtaMatPriNp=$messaggioQtaMatPriNp."Campo Quantit� di ".$rowMatPrimeNp['descri_mat']." deve essere maggiore di zero!<br/>";
									}	
								$NMatPriNp++;
							}// End While finite le materie prime di materia_prima
			
						if($NumErroreMtNp>0){	
							$messaggioQtaMatPriNp = $messaggioQtaMatPriNp . '<a href="javascript:history.back()">Ricontrollare i dati</a>';											      			
							echo $messaggioQtaMatPriNp;
						}else{ //Non ci sono errori Vado avanti e salvo 

					
					//Salvo nella tabella formula
					mysql_query("INSERT INTO serverdb.formula (cod_formula,descri_formula,dt_formula,num_sac,qta_sac,abilitato,dt_abilitato)
									VALUES ( 
											'".$CodiceFormula."',
											'".$DescriFormula."',
											'".dataCorrenteInserimento()."',
											'".$NumSacchetti."',
											'".$QtaSacchetto."',
											1,
											'".dataCorrenteInserimento()."')")
					or die("Errore 705 fallita: " . mysql_error());
					
					//Salvo gli accessori di accessorio formula
					$NAcc = 1;
					$sqlAccessori = mysql_query("SELECT 
													accessorio_formula.accessorio,
													accessorio_formula.quantita,
													gaz_001artico.descri
													
												FROM 
													serverdb.accessorio_formula 
												INNER JOIN 
													gazie.gaz_001artico 
												ON 	
													accessorio_formula.accessorio=gaz_001artico.codice
												WHERE 
													cod_formula='".$CodiceFormulaOld."'
												AND
													accessorio<>'scatLot'
												AND 
													accessorio<>'eticCh'
												AND 
													accessorio<>'sacCh'
												AND 
													accessorio<>'eticLot'
												AND 
													accessorio<>'OPER'
												ORDER BY gaz_001artico.descri") 
					 or die("Errore 706: " . mysql_error());
					while($rowAccessori=mysql_fetch_array($sqlAccessori)){
							
						//Memorizzo nelle rispettive variabili le quantit� di accessori
						$QuantitaAccessorio = $_POST['QtaAcc'.$NAcc];
						$SalvaQtaAcc = false;
							
						//Controllo input quantit� accessori
						if(!isset($QuantitaAccessorio)){
							$SalvaQtaAcc = false;
						}
						if(	is_numeric($QuantitaAccessorio) && $QuantitaAccessorio>0 && $QuantitaAccessorio!="" && isset($QuantitaAccessorio)){					
								$SalvaQtaAcc = true;
						}
						if($SalvaQtaAcc==true ){
							//Salvo gli accessori gi� esistenti nella tabella accessorio_formula associati al vecchio prodotto
							mysql_query("INSERT INTO serverdb.accessorio_formula 
												(cod_formula,accessorio,quantita,abilitato,dt_abilitato) 
											VALUES(
												'".$CodiceFormula."',
												'".$rowAccessori['accessorio']."',
												'".$QuantitaAccessorio."',
												1,
												'".dataCorrenteInserimento()."')")
								or die("Errore 707: " . mysql_error()); 
							}
							
						$NAcc++;
						}//End While Accessori di accessori_formula
			
						//Salvo i nuovi accessoriNp
						$NAccNp = $NAcc; //Contatore degli accessori presenti su gazie ma non in accessori_formula
						$sqlAccessoriNp = mysql_query("SELECT descri,codice 
															FROM 
																gazie.gaz_001artico 
															WHERE 
																	catmer =4 
																AND 
																	descri IS NOT NULL
																AND 
																	codice IS NOT NULL
																AND 
																	codice<>'scatLot'
																AND 
																	codice<>'eticCh'
																AND 
																	codice<>'sacCh'
																AND 
																	codice<>'eticLot'
																AND 
																	codice<>'OPER'
																AND 
																	codice NOT IN (SELECT accessorio 
																					   FROM 
																							serverdb.accessorio_formula 
																						WHERE 
																						cod_formula='".$CodiceFormulaOld."')
															ORDER BY descri") 
									  or die("Errore 708: " . mysql_error());
							while($rowAccessoriNp=mysql_fetch_array($sqlAccessoriNp)){
								//Memorizzo nelle rispettive variabili le quantit� di accessori
								$QuantitaAccessorioNp = $_POST['QtaAcc'.$NAccNp];
								$SalvaQtaAccNp = false;
													
								//Controllo input quantit� accessori
								if(!isset($QuantitaAccessorioNp)){
									$SalvaQtaAcc = false;
								}
								if(	is_numeric($QuantitaAccessorioNp) && $QuantitaAccessorioNp>0 && $QuantitaAccessorioNp!="" && isset($QuantitaAccessorioNp)){					
										$SalvaQtaAccNp = true;
									}
									if($SalvaQtaAccNp==true ){
										mysql_query("INSERT INTO serverdb.accessorio_formula 
														(cod_formula,accessorio,quantita,abilitato,dt_abilitato) 
													VALUES(
														'".$CodiceFormula."',
														'".$rowAccessoriNp['codice']."',
														'".$QuantitaAccessorioNp."',
														1,
														'".dataCorrenteInserimento()."')")
										or die("Errore 709: " . mysql_error()); 
									}
									
									$NAccNp++;
								}//End While Accessori di gazie
								//2.1 . Salvo l'accessorio ScatolaPerLotto
								mysql_query("INSERT INTO serverdb.accessorio_formula 
													(cod_formula,accessorio,quantita,abilitato,dt_abilitato) 
														VALUES(
															'".$CodiceFormula."',
															'scatLot',
															'".$ScatolaPerLotto."',
															1,
															'".dataCorrenteInserimento()."')")
								or die("Errore 710: " . mysql_error()); 
											
								//2.2 . Salvo l'accessorio EtichettaLotto
								mysql_query("INSERT INTO serverdb.accessorio_formula 
												(cod_formula,accessorio,quantita,abilitato,dt_abilitato) 
													VALUES(
															'".$CodiceFormula."',
															'eticLot',
															'".$EtichettaLotto."',
															1,
															'".dataCorrenteInserimento()."')")
								or die("Errore 711: " . mysql_error()); 
								
								//2.3 . Salvo l'accessorio EtichettaChimica
								mysql_query("INSERT INTO serverdb.accessorio_formula 
												(cod_formula,accessorio,quantita,abilitato,dt_abilitato) 
													VALUES(
															'".$CodiceFormula."',
															'eticCh',
															'".$EtichettaChimica."',
															1,
															'".dataCorrenteInserimento()."')")
								or die("Errore 712: " . mysql_error()); 
								
								//2.4 . Salvo l'accessorio SacchettoPolietilene
								mysql_query("INSERT INTO serverdb.accessorio_formula 
											(cod_formula,accessorio,quantita,abilitato,dt_abilitato) 
												VALUES(
															'".$CodiceFormula."',
															'sacCh',
															'".$SacchettoPolietilene."',
															1,
															'".dataCorrenteInserimento()."')")
								or die("Errore 713: " . mysql_error());
								
								//2.5 . Salvo l'accessorio Operatore
								mysql_query("INSERT INTO serverdb.accessorio_formula 
											(cod_formula,accessorio,quantita,abilitato,dt_abilitato) 
												VALUES(
															'".$CodiceFormula."',
															'OPER',
															'".$Operatore."',
															1,
															'".dataCorrenteInserimento()."')")
								or die("Errore 714: " . mysql_error()); 
												
								//Salvo le materie prime di generazione_formula
								//Estraggo l'elenco delle materie prime presenti nella generazione_formula 
								$NMatPri = 1;
								$sqlMatPrime = mysql_query("SELECT 	
																	generazione_formula.id_gen_form,
																	generazione_formula.quantita,
																	generazione_formula.cod_mat,
																	materia_prima.descri_mat
																FROM 
																	serverdb.generazione_formula 
																LEFT JOIN 
																	serverdb.materia_prima 
																	ON 
																	generazione_formula.cod_mat=materia_prima.cod_mat
																WHERE
																	cod_formula='".$CodiceFormulaOld."'
																ORDER BY descri_mat") 
												or die("Errore 715: " . mysql_error());
									while($rowMatPrime=mysql_fetch_array($sqlMatPrime)){
						
										//Memorizzo nelle rispettive variabili le quantit� di materia_prime
										$QuantitaMatPrima = $_POST['Qta'.$NMatPri];
										$SalvaQtaMatPrima = false;
							
										//Controllo input quantit� materie prime
										if(!isset($QuantitaMatPrima)){
											$SalvaQtaMatPrima = false;
										}
										if(	is_numeric($QuantitaMatPrima) && $QuantitaMatPrima>0 && $QuantitaMatPrima!="" && isset($QuantitaMatPrima)){					
											$SalvaQtaMatPrima = true;
										}
							
										if($SalvaQtaMatPrima==true ){
											// Salvo le quantit� nella tabella generazione formula	
											mysql_query("INSERT INTO serverdb.generazione_formula 										    														(cod_mat,																							                  											cod_formula,																																																			                                        					quantita,
															dt_inser,
															abilitato,
															dt_abilitato)
														VALUES(
																	'".$rowMatPrime['cod_mat']."',
																	'".$CodiceFormula."',
																	'".$QuantitaMatPrima."',
																	'".dataCorrenteInserimento()."',
																	1,
																	'".dataCorrenteInserimento()."')")
													or die("Errore 716: " . mysql_error());
										}
										$NMatPri++;
									}// End While finite le materie prime di generazione formula
								
								
								//Salvo le materie di materiaprima NP
								$NMatPriNp = $NMatPri;
								$sqlMatPrimeNp = mysql_query("SELECT * FROM serverdb.materia_prima 
															 	WHERE 
																	cod_mat NOT IN 
																			 (SELECT 
																					cod_mat
																				FROM 
																					serverdb.generazione_formula 
																				WHERE
																					cod_formula='".$CodiceFormulaOld."')
																			ORDER BY descri_mat") 
								or die("Errore 717: " . mysql_error());
								while($rowMatPrimeNp=mysql_fetch_array($sqlMatPrimeNp)){
									//Memorizzo nelle rispettive variabili le quantit� di materia_prime
							
									$QuantitaMatPrimaNp = $_POST['Qta'.$NMatPriNp];
									$SalvaQtaMatPrimaNp = false;
																	
									//Controllo input quantit� materie prime
									if(!isset($QuantitaMatPrimaNp)){
										$SalvaQtaMatPrimaNp = false;
									}
									if(	is_numeric($QuantitaMatPrimaNp) && $QuantitaMatPrimaNp>0 && $QuantitaMatPrimaNp!="" && isset($QuantitaMatPrimaNp)){					
										$SalvaQtaMatPrimaNp = true;
									}
							
									if($SalvaQtaMatPrimaNp==true ){
										// Inserisco per la prima volta le quantit� delle nuove mat prime nella tabella generazione formula	
										mysql_query("INSERT INTO serverdb.generazione_formula 										    													 	(cod_mat,																							                  											cod_formula,																																																			                                        					quantita,
															dt_inser,
															abilitato,
															dt_abilitato)
														VALUES(
																'".$rowMatPrimeNp['cod_mat']."',
																'".$CodiceFormula."',
																'".$QuantitaMatPrimaNp."',
																'".dataCorrenteInserimento()."',
																1,
																'".dataCorrenteInserimento()."')")
												or die("Errore 718: " . mysql_error());
									}
									$NMatPriNp++;
								}// End While finite le materie prime di materia_prima
								
								
								mysql_close();
								echo 'La formula � stata duplicata ed inserita nel Db! <br/>
								<a href="modifica_formula.php?CodiceFormula='. $CodiceFormula .'">Torna alla formula</a><br/>';
				}//End if NumerroreMtNpNumErroreAcc
			}//End if NumErroreMt
		}//End if NumErroreAccNp
	}//End if NumErroreAcc
}//End if ($errore) controllo degli input relativo alla FORMULA 



?>
</div>
</body>
</html>