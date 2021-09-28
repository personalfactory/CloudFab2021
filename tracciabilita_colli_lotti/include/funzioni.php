<?php
 
################################# DI GAUDIO - 2021 ############################

/** RESTITUISCE LA LISTA COMPLETA DEGLI UTENTI ABILITATI E DISABILITATI 
 * 
 * @param 
 * @return result - array di oggetti tipo "Utente" 
 **/
function getElencoColli(){ 
	$result = array(); 
	global $table_colli;
	
	$sql_res = recuperaElencoColli();
	$index = 0;
			
	if (mysql_num_rows($sql_res) != 0) { 
 		while ($colli = mysql_fetch_array($sql_res)) {  
			$result[$index] = new colli(
				$colli[$table_colli[0]],
				$colli[$table_colli[1]],						
					$colli[$table_colli[2]],
					$colli[$table_colli[3]],
					$colli[$table_colli[4]],
					$colli[$table_colli[5]],
					$colli[$table_colli[6]],
					$colli[$table_colli[7]],
					$colli[$table_colli[8]],
					$colli[$table_colli[9]],
					$colli[$table_colli[10]],
					$colli[$table_colli[11]],
					$colli[$table_colli[12]],
					$colli[$table_colli[13]],
					$colli[$table_colli[14]],
					$colli[$table_colli[15]],
					$colli[$table_colli[16]],
					$colli[$table_colli[17]],
					$colli[$table_colli[18]]);	
			$index++;
		}
	}
	return $result;
} 

function getDateBolla($numDoc){ 
	//$result = array(); 
	
	$result =[
	"lunedì",
	"martedì",
	"mercoledì",
	"giovedì",
	"venerdì",
	"sabato",
	"domenica"];
	
//	$sql_res = recuperaDateBolla($numDoc);
//	$index = 0;
//			
//	if (mysql_num_rows($sql_res) != 0) { 
// 		while ($date_bolla = mysql_fetch_array($sql_res)) {  
//			//$result[$index] = $date_bolla['num_doc'];	
//			$result[$index] = $index;
//			$index++;
//		}
//	}
	return $result;
} 


function getIdMaxColli(){ 
	$result = array(); 
	global $table_colli;
	
	$sql_res = recuperaIdMaxColli();
	$index = 0;
	$rep = 1;
			
	if (mysql_num_rows($sql_res) != 0) { 
 		while ($colli = mysql_fetch_array($sql_res)) {  
			$result[$index] = new colli(
				$colli[$table_colli[0]],
				$colli[$table_colli[1]],						
					$colli[$table_colli[2]],
					$colli[$table_colli[3]],
					$colli[$table_colli[4]],
					$colli[$table_colli[5]],
					$colli[$table_colli[6]],
					$colli[$table_colli[7]],
					$colli[$table_colli[8]],
					$colli[$table_colli[9]],
					$colli[$table_colli[10]],
					$colli[$table_colli[11]],
					$colli[$table_colli[12]],
					$colli[$table_colli[13]],
					$colli[$table_colli[14]],
					$colli[$table_colli[15]],
					$colli[$table_colli[16]],
					$colli[$table_colli[17]],
					$colli[$table_colli[18]]);	
			$index++;
		}
		
		$rep = $result[0]->getId()+1;
	}
	return $rep;
} 

function findAllColli() {

    $stringSql = "SELECT c.id,
						 c.codice_collo,
						 c.data,
						 c.dt_abilitato,
						 c.associato, 
						 c.num_bolla,
						 c.dt_bolla, 
						 c.abilitato, 
						 c.altezza, 
						 c.larghezza, 
						 c.profondita, 
						 c.peso, 
						 c.info1, 
						 c.info2, 
						 c.info3, 
						 c.info4, 
						 c.info5, 
						 c.id_utente,
						 c.id_azienda
						  
                        FROM
                                serverdb.colli c";
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_colli_lotti.php - FUNCTION findAllColli - " . $stringSql . " - " . mysql_error());
    return $sql;
}

function getInfoCollo($idCollo){ 

	global $table_colli;
	
	$sql_res = recuperaInfoCollo($idCollo); 
			
	if (mysql_num_rows($sql_res) != 0) { 
 		while ($colli = mysql_fetch_array($sql_res)) {  
			$result = new colli(
				$colli[$table_colli[0]],
				$colli[$table_colli[1]],						
					$colli[$table_colli[2]],
					$colli[$table_colli[3]],
					$colli[$table_colli[4]],
					$colli[$table_colli[5]],
					$colli[$table_colli[6]],
					$colli[$table_colli[7]],
					$colli[$table_colli[8]],
					$colli[$table_colli[9]],
					$colli[$table_colli[10]],
					$colli[$table_colli[11]],
					$colli[$table_colli[12]],
					$colli[$table_colli[13]],
					$colli[$table_colli[14]],
					$colli[$table_colli[15]],
					$colli[$table_colli[16]],
					$colli[$table_colli[17]],
					$colli[$table_colli[18]]);	 
		}
	}
	return $result;
} 
 


function getLottiCollo($idCollo){ 
	$result = array(); 
	global $table_collo_lotti;
	
	$sql_res = recuperaLottiCollo($idCollo);
	$index = 0;
			
	if (mysql_num_rows($sql_res) != 0) { 
 		while ($collo_lotti = mysql_fetch_array($sql_res)) {  
			$result[$index] = new collo_lotti(
				$collo_lotti[$table_collo_lotti[0]],
				$collo_lotti[$table_collo_lotti[1]],						
					$collo_lotti[$table_collo_lotti[2]],
					$collo_lotti[$table_collo_lotti[3]],
					$collo_lotti[$table_collo_lotti[4]]);	
			$index++;
		}
	}
	return $result;
} 
 



?>
