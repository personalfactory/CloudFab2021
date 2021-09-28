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

<table>
<?php
if($_POST['key']==""){
	echo 'Nessun risultato! <a href="gestione_lab_caratteristiche.php">Torna alle Caratteristiche</a>';
	}
if(isset($_POST['key'])&&($_POST['key']!="")/*&&(preg_match("/^[a-z0-9]+$/i", $_POST['key']))*/)
 {
	$key = trim($_POST['key']);
 
	$query="SELECT
					*
				FROM
					lab_caratteristica
				WHERE 
						(caratteristica LIKE '%" . $key . "%') 
					OR 	(descri_caratteristica LIKE '%" . $key . "%')
					OR 	(tipo_dato LIKE '%" . $key . "%')
					OR 	(dt_abilitato LIKE '%" . $key . "%')
				ORDER BY 
					caratteristica";

	$sql=mysql_query($query,$connessione) or die(mysql_error($connessione));
	$trovati = mysql_num_rows($sql);
	if($trovati > 0)
	{
 		echo "<br/>Trovate $trovati voci per il termine <b>".stripslashes($key)."</b></p>\n";
		?>
       <a href="gestione_lab_caratteristiche.php">Torna alle Caratteristiche</a>
        <?php include('./moduli/visualizza_lab_caratteristiche.php'); ?>
</body>
</html>
<?php

	}else{
  		// Notifica in caso di mancanza di risultati
 		echo 'Nessun risultato! <a href="gestione_lab_caratteristiche.php">Torna alle Caratteristiche</a>';
 	}
}
?>

</div>
</body>
</html>
