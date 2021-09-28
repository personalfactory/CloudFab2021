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
	echo 'Nessun risultato! <a href="gestione_chimica.php">Torna alle Chimica</a>';
	}
if(isset($_POST['key'])&&($_POST['key']!="")/*&&(preg_match("/^[a-z0-9]+$/i", $_POST['key']))*/)
 {
	$key = trim($_POST['key']);
 
	$query="SELECT
					*
				FROM
					chimica
				WHERE 
						(cod_chimica LIKE '%" . $key . "%') 
					OR 	(descri_formula LIKE '%" . $key . "%')
					OR 	(cod_prodotto LIKE '%" . $key . "%')
					OR 	(cod_lotto LIKE '%" . $key . "%')
					OR 	(data LIKE '%" . $key . "%')
				ORDER BY 
					cod_chimica,data";

	$sql=mysql_query($query,$connessione) or die(mysql_error($connessione));
	$trovati = mysql_num_rows($sql);
	if($trovati > 0)
	{
 		echo "<br/>Trovate $trovati voci per il termine <b>".stripslashes($key)."</b></p>\n";
		?>
        <a href="gestione_chimica.php">Torna alle Chimica</a>
        <?php include('./moduli/visualizza_chimica.php'); ?>
</body>
</html>
<?php

	}else{
  		// Notifica in caso di mancanza di risultati
 		echo 'Nessun risultato! <a href="gestione_chimica.php">Torna alla Chimica</a>';
 	}
}
?>

</div>
</body>
</html>
