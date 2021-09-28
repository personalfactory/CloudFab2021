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

//Ricavo il valore dell'id_mazzetta che si vuole modificare
$IdMazzetta=$_POST['IdMazzetta'];

//################### Gestioni errori di query #################################

$sqlColore = true;
$sqlColBase = true;
$insertStorico = true;
$erroreRusult = false;
$updateServerdb = false;

//################### Gestione errori di input #################################
$errore=false;
$messaggio=$msgErroreVerificato.'<br/>';
	
//Inizializzo due contatori
$NColEr=1; //Contatore dei Colori associati alla mazzetta
$NColBaseEr=1; //Contatore dei colori base associati ai vari Colori
//Seleziono dalla tabella mazzetta_colorata i Colori associati alla mazzetta da modificare ai quali devo modificare la composizione.

$sqlColoreEr = innerJoinMazzettaColorataColore($IdMazzetta);
/*
$sqlColoreEr = mysql_query("SELECT 
                                    mazzetta_colorata.id_colore,
                                    colore.nome_colore
                        FROM
                                serverdb.mazzetta_colorata
                        INNER JOIN serverdb.colore 
                        ON 
                                mazzetta_colorata.id_colore = colore.id_colore
                        WHERE 
                                mazzetta_colorata.id_mazzetta=".$IdMazzetta."
                        GROUP BY
                                    colore.nome_colore
                        ORDER BY 
                                    colore.nome_colore")
             or die("Errore 11: " . mysql_error());
             */
 		while($rowColoreEr=mysql_fetch_array($sqlColoreEr)){
			//Memorizzo l'id_colore arrivato tramite POST 
			$IdColore=$_POST['IdColore'.$NColEr];
			
			//Seleziono i colori_base associati a questo id_colore ed alla mazzetta che si sta modificando
			$sqlColBaseEr = selectMazzettaColoreBaseLeft($IdMazzetta, $IdColore);
			/*
			$sqlColBaseEr = mysql_query("SELECT   
                                                            mazzetta_colorata.id_maz_col,
                                                            mazzetta_colorata.id_mazzetta,
                                                            mazzetta_colorata.id_colore,
                                                            mazzetta_colorata.id_colore_base,
                                                            mazzetta_colorata.quantita,
                                                            mazzetta_colorata.abilitato,
                                                            mazzetta_colorata.dt_abilitato,
                                                            colore_base.nome_colore_base									
                                                    FROM 
                                                            serverdb.mazzetta_colorata
                                                    LEFT JOIN serverdb.colore_base
                                                    ON
                                                            mazzetta_colorata.id_colore_base=colore_base.id_colore_base
                                                    WHERE
                                                            mazzetta_colorata.id_mazzetta=".$IdMazzetta."
                                                    AND
                                                            mazzetta_colorata.id_colore=".$IdColore."
                                                    ORDER BY 
                                                            colore_base.nome_colore_base") 
							or die("Errore 121: " . mysql_error());
					*/	
		    //Memorizzo la quantita (arrivata tramite form) relativa al colore_base  
			while($rowColBaseEr=mysql_fetch_array($sqlColBaseEr)){
				
				//$QuantitaDaInserire = str_replace(" ","",$_POST['Qta'.$NColBaseEr]);
				$QuantitaDaInserire = $_POST['Qta'.$NColBaseEr];
				
				if($QuantitaDaInserire != $rowColBaseEr['quantita']){
					if(	!is_numeric($QuantitaDaInserire) ){							
						
						$errore=true;
						$messaggio=$messaggio." ".$msgQuantitaDi." (".$rowColBaseEr['nome_colore_base'].") ".$msgDelColore." (".$rowColoreEr['nome_colore'].") ".$msgNumerico."!<br />";
					}
				}
				//Controllo quantita eventualmente modificata 
				if(!isset($QuantitaDaInserire) || trim($QuantitaDaInserire) =="" ){
								
					$errore=true;
					$messaggio=$messaggio." ".$msgQuantitaDi.' '.$rowColBaseEr['nome_colore_base'].$msgVuota."<br />";
				}	
				
				$NColBaseEr++;
			}// End while finiti i colori base 
			$NColEr++;
		}//End while finiti i colori		
					
		$messaggio=$messaggio. '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';	
			
		if($errore){
			//Ci sono errori quindi non effettuo la modifica e visualizzo il messaggio di errore
			echo $messaggio;
		}else{
                    
		//################ INIZIO TRANSAZIONE ###########################
            begin();                   
                    
			//Inizializzo due contatori
			$NCol=1; //Contatore dei Colori associati alla mazzetta
			$NColBase=1; //Contatore dei colori base associati ai vari Colori
			//Seleziono dalla tabella mazzetta_colorata i Colori associati alla mazzetta da modificare ai quali devo modificare la composizione.
			
			$sqlColore = selectMazzettaColorataColore($IdMazzetta);
			/*
			$sqlColore = mysql_query("SELECT 
							 	mazzetta_colorata.id_colore,
								colore.nome_colore
						   FROM
							   serverdb.mazzetta_colorata
						   INNER JOIN serverdb.colore 
						   ON 
							 mazzetta_colorata.id_colore = colore.id_colore
						   WHERE 
							   mazzetta_colorata.id_mazzetta=".$IdMazzetta."
						   GROUP BY
						   		colore.nome_colore
						   ORDER BY 
                                                   colore.nome_colore");
//             or die("Errore 11: " . mysql_error());
 * 
 */
 		while($rowColore=mysql_fetch_array($sqlColore)){
			//Memorizzo l'id_colore arrivato tramite POST 
			$IdColore=$_POST['IdColore'.$NCol];
			
			//Seleziono i colori_base associati a questo id_colore ed alla mazzetta che si sta modificando
			$sqlColBase = selectMazzettaColorataColoreBaseInner($IdMazzetta, $IdColore);
			/*
			$sqlColBase = mysql_query("SELECT   
                                                            mazzetta_colorata.id_maz_col,
                                                            mazzetta_colorata.id_mazzetta,
                                                            mazzetta_colorata.id_colore,
                                                            mazzetta_colorata.id_colore_base,
                                                            mazzetta_colorata.quantita,
                                                            mazzetta_colorata.abilitato,
                                                            mazzetta_colorata.dt_abilitato,
                                                            colore_base.nome_colore_base									
                                                    FROM 
                                                            serverdb.mazzetta_colorata
                                                    INNER JOIN serverdb.colore_base
                                                    ON
                                                            mazzetta_colorata.id_colore_base=colore_base.id_colore_base
                                                    WHERE
                                                            mazzetta_colorata.id_mazzetta=".$IdMazzetta."
                                                    AND
                                                            mazzetta_colorata.id_colore=".$IdColore."
                                                    ORDER BY 
                                                            colore_base.nome_colore_base"); 
//							or die("Errore 121: " . mysql_error());
			*/
						
		    //Memorizzo la quantita (arrivata tramite form) relativa al colore_base  
			while($rowColBase=mysql_fetch_array($sqlColBase)){
						
				$QuantitaDaInserire =$_POST['Qta'.$NColBase];	
												
				// Non ci sono errori quindi posso andare avanti
				//Inserisco nello storico i vecchi record relativi all'associazione mazzetta-colore che si sta modificando 
				
				$insertStorico = insertStoricoAssociaMazzettaColore($rowColBase['id_maz_col'], $IdMazzetta, $IdColore, $rowColBase['id_colore_base'], $rowColBase['quantita'], $rowColBase['abilitato'], $rowColBase['dt_abilitato']);
/*
				$insertStorico = mysql_query("INSERT INTO storico.mazzetta_colorata 	
                                                    (id_maz_col,
                                                        id_mazzetta,
                                                        id_colore,
                                                        id_colore_base,
                                                        quantita,
                                                        abilitato,
                                                        dt_abilitato)
                                            VALUES(
                                                            ".$rowColBase['id_maz_col'].",
                                                            ".$IdMazzetta.",
                                                            ".$IdColore.",
                                                            '".$rowColBase['id_colore_base']."',
                                                            ".$rowColBase['quantita'].",
                                                            ".$rowColBase['abilitato'].",
                                                            '".$rowColBase['dt_abilitato']."')");
//				or die("Errore 122 : " . mysql_error());
	*/					
				//Salvo la modifica nella tabella mazzetta_colorata

				$updateServerdb = updateServerMazzettaColorata($IdMazzetta, $IdColore, $rowColBase['id_colore_base'], $QuantitaDaInserire );
				/*
				$updateServerdb = mysql_query("UPDATE serverdb.mazzetta_colorata 
                                        SET 
                                    quantita=if(quantita!=".$QuantitaDaInserire.",".$QuantitaDaInserire.",quantita)
                                               
                                        WHERE
                                                id_mazzetta=".$IdMazzetta."
                                        AND
                                                id_colore=".$IdColore."
                                        AND
                                                id_colore_base=".$rowColBase['id_colore_base']);
//				or die("Errore 123: " . mysql_error());
				*/
				
                                
                                if(!$updateServerdb OR !$insertStorico){ $erroreRusult = true;}
                                
				$NColBase++;
			}// End while finiti i colori base 
			$NCol++;
		}//End while finiti i colori
                
                
		if ($erroreRusult OR !$sqlColore OR !$sqlColBase) {

                    rollback();
                    echo $msgTransazioneFallita."! ".$msgErrContattareAdmin.'!';

                    echo "<br/>erroreRusult" . $erroreRusult;
                    echo "<br/>sqlColore" . $sqlColore;
                    echo "<br/>sqlColBase" . $sqlColBase;
                    echo "<br/>insertStorico" . $insertStorico;
                    echo "<br/>updateServerdb" . $updateServerdb;
                } else {

                    commit();
                    mysql_close();
                    ?>
                    <script language="javascript">
                        window.location.href="gestione_mazzette_colorate.php";
                    </script>
                <?php
                }

	}//fine if($errore) controllo input quantit�
?>

</div>
</body>
</html>
