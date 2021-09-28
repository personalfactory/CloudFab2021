<?php
//Tabelle coinvolte
//lab_materie_prime


/**
 * Seleziona una  per codice dalla tabella lab_materie_prime
 * @param type $codice
 * @return type
 */
function findLabMatPrimaByCodice($codice) {

    $sql = mysql_query("SELECT * FROM serverdb.lab_materie_prime WHERE cod_mat='" . $codice . "'") 
            or die("ERROR IN script_lab_materie_prime - FUNCTION findLabMatPrimaByCodice - SELECT * FROM serverdb.lab_materie_prime : " . mysql_error());
    return $sql;
}

/**
 * Seleziona tutte le materie prime dalla tabella materia_prima in base ai filtri
 * @param type $campoOrdine
 * @param type $campoGroupBy
 * @param type $codice
 * @param type $descri
 * @param type $famiglia
 * @param type $tipo
 * @param type $fornitore
 * @param type $dtAbilitato
 * @param type $strUtentiAziende
 * @return type
 */
function selectLabMatPrimeByFiltri($campoOrdine,
        $campoGroupBy,$codice, $descri, $famiglia,$tipo, 
        $fornitore,$dtAbilitato,$strUtentiAziende,$condizioneSelect) {

   $stringSql="SELECT * FROM serverdb.lab_materie_prime
         WHERE 
            cod_mat LIKE '%" . $codice . "%'
         AND 
            descri_materia LIKE '%" . $descri . "%'
         AND
            famiglia LIKE '%" . $famiglia . "%'
         AND
            tipo LIKE '%" . $tipo . "%'
         AND 
            fornitore LIKE '%" . $fornitore . "%'
        AND 
            dt_abilitato LIKE '%" . $dtAbilitato . "%'
        AND 
            (id_utente,id_azienda) IN ".$strUtentiAziende."
        AND
             ".$condizioneSelect."        
        GROUP BY ". $campoGroupBy."       
        ORDER BY " . $campoOrdine;
    
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_lab_materie_prime - FUNCTION selectMatPrimeByFiltri - : " .$stringSql. " ". mysql_error());

    return $sql;
}



/**
 * Seleziona tutte le materie prime dalla tabella materia_prima in base ai filtri
 * @param type $campoOrdine
 * @param type $campoGroupBy
 * @param type $codice
 * @param type $descri
 * @param type $famiglia
 * @param type $tipo
 * @param type $fornitore
 * @param type $dtAbilitato
 * @return type
 */
//function selectLabMatPrimeByFiltriOld($campoOrdine,
//        $campoGroupBy,$codice, $descri, $famiglia,$tipo, 
//        $fornitore,$dtAbilitato) {
//
//    $sql = mysql_query("SELECT * FROM serverdb.lab_materie_prime
//         WHERE 
//            cod_mat LIKE '%" . $codice . "%'
//         AND 
//            descri_materia LIKE '%" . $descri . "%'
//         AND
//            famiglia LIKE '%" . $famiglia . "%'
//         AND
//            tipo LIKE '%" . $tipo . "%'
//         AND 
//            fornitore LIKE '%" . $fornitore . "%'
//        AND 
//            dt_abilitato LIKE '%" . $dtAbilitato . "%'
//         GROUP BY ". $campoGroupBy."       
//         ORDER BY " . $campoOrdine) or die("ERROR IN script_lab_materie_prime - FUNCTION selectMatPrimeByFiltri - SELECT * serverdb.gaz_movmag : " . mysql_error());
//
//    return $sql;
//}





/**
 * Seleziona tutte le materie prime ed i componenti presenti nella tabella 
 * lab_materie_prime ordinandoli per codice e descrizione
 * @return type
 */
