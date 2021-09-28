<?php

function inserisciOrdineSingMac($idOrdine, $idProdotto, $ordineProduzione,$numPezzi,$pezzoKg,$contatore, $stato,$descriStato, $abilitato, $dtProgrammata,$dtAbilitato) {

     $stringSql = "INSERT INTO serverdb.ordine_sing_mac (id_ordine,id_prodotto,ordine_produzione,num_pezzi,kg_pezzo,contatore,stato,descri_stato, abilitato,dt_programmata,dt_abilitato) 
                        VALUES(" . $idOrdine . ", " . $idProdotto . "," . $ordineProduzione . "," . $numPezzi . "," . $pezzoKg . "," . $contatore . ",'" . $stato . "','" . $descriStato . "',". $abilitato . ",'" . $dtProgrammata . "','" . $dtAbilitato . "')";

    $sql = mysql_query($stringSql)
               or die("ERROR IN script_ordine_sing_mac.php - FUNCTION inserisciOrdineSingMac - ". $stringSql." - ". mysql_error());
return $sql;
}


function findOrdiniOriByFiltri($campoOrdine, $campoGroupBy,$idOrdine,$dtProgrammata,$descriStab,$nomeProdotto,$numPezzi,$ordineProduzione,$descriStato,$strUtentiAziende ) {
             
      $stringSql = "SELECT *,o.descri_stato AS descri_stato,s.stato AS stato
                FROM 
                    serverdb.ordine_elenco o
                JOIN 
                    serverdb.ordine_sing_mac s ON o.id_ordine=s.id_ordine
                JOIN 
                    serverdb.macchina m ON m.id_macchina=o.id_macchina
                JOIN 
                    serverdb.prodotto p ON p.id_prodotto=s.id_prodotto            
                WHERE  
                    o.id_ordine LIKE '%" . $idOrdine . "%' 
                AND 
                    s.dt_programmata LIKE '%" . $dtProgrammata . "%'
                AND
                    descri_stab LIKE '%" . $descriStab . "%'
                AND 
                    nome_prodotto LIKE '%" . $nomeProdotto . "%'
                AND                     
                    num_pezzi LIKE '%" . $numPezzi . "%' 
                AND 
                    ordine_produzione LIKE '%" . $ordineProduzione . "%'
                AND 
                    s.descri_stato LIKE '%" . $descriStato . "%'
                
                AND 
                    s.abilitato=1
                AND 
                    (o.id_utente,o.id_azienda) IN ".$strUtentiAziende."    
                
                GROUP BY " . $campoGroupBy . "
                ORDER BY " . $campoOrdine;

    $sql = mysql_query($stringSql) or die("ERROR IN script_ordine_sing_mac - FUNCTION findOrdiniOriByFiltri - " . $stringSql . " - " . mysql_error());
    return $sql;
}



/**
 * Modifica il campo abilitato della tabella ordine_sing_mac di serverdb
 * @param type $idOrdineSm
 * @param type $abilitato
 * @return type
 */
function modificaAbilitatoOrdineSm($idOrdineSm,$abilitato){
    $stringSql = "UPDATE serverdb.ordine_sing_mac SET abilitato=".$abilitato.",dt_abilitato=NOW() 
        WHERE id_ordine_Sm=" . $idOrdineSm;
    $sql = mysql_query($stringSql);
	//or die("ERROR IN script_ordine_sing_mac.php - FUNCTION modificaAbilitatoOrdineSm - ".$stringSql ." ". mysql_error());
return $sql;
}

function modificaStatoOrdineSm($idOrdineSm,$stato,$descriStato){
    $stringSql = "UPDATE serverdb.ordine_sing_mac SET stato='".$stato."', descri_stato='".$descriStato."', dt_abilitato=NOW()
        WHERE id_ordine_sm=" . $idOrdineSm;
    $sql = mysql_query($stringSql)
	or die("ERROR IN script_ordine_sing_mac.php - FUNCTION modificaStatoOrdineSm - ".$stringSql ." ". mysql_error());
return $sql;
}





function findOrdineSmByIdOrdineProdotto($idOrdine,$idProdotto){
	$sqlString= "SELECT * FROM serverdb.ordine_sing_mac
                                WHERE id_ordine=" . $idOrdine." AND id_prodotto=".$idProdotto;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_ordine_sing_mac - FUNCTION findOrdineSmByIdOrdineProdotto - ".$sqlString ." ". mysql_error());
	return $sql;
}





function findDettaglioOrdineByIdOrdine($idOrdine) {
             
     $sqlString = "SELECT o.id_macchina,o.note,o.dt_ordine,m.descri_stab,p.id_prodotto,p.cod_prodotto,p.nome_prodotto,
         ordine_produzione,s.dt_programmata,num_pezzi,kg_pezzo,s.id_ordine_sm,
         contatore, s.descri_stato,s.dt_produzione,s.descri_stato,s.stato
                FROM 
                    serverdb.ordine_elenco o
                JOIN 
                    serverdb.ordine_sing_mac s ON o.id_ordine=s.id_ordine
                JOIN 
                    serverdb.macchina m ON m.id_macchina=o.id_macchina
                JOIN 
                    serverdb.prodotto p ON p.id_prodotto=s.id_prodotto
                WHERE 
                    
                    o.id_ordine=".$idOrdine." 
                AND 
                    s.abilitato=1";
     
            $sql = mysql_query($sqlString)
	or die("ERROR IN script_ordine_sing_mac - FUNCTION findDettaglioOrdineByIdOrdine - ".$sqlString ." ". mysql_error());
	return $sql;            


}