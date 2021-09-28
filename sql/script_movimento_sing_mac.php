<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function insertNewMovimentoSingMac($idMovOri,$idComponente, $tipoMat,$quantita, $codIngressoComp,$operatore,$operazione, $proceduraAdottata,$tipoMov,
        $descriMov,$dataMov, $silo, $tipoConf,$pesoConf, $numeroConf, $respProduzione, $respQualita, $consTecnico,$note,
        $merceConforme,$stabilitaConforme, $marchioCeConforme,$codiceCE, $fornitore, $dtAbilitato,$idMacchina,$pesoTeorico,$idCiclo,$dtInizioProcedura,
        $dtFineProcedura,$abilitato,$origineMov,$numDoc,$dtDoc,$codiceIntegrazione,$dataArrivoMerce) {

    $stringSql = "INSERT INTO serverdb.movimento_sing_mac (
        id_mov_ori,
        id_materiale,
        tipo_materiale,
        quantita,
        cod_ingresso_comp,
        cod_operatore,
        operazione,
        procedura_adottata,
        tipo_mov,
        descri_mov,
        dt_mov,
        silo,
        tipo_confezione,
        peso_confezione,
        numero_confezioni,
        responsabile_produzione,
        responsabile_qualita,
        consulente_tecnico,
        note,
        merce_conforme,
        stabilita_conforme,
        marchio_ce_conforme,
        codice_ce,
        fornitore,
        dt_abilitato,
        id_macchina,
        peso_teorico,
        id_ciclo,
        dt_inizio_procedura,
        dt_fine_procedura,
        abilitato,
        origine_mov,
        num_doc,
        dt_doc,
        info1,
        info2) 
  VALUES (
       " . $idMovOri . ",
       " . $idComponente . ",
       '". $tipoMat . "',
       " . $quantita . ",
       '" . $codIngressoComp . "',
       '" . $operatore . "',
       '" . $operazione . "',
       '" . $proceduraAdottata . "',
       '" . $tipoMov . "', 
       '" . $descriMov . "',
       '" . $dataMov . "',
       '" . $silo . "',
       '" . $tipoConf . "',
       '" . $pesoConf . "',
       '" . $numeroConf . "',
       '" . $respProduzione . "',
       '" . $respQualita . "',
       '" . $consTecnico . "',
       '" . $note . "',
       '" . $merceConforme . "',
       '" . $stabilitaConforme . "',
       '" . $marchioCeConforme . "',
       '" . $codiceCE . "',
       '" . $fornitore . "',
       '" . $dtAbilitato . "',
       " . $idMacchina . ", 
       " . $pesoTeorico . ", 
       " . $idCiclo . ", 
       '" . $dtInizioProcedura . "',
       '" . $dtFineProcedura. "',
        " . $abilitato . ",
       '" . $origineMov . "',"
            . "'" . $numDoc . "',"
            . "'" . $dtDoc . "',"
            . "'" . $codiceIntegrazione . "',"
            . "'" . $dataArrivoMerce . "')";

    $sql = mysql_query($stringSql) ;
            //or die("ERROR IN script_movimento_sing_mac.php - FUNCTION insertNewMovimentoSingMac - " .$stringSql. " -  ".mysql_error());
    return $sql;
}




function selectMovimentoSingMacOriByFiltri($campoOrdine, $campoGroupBy,$idMacchina,$idMovIn, $codiceMat,$descriMateriale, $tipoMateriale, $quantita, $pesoTeorico, $codIngressoComp, $numDoc,$dtDoc,$tipoMov, $descriMov, $dtMov) {

     $stringSql="SELECT * FROM serverdb.movimento_sing_mac m JOIN serverdb.componente c ON m.id_materiale=c.id_comp
         WHERE 
            id_mov_inephos LIKE '%" . $idMovIn . "%'
         AND
            cod_componente LIKE '%" . $codiceMat . "%'
         AND   
            descri_componente LIKE '%" . $descriMateriale . "%'
         AND 
            tipo_materiale LIKE '%" . $tipoMateriale . "%'
         AND
            quantita LIKE '%" . $quantita . "%'
         AND 
            peso_teorico LIKE '%" . $pesoTeorico . "%'
         AND 
            cod_ingresso_comp LIKE '%" . $codIngressoComp . "%'
         AND 
            (num_doc LIKE '%" . $numDoc . "%' OR num_doc IS NULL)
         AND 
            (dt_doc LIKE '%" . $dtDoc . "%' OR dt_doc IS NULL)        
         AND 
            tipo_mov LIKE '%" . $tipoMov . "%'
         AND 
            descri_mov LIKE '%" . $descriMov . "%'
         AND 
            dt_mov LIKE '%" . $dtMov . "%'
         
         AND 
            id_macchina=".$idMacchina."
         AND
             m.abilitato=1
         GROUP BY " . $campoGroupBy . "       
         ORDER BY " . $campoOrdine;
            
             $sql = mysql_query($stringSql) or die("ERROR IN script_movimento_sing_mac - FUNCTION selectMovimentoSingMacOriByFiltri -  " .$stringSql.  mysql_error());

    return $sql;
}


