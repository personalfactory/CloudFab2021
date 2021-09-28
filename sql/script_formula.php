<?php
//Tabelle coinvolte :
//formula
//codice
//prodotto

//##############################################################################
//########################### SERVERDB #########################################
//##############################################################################

/**
 * Seleziona tutte le formule dalla tabella formula in base ai filtri
 * @param type $campoOrdine
 * @param type $campoGroupBy
 * @param type $codice
 * @param type $descri
 * @param type $famiglia
 * @param type $numSac
 * @param type $dtFormula
 * @param type $dtAbilitato
 * @return type
 */
function selectFormuleByFiltri($campoOrdine, $campoGroupBy, $codice, $descri, $famiglia, $numLotti,$numSacInLotto, $dtFormula, $dtAbilitato,$strUtentiAziende) {

    $stringSql="SELECT *,f.dt_abilitato as dt_abil FROM serverdb.formula f
        INNER JOIN serverdb.codice c ON  c.tipo_codice=substr(cod_formula,2,3)
        WHERE
            cod_formula LIKE '%" . $codice . "%'
         AND
            descri_formula LIKE '%" . $descri . "%'
         AND
            descrizione LIKE '%" . $famiglia . "%'
         AND
            num_lotti LIKE '%" . $numLotti . "%'
         AND
            num_sac_in_lotto LIKE '%" . $numSacInLotto . "%'
         AND
            dt_formula LIKE '%" . $dtFormula . "%'
         AND
            f.dt_abilitato LIKE '%" . $dtAbilitato . "%'
         AND 
            (f.id_utente,f.id_azienda) IN ".$strUtentiAziende."
          
         GROUP BY " . $campoGroupBy . "
         ORDER BY " . $campoOrdine;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_formula - FUNCTION selectFormuleByFiltri - ". $stringSql." - ". mysql_error());

    return $sql;
}

/**
 * Seleziona le informazioni anagrafiche di una formula dalla tabella formula
 * @param type $codFormula
 * @return type
 */
