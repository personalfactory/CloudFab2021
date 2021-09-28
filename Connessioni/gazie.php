
<?php

$hostname_gazie = "localhost";
$username_gazie = "cloudfab";
$password_gazie = "cloudFab11";
$database_gazie = "gazie";

$connessione = mysql_connect($hostname_gazie, $username_gazie, $password_gazie)
			  or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_gazie,$connessione);
?> 
