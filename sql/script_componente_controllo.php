<?php


function findInfoControlloCompByCodice($codiceIngressoComp) {

     $sqlString = "SELECT * FROM serverdb.componente_controllo cc 
JOIN serverdb.macchina m ON cc.id_macchina=m.id_macchina
JOIN serverdb.componente c ON c.id_comp=cc.id_comp
WHERE  cod_ingresso_comp = '" . $codiceIngressoComp . "'";

    $sql = mysql_query($sqlString) or die("ERROR IN script_componente_controllo.php - FUNCION findInfoControlloCompByCodice - " . $sqlString . " " . mysql_error());

    return $sql;
}



/**
 * Seleziona le informazioni relative alla materie prima caricata nel silos
 * @param type $codiceIngressoComp
 * @return type
 */
function findControlloCompByCodice($codiceIngressoComp) {

    $sqlString = "SELECT * FROM serverdb.componente_controllo WHERE cod_ingresso_comp = '" . $codiceIngressoComp . "'";

    $sql = mysql_query($sqlString) or die("ERROR IN script_componente_controllo.php - FUNCION findControlloCompByCodice - " . $sqlString . " " . mysql_error());

    return $sql;
}

/**
 * Inserisce un nuovo record dentro la tabella componente_controllo
 * @param type $idComponente
 * @param type $operatore
 * @param type $fornitore
 * @param type $marchioCeConforme
 * @param type $merceConforme
 * @param type $stabilitaConforme
 * @param type $proceduraAdottata
 * @param type $codiceIngressoComp
 * @param type $codiceCE
 * @param type $quantita
 * @param type $respProduzione
 * @param type $respQualita
 * @param type $consTecnico
 * @param type $note
 * @param type $idMacchina
 * @param type $dtAbilitato
 * @return type
 */
function insertNewMateriaPrimaIngresso($idComponente, $operatore, $fornitore, $marchioCeConforme, $merceConforme, $stabilitaConforme, $proceduraAdottata, $codiceIngressoComp, $codiceCE, $quantita, $respProduzione, $respQualita, $consTecnico, $note, $idMacchina, $dtAbilitato) {

    $stringSql = "INSERT INTO componente_controllo (
      id_comp,
      cod_operatore,
      fornitore,
      marchio_ce_conforme,
      merce_conforme,
      stabilita_conforme,
      procedura_adottata,
      cod_ingresso_comp,
      codice_ce,
      quantita,
      responsabile_produzione,
      responsabile_qualita,
      consulente_tecnico,
      note,
      id_macchina,
      dt_mov
      ) 
  VALUES (
       " . $idComponente . ",
       '" . $operatore . "',
       '" . $fornitore . "',
       " . $marchioCeConforme . ",
       " . $merceConforme . ",
       " . $stabilitaConforme . ",
       '" . $proceduraAdottata . "',
       '" . $codiceIngressoComp . "',
       '" . $codiceCE . "',
       " . $quantita . ",
       '" . $respProduzione . "',
       '" . $respQualita . "',
       '" . $consTecnico . "',
       '" . $note . "',
       " . $idMacchina . ",  
       '" . $dtAbilitato . "')";

    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_componente_controllo.php - FUNCTION insertNewMateriaPrimaIngresso - " .$stringSql. " -  ".mysql_error());
    return $sql;
}


function selectControlloComponentiByFiltri($campoOrdine, $campoGroupBy, $descriComp, $nominativo, $fornitore, $descriStab, $quantita, $dtAbilitato) {

    $stringSql="SELECT * FROM serverdb.componente_controllo cc JOIN serverdb.componente c 
        ON cc.id_comp=c.id_comp
        JOIN serverdb.figura f ON f.codice=cc.cod_operatore
        JOIN serverdb.macchina m ON m.id_macchina=cc.id_macchina         
         WHERE 
            descri_componente LIKE '%" . $descriComp . "%'
         AND 
            f.nominativo LIKE '%" . $nominativo . "%'
         AND
            fornitore LIKE '%" . $fornitore . "%'
         AND 
            descri_stab LIKE '%" . $descriStab . "%'
         AND 
            quantita LIKE '%" . $quantita . "%'
         AND 
            cc.dt_abilitato LIKE '%" . $dtAbilitato . "%'
         
         GROUP BY " . $campoGroupBy . "       
         ORDER BY " . $campoOrdine;
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_componente_controllo - FUNCTION selectControlloComponentiByFiltri - " . mysql_error());

    return $sql;
}
?>
