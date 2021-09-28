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
include('../sql/script_lingua.php');

//$sql = mysql_query("SELECT * FROM lingua") or die("Query fallita: " . mysql_error());

$sql = findAllLingua();

include('./moduli/visualizza_lingue.php'); ?> 

</div>
</body>
</html>
