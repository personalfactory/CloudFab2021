<?php
/**
 * Seleziona una macchina dalla tabella macchina tramite il codice stab
 * @param type $codiceStab
 * @return type
 */
function findMacchinaByCodice($codiceStab) {
    $stringSql = "SELECT * FROM serverdb.macchina WHERE cod_stab='" . $codiceStab . "'";
    $sql = mysql_query($stringSql) or die("ERROR IN script_macchina - FUNCTION findMacchinaByCodice - " . $stringSql . " - " . mysql_error());
    return $sql;
}

/**
 * Seleziona una macchina con stesso id o codice o descrizione dalla tabella macchina
 * @param type $idMacchina
 * @param type $codiceStab
 * @param type $descriStab
 * @return type
 */
function verificaEsistenzaMacchina($idMacchina, $codiceStab, $descriStab) {

    $stringSql = "SELECT * FROM serverdb.macchina 
                             WHERE 
                                id_macchina = " . $idMacchina . " 
                             OR 
                                cod_stab = '" . $codiceStab . "' 
                             OR 
                                descri_stab = '" . $descriStab . "'";
    $sql = mysql_query($stringSql) or die("ERROR IN script_macchina - FUNCTION verificaEsistenzaMacchina - " . $stringSql . " - " . mysql_error());
    return $sql;
}

/**
 * Ricerca nella tabella macchina una macchina con stesso codice o descrizione ed id_macchina diverso 
 * @param type $idMacchina
 * @param type $codiceStab
 * @param type $descriStab
 * @return type
 */
function verificaModificaMacchina($idMacchina, $codiceStab, $descriStab) {

    $stringSql = "SELECT * FROM serverdb.macchina 
				WHERE 
					(cod_stab = '" . $codiceStab . "' 
				OR 
					descri_stab = '" . $descriStab . "')
				AND 
					id_macchina<>" . $idMacchina;
    $sql = mysql_query($stringSql) or die("ERROR IN script_macchina - FUNCTION verificaModificaMacchina - " . $stringSql . " - " . mysql_error());
    return $sql;
}

/**
 * Seleziona tutte le macchine abilitate presenti nella tabella macchina e visibili
 * @param type $campoOrdine
 * @param type $strUtentiAziende
 * @return type
 */
function findAllMacchineVisAbilitate($campoOrdine,$strUtentiAziende) {

    $stringSql = "SELECT * FROM serverdb.macchina WHERE abilitato=1 AND (id_utente,id_azienda) IN ".$strUtentiAziende." ORDER BY " . $campoOrdine;
    $sql = mysql_query($stringSql) or die("ERROR IN script_macchina - FUNCTION findAllMacchineAbilitate - " . $stringSql . " - " . mysql_error());
    return $sql;
}

/**
 * Seleziona tutte le macchine presenti nella tabella macchina
 * @param type $campoOrdine
 * @return type
 */
