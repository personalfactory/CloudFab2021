<!DOCTYPE html>
<html>
<head>
	
</head>
	 <script type='text/javascript'>
	 
		
<body>

<?php

	include('../../Connessioni/serverdb.php'); 
	include('../../tracciabilita_colli_lotti/sql/query.php'); 
	include ('../../lingue/it.php');   // --------------- SISTEMARE ERRORE LETTURA DAL GESTORE LINGUE
 
	
	$index=0; 
	$codice = $_GET['cod']; 
	 
	$result = recuperaLottiColloCodice($codice);
  
 	echo "<tr>";	 
		echo "<td  class='cella33' colspan='2'>";
	echo $titoloCodiciLotto.$_SESSION['lingua'];
	echo "</td>";
	echo "</tr>";
	
	//decodifica codici Lotto --------------------------------DA MIGLIORARE
	$codiciLotto = $_GET['codiciLotto'];  
	$temp = "";
   	$codiciLottoInseriti = array(); 
	for ($i = 0; $i <strlen($codiciLotto); ++$i) { 
		if ($codiciLotto[$i]==="-"){ 
			array_push($codiciLottoInseriti, $temp);
			$temp="";
		} else {
			$temp = $temp.$codiciLotto[$i];
		}
	}
	 
	if (count($codiciLottoInseriti)>1){
			for ($i = 0; $i <count($codiciLottoInseriti); ++$i) { 
				echo "<tr>";
				echo "<td  class='cella111' colspan='2'>";
				echo "<label for='fname' name='codLotto' id='codLotto";
				echo $index;
				echo "'>";
				echo $codiciLottoInseriti[$i]."</label></td>";
				echo "</tr>";
				$index++;
			}
	}

	
	while($row = mysql_fetch_array($result)) { ì
		echo "<tr>";
		echo "<td  class='cella111' colspan='2'>";
		echo "<label for='fname' name='codLotto' id='codLotto";
		echo $index;
		echo "'>";
		echo $row['cod_lotto']. "</label></td>";
		echo "</tr>";
		$index++;

	}  
	echo "<tr> <td class='cella22' style='text-align:right'>";
  	echo $titleNumTotaleLottiInseriti;
	echo "</td> <td  class='cella22'> <label for='fname' name='numTotLotti' id='numTotLotti' >";
	echo $index;
	echo "</label></td></tr>";		
	
	
	
mysql_close($connessione);
?>
</body>
</html>