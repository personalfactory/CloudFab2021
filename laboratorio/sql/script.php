<?php

function begin() {
    mysql_query("BEGIN");
}

function commit() {
    mysql_query("COMMIT");
}

function rollback() {
    mysql_query("ROLLBACK");
}



/**
 * Genera in maniera random un codice alfanumerico utilizzando
 *  l'algoritmo crittografico MD5
 * @return type
 */

function generaCodice($lenght) {

  $sql = mysql_query("SELECT SUBSTRING(MD5(RAND()) FROM 1 FOR ".$lenght.") AS codice") 
          or die("ERROR IN script.php - FUNCTION generaCodice - SELECT SUBSTRING(MD5(RAND()) FROM 1 FOR 16)" . mysql_error());

  return $sql;
}


?>
