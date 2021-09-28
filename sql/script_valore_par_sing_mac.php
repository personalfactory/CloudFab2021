<?php

//##############################################################################
//########################### SERVERDB #########################################
//##############################################################################

function findValoreParSingMacByIdMacchina($idMacchina, $filtro, $idValSm, $idParSm, $nomeVariabile, $valoreVariabile, $dtAbilitato, $valoreIniziale, $dtValoreIniziale, $valoreMacchina, $dtModificaMac, $dtAgg) {

    $sql = mysql_query("SELECT                      
                        valore_par_sing_mac.id_val_par_sm,
                        valore_par_sing_mac.id_par_sm,
                        valore_par_sing_mac.valore_variabile,
                        valore_par_sing_mac.abilitato,
                        valore_par_sing_mac.dt_abilitato,
                        parametro_sing_mac.nome_variabile,
                        parametro_sing_mac.descri_variabile,
                        valore_par_sing_mac.valore_iniziale,                                      
                        valore_par_sing_mac.dt_valore_iniziale,
                        valore_par_sing_mac.valore_mac,
                        valore_par_sing_mac.dt_modifica_mac,
                        valore_par_sing_mac.dt_agg_mac
                    FROM
                        serverdb.valore_par_sing_mac
                    INNER JOIN serverdb.parametro_sing_mac 
                    ON 
                        valore_par_sing_mac.id_par_sm = parametro_sing_mac.id_par_sm
                   WHERE 
                        valore_par_sing_mac.id_macchina=" . $idMacchina . "
                   AND 
                      id_val_par_sm LIKE '%" . $idValSm . "%'
                  AND 
                      valore_par_sing_mac.id_par_sm LIKE '%" . $idParSm . "%'
                  AND 
                      nome_variabile LIKE '%" . $nomeVariabile . "%'
                  AND 
                      valore_variabile LIKE '%" . $valoreVariabile . "%'
                  AND 
                      valore_par_sing_mac.dt_abilitato LIKE '%" . $dtAbilitato . "%'
                  AND 
                      valore_iniziale LIKE '%" . $valoreIniziale . "%'
                  AND 
                      dt_valore_iniziale LIKE '%" . $dtValoreIniziale . "%'
                  AND 
                      valore_mac LIKE '%" . $valoreMacchina . "%'
                  AND 
                      dt_modifica_mac LIKE '%" . $dtModificaMac . "%'
                  AND 
                      dt_agg_mac LIKE '%" . $dtAgg . "%'       
                  ORDER BY " . $filtro);
    //or die("ERROR IN script_valore_par_sing_mac -FUNCTION findValoreParSingMacByIdMacchina - SELECT FROM valore_par_sing_mac: " . mysql_error());
    return $sql;
}

function updateValoreParSingMac($valore, $data, $idParSm, $idMacchina) {

    $sql = mysql_query("UPDATE serverdb.valore_par_sing_mac 
                  SET 
				dt_abilitato=if(valore_variabile != '" . $valore . "','" . $data . "',dt_abilitato),
        valore_variabile=if(valore_variabile != '" . $valore . "','" . $valore . "',valore_variabile)
			WHERE
				id_par_sm=" . $idParSm . "
			AND
			id_macchina=" . $idMacchina);
    //or die("ERROR IN script_valore_par_sing_mac -FUNCTION updateValoreParSingMac - UPDATE serverdb.valore_par_sing_mac : " . mysql_error());
    return $sql;
}

function updateValoreInizialeSm($dataCorrente, $idMacchina) {
    $sql = mysql_query("UPDATE serverdb.valore_par_sing_mac 
			SET 
				dt_valore_iniziale='" . $dataCorrente . "',
                                valore_iniziale = valore_variabile,
				dt_abilitato='" . $dataCorrente . "'
                        WHERE 
                            valore_par_sing_mac.id_macchina=" . $idMacchina);
//or die("ERROR IN script_valore_par_sing_mac -FUNCTION updateValoreInizialeSm - UPDATE serverdb.valore_par_sing_mac : " . mysql_error());

    return $sql;
}

/**
 * Seleziona alcuni campi per id
 * @param unknown $idParametro
 * @param unknown $connessione
 * @return resource
 */
function selectIdValSMById($idParametro, $connessione) {
    $sqlString = "SELECT
							id_val_par_sm,
							id_par_sm,
							id_macchina,
							valore_variabile
						FROM
							serverdb.valore_par_sing_mac
						WHERE
							id_par_sm=" . $idParametro;


    $sql = mysql_query($sqlString, $connessione) or die("ERROR IN script_valore_par_sing_mac - FUNCTION selectIdValSMById - " . $sqlString . " " . mysql_error());
    return $sql;
}

function insertValoreParSingMac($idParSm, $valoreVar, $valoreSm, $dtValoreIn, $valoreMac, $idMacchina, $abilitato, $dtAbilitato) {

    
    $stringSql = "INSERT INTO serverdb.valore_par_sing_mac (
                                                        id_par_sm,
                                                        valore_variabile,
                                                        valore_iniziale,
                                                        dt_valore_iniziale,
                                                        valore_mac,
                                                        id_macchina,
                                                        abilitato,
                                                        dt_abilitato)
                                                        VALUES (
                                                        " . $idParSm . ", 
                                                        '" . $valoreVar . "',
                                                        '" . $valoreSm . "',
                                                        '" . $dtValoreIn . "',
                                                        '" . $valoreMac . " ',
                                                        " . $idMacchina . ",
                                                        " . $abilitato . ", 
                                                        '" . $dtAbilitato . "')";
    $sql = mysql_query($stringSql);
    //or die("ERROR IN script_valore_par_sing_mac - FUNCTION insertValoreParSingMac - " . $stringSql . " " . mysql_error());
    return $sql;
}

//##############################################################################
//########################### STORICO #########################################
//##############################################################################

function insertIntoValoreParSingMacStorico($idValParSm, $idParSm, $idMacchina, $valoreVariabile, $abilitato, $dtAbilitato) {


    $sql = mysql_query("INSERT INTO storico.valore_par_sing_mac	
				(id_val_par_sm,id_par_sm,id_macchina,valore_variabile,abilitato,dt_abilitato)
				VALUES(
						" . $idValParSm . ",
						" . $idParSm . ",
						" . $idMacchina . ",
						'" . $valoreVariabile . "',
						" . $abilitato . ",
					   	'" . $dtAbilitato . "')");
//		or die("ERROR IN script_valore_par_sing_mac -FUNCTION insertIntoValoreParSingMacStorico - INSERT INTO  storico.valore_par_sing_mac : " . mysql_error());
    return $sql;
}

/**
 * Inserisce un nuovo record nello storico con abilitazione = 0
 * @param unknown $idValParSm
 * @param unknown $idParametroOld
 * @param unknown $idMacchina
 * @param unknown $valoreVariabile
 * @param unknown $dtAbilitato
 * @return resource
 */
function insertStoricoValoreParSM($idValParSm, $idParametroOld, $idMacchina, $valoreVariabile, $abilitato, $dtAbilitato) {
    $sqlString = "INSERT INTO storico.valore_par_sing_mac	
									(id_val_par_sm,
									id_par_sm,
									id_macchina,
									valore_variabile,
									abilitato,
									dt_abilitato)
								VALUES(
									   " . $idValParSm . ",
									   " . $idParametroOld . ",
									   " . $idMacchina . ",
									   '" . $valoreVariabile . "',
									   " . $abilitato . ",
									   '" . $dtAbilitato . "')";





    /* "INSERT INTO storico.valore_par_sing_mac	
      (id_val_par_sm,
      id_par_sm,
      id_macchina,
      valore_variabile,
      abilitato,
      dt_abilitato)
      VALUES(
      " . $idValParSm . ",
      '" . $idParametroOld . "',
      '" . $idMacchina . "',
      '" . $valoreVariabile . "',
      0,
      '" . $dtAbilitato . "')"; */


    $sql = mysql_query($sqlString) or die("ERROR IN script_valore_par_sing_mac - FUNCTION insertStoricoValoreParSM - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Inserisce un nuovo record nella tabella valore_par_sing_mac dopo aver verificato che l'associazione 
 * id_par_sm - id_macchina non sia già presente in tabella
 * @param unknown $nomeParametro
 * @param unknown $valoreBase
 * @param unknown $dataCorrente
 * @return resource
 */
function insertValoreParSM($idParametro, $valoreBase, $valoreIniziale, $valoreMac, $idMacchina, $abilitato, $dataCorrente) {
    $sqlString = "INSERT INTO serverdb.valore_par_sing_mac 
             (id_par_sm,valore_variabile,valore_iniziale,valore_mac,id_macchina,abilitato,dt_abilitato) 
                   SELECT  
                        '" . $idParametro . "',
                        '" . $valoreBase . "',
                        '" . $valoreIniziale . "',
                        '" . $valoreMac . "',
                        " . $idMacchina . ",
                        " . $abilitato . ",
                        '" . $dataCorrente . "' FROM DUAL
                 WHERE NOT EXISTS 
                 (SELECT * FROM valore_par_sing_mac WHERE id_par_sm='" . $idParametro . "' AND id_macchina=" . $idMacchina . ")";


    $sql = mysql_query($sqlString)
	or die("ERROR IN script_valore_par_sing_mac - FUNCTION insertValoreParSM - ".$sqlString ." ". mysql_error());
    return $sql;
}

/**
 * 
 * @param unknown $idMacchina
 * @return resource
 */
//function selectValoreParSMLeftJoinParamById($idMacchina){
//	$sqlString= "SELECT
//                                                        valore_par_sing_mac.id_val_par_sm,
//                                                        valore_par_sing_mac.id_par_sm,
//                                                        parametro_sing_mac.nome_variabile,
//                                                        parametro_sing_mac.descri_variabile,
//                                                        valore_par_sing_mac.valore_variabile
//                                                FROM
//                                                        serverdb.valore_par_sing_mac
//                                                LEFT JOIN serverdb.macchina 
//                                                ON 
//                                                        valore_par_sing_mac.id_macchina = macchina.id_macchina
//                                                LEFT JOIN serverdb.parametro_sing_mac 
//                                                ON 
//                                                        valore_par_sing_mac.id_par_sm = parametro_sing_mac.id_par_sm
//                                                WHERE 
//                                                        valore_par_sing_mac.id_macchina=" . $idMacchina . "
//                                                ORDER BY 
//                                                        parametro_sing_mac.id_par_sm";
//
//
//	$sql = mysql_query($sqlString)
//	or die("ERROR IN script_valore_par_sing_mac - FUNCTION selectValoreParSMLeftJoinParamById - ".$sqlString ." ". mysql_error());
//	return $sql;
//}

function selectValByIdByMac($idParametro, $idMacchina) {
    $sqlString = "SELECT
							*
						FROM
							serverdb.valore_par_sing_mac
						WHERE
							id_par_sm=" . $idParametro. " AND id_macchina=". $idMacchina;


    $sql = mysql_query($sqlString) or die("ERROR IN script_valore_par_sing_mac - FUNCTION selectValByIdByMac - " . $sqlString . " " . mysql_error());
    return $sql;
}

?>
