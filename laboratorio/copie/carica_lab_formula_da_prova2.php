<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
<body>
<div id="mainContainer">

    <?php 
    
    ///////////////// DA SISTEMARE !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    
    
include('../include/menu.php'); 
include('../include/precisione.php');
include('../include/gestione_date.php');
include('../Connessioni/serverdb.php');
include('sql/script.php');
include('sql/script_lab_formula.php');
include('sql/script_lab_risultato_matpri.php');
include('sql/script_lab_risultato_par.php');


 
//########################################################################################
//######################### GESTIONE DEGLI ERRORI ########################################
//########################################################################################
//Inizializzo l'errore relativo ai campi della tabella lab_formula
$errore=false; 
//Inizializzo le variabili che contano il numero di errori fatti sulle quantita di materia prima e di parametri
$NumErroreMt=0;
$NumErroreComp=0;
$NumErrorePar=0;
$NumErroreAcqua=0;

$ErroreEsisteFormula=false;//errore relativo all'esistenza della composizione della formula

$messaggio='';
		if(!isset($_POST['CodiceFormula']) || trim($_POST['CodiceFormula']) =="" ){
		
			$errore=true;
			$messaggio=$messaggio.' - Campo Codice Formula vuoto!<br />';
		
		}
		if(!isset($_POST['IdEsperimento']) || trim($_POST['IdEsperimento']) =="" ){
		
			$errore=true;
			$messaggio=$messaggio.' - Campo IdEsperimento vuoto!<br />';
		
		}
		if(!isset($_POST['NumeroEsperimento'])|| trim($_POST['NumeroEsperimento'])==""){
			$errore=true;
			$messaggio=$messaggio.' - Aggiornare la pagina prima di salvare!<br />';
		}
		//Verifica esistenza caricamento formula Non serve			
		
	if($errore){
		//Ci sono errori quindi non salvo
		$messaggio = $messaggio . '<a href="javascript:history.back()">Ricontrollare i dati</a>';
		echo $messaggio;
	}else{
		//Vado avanti perche non ci sono errori
		
		//Ricavo il valore dei campi tramite POST
		$CodiceFormula = str_replace("'","''",$_POST['CodiceFormula']);
		$NumeroEsperimento = str_replace("'","''",$_POST['NumeroEsperimento']);
		$IdEsperimento = str_replace("'","''",$_POST['IdEsperimento']);
                $Normativa = str_replace("'", "''", $_POST['Normativa']);
                $ProdOb = str_replace("'", "''", $_POST['ProdOb']);
				
		//Ricalcolo la data corrente  
		$DataFormula=dataCorrenteInserimento();
		
		///////////////////Controllo input materie prime////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////////////////
		$NMatPri = 1;
		$messaggioQtaMatPri="";
		$sqlMatPrime = findMatPriByEsperUnionAll($IdEsperimento);
                       
		while($rowMatPrime=mysql_fetch_array($sqlMatPrime)){
			
			//Memorizzo nelle rispettive variabili le quantit- di materia_prime
			$QuantitaMatPrima = $_POST['QtaMt'.$NMatPri];
												
			//Controllo input quantit- materie prime
			if(!is_numeric($QuantitaMatPrima) && $QuantitaMatPrima!=""){
				$NumErroreMt++;
				$messaggioQtaMatPri=$messaggioQtaMatPri."Campo Quantit- di ".$rowMatPrime['descri_materia']."deve essere di tipo numerico!<br/>";
			}
			if($QuantitaMatPrima<0){
				$NumErroreMt++;
				$messaggioQtaMatPri=$messaggioQtaMatPri."Campo Quantit- di ".$rowMatPrime['descri_materia']."deve essere maggiore di zero!<br/>";
			}	
							
			$NMatPri++;
		}// End While finite le materie prime 
		if($NumErroreMt>0){	
			$messaggioQtaMatPri = $messaggioQtaMatPri . '<a href="javascript:history.back()">Ricontrollare i dati</a>';																							      		echo $messaggioQtaMatPri;
		}else{
		
		
		//////////////////////Controllo input componenti prodotto/////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////
		$NComp = 1;
		$messaggioQtaComp="";
		$sqlComp = findCompByEsperUnionAll($IdEsperimento);
                      
		while($rowComp=mysql_fetch_array($sqlComp)){
			
			//Memorizzo nelle rispettive variabili le quantit- di materia_prime
			$QuantitaComp = $_POST['QtaComp'.$NComp];
												
			//Controllo input quantit- materie prime
			if(!is_numeric($QuantitaComp) && $QuantitaComp!=""){
				$NumErroreComp++;
				$messaggioQtaComp=$messaggioQtaComp."Campo Quantit- di ".$rowComp['descri_materia']."deve essere di tipo numerico!<br/>";
			}
			if($QuantitaComp<0){
				$NumErroreComp++;
				$messaggioQtaComp=$messaggioQtaComp."Campo Quantit- di ".$rowComp['descri_materia']."deve essere maggiore di zero!<br/>";
			}	
							
			$NComp++;
		}// End While finiti i componenti 
		if($NumErroreComp>0){	
			$messaggioQtaComp = $messaggioQtaComp . '<a href="javascript:history.back()">Ricontrollare i dati</a>';																							      		echo $messaggioQtaComp;
		}else{
			
			////////////////////////////Controllo input parametri/////////////////////////////////////
			//////////////////////////////////////////////////////////////////////////////////////////
			//Estraggo l'elenco dei parametri presenti nella tabella lab_parametro
			$NPar = 1;
			$messaggioQtaPar="";
		 	$sqlPar =findRisParByIdEspTipoUnionAll($IdEsperimento, $PercentualeNO); 
                                //e_parametro NOT LIKE '%acqua%')
								
			while($rowPar=mysql_fetch_array($sqlPar)){
			
				//Memorizzo nelle rispettive variabili le quantit- di materia_prime
				$QuantitaParametro = $_POST['QtaPar'.$NPar];
												
				//Controllo input quantit- parametri
				if(!is_numeric($QuantitaParametro) && $QuantitaParametro!=""){
					$NumErrorePar++;
					$messaggioQtaPar=$messaggioQtaPar."Campo Quantit- di ".$rowPar['nome_parametro']."deve essere di tipo numerico!<br/>";
				}
				if($QuantitaParametro<0){
					$NumErrorePar++;
					$messaggioQtaPar=$messaggioQtaPar."Campo Quantit- di ".$rowPar['nome_parametro']."deve essere maggiore di zero!<br/>";
				}	
							
			$NPar++;
			}// End While finiti i parametri
			
			if($NumErrorePar>0){	
				$messaggioQtaPar = $messaggioQtaPar . '<a href="javascript:history.back()">Ricontrollare i dati</a>';																							      			echo $messaggioQtaPar;
			}else{
	////////////////////////Vado avanti perch- non ci sono errori sulle quantit- di materie prime e parametri				
	
	///////////////////////////Controllo input ACQUA/////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////
	
				//Estraggo l'elenco dei parametri relativi all'acqua presenti nella tabella lab_parametro
				$messaggioQtaAc="";
		 		$NParAc = 1;
		 		$sqlParAc = findRisParByIdEspTipoUnionAll($IdEsperimento, $PercentualeSI);
				while($rowParAc=mysql_fetch_array($sqlParAc)){
					//Memorizzo nelle rispettive variabili le quantit- di materia_prime
					$QuantitaPercAcqua = $_POST['QtaPercAc'.$NParAc];
												
					//Controllo input quantit- parametri
					if(!is_numeric($QuantitaPercAcqua) && $QuantitaPercAcqua!=""){
						$NumErroreAcqua++;
						$messaggioQtaAc=$messaggioQtaAc."Campo Quantit- di ".$rowPar['nome_parametro']."deve essere di tipo numerico!<br/>";
					}
					if($QuantitaPercAcqua<0){
						$NumErroreAcqua++;
						$messaggioQtaAc=$messaggioQtaAc."Campo Quantit- di ".$rowPar['nome_parametro']."deve essere maggiore di zero!<br/>";
					}	
							
				$NParAc++;
			}// End While finiti i parametri ACQUA 
			
			if($NumErroreAcqua>0){	
				$messaggioQtaAc = $messaggioQtaAc . '<a href="javascript:history.back()">Ricontrollare i dati</a>';																							      			echo $messaggioQtaAc;
			}else{
				
			
			////////////////////////Controllo Esistenza Composizione Formula/////////////////////////////////
			/////////////////////////////////////////////////////////////////////////////////////////////////
			
			//Costruzione del codice esistenza della formula corrente con i codici delle materie prime e le loro quantit- percentuali
 			$CodiceEsistenza="";
			$messaggioEsisteFormula="";		
			$NMatPri = 1;
			global $i;//Conta le materie prime
			$i=0;
			mysql_data_seek($sqlMatPrime,0);
				while($rowMatPrime=mysql_fetch_array($sqlMatPrime)){
					
					//Costruisco tante stringhe quante sono le materie prime della formula
					//Ciascuna stringa - cos- strutturata :    cod_mat . "=" . QtaPerc . ";"
					
					if((isset($_POST['QtaPercMt'.$NMatPri]) && $_POST['QtaPercMt'.$NMatPri]!="" && $_POST['QtaPercMt'.$NMatPri]>0 )|| isset($_POST['MatKeVaria'.$NMatPri])){
												
						$ArrayMaterieQta[$i] = $rowMatPrime['cod_mat']."=".$_POST['QtaPercMt'.$NMatPri].";";
																							
						$i++;
					}
					
				$NMatPri++;
			}// End While finite le materie prime 
			
			$NComp = 1;
			global $k;//Conta i componenti
			$k=0;

			mysql_data_seek($sqlComp, 0);
				while($rowComp=mysql_fetch_array($sqlComp)){
					
					//Costruisco tante stringhe quante sono le materie prime della formula
					//Ciascuna stringa - cos- strutturata :    cod_mat . "=" . QtaPerc . ";"
					
					if((isset($_POST['QtaPercComp'.$NComp]) && $_POST['QtaPercComp'.$NComp]!="" && $_POST['QtaPercComp'.$NComp]>0) ||isset($_POST['CompKeVaria'.$NComp])){
												
						$ArrayComp[$k] = $rowComp['cod_mat']."=".$_POST['QtaPercComp'.$NComp].";";
																							
						$k++;
					}
					
				$NComp++;
			}// End While finite le materie prime 			
			
			$ArrayTot=array_merge($ArrayMaterieQta,$ArrayComp);
			//Ordino gli elementi dell'array secondo l' ordine alfabetico del cod mat
			sort($ArrayTot);
			
			$CodiceEsistenza="";			
			
			//Costruisco il codice esistenza della formula concatenando le stringhe ordinate in ordine alfabetico 
			for($j=0;$j<$i+$k;$j++)
			{
				$CodiceEsistenza=$CodiceEsistenza.$ArrayTot[$j];
			}
			
			
			//Verifica esistenza del codice esistenza
			$sqlCodEsistenza = findFormuleAllByUtente($_SESSION['username'],$_SESSION['nome_gruppo_utente']);
                          
			
			while($rowCodEsistenza=mysql_fetch_array($sqlCodEsistenza)){		
			
				if( $rowCodEsistenza['cod_esistenza']==$CodiceEsistenza ){
					$ErroreEsisteFormula=true;
					$messaggioEsisteFormula="Le stesse quantita di materie prime sono associate alla formula " .$rowCodEsistenza['cod_lab_formula']." !<br/>";
				}	
			}
			
			if($ErroreEsisteFormula){	
				$messaggioEsisteFormula = $messaggioEsisteFormula . '<a href="javascript:history.back()">Ricontrollare i dati</a>';																							      		
				echo $messaggioEsisteFormula;
			}else{
				
//////////////Fine controllo esistenza formula
				
//############################################################################################################
//############################## SALVATAGGIO NEL DB ##########################################################
//############################################################################################################
			$erroreTrasazione=false;
                            $insertFormula=true;	
                            begin();
                            
////////////////////////Se sono arrivata fin qui vuol dire che non si sono verificati errori di nessun genere quindi posso salvare			
				// 1 . Salvo nella tabella lab_formula
			$insertFormula=salvaFormula($CodiceFormula,dataCorrenteInserimento(),$ProdOb,$Normativa,$CodiceEsistenza,
                                $_SESSION['username'],$_SESSION['nome_gruppo_utente']);		
                           
				
				//Estraggo l'elenco delle materie prime presenti nella tabella lab_risultato_matpri
				$NMatPri = 1;
				mysql_data_seek($sqlMatPrime, 0);
				while($rowMatPrime=mysql_fetch_array($sqlMatPrime)){
			
					//Memorizzo nelle rispettive variabili le quantit- di materia_prime
					$QuantitaMatPrima = $_POST['QtaMt'.$NMatPri];
					$QuantitaPercMatPrima = $_POST['QtaPercMt'.$NMatPri];
					$SalvaQtaMatPrima = false;
													
					
					if(!isset($QuantitaMatPrima)){
						$SalvaQtaMatPrima = false;
					}
					if(	is_numeric($QuantitaMatPrima) && $QuantitaMatPrima>0 && $QuantitaMatPrima!="" && isset($QuantitaMatPrima)){					
						$SalvaQtaMatPrima = true;
					}
				
					if($SalvaQtaMatPrima==true ){
						// Salvo le quantit- nella tabella lab_matpri_teoria
						
					                                mysql_query("INSERT INTO lab_matpri_teoria 					  		       	 			                               (id_mat,cod_lab_formula,dt_inser,qta_teo,qta_teo_perc)
								VALUES ( 
                                                                        '".$rowMatPrime['id_mat']."',
                                                                        '".$CodiceFormula."',
                                                                        '".dataCorrenteInserimento()."',
                                                                        '".$QuantitaMatPrima."',
                                                                        '".$QuantitaPercMatPrima."')")
							or die("Errore 309: " . mysql_error());
					}
					//Salvo le materie prime oggetto  di variazione selezionate tramite checkbox con qta=0
                     if(isset($_POST['MatKeVaria'.$NMatPri]))
                     {
                            $MatKeVaria=$_POST['MatKeVaria'.$NMatPri];
							
							mysql_query("INSERT INTO lab_matpri_teoria 					  		       	 			                               (id_mat,cod_lab_formula,dt_inser,qta_teo,qta_teo_perc)
								VALUES ( 
											'".$rowMatPrime['id_mat']."',
											'".$CodiceFormula."',
											'".dataCorrenteInserimento()."',
											'0',
											'0')")
							or die("Errore 310: " . mysql_error());
                            
					 }
										
			$NMatPri++;
			}// End While finite le materie prime 
			
			//Estraggo l'elenco dei componenti prodotto presenti nella tabella lab_risultato_matpri
				$NComp = 1;
				$sqlComp = mysql_query("( SELECT
									lab_risultato_matpri. id_mat,
									lab_risultato_matpri.id_esperimento, 
									lab_risultato_matpri.qta_reale AS qta_reale,
									lab_materie_prime.descri_materia AS descri_materia,
									lab_materie_prime.cod_mat,
									lab_materie_prime.unita_misura,
									lab_materie_prime.prezzo
								   FROM 
									  serverdb.lab_risultato_matpri 
								   INNER JOIN 
									  serverdb.lab_materie_prime 
								  ON 
									  lab_risultato_matpri.id_mat = lab_materie_prime.id_mat  
								  WHERE 
									  cod_mat LIKE 'comp%' 
									 AND 
									  id_esperimento = '".$IdEsperimento."' )

									UNION

								  ( SELECT
										  lab_materie_prime.id_mat,
										  null,
										  null,
										  lab_materie_prime.descri_materia AS descri_materia,
										  lab_materie_prime.cod_mat,
										  lab_materie_prime.unita_misura,
										  lab_materie_prime.prezzo
									  FROM
										  serverdb.lab_materie_prime
									  WHERE
											  lab_materie_prime.cod_mat LIKE 'comp%'
										  AND 
											  lab_materie_prime.id_mat NOT IN 
																	  ( SELECT	id_mat			                        													
																		  FROM
																			  lab_risultato_matpri
																		  WHERE																			
																			  id_esperimento = '".$IdEsperimento."' )
								  )															
									ORDER BY  (qta_reale>=0 )=true DESC, descri_materia;	") 
						or die("Errore 311: " . mysql_error());
				while($rowComp=mysql_fetch_array($sqlComp)){
			
					//Memorizzo nelle rispettive variabili le quantit- di materia_prime
					$QuantitaComp = $_POST['QtaComp'.$NComp];
					$QuantitaPercComp = $_POST['QtaPercComp'.$NComp];
					$SalvaQtaComp = false;
													
					
					if(!isset($QuantitaComp)){
						$SalvaQtaComp = false;
					}
					if(	is_numeric($QuantitaComp) && $QuantitaComp>0 && $QuantitaComp!="" && isset($QuantitaComp)){					
						$SalvaQtaComp = true;
					}
				
					if($SalvaQtaComp==true ){
						// Salvo le quantit- nella tabella lab_matpri_teoria
						
						mysql_query("INSERT INTO lab_matpri_teoria 					  		       	 			                               (id_mat,cod_lab_formula,dt_inser,qta_teo,qta_teo_perc)
								VALUES ( 
											'".$rowComp['id_mat']."',
											'".$CodiceFormula."',
											'".dataCorrenteInserimento()."',
											'".$QuantitaComp."',
											'".$QuantitaPercComp."')")
							or die("Errore 312: " . mysql_error());
					}
						//Salvo i componenti oggetto  di variazione selezionati tramite checkbox con qta=0
                     if(isset($_POST['CompKeVaria'.$NComp]))
                     {
                            $CompKeVaria=$_POST['CompKeVaria'.$NComp];
							
							mysql_query("INSERT INTO lab_matpri_teoria 					  		       	 			                               (id_mat,cod_lab_formula,dt_inser,qta_teo,qta_teo_perc)
								VALUES ( 
											'".$rowComp['id_mat']."',
											'".$CodiceFormula."',
											'".dataCorrenteInserimento()."',
											'0',
											'0')")
							or die("Errore 313: " . mysql_error());
                            
					 }				
			$NComp++;
			}// End While finite le materie prime 
			
			//Estraggo l'elenco dei parametri presenti nella tabella lab_risultato_par
			$NPar = 1;
			$sqlPar = mysql_query("SELECT 
									lab_risultato_par.id_par,
									lab_parametro.nome_parametro, 
									lab_parametro.unita_misura,
									lab_risultato_par.valore_reale
								FROM 
									   lab_parametro 
								LEFT JOIN 
									lab_risultato_par 
								ON 
									lab_parametro.id_par=lab_risultato_par.id_par
								WHERE 
									(id_esperimento='".$IdEsperimento."' OR id_esperimento IS NULL) 
								AND
									(nome_parametro NOT LIKE '%acqua%')
								ORDER BY  
									(valore_reale>=0)=true DESC, nome_parametro ASC") 
		     		or die("Errore 314: " . mysql_error());
			while($rowPar=mysql_fetch_array($sqlPar)){
			
				//Memorizzo nelle rispettive variabili le quantit- di materia_prime
				$QuantitaParametro = $_POST['QtaPar'.$NPar];
				$SalvaQtaPar = false;
									
			if(!isset($QuantitaParametro)){
				$SalvaQtaPar = false;
			}
			if(	is_numeric($QuantitaParametro) && $QuantitaParametro>0 && $QuantitaParametro!="" && isset($QuantitaParametro)){					
				$SalvaQtaPar = true;
			}
			
			if($SalvaQtaPar==true ){
				// Salvo le quantit- nella tabella lab_parametro_teoria
				mysql_query("INSERT INTO lab_parametro_teoria 					  		       	 			                               (id_par,cod_lab_formula,dt_inser,valore_teo)
								VALUES ( 
											'".$rowPar['id_par']."',
											'".$CodiceFormula."',
											'".dataCorrenteInserimento()."',
											'".$QuantitaParametro."')")
				or die("Errore 315: " . mysql_error());
			}
										
			$NPar++;
		}// End While finiti i parametri
		
		//Estraggo l'elenco dei parametri ACQUA presenti nella tabella lab_risultato_par
			$NParAc = 1;
		 	$sqlParAc = mysql_query("SELECT 
									lab_risultato_par.id_par,
									lab_parametro.nome_parametro, 
									lab_parametro.unita_misura,
									lab_risultato_par.valore_reale
								FROM 
									   lab_parametro 
								LEFT JOIN 
									lab_risultato_par 
								ON 
									lab_parametro.id_par=lab_risultato_par.id_par
								WHERE 
									(id_esperimento='".$IdEsperimento."' OR id_esperimento IS NULL) 
								AND
									(nome_parametro LIKE '%acqua%')
								ORDER BY  
									(valore_reale>=0)=true DESC, nome_parametro ASC") 
					or die("Errore 316: " . mysql_error());
			while($rowParAc=mysql_fetch_array($sqlParAc)){
			
				//Memorizzo nelle rispettive variabili le quantit- di parametri
				$QuantitaPercAcqua = $_POST['QtaPercAc'.$NParAc];
				$SalvaQtaAcqua = false;
									
			if(!isset($QuantitaPercAcqua)){
				$SalvaQtaAcqua = false;
			}
			if(	is_numeric($QuantitaPercAcqua) && $QuantitaPercAcqua>0 && $QuantitaPercAcqua!="" && isset($QuantitaPercAcqua)){					
				$SalvaQtaAcqua = true;
			}
			
			if($SalvaQtaAcqua==true ){
				// Salvo le quantit- nella tabella lab_parametro_teoria
				mysql_query("INSERT INTO lab_parametro_teoria 					  		       	 			                               (id_par,cod_lab_formula,dt_inser,valore_teo)
								VALUES ( 
											'".$rowParAc['id_par']."',
											'".$CodiceFormula."',
											'".dataCorrenteInserimento()."',
											'".$QuantitaPercAcqua."')")
				or die("Errore 317: " . mysql_error());
			}
										
			$NParAc++;
		}// End While finiti i parametri
		
		echo 'Inserimento completato con successo! <a href="gestione_lab_formula.php">Torna alle Formule</a>';
		mysql_close();
		
		
			
		  }//End errore esistenza formula
		} //End if numerrore Acqua
	  }//End if ($numErrorePar)
	}//End if ($numErroreComp)
 }//End if ($numErroreMt)
}//End if errore


?>
</div>
</body>
</html>
