<?php

/**
 * Seleziona i parmaetri visibili all'utente in base ai filtri impostati
 * @param type $nome
 * @param type $descri
 * @param type $unMisura
 * @param type $tipo
 * @param type $dtAbilitato
 * @param type $campoOrdine
 * @param type $campoGroupBy
 * @param type $strUtentiAziende
 * @return type
 */
function findAllParametriVisByFiltri($nome,$descri,$unMisura,$tipo,$dtAbilitato,$campoOrdine,$campoGroupBy,$strUtentiAziende) {
    $stringSql = "SELECT *
			FROM
                            serverdb.lab_parametro
                        WHERE 
                             nome_parametro LIKE '%".$nome."%'
                        AND 
                            descri_parametro LIKE '%".$descri."%'
                        AND 
                            unita_misura LIKE '%".$unMisura."%'
                        AND 
                            tipo LIKE '%" . $tipo . "%'
                        AND 
                            dt_abilitato LIKE '%" . $dtAbilitato . "%'
                        AND
                            (id_utente,id_azienda) IN ".$strUtentiAziende."
                                                   
			GROUP BY ".$campoGroupBy."                            
                        ORDER BY ".$campoOrdine; 
    $sql=mysql_query($stringSql) or die("ERROR IN script_lab_parametro - FUNCTION findAllParametriVisByFiltri - " .$stringSql." - ". mysql_error());
    return $sql;
}

/**
 * Seleziona i parametri del tipo = $tipo ordinandoli in base a $campoOrdine
 * @param type $tipo
 * @param type $campoOrdine
 * @return type
 */
function findParametriByTipo($tipo, $campoOrdine) {

    $sql = mysql_query("SELECT * FROM serverdb.lab_parametro 
                     WHERE tipo = '" . $tipo . "'
                     ORDER BY " . $campoOrdine) or die("ERROR IN script_lab_parametro - FUNCTION findParametriByTipo - SELECT FROM serverdb.lab_parametro : " . mysql_error());

    return $sql;
}


/**
 * Seleziona i parametri visibili del tipo = $tipo ordinandoli in base a $campoOrdine
 * @param type $tipo
 * @param type $campoOrdine
 * @param type $strUtentiAziende
 * @return type
 */
function findParametriByTipoVis($tipo, $campoOrdine,$strUtentiAziende) {

    $stringSql="SELECT * FROM serverdb.lab_parametro 
                     WHERE (id_utente,id_azienda) IN ".$strUtentiAziende." AND tipo = '" . $tipo . "'
                     ORDER BY " . $campoOrdine;
    $sql = mysql_query($stringSql) or die("ERROR IN script_lab_parametro - FUNCTION findParametriByTipoVis - " .$stringSql." - ". mysql_error());

    return $sql;
}

/**
 * Verifica l'esistenza di un parametro con lo stesso nome nella tabella lab_parametro
 * in caso di inserimento di un nuovo parametro
 * @param type $nome
 */
function verificaEsistenzaNewPar($nome) {

    $sql = mysql_query("SELECT * FROM lab_parametro WHERE nome_parametro = '" . $nome . "'") or die("ERROR IN script_lab_parametro - FUNCTION verificaEsistenzaParametro - SELECT FROM serverdb.lab_parametro : " . mysql_error());
    return $sql;
}

/**
 * Verifica l'esistenza di un parametro con lo stesso nome e id diverso
 * nella tabella lab_parametro, in fase di modifica di un parametro esistente
 * @param type $nome
 */
function verificaEsistenzaModPar($nome, $idPar) {

    $sql = mysql_query("SELECT * FROM lab_parametro WHERE nome_parametro = '" . $nome . "' AND id_par <> " . $idPar) or die("ERROR IN script_lab_parametro - FUNCTION verificaEsistenzaParametro - SELECT FROM serverdb.lab_parametro : " . mysql_error());
    return $sql;
}

/**
 * Inserisce un nuovo parametro nella tabella lab_parametro
 * @param type $nomeParametro
 * @param type $descrizione
 * @param type $unitaMisura
 * @param type $tipo
 * @param type $data
 * @param type $idUtente
 * @param type $idAzienda
 * @return type
 */
function inserisciNuovoParametro($nomeParametro, $descrizione, $unitaMisura, $tipo, $data,$idUtente,$idAzienda) {

    $sql = mysql_query("INSERT INTO lab_parametro (nome_parametro, descri_parametro, unita_misura, tipo, dt_abilitato,id_utente,id_azienda) 
		VALUES ( '" . $nomeParametro .
            "','" . $descrizione .
            "','" . $unitaMisura .
            "','" . $tipo .
            "','" . $data . "',".$idUtente.",".$idAzienda.")");
//            or die("ERROR IN script_lab_parametro - FUNCTION inserisciNuovoParametro - INSERT INTO serverdb.lab_parametro : " . mysql_error());   
    return $sql;
}

/**
 * Modifica di un parametro esistente nella tabella lab_parametro
 * @return type
 */
function modificaParametro($nome,$descri,$unitaMisura,$tipo,$data,$idPar,$idAzienda) {
    $sql = mysql_query("UPDATE lab_parametro  
                        SET  
                                nome_parametro='" . $nome . "',
                                descri_parametro='" . $descri . "',
                                unita_misura='" . $unitaMisura . "',
                                tipo='" . $tipo . "',
                                dt_abilitato='" . $data . "',
                                id_azienda='" . $idAzienda . "'
                        WHERE 
                                id_par=" . $idPar);
//            or die("ERROR IN script_lab_parametro - FUNCTION modificaParametro - UPDATE lab_parametro : " . mysql_error());
    return $sql;
}

/**
 * Cerca un parametro tramite l'id nella tabella lab_parametro
 * @param type $idPar
 */
function findParametroById($idPar) {
    $sql = mysql_query("SELECT * FROM lab_parametro WHERE id_par=" . $idPar) or die("ERROR IN script_lab_parametro - FUNCTION findParametroById - SELECT * FROM serverdb.lab_parametro :  " . mysql_error());
    return $sql;
}




/**
 * Seleziona i parametri visibili in base al nome ed al tipo
 * @param type $nome
 * @param type $tipo
 * @param type $campoOrdine
 * @param type $campoGroupBy
 * @param type $strUtentiAziende
 * @return type
 */
function findAllParametriVisByNomeAndTipo($nome,$tipo,$campoOrdine,$campoGroupBy,$strUtentiAziende){
    $stringSql = "SELECT *
			FROM
                            serverdb.lab_parametro
                        WHERE 
                            nome_parametro LIKE '%".$nome."%'
                        AND
                            tipo LIKE '%" . $tipo . "%'
                        AND
                            (id_utente,id_azienda) IN ".$strUtentiAziende."
                                                   
			GROUP BY ".$campoGroupBy."                            
                        ORDER BY ".$campoOrdine; 
    $sql=mysql_query($stringSql) or die("ERROR IN script_lab_parametro - FUNCTION findAllParametriVisByNomeAndTipo - " .$stringSql." - ". mysql_error());
    return $sql;
}
?>
