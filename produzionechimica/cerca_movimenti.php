<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
<body>
<div id="mainContainer">
<?php 
//ini_set(display_errors, "1");
include('../include/menu.php'); 
include('../Connessioni/serverdb.php');
include('../include/gestione_date.php');
include('../sql/script_materia_prima.php');
 
if($_POST['key']==""){
	echo 'Nessun risultato! <a href="gestione_mov_magazzino.php">Torna ai Movimenti</a>';
	}
if(isset($_POST['key'])&&($_POST['key']!="")/*&&(preg_match("/^[a-z0-9]+$/i", $_POST['key']))*/)
 {
	$key = trim($_POST['key']);
 
	$query="SELECT 	* FROM mov_magazzino
                    WHERE 
                                    (cod_mov LIKE '%" . $key . "%') 
                            OR 	(stato LIKE '%" . $key . "%')
                            OR 	(dt_inser LIKE '%" . $key . "%')

                    ORDER BY 
                            cod_mov,dt_inser";

	$sql=mysql_query($query,$connessione) or die(mysql_error($connessione));
	$trovati = mysql_num_rows($sql);
	if($trovati > 0)
	{
 		echo "<br/>Trovate $trovati voci per il termine <b>".stripslashes($key)."</b></p>\n";
		?>
        <a href="gestione_mov_magazzino.php">Torna ai Movimenti</a>
        <?php include('./moduli/visualizza_movimenti.php'); ?>
</body>
</html>
<?php

	}else{
  		// Notifica in caso di mancanza di risultati
 		echo 'Nessun risultato! <a href="gestione_mov_magazzino.php">Torna ai Movimenti</a>';
 	}
}
?>

</div>
</body>
</html>
