<?php

function findAllParametriOrdine($campoOrdine){
    $sqlString="SELECT * FROM serverdb.parametro_ordine ORDER BY ".$campoOrdine;

   $sql = mysql_query($sqlString) ;
           //or die("ERROR IN script_parametro_ordine - FUNCTION findAllParametriOrdine - ".$sqlString ." ". mysql_error());
   return $sql;
}