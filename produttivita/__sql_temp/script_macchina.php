<?php

function findMacchinaById($idMacchina){
  
  $sql=mysql_query("SELECT *  FROM serverdb.macchina WHERE id_macchina=" . $idMacchina )
                    or die("ERROR IN script_macchina - FUNCTION findMacchinaById - SELECT FROM serverdb.macchina : " . mysql_error());
return $sql;
  
}

function findMacchinaByAbilitato($abilitato){
  
  $sql=mysql_query("SELECT *  FROM serverdb.macchina WHERE abilitato=" . $abilitato ." ORDER BY descri_stab" )
                    or die("ERROR IN script_macchina - FUNCTION findMacchinaByAbilitato - SELECT FROM serverdb.macchina : " . mysql_error());
return $sql;
  
}

function selectMacchina($idMacchina){
  
        
$sql=mysql_query(" SELECT 
                            m.id_macchina,
                            m.descri_stab,
                            a.gruppo,
                            a.geografico
                            FROM macchina m 
                      JOIN anagrafe_macchina a 
                      ON a.id_macchina=m.id_macchina 
                      WHERE m.id_macchina=".$idMacchina)
        or die("ERROR IN script_stab_gruppo_geo - FUNCTION selectMacchina - SELECT FROM macchina : " . mysql_error());
return $sql;
  
}
//function selectListaMacchineByIdMac($idMacchina,$codStab,$descriStab,$filtro){
//    
//  
//  $sql = mysql_query("SELECT
//                        m.id_macchina,
//                        m.cod_stab,
//                        m.descri_stab,
//                        a.gruppo,
//                        a.geografico,
//                        m.abilitato,
//                        m.dt_abilitato,
//                        COUNT(DISTINCT(id_processo)) AS processi_tot
//                      FROM
//                        macchina m
//                      LEFT JOIN anagrafe_macchina a
//                      ON 
//                        m.id_macchina = a.id_macchina
//                      LEFT JOIN processo p
//                      ON 
//                        m.id_macchina = p.id_macchina
//                      WHERE
//                        m.id_macchina=".$idMacchina."
//                      AND 
//                        m.cod_stab LIKE '%". $codStab."%'
//                      AND 
//                        m.descri_stab LIKE '%". $descriStab."%'
//                      GROUP BY id_macchina  
//                      ORDER BY ".$filtro) 
//              or die("ERRORE SELECT MACCHINE : " . mysql_error());
//  
//  return $sql;
//}
//function selectListaMacchine($codStab,$descriStab,$filtro){
//    
//  
//  $sql = mysql_query("SELECT
//                        m.id_macchina,
//                        m.cod_stab,
//                        m.descri_stab,
//                        a.gruppo,
//                        a.geografico,
//                        m.abilitato,
//                        m.dt_abilitato,
//                        COUNT(DISTINCT(id_processo)) AS processi_tot
//                      FROM
//                        macchina m
//                      LEFT JOIN anagrafe_macchina a
//                      ON 
//                        m.id_macchina = a.id_macchina
//                      LEFT JOIN processo p
//                      ON 
//                        m.id_macchina = p.id_macchina
//                      WHERE
//                        m.id_macchina>0
//                      AND 
//                        m.cod_stab LIKE '%". $codStab."%'
//                      AND 
//                        m.descri_stab LIKE '%". $descriStab."%'
//                      GROUP BY id_macchina  
//                      ORDER BY ".$filtro) 
//              or die("ERRORE SELECT MACCHINE : " . mysql_error());
//  
//  return $sql;
//}



/**
 * Seleziona tutti gli stabilimenti appartenenti ad un certo gruppo e riferimento geografico
 * dalla tab macchina
 * @param type $Gruppo
 * @param type $RifGeo
 * @return type
 */
function selectStabByGruppoGeo($Gruppo,$RifGeo) {
  mysql_query("SET @gruppoAcq='".$Gruppo."',@rigGeo='".$RifGeo."';");
  $sql=  mysql_query("SELECT 
                            m.id_macchina,
                            m.descri_stab,
                            a.gruppo,
                            a.geografico                          
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
          or die("ERROR IN script_macchina - FUNCTION selectStabByGruppoGeo - SELECT FROM gruppo g JOIN comune c JOIN macchina m : " . mysql_error());

  return $sql;
}


function selectMacchinaSp($idMacchina, $codice, $descriStab, $gruppo, $geografico, $filtro) {

  mysql_query("SET @IdMacchina='".$idMacchina."', 
                   @Codice='".$codice."',
                   @DescriStab='".$descriStab."',
                   @Gruppo='".$gruppo."',
                   @Geografico='".$geografico."',
                   @Filtro='".$filtro."'");
 
  $sql=  mysql_query("SELECT 
                            m.id_macchina,
                            m.cod_stab,
                            m.descri_stab,
                            a.gruppo,
                            a.geografico
                         FROM  gruppo g JOIN comune c JOIN macchina m
                         INNER JOIN anagrafe_macchina a ON m.id_macchina=a.id_macchina
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
                                                WHEN (@Gruppo = g.livello_6) THEN 64 
                                                WHEN (@Gruppo = g.livello_5) THEN 32 
                                                WHEN (@Gruppo = g.livello_4) THEN 16
                                                WHEN (@Gruppo = g.livello_3) THEN 8 
                                                WHEN (@Gruppo = g.livello_2) THEN 4 
                                                WHEN (@Gruppo = g.livello_1) THEN 2 
                                                END 
                                            AND 
                                                ((a.gruppo = g.livello_1) OR 
                                                (a.gruppo = g.livello_2) OR 
                                                (a.gruppo = g.livello_3) OR 
                                                (a.gruppo = g.livello_4) OR 
                                                (a.gruppo = g.livello_5) OR 
                                                (a.gruppo = g.livello_6)) 
                                            AND
                                                ((@Gruppo = g.livello_1) OR 
                                                (@Gruppo = g.livello_2) OR 
                                                (@Gruppo = g.livello_3) OR 
                                                (@Gruppo = g.livello_4) OR 
                                                (@Gruppo = g.livello_5) OR 
                                                (@Gruppo = g.livello_6)) 
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
                                        WHEN (@Geografico = c.mondo) THEN 64 
                                        WHEN (@Geografico = c.continente) THEN 32 
                                        WHEN (@Geografico = c.stato) THEN 16 
                                        WHEN (@Geografico = c.regione) THEN 8 
                                        WHEN (@Geografico = c.provincia) THEN 4 
                                        WHEN (@Geografico = c.comune) THEN 2 
                                        END 
                                    AND 
                                       ((@Geografico = c.mondo) OR 
                                        (@Geografico = c.continente) OR 
                                        (@Geografico = c.stato) OR 
                                        (@Geografico = c.regione) OR 
                                        (@Geografico = c.provincia) OR 
                                        (@Geografico = c.comune)) 
                                    AND 
                                       ((a.geografico = c.mondo) OR 
                                        (a.geografico = c.continente) OR 
                                        (a.geografico = c.stato) OR 
                                        (a.geografico = c.regione) OR 
                                        (a.geografico = c.provincia) OR 
                                        (a.geografico = c.comune)) 
                                  )
                                 AND 
                                    m.id_macchina LIKE CONCAT('%',@IdMacchina,'%')  
                                AND 
                                    m.cod_stab LIKE CONCAT('%',@Codice,'%')
                                AND 
                                    m.descri_stab LIKE CONCAT('%',@DescriStab,'%') 
                                GROUP BY m.id_macchina
                                ORDER BY ".$filtro)                                            

       or die("ERROR IN script_macchina- FUNCTION selectMacchinaSp - SELECT   FROM  gruppo g JOIN comune c JOIN macchina m: " . mysql_error());
  
  return $sql;
}
?>
