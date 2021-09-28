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
include('../Connessioni/serverdb.php');

if($_POST['key']==""){
	echo 'Nessun risultato! <a href="gestione_lotti.php">Torna ai Lotti</a>';
	}
if(isset($_POST['key'])&&($_POST['key']!=""))
 {
	$key = trim($_POST['key']);
 
	$query="SELECT
					*
				FROM
					lotto  
				WHERE 
						(cod_lotto LIKE '%" . $key . "%') 
					OR 	(dt_lotto LIKE '%" . $key . "%')
					OR 	(descri_lotto LIKE '%" . $key . "%') 
					
				ORDER BY 
					cod_lotto,dt_lotto";

	$sql=mysql_query($query,$connessione) or die(mysql_error($connessione));
	$trovati = mysql_num_rows($sql);
	if($trovati > 0)
	{
 		echo "<br/>Trovate $trovati voci per il termine <b>".stripslashes($key)."</b></p>\n";
		?>
        <a href="gestione_lotti.php">Torna ai Lotti</a>
        <?php include('./moduli/visualizza_lotti.php'); ?>
</body>
</html>
<?php

	}else{
  		// Notifica in caso di mancanza di risultati
 		echo 'Nessun risultato! <a href="gestione_lotti.php">Torna ai Lotti</a>';
 	}
}
?>

</div>
</body>
</html>
