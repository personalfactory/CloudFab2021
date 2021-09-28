<?php


//$sql = mysql_query("SELECT
//                            COUNT(DISTINCT(cod_chimica)) AS chim_usate,
//                            processo.id_macchina,                            
//                            processo.cod_stab,
//                            macchina.descri_stab,
//                            macchina.ragso1,
//                            macchina.dt_abilitato,
//                            MAX(processo.dt_produzione_mac) AS dt_produzione_mac,
//                            COUNT(*) AS processi_tot
//                        FROM
//                            processo 
//                        INNER JOIN
//                            macchina
//                        ON 
//                            processo.cod_stab=macchina.cod_stab
//                        WHERE
//                            macchina.abilitato=1
//                        GROUP BY  
//                            processo.cod_stab
//                            ORDER BY dt_produzione_mac DESC
//                        ") 
//    or die("Query fallita: " . mysql_error());

/**
 * Calcola la data di ultima produzione ed i processi totali di ogni stab
 * @param type $campoGroupBy
 * @return type
 */
function selectProdOrigamiByFiltri($campoOrdine, $campoGroupBy,$strUtentiAziende){    
    
    $stringSql="SELECT
                            COUNT(DISTINCT(cod_chimica)) AS chim_usate,
                            m.id_macchina,                            
                            m.cod_stab,
                            m.descri_stab,
                            m.dt_abilitato,
                            MAX(p.dt_produzione_mac) AS dt_produzione_mac,
                            COUNT(*) AS processi_tot
                        FROM
                            serverdb.macchina m
                        LEFT JOIN
                            serverdb.processo p
                        ON 
                            p.id_macchina=m.id_macchina
                        WHERE
                            m.abilitato=1
                         AND
                            (m.id_utente,m.id_azienda) IN ".$strUtentiAziende."
                        GROUP BY " . $campoGroupBy . "
                        ORDER BY " . $campoOrdine ;      
         
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_processo - FUNCTION selectProdOrigamiByFiltri - ". $stringSql." - ". mysql_error());

    return $sql;
    
    
}

/**
 * Seleziona i processi da visualizzare nello script gestione_processo.php
 * @param type $idMacchina
 * @param type $idProcesso
 * @param type $codProdotto
 * @param type $codChimica
 * @param type $codSacco
 * @param type $cliente
 * @param type $dataProd
 * @param type $nomeProdotto
 * @param type $pesoRealeSacco
 * @param type $filtro
 * @return type
 */
function selectProcessiByFiltriIdMac($idMacchina,
        $idProcesso,
        $codProdotto,
        $codChimica,
        $codSacco,
        $dataProd,
        $nomeProdotto,
        $pesoRealeSac,
        $filtro,
        $var){
  mysql_query("SET @var='".$var."'");
  $stringSql="SELECT
                            p.id_processo,
                            p.cod_prodotto,
                            p.cod_chimica,
                            p.cod_sacco,
                            p.dt_produzione_mac,
                            pt.nome_prodotto,
                            p.peso_reale_sacco,
                            pt.id_prodotto,
                            p.cod_comp_peso,
                            id_cat,
                            p.info2                            
                        FROM
                            processo p
                        JOIN 
                            prodotto pt
                            ON pt.cod_prodotto=p.cod_prodotto
                        JOIN 
                            anagrafe_prodotto a
                            ON pt.id_prodotto=a.id_prodotto    
                        WHERE 
                            id_macchina='" . $idMacchina . "'
                         AND id_processo LIKE '%" . $idProcesso . "%'
                           AND p.cod_prodotto LIKE '%" . $codProdotto . "%'
                             AND cod_chimica LIKE '%" . $codChimica . "%'
                               AND cod_sacco LIKE '%" . $codSacco . "%'
                                  AND dt_produzione_mac LIKE '%" . $dataProd . "%'
                                       AND nome_prodotto LIKE '%" . $nomeProdotto . "%'
                                           AND peso_reale_sacco LIKE '%" . $pesoRealeSac . "%'
                          GROUP BY             
                          CASE WHEN @var='id_processo' THEN id_processo END ,
                          CASE WHEN @var='cod_prodotto' THEN pt.cod_prodotto END ,
                          CASE WHEN @var='cod_chimica' THEN cod_chimica END ,
                          CASE WHEN @var='cod_sacco' THEN cod_sacco END ,
                          CASE WHEN @var='dt_produzione_mac' THEN dt_produzione_mac END,
                          CASE WHEN @var='nome_prodotto' THEN pt.nome_prodotto END, 
                          CASE WHEN @var='peso_reale_sacco' THEN peso_reale_sacco END  
                           ORDER BY ".$filtro;
  
$sql = mysql_query($stringSql)
              or die("ERROR IN script_processo - FUNCTION selectProcessiByFiltriIdMac -  " .$stringSql." - ". mysql_error());
return $sql;
}

