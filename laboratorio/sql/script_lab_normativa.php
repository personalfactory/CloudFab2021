<?php
/**
 * Seleziona tutte le norme in base ai filtri
 * @param type $campoOrdine
 * @param type $campoGroupBy
 * @param type $descriNorma
 * @param type $metodo
 * @param type $dtAbilitato
 * @return type
 */
function findAllNormeByFiltri($campoOrdine,
        $campoGroupBy,
        $normativa,
        $descriNorma,
         $dtAbilitato,$strUtentiAziende
        ){   
    $sql=mysql_query("SELECT 
                        *
                        FROM lab_normativa 
                           WHERE
                            normativa LIKE '%".$normativa."%' 
                           AND 
                            descri LIKE '%".$descriNorma."%' 
                           AND
                            dt_abilitato LIKE '%".$dtAbilitato."%'
			AND (id_utente,id_azienda) IN ".$strUtentiAziende."	
                           GROUP BY ". $campoGroupBy."
                           ORDER BY ".$campoOrdine) 
            or die("ERROR IN script_lab_normativa - FUNCTION function findAllNormeByFiltri()
 - SELECT FROM serverdb.lab_normativa  " . mysql_error());
   
    return $sql;
    
}

/**
 * Seleziona una data normativa dalla tabella lab_normativa dalla tabella lab_normativa 
 * @param type $normativa
 * @return type
 */
function findNormativaById($normativa){
  
  $sql=mysql_query("SELECT * FROM serverdb.lab_normativa WHERE normativa='".$normativa."'")
  or die("ERROR IN script_lab_normativa - FUNCTION findNormativaById - SELECT FROM serverdb.lab_normativa : " . mysql_error());

  return $sql;
  
}

/**
 * Seleziona l'elenco delle normative dalla tabella lab_normativa
 * @return type
 */
function findAllNormative(){
  
  $sql=mysql_query("SELECT * FROM serverdb.lab_normativa ORDER BY normativa")
  or die("ERROR IN script_lab_normativa - FUNCTION findAllNormative - SELECT FROM serverdb.lab_normativa : " . mysql_error());

  return $sql;
  
}

/**
 * Seleziona l'elenco delle normative visibili della tabella lab_normativa
 * @return type
 */
function findAllNormativeVis($strUtentiAziende){
  
  $stringSql="SELECT * FROM serverdb.lab_normativa WHERE (id_utente,id_azienda) IN ".$strUtentiAziende." ORDER BY normativa";
$sql=mysql_query($stringSql)
  or die("ERROR IN script_lab_normativa - FUNCTION findAllNormative - " .$stringSql ." - ". mysql_error());
  return $sql;
  
}

/**
 * Verifica l'esistenza di una data normativa
 * @param type $normativa
 * @return type
 */
function verificaEsistenzaNewNormativa($normativa){
    $sql=mysql_query("SELECT * FROM serverdb.lab_normativa WHERE normativa='".$normativa."'")
  or die("ERROR IN script_lab_normativa - FUNCTION verificaEsistenzaNewNormativa - SELECT FROM serverdb.lab_normativa : " . mysql_error());

  return $sql;
    
}

/**
 * Inserisce una nuova normativa nella tabella lab_normativa
 * @param type $Normativa
 * @param type $Descrizione
 */
function inserisciNuovaNormativa($normativa, $descrizione,$idUtente,$idAzienda){
    $stringSql="INSERT INTO serverdb.lab_normativa (normativa,descri,id_utente,id_azienda) 
        VALUES ('".$normativa."','".$descrizione."',".$idUtente.",".$idAzienda.")";
    
    $sql=mysql_query($stringSql)
  or die("ERROR IN script_lab_normativa - FUNCTION inserisciNuovaNormativa - " .$stringSql." ". mysql_error());

  return $sql;
        
}

function modificaLabNormativa($normativa, $descrizione, $dtAbilitato,$idAzienda) {
    echo $stringSql="UPDATE serverdb.lab_normativa  
				SET  					
					descri='" . $descrizione . "',
					dt_abilitato='" . $dtAbilitato . "',
                                        id_azienda=".$idAzienda."    
				WHERE 
					normativa='" . $normativa."'";
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_lab_normativa - FUNCTION modificaLabNormativa - " .$stringSql." - ". mysql_error());
    return $sql;
}

?>
