<?php

$hostname_origamidb = "localhost";
$username_origamidb = "cloudfab";
$password_origamidb = "cloudFab11";
$database_origamidb = "origamidb";

$connessione = mysql_connect($hostname_origamidb, $username_origamidb, $password_origamidb)
			  or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_origamidb,$connessione);
mysql_query("set names utf8");

?> 
