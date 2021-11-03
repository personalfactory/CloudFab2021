<?php

/**
 * Restituisce la lista dei colli
 * @param 
 * @return $sql
 */
function recuperaElencoProdottiChimica() {
	global $dbname;
    
	mysql_query("USE ".$dbname . mysql_error());
	$stringSql = "SELECT * FROM serverdb.lotto_artico ORDER BY codice"; 
    $sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  recuperaElencoProdottiChimica - " . $stringSql . " - " . mysql_error());
    return $sql;
}

function recuperaDatiFormulaProdotti($codice) {
	global $dbname;
    
	mysql_query("USE ".$dbname . mysql_error()); 
	$stringSql = "SELECT * FROM serverdb.formula f JOIN serverdb.generazione_formula g ON f.cod_formula=g.cod_formula JOIN serverdb.materia_prima m ON g.cod_mat=m.cod_mat WHERE f.cod_formula LIKE '%". $codice ."%' AND f.abilitato=1";
 
    $sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  recuperaDatiFormulaProdotti - " . $stringSql . " - " . mysql_error());
    return $sql; 
} 

function recuperaNumeroLottiCodice($codice) {
	global $dbname;
    
	mysql_query("USE ".$dbname . mysql_error()); 
	
	$stringSql = "SELECT Count(*) FROM lotto WHERE cod_lotto LIKE '%". $codice ."%' AND id_bolla IS NULL AND num_bolla IS NULL AND dt_bolla IS NULL;";
 
    $sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  recuperaLottiCodice - " . $stringSql . " - " . mysql_error());
    return $sql; 
} 

function recuperaLottiCodice($codice) {
	global $dbname;
    
	mysql_query("USE ".$dbname . mysql_error()); 
	
	$stringSql = "SELECT * FROM lotto WHERE cod_lotto LIKE '%". $codice ."%' AND id_bolla IS NULL AND num_bolla IS NULL AND dt_bolla IS NULL;";
 
    $sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  recuperaLottiCodice - " . $stringSql . " - " . mysql_error());
    return $sql; 
} 


function recuperaElencoOrdini() {
	global $dbname;
    
	mysql_query("USE ".$dbname . mysql_error()); 
	
	$stringSql = "SELECT * FROM ordine_produzione_chimica;"; 	// WHERE abilitato=1;";
 
    $sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  recuperaElencoOrdini - " . $stringSql . " - " . mysql_error());
    return $sql; 
} 

function getCounterOrdini($Data){

	global $dbname;
   	mysql_query("USE ".$dbname . mysql_error()); 
	 
	$stringSql =  "SELECT * FROM ordine_produzione_chimica WHERE data LIKE '%". $Data . "%'";
	  
	 $sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  getCounterOrdini - " . $stringSql . " - " . mysql_error()); 
	 
	return $sql;
}

function recuperaMaxId() {
 
	global $dbname;
    
	mysql_query("USE ".$dbname . mysql_error());
	$stringSql = "select max(id) from ordine_produzione_chimica"; 
    $sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  recuperaMaxId - " . $stringSql . " - " . mysql_error());
    return $sql;
}


function inserisciOrdine($id,$codice,$resp_ordine,$data_ordine,$data_evasione,$note,$info1,$info2,$info3,$info4,$info5,$idUtente,$idAzienda) {
 
	global $dbname;
	$dt_abilitato= $data_ordine;
    
	mysql_query("USE ".$dbname . mysql_error());
	$stringSql = "INSERT INTO ordine_produzione_chimica (id,codice_ordine,resp_ordine,data,abilitato,dt_abilitato,data_evasione_prevista,stato_evasione,dt_evasione,resp_evasione,annullamento,data_annullamento,resp_annullamento, note,note_evasione,note_annullamento, info1,info2,info3,info4,info5, id_utente,id_azienda) VALUES('".$id."','".$codice."','".$resp_ordine."','".$data_ordine."','1','".$dt_abilitato."','".$data_evasione."','0','','','0','','', '".$note."','','','".$info1."', '".$info2."', '".$info3."', '".$info4."','".$info5."', '".$idUtente."', '".$idAzienda."');";

    $sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  recuperaMaxId - " . $stringSql . " - " . mysql_error());
    return $sql;
}

function inserisciDettaglioOrdine($id_ordine,$id_dettaglio,$descri_dettaglio,$valore,$idUtente,$idAzienda, $dt_abilitato) {
 
	global $dbname;
    
	mysql_query("USE ".$dbname . mysql_error());
	 
	$stringSql = "INSERT INTO ordine_produzione_chimica_dettagli (id_ordine, id_dettaglio, descri_dettaglio, abilitato, dt_abilitato,valore, id_utente,id_azienda) VALUES('".$id_ordine."','".$id_dettaglio."','".$descri_dettaglio."','1','".$dt_abilitato."','".$valore."', '".$idUtente."', '".$idAzienda."');";
	 

    $sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  inserisciDettaglioOrdine - " . $stringSql . " - " . mysql_error());
    return $sql;
}

function recuperaComponentiOrdine() {
 
	global $dbname;
    
	mysql_query("USE ".$dbname . mysql_error());
	 
	$stringSql = "SELECT valore FROM ordine_produzione_chimica_dettagli WHERE (id_dettaglio = 9 OR id_dettaglio=6) AND abilitato = 1 order by id;";
	 

    $sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  inserisciDettaglioOrdine - " . $stringSql . " - " . mysql_error());
    return $sql;
}
 
function recuperaInformazioniOrdine($id) {
 
	global $dbname;
    
	mysql_query("USE ".$dbname . mysql_error());
	 
	$stringSql = "SELECT * from ordine_produzione_chimica WHERE id='".$id."';";

    $sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  recuperaInformazioniOrdine - " . $stringSql . " - " . mysql_error());
    return $sql;
}

