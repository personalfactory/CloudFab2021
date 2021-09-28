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
    include('../sql/script_presa.php');
    
    
    $sql= findAllFromPresa();
		
  //  $sql = mysql_query("SELECT * FROM presa ORDER BY presa") 
  //  or die("ERRORE SELECT FROM presa : " . mysql_error());
    
    include('./moduli/visualizza_prese.php');?>

</div>

</body>
</html>
