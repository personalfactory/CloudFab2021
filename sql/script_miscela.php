<?php

/**
 * Seleziona la miscela di origine di un dato kit chimico
 * @param type $codiceChimica
 * @return type
 */
function findMiscelaByCodChimica($codiceChimica) {
    
    $stringSql = "SELECT
                                    sacchetto_chimica.id_miscela,
                                    miscela.dt_miscela,
                                    miscela.cod_contenitore,
                                    miscela.peso_reale
                                  FROM
                                    miscela
                                  INNER JOIN 
                                    sacchetto_chimica 
                                  ON miscela.id_miscela = sacchetto_chimica.id_miscela
                                  WHERE 
                                    sacchetto_chimica.cod_chimica='" . $codiceChimica . "'";
    $sql = mysql_query($stringSql) ;
            //or die("ERROR IN script_miscela.php - FUNCTION findMiscelaByCodChimica - " . $stringSql . " - " . mysql_error());

    return $sql;
}


/**
 * Seleziona le informazioni relative ad una miscela
 * @param type $idMiscela
 * @return type
 */
function findMiscelaById($idMiscela) {
    $stringSql = "SELECT
                                m.dt_miscela,
                                m.cod_formula,
                                f.descri_formula,
                                m.cod_contenitore,
                                m.peso_reale,
                                m.num_sac_in_lotto,
                                m.num_lotti,
                                m.qta_lotto,
                                m.qta_sac
                                
                        FROM
                                serverdb.miscela m
                        INNER JOIN serverdb.formula f ON m.cod_formula=f.cod_formula
                        WHERE 
                                id_miscela=" . $idMiscela;
    $sql = mysql_query($stringSql) or die("ERROR IN script_miscela.php - FUNCTION findMiscelaById - " . $stringSql . " " . mysql_error());


    return $sql;
}

/**
 * Restituisce le materie prime presenti nella miscela ed i mov di magazzino
 * @param type $idMiscela
 * @return type
 */
function findMatPrimeMiscela($idMiscela) {
    $stringSql = "SELECT
                        cod_mov,
                        SUBSTRING_INDEX(cod_mov,'.',1),
                        peso_reale_mat,
                        descri_mat,
                        cod_mat
                FROM
                        miscela_componente mc
                INNER JOIN 
                        miscela m
                        ON 
                        m.id_miscela=mc.id_miscela
                JOIN 
                        materia_prima mt

                WHERE 
                    SUBSTRING_INDEX(cod_mov,'.',1)=cod_mat
                AND
                        mc.id_miscela='" . $idMiscela . "' ORDER BY cod_mat";
    $sql = mysql_query($stringSql) or die("ERROR IN script_miscela.php - FUNCTION findMatPrimeMiscela - " . $stringSql . " " . mysql_error());
    return $sql;
}

/**
 * Seleziona tutte le miscele dalla tabella miscela 
 * facendo un join con la tabella formula in base ai vari filtri impostati
 * @param type $campoOrdine
 * @param type $campoGroupBy
 * @param type $idMiscela
 * @param type $codFormula
 * @param type $descriFormula
 * @param type $codContenitore
 * @param type $dtMiscela
 * @param type $pesoReale
 * @return type
 */
function findMiscelaByFiltri($campoOrdine, $campoGroupBy, $idMiscela, $codFormula, $descriFormula, $codContenitore, $dtMiscela, $pesoReale) {

    $stringSql = "SELECT * FROM
                    serverdb.miscela m
                    INNER JOIN serverdb.formula f 
                    ON m.cod_formula=f.cod_formula
                WHERE 
                    id_miscela LIKE '%" . $idMiscela . "%'
                   AND
                    m.cod_formula LIKE '%" . $codFormula . "%'
                   AND
                    f.descri_formula  LIKE '%" . $descriFormula . "%'
                   AND
                    cod_contenitore LIKE '%" . $codContenitore . "%'
                   AND
                    dt_miscela LIKE '%" . $dtMiscela . "%'
                   AND
                    peso_reale LIKE '%" . $pesoReale . "%'     
                   GROUP BY " . $campoGroupBy . "
                   ORDER BY " . $campoOrdine;
    $sql = mysql_query($stringSql) or die("ERROR IN script_miscela.php - FUNCTION findMiscelaByFiltri - " . $stringSql . " " . mysql_error());


    return $sql;
}

/**
 * Calcola il peso totale di tutte le miscele ottenute filtrando
 * @param type $campoOrdine
 * @param type $campoGroupBy
 * @param type $idMiscela
 * @param type $codFormula
 * @param type $descriFormula
 * @param type $codContenitore
 * @param type $dtMiscela
 * @param type $pesoReale
 * @return type
 */
function findSumQtaMiscelaByFiltri($campoOrdine, $campoGroupBy, $idMiscela, $codFormula, $descriFormula, $codContenitore, $dtMiscela, $pesoReale) {

    $stringSql = "SELECT sum(peso_reale_mat) FROM
                    serverdb.miscela m
                    JOIN serverdb.formula f 
                    ON m.cod_formula=f.cod_formula
                    JOIN serverdb.miscela_componente c 
                    ON c.id_miscela=m.id_miscela
                WHERE 
                    m.id_miscela LIKE '%" . $idMiscela . "%'
                   AND
                    m.cod_formula LIKE '%" . $codFormula . "%'
                   AND
                    f.descri_formula  LIKE '%" . $descriFormula . "%'
                   AND
                    cod_contenitore LIKE '%" . $codContenitore . "%'
                   AND
                    dt_miscela LIKE '%" . $dtMiscela . "%'
                   AND
                    peso_reale LIKE '%" . $pesoReale . "%'";
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_miscela.php - FUNCTION findSumQtaMiscelaByFiltri - " . $stringSql . " " . mysql_error());


    return $sql;
}

/**
 * Modifica il valore campo peso_reale 
 * se questo è uguale al $pesoOld
 * @param type $idMiscela
 * @param type $pesoOld
 * @param type $pesoNew
 * @return type
 */
function updatePesoMiscela($idMiscela,$pesoOld,$pesoNew) {
    
    $stringSql = "UPDATE serverdb.miscela
                SET peso_reale=if(peso_reale=".$pesoOld."," . $pesoNew . ",peso_reale)              
                WHERE id_miscela='".$idMiscela."'";
    $sql = mysql_query($stringSql);
    //or die("ERROR IN script_miscela.php - FUNCTION updatePesoMiscela - " . $stringSql . " - " . mysql_error());

    return $sql;
}

function trovaClientiMiscela($arrayMiscela) {

 $string ="SELECT * FROM serverdb.sacchetto_chimica s 
JOIN serverdb.chimica c ON s.cod_chimica=c.cod_chimica
JOIN serverdb.lotto l ON c.cod_lotto=l.cod_lotto
JOIN serverdb.bolla b ON l.id_bolla=b.id_bolla 
JOIN serverdb.macchina m ON m.id_macchina=b.id_macchina
WHERE s.id_miscela IN (";

          for ($i = 0; $i < count($arrayMiscela); $i++) {
            if ($i > 0) {
              $string .= " , ";
            }
            $string .= $arrayMiscela[$i];
          }
          $string .= ")
GROUP BY m.id_macchina";
 
$sql = mysql_query($string)
    or die("ERROR IN script_miscela.php - FUNCTION trovaClientiMiscela - " . $string . " - " . mysql_error());

    return $sql;

}




?>