function findAllMatComp(){
    $sql = mysql_query("SELECT	*
			FROM
                            lab_materie_prime
			ORDER BY 
                            lab_materie_prime.cod_mat,
                            lab_materie_prime.descri_materia
					") 
or die("ERROR IN script_lab_materie_prime - FUNCTION findAllMatComp - SELECT FROM serverdb.lab_materie_prime : " . mysql_error());
return $sql;
}



/**
 * Seleziona tutte le famiglie delle materie prime presenti nella tabella 
 * lab_materie_prime 
 * @param type $strUtentiAziende
 * @return type
 */
function findAllTipiLabMatPri($strUtentiAziende){
    
    $stringSql="SELECT	*
                            FROM
                            serverdb.lab_materie_prime
                        WHERE 
                            (id_utente,id_azienda) IN ".$strUtentiAziende."
                        GROUP BY tipo
                        ORDER BY tipo";
    
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_lab_materie_prime - FUNCTION findAllTipiLabMatPri - " .$stringSql." - ". mysql_error());
return $sql;
}

/**
 * Seleziona tutte le famiglie delle materie prime presenti nella tabella 
 * lab_materie_prime 
 * @param type $strUtentiAziende
 * @return type
 */
function findAllFamiglieLabMatPri($strUtentiAziende){
    
    $stringSql="SELECT	*
                            FROM
                            serverdb.lab_materie_prime
                        WHERE 
                            (id_utente,id_azienda) IN ".$strUtentiAziende."
                        
                        GROUP BY famiglia
                        ORDER BY famiglia";
    
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_lab_materie_prime - FUNCTION findAllFamiglieLabMatPri - " .$stringSql." - ". mysql_error());
return $sql;
}
/**
 * Seleziona tutte le famiglie presenti nella tabella 
 * lab_materie_prime 
 * @return type
 */
function findAllFamiglie(){
    $sql = mysql_query("SELECT	*
			FROM
                            serverdb.lab_materie_prime			
                        GROUP BY famiglia
                        ORDER BY famiglia ") 
            or die("ERROR IN script_lab_materie_prime - FUNCTION findAllFamiglie - SELECT FROM serverdb.lab_materie_prime : " . mysql_error());
return $sql;
}

/**
 * Seleziona tutti i tipi presenti nella tabella 
 * lab_materie_prime 
 * @return type
 */
function findAllTipo(){
    $stringSql ="SELECT	*
			FROM
                            serverdb.lab_materie_prime			
                        GROUP BY tipo
                        ORDER BY tipo ";
         $sql=  mysql_query($stringSql) 
            or die("ERROR IN script_lab_materie_prime - FUNCTION findAllTipo - " .$stringSql." - ". mysql_error());
return $sql;
}

/**
 * Seleziona tutte le materie prime con codice diverso da "comp" 
 * dalla tabella lab_materie_prime e le ordina in base al parametro
 * @return type
 */
function findAllMateriePrime($campoOrdine){
    
    $sql=mysql_query("SELECT * FROM serverdb.lab_materie_prime WHERE cod_mat NOT LIKE 'comp%' ORDER BY ".$campoOrdine)
         or 
            die("ERROR IN script_lab_materie_prime - FUNCTION findAllMateriePime - SELECT FROM serverdb.lab_materie_prime : " . mysql_error());
return $sql;
            
}

/**
 * Seleziona tutte i componenti con codice "comp" 
 * dalla tabella lab_materie_prime e li ordina in base al parametro
 * @return type
 */
function findAllComponenti($campoOrdine){
    
    $sql=mysql_query("SELECT * FROM serverdb.lab_materie_prime WHERE cod_mat LIKE 'comp%' ORDER BY ".$campoOrdine)
         or 
            die("ERROR IN script_lab_materie_prime - FUNCTION findAllComponenti - SELECT FROM serverdb.lab_materie_prime : " . mysql_error());
return $sql;
            
}

function findMatPrimaById($idMateria){
    
    $sql=mysql_query("SELECT * FROM serverdb.lab_materie_prime WHERE id_mat=" . $idMateria)
         or 
            die("ERROR IN script_lab_materie_prime - FUNCTION findMatPrimaById - SELECT FROM serverdb.lab_materie_prime : " . mysql_error());
return $sql;   
            
}


function updateMateriaPrima($idMateria,$sottoTipo,$famiglia,$descri,$note,$fornitore,$prezzo,$prezzoBs,$unitaMisura,$idAzienda,$scaffale,$ripiano){
    $sql= mysql_query("UPDATE 
                        serverdb.lab_materie_prime
			SET 
                            famiglia='" . $famiglia . "',
                            tipo='".$sottoTipo."',  
                            descri_materia='" . $descri . "',
                            note='" . $note . "',
                            fornitore='" . $fornitore . "',
                            prezzo=".$prezzo.",
                            prezzo_bs=".$prezzoBs.",
                            unita_misura='".$unitaMisura."',
                            id_azienda='".$idAzienda."',
                            scaffale='".$scaffale."',
                            ripiano='".$ripiano."'
			WHERE 
                            id_mat=" . $idMateria);
//    or  die("ERROR IN script_lab_materie_prime - FUNCTION updateMateriaPrima - UPDATE serverdb.lab_materie_prime : " . mysql_error());
    
    return $sql;
    
}
/**
 * Aggiorna il prezzo ed il fornitore della materia prima
 * @param type $codice
 * @param type $fornitore
 * @param type $prezzo
 * @return type
 */
function aggiornaLabPreForn($codice,$fornitore,$prezzo){
    $sql= mysql_query("UPDATE 
                        serverdb.lab_materie_prime
			SET 
                            fornitore='" . $fornitore . "',
                            prezzo=".$prezzo."
                                WHERE cod_mat='" . $codice."'");
//    or  die("ERROR IN script_lab_materie_prime - FUNCTION aggiornaLabPreForn - UPDATE serverdb.lab_materie_prime : " . mysql_error());
    
    return $sql;
    
}



/**
 * Verifica l'esistenza di una materia prima nella tabella lab_materie_prime
 * facendo una select by codice o nome
 * @param type $codMat
 * @param type $nomeMat
 * @return type
 */
function verificaEsistenzaMatPrima($codMat,$nomeMat){
    
    $sql= mysql_query("SELECT * FROM lab_materie_prime 
        WHERE cod_mat = '" . $codMat . "' OR descri_materia='" . $nomeMat . "'");
//    or  die("ERROR IN script_lab_materie_prime - FUNCTION verificaEsistenzaMatPrima - SELECT * FROM serverdb.lab_materie_prime : " . mysql_error());
    
    return $sql;
}

/**
 * Inserisce una nuova materia prima nella tabella lab_materie_prime
 * @param type $famiglia
 * @param type $sottoTipo
 * @param type $codice
 * @param type $nome
 * @param type $data
 * @param type $unitaMisura
 * @param type $prezzo
 * @param type $prezzoBs
 * @param type $fornitore
 * @param type $note
 * @param type $idUtente
 * @param type $idAzienda
 */
function insertMateriaPrima($famiglia,$sottoTipo,$codice,$nome,$data,$unitaMisura,$prezzo,$prezzoBs,$fornitore,$note,$idUtente,$idAzienda,$scaffale,$ripiano,$tipo2,$tipo3){
 
    
    $stringSql="INSERT INTO serverdb.lab_materie_prime 
        (famiglia,tipo,cod_mat,descri_materia,dt_abilitato,unita_misura,prezzo,prezzo_bs,fornitore,note,id_utente,id_azienda,scaffale,ripiano,tipo2,tipo3)
                VALUES ('" . $famiglia . "',
                        '" . $sottoTipo . "',
                        '" . $codice . "',
                        '" . $nome . "',
                        '" . $data . "',
                        '" . $unitaMisura . "',
                        " . $prezzo . ",
                        " . $prezzoBs . ",
                        '" . $fornitore . "',
                        '" . $note . "',
                        " . $idUtente . ",
                        " . $idAzienda . ","
            . "'" . $scaffale . "',"
            . "'" . $ripiano . "',"
            . "'" . $tipo2 . "',"
            . "'" . $tipo3 . "')";
    $sql=   mysql_query($stringSql) ;
//     or  die("ERROR IN script_lab_materie_prime - FUNCTION insertMateriaPrima  : " .$stringSql." - ". mysql_error());
    return $sql;
}

/**
 * Seleziona dalla tabella lab_materie_prime 
 * il numero massimo dei codici del tipo 'comp04'
 * relativo ai componenti
 * @param type $prefissoCodice
 * @return type
 */
function estraiMaxNumCodComp($prefissoCodice){
    //SUBSTRING(MAX(cod_mat),5)
    $sql=   mysql_query("SELECT (MAX(CONVERT(SUBSTRING(cod_mat,5),UNSIGNED INTEGER))) 
                        AS max_num_cod
                            FROM 
                                serverdb.lab_materie_prime 
                            WHERE 
                                cod_mat like '".$prefissoCodice."%';"); 
//     or  die("ERROR IN script_lab_materie_prime - FUNCTION estraiMaxCodComp - SELECT  serverdb.lab_materie_prime  : " . mysql_error());
    return $sql;
    
}


/**
 * Seleziona tutte le materie prime compound in base al tipo
 * @param type $campoOrdine
 * @param type $tipo
 * @return type
 */
function selectAllLabMatByFiltri($campoOrdine,$tipo,$codMat,$descriMat,$strUtentiAziende) {

    $stringSql="SELECT * FROM serverdb.lab_materie_prime
         WHERE 
                cod_mat LIKE '%" . $codMat . "%'  
              AND
               descri_materia LIKE '%" . $descriMat . "%'  
              AND
               tipo LIKE '%" . $tipo . "%'  
              AND 
                (id_utente,id_azienda) IN ".$strUtentiAziende."
         ORDER BY " . $campoOrdine;
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_lab_materie_prime - FUNCTION selectAllLabMatByFiltri - " .$stringSql." - " .mysql_error());

    return $sql;
}

/**
 * Seleziona tutte le materie prime drymix in base al tipo
 * @param type $campoOrdine
 * @param type $tipo
 * @return type
 */
function selectAllLabCompByFiltri($campoOrdine,$tipo) {
    $stringSql="SELECT * FROM serverdb.lab_materie_prime
         WHERE 
            cod_mat LIKE 'comp%'
         AND
             tipo LIKE '%" . $tipo . "%'             
         ORDER BY " . $campoOrdine;
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_lab_materie_prime - FUNCTION selectAllLabCompByFiltri - " .$stringSql." - " .mysql_error());

    return $sql;
}




/**
 * Seleziona tutti i tipi di materie prime 
 * @return type
 */
function findAllTipiMatPrime($strUtentiAziende){
    $stringSql="SELECT * FROM serverdb.lab_materie_prime WHERE (id_utente,id_azienda) IN ".$strUtentiAziende." GROUP BY tipo ORDER BY tipo";
    $sql=mysql_query($stringSql)
         or 
            die("ERROR IN script_lab_materie_prime - FUNCTION findAllTipiMatPrime - " .$stringSql." - ". mysql_error());
return $sql;
            
}

/**
 * Aggiorna la descrizione di una materia prima con un dato codice in laboratorio 
 * @param type $codice
 * @param type $descri
 * @return type
 */
function aggiornaLabDescriMat($codice,$descri){
    $sql= mysql_query("UPDATE 
                        serverdb.lab_materie_prime
			SET 
                            descri_materia='" . $descri . "'
                                WHERE cod_mat='" . $codice."'");
//    or  die("ERROR IN script_lab_materie_prime - FUNCTION aggiornaLabDescriMat - UPDATE serverdb.lab_materie_prime : " . mysql_error());
    
    return $sql;
    
}

function selectMatPrimeCompound(){
    
    
    
    
}

?>
