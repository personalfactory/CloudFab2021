<?php 
function connettiServerdb($username, $password){

$hostname= "localhost";
$database = "serverdb";

$connessione = mysql_connect($hostname, $username, $password)
			  or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database,$connessione);

}


function connettiStorico($username, $password){

$hostname = "localhost";
$database = "storico";

$connessione = mysql_connect($hostname, $username, $password)
			  or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database,$connessione);
}


function connettiGazie($username, $password){

$hostname = "localhost";
$database = "gazie";

$connessione = mysql_connect($hostname, $username, $password)
			  or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database,$connessione);
}
?>