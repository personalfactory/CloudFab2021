<?php  

    include('../../Connessioni/serverdb.php'); 
	include("../../tracciabilita_colli_lotti/sql/query.php");
  
	  $idCollo = $_POST["idCollo"]; 
	 
	  if ($idCollo != ""){
 			//Registrazione Codice Collo
			disabilitaCollo($idCollo);
 	  
	 } 
	   

?>