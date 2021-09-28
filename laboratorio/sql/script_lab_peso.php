<?php
/**
 * Elimina dalla tabella lab_peso tutti i record relativi alla macchina in uso
 * @param type $idLabMacchina
 */
function deleteLabPeso($idLabMacchina) {
   $stringSql="DELETE FROM serverdb.lab_peso WHERE id_lab_macchina= " . $idLabMacchina;
    
    $sql=mysql_query($stringSql);
//         or die("ERROR IN script_lab_peso - FUNCTION deleteLabPeso - " .$stringSql." - ".  mysql_error());
    
    return $sql;
    
}


/**
 * Inizializza la tabella lab_peso relativa alle materie prime compound da pesare 
 * @param type $CodiceBarre
 * @param type $CodiceFormula
 * @param type $idLabMacchina
 * @param type $valoreDefPeso
 */
function inizializzaLabPesoCodMat($codiceBarre, $codiceFormula,$idLabMacchina,$valoreDefPeso,$tipo,$qtaMiscela,$tipoProva,$idUtente,$idAzienda){

      $stringSql="INSERT INTO serverdb.lab_peso (id,codice,peso,cod_barre,id_lab_macchina,
         descri,qta_teo,qta,cod_lab_formula,tipo,uni_mis,qta_miscela,tipo_esperimento,id_utente,id_azienda,prezzo) 
                SELECT
                    mt.id_mat,
                    mp.cod_mat,
                    ". $valoreDefPeso .",
                    '" . $codiceBarre . "',
                    ". $idLabMacchina .",
                        mp.descri_materia,
                        mt.qta_teo,
                        mt.qta_teo_perc,
                        '".$codiceFormula."',
                            '".$tipo."',
                                unita_misura,
                                ".$qtaMiscela.",
                                '".$tipoProva."',
                                ".$idUtente.",
                                    ".$idAzienda.",
                                        mp.prezzo
                                
                FROM
                        lab_matpri_teoria mt
                INNER JOIN 
                        lab_materie_prime mp ON mp.id_mat = mt.id_mat
                WHERE 
                    mp.cod_mat NOT LIKE 'comp%'
                    AND
                    mt.cod_lab_formula='" . $codiceFormula . "'";
  $sql=mysql_query($stringSql)
          or die("ERROR IN script_lab_peso - FUNCTION inizializzaLabPesoCodMat - " .$stringSql." - ".  mysql_error());
return $sql;
}

/**
 * Inizializza la tabella lab_peso relativa alle materie prime drymix da pesare 
 * @param type $CodiceBarre
 * @param type $CodiceFormula
 * @param type $idLabMacchina
 * @param type $valoreDefPeso
 */
function inizializzaLabPesoComp($codiceBarre, $codiceFormula,$idLabMacchina,$valoreDefPeso,$tipo,$qtaMiscela,$tipoProva,$idUtente,$idAzienda ){

     $stringSql="INSERT INTO serverdb.lab_peso (id,codice,peso,cod_barre,id_lab_macchina,
         descri,qta_teo,qta,cod_lab_formula,tipo,uni_mis,qta_miscela,tipo_esperimento,id_utente,id_azienda,prezzo) 
                SELECT
                    mt.id_mat,
                    mp.cod_mat,
                    ". $valoreDefPeso .",
                    '" . $codiceBarre . "',
                    ". $idLabMacchina .",
                        mp.descri_materia,
                        mt.qta_teo,
                        mt.qta_teo_perc,
                        '".$codiceFormula."',
                            '".$tipo."',
                        mp.unita_misura,
                        ".$qtaMiscela.",
                        '".$tipoProva."',
                                ".$idUtente.",
                                    ".$idAzienda.",mp.prezzo
                FROM
                        lab_matpri_teoria mt
                INNER JOIN 
                        lab_materie_prime mp ON mp.id_mat = mt.id_mat
                WHERE 
                    mp.cod_mat LIKE 'comp%'
                    AND
                    mt.cod_lab_formula='" . $codiceFormula . "'";
  $sql=mysql_query($stringSql)
          or die("ERROR IN script_lab_peso - FUNCTION inizializzaLabPesoCodMat - " .$stringSql." - ".  mysql_error());
