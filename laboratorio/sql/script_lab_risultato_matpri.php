<?php

/**
 * Seleziona tutte le materie prime associate ad un dato esperimento unendole a 
 * tutte le altre materie prime presenti nella tabella lab_materie_prime
 * @param type $idEsperimento
 * @return type
 */
function findMatPriByEsperUnionAll($idEsperimento) {

    $stringSql = "( SELECT
                                    lab_risultato_matpri. id_mat,
                                    lab_risultato_matpri.id_esperimento, 
                                    lab_risultato_matpri.qta_reale AS qta_reale,
                                    lab_materie_prime.descri_materia AS descri_materia,
                                    lab_materie_prime.cod_mat,
                                    lab_materie_prime.unita_misura,
                                    lab_materie_prime.prezzo
                               FROM 
                                      serverdb.lab_risultato_matpri 
                               INNER JOIN 
                                      serverdb.lab_materie_prime 
                               ON 
                                      lab_risultato_matpri.id_mat = lab_materie_prime.id_mat  
                               WHERE 
                                      cod_mat NOT LIKE 'comp%' 
                                 AND 
                                      id_esperimento = '" . $idEsperimento . "' )

                           UNION

                                ( SELECT
                                    lab_materie_prime.id_mat,
                                    null,
                                    null,
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
                                (SELECT	id_mat												
                                      FROM
                                              lab_risultato_matpri
                                      WHERE																			
                                              id_esperimento = '" . $idEsperimento . "' )
                            )															
                            ORDER BY  (qta_reale>=0 )=true DESC, descri_materia;";
    $sql = mysql_query($stringSql) or die("ERROR IN script_lab_risultato_matpri - FUNCTION findMatPriByEsperUnionAll - " . $stringSql . " - " . mysql_error());
    return $sql;
}

/**
 * Seleziona tutti componenti drymix associati ad un dato esperimento unendole a 
 * tutte le altre materie prime presenti nella tabella lab_materie_prime
 * @param type $idEsperimento
 * @return type
 */
function findCompByEsperUnionAll($idEsperimento) {

    $stringSql = "( SELECT
                        lab_risultato_matpri. id_mat,
                        lab_risultato_matpri.id_esperimento, 
                        lab_risultato_matpri.qta_reale AS qta_reale,
                        lab_materie_prime.descri_materia AS descri_materia,
                        lab_materie_prime.cod_mat,
                        lab_materie_prime.unita_misura,
                        lab_materie_prime.prezzo
                   FROM 
                          serverdb.lab_risultato_matpri 
                   INNER JOIN 
                          serverdb.lab_materie_prime 
                   ON 
                          lab_risultato_matpri.id_mat = lab_materie_prime.id_mat  
                   WHERE 
                          cod_mat LIKE 'comp%' 
                         AND 
                          id_esperimento = '" . $idEsperimento . "' )

            UNION

                  ( SELECT
                                  lab_materie_prime.id_mat,
                                  null,
                                  null,
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
                              ( SELECT	id_mat			                        													
                                      FROM
                                              serverdb.lab_risultato_matpri
                                      WHERE																			
                                              id_esperimento = '" . $idEsperimento . "' )
               )															
                ORDER BY  (qta_reale>=0 )=true DESC, descri_materia;	";


    $sql = mysql_query($stringSql) or die("ERROR IN script_lab_risultato_matpri - FUNCTION findCompByEsperUnionAll - " . $stringSql . " - " . mysql_error());
    return $sql;
}

/**
 * Seleziona i componenti di un dato esperimento dalla tabella lab_risultato_matpri
 * @param type $idEsperimento
 */
