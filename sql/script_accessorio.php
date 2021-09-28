<?php
//Tabelle coinvolte
//accessorio
//accessorio_formula


/**
 * Seleziona l'elenco di accessori non presenti in una formula 
 * diversi dai parametri dati
 * @param type $codiceFormula
 * @param type $codScatLot
 * @param type $codEticLot
 * @param type $codSacCh
 * @param type $codEticCh
 * @param type $codOper
 */
function findAccessoriNotInFormula($codiceFormula,$strUtentiAziende){

         $stringSql = "SELECT codice,descri 
                                FROM 
                                        serverdb.accessorio 
                                WHERE 
                                    descri IS NOT NULL
                                AND 
                                    codice IS NOT NULL
                                AND 
                                    (id_utente,id_azienda) IN ".  $strUtentiAziende."
                                AND
                                    codice NOT IN (SELECT accessorio 
                                                    FROM 
                                                        serverdb.accessorio_formula 
                                                    WHERE 
                                                        cod_formula='" . $codiceFormula . "'
                                                    )
                                                    ORDER BY descri";
$sql=mysql_query($stringSql)
          or die("ERROR IN script_accessorio.php - FUNCTION findAccessoriNotInFormula -  " .$stringSql." - ". mysql_error());
return $sql;

}







/**
 * Seleziona tutti gli accessori presenti nella tabella accessorio ad eccezione 
 * di quelli passati come parametri alla funzione, visibili all'utente
 * @param type $codScatLot
 * @param type $codEticLot
 * @param type $codEticCh
 * @param type $codSacCh
 * @param type $codOper
 * @param type $strUtentiAziende
 * @return type
 */
function findAccessoriDiversiDa($codScatLot,$codEticLot,$codEticCh,$codSacCh,$codOper,$strUtentiAziende){
    $stringSql="SELECT * 
                    FROM 
                            serverdb.accessorio
                    WHERE 
                                descri IS NOT NULL
                            AND 
                                codice IS NOT NULL
                            AND 
                                codice NOT IN ('".$codScatLot."','".$codEticLot."','".$codSacCh."','".$codEticCh."','".$codOper."')
                            AND
                                (id_utente,id_azienda) IN ".  $strUtentiAziende."
                            
                   ORDER BY descri";
    
//            mysql_query("SELECT * 
//                    FROM 
//                            serverdb.accessorio
//                    WHERE 
//                                descri IS NOT NULL
//                            AND 
//                                    codice IS NOT NULL
//                            AND 
//                                    codice<>'".$codScatLot."'
//                            AND 
//                                    codice<>'".$codEticLot."'
//                            AND 
//                                    codice<>'".$codSacCh."'
//                            AND 
//                                    codice<>'".$codEticCh."'
//                            AND 
//                                    codice<>'".$codOper."'
//                        ORDER BY descri")
           $sql = mysql_query($stringSql) 
                   or die("ERROR IN script_accessorio.php - FUNCTION findAccessoriDiversiDa - "  .$stringSql." - ". mysql_error());

return $sql;
}

/**
 * Seleziona tutti gli accessori dalla tabella accessorio ordinandoli 
 * in base al parametro passato nella funzione
 * @param type $campoOrdine
 * @return type
 */
function findAllAccessori($campoOrdine,$strUtentiAziende){
    $stringSql="SELECT * FROM serverdb.accessorio 
                            WHERE 
                                (id_utente,id_azienda) IN ".  $strUtentiAziende."
                            ORDER BY ".$campoOrdine;
    $sql = mysql_query($stringSql) 
        or die("ERROR IN script_accessorio.php - FUNCTION findAllAccessori - ".$stringSql." - "  . mysql_error());
     return $sql;
}



/**
 * Verifica l'esistenza di un accessorio nella tabella accessorio
 * facendo una select by codice 
 * @param type $codice
 * @return type
 */
function verificaEsistenzaAccessorio($codice){
    
    $sql= mysql_query("SELECT * FROM accessorio 
                        WHERE codice = '" . $codice . "'");
//    or  die("ERROR IN script_accessorio - FUNCTION verificaEsistenzaAccessorio - SELECT * FROM serverdb.accessorio : " . mysql_error());
    
    return $sql;
}



/**
 * Inserisce un nuovo accessorio nella tabella accessorio
 * @param type $codice
 * @param type $descri
 * @param type $unitaMisura
 * @param type $prezzoAcq
  * @return type
 */
function insertAccessorio($codice,$descri,$unitaMisura,$prezzoAcq,$idUtente,$idAzienda){
    
    $sql=mysql_query("INSERT INTO serverdb.accessorio (
                            codice,
                            descri,
                            uni_mis,
                            pre_acq,
                            id_utente,
                            id_azienda)
               VALUES ( '" . $codice . "',
                        '" . $descri . "',                       
                        '" . $unitaMisura . "',
                        " . $prezzoAcq . ",
                        ".$idUtente.",
                        ".$idAzienda.")"); 
//     or  die("ERROR IN script_accessorio - FUNCTION insertAccessorio - INSERT INTO serverdb.accessorio  : " . mysql_error());
    return $sql;
}

/**
 * Seleziona un accessorio dal codiceLot
 * @param type $codice
 * @return type
 */
function findAccessorioByCodice($codice){
    
     $sql=   mysql_query("SELECT * FROM serverdb.accessorio WHERE codice ='".$codice."'"); 
//     or  die("ERROR IN script_accessorio - FUNCTION findAccessorioByCodice - SELECT * FROM serverdb.accessorio  : " . mysql_error());
    return $sql;
    
    
}

/**
 * Modifica un accessorio nella tabella accessorio
 * @param type $codiceOld
 * @param type $codice
 * @param type $descri
 * @param type $uniMis
 * @param type $preAcq
 * @param type $idAzienda
 * @return type
 */
function modificaAccessorio($codiceOld,$codice,$descri,$uniMis,$preAcq,$idAzienda){
  
    $sql=   mysql_query("UPDATE serverdb.accessorio SET 
                            codice= if(codice != '" . $codice . "','" . $codice . "',codice),
                            descri= if(descri != '" . $descri . "','" . $descri . "',descri),
                            uni_mis= if(uni_mis != '" . $uniMis . "','" . $uniMis . "',uni_mis),
                            pre_acq= if(pre_acq != '" . $preAcq . "','" . $preAcq . "',pre_acq),
                            id_azienda= if(id_azienda != '" . $idAzienda . "','" . $idAzienda . "',id_azienda)
                        WHERE codice ='".$codiceOld."'")
     or  die("ERROR IN script_accessorio - FUNCTION modificaAccessorio - UPDATE serverdb.accessorio  : " . mysql_error());
    return $sql;
    
    
}

?>
