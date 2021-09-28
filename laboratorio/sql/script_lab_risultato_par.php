<?php
/**
 * Seleziona i parametri associati ad un dato esperimento con le qta reali ed i 
 * parametri presenti nella tabella lab_parametro
 * @param type $idEsperimento
 * @param type $tipo
 * @return type
 */
function findRisParByIdEspTipoUnionAll($idEsperimento,$tipo){
    
    $stringSql="SELECT 
                                        lab_parametro.nome_parametro, 
                                        lab_parametro.unita_misura,
                                        lab_risultato_par.valore_reale
                                FROM 
                                           lab_parametro 
                                LEFT JOIN 
                                        lab_risultato_par 
                                ON 
                                        lab_parametro.id_par=lab_risultato_par.id_par
                                WHERE 
                                        (id_esperimento='".$idEsperimento."' OR id_esperimento IS NULL) 
                                AND
                                        tipo = '" . $tipo . "'
                                ORDER BY  
                                        (valore_reale>=0)=true DESC, nome_parametro ASC";
    $sql=mysql_query($stringSql) 
                   or die("ERROR IN script_lab_risultato_par - FUNCTION findRisParByIdEspTipoUnionAll - ".$stringSql." - " . mysql_error());
           return $sql;
}


/**
 * Seleziona i risultati di tutti i parametri di un dato esperimento 
 * dalla tabella lab_risultato_par
 * @param type $idEsperimento
 * @return type
 */
function findRisultatiParByIdEsperimento($idEsperimento){

$sql = mysql_query("SELECT
                                    lab_risultato_par.id_par,
                                    lab_parametro.nome_parametro,
                                    lab_parametro.tipo,
                                    lab_parametro.unita_misura,
                                    lab_parametro_teoria.valore_teo,
                                    lab_risultato_par.valore_reale
                            FROM
                                    lab_risultato_par
                            INNER JOIN lab_esperimento 
                                    ON 
                                            lab_risultato_par.id_esperimento = lab_esperimento.id_esperimento
                            INNER JOIN lab_parametro 
                                    ON 
                                            lab_risultato_par.id_par = lab_parametro.id_par
                            INNER JOIN lab_parametro_teoria 
                                    ON 
                                            lab_esperimento.cod_lab_formula = lab_parametro_teoria.cod_lab_formula 
                                    AND
                                            lab_parametro.id_par = lab_parametro_teoria.id_par
                            WHERE 

                                    lab_risultato_par.id_esperimento=" . $idEsperimento . "
                            GROUP BY 
                                    lab_risultato_par.id_par
                            ORDER BY 
                                    lab_parametro.nome_parametro")
                    or die("ERROR IN script_lab_risultato_par - FUNCTION findRisultatiParByIdEsperimento - SELECT FROM serverdb.lab_risultato_par : " . mysql_error());


return $sql;

}

/**
 * Seleziona il valore reale dei parametri di un certo tipo di un dato esperimento
 * dalla tabella lab_risultato_par
 * @param type $idEsperimento
 * @param type $tipo
 * @return type
 */
function findRisultatiParByIdEspAndTipo($idEsperimento,$tipo){
    
 $sql = mysql_query("SELECT
                                lab_risultato_par.valore_reale
                        FROM
                                lab_risultato_par
                        INNER JOIN lab_parametro 
                        ON 
                                lab_risultato_par.id_par = lab_parametro.id_par
                        WHERE 
                                lab_risultato_par.id_esperimento=" . $idEsperimento . " 
                        AND 
                                (lab_parametro.tipo LIKE '%" . $tipo . "%')")
                    or die("ERROR IN script_lab_risultato_par - FUNCTION findRisultatiParByIdEspAndTipo - SELECT FROM serverdb.lab_risultato_par : " . mysql_error());
    return $sql;
}


/**
 * Seleziona la quantità di un certo parametro usato in un dato esperimento
 * @param type $idEsperimento
 */
function findQtaByIdEsperIdPar($idEsperimento,$idPar) {

    $stringSql="SELECT
                                *
                        FROM
                                lab_risultato_par
                        INNER JOIN lab_parametro ON 
                                lab_risultato_par.id_par = lab_parametro.id_par
                        WHERE 
                                lab_risultato_par.id_esperimento=" . $idEsperimento . "
                                AND
                                lab_risultato_par.id_par =".$idPar;
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_lab_risultato_par - FUNCTION findQtaByIdEsperIdPar - " .$stringSql." - ". mysql_error());
    return $sql;
}

/**
 * seleziona tutti i risultati relativi ad i parametri di un dato esperimento
 * @param type $idEsperimento
 */
function findRisParByIdEsp($idEsperimento){
  
    
    $stringSql="SELECT * FROM lab_risultato_par WHERE id_esperimento=" . $idEsperimento;
            
           $sql= mysql_query($stringSql) 
                   or die("ERROR IN script_lab_risultato_par - FUNCTION findRisParByIdEsp - " .$stringSql." - ". mysql_error());

           return $sql;
}


/**
 * Inserisce un parameretro in un esperimento
 * @param type $idEsperimento
 * @param type $idPar
 * @param type $valoreReale
 * @param type $dtReg
 * @param type $oraReg
 * @return type
 */
function insertRisultatoPar($idPar,$idEsperimento,$valoreReale,$dtReg,$oraReg){
    
    $stringSql="INSERT INTO lab_risultato_par 	
        (id_par,id_esperimento,valore_reale,dt_registrazione,ora_registrazione)
                                                VALUES ( 
                                                    '" . $idPar . "',
                                                    '" . $idEsperimento . "',
                                                    '" . $valoreReale. "',
                                                    '" . $dtReg . "',
                                                    '" . $oraReg . "')";
     $sql= mysql_query($stringSql);
//             or die("ERRORE IN script_lab_risultato_matpri - FUNCTION insertRisultatoPar - ". $stringSql ." - ". mysql_error());
    
    return $sql;
    
}



function findAllParByArrayEsperimenti($stringaEsperimenti) {
    $sqlString = "SELECT * FROM serverdb.lab_risultato_par r
			JOIN serverdb.lab_esperimento e
			ON 
                            r.id_esperimento = e.id_esperimento
			JOIN serverdb.lab_formula f
			ON 
                            e.cod_lab_formula = f.cod_lab_formula
                        JOIN serverdb.lab_parametro p
			ON 
        		    r.id_par = p.id_par
			WHERE 
                            e.id_esperimento IN " . $stringaEsperimenti . "                                           
			GROUP BY p.id_par
			ORDER BY p.nome_parametro";

    $sql = mysql_query($sqlString) or die("ERROR IN script_lab_risultato_par - FUNCTION findAllParByArrayEsperimenti -  " . $sqlString . " - " . mysql_error());
    return $sql;
}

function findQtaByProvaIdPar($idEsperimento,$idPar) {

    $stringSql="SELECT * FROM serverdb.lab_risultato_par r
                        JOIN serverdb.lab_parametro p ON r.id_par= p.id_par
                        WHERE
                             r.id_esperimento=".$idEsperimento."
                             AND
                             p.id_par =".$idPar;
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_lab_risultato_par- FUNCTION findQtaByProvaIdPar - " .$stringSql." - ". mysql_error());
    return $sql;
}


?>
