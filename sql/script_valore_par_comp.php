<?php

//##############################################################################
//################### SERVERDB #################################################
//##############################################################################
/**
 * Inserisce un nuovo record nella tabella valore_par_comp
 * @param type $idParComp
 * @param type $idComp
 * @param type $valoreVar
 * @param type $valoreIn
 * @param type $dtValoreIn
 * @param type $valoreMac
 * @param type $idMacchina
 * @param type $abilitato
 * @param type $dtAbilitato
 * @return type
 */
function insertNewRecordValoreParComp($idParComp, $idComp, $valoreVar, $valoreIn, $dtValoreIn, $valoreMac, $idMacchina, $abilitato, $dtAbilitato) {

    $stringSql = "INSERT INTO serverdb.valore_par_comp (
                                                        id_par_comp,
                                                        id_comp,
                                                        valore_variabile,
                                                        valore_iniziale,
                                                        dt_valore_iniziale,
                                                        valore_mac,
                                                        id_macchina,
                                                        abilitato,
                                                        dt_abilitato)		
                                                        VALUES (
							" . $idParComp . ",
                                                        " . $idComp . ",
                                                        '" . $valoreVar . "',
							'" . $valoreIn . "',
							'" . $dtValoreIn . "',
                                                        '" . $valoreMac . " ',  
                                                        " . $idMacchina . ",
							" . $abilitato . ",
							'" . $dtAbilitato . "')";

    $sql = mysql_query($stringSql);
    //or die("ERROR IN script_valore_par_comp - FUNCTION insertNewRecordValoreParComp - " .$stringSql." ". mysql_error());;

    return $sql;
}

/**
 * Inserisce nella tabela valore_par_comp tutti i parametri presenti nella tabella
 * parametro_comp_prod associandoli all'id del componente dato
 * @param type $idComponente
 * @param type $dtAbilitato
 * @return type
 */
function inserisciValParComp($idComponente, $dtAbilitato) {

    $stringSql = "INSERT INTO serverdb.valore_par_comp (id_comp,
                                             id_par_comp,
                                             valore_variabile,
                                             id_macchina,
                                             abilitato,
                                             dt_abilitato,valore_iniziale,valore_mac) 
                    SELECT  
                        " . $idComponente . ",							
                        parametro_comp_prod.id_par_comp,
                        parametro_comp_prod.valore_base,
                        macchina.id_macchina,
                        1,
                        '" . $dtAbilitato . "',
                        parametro_comp_prod.valore_base,
                        ''
                        FROM 
                            serverdb.parametro_comp_prod,serverdb.macchina";

    $sql = mysql_query($stringSql);
    //or die("ERROR IN script_valore_par_comp - FUNCTION inserisciValParComp - " .$stringSql." ". mysql_error());;

    return $sql;
}

function findValoreParCompByIdMacchina($idMacchina, $filtro, $idValParComp, $idParComp, $nomeVariabile, $descriComponente, $valoreVariabile, $dtAbilitato, $valoreIniziale, $dtValoreIniziale, $valoreMacchina, $dtModificaMac, $dtAgg, $strUtentiAziende) {
    $stringSql = "SELECT *,v.dt_abilitato AS dt_abilitato FROM
                            serverdb.valore_par_comp v
                        INNER JOIN serverdb.macchina m
                        ON 
                            v.id_macchina = m.id_macchina
                        INNER JOIN serverdb.parametro_comp_prod p
                        ON 
                            v.id_par_comp = p.id_par_comp
                        INNER JOIN serverdb.componente c 
                        ON 
                            v.id_comp = c.id_comp                                            
                        WHERE 
                            v.id_macchina=" . $idMacchina . "
                        AND 
                            id_val_comp LIKE '%" . $idValParComp . "%'
                        AND 
                            p.id_par_comp LIKE '%" . $idParComp . "%'
                        AND 
                            nome_variabile LIKE '%" . $nomeVariabile . "%'
                        AND 
                            descri_componente LIKE '%" . $descriComponente . "%'
                        AND 
                            valore_variabile LIKE '%" . $valoreVariabile . "%'
                        AND 
                            v.dt_abilitato LIKE '%" . $dtAbilitato . "%'
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
                        AND         
                            (c.id_utente,c.id_azienda) IN " . $strUtentiAziende . "                         
                        ORDER BY
                            " . $filtro;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_valore_par_comp - FUNCTION findValoreParCompByIdMacchina - " . $stringSql . " - " . mysql_error());
    return $sql;
}

function updateValoreParComp($valore, $dataCorrente, $idParComp, $idComp, $idMacchina) {
    $stringSql = "UPDATE serverdb.valore_par_comp SET dt_abilitato=if(valore_variabile != '" . $valore . "','" . $dataCorrente . "',dt_abilitato),
                                                valore_variabile=if(valore_variabile != '" . $valore . "','" . $valore . "',valore_variabile)
				WHERE
                                    id_par_comp=" . $idParComp . "
                                AND 
                                    id_comp=" . $idComp . "
                                AND
                                    id_macchina=" . $idMacchina;

    $sql = mysql_query($stringSql);
//or die("ERRROR IN  4 UPDATE serverdb.valore_par_comp : " . mysql_error());
    return $sql;
}

