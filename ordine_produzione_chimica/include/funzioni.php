<?php
 
################################# DI GAUDIO - 2021 ############################

/** RESTITUISCE LA LISTA COMPLETA DEGLI UTENTI ABILITATI E DISABILITATI 
 * 
 * @param 
 * @return result - array di oggetti tipo "Utente" 
 **/
function getElencoOrdini(){ 
	$result = array();  
	
	$sql_res = recuperaElencoOrdini();
	$index = 0;
			
	if (mysql_num_rows($sql_res) != 0) { 
 		while ($res = mysql_fetch_array($sql_res)) {  
			$result[$index] = array(
				$res['id'],
				$res['codice_ordine'],	 
				$res['resp_ordine'],
				$res['data'],
				$res['abilitato'],
				$res['dt_abilitato'], 
				$res['data_evasione_prevista'],
				$res['stato_evasione'],
				$res['dt_evasione'],
				$res['resp_evasione'],
				$res['annullamento'],
				$res['data_annullamento'],
				$res['resp_annullamento'], 
				$res['note'],
				$res['note_evasione'],
				$res['note_annullamento'],
				$res['note'],
				$res['info1'],
				$res['info2'],
				$res['info3'],
				$res['info4'],
				$res['info5'],
				$res['id_utente'],
				$res['id_azienda']);	 
			$index++;
		}
	}
	return $result;
}  

?>