return $sql;
}



/**
 * Inizializzazione della tabella lab_peso relativa ai parametri di un dato tipo
 * @param type $CodiceBarre
 * @param type $CodiceFormula
 * @param type $tipoParametro
 * @param type $idLabMacchina
 * @param type $valoreDefPeso
 */
 
function inizializzaLabPesoParametri($codiceBarre,$codiceFormula,$tipoParametro,$idLabMacchina,$valoreDefPeso,$qtaMiscela,$tipoProva,$idUtente,$idAzienda){
    $stringSql="INSERT INTO lab_peso (id,codice,peso,cod_barre,id_lab_macchina,
       descri,qta_teo,qta,cod_lab_formula,tipo,uni_mis,qta_miscela,tipo_esperimento,id_utente,id_azienda,prezzo) 
            SELECT
                            lab_parametro_teoria.id_par,
                            lab_parametro.nome_parametro,
                            ".$valoreDefPeso.",
                            '" . $codiceBarre . "',
                            ".$idLabMacchina.",
                             lab_parametro.descri_parametro,
                             lab_parametro_teoria.valore_teo,
                             ".$valoreDefPeso.",
                             '".$codiceFormula."',
                             lab_parametro.tipo,
                             lab_parametro.unita_misura,
                             ".$qtaMiscela.",
                             '".$tipoProva."',
                                ".$idUtente.",
                                    ".$idAzienda.",0
            FROM
                            lab_parametro_teoria 
            INNER JOIN 
                            lab_parametro ON lab_parametro.id_par = lab_parametro_teoria.id_par
            WHERE 
                            lab_parametro_teoria.cod_lab_formula='" . $codiceFormula . "'
                    AND 
                    (lab_parametro.tipo LIKE '%" . $tipoParametro . "%' )";
        $sql=mysql_query($stringSql)
          or die("ERROR IN script_lab_peso - FUNCTION inizializzaLabPesoPercSI - " .$stringSql." - ".  mysql_error());
        return $sql;

}

/**
 * La tabella viene inizializzata: 
 * peso <- quantita registrate nella prova di origine calcolate in base alla nuova quantita totale di miscela; 
 * qta_teo <- quantita teorica percentuale definita nella formula
 * qta <- quantita percentuale reale usata nella prova di origine  
 * la tabella viene aggiornata con le quantita pesate durante la procedura di pesa 
 * eseguita nella pagina carica_lab_peso
 *
 * @param type $qtaTotMiscela
 * @param type $codiceBarre
 * @param type $idEsperimento
 * @param type $pesoMiscela
 * @param type $idLabMacchina
 * @param type $codLabFormula
 * @param type $tipo
 * @return type
 */
