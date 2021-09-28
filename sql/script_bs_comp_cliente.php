<?php

function eliminaCompBsCliente($idCliente) {

    $stringSql = "DELETE FROM 
                            serverdb.bs_comp_cliente 
                        WHERE                             
                            id_cliente=" . $idCliente;
    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_componenti - FUNCTION eliminaCompBsCliente - " . $stringSql . " : " . mysql_error());
    return $sql;
}

function findCompBsCliente($campoOrdine, $strUtentiAziende, $anno) {

    $stringSql = "SELECT * 
                        FROM 
                            serverdb.bs_comp_cliente b JOIN serverdb.componente c
                            ON b.id_comp=c.id_comp
                        WHERE 
                            b.anno=" . $anno . " 
                        AND
                            (c.id_utente,c.id_azienda )IN " . $strUtentiAziende . "                       
                        ORDER BY 
                            " . $campoOrdine;
    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_componenti - FUNCTION findCompBsCliente - " . $stringSql . " : " . mysql_error());
    return $sql;
}

function findCompBsByCliente($campoOrdine, $idCliente) {

    $stringSql = "SELECT * 
                        FROM 
                            serverdb.bs_comp_cliente b JOIN serverdb.componente c
                            ON b.id_comp=c.id_comp
                        WHERE 
                            b.id_cliente=" . $idCliente . " 
                                                   
                        ORDER BY 
                            " . $campoOrdine;
    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_componenti - FUNCTION findCompBsByCliente - " . $stringSql . " : " . mysql_error());
    return $sql;
}

function selectBSCompClienteByIdProdotto($idCliente, $idProdotto,$idLingua,$valAbilitato) {
    $stringSql = "SELECT * FROM 
                                    serverdb.componente_prodotto cp
                                JOIN  serverdb.bs_comp_cliente c ON
                                    cp.id_comp=c.id_comp
                                JOIN serverdb.dizionario d    
                                WHERE
                                    d.id_diz_tipo=4
                                AND 
                                    d.id_vocabolo=c.id_comp
                                AND 
                                    d.id_lingua=".$idLingua."
                                AND       
                                    id_cliente=" . $idCliente . "                                        
                                AND
                                    cp.id_prodotto=" . $idProdotto." 
                                AND 
                                  cp.abilitato=".$valAbilitato;

    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_comp_cliente - FUNCTION selectBSCompClienteByIdProdotto " . mysql_error());

    return $sql;
}

function inserisciPreAcqCompCliente($idComp, $idCliente, $preAcq, $anno) {
    $stringSql = "INSERT INTO serverdb.bs_comp_cliente
       (id_comp,id_cliente,pre_acq,anno)
                        VALUES (" . $idComp . ",
                            '" . $idCliente . "',
                                " . $preAcq . ",
                                    " . $anno . ")";
    $sql = mysql_query($stringSql) ;
            //or die("ERROR IN script_bs_comp_cliente - FUNCTION inserisciPreAcqCompCliente - " . $stringSql . " : " . mysql_error());


    return $sql;
}

//function findCompClienteUnionNewComp($campoOrdine, $idCliente,$strUtentiAziendeVis) {
//     $stringSql = "SELECT id_comp,cod_componente,descri_componente,pre_acq FROM  
//(SELECT c.id_comp AS id_comp,cod_componente,descri_componente,b.pre_acq AS pre_acq 
//FROM serverdb.bs_comp_cliente b JOIN serverdb.componente c ON b.id_comp=c.id_comp
//WHERE b.id_cliente=" . $idCliente . "
// UNION ALL                              
//SELECT c.id_comp AS id_comp,cod_componente,descri_componente,m.pre_acq AS pre_Acq FROM serverdb.componente c 
//JOIN serverdb.materia_prima m ON c.cod_componente=m.cod_mat
//JOIN serverdb.componente_prodotto cp ON cp.id_comp=c.id_comp
//JOIN serverdb.bs_prodotto b ON b.id_prodotto=cp.id_prodotto
//WHERE cod_componente<>'chimica'
//AND
//(c.id_utente,c.id_azienda )IN " . $strUtentiAziendeVis . ") derivedTable
//GROUP BY ".$campoOrdine;
//
//    $sql = mysql_query($stringSql) or die("ERROR IN script_componente - FUNCTION findComponentiEPrezzo - " . $stringSql . " : " . mysql_error());
//
//
//    return $sql;
//}


function findCompClienteUnionNewComp($campoOrdine, $idCliente,$strUtentiAziendeVis,$idLingua,$abilitato) {
     $stringSql = "SELECT id_comp,cod_componente,vocabolo AS descri_componente,pre_acq FROM  
(SELECT c.id_comp AS id_comp,cod_componente,descri_componente,b.pre_acq AS pre_acq 
FROM serverdb.bs_comp_cliente b JOIN serverdb.componente c ON b.id_comp=c.id_comp
WHERE b.id_cliente=" . $idCliente . "
 UNION ALL                              
SELECT c.id_comp AS id_comp,cod_componente,descri_componente,l.prezzo_bs AS pre_acq FROM serverdb.componente c 
JOIN serverdb.lab_materie_prime l ON c.cod_componente=l.cod_mat
JOIN serverdb.componente_prodotto cp ON cp.id_comp=c.id_comp
JOIN serverdb.bs_prodotto b ON b.id_prodotto=cp.id_prodotto
WHERE cod_componente<>'chimica'
AND cp.abilitato=".$abilitato."
AND
(c.id_utente,c.id_azienda )IN " . $strUtentiAziendeVis . ") derivedTable
JOIN serverdb.dizionario d ON id_comp=d.id_vocabolo 
WHERE id_diz_tipo=4 AND id_lingua=".$idLingua."
GROUP BY ".$campoOrdine;

    $sql = mysql_query($stringSql) or die("ERROR IN script_componente - FUNCTION findComponentiEPrezzo - " . $stringSql . " : " . mysql_error());


    return $sql;
}

?>
