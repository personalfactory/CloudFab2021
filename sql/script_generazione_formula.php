<?php
//Tabelle coinvolte 
//generazione_formula
//materia_prima

//##############################################################################
//########################### SERVERDB #########################################
//##############################################################################
/**
 * Cerca una materia prima in una formula di produzione
 * @param type $codiceFormula
 * @param type $codiceMatPrima
 * @return type
 */
function findMatPrimaByFormulaAndCod($codiceFormula,$codiceMatPrima){

$stringSql="SELECT * FROM serverdb.generazione_formula 
                                WHERE 
                                        cod_formula='".$codiceFormula."' 
                                AND 
                                        cod_mat='".$codiceMatPrima."'";
$sql=  mysql_query($stringSql) 
        or die("ERROR IN script_generazione_formula.php - FUNCTION findMatPrimaByFormulaAndCod - " .$stringSql." - ".  mysql_error());

return $sql;


}



/**
 * Inserisce le qta di materie prime nella tabella generazione_formula
 * @param type $codMat
 * @param type $codFormula
 * @param type $qtaMat
 * @param type $dtInser
 * @param type $abilitato
 * @param type $dtAbilitato
 * @return type
 */
function inserisciGenerazioneFormula($codMat,
        $codFormula,
        $qtaMat,
        $qtaKit,
        $dtInser,
        $abilitato,
        $dtAbilitato){
    $stringSql="INSERT INTO serverdb.generazione_formula 
                (cod_mat,
                cod_formula,	
                quantita,
                qta_kit,
                dt_inser,
                abilitato,
                dt_abilitato)
        VALUES(
                        '" . $codMat . "',
                        '" . $codFormula . "',
                        " . $qtaMat . ",
                        " . $qtaKit . ",
                        '" . $dtInser . "',
                        ".$abilitato.",
                        '" . $dtAbilitato. "')";
 $sql=mysql_query($stringSql) ;
//        or die("ERROR IN script_generazione_formula.php - FUNCTION inserisciGenerazioneFormula - " .$stringSql." - ".  mysql_error());
 return $sql;
}



/**
 * Seleziona l'elenco delle materie prime di una formula
 * @param type $codiceFormula
 * @return type
 */