function inizializzaLabPesoMatPriKeVaria( $qtaTotMiscela, $codiceBarre, $idEsperimento,
        $pesoMiscela,$idLabMacchina,$codLabFormula,$tipo,$tipoEsperimento,$idUtente,$idAzienda ){

 $stringSql="INSERT INTO lab_peso (id,codice,peso,cod_barre,id_lab_macchina,
                              descri,uni_mis,qta_teo,qta,cod_lab_formula,tipo,qta_miscela,prezzo,tipo_esperimento,id_utente,id_azienda) 
                SELECT
                                r.id_mat,
                                m.cod_mat,
                                TRUNCATE((r.qta_reale*" . $pesoMiscela . ")/" . $qtaTotMiscela . ",4),
                                '" . $codiceBarre . "',
                                ".$idLabMacchina.",
                                m.descri_materia,
                                m.unita_misura,
                                mt.qta_teo_perc,
                                TRUNCATE((r.qta_reale*100)/".$qtaTotMiscela.",4),
                                mt.cod_lab_formula,
                                '" . $tipo . "',".$pesoMiscela.",prezzo,
                                    '" . $tipoEsperimento . "',
                                        " . $idUtente . ",
                                            " . $idAzienda . "
                                    
                FROM
                                lab_risultato_matpri r
                INNER JOIN 
                                lab_materie_prime m ON m.id_mat = r.id_mat
                INNER JOIN 
                                lab_matpri_teoria mt ON m.id_mat = mt.id_mat
                WHERE 
                                m.cod_mat NOT LIKE 'comp%'
                           AND
                                r.id_esperimento=" . $idEsperimento."
                           AND 
                                mt.cod_lab_formula='".$codLabFormula."'
                 GROUP BY m.id_mat
                 ORDER BY m.id_mat  ";
        $sql=mysql_query($stringSql)
          or die("ERROR IN script_lab_peso - FUNCTION inizializzaLabPesoMatPriKeVaria - " .$stringSql." - ".  mysql_error());
        return $sql;
}


/**
 * * La tabella viene inizializzata: 
 * peso <- quantita registrate nella prova di origine calcolate in base alla nuova quantita totale di miscela; 
 * qta_teo <- quantita teorica percentuale definita nella formula
 * qta <- quantita percentuale reale usata nella prova di origine  
 * la tabella viene aggiornata con le quantita pesate durante la procedura di pesa 
 * eseguita nella pagina carica_lab_peso
 * @param type $qtaTotMiscela
 * @param type $codiceBarre
 * @param type $idEsperimento
 * @param type $pesoMiscela
 * @param type $idLabMacchina
 * @param type $codLabFormula
 * @param type $tipo
 * @return type
 */
function inizializzaLabPesoCompKeVaria( $qtaTotMiscela, $codiceBarre, $idEsperimento,
        $pesoMiscela,$idLabMacchina,$codLabFormula,$tipo,$tipoEsperimento,$idUtente,$idAzienda ){

$stringSql="INSERT INTO lab_peso (id,codice,peso,cod_barre,id_lab_macchina,
                              descri,uni_mis,qta_teo,qta,cod_lab_formula,tipo,qta_miscela,prezzo,tipo_esperimento,id_utente,id_azienda) 
                SELECT
                                r.id_mat,
                                m.cod_mat,
                                TRUNCATE((r.qta_reale*" . $pesoMiscela . ")/" . $qtaTotMiscela . ",4),
                                '" . $codiceBarre . "',
                                ".$idLabMacchina.",
                                m.descri_materia,
                                m.unita_misura,
                                mt.qta_teo_perc,
                                TRUNCATE((r.qta_reale*100)/".$qtaTotMiscela.",4),
                                mt.cod_lab_formula,
                                '" . $tipo . "',".$pesoMiscela.",prezzo,
                                     '" . $tipoEsperimento . "',
                                        " . $idUtente . ",
                                            " . $idAzienda . "
                FROM
                                lab_risultato_matpri r
                INNER JOIN 
                                lab_materie_prime m ON m.id_mat = r.id_mat
                INNER JOIN 
                                lab_matpri_teoria mt ON m.id_mat = mt.id_mat
                WHERE 
                                m.cod_mat LIKE 'comp%'
                           AND
                                r.id_esperimento=" . $idEsperimento."
                           AND 
                                mt.cod_lab_formula='".$codLabFormula."'
                 GROUP BY  m.id_mat
                 ORDER BY m.id_mat  ";
        $sql=mysql_query($stringSql)
          or die("ERROR IN script_lab_peso - FUNCTION inizializzaLabPesoCompKeVaria - " .$stringSql." - ".  mysql_error());
        return $sql;
}