function impostaValoriInizialiComp($idMacchina) {

    $sql = mysql_query("UPDATE serverdb.valore_par_comp 
			SET 
				dt_valore_iniziale='" . dataCorrenteInserimento() . "',
                                valore_iniziale = valore_variabile,
				dt_abilitato='" . dataCorrenteInserimento() . "'
     WHERE 
        valore_par_comp.id_macchina=" . $idMacchina);
    //or die("ERROR IN script_valore_par_comp - FUNCTION impostaValoriInizialiComp - UPDATE serverdb.valore_par_comp : " . mysql_error());
    return $sql;
}

//##############################################################################
//################### STORICO ##################################################
//##############################################################################
//TESTARE 
function insertIntoValParCompStorico($idValComp, $idComp, $idParComp, $idMacchina, $valoreVariabile, $abilitato, $dtAbilitato) {

    $sql = mysql_query("INSERT INTO storico.valore_par_comp	(
                        id_val_comp,
                        id_comp,
                        id_par_comp,
                        id_macchina,
                        valore_variabile,
                        abilitato,
                        dt_abilitato) 
                VALUES (
                      " . $idValComp . ",
                      " . $idComp . ",
                      " . $idParComp . ",
                      " . $idMacchina . ",
                     '" . $valoreVariabile . "',
                      0,
                     '" . $dtAbilitato . "')
                     ");
//        or die("ERROR IN script_valore_par_comp - FUNCTION  insertIntoValParCompStorico - INSERT INTO  storico.valore_par_comp : " . mysql_error());

    return $sql;
}

/**
 * Inserisce un nuovo record
 * @param unknown $nomeParametro
 * @param unknown $valoreBase
 * @param unknown $dataCorrente
 * @return resource
 */
function insertNewValoreParComp($nomeParametro, $valoreBase, $dataCorrente) {
    $sqlString = "INSERT INTO serverdb.valore_par_comp 
                    (id_comp,id_par_comp,valore_variabile,valore_iniziale,valore_mac,id_macchina,abilitato,dt_abilitato) 
                    SELECT  
                            componente.id_comp,
                            parametro_comp_prod.id_par_comp,
                            '" . $valoreBase . "',
                            '" . $valoreBase . "',
                            '" . $valoreBase . "',
                            macchina.id_macchina,
                            1,
                            '" . $dataCorrente . "'
                    FROM 
                            serverdb.parametro_comp_prod,serverdb.componente,serverdb.macchina
                    WHERE 
                            parametro_comp_prod.nome_variabile='" . $nomeParametro . "'";

    $sql = mysql_query($sqlString);
    //or die("ERROR IN script_valore_par_comp - FUNCTION insertNewValoreParComp - ".$sqlString ." ". mysql_error());
    return $sql;
}

/**
 * Seleziona alcuni campi del record di serverdb.valore_par_comp selezionato per id_par_comp
 * @param unknown $idParametro
 * @return resource
 */
function selectIdValCompByIdParComp($idParametro) {
    $sqlString = "SELECT 	
                                            id_val_comp,
                                            id_par_comp,
                                            id_comp,
                                            id_macchina,
                                            valore_variabile,
                                            valore_iniziale,
                                            dt_valore_iniziale,
                                            dt_modifica_mac,
                                            dt_agg_mac,
                                            valore_mac
                                        FROM 
                                                serverdb.valore_par_comp 
                                        WHERE 
                                                id_par_comp=" . $idParametro;

    $sql = mysql_query($sqlString)
            or die("ERROR IN script_valore_par_comp - FUNCTION selectIdValCompByIdParComp - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Inserisce un nuovo record nello storico
 * @param unknown $IdValParComp
 * @param unknown $IdParametroOld
 * @param unknown $IdComp
 * @param unknown $IdMacchina
 * @param unknown $ValoreVariabile
 * @param unknown $ValoreIniziale
 * @param unknown $DtValoreIniziale
 * @param unknown $DtModificaMacchina
 * @param unknown $DtAggMacchina
 * @param unknown $ValoreMacchina
 * @return resource
 */
function insertStoricoValoreParComp($IdValParComp, $IdParametroOld, $IdComp, $IdMacchina, $ValoreVariabile, $ValoreIniziale, $DtValoreIniziale, $DtModificaMacchina, $DtAggMacchina, $ValoreMacchina) {
    $sqlString = "INSERT INTO storico.valore_par_comp
                                            (id_val_comp,
                                            id_par_comp,
                                            id_comp,
                                            id_macchina,
                                            valore_variabile,
                                            abilitato,
                                            dt_abilitato,
                                            valore_iniziale,
                                            dt_valore_iniziale,
                                            dt_modifica_mac,
                                            dt_agg_mac,
                                            valore_mac)
                                    VALUES(
                                                '" . $IdValParComp . "',
                                                '" . $IdParametroOld . "',
                                                '" . $IdComp . "',
                                                '" . $IdMacchina . "',
                                                '" . $ValoreVariabile . "',
                                                0,
                                                NOW(),
                                                '" . $ValoreIniziale . "',
                                                '" . $DtValoreIniziale . "',
                                                '" . $DtModificaMacchina . "',
                                                '" . $DtAggMacchina . "',
                                                '" . $ValoreMacchina . "'
                                                )";

    $sql = mysql_query($sqlString)
            or die("ERROR IN script_valore_par_comp - FUNCTION insertStoricoValoreParComp - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * Aggiorna i campi dt_abilitato e id_par_comp in serverdb.valore_par_comp 
 * @param unknown $idParametro
 * @param unknown $dataCorrente
 * @param unknown $idParametroOld
 * @return resource
 */
function updateIdParAndDtByIdParComp($idParametro, $dataCorrente, $idParametroOld) {
    $sqlString = "UPDATE serverdb.valore_par_comp 
						SET
                                                dt_abilitato=if(id_par_comp != '" . $idParametro . "',
                                                    '" . $dataCorrente . "',
                                                        dt_abilitato),
                                                id_par_comp=if(id_par_comp != '" . $idParametro . "',
                                                    '" . $idParametro . "',
                                                    id_par_comp)
						WHERE 
                                                    id_par_comp='" . $idParametroOld . "'";

    $sql = mysql_query($sqlString)
            or die("ERROR IN script_valore_par_comp - FUNCTION updateIdParAndDtByIdParComp - " . $sqlString . " " . mysql_error());
    return $sql;
}

/**
 * 
 * @param unknown $idMacchina
 * @return resource
 */
//function selectValoreParCompInnerJoinParamById($idMacchina){
//	$sqlString= "SELECT
//                                                        valore_par_comp.id_par_comp,
//                                                        parametro_comp_prod.nome_variabile,
//                                                        parametro_comp_prod.descri_variabile
//                                                        FROM
//                                                        serverdb.valore_par_comp
//                                                INNER JOIN serverdb.macchina 
//                                                ON 
//                                                        valore_par_comp.id_macchina = macchina.id_macchina
//                                                INNER JOIN serverdb.parametro_comp_prod 
//                                                ON 
//                                                        valore_par_comp.id_par_comp = parametro_comp_prod.id_par_comp
//                                                WHERE 
//                                                        valore_par_comp.id_macchina=" . $idMacchina . "
//                                                GROUP BY 
//                                                valore_par_comp.id_par_comp					
//                                                ORDER BY 
//							parametro_comp_prod.id_par_comp";
//
//	$sql = mysql_query($sqlString)
//	or die("ERROR IN script_valore_par_comp - FUNCTION selectValoreParCompInnerJoinParamById - ".$sqlString ." ". mysql_error());
//	return $sql;
//}

/**
 * 
 * @param unknown $idMacchina
 * @param unknown $id_par_comp
 * @return resource
 */
//function selectValoreParCompInnerJoinComponenteById($idMacchina, $id_par_comp){
//	$sqlString= "SELECT
//                                                            componente.id_comp,
//                                                            componente.descri_componente,
//                                                            valore_par_comp.valore_variabile
//                                                    FROM
//                                                            serverdb.valore_par_comp
//                                                    INNER JOIN serverdb.macchina 
//                                                    ON 
//                                                            valore_par_comp.id_macchina = macchina.id_macchina
//                                                    INNER JOIN serverdb.componente 
//                                                    ON 
//                                                            valore_par_comp.id_comp = componente.id_comp
//                                                    WHERE 
//                                                            valore_par_comp.id_macchina=" . $idMacchina . "
//                                                    AND 
//                                                            valore_par_comp.id_par_comp=" . $id_par_comp . "
//                                                    ORDER BY 
//                                                            componente.descri_componente";
//
//	$sql = mysql_query($sqlString)
//	or die("ERROR IN script_valore_par_comp - FUNCTION selectValoreParCompInnerJoinComponenteById - ".$sqlString ." ". mysql_error());
//	return $sql;
//}



function insertIfNotExistValParComp($idComp, $idParComp, $valoreVariabile, $idMacchina, $dtAbilitato) {
  $sqlString = "INSERT INTO serverdb.valore_par_comp (id_comp,
                                             id_par_comp,
                                             valore_variabile,
                                             id_macchina,
                                             abilitato,
                                             dt_abilitato,valore_iniziale,valore_mac)
SELECT " . $idComp . "," . $idParComp . ",'" . $valoreVariabile . "'," . $idMacchina . ",'1', '" . $dtAbilitato . "','" . $valoreVariabile . "','" . $valoreVariabile . "' FROM DUAL
WHERE NOT EXISTS (SELECT * FROM serverdb.valore_par_comp WHERE
id_comp=" . $idComp . " AND
id_par_comp=" . $idParComp . " AND 
id_macchina=" . $idMacchina . ")";

    $sql = mysql_query($sqlString)
            or die("ERROR IN script_valore_par_comp - FUNCTION insertIfNotExistValParComp - " . $sqlString . " " . mysql_error());
    return $sql;
}

?>
