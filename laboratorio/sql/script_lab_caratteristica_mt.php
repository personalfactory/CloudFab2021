<?php
/**
 * Seleziona tutte le caratteristiche visubili all'utente dalla tabella lab_caratteristica_mt
 * in base ai filtri impostati
 * @param type $campoOrdine
 * @param type $campoGroupBy
 * @param type $idCarat
 * @param type $caratteristica
 * @param type $descriCar
 * @param type $uniMisCar
 * @param type $dimensione
 * @param type $uniMisDim
 * @param type $metodologia
 * @param type $dtAbilitato
 * @param type $strUtentiAziende
 * @return type
 */
function findAllCarMtVisByFiltri($campoOrdine,
        $campoGroupBy,
        $idCarat,
        $caratteristica,
        $descriCar,
        $uniMisCar,        
        $dimensione,
        $uniMisDim,        
        $metodologia,
        $dtAbilitato,
        $strUtentiAziende
        ){   
    $stringSql="SELECT 
                        *
                        FROM serverdb.lab_caratteristica_mt
                         WHERE
                            id_carat LIKE '%".$idCarat."%' 
                           AND     
                            caratteristica LIKE '%".$caratteristica."%' 
                           AND 
                            descri_caratteristica LIKE '%".$descriCar."%' 
                           AND
                            uni_mis_car LIKE '%".$uniMisCar."%' 
                           AND
                            dimensione LIKE '%".$dimensione."%'
                           AND
                            uni_mis_dim LIKE '%".$uniMisDim."%'
                           AND
                            metodologia LIKE '%".$metodologia."%'
                           AND
                            dt_abilitato LIKE '%".$dtAbilitato."%'    
                           AND 
                            (id_utente,id_azienda) IN ".$strUtentiAziende."
                           GROUP BY ". $campoGroupBy."
                           ORDER BY ".$campoOrdine;
    $sql=mysql_query($stringSql) 
            or die("ERROR IN script_lab_caratteristica - FUNCTION function findAllCarMtVisByFiltri()
 - " .$stringSql. " - ". mysql_error());
   
    return $sql;
    
}
//Da eliminare o rinominare 
function findAllCaratteristiche() {

    $sql = mysql_query("SELECT * FROM serverdb.lab_caratteristica_mt                                           
               ORDER BY caratteristica") or die("ERROR IN script_lab_caratteristica_mt - FUNCTION findAllCaratteristiche - SELECT FROM  lab_caratteristica_mt" . mysql_error());
    return $sql;
}

/**
 * Seleziona tutte le caratteristiche dellematerie prime visualizzabili
 * @param type $strUtentiAziende
 * @return type
 */
function findAllCaratteristicheMtVis($strUtentiAziende) {
    
    $stringSql="SELECT * FROM serverdb.lab_caratteristica_mt  WHERE (id_utente,id_azienda) IN ".$strUtentiAziende."                                         
               ORDER BY caratteristica";
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_lab_caratteristica_mt - FUNCTION findAllCaratteristicheMt - " . mysql_error());
    return $sql;
}


/**
 * Seleziona le informazioni di una caratteristica
 * @param type $idCar
 * @return type
 */
function findCaratteristicaById($idCar) {

    $sql = mysql_query("SELECT * FROM serverdb.lab_caratteristica_mt WHERE id_carat=" . $idCar) or die("ERROR IN script_lab_caratteristica_mt - FUNCTION findCaratteristicaById - SELECT FROM  lab_caratteristica_mt" . mysql_error());
    return $sql;
}

/**
 * Seleziona le informazioni di una caratteristica
 * @param type $idCar
 * @return type
 */
function verificaEsistenzaCar($car) {

    $sql = mysql_query("SELECT * FROM serverdb.lab_caratteristica_mt WHERE caratteristica='" . $car . "'") or die("ERROR IN script_lab_caratteristica_mt - FUNCTION verificaEsistenzaCar - SELECT FROM  lab_caratteristica_mt" . mysql_error());
    return $sql;
}


/**
 * Verifica l'esistenza di una caratteristica con stesso nome ma diverso id
 * @param type $caratteristica
 * @param type $idCaratteristica
 * @return type
 */
function verificaEsistenzaModificaCar($caratteristica,$idCaratteristica) {

    $sql = mysql_query("SELECT * FROM serverdb.lab_caratteristica_mt WHERE caratteristica = '" . $caratteristica . "' AND id_carat<>" . $idCaratteristica) 
            or die("ERROR IN script_lab_caratteristica_mt - FUNCTION verificaEsistenzaModificaCar - SELECT FROM  lab_caratteristica_mt" . mysql_error());
    return $sql;
}

/**
 * Inserisce una nuova caratteristica nella tabella lab_caratteristica_mt
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
function inserisciNuovaCarMt($caratteristica, $descrizione, $uniMisCar, $tipoDato, $dimensione, $uniMisDim, $metodologia, $abilitato, $dtAbilitato,$idUtente,$idAzienda) {
    
    $stringSql="INSERT INTO serverdb.lab_caratteristica_mt (
                                    caratteristica, 
                                    descri_caratteristica,
                                    uni_mis_car,
                                    tipo_dato,
                                    dimensione,
                                    uni_mis_dim,
                                    metodologia,
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
                                    " . $abilitato . ",
			            '" . $dtAbilitato . "'," . $idUtente . ",".$idAzienda.")";
    $sql = mysql_query($stringSql);
            //or die("ERROR IN script_lab_caratteristica_mt - FUNCTION inserisciNuovaCarMt - " .$stringSql." - ". mysql_error());
    return $sql;
}


function modificaCaratteristicaMt($idCaratteristica,$caratteristica, $descrizione, $uniMisCar, $tipoDato, $dimensione, $uniMisDim, $metodologia, $abilitato, $dtAbilitato,$idAzienda) {
    $stringSql="UPDATE serverdb.lab_caratteristica_mt  
                SET  
                        caratteristica='" . $caratteristica . "',
                        descri_caratteristica='" . $descrizione . "',
                        tipo_dato='" . $tipoDato . "',
                        uni_mis_car='".$uniMisCar."',
                        dimensione='".$dimensione."',    
                        uni_mis_dim='".$uniMisDim."',
                        metodologia='".$metodologia."',
                        abilitato=" . $abilitato . ",
                        dt_abilitato='" . $dtAbilitato . "',
                        id_azienda=".$idAzienda."
                WHERE 
                        id_carat=" . $idCaratteristica;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_lab_caratteristica_mt - FUNCTION modificaCaratteristica - ".$stringSql . mysql_error());
    return $sql;
}


?>