/**
 * Seleziona i prodotti presenti nella tabella processo 
 * in relazione agli stabilimenti presenti nella tab stab_gruppo_geo
 * @param type $idUtente
 * @return type
 */
  function selectProdottiFromProcesso($idUtente){
    
    $sql=mysql_query("SELECT ps.cod_prodotto,pr.nome_prodotto 
                      FROM prodotto pr 
                      JOIN processo ps ON pr.cod_prodotto=ps.cod_prodotto 
                      JOIN stab_gruppo_geo s ON s.id_macchina=ps.id_macchina
                      WHERE s.id_utente=".$idUtente."
                      GROUP BY ps.cod_prodotto 
                      ORDER BY ps.cod_prodotto")  
             or die("ERROR IN script_processo - FUNCTION selectProdottiFromProcesso - SELECT  FROM serverdb.processo: " . mysql_error());
    return $sql;
  }
  
  
  //############################### OGGETTI  ####################################
 /**
 * Seleziona i prodotti presenti nella tabella processo 
 * in relazione agli stabilimenti presenti nell'oggetto stab_gruppo_geo
 * @param type $idUtente
 * @return type
 */
  function selectProdottiFromProcessoByStab($stabGrupGeo){
    
$string = "SELECT ps.cod_prodotto,
                    pr.nome_prodotto 
               FROM prodotto pr 
               JOIN processo ps ON pr.cod_prodotto=ps.cod_prodotto 
               WHERE id_macchina IN (";

          for ($i = 0; $i < count($stabGrupGeo); $i++) {
            if ($i > 0) {
              $string .= " , ";
            }
            $string .= $stabGrupGeo[$i]->getId_macchina();
          }
          $string .= ") GROUP BY ps.cod_prodotto 
                ORDER BY ps.cod_prodotto";
          

    $result = mysql_query($string) 
    or die("ERROR IN script_processo - FUNCTION selectProdottiFromProcessoByStab - " . $string." ".mysql_error());

    return $result;
  }
  
  
  /**
 * Seleziona i prodotti presenti nella tabella processo 
 * @param type $idUtente
 * @return type
 */
  function selectProdottiFromProcesso2(){
    
    $sql=mysql_query("SELECT ps.cod_prodotto,pr.nome_prodotto 
                      FROM prodotto pr 
                      JOIN processo ps ON pr.cod_prodotto=ps.cod_prodotto 
                      GROUP BY ps.cod_prodotto 
                      ORDER BY ps.cod_prodotto")  
             or die("ERROR IN script_processo - FUNCTION selectProdottiFromProcesso - SELECT  FROM serverdb.processo: " . mysql_error());
    return $sql;
  }
  
  /**
   * Seleziona le informazioni di un processo tramite il codice del sacco
   * fra le macchine visibili all'utente
   * @param type $codSacco
   * @param type $stringUtentiAziende
   * @return type
   */
 function findProcessoByCodSaccoVis($codSacco,$stringUtentiAziende){
     $stringSql="SELECT * FROM serverdb.processo p 
                            JOIN serverdb.macchina m ON m.id_macchina=p.id_macchina											
			WHERE 
                            cod_sacco='" . $codSacco . "'
                        AND
                           (m.id_utente,m.id_azienda) IN ".$stringUtentiAziende ;
     $sql = mysql_query($stringSql) 
                    or die("ERRORE IN script_processo.php - FUNCTION findProcessoByCodSaccoVis - " .$stringSql." - ". mysql_error());
     return $sql;
 }
  
  /**
   * Seleziona i processi da salvare nell'oggetto Produttivita in base 
   * agli stabilimenti presenti nell'oggetto $stabGrupGeo
   * @param type $Data3
   * @param type $Data4
   * @param type $CodOperatore
   * @param type $CodProdotto
   * @param type object StabGrupGeo
   * @return type
   */
  function selectCreateProduttivita($Data3, 
          $Data4, 
          $CodOperatore, 
          $CodProdotto, 
          $stabGrupGeo) {
  
  $string = "SELECT 
                        id_processo, 
                        p.id_macchina,
                        cod_prodotto,
                        cod_chimica,
                        cod_sacco,
                        cod_operatore,
                        dt_produzione_mac 
                        FROM processo p
                        WHERE 
                            (dt_produzione_mac<='".$Data4."' AND dt_produzione_mac>='".$Data3."') 
                          AND
                            (cod_operatore LIKE '%".$CodOperatore."%' OR cod_operatore IS NULL)
                          AND
                             cod_prodotto LIKE '%".$CodProdotto."%'
                          AND
                            p.id_macchina IN (";

          for ($i = 0; $i < count($stabGrupGeo); $i++) {
            if ($i > 0) {
              $string .= " , ";
            }
            $string .= $stabGrupGeo[$i]->getId_macchina();
          }
          $string .= ") GROUP BY id_macchina,id_processo
                        ORDER BY dt_produzione_mac ASC";
//          echo $string;
          $sql=mysql_query($string)              
          or die("ERROR IN script_processo - FUNCTION selectCreateProduttivita - SELECT * FROM processo: " . mysql_error());
          return $sql;
}


/**
 * Seleziona dalla tabella processo i processi raggruppati per codice chimica
 * da salvare nell'oggetto TempoMedioInsacco in base agli id dei processi attivi
 * presenti nell'oggetto $objProcessiAttivi
 * @param type Produttivita $objProcessiAttivi
 * @return type
 */
function selectCreateTempoMedioInsacco($objProcessiAttivi) {
     
      $string ="SELECT    id_macchina,
                          dt_produzione_mac,
                          cod_operatore,
                          cod_prodotto,
                          cod_chimica
                          FROM processo 
                          WHERE 
                          id_processo IN (";
      for ($i = 0; $i < count($objProcessiAttivi); $i++) {
            if ($i > 0) {
              $string .= " , ";
            }
            $string .= $objProcessiAttivi[$i]->getId_processo();
          }
          
          $string .= ") GROUP BY cod_chimica ORDER BY id_processo"; 
          
//          echo $string;
          $sql=mysql_query($string) or die ("ERROR IN script processo - FUNCTION selectCreateTempoMedioInsacco " . mysql_error());
      
//       mysql_query("UPDATE tempo_medio_insacco SET media_per_cod_chimica_pesata= media_per_cod_chimica*num_sac;")
//       or die("ERROR IN script_tempo_medio_insacco - FUNCTION insertIntoTempoMedioInsacco - SELECT - UPDATE tempo_medio_insacco : " . mysql_error());
 return $sql;
  }
  
  
  function findProcessoByIdProcMacVis($idProcesso,$idMacchina,$stringUtentiAziende){
     $stringSql="SELECT * FROM serverdb.processo p 
                            JOIN serverdb.macchina m ON m.id_macchina=p.id_macchina											
			WHERE 
                            p.id_processo=" . $idProcesso . "
                        AND   p.id_macchina=".$idMacchina."      
                        AND
                           (m.id_utente,m.id_azienda) IN ".$stringUtentiAziende ;
     $sql = mysql_query($stringSql) 
                    or die("ERRORE IN script_processo.php - FUNCTION findProcessoByIdProcMacVis - " .$stringSql." - ". mysql_error());
     return $sql;
 }
  
 
 
 
// function findNumSacPerKitInProcesso($codChimica){
//     $stringSql="SELECT count(*) as num_sacchi_per_kit FROM serverdb.processo p 
//			WHERE 
//                            cod_chimica='" . $codChimica . "'";
//     $sql = mysql_query($stringSql) 
//                    or die("ERRORE IN script_processo.php - FUNCTION findNumSacPerKitInProcesso - " .$stringSql." - ". mysql_error());
//     return $sql;
// }
 
 function findProcessiByCodChimica($codChimica){                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             
     $stringSql="SELECT * FROM serverdb.processo p                       										
			WHERE                       
                            cod_chimica= '".$codChimica."' ORDER BY id_processo";                               
          
     $sql = mysql_query($stringSql) 
                    or die("ERRORE IN script_processo.php - FUNCTION findProcessiByCodChimica - " .$stringSql." - ". mysql_error());
     return $sql;
 }
 
 
 function selectProcessiByFiltriIdMacAndCiclo($idMacchina,
        $idProcesso,
        $codProdotto,
        $codChimica,
        $codSacco,
        $dataProd,
        $nomeProdotto,
        $pesoRealeSac,
        $filtro,
        $var,$idCiclo){
  mysql_query("SET @var='".$var."'");
 $stringSql="SELECT
                            p.id_processo,
                            p.cod_prodotto,
                            p.cod_chimica,
                            p.cod_sacco,
                            p.dt_produzione_mac,
                            pt.nome_prodotto,
                            p.peso_reale_sacco,
                            pt.id_prodotto,
                            p.cod_comp_peso,
                            id_cat,
                            p.info2
                        FROM
                            processo p
                        JOIN 
                            prodotto pt
                            ON pt.cod_prodotto=p.cod_prodotto
                        JOIN 
                            anagrafe_prodotto a
                            ON pt.id_prodotto=a.id_prodotto 
                        JOIN ciclo_processo c ON c.id_processo=p.id_processo    
                        WHERE 
                            p.id_macchina=" . $idMacchina . "
                         AND c.id_ciclo=" . $idCiclo . "
                         AND p.id_processo LIKE '%" . $idProcesso . "%'
                           AND p.cod_prodotto LIKE '%" . $codProdotto . "%'
                             AND cod_chimica LIKE '%" . $codChimica . "%'
                               AND cod_sacco LIKE '%" . $codSacco . "%'
                                  AND dt_produzione_mac LIKE '%" . $dataProd . "%'
                                       AND nome_prodotto LIKE '%" . $nomeProdotto . "%'
                                           AND peso_reale_sacco LIKE '%" . $pesoRealeSac . "%'
                          GROUP BY             
                          CASE WHEN @var='id_processo' THEN p.id_processo END ,
                          CASE WHEN @var='cod_prodotto' THEN pt.cod_prodotto END ,
                          CASE WHEN @var='cod_chimica' THEN cod_chimica END ,
                          CASE WHEN @var='cod_sacco' THEN cod_sacco END ,
                          CASE WHEN @var='dt_produzione_mac' THEN dt_produzione_mac END,
                          CASE WHEN @var='nome_prodotto' THEN pt.nome_prodotto END, 
                          CASE WHEN @var='peso_reale_sacco' THEN peso_reale_sacco END  
                           ORDER BY ".$filtro;
  
$sql = mysql_query($stringSql)
              or die("ERROR IN script_processo - FUNCTION selectProcessiByFiltriIdMacAndCiclo -  " .$stringSql." - ". mysql_error());
return $sql;
}

function selectProcessiByFiltriIdMacAndArrayCiclo($idMacchina,
        $idProcesso,
        $codProdotto,
        $codChimica,
        $codSacco,
        $dataProd,
        $nomeProdotto,
        $pesoRealeSac,
        $filtro,
        $var,
        $strCicli){
  mysql_query("SET @var='".$var."'");
  $stringSql="SELECT
                            p.id_processo,
                            p.cod_prodotto,
                            p.cod_chimica,
                            p.cod_sacco,
                            p.dt_produzione_mac,
                            pt.nome_prodotto,
                            p.peso_reale_sacco,
                            pt.id_prodotto,
                            p.cod_comp_peso,
                            id_cat,
                            p.info2
                        FROM
                            processo p
                        JOIN 
                            prodotto pt
                            ON pt.cod_prodotto=p.cod_prodotto
                        JOIN 
                            anagrafe_prodotto a
                            ON pt.id_prodotto=a.id_prodotto 
                        JOIN ciclo_processo c ON c.id_processo=p.id_processo    
                        WHERE 
                            p.id_macchina=" . $idMacchina . "
                         
                         AND p.id_processo LIKE '%" . $idProcesso . "%'
                           AND p.cod_prodotto LIKE '%" . $codProdotto . "%'
                             AND cod_chimica LIKE '%" . $codChimica . "%'
                               AND cod_sacco LIKE '%" . $codSacco . "%'
                                  AND dt_produzione_mac LIKE '%" . $dataProd . "%'
                                       AND nome_prodotto LIKE '%" . $nomeProdotto . "%'
                                           AND peso_reale_sacco LIKE '%" . $pesoRealeSac . "%'
                                               
                                            AND id_ciclo IN ".$strCicli."
                          GROUP BY             
                          CASE WHEN @var='id_processo' THEN p.id_processo END ,
                          CASE WHEN @var='cod_prodotto' THEN pt.cod_prodotto END ,
                          CASE WHEN @var='cod_chimica' THEN cod_chimica END ,
                          CASE WHEN @var='cod_sacco' THEN cod_sacco END ,
                          CASE WHEN @var='dt_produzione_mac' THEN dt_produzione_mac END,
                          CASE WHEN @var='nome_prodotto' THEN pt.nome_prodotto END, 
                          CASE WHEN @var='peso_reale_sacco' THEN peso_reale_sacco END  
                           ORDER BY ".$filtro;
  
$sql = mysql_query($stringSql)
              or die("ERROR IN script_processo - FUNCTION selectProcessiByFiltriIdMacAndArrayCiclo -  " .$stringSql." - ". mysql_error());
return $sql;
}
 
 



function findInfoProcessiEsporta($idMacchina,$dataInf,$dataSup){                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             
     $stringSql="SELECT 
c.id_ciclo, 
c.tipo_ciclo, 
c.dt_inizio_ciclo,
c.dt_fine_ciclo,
c.id_ordine,
c.id_prodotto,
p.cod_prodotto,
p.cod_chimica,
p.cliente,
p.cod_operatore,
c.id_cat,
c.velocita_mix,
c.tempo_mix,
c.num_sacchi,
c.num_sacchi_aggiuntivi,
c.vibro_attivo,
c.aria_cond_scarico,
c.aria_interno_valvola,
c.aria_pulisci_valvola,
cp.id_processo,
cp.dt_inizio_processo,
cp.dt_fine_processo,
p.cod_sacco,
p.peso_reale_sacco,
p.dt_produzione_mac,
p.cod_comp_peso,
p.info2,
p.info3,
p.info4, 
m.id_materiale,
co.cod_componente,
co.descri_componente,
m.tipo_materiale,
m.quantita,
m.peso_teorico,
m.cod_ingresso_comp,
m.dt_mov,
m.silo,
m.descri_mov,
m.dt_inizio_procedura,
m.dt_fine_procedura,
pr.nome_prodotto,
cat.nome_categoria
FROM  serverdb.ciclo c 
JOIN serverdb.ciclo_processo cp ON c.id_ciclo=cp.id_ciclo 
JOIN serverdb.processo p ON p.id_processo=cp.id_processo
JOIN serverdb.movimento_sing_mac m ON m.id_ciclo=c.id_ciclo 
JOIN serverdb.componente co ON co.id_comp=m.id_materiale
JOIN serverdb.prodotto pr ON pr.id_prodotto=c.id_prodotto
JOIN serverdb.categoria cat ON cat.id_cat=c.id_cat
WHERE m.id_macchina=c.id_macchina 
AND p.id_macchina=".$idMacchina." AND (c.dt_abilitato>='".$dataInf."' AND c.dt_abilitato<='".$dataSup."')
             GROUP BY id_ciclo, id_processo, id_materiale ORDER BY id_ciclo, id_processo, id_materiale";                               
          
     $sql = mysql_query($stringSql) 
                    or die("ERRORE IN script_processo.php - FUNCTION findInfoProcessiEsporta - " .$stringSql." - ". mysql_error());
     return $sql;
 }
 
 
 
 function findInfoProcessiByIdCiclo($idMacchina,$idCiclo,$idProdotto) {

    $sqlString = "SELECT *
                    FROM serverdb.processo p
                    JOIN serverdb.ciclo_processo cp ON cp.id_processo=p.id_processo
                    JOIN serverdb.ciclo c ON c.id_ciclo=cp.id_ciclo
                   WHERE c.id_macchina=".$idMacchina."  
                        AND c.id_ciclo=".$idCiclo ." "
            . "AND c.id_prodotto=".$idProdotto ." ORDER BY p.id_processo";       
    $sql = mysql_query($sqlString) 
            or die("ERROR IN script_processo.php - FUNCION findInfoProcessiByIdCiclo - " . $sqlString . " " . mysql_error());

    return $sql;
}
 

