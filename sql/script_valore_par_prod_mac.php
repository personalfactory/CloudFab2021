<?php

function insertValoriProdottoMacchina($idParPm,$idProdotto,$idMacchina,$valore) {
    
    $stringSql = "INSERT INTO serverdb.valore_par_prod_mac 
                    (id_par_pm,
                    id_prodotto,
                    id_macchina,
                    valore_variabile,
                    abilitato,
                    dt_abilitato) 
           VALUES (".$idParPm.",
                    " . $idProdotto . ",
                    " . $idMacchina . ",
                    '".$valore."',
                    1,
                    NOW())";

    $sql = mysql_query($stringSql);
    //or die("ERROR IN script_valore_par_prod_mac.php - FUNCTION insertValoriProdottoMacchina - ".$stringSql ." ". mysql_error());
    return $sql;
}


function insertIfNotExistValParProdMac($idProdotto, $idParPm, $valoreVariabile, $idMacchina, $dtAbilitato) {
  $sqlString = "INSERT INTO serverdb.valore_par_prod_mac (id_prodotto,
                                             id_par_pm,
                                             valore_variabile,
                                             id_macchina,
                                             abilitato,
                                             dt_abilitato)
SELECT " . $idProdotto . "," . $idParPm . ",'" . $valoreVariabile . "'," . $idMacchina . ",'1', '" . $dtAbilitato . "' FROM DUAL
WHERE NOT EXISTS (SELECT * FROM serverdb.valore_par_prod_mac WHERE
id_prodotto=" . $idProdotto . " AND
id_par_pm=" . $idParPm . " AND 
id_macchina=" . $idMacchina . ")";

    $sql = mysql_query($sqlString)
            or die("ERROR IN script_valore_par_prod_mac - FUNCTION insertIfNotExistValParProdMac - " . $sqlString . " " . mysql_error());
    return $sql;
}


function selectMacchineFromValParProdMac($campoOrdine,$campoGroupBy,$idProdotto) {
    
    $stringSql = "SELECT * FROM serverdb.valore_par_prod_mac WHERE id_prodotto=".$idProdotto." GROUP BY id_macchina ORDER BY id_macchina";

    $sql = mysql_query($stringSql);
    //or die("ERROR IN script_valore_par_prod_mac.php - FUNCTION selectMacchineFromValParProdMac - ".$stringSql ." ". mysql_error());
    return $sql;
}

function selectProdottiFromValParProdMac($campoOrdine,$campoGroupBy,$idMacchina) {
    
    $stringSql = "SELECT * FROM serverdb.valore_par_prod_mac WHERE id_macchina=".$idMacchina." GROUP BY ".$campoGroupBy." ORDER BY ".$campoOrdine ;

    $sql = mysql_query($stringSql);
    //or die("ERROR IN script_valore_par_prod_mac.php - FUNCTION selectProdottiFromValParProdMac - ".$stringSql ." ". mysql_error());
    return $sql;
}

/**
 * Aggiunge un nuovo parametro nella tabella valore_par_prod_mac, 
 * per tutte le macchine ed i prodotti già presenti nella tabella.
 * @param type $idParametro
 * @param type $valoreBase
 * @param type $dataCorrente
 * @return type
 */
function insertNewValoreParxProdxMac($idParametro, $valoreBase, $dataCorrente){
	$sqlString= "INSERT INTO serverdb.valore_par_prod_mac 
                    (id_prodotto,id_par_pm,valore_variabile,id_macchina,abilitato,dt_abilitato) 
                    SELECT  
                            id_prodotto,
                            ".$idParametro.",    
                            '" . $valoreBase . "',
                            id_macchina,
                            1,
                            '" . $dataCorrente . "'
                    FROM 
                            serverdb.valore_par_prod_mac
                            
                    GROUP BY id_macchina,id_prodotto
                    ORDER BY id_macchina,id_prodotto";

	$sql = mysql_query($sqlString);
//	or die("ERROR IN script_valore_par_prod_comp - FUNCTION insertNewValoreParxProdxMac - ".$sqlString ." ". mysql_error());
	return $sql;
}

function findValoreParProdByIdMacchina($idMacchina,$filtro,
                      $idValParPm,
                      $idParPm,
                      $nomeVariabile,
                      $nomeProdotto,
                      $valoreVariabile,
                      $dtAbilitato,
                      $strUtentiAziende){
    $stringSql= "SELECT *,v.dt_abilitato AS dt_abilitato FROM
                            serverdb.valore_par_prod_mac v
                        INNER JOIN serverdb.macchina m
                        ON 
                            v.id_macchina = m.id_macchina
                        INNER JOIN serverdb.parametro_prod_mac p
                        ON 
                            v.id_par_pm = p.id_par_pm
                        INNER JOIN serverdb.prodotto pr 
                        ON 
                            v.id_prodotto = pr.id_prodotto                                            
                        WHERE 
                            v.id_macchina=" . $idMacchina . "
                        AND 
                            id_val_pm LIKE '%".$idValParPm."%'
                        AND 
                            p.id_par_pm LIKE '%".$idParPm."%'
                        AND 
                            nome_variabile LIKE '%".$nomeVariabile."%'
                        AND 
                            nome_prodotto LIKE '%".$nomeProdotto."%'
                        AND 
                            valore_variabile LIKE '%".$valoreVariabile."%'
                        AND 
                            v.dt_abilitato LIKE '%".$dtAbilitato."%'
                        AND         
                            (pr.id_utente,pr.id_azienda) IN ".$strUtentiAziende."                         
                        ORDER BY
                            ".$filtro; 
           $sql=  mysql_query($stringSql) 
                   or die("ERROR IN script_valore_par_prod.php - FUNCTION findValoreParProdByIdMacchina - " .$stringSql." - ". mysql_error());
   return $sql;
}



//##############################################################################
//################### STORICO ##################################################
//##############################################################################

function insertIntoValParProdMac($idValPm,
                                      $idProdotto,
                                      $idParPr,
                                      $idMacchina,
                                      $valoreVariabile,
                                      $abilitato,
                                      $dtAbilitato){
 
    $stringSql="INSERT INTO storico.valore_par_prod_mac	(
                        id_val_pm,
                        id_prodotto,
                        id_par_pm,
                        id_macchina,
                        valore_variabile,
                        abilitato,
                        dt_abilitato) 
                VALUES (
                      " . $idValPm . ",
                      " . $idProdotto. ",
                      " . $idParPr . ",
                      " . $idMacchina . ",
                     '" . $valoreVariabile . "',
                      ".$abilitato.",
                     '".$dtAbilitato."')";
$sql = mysql_query($stringSql);  
//       or die("ERROR IN script_valore_par_prod_mac - FUNCTION  insertIntoValParProdMac - INSERT INTO  storico.valore_par_prod_mac : " .$stringSql." - ". mysql_error());
 
return $sql;

}

function updateValoreParProdMac($valore,$dataCorrente,$idParPm,$idProdotto,$idMacchina){
 $stringSql="UPDATE serverdb.valore_par_prod_mac"
         . " SET dt_abilitato=if(valore_variabile != '" . $valore . "','" . $dataCorrente . "',dt_abilitato),
                 valore_variabile=if(valore_variabile != '" . $valore . "','" . $valore . "',valore_variabile)
				WHERE
                                    id_par_pm=" . $idParPm . "
                                AND 
                                    id_prodotto=" . $idProdotto . "
                                AND
                                    id_macchina=" . $idMacchina;
    
$sql=mysql_query($stringSql);
//or die("ERRROR IN  4 UPDATE serverdb.valore_par_prod_mac : " . mysql_error());
return $sql;
}