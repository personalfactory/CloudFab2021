<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
<body>
<div id=mainContainer>
<?php 
include('../include/menu.php'); 
include('../include/gestione_date.php'); 
include('../Connessioni/serverdb.php');
include('../Connessioni/storico.php');
$CodiceFormula=$_GET['CodiceFormula'];

//1.	Seleziono il record da cancellare dalla tabella [formula] di serverdb e memorizzo il contenuto dei campi 
$queryFormula="SELECT cod_formula,dt_formula,descri_formula,num_sac,qta_sac,abilitato,dt_abilitato
						FROM 
							serverdb.formula
						WHERE 
							cod_formula='".$CodiceFormula."'";
  		$sqlFormula=mysql_query($queryFormula,$connessione) or die("Errore 421: " . mysql_error());
		while($rowFormula=mysql_fetch_array($sqlFormula)){
			
				$cod_formula_old=$rowFormula['cod_formula'];
				$dt_formula_old=$rowFormula['dt_formula'];
				$descri_formula_old=$rowFormula['descri_formula'];
				$num_sac_old=$rowFormula['num_sac'];
				$qta_sac_old=$rowFormula['qta_sac'];
				$abilitato_old=$rowFormula['abilitato'];
				$dt_abilitato_old=$rowFormula['dt_abilitato'];
		}

//2.	Inserisco il record da cancellare nella tabella [formula] del db storico, ponendo il campo �abilitato� uguale a zero e aggiornando il campo �dt_abilitato� con data corrente;
mysql_query("INSERT INTO storico.formula	
						(cod_formula,dt_formula,descri_formula,num_sac,qta_sac,abilitato,dt_abilitato)
						VALUES(
							   '".$cod_formula_old."',
							   '".$dt_formula_old."',
							   '".$descri_formula_old."',
							   '".$num_sac_old."',
							   '".$qta_sac_old."',
							   0,
							   '".dataCorrenteInserimento()."')")
		or die("Errore 422 : " . mysql_error());

//3.	Seleziono il record da cancellare dalla tabella [accessorio_formula] di serverdb;
$queryAcc="SELECT 
						id_acces_form,cod_formula,accessorio,quantita,abilitato,dt_abilitato
					FROM
						serverdb.accessorio_formula
					WHERE 
						cod_formula='".$CodiceFormula."'";
  	$sqlAcc=mysql_query($queryAcc,$connessione) or die("Errore 423: " . mysql_error());
while($rowAcc=mysql_fetch_array($sqlAcc)){
			
		$id_acces_form_old=$rowAcc['id_acces_form'];
		$cod_formula_old=$rowAcc['cod_formula'];
		$accessorio_old=$rowAcc['accessorio'];
		$quantita_old=$rowAcc['quantita'];
		$abilitato_old=$rowAcc['abilitato'];
		$dt_abilitato_old=$rowAcc['dt_abilitato'];

//4.	Inserisco il record da cancellare nella tabella [accessorio_formula] del db storico, ponendo il campo �abilitato� uguale a zero e aggiornando il campo �dt_abilitato� con data corrente;

		mysql_query("INSERT INTO storico.accessorio_formula 						 										
								(id_acces_form,
								 cod_formula,
								 accessorio,
								 quantita,
								 abilitato,
								 dt_abilitato) 
								VALUES(
									   ".$id_acces_form_old.",
									   '".$cod_formula_old."',
									   '".$accessorio_old."',
									   '".$quantita_old."',
									    0,
								   	   '".dataCorrenteInserimento()."')")
			or die("Errore 424 : " . mysql_error());
		}//End While accessori
		

//5.	Seleziono ora i vecchi record presenti nella tabella [generazione_formula] relativi al codice_formula da cancellare;  
$queryMatPri="SELECT 
					id_gen_form,cod_mat,cod_formula,quantita,dt_inser,abilitato,dt_abilitato
				FROM
					serverdb.generazione_formula
				WHERE 
					cod_formula='".$CodiceFormula."'";
  		$sqlMatPri=mysql_query($queryMatPri,$connessione) or die("Errore 425: " . mysql_error());
		while($rowMt=mysql_fetch_array($sqlMatPri)){
			
				$id_gen_form_old=$rowMt['id_gen_form'];
				$cod_formula_old=$rowMt['cod_formula'];
				$cod_mat_old=$rowMt['cod_mat'];
				$quantita_old=$rowMt['quantita'];
				$dt_inser_old=$rowMt['dt_inser'];
				$abilitato_old=$rowMt['abilitato'];
				$dt_abilitato_old=$rowMt['dt_abilitato'];
				
//6.	Inserisco i vecchi record appena selezionati nella tabella [generazione_formula] del db  storico, ponendo il campo "abilitato" uguale a zero e aggiornando il campo �dt_abilitato� con data corrente;
			mysql_query("INSERT INTO storico.generazione_formula 						 										
								(id_gen_form,
								 cod_formula,
								 cod_mat,
								 quantita,
								 dt_inser,
								 abilitato,
								 dt_abilitato) 
								VALUES(
									   ".$id_gen_form_old.",
									   '".$cod_formula_old."',
									   '".$cod_mat_old."',
									   '".$quantita_old."',
									   '".$dt_inser_old."',
									    0,
								   	   '".dataCorrenteInserimento()."')")
			or die("Errore 426 : " . mysql_error());
		}//End While Materie prime

//7.	Cancello il record dalla tabella [formula] di serverdb;
mysql_query("DELETE FROM serverdb.formula WHERE cod_formula='".$CodiceFormula."'") or die("Errore 427 : " . mysql_error());
//DA togliere 
mysql_query("DELETE FROM serverdb.generazione_formula WHERE cod_formula='".$CodiceFormula."'") or die("Errore 427 : " . mysql_error());
mysql_query("DELETE FROM serverdb.accessorio_formula WHERE cod_formula='".$CodiceFormula."'") or die("Errore 427 : " . mysql_error());

mysql_close();
echo '<div id=container>La formula e\' stata eliminata! <a href="gestione_formula.php">Torna alla gestione delle Formule</a></div>';


?>
</div>
</body>

  </html>