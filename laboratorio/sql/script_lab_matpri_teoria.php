<?php
/**
 * Salva le quantità delle materie prime di una formula nella tabella lab_matpri_teoria
 * @param type $idMat
 * @param type $codice
 * @param type $dataCorrente
 * @param type $qtaMat
 * @param type $qtaMatPerc
 * @return type
 */
function salvaQtaFormula($idMat, $codice, $dataCorrente, $qtaMat, $qtaMatPerc, $tipo) {
   
    $sql = mysql_query("INSERT INTO lab_matpri_teoria (
        id_mat,cod_lab_formula,dt_inser,qta_teo,qta_teo_perc,tipo)
                        VALUES ( 
                                '" . $idMat . "',
                                '" . $codice . "',
                                '" . $dataCorrente . "',
                                '" . $qtaMat . "',
                                '" . $qtaMatPerc . "',
                                '" . $tipo . "'   )");
//            or die("ERROR IN script_lab_matpri_teoria - FUNCTION salvaQtaFormula - INSERT INTO serverdb.script_lab_matpri_teoria " . mysql_error());
    return $sql;
}

/**
 * Restituisce tutti i componenti e le materie prime di una formula, con le qta ed il prezzo  
 * @param type $codiceFormula
 * @return type
 */
function findMatCompFormulaByCodice($codiceFormula) {
    $sql = mysql_query("SELECT
                            lab_matpri_teoria.id_matpri_teo,
                            lab_matpri_teoria.qta_teo,
                            lab_matpri_teoria.dt_inser,
                            lab_materie_prime.descri_materia,
                            lab_materie_prime.prezzo,
                            lab_materie_prime.id_mat,
                            lab_materie_prime.unita_misura,
                            lab_materie_prime.cod_mat
                    FROM
                            serverdb.lab_matpri_teoria
                    INNER JOIN
                            serverdb.lab_materie_prime
                            ON
                                    lab_matpri_teoria.id_mat=lab_materie_prime.id_mat
                    WHERE 
                            cod_lab_formula='" . $codiceFormula . "'
                    ORDER BY lab_materie_prime.descri_materia") or die("ERROR IN script_lab_matpri_teoria - FUNCTION findMatCompFormulaByCodice - SELECT FROM lab_matpri_teoria JOIN lab_materie_prime" . mysql_error());
    return $sql;
}

/**
 * Seleziona le materie prime di una data formula
 * @param type $codiceFormula
 * @return type
 */
function findMatPriFormulaByCodice($codiceFormula) {

    $sql = mysql_query("SELECT
                                lab_matpri_teoria.id_matpri_teo,
                                lab_matpri_teoria.qta_teo,
                                lab_matpri_teoria.dt_inser,
                                lab_materie_prime.descri_materia,
                                lab_materie_prime.id_mat,
                                lab_materie_prime.tipo,
                                lab_materie_prime.cod_mat,
                                lab_materie_prime.unita_misura,
                                lab_materie_prime.prezzo
                        FROM
                                lab_matpri_teoria
                        INNER JOIN
                                lab_materie_prime
                                ON
                                lab_matpri_teoria.id_mat=lab_materie_prime.id_mat
                        WHERE 
                                cod_lab_formula='" . $codiceFormula . "'
                        AND
                                cod_mat NOT LIKE 'comp%'
                        ORDER BY lab_materie_prime.descri_materia") or die("ERROR IN script_lab_matpri_teoria - FUNCTION findMatPriFormulaByCodice - SELECT FROM lab_matpri_teoria JOIN lab_materie_prime" . mysql_error());
    return $sql;
}

function findCompFormulaByCodice($codiceFormula) {
    $sql = mysql_query("SELECT
                            lab_matpri_teoria.id_matpri_teo,
                            lab_matpri_teoria.qta_teo,
                            lab_matpri_teoria.dt_inser,
                            lab_materie_prime.descri_materia,
                            lab_materie_prime.id_mat,
                            lab_materie_prime.cod_mat,
                            lab_materie_prime.unita_misura,
                            lab_materie_prime.prezzo                           
                    FROM
                            lab_matpri_teoria
                    INNER JOIN
                            lab_materie_prime
                            ON
                                    lab_matpri_teoria.id_mat=lab_materie_prime.id_mat
                    WHERE 
                            cod_lab_formula='" . $codiceFormula . "'
                            AND
                            cod_mat LIKE 'comp%'
                    ORDER BY lab_materie_prime.descri_materia") or die("ERROR IN script_lab_matpri_teoria - FUNCTION findCompFormulaByCodice - SELECT FROM lab_matpri_teoria JOIN lab_materie_prime" . mysql_error());

    return $sql;
}

/**
 * Seleziona l'elenco di tutte le materie prime presenti in [lab_materie_prime] 
 * comprese quelle associate alla vecchia formula, salvate in tabella [lab_matpri_teoria] 
 * con quantita >=0.
 * @param type $codiceFormula
 * @return type
 */
function findMatTeoUnionMatPrimeByCodice($codiceFormula,$strUtentiAziende) {
  
    
    echo $stringSql="(SELECT
                            lab_matpri_teoria.id_mat,
                            lab_matpri_teoria.tipo,
                            lab_matpri_teoria.qta_teo AS qta_teo,
                            lab_materie_prime.descri_materia AS descri_materia,
                            lab_materie_prime.cod_mat,
                            lab_materie_prime.unita_misura,
                            lab_materie_prime.prezzo
                        FROM
                                serverdb.lab_matpri_teoria
                        INNER JOIN 
                                serverdb.lab_materie_prime
                            ON   
                                lab_materie_prime.id_mat=lab_matpri_teoria.id_mat
                        WHERE
                                cod_mat NOT LIKE 'comp%'
                        AND
                                lab_matpri_teoria.cod_lab_formula='" . $codiceFormula . "'
                                   ) 
                    UNION
                    (SELECT
                                lab_materie_prime.id_mat,
                                '' AS tipo,
                                0 AS qta_teo,
                                lab_materie_prime.descri_materia AS descri_materia,
                                lab_materie_prime.cod_mat,
                                lab_materie_prime.unita_misura,
                                lab_materie_prime.prezzo
                        FROM
                                serverdb.lab_materie_prime
                        WHERE
                                lab_materie_prime.cod_mat NOT LIKE 'comp%'
                        AND 
                                lab_materie_prime.id_mat NOT IN 
                                 ( SELECT id_mat FROM 
                                        lab_matpri_teoria
                                    WHERE
                                        cod_mat NOT LIKE 'comp%'
                                    AND
                                        cod_lab_formula='" . $codiceFormula . "' )
                         AND (id_utente,id_azienda) IN ".$strUtentiAziende."                   
                         )
                          ORDER BY qta_teo DESC, tipo DESC,descri_materia";
    
    
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_lab_matpri_teoria - FUNCTION findMatTeoUnionMatPrimeByCodice - " .$stringSql. " - ".mysql_error());

    return $sql;
}

/**
 * Seleziona l'elenco di tutti i componenti presenti in [lab_materie_prime] 
 * compresi quelli associati alla vecchia formula, salvati in tabella [lab_matpri_teoria] 
 * con quantita >=0.
 * @param type $codiceFormula
 * @return type
 */
function findCompTeoUnionCompByCodice($codiceFormula,$strUtentiAziende) {
    
    echo $stringSql="( SELECT
                            lab_matpri_teoria.id_mat,
                            lab_matpri_teoria.tipo,
                            lab_matpri_teoria.qta_teo AS qta_teo,
                            lab_materie_prime.descri_materia AS descri_materia,
                            lab_materie_prime.cod_mat,
                            lab_materie_prime.unita_misura,
                            lab_materie_prime.prezzo
                    FROM
                            serverdb.lab_matpri_teoria
                    INNER JOIN 
                            serverdb.lab_materie_prime
                     ON   
                            lab_materie_prime.id_mat=lab_matpri_teoria.id_mat
                    WHERE
                            cod_mat LIKE 'comp%'
                    AND
                            lab_matpri_teoria.cod_lab_formula='" . $codiceFormula . "'
                     ) 

            UNION

            ( SELECT
                            lab_materie_prime.id_mat,
                            '' AS tipo,
                            0 AS qta_teo,
                            lab_materie_prime.descri_materia AS descri_materia,
                            lab_materie_prime.cod_mat,
                            lab_materie_prime.unita_misura,
                            lab_materie_prime.prezzo
                    FROM
                            serverdb.lab_materie_prime
                    WHERE
                            lab_materie_prime.cod_mat LIKE 'comp%'
                    AND 
                            lab_materie_prime.id_mat NOT IN 
                    ( SELECT													                                       													id_mat 
                            FROM
                                    serverdb.lab_matpri_teoria
                            WHERE
                                    cod_mat LIKE 'comp%'
                            AND
                                    cod_lab_formula='" . $codiceFormula . "')
                     AND (id_utente,id_azienda) IN ".$strUtentiAziende."                   
                    )
            ORDER BY qta_teo DESC, tipo DESC,descri_materia";
    
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_lab_matpri_teoria - FUNCTION findCompTeoUnionCompByCodice -". $stringSql." - ". mysql_error());
    return $sql;
}

/**
 * Seleziona l'elenco di tutte le materie prime definite per le formule di un dato prodotto obiettivo
 * @param type $prodOb 
 * 
 */
function findAllMtProdOb($prodOb,$tipoCodice,$strUtentiAziende) {

    $stringSql = "SELECT * FROM serverdb.lab_matpri_teoria m
        INNER JOIN serverdb.lab_materie_prime p 
        ON m.id_mat=p.id_mat
        INNER JOIN serverdb.lab_formula f ON  f.cod_lab_formula=m.cod_lab_formula 
        WHERE 
            prod_ob = '".$prodOb."'
        AND 
            cod_mat like '".$tipoCodice."%'  
        AND (f.id_utente,f.id_azienda) IN ".$strUtentiAziende."        
        GROUP BY p.id_mat 
        ORDER BY descri_materia;";

    $sql = mysql_query($stringSql) or die("ERROR IN script_lab_matpri_teoria - FUNCTION findAllMtProdOb - " . $stringSql . " - " . mysql_error());
    return $sql;
}


/**
 * Calcola il totale delle qta teoriche di tutte le materie prime e componenti di una formula
 * @param type $codLabFormula
 */
function findQtaTotMatPrimeByCodForm($codLabFormula){
    
     $stringSql="SELECT
                                SUM(qta_teo) AS totale_qta_teo
                        FROM
                                serverdb.lab_matpri_teoria
                       
                        WHERE 
                                cod_lab_formula='".$codLabFormula."'" ;
                               
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_lab_matpri_teoria - FUNCTION findQtaTotMatPrimeByCodForm - " .$stringSql." - ". mysql_error());
    return $sql;
    
    
    
    
}

/**
 * Seleziona la quantità di una certa materia prima usata in una data formula
 * @param type $codLabformula,$idMat
 */
function findQtaByCodFormIdMat($codLabformula,$idMat) {

    $stringSql="SELECT
                                *
                        FROM
                                serverdb.lab_matpri_teoria mt
                        INNER JOIN serverdb.lab_materie_prime m ON 
                                mt.id_mat = m.id_mat
                        WHERE 
                                mt.cod_lab_formula='".$codLabformula."'
                                AND
                                mt.id_mat =".$idMat;
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_lab_matpri_teo - FUNCTION findQtaByCodFormIdMat - " .$stringSql." - ". mysql_error());
    return $sql;
}


function findQtaByProvaIdMat($idEsperimento,$idMat) {

    $stringSql="SELECT
                                *
                        FROM
                                serverdb.lab_risultato_matpri mt
                        INNER JOIN serverdb.lab_materie_prime m ON 
                                mt.id_mat = m.id_mat
                        WHERE
                                mt.id_esperimento=".$idEsperimento."
                                AND
                                mt.id_mat =".$idMat;
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_lab_matpri_teo - FUNCTION findQtaByProvaIdMat - " .$stringSql." - ". mysql_error());
    return $sql;
}


?>
