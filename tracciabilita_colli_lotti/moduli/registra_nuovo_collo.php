<?php  

    include('../../Connessioni/serverdb.php'); 
	include("../../tracciabilita_colli_lotti/sql/query.php");
  
		$codiceCollo = "";
		$dataCollo  = ""; 
		$altezzaCollo  = "0";
		$larghezzaCollo  = "0"; 
		$profonditaCollo  = "0";
		$pesoCollo = "0";
		$info1collo  = "";
		$info2collo  = "";
		$info3collo  = "";
		$info4collo  = "";
		$info5collo = "";	  
		$codiciLotto  = "";
 		$idUtente = "0";
		$idAzienda = "0";

	  //Lettura Informazioni da Registrare
	  if (isset($_POST["codiceCollo"])) {
	
			  if (isset($_POST["idCollo"])) { $idCollo = $_POST["idCollo"]; }
			  if (isset($_POST["codiceCollo"])) { $codiceCollo = $_POST["codiceCollo"]; }
			  if (isset($_POST["dataCollo"])) { $dataCollo = $_POST["dataCollo"]; }
		 	  if (isset($_POST["altezzaCollo"])) { $altezzaCollo = $_POST["altezzaCollo"]; }
			  if (isset($_POST["larghezzaCollo"])) { $larghezzaCollo = $_POST["larghezzaCollo"]; } 
			  if (isset($_POST["profonditaCollo"])) { $profonditaCollo = $_POST["profonditaCollo"]; }
			  if (isset($_POST["pesoCollo"])) { $pesoCollo = $_POST["pesoCollo"]; }
			  if (isset($_POST["info1collo"])) { $info1collo = $_POST["info1collo"];  }
			  if (isset($_POST["info2collo"])) { $info2collo = $_POST["info2collo"]; } 
			  if (isset($_POST["info3collo"])) { $info3collo = $_POST["info3collo"]; }
			  if (isset($_POST["info4collo"])) { $info4collo = $_POST["info4collo"]; }
			  if (isset($_POST["info5collo"])) { $info5collo = $_POST["info5collo"]; }	 
		  	  if (isset($_POST["idUtente"])) { $idUtente = $_POST["idUtente"]; }	 
		  	  if (isset($_POST["idAzienda"])) { $idAzienda = $_POST["idAzienda"]; }	
		  
	 	  /////////////////////////////////////////////////////////////////////////////////////////////// INSERIRE CONTROLLI SUI DATI  
		
		  //Verifica Codice Collo
		  if ($codiceCollo != ""){
			  	//Registrazione Codice Collo
				insertCollo($idCollo,$codiceCollo, $dataCollo,$altezzaCollo,$larghezzaCollo,$profonditaCollo,$pesoCollo,$info1collo,$info2collo,$info3collo,$info4collo,$info5collo, $idUtente, $idAzienda);
	 
			  	//Registrazione Codice Collo Lotti
				if (isset($_POST["codiciLotto"])) { 
					
					$codiciLotto = $_POST["codiciLotto"];	 
					
					 for ($i = 0; $i < count($codiciLotto); ++$i) {  
						 if (strlen($codiciLotto[$i])>1){
							insertColloLotti($idCollo, $codiciLotto[$i]); 
						 }
		 			} 
		 		}
	  	}
		   
		
	  } 
?>