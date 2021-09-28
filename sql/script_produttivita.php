<?php

function deleteFromProduttivitaByUtente($idUtente){
    
    mysql_query("DELETE FROM produttivita WHERE id_utente=".$idUtente)
            or die("ERROR IN script_produttivita- FUNCTION deleteFromProduttivitaByUtente - DELETE FROM produttivita WHERE id_utente : " . mysql_error());
    
}
/**
 * Funzione che chiama la procedura DATA_DIFF_GRUPPO_GEO di serverdb, 
 * seleziona i processi con le date dalla tabella processo 
 * ed li inserisce nella tabella produttivita calcolando la differenza di tempo 
 * tra ciascun processo
 * utile al calcolo della produttivita
 * @param type $IdMacchina
 * @param type $Data3
 * @param type $Data4
 * @param type $OreDaEscludere
 * @param type $CodOperatore
 * @param type $CodProdotto
 */
function callDataDiffGrupGeoSp($IdMacchina, $Data3, $Data4, $OreDaEscludere, $CodOperatore, $CodProdotto, $idUtente, $Gruppo,$RifGeo) {
  mysql_query("CALL serverdb.DATA_DIFF_GRUPPO_GEO( '" . $Gruppo . "',
                                                  '" . $RifGeo . "',
                                                   " . $IdMacchina . ",
                                                  '" . $Data3 . "',
                                                  '" . $Data4 . "',
                                                  " . $OreDaEscludere . ",                                             
                                                  '%" . $CodOperatore . "%',  
                                                  '%" . $CodProdotto . "%',
                                                  " . $idUtente.")");
   
}

/**
 * Funzione che chiama la procedura DATA_DIFF_GRUPPO_GEO di serverdb, 
 * seleziona i processi con le date dalla tabella processo 
 * ed li inserisce nella tabella produttivita calcolando la differenza di tempo 
 * tra ciascun processo
 * utile al calcolo della produttivita
 * @param type $IdMacchina
 * @param type $Data3
 * @param type $Data4
 * @param type $OreDaEscludere
 * @param type $CodOperatore
 * @param type $CodProdotto
 */
function callDataDiffStabSp($IdMacchina, $Data3, $Data4, $OreDaEscludere,$CodProdotto,$idUtente) {
 
  mysql_query("CALL serverdb.DATA_DIFF_STAB(          
                                                    " . $IdMacchina . ",
                                                  '" . $Data3 . "',
                                                  '" . $Data4 . "',
                                                  " . $OreDaEscludere . ", 
                                                  '%" . $CodProdotto . "%',
                                                  " . $idUtente.")");
   
}

function callDataDiffStabAllSp($Data3, $Data4, $OreDaEscludere,$CodProdotto,$idUtente) {
    
  mysql_query("CALL serverdb.DATA_DIFF_STAB_ALL( '" . $Data3 . "',
                                             '" . $Data4 . "',
                                             " . $OreDaEscludere . ", 
                                             '%" . $CodProdotto . "%',
                                             " . $idUtente.")");
   
}


/**
 * Modifica il campo in_servizio della tabella produttivita, ponendolo uguale a 1 
 * in tutti gli intervalli di produttivita minori del numero di ore giornaliere di lavoro
 * @param type $SecondiDaEscludere
 */
function updateProduttivitaInServizio($SecondiDaEscludere,$idUtente) {

  mysql_query("UPDATE produttivita SET in_servizio = 1 WHERE diff<" .$SecondiDaEscludere ." AND id_utente=".$idUtente) 
          or die("ERROR IN script_produttivita- FUNCTION updateTempInServizio - UPDATE produttivita.in_servizio : " . mysql_error());
}

/**
 * Modifica il campo attivo della tabella produttivita ponendolo =1 in tutti gli 
 * intervalli di produttivitao minori del produttivitao di inattivita 
 * @param type $SecondiInattivita
 */
function updateProduttivitaAttivo($SecondiInattivita,$idUtente) {

  mysql_query("UPDATE produttivita SET attivo = 1 WHERE diff<" . $SecondiInattivita."  AND id_utente=".$idUtente) 
          or die("ERROR IN script_produttivita - FUNCTION updateTempAttivo - UPDATE serverdb.produttivita.attivo : " . mysql_error());
}

/**
 * Seleziona il totale in secondi del servizio lavorativo dalla tabella produttivita
 * @return type
 */
function selectSecInServizioFromProduttivita($idUtente) {
  
  $sql = mysql_query("SELECT SUM(diff) AS num_sec_in_servizio FROM produttivita WHERE in_servizio=1 AND id_utente=".$idUtente) 
          or die("ERROR IN script_produttivita - FUNCTION  selectSecInServizioFromTemp - SELECT FROM serverdb.produttivita : " . mysql_error());
  return $sql;
}

