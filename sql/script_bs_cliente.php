<?php

//function findClientiBsByIdUtente($idUtente,$campoOrdine) {
//   $stringSql = "SELECT * 
//                        FROM 
//                            serverdb.bs_cliente                             
//                        WHERE 
//                            id_utente_iN='".$idUtente."'                        
//                        ORDER BY 
//                            ".$campoOrdine;
//    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_cliente - FUNCTION findClientiBsByIdutente - " . $stringSql . " : " . mysql_error());
//    
//
//    return $sql;
//}

/**
 * da spostare nel file giusto
 * @param type $idUtente
 * @param type $campoOrdine
 * @return type
 */
function findClientiBsByUtente($strUtentiAziende,$campoOrdine) {
    
    $stringSql = "SELECT * 
                        FROM 
                            serverdb.bs_cliente c                           
                        WHERE 
                            (id_utente,id_azienda) IN ".$strUtentiAziende."                       
                        ORDER BY 
                            ".$campoOrdine;
    

    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_cliente - FUNCTION findClientiBsByUtente - " . $stringSql . " : " . mysql_error());
    

    return $sql;
}

function findClienteBsByFiltri($campoGroupBy,$filtroOrdinamento,$idCliente,$nominativo,
            $descrizione,$note,$dtAbilitato,$strUtentiAziende){
	$sqlString="SELECT * FROM serverdb.bs_cliente                         
                        WHERE 
                            id_cliente LIKE '%".$idCliente."%'
                        AND 
                            nominativo LIKE '%".$nominativo."%'
                        AND 
                            descrizione LIKE '%".$descrizione."%'
                        AND 
                            note LIKE '%".$note."%'
                        AND 
                            dt_abilitato LIKE '%" . $dtAbilitato . "%'
                        AND
                            (id_utente,id_azienda) IN ".$strUtentiAziende."
                        GROUP BY ".$campoGroupBy."                            
                        ORDER BY ".$filtroOrdinamento;
	
	$sql = mysql_query($sqlString)
	or die("ERROR IN script_bs_cliente.php - FUNCTION findClienteBsByFiltri - ".$sqlString ." ". mysql_error());
 return $sql;
}

function findClienteBsByNominativo($nominativo){
    
    $stringSql = "SELECT * 
                        FROM 
                            serverdb.bs_cliente                             
                        WHERE 
                            nominativo='".$nominativo."'";                        
                        
    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_cliente - FUNCTION findClienteBsByNominativo - " . $stringSql . " : " . mysql_error());
    

    return $sql;
    
}


function inserisciClienteBs($nominativo,$descrizione,$note,$dtAbilitato,$idUtente,$idAzienda){
    
    $stringSql = "INSERT INTO serverdb.bs_cliente (nominativo,descrizione,note,dt_abilitato,id_utente,id_azienda)                             
                        VALUES ('".$nominativo."','".$descrizione."','".$note."','".$dtAbilitato."',".$idUtente.",".$idAzienda.")";                        
                   
    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_cliente - FUNCTION inserisciClienteBs - " . $stringSql . " : " . mysql_error());
    
    return $sql;
    
}


function findMaxIdBsCliente(){
    
    $stringSql = "SELECT MAX(id_cliente) AS id_cliente
                        FROM 
                            serverdb.bs_cliente";                   
                        
    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_cliente - FUNCTION findMaxIdBsCliente - " . $stringSql . " : " . mysql_error());
    

    return $sql;
    
}


function findClienteBsById($idCliente) {

    $stringSql = "SELECT * 
                        FROM 
                             serverdb.bs_cliente c 
                        WHERE 
                            c.id_cliente=".$idCliente;
    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_cliente - FUNCTION findClienteBsById - " . $stringSql . " : " . mysql_error());
    

    return $sql;
}


function updateBSClienteById($idCliente,$nominativo,$descrizione,$note,$dtAbilitato,$idAzienda) {
$stringSql = "UPDATE serverdb.bs_cliente b SET 
                    nominativo='".$nominativo."',
                    descrizione='".$descrizione."',
                    note='".$note."',
                    dt_abilitato='".$dtAbilitato."',
                    id_azienda='".$idAzienda."'    
              WHERE
                    b.id_cliente=".$idCliente;

$sql = mysql_query($stringSql) or die("ERROR IN " . $stringSql . " : " . mysql_error());

return $sql;
}



/**
 * Verifica esistenza durante la modifica
 * @param type $nominativo
 * @return type
 */
function findClienteBsByNominativoID($idCliente,$nominativo){
    
    $stringSql = "SELECT * 
                        FROM 
                            serverdb.bs_cliente                             
                        WHERE 
                            nominativo='".$nominativo."'"            
                . " AND id_cliente<> ".$idCliente;                        
                        
    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_cliente - FUNCTION findClienteBsByNominativoID - " . $stringSql . " : " . mysql_error());
    

    return $sql;
    
}
?>
