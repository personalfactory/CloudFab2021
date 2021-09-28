<?php

/**
 * Elimina i record associati ad un id_utente
 * @param type $idUtente
 */

function deleteTempoMedioInsaccoByIdUtente($idUtente){
  
   mysql_query("DELETE FROM tempo_medio_insacco WHERE id_utente=".$idUtente)
   or die("ERROR IN script_tempo_medio_insacco - FUNCTION deleteTempoMedioInsaccoByIdUtente - DELETE - SELECT tempo_medio_insacco : " . mysql_error());
}

/**
 * Inserisce nella tabella tempo_medio_insacco i processi ed esegue dei calcoli utili al calcolo
 * del tempo medio di insacco durante il processo
 * @param type $idMacchina
 * @return type
 */
  function insertIntoTempoMedioInsacco($idUtente) {
    
      
      $sql =mysql_query("INSERT INTO tempo_medio_insacco (id_macchina,
                                 dt_produzione_mac,
                                 cod_operatore,
                                 cod_prodotto,
                                 cod_chimica,
                                 somma_tempo_sec,
                                 num_sac,
                                 media_per_cod_chimica,
                                 id_utente)
                          SELECT
                          processo.id_macchina,
                          processo.dt_produzione_mac,
                          processo.cod_operatore,
                          processo.cod_prodotto,
                          processo.cod_chimica,
                          sum(produttivita.diff),
                          count(produttivita.id_processo),                          
                          (sum(produttivita.diff) / count(produttivita.id_processo)),                          
                          ".$idUtente."
                          FROM produttivita 
                          JOIN processo ON processo.id_processo = produttivita.id_processo 
                          WHERE 
                            produttivita.attivo=1
                         AND 
                            produttivita.id_utente=".$idUtente."
                          GROUP BY processo.cod_chimica 
                          ORDER BY produttivita.id_processo") 
            or die("ERROR IN script_tempo_medio_insacco - FUNCTION insertIntoTempoMedioInsacco - INSERT INTO tempo_medio_insacco : " . mysql_error());
            
       mysql_query("UPDATE tempo_medio_insacco SET media_per_cod_chimica_pesata= media_per_cod_chimica*num_sac;")
       or die("ERROR IN script_tempo_medio_insacco - FUNCTION insertIntoTempoMedioInsacco - SELECT - UPDATE tempo_medio_insacco : " . mysql_error());
 return $sql;
  }

  /**
   * Seleziona e calcola media ponderata del tempo di insacco dalla tabella tempo_medio_medio_insacco
   * @param type $idUtente
   * @return type
   */

function selectTempoMedioInsacco($idUtente) {
   
    $sql = mysql_query("SELECT SUM(media_per_cod_chimica_pesata)/SUM(num_sac) AS media_pesata FROM tempo_medio_insacco
              WHERE id_utente =".$idUtente) 
            or die("ERROR IN script_tempo_medio_insacco - FUNCTION selectTempoMedioInsacco - SELECT  FROM serverdb.TempoMedioInsacco: " . mysql_error());
    return $sql;
  }

?>
