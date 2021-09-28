
<?php

$hostname_dbutente = "localhost";
$username_dbutente = "us_permessi.db";
$password_dbutente = "P3rM3551_14";
$database_dbutente = "dbutente";

$connessione = mysql_connect($hostname_dbutente, $username_dbutente, $password_dbutente)
			  or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_dbutente,$connessione);
mysql_query("set names utf8");

?> 