/**
 * Seleziona il totale dei secondi di inattivita durante le ore di servizio
 * @return type
 */
function selectSecInatFromProduttivita($idUtente) {
  
  $sql = mysql_query("SELECT SUM(diff) AS num_sec_inat FROM produttivita WHERE attivo=0 AND in_servizio=1 AND id_utente=".$idUtente) 
          or die("ERROR IN script_produttivita - FUNCTION selectSecInatFromTemp - SELECT FROM produttivita : " . mysql_error());
  return $sql;
}

/**
 * Calcola il totale delle ore di produzione effettiva
 * @return type
 */
function selectSecProdFromProduttivita($idUtente) {
   
  $sql = mysql_query("SELECT SUM(diff) AS num_sec_prod FROM produttivita WHERE attivo=1 AND in_servizio=1 AND id_utente=".$idUtente) 
          or die("ERROR IN script_produttivita - FUNCTION selectSecProdFromTemp - SELECT FROM produttivita : " . mysql_error());
  return $sql;
}

/**
 * Calcola il numero totale di sacchi prodotti
 * @return type
 */
function selectNumSacFromProduttivita($idUtente) {
   
  $sql = mysql_query("SELECT count(id_processo) as num_sac FROM serverdb.produttivita WHERE id_utente=".$idUtente) 
          or die("ERROR IN script_produttivita - FUNCTION selectNumSacFromTemp - SELECT * FROM serverdb.produttivita: " . mysql_error());
  return $sql;
}


/**
 * Seleziona i processi da visualizzare dalla tabella produttività
 * @param type $idMacchina
 * @param type $dataTo
 * @param type $dataFrom
 * @param type $inServizio
 * @param type $attivo
 * @param type $idProcesso
 * @param type $codProdotto
 * @param type $codChimica
 * @param type $codSacco
 * @param type $nominativo
 * @param type $att
 * @param type $prec
 * @param type $nomeProdotto
 * @param type $descriStab
 * @return type
 */