function findAnFormulaByCodice($codFormula) {
    
    $sql = mysql_query("SELECT *
                        FROM  serverdb.formula
                        WHERE cod_formula='" . $codFormula . "'") 
            or die("ERROR IN script_formula.php - FUNCTION findAnFormulaByCodice - SELECT * FROM serverdb.formula: " . mysql_error());

    return $sql;
}


/**
 * Seleziona tutte le formule dalla tabella formula
 * @param type $codFormula
 * @return type
 */
function findAllFormule($campoOrdine) {
    $stringSql="SELECT * FROM  serverdb.formula ORDER BY " . $campoOrdine;
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_formula.php - FUNCTION findAllFormule - " .$stringSql." - ". mysql_error());

    return $sql;
}

/**
 * Verifica se la descrizione di una formula esiste 
 * @param type $codFormula
 * @param type $descriFormula
 * @return type
 */
function findDescriFormlaDiversaDaCodice($codFormula,$descriFormula) {
    $stringSql="SELECT *
                        FROM  serverdb.formula
                        WHERE cod_formula<>'" . $codFormula . "'
                            AND descri_formula='".$descriFormula."'";
    
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_formula.php - FUNCTION findDescriFormlaDiversaDaCodice - " .$stringSql." ". mysql_error());

    return $sql;
}

/**
 * Seleziona le informazioni anagrafiche di una formula dalla tabella formula
 * @param type $codFormula
 * @return type
 */
function findAnFormulaByCodiceNome($codFormula,$descriFormula) {
    
    $sql = mysql_query("SELECT *
                        FROM  serverdb.formula
                        WHERE cod_formula='" . $codFormula . " ' 
                            OR descri_formula='".$descriFormula."'") 
            or die("ERROR IN script_formula.php - FUNCTION findAnFormulaByCodice - SELECT *                                FROM
                              serverdb.formula: " . mysql_error());

    return $sql;
}


/**
 * Seleziona il numero massimo del codice avente come prefisso l'argomento
 * @param type $prefissoCodice
 * @return type
 */
function selectMaxNumCodice($prefissoCodice) {
   
    $sql = mysql_query("SELECT SUBSTR(MAX(cod_formula),5) AS num_max
                    FROM 
                            serverdb.formula
                    WHERE 
                            MID(cod_formula,1,4 )='" . $prefissoCodice . "'") 
            or die("ERROR IN script_formula.php - FUNCTION selectMaxNumCodice - SELECT SUBSTR(MAX(cod_formula),5) FROM serverdb.formula " . mysql_error());
    return $sql;
}

/**
 * Inserisce una nuova formula nella tabella serverdb.formula
 * @param type $codiceFormula
 * @param type $descriFormula
 * @param type $data
 * @param type $numSacchetti
 * @param type $qtaSacchetto
 * @param type $abilitato
 * @param type $dtAbilitato
 * @return type
 */
function inserisciAnagrafeFormula($codiceFormula, $descriFormula, $data, $numSacchetti, $qtaSacchetto, $numKitInLotto,$numLotti,$qtaLotto,$qtaTotMiscela,
        $abilitato, //1
        $dtAbilitato,
        $metodoCalcolo,
        $idUtente,
        $idAzienda) {  
    $sql = mysql_query("INSERT INTO serverdb.formula 	
                        (cod_formula,
                        descri_formula,
                        dt_formula,
                        num_sac,
                        qta_sac,
                        num_sac_in_lotto,
                        num_lotti,
                        qta_lotto,
                        qta_tot_miscela,
                        abilitato,
                        dt_abilitato,
                        metodo_calcolo,
                        id_utente,
                        id_azienda)
                VALUES ( 
                        '" . $codiceFormula . "',
                        '" . $descriFormula . "',
                        '" . $data . "',
                        " . $numSacchetti . ",
                        " . $qtaSacchetto . ",
                        " . $numKitInLotto . ",
                        " . $numLotti . ",
                        " . $qtaLotto . ",
                        " . $qtaTotMiscela . ",
                        " . $abilitato . ",
                        '" . $dtAbilitato . "',
                        '" . $metodoCalcolo . "',
                        " . $idUtente . ",
                        " . $idAzienda . ")") 
            or die("ERROR IN script_formula.php - FUNCTION inserisciAnagrafeFormula - INSERT INTO formula : " . mysql_error());
    return $sql;
}

/**
 * Modifica un record della tabella formula
 * @param type $codiceFormula
 * @param type $descriFormula
 * @param type $numSacchetti
 * @param type $qtaSac
 * @param type $numSacInLotto
 * @param type $numLotti
 * @param type $qtaLotto
 * @param type $qtaTotMiscela
 * @param type $abilitato
 * @param type $dtAbilitato
 * @param type $idAzienda
 * @return type
 */
function updateFormulaByCodice($codiceFormula,$descriFormula,$numSacchetti,$qtaSac,$numSacInLotto,$numLotti,$qtaLotto,$qtaTotMiscela,$abilitato,$dtAbilitato,$metodoCalcolo,$idAzienda){
   
    $sqlString="UPDATE
                        serverdb.formula 
                    SET 
                        descri_formula='".$descriFormula."',
                        num_sac=".$numSacchetti.",
                        qta_sac=".$qtaSac.",
                        num_sac_in_lotto=".$numSacInLotto.",
                        num_lotti=".$numLotti.",
                        qta_lotto=".$qtaLotto.",
                        qta_tot_miscela=".$qtaTotMiscela.",
                        abilitato=".$abilitato.",
                        dt_abilitato='".$dtAbilitato."',
                        id_azienda='".$idAzienda."',
                        metodo_calcolo='".$metodoCalcolo."'    
                    WHERE 
                        cod_formula='".$codiceFormula."'";
    $sql=mysql_query($sqlString)
   or die("ERROR IN script_formula.php - FUNCTION updateFormulaByCodice - " . $sqlString . mysql_error());
    return $sql;
}


/**
 * Selezione del codice prodotto fra le varie formule presenti nella tabella [formula]
 * Visualizzazione solo dei codici delle formule non ancora diventate prodotti 
 * senza la lettera "K" davanti e che sono visibili all'utente
 */
function selectCodFormulaNotInProdotto($strUtentiAziende){

    $stringSql="SELECT MID(cod_formula,2,5) 
                    FROM 
                        serverdb.formula
                    WHERE 
                         MID(cod_formula,2,5)
                    NOT IN (SELECT  cod_prodotto
                            FROM 
                                serverdb.prodotto)
                    AND
                        MID(cod_formula,2,3) 
                     IN (SELECT tipo_codice FROM serverdb.codice )
                    AND
                                  
                        (id_utente,id_azienda) IN ".  $strUtentiAziende."
                    ORDER BY cod_formula";

    
$sql = mysql_query($stringSql) 
            or die("ERROR IN script_formula.php - FUNCTION selectCodFormulaNotInProdotto - ".$stringSql . mysql_error());
    return $sql;
}



function findMateriePriFormulaByCod($codiceFormula,$campoOrdine){
    
     $stringSql="SELECT *  FROM serverdb.formula f
                    JOIN serverdb.generazione_formula g ON f.cod_formula=g.cod_formula
                    JOIN serverdb.materia_prima m ON g.cod_mat=m.cod_mat
                WHERE
                    f.cod_formula='" . $codiceFormula . "'
                ORDER BY ".$campoOrdine;
    $sql = mysql_query($stringSql)
          or die("ERROR IN script_formula.php - FUNCTION findMateriePriFormulaByCod - : " . mysql_error());
    return $sql;
    
}



//##############################################################################
//########################### STORICO ##########################################
//##############################################################################

/**
 * 
 * @return type
 */
function storicizzaAnFormula($codFormula,
                                $dtFormula,
                                $descriFormula,
                                $numSac,
                                $qtaSac,
                                $abilitato,
                                $dtAbilitato) {
   
    $stringSql = "INSERT INTO storico.formula	
                        (cod_formula,
                         dt_formula,
                         descri_formula,
                         num_sac,
                         qta_sac,
                         abilitato,
                         dt_abilitato)
            VALUES(
                       '" . $codFormula . "',
                       '" . $dtFormula . "',
                       '" . $descriFormula . "',
                       '" . $numSac . "',
                       '" . $qtaSac . "',
                       " . $abilitato . ",
                       '" . $dtAbilitato . "')";
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_formula.php - FUNCTION storicizzaAnFormula - ".$stringSql . mysql_error());
    return $sql;
}





?>