function findMovimentoByCodice($codiceIngressoComp) {

    $sqlString = "SELECT * FROM serverdb.movimento_sing_mac WHERE cod_ingresso_comp = '" . $codiceIngressoComp . "'";

    $sql = mysql_query($sqlString) or die("ERROR IN script_movimento_sing_mac.php - FUNCION findMovimentoByCodice - " . $sqlString . " " . mysql_error());

    return $sql;
}



function findCicliByMacCodCompPeso($idMacchina,$codIngressoComp) {
    $stringSql = "SELECT * FROM 
                            serverdb.movimento_sing_mac                          
                        WHERE 
                            cod_ingresso_comp='".$codIngressoComp."'
                        AND
                            id_macchina=".$idMacchina."
                        AND id_ciclo IN (SELECT id_ciclo FROM serverdb.ciclo_processo WHERE id_macchina=".$idMacchina.")        
                        ORDER BY id_ciclo";
                            
    $sql = mysql_query($stringSql) or die ("ERROR IN script_movimento_sing_mac.php - FUNCTION findCicliByMacCodCompPeso - " . $stringSql . " : " . mysql_error());
    
    return $sql;
}



function findMovimentoByIdCiclo($idCiclo,$idMacchina,$idMateriale) {

    $sqlString = "SELECT * FROM serverdb.movimento_sing_mac "
                    . "WHERE id_ciclo = '" . $idCiclo . "'
                       AND
                            id_macchina=".$idMacchina." "
                    . "AND  id_materiale=".$idMateriale ;

    $sql = mysql_query($sqlString) 
            or die("ERROR IN script_movimento_sing_mac.php - FUNCION findMovimentoByIdCiclo - " . $sqlString . " " . mysql_error());

    return $sql;
}




function findMateriePrimeConsumateMacchina($idMacchina,$dataInf,$dataSup,$tipoMov,$campoGroupBy,$campoOrderBy) {

   $sqlString = "SELECT id_materiale,descri_componente,id_ciclo
        FROM serverdb.movimento_sing_mac m 
        JOIN serverdb.componente co ON m.id_materiale=co.id_comp
        WHERE id_macchina=".$idMacchina."  AND tipo_mov='".$tipoMov."' 
        AND (substring(dt_mov,1,10)>='".$dataInf."' AND substring(dt_mov,1,10)<='".$dataSup."') GROUP BY ".$campoGroupBy . " ORDER BY ".$campoOrderBy;

    $sql = mysql_query($sqlString) 
            or die("ERROR IN script_movimento_sing_mac.php - FUNCION findConsumiMacchina - " . $sqlString . " " . mysql_error());

    return $sql;
}



function findConsumoMateriePrime($idMacchina,$idProdotto,$idMateriale,$dataInf,$dataSup,$tipoMov) {

   $sqlString = "SELECT cod_ingresso_comp, nome_prodotto, SUM(quantita) AS quantitaTot ,m.id_ciclo 
        FROM serverdb.movimento_sing_mac m 
            JOIN serverdb.ciclo c ON c.id_ciclo=m.id_ciclo 
            JOIN serverdb.prodotto p ON p.id_prodotto=c.id_prodotto
            JOIN serverdb.componente co ON m.id_materiale=co.id_comp
            WHERE c.id_macchina=m.id_macchina AND c.id_macchina=".$idMacchina."  AND tipo_mov='".$tipoMov."' "
            . "AND c.id_prodotto=".$idProdotto." AND m.id_materiale=".$idMateriale."
            
             AND (substring(dt_mov,1,10)>='".$dataInf."' AND substring(dt_mov,1,10)<='".$dataSup."')"
            . " GROUP BY p.id_prodotto"  ;

    $sql = mysql_query($sqlString) 
            or die("ERROR IN script_movimento_sing_mac.php - FUNCION findConsumoMateriePrime - " . $sqlString . " " . mysql_error());

    return $sql;
}


