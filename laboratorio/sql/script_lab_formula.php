<?php

/**
 * Seleziona tutte le formule visibili filtrando per codice formula  
 * @param $campoOrdine
 * @return type
 */
function findAllLabFormuleByCod($campoOrdine,$strUtentiAziende,$codLabFormula,$visibilita){
    $stringSql="SELECT *
                        FROM
                                serverdb.lab_formula
                        WHERE (id_utente,id_azienda) IN ".$strUtentiAziende."  
                            AND
                            cod_lab_formula LIKE '%".$codLabFormula."%'
                            AND 
                                visibilita<=".$visibilita."
                        ORDER BY ".$campoOrdine;
    $sql=mysql_query($stringSql)
     or die("ERROR IN script_lab_formula - FUNCTION findAllLabFormuleByCod - ". $stringSql ." - ". mysql_error());
    
    
    
    return $sql;
}


/**
 * Seleziona tutte le formule di un dato prodotto target 
 * @param type $prodOb
 * @return type
 */
function findFormuleByProdOb($prodOb,$strUtentiAziende){
    
    $stringSql="SELECT *
                        FROM
                                serverdb.lab_formula
                        WHERE 
                                prod_ob='".$prodOb."'
                           AND
                                (id_utente,id_azienda) IN ".$strUtentiAziende."                          
                   ORDER BY cod_lab_formula";
            
            
            $sql=mysql_query($stringSql) 
                    or die("ERROR IN script_lab_formula - FUNCTION findFormuleByProdOb - ".$stringSql." - " . mysql_error());
    
    
    
    return $sql;
}



/**
 * Cerca un codice formula nella tabella lab_formula
 * @param type $codice
 * @return type
 */
function verificaEsistenzaFormula($codice){

      $sql = mysql_query("SELECT * FROM serverdb.lab_formula 
			WHERE 
                            cod_lab_formula = '" . $codice . "'")
        or die("ERROR IN script_lab_formula - FUNCTION verificaEsistenzaFormula - SELECT FROM serverdb.lab_formula : " . mysql_error());

    return $sql;
}

/**
 * Seleziona le formule di un determinato gruppo ed utente
 * @param type $userName
 * @param type $nomeGruppo
 * @return type
 */
//function findFormuleByUtenteGruppo($campoOrdine,$userName, $nomeGruppo){
//      $stringSql = "SELECT * FROM lab_formula 
//                            WHERE
//                                 utente='" .$userName . "'
//                            OR
//                                 gruppo_lavoro='" . $nomeGruppo . "'
//                            ORDER BY ".$campoOrdine;
//             $sql= mysql_query($stringSql)
//        or die("ERROR IN script_lab_formula - FUNCTION findFormuleByGruppo - " .$stringSql." - ".  mysql_error());
//
//    return $sql;
//}


/**
 * Seleziona le formule di un determinato gruppo ed utente
 * @param type $idAzienda
 * @param type $campoOrdine
 * @return type
 */
function findFormuleByAzienda($campoOrdine,$idAzienda){
      $stringSql = "SELECT * FROM lab_formula 
                            WHERE
                                 id_azienda=" .$idAzienda." ORDER BY ".$campoOrdine;                            
                            
             $sql= mysql_query($stringSql)
        or die("ERROR IN script_lab_formula - FUNCTION findFormuleByAzienda - " .$stringSql." - ".  mysql_error());

    return $sql;
}





/**
 * Inserisce una nuova formula nella tabella lab_formula
 * @param type $codice
 * @param type $dataCorrente
 * @param type $prodOb
 * @param type $normativa
 * @param type $codiceEsistenza
 * @param type $userName
 * @param type $nomeGruppo
 * @param type $idUtente
 * @param type $idAzienda
 * @return type
 */
function salvaLabFormula($codice,$dataCorrente,$prodOb,$normativa,$codiceEsistenza,$userName,$nomeGruppo,$idUtente,$idAzienda,$visibilita){
   
    $stringSql ="INSERT INTO lab_formula (cod_lab_formula,
                                                dt_lab_formula,
                                                prod_ob,
                                                normativa,
                                                cod_esistenza,
                                                utente,
                                                gruppo_lavoro,id_utente,id_azienda,visibilita)
                                      VALUES ( 
                                        '" . $codice . "',
                                        '" . $dataCorrente . "',
                                        '" . $prodOb . "',    
                                        '" . $normativa . "', 
                                        '" . $codiceEsistenza . "',
                                        '" . $userName . "',
                                        '" . $nomeGruppo . "',
                                            " . $idUtente . ",
                                                " . $idAzienda . ",".$visibilita.")";
       $sql= mysql_query($stringSql);
       //or die("ERROR IN script_lab_formula - FUNCTION salvaLabFormula -  " .$stringSql." - ". mysql_error());
    return $sql;
    
}


