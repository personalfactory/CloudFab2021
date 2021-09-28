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
    
    $sql = mysql_query("SELECT
                            produzione_miscela.id_miscela,
                            produzione_miscela.cod_formula,
                            produzione_miscela.cod_contenitore,
                            produzione_miscela.cod_mov,
                            produzione_miscela.cod_mat,
                            produzione_miscela.descri_mat,
                            produzione_miscela.mat_pesata,
                            produzione_miscela.peso_mat_teo,
                            produzione_miscela.peso_mat,
                         	produzione_miscela.peso_tot,
							miscela.dt_miscela
                           
                        FROM 
                            produzione_miscela
                        INNER JOIN 
                        miscela 
                        ON produzione_miscela.id_miscela=miscela.id_miscela") 
    or die("Query fallita: " . mysql_error());
    
    include('./moduli/visualizza_produzione_miscela.php'); ?>
 
</div>

</body>
</html>
