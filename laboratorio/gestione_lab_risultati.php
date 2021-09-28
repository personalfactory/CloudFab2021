<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
<body>

<div id="mainContainer">

<?php 
include('../include/menu.php'); include('../Connessioni/serverdb.php');
$sql = mysql_query("SELECT
						lab_risultato_car.id_esperimento,
						lab_esperimento.cod_lab_formula,
						lab_esperimento.num_prova,
						lab_esperimento.dt_prova
					FROM
						lab_risultato_car
					INNER JOIN 
						lab_esperimento 
						ON lab_esperimento.id_esperimento = lab_risultato_car.id_esperimento
					GROUP BY 
						lab_esperimento.id_esperimento
") 
or die("Query fallita: " . mysql_error());

include('./moduli/visualizza_lab_risultati.php'); 

?> 
</div>
</body>
</html>
