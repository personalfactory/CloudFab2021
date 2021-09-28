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
include('../include/precisione.php');
include('../sql/script_materia_prima.php');
//Setto il tempo massimo di esecuzione dello script 
set_time_limit(120);
$NumMov=0;
$CodMov="";

$errore=false;
$InsertMovMagServerdb=1;
$NumCodiciAggiornati=0;	
$dataDoc="0";
//##############################################################################
//################ MOVIMENTI DA GAZIE ##########################################
//##############################################################################
mysql_query("BEGIN");

//Calcolo il numero totale di mov di magazzino in entrata su gazie relativi alle materie prime
$SelectNumMov=mysql_query("SELECT COUNT(*) AS num_mov
                                FROM 
                                        serverdb.gaz_movmag g
                                INNER JOIN serverdb.materia_prima m
                                ON g.artico=m.cod_mat
                        WHERE 
                        g.cat_mer =2 
                        AND 
                        g.tip_doc ='".$valTipoDocDdtAcq."'")

                    or die("Errore 1 SELECT FROM gaz_movmag : " . mysql_error());
			while ($rowNumMov=mysql_fetch_array($SelectNumMov)){
				$NumMov=$rowNumMov['num_mov'];
			}
				
		$i=0;
		//Seleziono i movimenti da gazie e costruisco il codice di ciascun movimento
		$SelectMovEntrataGazie=mysql_query("SELECT artico,id_mov,dt_doc
                                                FROM 
                                                    serverdb.gaz_movmag 
                                                WHERE
                                                    cat_mer =2 
                                                AND 
                                                    tip_doc ='".$valTipoDocDdtAcq."'")
								
					or die("Errore 1 SELECT FROM gaz_movmag : " . mysql_error());
				while ($row=mysql_fetch_array($SelectMovEntrataGazie)){
				$dataDoc = substr($row['dt_doc'],0, 4).substr($row['dt_doc'],5, 2).substr($row['dt_doc'],8, 2);
				
				// COSTRUZIONE DEL CODICE MOVIMENTO
				$CodMov=$row['artico'].".".$row['id_mov'].".".$dataDoc;
                                
                                //VERIFICA ESISTENZA CODICE MOVIMENTO SU SERVERDB
				$SelectCodMovServerdb=mysql_query("SELECT * FROM serverdb.mov_magazzino
								WHERE cod_mov='".$CodMov."'")
								
					or die("Errore 2 SELECT FROM mov_magazzino : " . mysql_error());
                                
                                
                                if(mysql_num_rows($SelectCodMovServerdb)==0){
					//INSERIMENTO DEL CODICE MOV SU SERVERDB					
					$InsertMovMagServerdb=mysql_query("INSERT INTO serverdb.mov_magazzino (cod_mov,stato,dt_inser)
										VALUES ('".$CodMov."',1,'".$row['dt_doc']."')")
					or die("Errore 3 INSERT INTO serverdb.mov_magazzino : " . mysql_error());
					$_SESSION['codici_mov'][$NumCodiciAggiornati]=$CodMov;
					$NumCodiciAggiornati++;	
					
				}
				if(!$InsertMovMagServerdb){
					$errore=true;
				}
				
				$i++;
			}
				
if( $errore ){
	  
	  mysql_query("ROLLBACK");
	  echo "TRANSAZIONE NON RIUSCITA!";
	  echo '<a href="gestione_mov_magazzino.php">VISUALIZZA MOVIMENTI</a>';	  
	  } else if(!$errore AND $NumCodiciAggiornati>0){
		  
	  	mysql_query("COMMIT");
	  	echo "TRANSAZIONE RIUSCITA! </br>";
	  	echo 'Sono stati inseriti n. '.$NumCodiciAggiornati.' movimenti di magazzino :<br/>';
	 	 	   
      	include('./moduli/visualizza_cod_mov_aggiornati.php'); 
		   
	  
	  } else if(!$errore AND $NumCodiciAggiornati==0){
		mysql_query("COMMIT");
		echo 'Non ci sono movimenti da aggiornare!<br/>';
		echo '<a href="gestione_mov_magazzino.php">VISUALIZZA MOVIMENTI</a>';
	}
mysql_close();


?>
</div>
</body>
</html>
