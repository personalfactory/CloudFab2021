<!DOCTYPE html>
<html>
<head>
	
</head>
<body>

<?php

	include('../../Connessioni/serverdb.php'); 
	include('../../tracciabilita_colli_lotti/sql/query.php');  
	include('../../include/precisione.php');
 
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Lettura dati 
	 
  	$numDdt = $_GET['numDdt'];
	$dataEmi = $_GET['dataEmi']; 
	$codiceStab= $_GET['codiceStab']; 
	$idMacchina= $_GET['idMacchina']; 
	$codiciColloStr= $_GET['codiciColloStr'];
	$codiciLottoStr= $_GET['codiciLottoStr'];
	///////////////////////////////////////////////////////////////////////////////////////// Decodifica Codici Collo 
	$temp = "";
   	$codiciColliInseriti = array(); 
	for ($i = 0; $i <strlen($codiciColloStr); ++$i) { 
		if ($codiciColloStr[$i]==="-"){ 
			array_push($codiciColliInseriti, $temp);
			$temp="";
		} else {
			$temp = $temp.$codiciColloStr[$i];
		}
	}  
	///////////////////////////////////////////////////////////////////////////////////////// Decodifica Codici Lotto
	$temp = "";
   	$codiciLottoInseriti = array(); 
	for ($i = 0; $i <strlen($codiciLottoStr); ++$i) { 
		if ($codiciLottoStr[$i]==="-"){ 
			array_push($codiciLottoInseriti, $temp);
			$temp="";
		} else {
			$temp = $temp.$codiciLottoStr[$i];
		}
	}
	 
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Registrazione dati 
	inserisciDdtInBolla($numDdt,$dataEmi,$codiceStab,$idMacchina);
	
	$resultSelectIdBollaServerdb = findDdtInBolla($numDdt, $dataEmi); 
    while ($row = mysql_fetch_array($resultSelectIdBollaServerdb)) {
		 $idBolla = $row['id_bolla'];
    } 
	
	for ($i = 0; $i < count($codiciLottoInseriti); $i++) {	
		updateLottoAssociaDdt($idBolla, $numDdt, $dataEmi, $codiciLottoInseriti[$i],"$valStatoLottoVenduto");
	}
	
	 for ($i = 0; $i < count($codiciColliInseriti); $i++) {	
		updateColloLotto($numDdt,$dataEmi,$codiciColliInseriti[$i]);
	}
	 
mysql_close($connessione);
?>
</body>
</html>