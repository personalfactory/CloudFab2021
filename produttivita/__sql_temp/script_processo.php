<?php
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
 * @param type $filtro
 * @return type
 */
function selectProcessiByFiltriIdMac($idMacchina,
        $idProcesso,
        $codProdotto,
        $codChimica,
        $codSacco,
        $cliente,
        $dataProd,
        $nomeProdotto,
        $filtro,
        $var){
  mysql_query("SET @var='".$var."'");
$sql = mysql_query("SELECT
                            processo.id_processo,
                            processo.cod_prodotto,
                            processo.cod_chimica,
                            processo.cod_sacco,
                            processo.cliente,
                            processo.dt_produzione_mac,
                            prodotto.nome_prodotto
                        FROM
                            processo
                        INNER JOIN 
                            prodotto
                            ON prodotto.cod_prodotto=processo.cod_prodotto                           
                        WHERE 
                            id_macchina='" . $idMacchina . "'
                         AND id_processo LIKE '%" . $idProcesso . "%'
                           AND processo.cod_prodotto LIKE '%" . $codProdotto . "%'
                             AND cod_chimica LIKE '%" . $codChimica . "%'
                               AND cod_sacco LIKE '%" . $codSacco . "%'
                                  AND cliente LIKE '%" . $cliente . "%'
                                     AND dt_produzione_mac LIKE '%" . $dataProd . "%'
                                       AND nome_prodotto LIKE '%" . $nomeProdotto . "%'
                          GROUP BY             
                          CASE WHEN @var='id_processo' THEN id_processo END ,
                          CASE WHEN @var='cod_prodotto' THEN prodotto.cod_prodotto END ,
                          CASE WHEN @var='cod_chimica' THEN cod_chimica END ,
                          CASE WHEN @var='cod_sacco' THEN cod_sacco END ,
                          CASE WHEN @var='cliente' THEN cliente END ,
                          CASE WHEN @var='dt_produzione_mac' THEN dt_produzione_mac END,
                          CASE WHEN @var='nome_prodotto' THEN prodotto.nome_prodotto END  
                           ORDER BY ".$filtro )
              or die("ERROR IN script_processo - FUNCTION selectProcessiByFiltriIdMac - SELECT  FROM processo: " . mysql_error());
return $sql;
}

/**
 * Seleziona i prodotti presenti nella tabella processo 
 * in relazione agli stabilimenti presenti nella tab stab_gruppo_geo
 * @param type $idUtente
 * @return type
 */
//  function selectProdottiFromProcesso($idUtente){
//    
//    $sql=mysql_query("SELECT ps.cod_prodotto,pr.nome_prodotto 
//                      FROM prodotto pr 
//                      JOIN processo ps ON pr.cod_prodotto=ps.cod_prodotto 
//                      JOIN stab_gruppo_geo s ON s.id_macchina=ps.id_macchina
//                      WHERE s.id_utente=".$idUtente."
//                      GROUP BY ps.cod_prodotto 
//                      ORDER BY ps.cod_prodotto")  
//             or die("ERROR IN script_processo - FUNCTION selectProdottiFromProcesso - SELECT  FROM serverdb.processo: " . mysql_error());
//    return $sql;
//  }
  
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
  
 //############################### OGGETTI  ####################################
 /**
 * Seleziona i prodotti presenti nella tabella processo 
 * in relazione agli stabilimenti presenti nella tab stab_gruppo_geo
 * @param type $idUtente
 * @return type
 */
  function selectProdottiFromProcesso($stabGrupGeo){
    
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
//          echo $string;

    $result = mysql_query($string) 
    or die("ERROR IN script_processo - FUNCTION selectProdottiFromProcesso - SELECT  FROM serverdb.processo: " . mysql_error());

    return $result;
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
?>
