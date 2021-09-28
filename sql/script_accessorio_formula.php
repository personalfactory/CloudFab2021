<?php
//##############################################################################
//########################## SERVERDB ##########################################
//##############################################################################
/**
 * Inserisce un accessorio formula
 * @param type $codiceFormula
 * @param type $accessorio
 * @param type $quantita
 * @param type $abilitato
 * @param type $dtAbilitato
 */
function inserisciAccFormula($codiceFormula,$accessorio,$quantita,$abilitato,$dtAbilitato){

$sql=mysql_query("INSERT INTO serverdb.accessorio_formula 
            (cod_formula,accessorio,quantita,abilitato,dt_abilitato) 
                    VALUES(
                            '" . $codiceFormula . "',
                            '" . $accessorio . "',
                            '" . $quantita . "',
                            ".$abilitato.",
                            '" . $dtAbilitato . "')") ;
//        or die("ERROR IN script_accessorio_formula.php - FUNCTION inserisciAccFormula - INSERT INTO serverdb.accessorio_formula : " . mysql_error());
return $sql;
}

/**
 * Seleziona gli accessori di una data formula con i prezzi
 * @param type $codiceFormula
 * @param type $codScatLot
 * @param type $codEticLot
 * @param type $codEticCh
 * @param type $codSacCh
 * @param type $codOper
 * @return type
 */
function findAccessFormByCodFormula($codiceFormula,$codScatLot,$codEticLot,$codSacCh,$codEticCh,$codOper){

$sql = mysql_query("SELECT 
                        *
                FROM 
                        serverdb.accessorio_formula 
                INNER JOIN 
                        serverdb.accessorio
                ON 	
                        accessorio_formula.accessorio=accessorio.codice
                WHERE 
                        cod_formula='" . $codiceFormula . "'
                AND
                        accessorio<>'".$codScatLot."'
                AND 
                        accessorio<>'".$codEticCh."'
                AND 
                        accessorio<>'".$codSacCh."'
                AND 
                        accessorio<>'".$codEticLot."'
                AND 
                        accessorio<>'".$codOper."'
                ORDER BY descri")
          or die("ERROR IN script_accessorio_formula.php - FUNCTION findAccessFormByCodFormula - SELECT : " . mysql_error());

return $sql;

}

/**
 * Seleziona un accessorio di una data formula
 * @param type $codiceFormula
 * @param type $codAccessorio
 * @return type
 */
function findAccessorioInFormulaByCodice($codiceFormula,$codAccessorio){
    
                        $stringSql="SELECT 
                                            accessorio_formula.quantita
                                    FROM 
                                            serverdb.accessorio_formula 
                                    WHERE 
                                            cod_formula='".$codiceFormula."'
                                    AND 
                                            accessorio='".$codAccessorio."'";
    $sql = mysql_query($stringSql)
    or die("ERROR IN script_accessorio_formula.php - FUNCTION findAccessorioInFormulaByCodice - ".$stringSql." : " . mysql_error());
    return $sql;
}

/**
 * Seleziona tutti gli accessori di una data formula
 * @param type $codiceFormula
 */
function findAccessoriFormulaByCodFormula($codiceFormula){
    
    $stringSql="SELECT 
                    id_acces_form,
                    codice,
                    descri,
                    pre_acq,
                    uni_mis,
                    cod_formula,
                    accessorio,
                    quantita,
                    af.abilitato,
                    af.dt_abilitato
            FROM
                    serverdb.accessorio_formula af
            JOIN 
                    serverdb.accessorio a ON af.accessorio=a.codice
            WHERE 
                    cod_formula='".$codiceFormula."'";
    
    $sql = mysql_query($stringSql)
    or die("ERROR IN script_accessorio_formula.php - FUNCTION findAccessoriFormulaByCodFormula - ".$stringSql." - ". mysql_error());
    return $sql;
}

/**
 * Modifica un accessorio in una data formula
 * @param type $codiceFormula
 * @param type $codAccessorio
 * @param type $quantita
 * @param type $dtAbilitato
 * @return type
 */
function modificaAccessorioFormula($codiceFormula,$codAccessorio,$quantita,$dtAbilitato){
    
   $stringSql="UPDATE serverdb.accessorio_formula
                SET 
                    quantita='".$quantita."',
                    dt_abilitato='".$dtAbilitato."'
                WHERE
                    cod_formula='".$codiceFormula."'
                AND
                    accessorio='".$codAccessorio."'";
$sql = mysql_query($stringSql)
    or die("ERROR IN script_accessorio_formula.php - FUNCTION modificaAccessoriFormulaByCodFormula - ".$stringSql." - ". mysql_error());
    return $sql;
    
}




//##############################################################################
//########################## STORICO ###########################################
//##############################################################################
/**
 * Inserisce nella tabella accessorio_formula del db storico 
 * un accessorio di una data formula 
 * @param type $idAccForm
 * @param type $codFormula
 * @param type $accessorio
 * @param type $quantita
 * @param type $abilitato
 * @param type $dtAbilitato
 * @return type
 */
function storicizzaAccessorioFormula($idAccForm,$codFormula,$accessorio,$quantita,$abilitato,$dtAbilitato){
    
    $stringSql="INSERT INTO storico.accessorio_formula 						 										
                (id_acces_form,
                 cod_formula,
                 accessorio,
                 quantita,
                 abilitato,
                 dt_abilitato) 
        VALUES(
           ".$idAccForm.",
           '".$codFormula."',
           '".$accessorio."',
           '".$quantita."',
           ".$abilitato.",
           '".$dtAbilitato."')";
    $sql=mysql_query($stringSql)
or die("ERROR IN script_accessorio_formula.php - FUNCTION  storicizzaAccessorioFormula - ". $strinSql. mysql_error());
    return $sql;
}



?>
