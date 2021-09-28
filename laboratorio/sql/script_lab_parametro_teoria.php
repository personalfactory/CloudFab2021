<?php

/**
 * Seleziona la quantità di un certo parametro usato in una data formula
 * @param type $codLabformula
 */
function findQtaByCodFormIdPar($codLabformula,$idPat) {

    $stringSql="SELECT
                                *
                        FROM
                                lab_parametro_teoria pt
                        INNER JOIN lab_parametro p ON 
                                pt.id_par = p.id_par
                        WHERE 
                                pt.cod_lab_formula='".$codLabformula."'
                                AND
                                pt.id_par =".$idPat;
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_lab_parametro_teoria - FUNCTION findQtaByCodFormIdPar - " .$stringSql." - ". mysql_error());
    return $sql;
}


/**
 * Seleziona l'elenco di tutti i parametri definiti 
 * per le formule di un dato prodotto obbiettivo
 * @param type $prodOb 
 * 
 */
function findAllParProdOb($prodOb,$strUtentiAziende) {

    $stringSql = "SELECT * FROM serverdb.lab_parametro_teoria pt
        INNER JOIN serverdb.lab_parametro p 
        ON pt.id_par=p.id_par
        INNER JOIN serverdb.lab_formula f ON  f.cod_lab_formula=pt.cod_lab_formula 
        WHERE 
            prod_ob = '".$prodOb."'
         AND
          (f.id_utente,f.id_azienda) IN ".$strUtentiAziende."
        GROUP BY p.id_par 
        ORDER BY nome_parametro;";

    $sql = mysql_query($stringSql) or die("ERROR IN script_lab_parametro_teoria - FUNCTION findAllParProdOb - " . $stringSql . " - " . mysql_error());
    return $sql;
}

/**
 * Restituisce i parametri di una formula
 * @param type $codiceFormula
 * @return type
 */
function findParFormulaByCodice($codiceFormula) {
    
       $sql=mysql_query("SELECT 
                                lab_parametro.id_par, 
                                lab_parametro.nome_parametro, 
                                lab_parametro.tipo, 
                                lab_parametro.unita_misura,
                                lab_parametro_teoria.valore_teo
                        FROM 
                                serverdb.lab_parametro_teoria 
                        INNER JOIN 
                                serverdb.lab_parametro 
                        ON 
                                lab_parametro_teoria.id_par=lab_parametro.id_par
                        WHERE 
                                cod_lab_formula='" . $codiceFormula . "' 
                        ORDER BY 
                                nome_parametro") 
               or die("ERROR IN script_lab_parametro_teoria - FUNCTION findParFormulaByCodice - SELECT FROM serverdb.lab_parametro_teoria JOIN serverdb.lab_parametro" . mysql_error());
    return $sql;
}

/**
 * Selezione di tutti i parametri di un determinato tipo presenti nella tabella lab_parametro 
 * uniti a quelli associati ad una formula (con valore>=0) presenti nella tabella lab_parametro_teoria.
 * @param type $codiceFormula
 * @param type $tipo
 * @return type
 */
function findParByCodFormula($codiceFormula,$tipo,$strUtentiAziende){
   $sql= mysql_query("(SELECT 
                                    lab_parametro.nome_parametro, 
                                    lab_parametro.unita_misura,
                                    lab_parametro.tipo,
                                    lab_parametro_teoria.id_par,
                                    lab_parametro_teoria.valore_teo
                            FROM 
                                       serverdb.lab_parametro 
                            LEFT JOIN 
                                    serverdb.lab_parametro_teoria 
                            ON 
                                    lab_parametro.id_par=lab_parametro_teoria.id_par
                            WHERE 
                                    (cod_lab_formula='" . $codiceFormula . "' OR cod_lab_formula IS NULL) 
                            AND
                                    tipo = '".$tipo."')
                            UNION 
                            (SELECT 
                                    lab_parametro.nome_parametro, 
                                    lab_parametro.unita_misura,
                                    lab_parametro.tipo,
                                    lab_parametro.id_par,
                                    0
                            FROM 
                                    serverdb.lab_parametro 
                            WHERE 
                                    tipo ='".$tipo."'
                                AND             
                                    id_par NOT IN 
                                    (SELECT id_par FROM serverdb.lab_parametro_teoria
                                        WHERE 
                                             cod_lab_formula='" . $codiceFormula . "')
                                AND (id_utente,id_azienda) IN ".$strUtentiAziende."                  
                            )
                            ORDER BY  
                            (valore_teo>=0)=true DESC, nome_parametro ASC") 
            or die("ERROR IN script_lab_parametro_teoria - FUNCTION findParByCodFormula - SELECT FROM serverdb.lab_parametro_teoria UNION serverdb.lab_parametro" . mysql_error());
   return $sql;
}

/**
 * Salva i parametri di una formula nella tabella lab_parametro_teoria
 * @param type $idPar
 * @param type $codiceFormula
 * @param type $data
 * @param type $QtaPar
 * @return type
 */
function salvaParFormula($idPar,$codiceFormula,$data,$QtaPar){
    
    $sql=mysql_query("INSERT INTO lab_parametro_teoria (id_par,cod_lab_formula,dt_inser,valore_teo)
                    VALUES ( 
                                            '".$idPar."',
                                            '".$codiceFormula."',
                                            '".$data."',
                                            '".$QtaPar."')")
				or die("ERROR IN script_lab_parametro_teoria - FUNCTION salvaParFormula - INSERT INTO lab_parametro_teoria" . mysql_error());
    
    return $sql;
};
?>
