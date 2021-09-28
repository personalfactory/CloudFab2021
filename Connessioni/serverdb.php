
<?php

$hostname_serverdb = "localhost";
$username_serverdb = "cloudfab";
$password_serverdb = "cloudFab11";
$database_serverdb = "serverdb";

$connessione = mysql_connect($hostname_serverdb, $username_serverdb, $password_serverdb)
			  or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_serverdb,$connessione);
mysql_query("set names utf8");

?> 