/**
 * Inizializzazione pesa dell'acqua da eseguire negli esperimenti successivi al primo
 * La tabella viene inizializzata: 
 * peso <- quantita registrate nella prova di origine calcolate in base alla nuova quantita totale di miscela; 
 * qta_teo <- quantita teorica percentuale definita nella formula
 * qta <- quantita percentuale reale usata nella prova di origine  
 * la tabella viene aggiornata con le quantita pesate durante la procedura di pesa 
 * eseguita nella pagina carica_lab_peso
 * @param type $qtaTotMiscela
 * @param type $codiceBarre
 * @param type $idEsperimento
 * @param type $idLabMacchina
 * @param type $pesoMiscela
 * @param type $codLabFormula
 * @param type $tipoPar
 * @return type
 */
function inizializzaLabPesoPar($qtaTotMiscela, $codiceBarre, $idEsperimento,
        $idLabMacchina,$pesoMiscela,$codLabFormula,$tipoPar,$tipoEsperimento,$idUtente,$idAzienda ){
    
  
    $stringSql="INSERT INTO lab_peso (id,codice,peso,cod_barre,id_lab_macchina,
      descri,qta_teo,qta,cod_lab_formula,tipo,uni_mis,tipo_esperimento,id_utente,id_azienda,qta_miscela,prezzo) 
                SELECT
                                r.id_par,
                                p.nome_parametro,
                                TRUNCATE((r.valore_reale*" . $pesoMiscela . ")/" . $qtaTotMiscela . ",4),
                                '" . $codiceBarre . "',
                                ".$idLabMacchina.",
                                p.descri_parametro,
                                pt.valore_teo,
                                TRUNCATE((r.valore_reale*100)/".$qtaTotMiscela.",4),
                                pt.cod_lab_formula,
                                '".$tipoPar."',
                                p.unita_misura,
                                '".$tipoEsperimento."',
                                    ".$idUtente.",
                                        ".$idAzienda.",
                                            " . $pesoMiscela . ",0
                FROM
                                lab_risultato_par r
                INNER JOIN 
                                lab_parametro p ON p.id_par = r.id_par
                INNER JOIN 
                                lab_parametro_teoria pt ON p.id_par = pt.id_par
                WHERE 
                                r.id_esperimento=" . $idEsperimento . "
                        AND 
                                pt.cod_lab_formula='".$codLabFormula."'
                        AND 
                                (p.tipo LIKE '%" . $tipoPar . "%')";
         $sql=mysql_query($stringSql)
          or die("ERROR IN script_lab_peso - FUNCTION inizializzaLabPesoPercSI - " .$stringSql." - ".  mysql_error());
        return $sql;

}

/**
 * Inizializzazione pesa dell'acqua da eseguire negli esperimenti successivi al primo
 * La tabella viene inizializzata: 
 * peso <- quantita registrate nella prova di origine calcolate in base alla nuova quantita totale di miscela; 
 * qta_teo <- quantita teorica percentuale definita nella formula
 * qta <- valore reale usato nella prova di origine  
 * la tabella viene aggiornata con le quantita pesate durante la procedura di pesa 
 * eseguita nella pagina carica_lab_peso
 * @param type $qtaTotMiscela
 * @param type $codiceBarre
 * @param type $idEsperimento
 * @param type $idLabMacchina
 * @param type $pesoMiscela
 * @param type $codLabFormula
 * @param type $tipoPar
 * @return type
 */