function recuperaDettagliOrdine($id_ordine,$id_dettaglio) {
 
	global $dbname;
    
	mysql_query("USE ".$dbname . mysql_error());
 
	$stringSql = "SELECT * from ordine_produzione_chimica_dettagli WHERE id_ordine='".$id_ordine."' AND id_dettaglio ='".$id_dettaglio."';";

    $sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  recuperaDettagliOrdine - " . $stringSql . " - " . mysql_error());
    return $sql;
}

function updateEvasione($id_ordine, $dt_evasione,$resp_evasione, $note_evasione) {
 
	global $dbname; 
	$dt_abilitato = $dt_evasione;
	mysql_query("USE ".$dbname . mysql_error());
 
	$stringSql = "UPDATE ordine_produzione_chimica SET stato_evasione=1, dt_evasione='".$dt_evasione."', resp_evasione ='".$resp_evasione."', dt_abilitato='".$dt_abilitato."',  note_evasione ='".$note_evasione."' WHERE id= '".$id_ordine."';";
	
	$sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  updateEvasione - " . $stringSql . " - " . mysql_error());
	
	$stringSql = "UPDATE ordine_produzione_chimica_dettagli SET abilitato=0, dt_abilitato='".$dt_abilitato."' WHERE id_ordine= '".$id_ordine."';";
	
	$sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  updateEvasione - " . $stringSql . " - " . mysql_error());
	
    return $sql;
}	

function updateAnnullamento($id_ordine, $dt_annullamento,$resp_annullamento, $note_annullamento) {
 
	global $dbname;
	$dt_abilitato = $dt_annullamento;
    
	mysql_query("USE ".$dbname . mysql_error());
 
	$stringSql = "UPDATE ordine_produzione_chimica SET annullamento=1, data_annullamento='".$dt_annullamento."',  dt_abilitato='".$dt_abilitato."', resp_annullamento ='".$resp_annullamento."', note_annullamento ='".$note_annullamento."' WHERE id= '".$id_ordine."';";
	
	$sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  updateAnnullamento - " . $stringSql . " - " . mysql_error());
	
	$stringSql = "UPDATE ordine_produzione_chimica_dettagli SET abilitato=0, dt_abilitato='".$dt_abilitato."' WHERE id_ordine= '".$id_ordine."';";
	
	$sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  updateAnnullamento - " . $stringSq2 . " - " . mysql_error());
	
    return $sql;
}	

function updateAbilita($id_ordine, $annullamento, $resp_abilita, $dt_abilitato) {
 
	global $dbname;
    
	mysql_query("USE ".$dbname . mysql_error());
 
	$stringSql = "UPDATE ordine_produzione_chimica SET abilitato='".$annullamento."' WHERE id= '".$id_ordine."';";
	
	$sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  updateAbilita - " . $stringSql . " - " . mysql_error());
	
	$stringSql = "UPDATE ordine_produzione_chimica_dettagli SET abilitato='".$annullamento."', dt_abilitato='".$dt_abilitato."', resp_abilita_disabilta='".$resp_abilita."' WHERE id_ordine= '".$id_ordine."';";
	
	$sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  updateAbilita - " . $stringSq2 . " - " . mysql_error());
	
    return $sql;
}
function recuperaElencoResponsabiliProduzioneChimica() {
	global $dbname;
    
	mysql_query("USE ".$dbname . mysql_error());
	$stringSql = "SELECT * FROM serverdb.utente where id_gruppo_utente='29'"; 
    $sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  recuperaElencoResponsabiliProduzioneChimica - " . $stringSql . " - " . mysql_error());
    return $sql;
}
function recuperaListaLottiCollo() {
	global $dbname;
    
	mysql_query("USE ".$dbname . mysql_error());
	$stringSql = "SELECT * FROM collo_lotti cl INNER JOIN colli c ON c.id = cl.id_collo WHERE cl.abilitato = 1 AND c.abilitato=1"; 
    $sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  recuperaListaLottiCollo - " . $stringSql . " - " . mysql_error());
    return $sql;
}

 

function disabilitaCodiceLotto($codiceLotto, $dataBolla) {
 
	global $dbname;
	$dt_abilitato = $dt_annullamento;
    
	mysql_query("USE ".$dbname . mysql_error());

	$stringSql = "UPDATE collo_lotti SET abilitato=0 WHERE cod_lotto= '".$codiceLotto."';";
	
	$sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  disabilitaCodiceLotto1 - " . $stringSql . " - " . mysql_error());
	
	$stringSql = "UPDATE lotto set parent = 0, dt_bolla='".$dataBolla."' WHERE cod_lotto = '".$codiceLotto."';";
	
	$sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  disabilitaCodiceLotto2 - " . $stringSq2 . " - " . mysql_error());
	
    return $sql;
}	

function updateNote($note) {
 
	global $dbname;  
	
	mysql_query("USE ".$dbname . mysql_error());

	$stringSql = "UPDATE ordine_produzione_chimica SET note ='".$note[1]."' WHERE id = '".$note[0]."';";
	
	$sql = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  updateNote - " . $stringSql . " - " . mysql_error());
	
	for ($i=0; $i<$note[2]; $i++){
		$stringSql = "UPDATE ordine_produzione_chimica_dettagli SET valore = '".$note[3+$i*2]."' WHERE id = '".$note[4+$i*2]."';";
		$sql = mysql_query($stringSql)
           or die("ERROR IN FUNCTION  disabilitaCodiceLotto2 - " . $stringSq2 . " - " . mysql_error());
	}
	
    return $sql;
}


?> 