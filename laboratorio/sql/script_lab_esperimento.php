<?php

/**
 * Seleziona il prodotto target di un dato esperimento
 * @param type $idEsperimento
 * @return type
 */
function findProdTargetByEsperimento($idEsperimento) {
    $stringSql="SELECT *,e.id_utente AS utente,e.id_azienda AS azienda FROM serverdb.lab_esperimento e JOIN serverdb.lab_formula f 
    ON e.cod_lab_formula=f.cod_lab_formula
    WHERE id_esperimento=" . $idEsperimento;
    $sql = mysql_query($stringSql) 
             or die("ERROR IN script_lab_esperimento - FUNCTION findProdTargetByEsperimento -  : " .$stringSql." ". mysql_error());
    return $sql;
}

/**
 * Seleziona tutte le informazioni anagrafiche di un dato esperimento 
 * dalla tabella lab_esperimento tramite l'id
 * @param type $idEsperimento
 * @return type
 */
function findEsperimentoById($idEsperimento) {
    $sql = mysql_query("SELECT *
                                FROM
                                        serverdb.lab_esperimento
                                WHERE 
                                        lab_esperimento.id_esperimento=" . $idEsperimento) 
            or die("ERROR IN script_lab_esperimento - FUNCTION findEsperimentoById - SELECT FROM serverdb.lab_esperimento : " . mysql_error());

    return $sql;
}

/**
 * Seleziona tutti gli esperimenti visibili all'utente
 * dalla tabella lab_esperimento raggruppando per un determinato campo 
 * @param type $campoGroupBy
 * @param type $campoOrdine
 * @param type $strUtentiAziende
 * @return type
 */
function findAllEspVis($campoGroupBy,$campoOrdine,$strUtentiAziende) {
    $stringSql = "SELECT * FROM serverdb.lab_esperimento 
                    WHERE 
                        (id_utente,id_azienda) IN ".$strUtentiAziende."
                    GROUP BY ".$campoGroupBy."
                    ORDER BY ". $campoOrdine; 
         $sql=mysql_query($stringSql) 
            or die("ERROR IN script_lab_esperimento - FUNCTION findAllEspVis - " .$stringSql." - ". mysql_error());
    return $sql;

    }

/**
 * Seleziona il numero di prove totale effettuate su una formula
 * @param type $codiceFormula
 * @return type
 */
function selectMaxNumEsperimento($codiceFormula) {

    $stringSql = "SELECT MAX(num_prova) AS num_prova_tot,
                        id_esperimento,
                        cod_barre,
                        num_prova,
                        dt_prova,
                        ora_prova
                    FROM 
                         serverdb.lab_esperimento 
                    WHERE 
                        cod_lab_formula='" . $codiceFormula . "'";
$sql=mysql_query($stringSql) 
            or die("ERROR IN script_lab_esperimento - FUNCTION selectMaxNumEsperimento - " .$stringSql." - ". mysql_error());
    return $sql;
}

/**
 * Seleziona le prove effettuate su una formula
 * @param type $codiceFormula
 * @return type
 */
function selectEsperimentiByFormula($codiceFormula) {

    $sql = mysql_query("SELECT 
                        id_esperimento,
                        cod_barre,
                        num_prova,
                        dt_prova,
                        ora_prova
                    FROM 
                         serverdb.lab_esperimento 
                    WHERE 
                        cod_lab_formula='" . $codiceFormula . "'
                           ORDER BY id_esperimento  ") or die("ERROR IN script_lab_esperimento - FUNCTION selectMaxNumEsperimento - SELECT FROM serverdb.lab_esperimento : " . mysql_error());

    return $sql;
}



/**
 * Seleziona le prove effettuate su una formula visibili all' utente
 * @param type $codiceFormula
 * @return type
 */
function selectEsperimentiVisByFormula($codiceFormula,$strUtentiAziendeEsp) {
    $stringSql="SELECT 
                        id_esperimento,
                        cod_barre,
                        num_prova,
                        dt_prova,
                        ora_prova
                    FROM 
                         serverdb.lab_esperimento 
                    WHERE 
                        cod_lab_formula='" . $codiceFormula . "'
                    AND
                        (id_utente,id_azienda) IN ".$strUtentiAziendeEsp."
                    ORDER BY id_esperimento";
    $sql = mysql_query($stringSql) or die("ERROR IN script_lab_esperimento - FUNCTION selectEsperimentiVisByFormula - " .$stringSql." - ". mysql_error());

    return $sql;
}


/**
 * seleziona tutti gli esperimenti visibili all'utente
 * @param type $campoOrdine
 * @param type $campoGroupBy
 * @param type $codFormula
 * @param type $codBarre
 * @param type $prodOb
 * @param type $norma
 * @param type $dtProva
 * @param type $utente
 * @param type $gruppoLavoro
 * @param type $strUtentiAziende
 * @param type $visibilita
 * @return type
 */
function findEsperimentiAll(
$campoOrdine, $campoGroupBy, $codFormula, $codBarre, $prodOb, $norma, $dtProva, $utente, $gruppoLavoro,$strUtentiAziende,$visibilita){


    $sql = mysql_query("SELECT
                          e.id_esperimento,
                          e.cod_lab_formula,
                          e.cod_barre,
                          e.num_prova,
                          e.dt_prova,
                          e.ora_prova,
                          f.utente,
                          f.gruppo_lavoro,
                          f.prod_ob,
                          f.normativa
                        FROM
                          serverdb.lab_esperimento e
                        INNER JOIN 
                          serverdb.lab_formula f
                          ON 
                            e.cod_lab_formula = f.cod_lab_formula
                        WHERE 
                                e.cod_lab_formula LIKE '%" . $codFormula . "%'
                            AND 
                                cod_barre LIKE '%" . $codBarre . "%'
                            AND
                                prod_ob LIKE '%" . $prodOb . "%'
                            AND
                                normativa LIKE '%" . $norma . "%'
                            AND
                                dt_prova LIKE '%" . $dtProva . "%'
                            AND
                                f.utente LIKE '%" . $utente . "%'
                            AND 
                                f.gruppo_lavoro LIKE '%" . $gruppoLavoro . "%'
                            AND (e.id_utente,e.id_azienda) IN ".$strUtentiAziende." 
                            AND f.visibilita<=".$visibilita."    
                            GROUP BY " . $campoGroupBy . "
                            ORDER BY " . $campoOrdine) 
            or die("ERROR IN script_lab_esperimento- FUNCTION findEsperimentiAll() - SELECT FROM lab_esperimento : " . mysql_error());
    return $sql;
}

/**
 * Seleziona tutti gli esperimenti appartenenti ad un gruppo
 * che verificano i filtri sui vari campi, utilizzando il LIKE.
 * @param type $username
 * @param type $gruppoUtente
 * @param type $campoOrdine
 * @param type $campoGroupBy
 * @param type $codFormula
 * @param type $codBarre
 * @param type $prodOb
 * @param type $codBarre
 * @param type $numProva
 * @param type $dtProva
 * @param type $utente
 * @return type
 */
function findEsperimentiByGruppo($username, $gruppoUtente, $campoOrdine, $campoGroupBy, $codFormula, $codBarre, $prodOb, $norma, $dtProva,$strUtentiAziende) {
	$stringSql="SELECT
                          e.id_esperimento,
                          e.cod_lab_formula,
                          e.dt_prova,
                          e.ora_prova,
                          f.utente,
                          f.gruppo_lavoro,
                          f.prod_ob,
                          e.cod_barre,
                          f.normativa
                        FROM
                          serverdb.lab_esperimento e
                        INNER JOIN 
                          serverdb.lab_formula f
                          ON 
                            e.cod_lab_formula = f.cod_lab_formula
                        WHERE 
                               (f.utente='" . $username . "'
                                OR  
                                gruppo_lavoro='" . $gruppoUtente . "')
                            AND 
                               e. cod_lab_formula LIKE '%" . $codFormula . "%'
                            AND 
                                cod_barre LIKE '%" . $codBarre . "%'
                            AND
                                prod_ob LIKE '%" . $prodOb . "%'
                            AND
                                normativa LIKE '%" . $norma . "%'        
                            AND
                                dt_prova LIKE '%" . $dtProva . "%'
                            AND (e.id_utente,e.id_azienda) IN ".$strUtentiAziende."          
                            GROUP BY " . $campoGroupBy . "
                            ORDER BY " . $campoOrdine;
    $sql = mysql_query($stringSql) or die("ERROR IN script script_lab_esperimenti - FUNCTION findEsperimentiByGruppo() - " .$stringSql." - ". mysql_error());
    return $sql;
}


/**
 * Verifca se il codice è già presente nell tabella lab_esperimento
 * @param type $codice
 * @return type
 */
function verificaEsistenzaCodice($codice){
    $stringSql="SELECT cod_barre FROM serverdb.lab_esperimento WHERE cod_barre='" . $codice . "'";
  $sql=mysql_query($stringSql) 
          or die("ERROR IN script_lab_esperimento - FUNCTION verificaEsistenzaCodice -  " .$stringSql." - ". mysql_error());
  
  return $sql;
}

/**
 * Ricerca un esperimento per codice
 * @param type $codice
 * @return type
 */
function findIdEsperimentoByCod($codice){
    
    $stringSql="SELECT * FROM serverdb.lab_esperimento WHERE cod_barre='" . $codice . "'";
  $sql=mysql_query($stringSql) 
          or die("ERROR IN script_lab_esperimento - FUNCTION findIdEsperimentoByCod -  " .$stringSql." - ". mysql_error());
  
  return $sql;
    
    
}

/**
 * Ricerca il massimo id_esperimento
 * @param type $codiceFormula
 * @return type
 */
function findMaxIdEsperimentoByCod($codiceFormula){
    
    $stringSql="SELECT MAX(id_esperimento) AS id_esperimento FROM serverdb.lab_esperimento WHERE cod_lab_formula='".$codiceFormula."'";
  $sql=mysql_query($stringSql) 
          or die("ERROR IN script_lab_esperimento - FUNCTION findMaxIdEsperimentoByCod -  " .$stringSql." - ". mysql_error());
  
  return $sql;
    
    
}



/**
 * Inserisce un nuovo esperimento nella tabella lab_esperimento
 * @param type $codiceForm
 * @param type $numProva
 * @param type $codProva
 * @param type $dtProva
 * @param type $oraProva
 * @return type
 */
function insertNewEsperimento($codiceForm,$tipo,$numProva,$codProva,$dtProva,$oraProva,$idUtente,$idAzienda){
    
    $stringSql="INSERT INTO serverdb.lab_esperimento (cod_lab_formula,tipo,num_prova,cod_barre,dt_prova,ora_prova,id_utente,id_azienda)
                                VALUES ( 
                                                '" . $codiceForm . "',
                                                '" . $tipo . "',
                                                '" . $numProva . "',
                                                '" . $codProva . "',
                                                '" . $dtProva . "',
                                                '" . $oraProva . "',
                                                " . $idUtente . ",
                                                " . $idAzienda . ")";
    
   $sql= mysql_query($stringSql); 
//            or die("ERROR IN script_lab_esperimento - FUNCTION insertNewEsperimento - ".$stringSql." - " . mysql_error());
    
    return $sql;
    
}

?>
