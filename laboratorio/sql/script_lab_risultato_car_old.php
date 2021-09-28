<?php

/**
 * Elimina una riga nella tabella lab_risultato_car
 * @param type $idRiga
 * @return type
 */
function deleteRisultatoCar($idRiga) {
    
    $stringSql="DELETE FROM serverdb.lab_risultato_car WHERE id=".$idRiga;
    
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_lab_risultato_car - FUNCTION deleteRisultatoCar - " . $stringSql." ". mysql_error());
    return $sql;
}





/**
 * Seleziona l'elenco di tutte le caratteristiche definite per alcuni esperimenti
 * @param type $arrayEsperimenti è una matrice contenente gli id degli esperimenti
 * sulla prima colonna e i codici a barre sulla seconda
 */
function findAllCarFormula($arrayEsperimenti) {

    $stringSql = "SELECT * FROM serverdb.lab_risultato_car r
        INNER JOIN serverdb.lab_caratteristica c 
        ON r.id_carat=c.id_carat
WHERE id_esperimento IN
(";
    
    for ($i = 0; $i < count($arrayEsperimenti); $i++) {
        if ($i > 0) {
            $stringSql .= " , ";
        }
        $stringSql .= $arrayEsperimenti[$i][1];
    }

    $stringSql.=") 
        

GROUP BY caratteristica;";

    $sql = mysql_query($stringSql) or die("ERROR IN script_lab_risultato_car - FUNCTION findAllCarFormula - " . $stringSql . " - " . mysql_error());
    return $sql;
}

/**
 * Seleziona i valori relativi ai risultati di una caratteristica di un dato esperimneto
 * @param type $idEsperimento
 * @param type $idCar
 * @return type
 */
function findRisultatoCarByIdEspAndIdCar($idEsperimento, $idCar) {
    $sql = mysql_query("SELECT valore_caratteristica AS y, valore_dimensione AS x
                        FROM serverdb.lab_risultato_car 
                        WHERE 
                                id_esperimento=" . $idEsperimento . " 
                            AND 
                                id_carat=" . $idCar . "
                            ORDER BY valore_dimensione") or die("ERROR IN script_lab_risultato_car - FUNCTION findRisultatoCarByIdEspAndIdCar - SELECT FROM lab_risultato_car : " . mysql_error());
    return $sql;
}

/**
 * Associa una caratteristica ad un esperimento, 
 * inserendo un record nella tabella lab_risultato_car
 * @param type $idEsperimento
 * @param type $idCar
 * @param type $valoreCar
 * @param type $valDimensione
 *  @param type $note
 * @return type
 */
function inserisciCaratteristicaProva($idEsperimento, $idCar, $valoreCar, $valDimensione, $note) {
     $stringSql = "INSERT INTO serverdb.lab_risultato_car 
                            (id_esperimento,
                             id_carat,
                             valore_caratteristica,
                             valore_dimensione,
                             note) 
                            VALUES(    " . $idEsperimento . ",
                                       " . $idCar . ",
                                       '" . $valoreCar . "',
                                       " . $valDimensione . ",
                                       '" . $note . "')";
    $sql = mysql_query($stringSql);
    //or die("ERROR IN script_lab_risultato_car - FUNCTION inserisciCaratteristicaProva - " . $stringSql . " - " . mysql_error());
    return $sql;
}

/**
 * Seleziona tutte le caratteristiche di un dato esperimento dalla tabella lab_risultato_car
 * @return type
 */
function findRisultatoCarByIdEsperimento($idEsperimento) {

    $sql = mysql_query("SELECT
                                lab_caratteristica.id_carat,
                                lab_caratteristica.caratteristica,
                                lab_caratteristica.descri_caratteristica,
                                lab_caratteristica.uni_mis_car,
                                lab_caratteristica.dimensione,
                                lab_caratteristica.uni_mis_dim,
                                lab_caratteristica.tipo_dato,
                                lab_risultato_car.note,
                                lab_risultato_car.id,
                                lab_risultato_car.valore_dimensione,
                                lab_risultato_car.valore_caratteristica,
                                lab_risultato_car.dt_registrazione
                                		
                        FROM
                                serverdb.lab_risultato_car
                        INNER JOIN 
                                serverdb.lab_caratteristica 
                             ON 
                                lab_risultato_car.id_carat = lab_caratteristica.id_carat
                        WHERE	
                                lab_risultato_car.id_esperimento=" . $idEsperimento . "
                        
                        ORDER BY 
                                lab_caratteristica.caratteristica") or die("ERROR IN  script_lab_risultato_car.php - FUNCTION findRisultatoCarByIdEsperimento :" . mysql_error());
    return $sql;
}

/**
 * Seleziona tutte i risultati relativi ad una singola caratteristica 
 * di un dato esperimento dalla tabella lab_risultato_car
 * @param type $idEsperimento
 * @param type $idCarat
 * @return type
 */
function findRisultatoSingolaCarByIdEspIdCar($idEsperimento, $idCarat) {
    $stringSql = "SELECT * FROM
                                serverdb.lab_risultato_car
                        INNER JOIN 
                                serverdb.lab_caratteristica 
                             ON 
                                lab_risultato_car.id_carat = lab_caratteristica.id_carat
                        WHERE	
                                lab_risultato_car.id_esperimento=" . $idEsperimento . "
                                    AND
                                    lab_risultato_car.id_carat=" . $idCarat . "
                        ORDER BY 
                                lab_risultato_car.valore_dimensione,lab_risultato_car.dt_registrazione,ora_registrazione";
    $sql = mysql_query($stringSql) or die("ERROR IN  script_lab_risultato_car.php - FUNCTION findRisultatoSingolaCarByIdEspIdCar - " . $stringSql . " - " . mysql_error());
    return $sql;
}

/**
 * Modifica il valore di una cartteristica di un dato esperimento
 * NB. l'istruzione if non funziona se i campi sono null!!
 * @param type $valore
 * @param type $idEsperimento
 * @param type $idCarat
 * @param type $note
 * @return type
 */
function modificaRisultatiCar($valoreCar, $valoreDim, $idEsperimento, $idRisCarat, $note) {
    $stringSql = "UPDATE serverdb.lab_risultato_car					  		       	 			                         
                         SET 
                             valore_caratteristica=if(valore_caratteristica != '" . $valoreCar . "','" . $valoreCar . "',valore_caratteristica),
                             valore_dimensione=if(valore_dimensione != '" . $valoreDim . "','" . $valoreDim . "',valore_dimensione),
                             note=if(note != '" . $note . "' OR note IS NULL,'" . $note . "',note)    
                         WHERE 
                             id_esperimento=" . $idEsperimento . "
                         AND 
			     id=" . $idRisCarat;
    $sql = mysql_query($stringSql) or die("ERROR IN  script_lab_risultato_car.php - FUNCTION modificaRisultatiCar " . $stringSql . " - " . mysql_error());
    return $sql;
}



/**
 * Seleziona tutte le caratteristiche definite per le prove presenti nell'array 
 * anche le caratteristiche che hanno solo allegati e non valori
 * @param type $arrayEsperimenti è una matrice contenente gli id degli esperimenti
 * sulla prima colonna e i codici a barre sulla seconda
 * @return type
 */
function findAllCarUnionFormula($arrayEsperimenti) {

    $stringSql = "SELECT * FROM
       ((SELECT r.id_carat AS id_carat,r.id_esperimento AS id_esper,caratteristica,uni_mis_car,uni_mis_dim,tipo_dato,note
        FROM serverdb.lab_risultato_car r
        INNER JOIN serverdb.lab_caratteristica c 
        ON r.id_carat=c.id_carat
WHERE id_esperimento IN
(";    
    for ($i = 0; $i < count($arrayEsperimenti); $i++) {
        if ($i > 0) {
            $stringSql .= " , ";
        }
        $stringSql .= $arrayEsperimenti[$i][1];
    }

    $stringSql.=") )        
UNION DISTINCT
(SELECT a.id_carat AS id_carat,a.id_rif AS id_esper,caratteristica,uni_mis_car,uni_mis_dim,tipo_dato,note
        FROM serverdb.lab_allegato a
        INNER JOIN serverdb.lab_caratteristica c 
        ON a.id_carat=c.id_carat
WHERE id_rif IN
(";
    
    for ($i = 0; $i < count($arrayEsperimenti); $i++) {
        if ($i > 0) {
            $stringSql .= " , ";
        }
        $stringSql .= $arrayEsperimenti[$i][1];
    }

    $stringSql.="))
        ) AS elenco_car GROUP BY caratteristica ORDER BY caratteristica";

    $sql = mysql_query($stringSql) or die("ERROR IN script_lab_risultato_car - FUNCTION findAllCarFormula - " . $stringSql . " - " . mysql_error());
    return $sql;
}


/**
 * Dato un array contenente gli id di alcuni esperimenti e dato l'id di una caratteristica 
 * la funzione conta il numero tot di valori registrati per quella caratteristica 
 * con valori della dimensione diversi fra loro
 * @param type $arrayEsperimenti
 * @param type $idCar
 * @return type
 */
//function countValoriCar($arrayEsperimenti,$idCar) {
//$stringSql="SELECT * FROM serverdb.lab_risultato_car WHERE id_esperimento IN
//(";    
//    for ($i = 0; $i < count($arrayEsperimenti); $i++) {
//        if ($i > 0) {
//            $stringSql .= " , ";
//        }
//        $stringSql .= $arrayEsperimenti[$i][1];
//    }
//   $stringSql.=")  
//AND id_carat=".$idCar." GROUP BY valore_dimensione";
//
//$sql=mysql_query($stringSql) 
//        or die("ERROR IN script_lab_risultato_car - FUNCTION countValoriCar - " . $stringSql . " - " . mysql_error());
//    return $sql;
//}




?>