/**
 * Seleziona tutte le formule, in base ai filtri, utilizzando LIKE.
 * Effettua una ricerca su tutti i gruppi di lavoro.
 * @param type $campoOrdine
 * @param type $campoGroupBy
 * @param type $codLabForm
 * @param type $dtLabForm
 * @param type $prodOb
 * @param type $utente
 * @param type $gruppoLavoro
 * @return type
 */
function findAllFormule($campoOrdine,
        $campoGroupBy,
        $codLabForm,
        $dtLabForm,
        $prodOb,
        $normativa,
        $utente,
        $gruppoLavoro,$strUtentiAziende,$visibilita){
    
    $sql=mysql_query("SELECT * FROM lab_formula 
                        WHERE
                            cod_lab_formula LIKE '%".$codLabForm."%'
                           AND 
                            dt_lab_formula LIKE '%".$dtLabForm."%'
                           AND
                            prod_ob LIKE '%".$prodOb."%'
                           AND
                            normativa LIKE '%".$normativa."%'
                           AND
                            utente LIKE '%".$utente."%'
                           AND 
                            gruppo_lavoro LIKE '%".$gruppoLavoro."%'
                           AND 
                            (id_utente,id_azienda) IN ".$strUtentiAziende." 
                           AND 
                            visibilita<=".$visibilita."
                           GROUP BY ".$campoGroupBy."
                           ORDER BY ".$campoOrdine) 

            or die("ERROR IN script_lab_formula - FUNCTION findAllFormule - SELECT FROM serverdb.lab_formula " . mysql_error());
   
    return $sql;
    
}

/**
 * Seleziona le informazioni anagrafiche di una formula
 * @param type $codLabForm
 * @return type
 */
function findFormulaByCodice($codLabForm){
    $stringSql="SELECT *
                        FROM
                                serverdb.lab_formula
                        WHERE 
                                cod_lab_formula='".$codLabForm."'";
    $sql=mysql_query($stringSql)
     or die("ERROR IN script_lab_formula - FUNCTION findFormulaByCodice - SELECT FROM serverdb.lab_formula " . mysql_error());
    
    
    
    return $sql;
}

/**
 * Modifica l'azieda e la visibilita di una formula in laboratorio
 * @param type $codLabForm
 * @param type $azienda
 * @param type $visibilita
 * @return type
 */
function updateLabFormulaByCodice($codLabForm,$azienda,$visibilita){
    $stringSql="UPDATE serverdb.lab_formula "
            . "SET id_azienda=".$azienda.","
            . " visibilita=".$visibilita."           
             WHERE 
                cod_lab_formula='".$codLabForm."'";
    $sql=mysql_query($stringSql)
     or die("ERROR IN script_lab_formula - FUNCTION updateLabFormulaByCodice - ".$stringSql." ". mysql_error());
    
    
    
    return $sql;
}


/**
 * Seleziona le formule, in base ai filtri, utilizzando LIKE.
 * Effettua la ricerca all'interno di un determinato gruppo di lavoro.
 * @param type $username (Utente corrente salvato nella sessione)
 * @param type $gruppo (Gruppo dell'utente salvato in sessione)
 * @param type $campoOrdine
 * @param type $campoGroupBy
 * @param type $codLabForm
 * @param type $dtLabForm
 * @param type $prodOb
 * @param type $utente (Utente che si intende ricercare per visualizzarne le formule)
 * @return type
 */
//function findFormuleByGruppo($username,
//                             $gruppo,
//                             $campoOrdine,
//                             $campoGroupBy,
//                             $codLabForm,
//                             $dtLabForm,
//                             $prodOb,
//                             $normativa,
//                             $utente,
//                             $strUtentiAziende){
//    $sql = mysql_query("SELECT *
//                            FROM 	
//                                lab_formula 
//                            WHERE 
//                                (utente='" . $username . "' 
//                            OR  
//                                gruppo_lavoro='" . $gruppo . "')
//                            AND 
//                                cod_lab_formula LIKE '%".$codLabForm."%'
//                            AND 
//                                dt_lab_formula LIKE '%".$dtLabForm."%'
//                            AND
//                                prod_ob LIKE '%".$prodOb."%'
//                            AND
//                                normativa LIKE '%".$normativa."%'
//                            AND 
//                                utente LIKE '%".$utente."%'
//                            AND 
//                                (id_utente,id_azienda) IN ".$strUtentiAziende." 
//                            GROUP BY ". $campoGroupBy."
//                            ORDER BY ". $campoOrdine) 
//    
//     or die("ERROR IN script_lab_formula - FUNCTION findFormuleByGruppo - SELECT FROM serverdb.lab_formula " . mysql_error());
//   return $sql;
//}



/**
 * Seleziona tutte le formule di un dato utente di un dato gruppo
 * @param type $codLabForm
 * @return type
 */
//function findFormuleAllByUtente($username,$gruppo){
//    
//    $stringSql="SELECT * FROM lab_formula
//                        WHERE
//                        utente='".$username."'
//                        AND 
//                        gruppo_lavoro='".$gruppo."'";
//    $sql=mysql_query($stringSql)  
//            or die("ERROR IN script_lab_formula - FUNCTION findFormuleAllByUtente   ".$stringSql ." - ". mysql_error());
//    
//    
//    
//    return $sql;
//}


/**
 * Seleziona tutte le formule di un dato prodotto target di un gruppo utente
 * @param type $prodOb
 *  @param type $username
 *  @param type $gruppo
 * @return type
 */
//function findFormuleByProdObUtenteGruppo($prodOb,$username,$gruppo,$strUtentiAziende){
//    
//    $stringSql="SELECT *
//                        FROM
//                                serverdb.lab_formula
//                        WHERE 
//                                prod_ob='".$prodOb."'
//                          AND          
//                                (utente='" . $username . "' 
//                            OR  
//                                gruppo_lavoro='" . $gruppo . "')
//                          AND
//                            (id_utente,id_azienda) IN ".$strUtentiAziende."
//                   ORDER BY cod_lab_formula";
//            
//            
//            $sql=mysql_query($stringSql) 
//                    or die("ERROR IN script_lab_formula - FUNCTION findFormuleByProdOb - ".$stringSql." - " . mysql_error());
//    
//    
//    
//    return $sql;
//}


/**
 * Seleziona tutte le formule  
 * @param $campoOrdine
 * @return type
 */
//function findAllLabFormule($campoOrdine,$strUtentiAziende){
//    $stringSql="SELECT *
//                        FROM
//                                serverdb.lab_formula
//                        WHERE (id_utente,id_azienda) IN ".$strUtentiAziende."        
//                        ORDER BY ".$campoOrdine;
//    $sql=mysql_query($stringSql)
//     or die("ERROR IN script_lab_formula - FUNCTION findAllLabFormule - ". $stringSql ." - ". mysql_error());
//    
//    
//    
//    return $sql;
//}


/**
 * Seleziona le formule di un determinato gruppo ed utente visibili all'utente
 * @param type $campoOrdine
 * @param type $userName
 * @param type $nomeGruppo
 * @param type $strUtentiAziende
 * @return type
 */
//function findFormuleVisByGruppo($campoOrdine,$userName, $nomeGruppo,$strUtentiAziende){
//      $stringSql = "SELECT * FROM serverdb.lab_formula 
//                            WHERE
//                                 (utente='" .$userName . "'
//                                OR
//                                 gruppo_lavoro='" . $nomeGruppo . "')
//                            AND (id_utente,id_azienda) IN ".$strUtentiAziende."         
//                            ORDER BY ".$campoOrdine;
//             $sql= mysql_query($stringSql)
//        or die("ERROR IN script_lab_formula - FUNCTION findFormuleVisByGruppo - " .$stringSql." - ".  mysql_error());
//
//    return $sql;
//}


/**
 * Salva le informazioni anagrafiche della formula nella tabella lab_formula
 * @param type $Codice
 * @param type $dataCorrente
 * @param type $CodiceEsistenza
 * @param type $userName
 * @param type $nomeGruppo
 * @return type
 */
//function salvaFormula($codice,$dataCorrente,$prodOb,$normativa,$codiceEsistenza,$userName,$nomeGruppo){
//   
//    $sql=mysql_query("INSERT INTO lab_formula (cod_lab_formula,
//                                                dt_lab_formula,
//                                                prod_ob,
//                                                normativa,
//                                                cod_esistenza,
//                                                utente,
//                                                gruppo_lavoro)
//                                      VALUES ( 
//                                        '" . $codice . "',
//                                        '" . $dataCorrente . "',
//                                        '" . $prodOb . "',    
//                                        '" . $normativa . "', 
//                                        '" . $codiceEsistenza . "',
//                                        '" . $userName . "',
//                                        '" . $nomeGruppo . "')")
//       or die("ERROR IN script_lab_formula - FUNCTION salvaFormula - INSERT INTO serverdb.lab_formula " . mysql_error());
//    return $sql;
//    
//}

?>