function findProdottiInCicli($idMacchina,$dataInf,$dataSup,$tipoMov,$campoGroupBy,$campoOrderBy) {

  $sqlString = "SELECT p.id_prodotto, nome_prodotto,c.dt_abilitato,c.id_ciclo,velocita_mix,tempo_mix
        FROM serverdb.movimento_sing_mac m 
        JOIN serverdb.ciclo c ON c.id_ciclo=m.id_ciclo 
        JOIN serverdb.prodotto p ON p.id_prodotto=c.id_prodotto
        WHERE c.id_macchina=m.id_macchina 
        AND c.id_macchina=".$idMacchina."  AND tipo_mov='".$tipoMov."'                       
             AND (substring(dt_mov,1,10)>='".$dataInf."' AND substring(dt_mov,1,10)<='".$dataSup."') GROUP BY ".$campoGroupBy . " ORDER BY ".$campoOrderBy;

    $sql = mysql_query($sqlString) 
            or die("ERROR IN script_movimento_sing_mac.php - FUNCION findProdottiInCicli - " . $sqlString . " " . mysql_error());

    return $sql;
}



function findTotMateriePrimeInCiclo($idMacchina,$idProdotto,$idCiclo,$tipoMov) {

    $sqlString = "SELECT m.quantita 
                    FROM serverdb.movimento_sing_mac m 
                    JOIN serverdb.ciclo c ON c.id_ciclo=m.id_ciclo 
                   WHERE c.id_macchina=m.id_macchina AND c.id_macchina=".$idMacchina."  
                        AND tipo_mov='".$tipoMov."'
                        AND c.id_prodotto=".$idProdotto."
                        AND c.id_ciclo=".$idCiclo;       
    $sql = mysql_query($sqlString) 
            or die("ERROR IN script_movimento_sing_mac.php - FUNCION findTotMateriePrimeInCiclo - " . $sqlString . " " . mysql_error());

    return $sql;
}


function findConsumoMateriaPrimaInCiclo($idMacchina,$idMateriale,$idProdotto,$idCiclo,$tipoMov) {

    $sqlString = "SELECT cod_ingresso_comp, quantita
                    FROM serverdb.movimento_sing_mac m 
                    JOIN serverdb.ciclo c ON c.id_ciclo=m.id_ciclo 
                  WHERE c.id_macchina=m.id_macchina 
                    AND c.id_macchina=".$idMacchina."  
                    AND tipo_mov='".$tipoMov."'
                    AND id_materiale=".$idMateriale."
                    AND c.id_prodotto=".$idProdotto."
                    AND c.id_ciclo=".$idCiclo;       

    $sql = mysql_query($sqlString) 
            or die("ERROR IN script_movimento_sing_mac.php - FUNCION findMateriePrimeInCiclo - " . $sqlString . " " . mysql_error());

    return $sql;
}




function findLastIdMovIn() {

    $sqlString = "SELECT MAX(id_mov_inephos) AS last_id FROM serverdb.movimento_sing_mac";
                        

    $sql = mysql_query($sqlString) 
            or die("ERROR IN script_movimento_sing_mac.php - FUNCION findLastIdMovIn - " . $sqlString . " " . mysql_error());

    return $sql;
}

function findMovimentoByIdMovInephos($idMovInephos) {

    $sqlString = "SELECT * FROM serverdb.movimento_sing_mac cc"
            . " JOIN serverdb.macchina m ON cc.id_macchina=m.id_macchina
                    JOIN serverdb.componente c ON c.id_comp=cc.id_materiale "
                    . "WHERE id_mov_inephos = " . $idMovInephos ;

    $sql = mysql_query($sqlString) 
            or die("ERROR IN script_movimento_sing_mac.php - FUNCION findMovimentoByIdMovInephos - " . $sqlString . " " . mysql_error());

    return $sql;
}


function findMovimentoByIdCicloIdMacchina($idCiclo,$idMacchina) {

    $sqlString = "SELECT * FROM serverdb.movimento_sing_mac "
                    . "WHERE id_ciclo = '" . $idCiclo . "'
                       AND
                            id_macchina=".$idMacchina ;

    $sql = mysql_query($sqlString) 
            or die("ERROR IN script_movimento_sing_mac.php - FUNCION findMovimentoByIdCicloIdMacchina - " . $sqlString . " " . mysql_error());

    return $sql;
}


function findMovimentoByCodMovTipo($codMov,$tipoMov) {

    $sqlString = "SELECT * FROM serverdb.movimento_sing_mac WHERE cod_ingresso_comp = '".$codMov."' AND tipo_mov='".$tipoMov."'";

    $sql = mysql_query($sqlString) 
            
            or die("ERROR IN script_movimento_sing_mac.php - FUNCION findMovimentoByCodMovTipo - " . $sqlString . " " . mysql_error());

    return $sql;
}


function findMovimentoByCodMovProcAdot($codMov,$proceduraAdottata) {

    $sqlString = "SELECT * FROM serverdb.movimento_sing_mac WHERE cod_ingresso_comp = '".$codMov."' AND procedura_adottata='".$proceduraAdottata."'";

    $sql = mysql_query($sqlString) 
            
            or die("ERROR IN script_movimento_sing_mac.php - FUNCION findMovimentoByCodMovProcAdot - " . $sqlString . " " . mysql_error());

    return $sql;
}