function selectProcessiTempByFiltri($idMacchina,
                            $dataTo,
                            $dataFrom,
                            $inServizio,
                            $attivo,
                            $idProcesso,
                            $codProdotto,
                            $codChimica,
                            $codSacco,
                            $nominativo,
                            $att,
                            $prec,
                            $nomeProdotto,
                            $descriStab,
                            $idUtente,
                            $filtro){
  
   $sql = mysql_query("SELECT
                            id_processo,
                            prec,
                            att,
                            p.id_macchina,
                            p.cod_prodotto,
                            cod_chimica,
                            cod_sacco,
                            cod_operatore,
                            pr.nome_prodotto,
                            f.nominativo,
                            s.gruppo,
                            s.geografico,
                            s.descri_stab
                        FROM
                            produttivita p                        
                        LEFT JOIN 
                            prodotto pr
                            ON p.cod_prodotto=pr.cod_prodotto 
                        INNER JOIN 
                            stab_gruppo_geo s 
                            ON p.id_macchina=s.id_macchina
                        LEFT JOIN 
                            figura f
                            ON p.cod_operatore=f.codice 
                        WHERE 
                                p.id_utente=".$idUtente."
                            AND 
                                s.id_utente=".$idUtente."
                            AND    
                                att<='" . $dataTo . "'
                            AND
                                prec>='" . $dataFrom . "'
                            AND 
                                in_servizio LIKE '%" . $inServizio . "%'
                            AND 
                                attivo LIKE '%" . $attivo . "%'
                            AND 
                                id_processo LIKE '%" . $idProcesso . "%'
                            AND 
                                p.cod_prodotto LIKE '%" . $codProdotto . "%'
                            AND 
                                cod_chimica LIKE '%" . $codChimica . "%'
                            AND 
                                cod_sacco LIKE '%" . $codSacco . "%'
                            AND 
                                (f.nominativo LIKE '%" . $nominativo . "%' OR f.nominativo IS NULL)
                            AND 
                                att LIKE '%" . $att . "%'
                            AND 
                                prec LIKE '%" . $prec . "%'      
                            AND 
                                nome_prodotto LIKE '%" . $nomeProdotto . "%' 
                            AND
                                s.descri_stab LIKE '%" . $descriStab . "%' 
                        ORDER BY ".$filtro)
           or die("ERROR IN script_produttivita - FUNCTION selectProcessiTempByFiltri - SELECT * FROM produttivita: " . mysql_error());
  
  return $sql;
  
}

/**
 * Seleziona i processi da visualizzare dalla tabella produttività
 * @param type $idMacchina
 * @param type $dataTo
 * @param type $dataFrom
 * @param type $inServizio
 * @param type $attivo
 * @param type $idProcesso
 * @param type $codProdotto
 * @param type $codChimica
 * @param type $codSacco
 * @param type $nominativo
 * @param type $att
 * @param type $prec
 * @param type $nomeProdotto
 * @param type $descriStab
 * @return type
 */
function selectProcessiTempByFiltri2($idMacchina,
                            $dataTo,
                            $dataFrom,
                            $inServizio,
                            $attivo,
                            $idProcesso,
                            $codProdotto,
                            $codChimica,
                            $codSacco,
                            $nominativo,
                            $att,
                            $prec,
                            $nomeProdotto,
                            $descriStab,
                            $idUtente,
                            $filtro){
  
   $sql = mysql_query("SELECT
                            id_processo,
                            prec,
                            att,
                            p.id_macchina,
                            p.cod_prodotto,
                            cod_chimica,
                            cod_sacco,
                            cod_operatore,
                            pr.id_prodotto,
                            pr.nome_prodotto,
                            f.nominativo,
                            m.descri_stab
                        FROM
                            produttivita p                        
                        INNER JOIN 
                            prodotto pr
                            ON pr.cod_prodotto=p.cod_prodotto 
                        INNER JOIN 
                            macchina m
                            ON p.id_macchina=m.id_macchina 
                        LEFT JOIN 
                            figura f
                            ON p.cod_operatore=f.codice 
                        WHERE 
                                p.id_utente=".$idUtente."
                            AND 
                                p.id_macchina=".$idMacchina."
                            AND    
                                att<='" . $dataTo . "'
                            AND
                                prec>='" . $dataFrom . "'
                            AND 
                                in_servizio LIKE '%" . $inServizio . "%'
                            AND 
                                attivo LIKE '%" . $attivo . "%'
                            AND 
                                id_processo LIKE '%" . $idProcesso . "%'
                            AND 
                                p.cod_prodotto LIKE '%" . $codProdotto . "%'
                            AND 
                                cod_chimica LIKE '%" . $codChimica . "%'
                            AND 
                                cod_sacco LIKE '%" . $codSacco . "%'
                            AND 
                                (f.nominativo LIKE '%" . $nominativo . "%' OR f.nominativo IS NULL)
                            AND 
                                att LIKE '%" . $att . "%'
                            AND 
                                prec LIKE '%" . $prec . "%'      
                            AND 
                                nome_prodotto LIKE '%" . $nomeProdotto . "%' 
                            AND
                                m.descri_stab LIKE '%" . $descriStab . "%' 
                        ORDER BY ".$filtro)
           or die("ERROR IN script_produttivita - FUNCTION selectProcessiTempByFiltri2 - SELECT * FROM produttivita: " . mysql_error());
  
  return $sql;
  
}

/**
 * Seleziona i processi da visualizzare dalla tabella produttività
 * @param type $idMacchina
 * @param type $dataTo
 * @param type $dataFrom
 * @param type $inServizio
 * @param type $attivo
 * @param type $idProcesso
 * @param type $codProdotto
 * @param type $codChimica
 * @param type $codSacco
 * @param type $nominativo
 * @param type $att
 * @param type $prec
 * @param type $nomeProdotto
 * @param type $descriStab
 * @return type
 */
function selectProcessiTempByFiltriXX($objStabGrupGeo, 
        $objProduttivita, 
        $idMacchina, 
        $dataTo, 
        $dataFrom, 
        $inServizio,
        $attivo, 
        $idProcesso, 
        $codProdotto, 
        $codChimica,
        $codSacco, 
        $nominativo, 
        $prec, 
        $nomeProdotto, 
        $descriStab, 
        $filtro) {

    $string = "SELECT
                            p.id_processo,
                            p.dt_produzione_mac,
                            p.id_macchina,
                            p.cod_prodotto,
                            pr.id_prodotto,
                            p.cod_chimica,
                            p.cod_sacco,
                            p.cod_operatore,
                            pr.nome_prodotto,
                            f.nominativo,
                            am.gruppo,
                            am.geografico,
                            m.descri_stab
                        FROM
                            processo p
                        INNER JOIN prodotto pr ON p.cod_prodotto = pr.cod_prodotto
                        LEFT JOIN 
                            figura f
                            ON p.cod_operatore=f.codice 
                        INNER JOIN macchina m ON p.id_macchina=m.id_macchina
                        INNER JOIN anagrafe_macchina am ON p.id_macchina=am.id_macchina
                        WHERE 
                            p.id_macchina IN (";

    for ($i = 0; $i < count($objStabGrupGeo); $i++) {
        if ($i > 0) {
            $string .= " , ";
        }
        $string .= $objStabGrupGeo[$i]->getId_macchina();
    }

    $string.=") AND p.id_processo IN (";
    for ($i = 0; $i < count($objProduttivita); $i++) {
//        if($objProduttivita[$i]->getAttivo()==$attivo AND $objProduttivita[$i]->getIn_servizio()==$inServizio){
        if ($i > 0 ) {
            $string .= " , ";
        }
        $string .= $objProduttivita[$i]->getId_processo();
//        }
    }

    $string.=")             AND    
                                dt_produzione_mac<='" . $dataTo . "'
                            AND
                                dt_produzione_mac>='" . $dataFrom . "'
                            AND 
                                id_processo LIKE '%" . $idProcesso . "%'
                            AND 
                                p.cod_prodotto LIKE '%" . $codProdotto . "%'
                            AND 
                                cod_chimica LIKE '%" . $codChimica . "%'
                            AND 
                                cod_sacco LIKE '%" . $codSacco . "%'
                            AND 
                                (f.nominativo LIKE '%" . $nominativo . "%' OR f.nominativo IS NULL)
                            AND 
                                dt_produzione_mac LIKE '%" . $prec . "%'
                            AND 
                                nome_prodotto LIKE '%" . $nomeProdotto . "%' 
                            AND
                                m.descri_stab LIKE '%" . $descriStab . "%' 
                        ORDER BY " . $filtro;
//    echo $string;
    $sql = mysql_query($string) or die("ERROR IN script_produttivita - FUNCTION selectProcessiTempByFiltriXX - SELECT * FROM produttivita: " .$string." ". mysql_error());

    return $sql;
}






/**
 * Seleziona i processi da visualizzare dalla tabella produttività
 * @param type $idMacchina
 * @param type $dataTo
 * @param type $dataFrom
 * @param type $inServizio
 * @param type $attivo
 * @param type $idProcesso
 * @param type $codProdotto
 * @param type $codChimica
 * @param type $codSacco
 * @param type $nominativo
 * @param type $att
 * @param type $prec
 * @param type $nomeProdotto
 * @param type $descriStab
 * @return type
 */
function selectProcessiTempAllByFiltri(
                            $dataTo,
                            $dataFrom,
                            $inServizio,
                            $attivo,
                            $idProcesso,
                            $codProdotto,
                            $codChimica,
                            $codSacco,
                            $nominativo,
                            $att,
                            $prec,
                            $nomeProdotto,
                            $descriStab,
                            $idUtente,
                            $filtro){
  
   $sql = mysql_query("SELECT
                            id_processo,
                            prec,
                            att,
                            p.id_macchina,
                            p.cod_prodotto,
                            cod_chimica,
                            cod_sacco,
                            cod_operatore,
                            pr.nome_prodotto,
                            pr.id_prodotto,
                            f.nominativo,
                            m.descri_stab
                        FROM
                            produttivita p                        
                        INNER JOIN 
                            prodotto pr
                            ON pr.cod_prodotto=p.cod_prodotto 
                        INNER JOIN 
                            macchina m
                            ON p.id_macchina=m.id_macchina 
                        LEFT JOIN 
                            figura f
                            ON p.cod_operatore=f.codice 
                        WHERE 
                                p.id_utente=".$idUtente."
                            AND 
                                att<='" . $dataTo . "'
                            AND
                                prec>='" . $dataFrom . "'
                            AND 
                                in_servizio LIKE '%" . $inServizio . "%'
                            AND 
                                attivo LIKE '%" . $attivo . "%'
                            AND 
                                id_processo LIKE '%" . $idProcesso . "%'
                            AND 
                                p.cod_prodotto LIKE '%" . $codProdotto . "%'
                            AND 
                                cod_chimica LIKE '%" . $codChimica . "%'
                            AND 
                                cod_sacco LIKE '%" . $codSacco . "%'
                            AND 
                                (f.nominativo LIKE '%" . $nominativo . "%' OR f.nominativo IS NULL)
                            AND 
                                att LIKE '%" . $att . "%'
                            AND 
                                prec LIKE '%" . $prec . "%'      
                            AND 
                                nome_prodotto LIKE '%" . $nomeProdotto . "%' 
                            AND
                                m.descri_stab LIKE '%" . $descriStab . "%' 
                        ORDER BY ".$filtro)
           or die("ERROR IN script_produttivita - FUNCTION selectProcessiTempAllByFiltri - SELECT * FROM produttivita: " . mysql_error());
  
  return $sql;
  
}


?>
