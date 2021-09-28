<?php
/**
 * Seleziona tutte le caratteristiche in base ai filtri
 * @param type $campoOrdine
 * @param type $campoGroupBy
 * @param type $descriCar
 * @param type $metodologia
 * @param type $dtAbilitato
 * @return type
 */
function findAllCarByFiltri($campoOrdine,
        $campoGroupBy,
        $normativa,
        $descriCar,
        $metodologia,
        $caratteristica,
        $dtAbilitato,
        $strUtentiAziende
        ){   
    $sql=mysql_query("SELECT 
                        *
                        FROM serverdb.lab_caratteristica       
                         WHERE
                            normativa LIKE '%".$normativa."%' 
                           AND 
                            descri_caratteristica LIKE '%".$descriCar."%' 
                           AND
                            metodologia LIKE '%".$metodologia."%' 
                           AND
                            dt_abilitato LIKE '%".$dtAbilitato."%'
                           AND
                           caratteristica LIKE '%".$caratteristica."%'
                           AND 
                            (id_utente,id_azienda) IN ".$strUtentiAziende."
                           GROUP BY ". $campoGroupBy."
                           ORDER BY ".$campoOrdine) 
            or die("ERROR IN script_lab_caratteristica - FUNCTION function findAllCarByFiltri()
 - SELECT FROM serverdb.lab_caratteristica " . mysql_error());
   
    return $sql;
    
}



/**
 * Seleziona tutte le caratteristiche associate ad una data normativa
 * @param type $idCar
 * @return type
 */
function findCarByNormativa($normativa) {

    $sql = mysql_query("SELECT * FROM lab_caratteristica WHERE normativa='" . $normativa."'") 
            or die("ERROR IN script_lab_caratteristica - FUNCTION findCarByNormativa - SELECT FROM  lab_caratteristica" . mysql_error());
    return $sql;
}

/**
 * Seleziona le caratteristiche visibili all'utente in base ad una normativa
 * @param type $normativa
 * @param type $strUtentiAziende
 * @return type
 */
function findCarVisByNormativa($normativa,$strUtentiAziende) {
    $stringSql="SELECT * FROM serverdb.lab_caratteristica WHERE normativa='" . $normativa."' AND (id_utente,id_azienda) IN ".$strUtentiAziende." ORDER BY caratteristica";
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_lab_caratteristica - FUNCTION findCarVisByNormativa - " . $stringSql." - ". mysql_error());
    return $sql;
}

function findAllCaratteristiche() {

    $sql = mysql_query("SELECT * FROM lab_caratteristica                                           
                                                    ORDER BY caratteristica") or die("ERROR IN script_lab_caratteristica - FUNCTION findAllCaratteristiche - SELECT FROM  lab_caratteristica" . mysql_error());
    return $sql;
}

/**
 * Seleziona le informazioni di una caratteristica
 * @param type $idCar
 * @return type
 */
function findCaratteristicaById($idCar) {

    $sql = mysql_query("SELECT * FROM lab_caratteristica WHERE id_carat=" . $idCar) or die("ERROR IN script_lab_caratteristica - FUNCTION findCaratteristicaById - SELECT FROM  lab_caratteristica" . mysql_error());
    return $sql;
}

/**
 * Seleziona le informazioni di una caratteristica
 * @param type $idCar
 * @return type
 */
function verificaEsistenzaCar($car) {

    $sql = mysql_query("SELECT * FROM lab_caratteristica WHERE caratteristica='" . $car . "'") or die("ERROR IN script_lab_caratteristica - FUNCTION verificaEsistenzaCar - SELECT FROM  lab_caratteristica" . mysql_error());
    return $sql;
}


/**
 * Verifica l'esistenza di una caratteristica con stesso nome ma diverso id
 * @param type $caratteristica
 * @param type $idCaratteristica
 * @return type
 */
function verificaEsistenzaModificaCar($caratteristica,$idCaratteristica) {

    $sql = mysql_query("SELECT * FROM lab_caratteristica WHERE caratteristica = '" . $caratteristica . "' AND id_carat<>" . $idCaratteristica) 
            or die("ERROR IN script_lab_caratteristica - FUNCTION verificaEsistenzaModificaCar - SELECT FROM  lab_caratteristica" . mysql_error());
    return $sql;
}

/**
 * Inserisce una nuova caratteristica nella tabella lab_caratteristica
 * @param type $caratteristica
 * @param type $descrizione
 * @param type $uniMisCar
 * @param type $tipoDato
 * @param type $dimensione
 * @param type $uniMisDim
 * @param type $metodologia
 * @param type $abilitato
 * @param type $dtAbilitato
 * @return type
 */
function inserisciNuovaCaratteristica($caratteristica, $descrizione, $uniMisCar, $tipoDato, $dimensione, $uniMisDim, $metodologia,$normativa, $abilitato, $dtAbilitato,$idUtente,$idAzienda) {
    
    $stringSql="INSERT INTO lab_caratteristica (
                                    caratteristica, 
                                    descri_caratteristica,
                                    uni_mis_car,
                                    tipo_dato,
                                    dimensione,
                                    uni_mis_dim,
                                    metodologia,
                                    normativa,
                                    abilitato,
                                    dt_abilitato,id_utente,id_azienda) 
                            VALUES ( 
                                    '" . $caratteristica . "',
                                    '" . $descrizione . "',
                                    '" . $uniMisCar . "',
                                    '" . $tipoDato . "',
                                    '" . $dimensione . "',
                                    '" . $uniMisDim . "',
                                    '" . $metodologia . "',
                                    '" . $normativa. "',
                                    " . $abilitato . ",
			            '" . $dtAbilitato . "',".$idUtente.",".$idAzienda.")";
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_lab_caratteristica - FUNCTION inserisciNuovaCaratteristica - ".$stringSql." - " . mysql_error());
    return $sql;
}


function modificaCaratteristica($idCaratteristica,$caratteristica, $descrizione, $uniMisCar, $tipoDato, $dimensione, $uniMisDim, $metodologia,$normativa, $abilitato, $dtAbilitato,$idAzienda) {
    
    $sql = mysql_query("UPDATE lab_caratteristica  
					SET  
						caratteristica='" . $caratteristica . "',
						descri_caratteristica='" . $descrizione . "',
						tipo_dato='" . $tipoDato . "',
                                                uni_mis_car='".$uniMisCar."',
                                                dimensione='".$dimensione."',    
                                                uni_mis_dim='".$uniMisDim."',
                                                metodologia='".$metodologia."',
                                                normativa='".$normativa."',    
                                                abilitato=" . $abilitato . ",
						dt_abilitato='" . dataCorrenteInserimento() . "',
                                                id_azienda=".$idAzienda."    
					WHERE 
						id_carat=" . $idCaratteristica)
            or die("ERROR IN script_lab_caratteristica - FUNCTION modificaCaratteristica - UPDATE lab_caratteristica" . mysql_error());
    return $sql;
}


?>
