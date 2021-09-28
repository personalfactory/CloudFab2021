<?php
function selectGruppiFromAnMac() {

 $sql = mysql_query("SELECT gruppo FROM anagrafe_macchina WHERE abilitato=1 GROUP BY gruppo ORDER BY gruppo") 
                  or die("ERROR IN script_anagrafe_macchina - FUNCTION selectGruppiFromAnMac - SELECT gruppo FROM serverdb.anagrafe_macchina : " . mysql_error());
  
  return $sql;
}

function selectGeoFromAnMac() {

$sql = mysql_query("SELECT geografico FROM anagrafe_macchina WHERE abilitato=1 GROUP BY geografico ORDER BY geografico") 
                  or die("ERROR IN script_anagrafe_macchina - FUNCTION selectGeoFromAnMac - SELECT geografico FROM serverdb.anagrafe_macchina : " . mysql_error());
  
  return $sql;
}

//function selectGruGeoByIdMacchina($idMacchina) {
//
//$sql = mysql_query("SELECT gruppo,geografico FROM anagrafe_macchina WHERE id_macchina=".$idMacchina) 
//                  or die("ERROR IN script_anagrafe_macchina - FUNCTION selectGruGeoFromByIdMacchina - SELECT gruppo,geografico FROM serverdb.anagrafe_macchina : " . mysql_error());
//  
//  return $sql;
//}
?>