function findComponentiByIdEsperimento($idEsperimento) {

    $sql = mysql_query("SELECT
                                lab_risultato_matpri.id_mat,
                                lab_materie_prime.descri_materia,
                                lab_materie_prime.prezzo,
                                lab_matpri_teoria.qta_teo_perc,
                                lab_matpri_teoria.qta_teo,
                                lab_risultato_matpri.qta_reale
                            FROM
                                    serverdb.lab_risultato_matpri
                            INNER JOIN serverdb.lab_esperimento 
                                    ON 
                                            lab_risultato_matpri.id_esperimento = lab_esperimento.id_esperimento
                            INNER JOIN serverdb.lab_materie_prime 
                                    ON 
                                            lab_risultato_matpri.id_mat = lab_materie_prime.id_mat
                            INNER JOIN serverdb.lab_matpri_teoria 
                                    ON 
                                            lab_esperimento.cod_lab_formula = lab_matpri_teoria.cod_lab_formula 
                                    AND
                                            lab_materie_prime.id_mat = lab_matpri_teoria.id_mat
                            WHERE 
                                    lab_risultato_matpri.id_esperimento=" . $idEsperimento . "
                                    AND
                                    lab_materie_prime.cod_mat LIKE 'comp%'
                            GROUP BY 
                                    lab_risultato_matpri.id_mat
                            ORDER BY 
                                    lab_materie_prime.descri_materia") or die("ERROR IN script_lab_risultato_matpri - FUNCTION findComponentiByIdEsperimento
                        - SELECT FROM lab_risultato_matpri JOIN lab_esperimento,lab_materie_prime,lab_matpri_teoria : " . mysql_error());
    return $sql;
}

/**
 * Seleziona le materie prime chimica di un dato esperimento
 * dalla tabella lab_risultato_matpri
 * @param type $idEsperimento
 */
function findMatPrimeByIdEsperimento($idEsperimento) {

     $stringSql = "SELECT
                                lab_risultato_matpri.id_mat,
                                lab_materie_prime.descri_materia,
                                lab_materie_prime.prezzo,
                                lab_matpri_teoria.qta_teo_perc,
                                lab_matpri_teoria.qta_teo,
                                lab_risultato_matpri.qta_reale
                        FROM
                                serverdb.lab_risultato_matpri
                        INNER JOIN serverdb.lab_esperimento 
                                ON 
                                        lab_risultato_matpri.id_esperimento = lab_esperimento.id_esperimento
                        INNER JOIN serverdb.lab_materie_prime 
                                ON 
                                        lab_risultato_matpri.id_mat = lab_materie_prime.id_mat
                        INNER JOIN serverdb.lab_matpri_teoria 
                                ON 
                                        lab_esperimento.cod_lab_formula = lab_matpri_teoria.cod_lab_formula 
                                AND
                                        lab_materie_prime.id_mat = lab_matpri_teoria.id_mat
                        WHERE 
                                lab_risultato_matpri.id_esperimento=" . $idEsperimento . "
                                AND
                                lab_materie_prime.cod_mat NOT LIKE 'comp%'
                        GROUP BY 
                                lab_risultato_matpri.id_mat
                        ORDER BY 
                                lab_materie_prime.descri_materia";
     $sql=  mysql_query($stringSql) or die("ERROR IN script_lab_risultato_matpri - FUNCTION findMatPrimeByIdEsperimento - SELECT FROM lab_risultato_matpri JOIN lab_esperimento,lab_materie_prime,lab_matpri_teoria : " . mysql_error());
    return $sql;
}

/**
 * Seleziona la quantità di una certa materia prima usata in un dato esperimento
 * @param type $idEsperimento
 */
function findQtaByIdEsperIdMat($idEsperimento, $idMat) {

    $stringSql = "SELECT
                                *
                        FROM
                                serverdb.lab_risultato_matpri
                        INNER JOIN serverdb.lab_materie_prime ON 
                                lab_risultato_matpri.id_mat = lab_materie_prime.id_mat
                        WHERE 
                                lab_risultato_matpri.id_esperimento=" . $idEsperimento . "
                                AND
                                lab_risultato_matpri.id_mat =" . $idMat;
    $sql = mysql_query($stringSql) or die("ERROR IN script_lab_risultato_matpri - FUNCTION findQtaByIdEsperIdMat - " . $stringSql . " - " . mysql_error());
    return $sql;
}

/**
 * Calcola il totale delle qta reali di tutte le materie prime e componenti di un esperimento
 * @param type $idEsperimento
 */
function findQtaTotMatPrimeByIdEsper($idEsperimento) {

    $stringSql = "SELECT SUM(qta_reale) AS totale_qta_reale
                   FROM
                       serverdb.lab_risultato_matpri
                   WHERE 
                       id_esperimento=" . $idEsperimento;

    $sql = mysql_query($stringSql) or die("ERROR IN script_lab_risultato_matpri - FUNCTION findQtaTotMatPrimeByIdEsper - " . $stringSql . " - " . mysql_error());
    return $sql;

}
    /**
     * Seleziona le materie prime di un esperimento per idEsperimento
     * @param type $idEsperimento
     */
    function findMatEsperimentoById($idEsperimento,$campoOrdine) {

        $stringSql = "SELECT
                                            *
                                            FROM
                                                    serverdb.lab_risultato_matpri
                                            WHERE id_esperimento=" . $idEsperimento."
                                            ORDER BY ".$campoOrdine;
        
        
        $sql=mysql_query($stringSql) or die("ERROR IN script_lab_risultato_matpri - FUNCTION findMatEsperimentoById - ".$stringSql . " ".mysql_error());
        return $sql;
    }



/**
 * Seleziona la quantità ed il prezzo di tutte le materie prime di un dato esperimento
 * @param type $idEsperimento
 * @return type
 */
function findQtaEsperimento($idEsperimento) {
    $sql = mysql_query("SELECT * FROM
                            serverdb.lab_risultato_matpri
                    INNER JOIN	
                            lab_materie_prime
                        ON
                            lab_materie_prime.id_mat=lab_risultato_matpri.id_mat
                    WHERE 
                            lab_risultato_matpri.id_esperimento=" . $idEsperimento) or die("ERROR IN script_lab_risultato_matpri - FUNCTION findQtaEsperimento - SELECT FROM lab_risultato_matpri INNER JOIN	
                            lab_materie_prime " . mysql_error());
    return $sql;
}

/**
 * Seleziona tutti gli esperimenti in cui è stata usata una data materia prima
 * in un dato gruppo di lavoro
 * @param type $idMateria
 * @return type
 */
function findEsperimentiByIdMat($idMateria, $username, $gruppo) {
    $sqlString = "SELECT
						r.id_mat,
						r.id_esperimento,
						e.cod_barre,
						e.cod_lab_formula,
						e.dt_prova,
                                                e.num_prova,
						f.cod_lab_formula,
                                                Max(num_prova) as num_prove_tot
						
					FROM
						serverdb.lab_risultato_matpri r
					INNER JOIN lab_esperimento e
					ON 
						r.id_esperimento = e.id_esperimento
					INNER JOIN serverdb.lab_formula f
					ON 
						e.cod_lab_formula = f.cod_lab_formula
					WHERE r.id_mat='" . $idMateria . "'
                                            AND 
                                                (f.utente='" . $username . "' 
                                                OR  
                                                f.gruppo_lavoro='" . $gruppo . "')
					GROUP BY 
						r.id_mat,
                                                f.cod_lab_formula
					ORDER BY 
						r.id_mat, f.cod_lab_formula,e.num_prova";

    $sql = mysql_query($sqlString) or die("ERROR IN script_lab_risultato_matpri - FUNCTION findEsperimentiByIdMat -  " . $sqlString . " - " . mysql_error());
    return $sql;
}

/**
 * Seleziona tutti gli esperimenti in cui è stata usata una data materia prima
 * 
 * @param type $idMateria
 * @return type
 */
function findAllEsperimentiByIdMat($idMateria) {
    $sqlString = "SELECT
						r.id_mat,
						r.id_esperimento,
						e.cod_barre,
						e.cod_lab_formula,
						e.dt_prova,
                                                e.num_prova,
						f.cod_lab_formula,
                                                Max(num_prova) as num_prove_tot
						
					FROM
						serverdb.lab_risultato_matpri r
					INNER JOIN serverdb.lab_esperimento e
					ON 
						r.id_esperimento = e.id_esperimento
					INNER JOIN serverdb.lab_formula f
					ON 
						e.cod_lab_formula = f.cod_lab_formula
					WHERE r.id_mat='" . $idMateria . "'
                                           
					GROUP BY 
						r.id_mat,
                                                f.cod_lab_formula
					ORDER BY 
						r.id_mat, f.cod_lab_formula,e.num_prova";

    $sql = mysql_query($sqlString) or die("ERROR IN script_lab_risultato_matpri - FUNCTION findAllEsperimentiByIdMat -  " . $sqlString . " - " . mysql_error());
    return $sql;
}



/**
 * Inserisce una materia prima in un esperimento
 * @param type $idEsperimento
 * @param type $idMat
 * @param type $qtaReale
 * @param type $dtReg
 * @param type $oraReg
 * @return type
 */
function insertRisultatoMatPri($idEsperimento,$idMat,$qtaReale,$dtReg,$oraReg){
    
    $stringSql="INSERT INTO lab_risultato_matpri 	
        (id_esperimento,id_mat,qta_reale,data_registrazione,ora_registrazione)
                                        VALUES ( 
                                                " . $idEsperimento . ",
                                                '" . $idMat . "',
                                                '" . $qtaReale . "',
                                                '" . $dtReg . "',
                                                '" . $oraReg . "')";
     $sql= mysql_query($stringSql);
//             or die("ERRORE IN script_lab_risultato_matpri - FUNCTION insertRisultatoMatPri - ". $sqlString ." - ". mysql_error());
    
    return $sql;
    
}



function findAllMatPriByArrayEsperimenti($stringaEsperimenti,$tipoCodice) {
    $sqlString = "SELECT * FROM serverdb.lab_risultato_matpri r
			JOIN serverdb.lab_esperimento e
			ON 
                            r.id_esperimento = e.id_esperimento
			JOIN serverdb.lab_formula f
			ON 
                            e.cod_lab_formula = f.cod_lab_formula
                        JOIN serverdb.lab_materie_prime m
			ON 
        		    r.id_mat = m.id_mat
			WHERE 
                            e.id_esperimento IN " . $stringaEsperimenti . "   
                        AND 
                            m.cod_mat LIKE '".$tipoCodice."%'
			GROUP BY m.id_mat
			ORDER BY m.descri_materia";

    $sql = mysql_query($sqlString) or die("ERROR IN script_lab_risultato_matpri - FUNCTION findAllMatPriByArrayEsperimenti -  " . $sqlString . " - " . mysql_error());
    return $sql;
}

function findAllMatPriDrymixByArrayEsperimenti($stringaEsperimenti,$tipoCodice) {
    $sqlString = "SELECT * FROM serverdb.lab_risultato_matpri r
			JOIN serverdb.lab_esperimento e
			ON 
                            r.id_esperimento = e.id_esperimento
			JOIN serverdb.lab_formula f
			ON 
                            e.cod_lab_formula = f.cod_lab_formula
                        JOIN serverdb.lab_materie_prime m
			ON 
        		    r.id_mat = m.id_mat
			WHERE 
                            e.id_esperimento IN " . $stringaEsperimenti . "  
                        AND 
                            m.cod_mat LIKE '".$tipoCodice."%'
			GROUP BY m.id_mat
			ORDER BY m.descri_materia";

    $sql = mysql_query($sqlString) or die("ERROR IN script_lab_risultato_matpri - FUNCTION findAllMatPriDrymixByArrayEsperimenti -  " . $sqlString . " - " . mysql_error());
    return $sql;
}

?>