function findMaterieFormulaByCodice($codiceFormula,$campoOrdine){
    
    $sql = mysql_query("SELECT 
                                *
                        FROM 
                                serverdb.generazione_formula 
                        INNER JOIN 
                                serverdb.materia_prima 
                        ON 
                                generazione_formula.cod_mat=materia_prima.cod_mat
                        WHERE
                                cod_formula='" . $codiceFormula . "'
                        ORDER BY ".$campoOrdine)
          or die("ERROR IN script_generazione_formula.php - FUNCTION findMaterieFormulaByCodice - SELECT 
                                *
                        FROM 
                                serverdb.generazione_formula 
                        INNER JOIN 
                                serverdb.materia_prima : " . mysql_error());
    return $sql;
    
}

/**
 * Seleziona l'elenco delle materie prime presenti nella tabella 
 * materia_prima ma non presenti nella formula, visibili all'utente 
 * @param type $codiceFormula
 * @param type $campoOrdine
 * @param type $strUtentiAziende
 * @return type
 */
function findMaterieNonPresentiInFormula($codiceFormula,$campoOrdine,$prefiCodComp,$strUtentiAziende){   
    $stringSql= "SELECT * FROM serverdb.materia_prima 
                    WHERE 
                            (id_utente,id_azienda) IN ".  $strUtentiAziende."
                       AND     
                            cod_mat NOT LIKE '".$prefiCodComp."%'         
                        AND     
                            cod_mat NOT IN 
                         (SELECT 
                                        cod_mat
                                FROM 
                                        serverdb.generazione_formula 
                                WHERE
                                        cod_formula='" . $codiceFormula . "')
                        ORDER BY ".$campoOrdine;   
    $sql= mysql_query($stringSql)
    or die("ERROR IN script_generazione_formula.php - FUNCTION findMaterieNonPresentiInFormula - ". $stringSql. " : ".mysql_error());
    
    return $sql;
        
}

/**
 * Seleziona tutte le materie prime di una data formula
 * @param type $codiceFormula
 */
function findMatPrimeFormulaByCodFormula($codiceFormula){
    
    $stringSql="SELECT 
                   *
                FROM
                    serverdb.generazione_formula
                WHERE 
                    cod_formula='".$codiceFormula."'";
    $sql=mysql_query($stringSql) 
    or die("ERROR IN script_generazione_formula.php - FUNCTION findMatPrimeFormulaByCodFormula - ". $stringSql." - " .mysql_error());
    return $sql;
}

/**
 * Modifica la quantità e la data di una materia prima in una data formula
 * @param type $idGenForm
 * @param type $codiceFormula
 * @param type $quantita
 * @param type $qtaKit
 * @param type $dtAbilitato
 * @return type
 */
function modificaGenerazioneFormula($idGenForm,$codiceFormula,$quantita,$qtaKit,$dtAbilitato){
        
    $stringSql="UPDATE serverdb.generazione_formula 										    								                    SET
                    quantita=".$quantita.",	
                        qta_kit=".$qtaKit.",
                    dt_abilitato='".$dtAbilitato."'
            WHERE
                    cod_formula='".$codiceFormula."'
            AND
                    id_gen_form=".$idGenForm;
         
    $sql=mysql_query($stringSql)
          or die("ERROR IN script_generazione_formula.php - FUNCTION modificaGenerazioneFormula - " .$stringSql." - " .mysql_error());
          
          return $sql;

          
}

/**
 * Elimina un record nella tabella generazione_formula
 * @param type $idGenForm
 * @return type
 */
function eliminaRecordGenFormulaById($idGenForm){
$stringSql="DELETE FROM serverdb.generazione_formula WHERE id_gen_form=".$idGenForm;

 $sql=mysql_query($stringSql); 
          //or die("ERROR IN script_generazione_formula.php - FUNCTION eliminaRecordGenFormulaById - " .$stringSql." - " .mysql_error());
          
          return $sql;


}


//##############################################################################
//########################### STORICO ##########################################
//##############################################################################

/**
 * Inserisce un record nella tabella generazione_formula del db storico
 * @param type $idGenForm
 * @param type $codFormula
 * @param type $codMat
 * @param type $quantita
 * @param type $dtInser
 * @param type $abilitato
 * @param type $dtAbilitato
 * @return type
 */
function storicizzaGenerazioneFormula($idGenForm,$codFormula,$codMat,$quantita,$dtInser,$abilitato,$dtAbilitato){
$stringSql="INSERT INTO storico.generazione_formula 						 										
                                    (id_gen_form,
                                     cod_formula,
                                     cod_mat,
                                     quantita,
                                     dt_inser,
                                     abilitato,
                                     dt_abilitato) 
                    VALUES(
                                       ".$idGenForm.",
                                       '".$codFormula."',
                                       '".$codMat."',
                                       '".$quantita."',
                                       '".$dtInser."',
                                       ".$abilitato.",
                                       '".$dtAbilitato."')";
$sql=mysql_query($stringSql); 
//        or die("ERROR IN script_generazione_formula.php - FUNCTION storicizzaGenerazioneFormula - ". $stringSql. mysql_error());

return $sql;
}


function selectMatPrimeInFormule($campoOrdine, $campoGroupBy,$strUtentiAziende) {

    $stringSql = "SELECT g.cod_mat as cod_mat FROM serverdb.generazione_formula g
        JOIN serverdb.materia_prima m ON g.cod_mat=m.cod_mat
         WHERE 
             (id_utente,id_azienda) IN ".$strUtentiAziende."     
         
         GROUP BY " . $campoGroupBy . "       
         ORDER BY " . $campoOrdine;
    
         $sql= mysql_query($stringSql ) or die("ERROR IN script_generazione_formula - FUNCTION selectMatPrimeInFormule -  ".$stringSql." - " . mysql_error());

    return $sql;
}


function findFormuleByMatPrima($codiceMatPrima,$strUtentiAziende){

$stringSql="SELECT * FROM serverdb.generazione_formula g JOIN serverdb.formula f
                            ON g.cod_formula=f.cod_formula
                            JOIN serverdb.prodotto p
                            WHERE 
                            p.cod_prodotto=SUBSTRING(f.cod_formula,2,6)
                            AND
                            (f.id_utente,f.id_azienda) IN ".$strUtentiAziende."    
                            AND cod_mat='".$codiceMatPrima."'";
$sql=  mysql_query($stringSql) 
        or die("ERROR IN script_generazione_formula.php - FUNCTION findFormuleByMatPrima - " .$stringSql." - ".  mysql_error());

return $sql;


}