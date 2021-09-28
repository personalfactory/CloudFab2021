
<?php

$hostname_storico = "localhost";
$username_storico = "cloudfab";
$password_storico = "cloudFab11";
$database_storico = "storico";

$connessione = mysql_connect($hostname_storico, $username_storico, $password_storico)
			  or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_storico,$connessione);
mysql_query("set names utf8");

?> 
