<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
<body>
<div id="mainContainer">
<?php include('../include/menu.php'); 
include('../Connessioni/serverdb.php');?>


<?php
if($_POST['key']==""){
	echo 'Nessun risultato! <a href="gestione_lab_risultati.php">Torna ai Risultati delle Formule</a>';
	}
if(isset($_POST['key'])&&($_POST['key']!="")/*&&(preg_match("/^[a-z0-9]+$/i", $_POST['key']))*/)
 {
	$key = trim($_POST['key']);
 
	$query="SELECT
				lab_risultato.id_risultato,
				lab_caratteristica.caratteristica,
				lab_formula.cod_lab_formula,
				lab_formula.dt_lab_formula,
				lab_risultato.valore_numerico,
				lab_risultato.valore_testo,
				lab_risultato.dt_registrazione,
				lab_formula.utente,
				lab_formula.gruppo_lavoro
				
			FROM
				lab_risultato
			INNER JOIN 
				lab_caratteristica 
			ON lab_risultato.id_carat = lab_caratteristica.id_carat
			INNER JOIN 
				lab_formula 
			ON lab_formula.id_lab_form = lab_risultato.id_lab_form
			WHERE 
					(lab_formula.cod_formula 			LIKE '%" . $key . "%') 
				OR 	(lab_formula.utente 				LIKE '%" . $key . "%')
				OR 	(lab_formula.gruppo_lavoro 			LIKE '%" . $key . "%')
				OR 	(lab_formula.num_prova	 	LIKE '%" . $key . "%')
				OR 	(lab_risultato.valore_numerico 		LIKE '%" . $key . "%')
				OR 	(lab_risultato.valore_testo	 		LIKE '%" . $key . "%')
			
			ORDER BY 
				cod_formula";

	$sql=mysql_query($query,$connessione) or die(mysql_error($connessione));
	$trovati = mysql_num_rows($sql);
	if($trovati > 0)
	{
 		echo "<br/>Trovate $trovati voci per il termine <b>".stripslashes($key)."</b></p>\n";
		?>
        <a href="gestione_lab_risultati.php">Torna ai Risultati delle Formule</a>
        <?php include('./moduli/visualizza_lab_risultati.php'); ?>
</body>
</html>
<?php

	}else{
  		// Notifica in caso di mancanza di risultati
 		echo 'Nessun risultato! <a href="gestione_lab_risultati.php">Torna ai Risultati delle Formule</a>';
 	}
}
?>

</div>
</body>
</html>
