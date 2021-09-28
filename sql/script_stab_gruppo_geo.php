<?php

function findStabGruppoGeoByIdUtente($idUtente){
  $sql=mysql_query("SELECT * FROM stab_gruppo_geo WHERE id_utente=".$idUtente)
          or die("ERROR IN script_stab_gruppo_geo - FUNCTION findStabGruppoGeoByIdUtente - SELECT * FROM stab_gruppo_geo : " . mysql_error());
  return $sql;
}

function deleteStabGruppoGeoByUtente($idUtente){
  
  mysql_query("DELETE FROM stab_gruppo_geo WHERE id_utente=".$idUtente)
          or die("ERROR IN script_stab_gruppo_geo - FUNCTION deleteStabGruppoGeoByUtente - DELETE FROM stab_gruppo_geo : " . mysql_error());
  
}

/**
 * Inserisce nella tabella stab_gruppo_geo l'elenco di tutti gli stabilimenti 
 * presenti nella tabella macchina.
 * @param type $Gruppo
 * @param type $RifGeo
 * @param type $idUtente
 */
 
function insertStabGruppoGeo2($idUtente){  
  
mysql_query("SET @idUtente=".$idUtente.";");
mysql_query("INSERT INTO stab_gruppo_geo (id_macchina,descri_stab,gruppo,geografico,id_utente)
                        SELECT 
                            m.id_macchina,
                            m.descri_stab,
                            '0',
                            '0',
                            @idUtente 
                        FROM macchina m 
                        JOIN anagrafe_macchina a
                            ON a.id_macchina=m.id_macchina
                        GROUP BY m.id_macchina
                        ORDER BY m.descri_stab")
        or die("ERROR IN script_stab_gruppo_geo - FUNCTION insertStabGruppoGeo2 - INSERT INTO stab_gruppo_geo : " . mysql_error());
 
}


/**
 * Inserisce nella tabella stab_gruppo_geo l'elenco degli stabilimenti relativi alla 
 * scelta del gruppo e del rif geografico fatta dall'utente.
 * @param type $Gruppo
 * @param type $RifGeo
 * @param type $idUtente
 */
 
function insertStabGruppoGeo($Gruppo,$RifGeo,$idUtente){  
  
mysql_query("SET @gruppoAcq='".$Gruppo."',@rigGeo='".$RifGeo."',@idUtente=".$idUtente.";");
mysql_query("INSERT INTO stab_gruppo_geo (id_macchina,descri_stab,gruppo,geografico,id_utente)
                        SELECT 
                            m.id_macchina,
                            m.descri_stab,
                            a.gruppo,
                            a.geografico,
                            @idUtente 
                        FROM  gruppo g JOIN comune c JOIN macchina m 
                        JOIN anagrafe_macchina a
                            ON a.id_macchina=m.id_macchina
                         WHERE 
                                 (
                                            CASE 
                                                WHEN (a.gruppo = g.livello_6) THEN 64 
                                                WHEN (a.gruppo = g.livello_5) THEN 32 
                                                WHEN (a.gruppo = g.livello_4) THEN 16 
                                                WHEN (a.gruppo = g.livello_3) THEN 8 
                                                WHEN (a.gruppo = g.livello_2) THEN 4 
                                                WHEN (a.gruppo = g.livello_1) THEN 2 
                                                END 
                                                <= 
                                                CASE 
                                                WHEN (@gruppoAcq = g.livello_6) THEN 64 
                                                WHEN (@gruppoAcq = g.livello_5) THEN 32 
                                                WHEN (@gruppoAcq = g.livello_4) THEN 16
                                                WHEN (@gruppoAcq = g.livello_3) THEN 8 
                                                WHEN (@gruppoAcq = g.livello_2) THEN 4 
                                                WHEN (@gruppoAcq = g.livello_1) THEN 2 
                                                END 
                                            AND 
                                                ((a.gruppo = g.livello_1) OR 
                                                (a.gruppo = g.livello_2) OR 
                                                (a.gruppo = g.livello_3) OR 
                                                (a.gruppo = g.livello_4) OR 
                                                (a.gruppo = g.livello_5) OR 
                                                (a.gruppo = g.livello_6)) 
                                            AND
                                                ((@gruppoAcq = g.livello_1) OR 
                                                (@gruppoAcq = g.livello_2) OR 
                                                (@gruppoAcq = g.livello_3) OR 
                                                (@gruppoAcq = g.livello_4) OR 
                                                (@gruppoAcq = g.livello_5) OR 
                                                (@gruppoAcq = g.livello_6)) 
                                )
                            AND 
                                (
                                   CASE                     
                                       WHEN (a.geografico = c.mondo) THEN 64 
                                       WHEN (a.geografico = c.continente) THEN 32 
                                       WHEN (a.geografico = c.stato) THEN 16 
                                       WHEN (a.geografico = c.regione) THEN 8 
                                       WHEN (a.geografico = c.provincia) THEN 4 
                                       WHEN (a.geografico = c.comune) THEN 2 
                                        END 
                                        <= 
                                        CASE 
                                        WHEN (@rigGeo = c.mondo) THEN 64 
                                        WHEN (@rigGeo = c.continente) THEN 32 
                                        WHEN (@rigGeo = c.stato) THEN 16 
                                        WHEN (@rigGeo = c.regione) THEN 8 
                                        WHEN (@rigGeo = c.provincia) THEN 4 
                                        WHEN (@rigGeo = c.comune) THEN 2 
                                        END 
                                    AND 
                                       ((@rigGeo = c.mondo) OR 
                                        (@rigGeo = c.continente) OR 
                                        (@rigGeo = c.stato) OR 
                                        (@rigGeo = c.regione) OR 
                                        (@rigGeo = c.provincia) OR 
                                        (@rigGeo = c.comune)) 
                                    AND 
                                       ((a.geografico = c.mondo) OR 
                                        (a.geografico = c.continente) OR 
                                        (a.geografico = c.stato) OR 
                                        (a.geografico = c.regione) OR 
                                        (a.geografico = c.provincia) OR 
                                        (a.geografico = c.comune)) 
                                  )
                                GROUP BY m.id_macchina
                                ORDER BY m.descri_stab")
        or die("ERROR IN script_stab_gruppo_geo - FUNCTION insertStabGruppoGeo - INSERT INTO stab_gruppo_geo : " . mysql_error());

  
}


/**
 * Inserisce le informazioni della macchina selezionata nella tabella stab_gruppo_geo
 * @param type $idMacchina
 * @param type $idUtente
 */
function insertIdMacchinaStabGruppoGeo($idMacchina,$idUtente){
  
        
mysql_query("INSERT INTO stab_gruppo_geo (id_macchina,descri_stab,gruppo,geografico,id_utente)
                      SELECT 
                            m.id_macchina,
                            m.descri_stab,
                            a.gruppo,
                            a.geografico,
                            ".$idUtente." 
                      FROM macchina m 
                      JOIN anagrafe_macchina a 
                      ON a.id_macchina=m.id_macchina 
                      WHERE m.id_macchina=".$idMacchina)
        or die("ERROR IN script_stab_gruppo_geo - FUNCTION insertIdMacchinaStabGruppoGeo - INSERT INTO stab_gruppo_geo : " . mysql_error());

  
}
?>
