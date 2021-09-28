
<?php

$hostname_localdb = "localhost";
$username_localdb = "cloudfab";
$password_localdb = "cloudFab11";
$database_localdb = "localdb";

$connessione = mysql_connect($hostname_localdb, $username_localdb, $password_localdb)
			  or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_localdb,$connessione);

?> 
