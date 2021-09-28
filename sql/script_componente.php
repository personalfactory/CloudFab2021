<?php
//Tabelle coinvolte
//componente

/**
 * Seleziona dalla tabella componente tutti i componenti che non sono presenti nel prodotto
 * @param type $idProdotto
 * @param type $strUtentiAziendeVis
 * @return type
 */
function findCompNotInProdotto($idProdotto,$prefCodComp,$strUtentiAziendeVis){

$stringSql = "SELECT * FROM serverdb.componente 
                WHERE
                    cod_componente LIKE '".$prefCodComp."%'
                AND
                    id_comp NOT IN 
                            (SELECT 
                                id_comp 
                            FROM 
                                serverdb.componente_prodotto 
                            WHERE 
                                id_prodotto=".$idProdotto.")
                AND
                    (id_utente,id_azienda) IN ".$strUtentiAziendeVis."
               
                ORDER BY descri_componente";

$sql = mysql_query($stringSql)
	or die("ERROR IN script_componente.php - FUNCTION findCompNotInProdotto - ".$stringSql ." ". mysql_error());
 return $sql;


}


/**
 * Seleziona tutti i componenti visibili all'utente
 * @param type $strUtentiVis
 * @param type $strAziendeVis
 * @return type
 */
function selectComponentiVis($strUtentiAziende,$campoOrderBy){
$sql = mysql_query("SELECT * FROM serverdb.componente 
                         WHERE 
                                (id_utente,id_azienda) IN ".  $strUtentiAziende."
                        ORDER BY ".$campoOrderBy) 
        or die("ERROR IN script_componente - FUNCTION selectComponentiVis - SELECT * FROM componente : " . mysql_error());

return $sql;
}


function selectComponentiVisByDizionario($strUtentiAziende,$campoOrderBy,$idLingua){
$sql = mysql_query("SELECT * FROM serverdb.componente c
                    JOIN 
                        serverdb.dizionario d    
                    WHERE
                        d.id_diz_tipo=4
                    AND 
                        d.id_vocabolo=c.id_comp
                    AND 
                        d.id_lingua=".$idLingua."
                    AND
                        (id_utente,id_azienda) IN ".  $strUtentiAziende."
                    ORDER BY ".$campoOrderBy) 
        or die("ERROR IN script_componente - FUNCTION selectComponentiVis - SELECT * FROM componente : " . mysql_error());

return $sql;
}







function selectComponenti(){
$sql = mysql_query("SELECT * FROM serverdb.componente ORDER BY descri_componente") 
        or die("ERROR IN script_componente - FUNCTION selectComponenti - SELECT * FROM componente : " . mysql_error());

return $sql;
}

/**
 * Seleziona un componente dalla tabella componntetramite il suo codice
 * @param type $codice
 * @return type
 */
function findComponenteByCod($codice){
     $stringSql = "SELECT * FROM serverdb.componente 
                            WHERE 
                                cod_componente = '" . $codice . "'";
    
    $sql = mysql_query($stringSql) 
    or die("ERROR IN script_componente - FUNCTION findComponenteByCod - " . $stringSql . " : " . mysql_error());
    

    return $sql;
}

/**
 * Seleziona un componente dalla tabella componente tramite il suo id
 * @param type $codice
 * @return type
 */
function findComponenteById($idComp){
     $stringSql = "SELECT * FROM serverdb.componente 
                            WHERE 
                                id_comp = '" . $idComp . "'";
    
    $sql = mysql_query($stringSql) 
    or die("ERROR IN script_componente - FUNCTION findComponenteById - " . $stringSql . " : " . mysql_error());
    

    return $sql;
}

/**
 * Inserisce un nuovo componente nella tabella componente
 * @param type $codice
 * @param type $descrizione
 * @param type $abilitato
 * @return type
 */
function inserisciComponente($codice,$descrizione,$abilitato,$idUtente,$idAzienda){
    
       $stringSql = "INSERT INTO serverdb.componente(cod_componente,descri_componente,abilitato,id_utente,id_azienda) 
                                VALUES ( '" . $codice . "',
                                         '" . $descrizione . "',
                                         " . $abilitato . ",
                                         ".$idUtente.",
                                         ".$idAzienda.")";
       
       $sql = mysql_query($stringSql);
    //or die("ERROR IN script_componente - FUNCTION inserisciComponente - " . $stringSql . " : " . mysql_error());
    

    return $sql;
}

/**
 * Seleziona tutti i componenti visibili in base ai filtri impostati sui campi
 * @param type $filtroOrdinamento
 * @param type $strUtentiAziende
 * @param type $idComp
 * @param type $codComp
 * @param type $descriComp
 * @param type $abilitato
 * @param type $dtAbilitato
 * @return type
 */
function findAllComponentiVisByFiltri($campoGroupBy,$filtroOrdinamento,$strUtentiAziende,$idComp,$codComp,$descriComp,$abilitato,$dtAbilitato,$condizioneSelect){
	 $sqlString= "SELECT *,c.abilitato AS abilitato,c.dt_abilitato AS dt_abilitato FROM serverdb.componente c
            JOIN serverdb.lab_materie_prime l ON c.cod_componente=l.cod_mat
         WHERE                
            id_comp LIKE '%" . $idComp . "%'
         AND 
            cod_componente LIKE '%" . $codComp . "%'
         AND
            descri_componente LIKE '%" . $descriComp . "%'
         AND 
            c.abilitato LIKE '%" . $abilitato . "%'
         AND 
            c.dt_abilitato LIKE '%" . $dtAbilitato . "%'
         AND
            (c.id_utente, c.id_azienda) IN ".$strUtentiAziende."
         AND
            ".$condizioneSelect." 
        GROUP BY " . $campoGroupBy . "           
        ORDER BY ".$filtroOrdinamento;
	
	$sql = mysql_query($sqlString)
		or die("ERROR IN script_componente.php - FUNCTION findAllComponentiVisByFiltri - ".$sqlString ." ". mysql_error());
	
	return $sql;
}


/**
 * Seleziona i campi id_comp e descri_componente dalla tabella componente
 * @return resource
 */
function findIdAndDescriComponente(){
	$stringSql = "SELECT 
                                                id_comp,
                                                descri_componente
                                        FROM 
                                                serverdb.componente";

	$sql = mysql_query($stringSql)
	or die("ERROR IN script_componente - FUNCTION findIdAndDescriComponente - " . $stringSql . " : " . mysql_error());


	return $sql;
}



/**
 * Seleziona un componente per campi simili alla chiave
 * @param unknown $key
 * @param unknown $filtro
 * @return resource
 * @author FR
 */
function findComponenteByKey($key, $filtro){
	$stringSql = "SELECT * FROM serverdb.componente
                                    
			WHERE 
                                   (id_comp LIKE '%" . $key . "%')
                                OR (cod_componente LIKE '%" . $key . "%') 
				OR (descri_componente LIKE '%" . $key . "%')
				OR (dt_abilitato LIKE '%" . $key . "%')
                       ORDER BY 
                            " . $filtro;

	$sql = mysql_query($stringSql)
	or die("ERROR IN script_componente - FUNCTION findComponenteByKey - " . $stringSql . " : " . mysql_error());


	return $sql;
}

/**
 * Aggiorna il campo descrizione della tabella componente
 * @param type $codice
 * @param type $prezzoMedio
 */
function aggiornaDescriComp($codice, $descrizione) {

    $stringSql = "UPDATE serverdb.componente SET 
                descri_componente = if(descri_componente != '" . $descrizione . "','" . $descrizione . "',descri_componente)
          WHERE 
                cod_componente = '" . $codice . "'";
    
    $sql=  mysql_query($stringSql)
    or  die("ERROR IN script_componente - FUNCTION aggiornaDescriComp - " .$stringSql." - ". mysql_error());   

    return $sql;
}

/**
 * Verifica se nella tabella componente esiste un componente con stesso codice o 
 * stessa descrizione e id diverso da quello che si sta modificando
 * @param type $idComp
 * @param type $codice
 * @param type $descrizione
 * @return type
 */
function verificaEsistenzaModificaComp($idComp,$codice, $descrizione) {

    $stringSql = "SELECT * FROM serverdb.componente 
				WHERE 
					(cod_componente = '" . $codice . "' 
				OR 
					descri_componente = '" . $descrizione . "')
				AND 
					id_comp<>" . $idComp;
    
    $sql=  mysql_query($stringSql)
    or  die("ERROR IN script_componente - FUNCTION verificaEsistenzaModificaComp - " .$stringSql." - ". mysql_error());   

    return $sql;
}

//##############################################################################
//########################### STORICO ##########################################
//##############################################################################


/**
 * Inserisce un componente nel db storico tabella componente
 * @param type $idComponente
 * @return type
 */
function inserisciComponenteStorico($idComponente){
    
       $stringSql = "INSERT INTO storico.componente 						 										
                                (id_comp,
                                cod_componente,
                                descri_componente,
                                abilitato,
                                dt_abilitato) 
                        SELECT 
                                id_comp,
                                cod_componente,
                                descri_componente,
                                abilitato,
                                dt_abilitato
                        FROM 
                                serverdb.componente
                        WHERE 
                                id_comp='" . $idComponente . "'";
       
       $sql = mysql_query($stringSql);
    //or die("ERROR IN script_componente - FUNCTION inserisciComponenteStorico - " . $stringSql . " : " . mysql_error());
    

    return $sql;
}

/**
 * Modifica il codice e la descrizione di un componente nella tabella componente
 * di serverdb solo se sono realmente stai modificati
 * @param type $idComponente
 * @param type $codiceComponente
 * @param type $descriComponente
 */
function modificaComponente($idComponente,$codiceComponente,$descriComponente){
    
    $stringSql="UPDATE serverdb.componente 
                    SET 
                            cod_componente=if(cod_componente!='" . $codiceComponente . "','" . $codiceComponente . "',cod_componente),
                            descri_componente=if(descri_componente!='" . $descriComponente . "','" . $descriComponente . "',descri_componente)							
                    WHERE 
                            id_comp='" . $idComponente . "'";
                       $sql = mysql_query($stringSql);
        //or die("ERROR IN script_componente - FUNCTION modificaComponente - " . $stringSql . " : " . mysql_error());;
    return $sql;
}



/**
 * Seleziona tutti i componenti presenti nella tabella lab_materie_prime 
 * ma non presenti nella tabella componente
 * @param type $prefissoCodiceComponenti
 */
function findLabMatPrimeNotInComponente($prefissoCodiceComponenti,$campoOrdine,$strUtentiAziendeVis,$tipo2,$tipo3,$codice,$descrizione) {
   $stringSql = "SELECT * 
                        FROM 
                            serverdb.lab_materie_prime 
                        WHERE 
                            cod_mat LIKE '".$prefissoCodiceComponenti."%'
                        AND 
                            cod_mat NOT IN 
                            (SELECT cod_componente FROM serverdb.componente)
                        AND 
                            (id_utente,id_azienda )IN ".$strUtentiAziendeVis."
                        AND 
                            tipo2='".$tipo2."' AND tipo3='".$tipo3."'
                        AND 
                            cod_mat LIKE '%".$codice."%'
                        AND 
                            descri_materia LIKE '%".$descrizione."%'
                        ORDER BY 
                            ".$campoOrdine;
    $sql = mysql_query($stringSql) or die("ERROR IN script_materia_prima - FUNCTION findLabMatPrimeNotInComponente - " . $stringSql . " : " . mysql_error());
    

    return $sql;
}

/**
 * BS
 * Seleziona i componenti ed il prezzo visibili all'utente
 * @param type $campoOrdine
 * @param type $strUtentiAziendeVis
 * @return type
 */
//function findComponentiEPrezzo($campoOrdine,$strUtentiAziendeVis) {
//   $stringSql = "SELECT *
//                        FROM 
//                            serverdb.componente c 
//                        JOIN serverdb.materia_prima m ON c.cod_componente=m.cod_mat
//                        JOIN serverdb.componente_prodotto cp ON cp.id_comp=c.id_comp
//                        JOIN serverdb.bs_prodotto b ON b.id_prodotto=cp.id_prodotto                            
//                        WHERE 
//                            (c.id_utente,c.id_azienda )IN ".$strUtentiAziendeVis." 
//                        AND c.cod_componente<>'chimica'
//                        GROUP BY c.id_comp        
//                        ORDER BY 
//                            ".$campoOrdine;
//    $sql = mysql_query($stringSql) or die("ERROR IN script_componente - FUNCTION findComponentiEPrezzo - " . $stringSql . " : " . mysql_error());
//    
//
//    return $sql;
//}

function findComponentiEPrezzo($campoOrdine,$strUtentiAziendeVis) {
   $stringSql = "SELECT *,l.prezzo_bs AS pre_acq
                        FROM 
                            serverdb.componente c 
                        JOIN serverdb.lab_materie_prime l ON c.cod_componente=l.cod_mat
                        JOIN serverdb.componente_prodotto cp ON cp.id_comp=c.id_comp
                        JOIN serverdb.bs_prodotto b ON b.id_prodotto=cp.id_prodotto                            
                        WHERE 
                            (c.id_utente,c.id_azienda )IN ".$strUtentiAziendeVis." 
                        AND c.cod_componente<>'chimica'
                        GROUP BY c.id_comp        
                        ORDER BY 
                            ".$campoOrdine;
    $sql = mysql_query($stringSql) or die("ERROR IN script_componente - FUNCTION findComponentiEPrezzo - " . $stringSql . " : " . mysql_error());
    

    return $sql;
}

function findAllComponentiAbilitati($campoOrdine){
    
    $stringSql="SELECT 
                       *                
                 FROM serverdb.componente               
                                              
                WHERE 
                    abilitato = '1'
                ORDER BY " . $campoOrdine;
           $sql = mysql_query($stringSql)
    or die("ERROR IN script_componente.php - findAllComponentiAbilitati - ".$stringSql." - " . mysql_error());
	return $sql;
    
}

/**
 * Seleziona tutti i pigmenti visibili all' utente
 * @param type $strUtentiVis
 * @param type $strAziendeVis
 * @return type
 */
function selectComponentiByTipoVis($strUtentiAziende,$campoOrderBy,$tipo2){
    $sql = mysql_query("SELECT * FROM serverdb.componente c
                        JOIN serverdb.lab_materie_prime l ON c.cod_componente=l.cod_mat
                         WHERE 
                            tipo2='".$tipo2."' 
                          AND
                               c.abilitato=1 
                          AND
                              (l.id_utente,l.id_azienda) IN ". $strUtentiAziende."
                        ORDER BY ".$campoOrderBy) 
        or die("ERROR IN script_componente - FUNCTION selectComponentiByTipoVis - SELECT * FROM componente : " . mysql_error());

return $sql;
}



function selectCompVisByDizionarioAndTipo2($strUtentiAziende,$campoOrderBy,$idLingua,$tipo2){
$sql = mysql_query("SELECT * FROM serverdb.componente c
                    JOIN 
                        serverdb.dizionario d    
                    JOIN 
                        serverdb.lab_materie_prime l ON c.cod_componente=l.cod_mat    
                    WHERE
                        d.id_diz_tipo=4
                    AND 
                        d.id_vocabolo=c.id_comp
                    AND 
                        d.id_lingua=".$idLingua."
                    AND
                        tipo2='".$tipo2."' 
                    AND
                        c.abilitato=1
                    AND
                        (c.id_utente,c.id_azienda) IN ".  $strUtentiAziende."
                    ORDER BY ".$campoOrderBy) 
        or die("ERROR IN script_componente - FUNCTION selectCompVisByDizionarioAndTipo2 - SELECT * FROM componente : " . mysql_error());

return $sql;
}


?>