function inizializzaLabPesoParPercNO($qtaTotMiscela, $codiceBarre, $idEsperimento,
        $idLabMacchina,$pesoMiscela,$codLabFormula,$tipoPar,$tipoEsperimento,$idUtente,$idAzienda ){
  
  $stringSql="INSERT INTO lab_peso (id,codice,peso,cod_barre,id_lab_macchina,
      descri,qta_teo,qta,cod_lab_formula,tipo,uni_mis,tipo_esperimento,id_utente,id_azienda,qta_miscela,prezzo) 
                SELECT
                                r.id_par,
                                p.nome_parametro,
                                TRUNCATE((r.valore_reale*" . $pesoMiscela . ")/" . $qtaTotMiscela . ",4),
                                '" . $codiceBarre . "',
                                ".$idLabMacchina.",
                                p.descri_parametro,
                                pt.valore_teo,
                                r.valore_reale,
                                pt.cod_lab_formula,
                                '".$tipoPar."',
                                p.unita_misura,
                                 '".$tipoEsperimento."',
                                    ".$idUtente.",
                                        ".$idAzienda.",
                                            " . $pesoMiscela . ",0
                                
                FROM
                                lab_risultato_par r
                INNER JOIN 
                                lab_parametro p ON p.id_par = r.id_par
                INNER JOIN 
                                lab_parametro_teoria pt ON p.id_par = pt.id_par
                WHERE 
                                r.id_esperimento=" . $idEsperimento . "
                        AND 
                                pt.cod_lab_formula='".$codLabFormula."'
                        AND 
                                (p.tipo LIKE '%" . $tipoPar . "%' )";
         $sql=mysql_query($stringSql)
          or die("ERROR IN script_lab_peso - FUNCTION inizializzaLabPesoPercSI - " .$stringSql." - ".  mysql_error());
        return $sql;

}

/**
 * Seleziona le materie prime di una data formula ed il loro peso dalla tabella lab_peso
 * @param type $codiceFormula
 * @param type $idLabMacchina
 * @param type $tipo
 */
function findPeso($codiceFormula,$idLabMacchina,$tipo){
$stringSql = "SELECT
                   *
                    FROM                           
                            serverdb.lab_peso 
                    WHERE 
                            cod_lab_formula='" . $codiceFormula . "'
                            AND
                            tipo ='".$tipo."'
                      AND 
                      id_lab_macchina=" . $idLabMacchina . "
                    GROUP BY id
                    ORDER BY descri";
$sql = mysql_query($stringSql) 
            or die("ERROR IN script_lab_matpri_teoria - FUNCTION findPeso - " .$stringSql." - ". mysql_error());
return $sql;

}

/**
 * Aggiorno il peso della materia prima nella  tabella [lab_peso] 
 * con il valore letto dalla tabella [lab_bilancia]
 * @param type $codice materiale da pesare
 * @param type $idLabMacchina
 * @param type $peso
 */
function aggiornaPeso($codice,$idLabMacchina,$peso){
$stringSql = "UPDATE serverdb.lab_peso 
                SET peso=peso+".$peso." 
               WHERE 
                codice='".$codice."' 
                AND 
                id_lab_macchina= ".$idLabMacchina;
$sql = mysql_query($stringSql) 
            or die("ERROR IN script_lab_matpri_teoria - FUNCTION aggiornaPeso - " .$stringSql." - ". mysql_error());
return $sql;

}



function inizializzaLabPesoAccessori($idLabMacchina,$codLabFormula,$codBarre,$tipo,$qtaMiscela,$tipoEsperimento,$idUtente,$idAzienda,$strUtentiAziendeAccessori){
   $stringSql=" INSERT INTO serverdb.lab_peso (id,codice,descri,peso,cod_barre,id_lab_macchina,
       qta_teo,qta,cod_lab_formula,tipo,uni_mis,qta_miscela,tipo_esperimento,id_utente,id_azienda,prezzo)
      SELECT 
        0,codice,descri,0,'".$codBarre."',
        ".$idLabMacchina.",0,0,'".$codLabFormula."','".$tipo."',"
        . "uni_mis,".$qtaMiscela.",'".$tipoEsperimento."',".$idUtente.",".$idAzienda.",pre_acq "
        . "FROM serverdb.accessorio WHERE (id_utente,id_azienda) IN ".  $strUtentiAziendeAccessori;
    
    $sql = mysql_query($stringSql) or die("ERROR IN script_lab_peso - FUNCTION inizializzaLabPesoAccessori - " .$stringSql." - ". mysql_error());
return $sql;
}





?>