function findAllMacchine($campoOrdine) {

    $stringSql = "SELECT * FROM serverdb.macchina ORDER BY " . $campoOrdine;
    $sql = mysql_query($stringSql) or die("ERROR IN script_macchina - FUNCTION findAllMacchine - " . $stringSql . " - " . mysql_error());
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
function findMacchinaById($idMacchina) {
    $stringSql="SELECT *  FROM serverdb.macchina WHERE id_macchina=" . $idMacchina;
    
    $sql = mysql_query($stringSql) or die("ERROR IN script_macchina - FUNCTION findMacchinaById -  ".$stringSql ." - ". mysql_error());
    return $sql;
}

function findMacchinaByAbilitato($abilitato) {

    $sql = mysql_query("SELECT *  FROM serverdb.macchina WHERE abilitato=" . $abilitato . " ORDER BY descri_stab") or die("ERROR IN script_macchina - FUNCTION findMacchinaByAbilitato - SELECT FROM serverdb.macchina : " . mysql_error());
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
function selectStabAbilitatiByGruppoGeo($Gruppo, $RifGeo) {
    mysql_query("SET @gruppoAcq='" . $Gruppo . "', @rigGeo='" . $RifGeo . "';");
    $stringSql="SELECT 
                            m.id_macchina,
                            m.descri_stab,
                            a.gruppo,
                            a.geografico                          
                         FROM  serverdb.gruppo g JOIN serverdb.comune c JOIN serverdb.macchina m 
                        JOIN serverdb.anagrafe_macchina a
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
                                ORDER BY m.descri_stab";
          $sql = mysql_query($stringSql)  or die("ERROR IN script_macchina - FUNCTION selectStabByGruppoGeo - " .$stringSql." - ". mysql_error());

    return $sql;
}


/**
 * Seleziona gli stabilimenti appartenenti ad un dato gruppo e rif geografico o visibili all'utente
 * @param type $Gruppo
 * @param type $RifGeo
 * @param type $strUtAziende
 * @return type
 */
function selectStabByGruppoGeoVis($Gruppo, $RifGeo,$strUtAziende) {
    mysql_query("SET @gruppoAcq='" . $Gruppo . "',@rigGeo='" . $RifGeo . "';");
    $sql = mysql_query("SELECT 
                            m.id_macchina,
                            m.descri_stab,
                            a.gruppo,
                            a.geografico                          
                         FROM  serverdb.gruppo g JOIN serverdb.comune c JOIN serverdb.macchina m 
                        JOIN serverdb.anagrafe_macchina a
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
                                AND 
                                    (m.id_utente,m.id_azienda) IN ".$strUtAziende."
                                GROUP BY m.id_macchina
                                ORDER BY m.descri_stab") 
            or die("ERROR IN script_macchina - FUNCTION selectStabByGruppoGeoVis - SELECT FROM gruppo g JOIN comune c JOIN macchina m : " . mysql_error());

    return $sql;
}





/**
 * 
 * @param type $idMacchina
 * @param type $codice
 * @param type $descriStab
 * @param type $gruppo
 * @param type $geografico
 * @param type $filtro
 * @return type
 */
function selectMacchinaSp($idMacchina, $codice, $descriStab,$userOrigami,$userServer,$abilitato, $gruppo, $geografico, $filtro, $strUtentiAziende) {

    mysql_query("SET @IdMacchina='" . $idMacchina . "', 
                   @Codice='" . $codice . "',
                   @DescriStab='" . $descriStab . "',
                   @UserOrigami='" . $userOrigami . "',
                   @UserServer='".$userServer."',
                   @Abilitato='".$abilitato."',
                   @Gruppo='" . $gruppo . "',
                   @Geografico='" . $geografico . "',
                   @Filtro='" . $filtro . "'");

    $sql = mysql_query("SELECT 
                            m.id_macchina,
                            m.cod_stab,
                            m.descri_stab,
                            a.gruppo,
                            a.geografico,
                            m.user_origami,
                            m.user_server,
                            m.abilitato,
                            m.ftp_user,
                            m.ftp_password
                         FROM  serverdb.gruppo g JOIN serverdb.comune c JOIN serverdb.macchina m
                         INNER JOIN serverdb.anagrafe_macchina a ON m.id_macchina=a.id_macchina
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
                                AND 
                                    m.user_origami LIKE CONCAT('%',@UserOrigami,'%')
                                AND 
                                    m.user_server LIKE CONCAT('%',@UserServer,'%')
                                AND 
                                    m.abilitato LIKE CONCAT('%',@Abilitato,'%')    
                                AND 
                                    (m.id_utente,m.id_azienda) IN " . $strUtentiAziende . "                                                                 
                                GROUP BY m.id_macchina
                                ORDER BY " . $filtro) or die("ERROR IN script_macchina- FUNCTION selectMacchinaSp - SELECT   FROM  gruppo g JOIN comune c JOIN macchina m: " . mysql_error());

    return $sql;
}

//function selectMacchinaSp($idMacchina, $codice, $descriStab, $gruppo, $geografico, $filtro) {
//
//  mysql_query("SET @IdMacchina='".$idMacchina."', 
//                   @Codice='".$codice."',
//                   @DescriStab='".$descriStab."',
//                   @Gruppo='".$gruppo."',
//                   @Geografico='".$geografico."',
//                   @Filtro='".$filtro."'");
// 
//  $sql=  mysql_query("SELECT 
//                            m.id_macchina,
//                            m.cod_stab,
//                            m.descri_stab,
//                            a.gruppo,
//                            a.geografico
//                         FROM  serverdb.gruppo g JOIN serverdb.comune c JOIN serverdb.macchina m
//                         INNER JOIN serverdb.anagrafe_macchina a ON m.id_macchina=a.id_macchina
//                         WHERE 
//                                 (
//                                            CASE 
//                                                WHEN (a.gruppo = g.livello_6) THEN 64 
//                                                WHEN (a.gruppo = g.livello_5) THEN 32 
//                                                WHEN (a.gruppo = g.livello_4) THEN 16 
//                                                WHEN (a.gruppo = g.livello_3) THEN 8 
//                                                WHEN (a.gruppo = g.livello_2) THEN 4 
//                                                WHEN (a.gruppo = g.livello_1) THEN 2 
//                                                END 
//                                                <= 
//                                                CASE 
//                                                WHEN (@Gruppo = g.livello_6) THEN 64 
//                                                WHEN (@Gruppo = g.livello_5) THEN 32 
//                                                WHEN (@Gruppo = g.livello_4) THEN 16
//                                                WHEN (@Gruppo = g.livello_3) THEN 8 
//                                                WHEN (@Gruppo = g.livello_2) THEN 4 
//                                                WHEN (@Gruppo = g.livello_1) THEN 2 
//                                                END 
//                                            AND 
//                                                ((a.gruppo = g.livello_1) OR 
//                                                (a.gruppo = g.livello_2) OR 
//                                                (a.gruppo = g.livello_3) OR 
//                                                (a.gruppo = g.livello_4) OR 
//                                                (a.gruppo = g.livello_5) OR 
//                                                (a.gruppo = g.livello_6)) 
//                                            AND
//                                                ((@Gruppo = g.livello_1) OR 
//                                                (@Gruppo = g.livello_2) OR 
//                                                (@Gruppo = g.livello_3) OR 
//                                                (@Gruppo = g.livello_4) OR 
//                                                (@Gruppo = g.livello_5) OR 
//                                                (@Gruppo = g.livello_6)) 
//                                )
//                            AND 
//                                (
//                                   CASE                     
//                                       WHEN (a.geografico = c.mondo) THEN 64 
//                                       WHEN (a.geografico = c.continente) THEN 32 
//                                       WHEN (a.geografico = c.stato) THEN 16 
//                                       WHEN (a.geografico = c.regione) THEN 8 
//                                       WHEN (a.geografico = c.provincia) THEN 4 
//                                       WHEN (a.geografico = c.comune) THEN 2 
//                                        END 
//                                        <= 
//                                        CASE 
//                                        WHEN (@Geografico = c.mondo) THEN 64 
//                                        WHEN (@Geografico = c.continente) THEN 32 
//                                        WHEN (@Geografico = c.stato) THEN 16 
//                                        WHEN (@Geografico = c.regione) THEN 8 
//                                        WHEN (@Geografico = c.provincia) THEN 4 
//                                        WHEN (@Geografico = c.comune) THEN 2 
//                                        END 
//                                    AND 
//                                       ((@Geografico = c.mondo) OR 
//                                        (@Geografico = c.continente) OR 
//                                        (@Geografico = c.stato) OR 
//                                        (@Geografico = c.regione) OR 
//                                        (@Geografico = c.provincia) OR 
//                                        (@Geografico = c.comune)) 
//                                    AND 
//                                       ((a.geografico = c.mondo) OR 
//                                        (a.geografico = c.continente) OR 
//                                        (a.geografico = c.stato) OR 
//                                        (a.geografico = c.regione) OR 
//                                        (a.geografico = c.provincia) OR 
//                                        (a.geografico = c.comune)) 
//                                  )
//                                 AND 
//                                    m.id_macchina LIKE CONCAT('%',@IdMacchina,'%')  
//                                AND 
//                                    m.cod_stab LIKE CONCAT('%',@Codice,'%')
//                                AND 
//                                    m.descri_stab LIKE CONCAT('%',@DescriStab,'%') 
//                                GROUP BY m.id_macchina
//                                ORDER BY ".$filtro)                                            
//
//       or die("ERROR IN script_macchina- FUNCTION selectMacchinaSp - SELECT   FROM  gruppo g JOIN comune c JOIN macchina m: " . mysql_error());
//  
//  return $sql;
//}
//*********************************************NEW

/**
 * Modifica le informazioni di una macchina nella tabella macchina di serverdb solo se sono realmente cambiate
 * @param type $codiceStab
 * @param type $descriStab
 * @param type $ragSo1
 * @param type $userOrigami
 * @param type $userServer
 * @param type $passOrigami
 * @param type $passServer
 * @param type $userFtp
 * @param type $passFtp
 * @param type $passZip
 * @param type $abilitato
 * @param type $idMacchina
 * @return type
 */
function modificaMacchina($codiceStab,$descriStab,$ragSo1,$userOrigami,$userServer,$passOrigami,$passServer,$userFtp,$passFtp,$passZip,$abilitato,$idMacchina,$idAzienda) {
    $stringSql = "UPDATE serverdb.macchina SET     
                    cod_stab=if(cod_stab != '" . $codiceStab . "','" . $codiceStab . "',cod_stab),
                    descri_stab=if(descri_stab != '" . $descriStab . "','" . $descriStab . "',descri_stab),
                    ragso1=if(ragso1 != '" . $ragSo1 . "','" . $ragSo1 . "',ragso1),    
                    user_origami=if(user_origami != '" . $userOrigami . "','" . $userOrigami . "',user_origami),
                    user_server=if(user_server != '" . $userServer . "','" . $userServer . "',user_server),
                    pass_origami=if(pass_origami != '" . $passOrigami . "','" . $passOrigami . "',pass_origami),
                    pass_server=if(pass_server != '" . $passServer . "','" . $passServer . "',pass_server),
                    ftp_user=if(ftp_user != '" . $userFtp . "','" . $userFtp . "',ftp_user),
                    ftp_password=if(ftp_password != '" . $passFtp . "','" . $passFtp . "',ftp_password),    
                    zip_password=if(zip_password != '" . $passZip . "','" . $passZip . "',zip_password),
                    abilitato='" . $abilitato . "',
                    id_azienda=if(id_azienda != '" . $idAzienda . "','" . $idAzienda . "',id_azienda)    
                        WHERE id_macchina=" . $idMacchina;
    $sql = mysql_query($stringSql);
            //or die("ERROR IN script_macchina - FUNCTION modificaMacchina - " . $stringSql . " - " . mysql_error());
    return $sql;
}

/**
 * Seleziona tutte le informazioni anagrafiche di una macchina 
 * ricercando per id_macchina 
 * @param unknown $idMacchina
 * @return resource
 */
function selectAllInfoMacchinaById($idMacchina) {
    $sqlString = "SELECT
                                            m.id_macchina,
                                            m.cod_stab,
                                            m.descri_stab,
                                            m.ragso1,
                                            a.id_cliente_gaz,
                                            a.geografico,
                                            a.tipo_riferimento,
                                            a.gruppo,
                                            a.livello_gruppo,
                                            a.id_lingua,
                                            l.lingua,
                                            m.user_origami,
                                            m.user_server,
                                            m.pass_origami,
                                            m.pass_server,
                                            m.ftp_user,
                                            m.ftp_password,
                                            m.zip_password,
                                            m.abilitato,
                                            m.dt_abilitato,
                                            m.id_utente,
                                            m.id_azienda
                                    FROM
                                            serverdb.macchina m
                                    JOIN serverdb.anagrafe_macchina a
                                    ON 
                                            m.id_macchina = a.id_macchina
                                    JOIN serverdb.lingua l
                                    ON 
                                            a.id_lingua = l.id_lingua
                                    WHERE 
                                            m.id_macchina=" . $idMacchina;

    $sql = mysql_query($sqlString) or die("ERROR IN script_macchina - FUNCTION selectMacchinaLeftJoinById - " . $sqlString . " " . mysql_error());
    return $sql;
}

function insertNewMacchina($idMacchina, $codiceStab, $descriStab, $ragso1, $abilitato, $dtAbilitato, $userOrigami, $userServer, $passOrigami, $passServer, $userFtp, $passFtp, $passZip, $idUtente, $idAzienda) {

    $sqlString = "INSERT INTO serverdb.macchina (
                          id_macchina,  
                          cod_stab,
                          descri_stab,
                          ragso1,
                          abilitato,
                          dt_abilitato,
                          user_origami,
                          user_server,
                          pass_origami,
                          pass_server,
                          ftp_user,
                          ftp_password,
                          zip_password,
                          id_utente,
                          id_azienda
                          ) 
					VALUES (" . $idMacchina . ",
                                                '" . $codiceStab . "',
                                                '" . $descriStab . "',
                                                '" . $ragso1 . "',
                                                " . $abilitato . ",
                                                '" . $dtAbilitato . "',
                                                '" . $userOrigami . "',
                                                '" . $userServer . "',
                                                '" . $passOrigami . "',
                                                '" . $passServer . "',
                                                '" . $userFtp . "',
						'" . $passFtp . "',
                                                '" . $passZip . "',
                                                 " . $idUtente . ",
                                                 " . $idAzienda . ")";
    $sql = mysql_query($sqlString);
    //or die("ERROR IN script_macchina - FUNCTION insertNewMacchina - ".$sqlString ." ". mysql_error());
    return $sql;
}

//##############################################################################
//######################### STORICO ############################################
//##############################################################################

/**
 * Inserimento nella tabella macchina del db storico di un record 
 * @param type $idMacchina
 * @return type
 */
function storicizzaMacchina($idMacchina) {


    $stringSql = "INSERT INTO storico.macchina	
                            (id_macchina,
                                cod_stab,
                                descri_stab,
                                ragso1,
                                user_origami,
                                user_server,
                                pass_origami,
                                pass_server,
                                abilitato,
                                dt_abilitato)
                         SELECT 	     						
                                id_macchina,
                                cod_stab,
                                descri_stab,
                                ragso1,                                
                                user_origami,
                                user_server,
                                pass_origami,
                                pass_server,
				abilitato,
                                dt_abilitato
                        FROM 
                                serverdb.macchina
                        WHERE 
                                id_macchina=" . $idMacchina;

    $sql = mysql_query($stringSql);
    //or die("ERROR IN script_macchina - FUNCTION storicizzaMacchina - ".$sqlString ." ". mysql_error());
    return $sql;
}

?>
