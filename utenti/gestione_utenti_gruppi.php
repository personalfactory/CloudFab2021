<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
<body>


<div id="mainContainer">

	<?php 
    include('../include/menu.php'); include('../include/gestione_date.php');
    include('../Connessioni/serverdb.php');
    
    $sql = mysql_query("SELECT
                            id_gruppo_utente,
                            nome_gruppo_utente,
                            tipo_gruppo_utente,
                            descri_gruppo_utente,
                            abilitato,
                            dt_abilitato
                        FROM
                            utente_gruppo
                        ORDER BY 
                            id_gruppo_utente
                            ") 
    or die("Query fallita: " . mysql_error());
    
    include('./moduli/visualizza_utenti_gruppi.php');?>

</div>

</body>
</html>
