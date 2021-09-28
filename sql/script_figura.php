<?php

//##################### GESTIONE FIGURE ########################################
/**
 * Funzione che chiama la stored procedure serverdb.SELECT_FIGURE
 *  
 * @param type $Codice
 * @param type $Figura
 * @param type $Gruppo
 * @param type $Geografico
 * @param type $DtAbilitato
 * @param type $Filtro
 * @return l'elenco delle figure selezionate in base ai parametri 
 */
function selectFigureSp($Nominativo, $Codice, $Figura, $Gruppo, $Geografico, $DtAbilitato, $Filtro,$strUtentiAziende) {

  mysql_query("SET  @Nominativo='" . $Nominativo . "', 
                    @Codice='" . $Codice . "',
                    @Figura='" . $Figura . "',
                    @Gruppo='" . $Gruppo . "',
                    @Geografico='" . $Geografico . "',
                    @DtAbilitato='" . $DtAbilitato . "',
                    @Filtro='" . $Filtro . "'");
 
  $stringSql="SELECT 
id_figura,                            
f.nominativo,
                            f.codice,
                            ft.figura,
                            f.dt_abilitato,
                            f.gruppo,
                            f.geografico                          
                         FROM  serverdb.gruppo g JOIN serverdb.comune c JOIN serverdb.figura f
                         INNER JOIN figura_tipo ft ON ft.id_figura_tipo=f.id_figura_tipo
                            WHERE 
                                 (
                                            CASE 
                                                WHEN (f.gruppo = g.livello_6) THEN 64 
                                                WHEN (f.gruppo = g.livello_5) THEN 32 
                                                WHEN (f.gruppo = g.livello_4) THEN 16 
                                                WHEN (f.gruppo = g.livello_3) THEN 8 
                                                WHEN (f.gruppo = g.livello_2) THEN 4 
                                                WHEN (f.gruppo = g.livello_1) THEN 2 
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
                                                ((f.gruppo = g.livello_1) OR 
                                                (f.gruppo = g.livello_2) OR 
                                                (f.gruppo = g.livello_3) OR 
                                                (f.gruppo = g.livello_4) OR 
                                                (f.gruppo = g.livello_5) OR 
                                                (f.gruppo = g.livello_6)) 
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
                                       WHEN (f.geografico = c.mondo) THEN 64 
                                       WHEN (f.geografico = c.continente) THEN 32 
                                       WHEN (f.geografico = c.stato) THEN 16 
                                       WHEN (f.geografico = c.regione) THEN 8 
                                       WHEN (f.geografico = c.provincia) THEN 4 
                                       WHEN (f.geografico = c.comune) THEN 2 
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
                                       ((f.geografico = c.mondo) OR 
                                        (f.geografico = c.continente) OR 
                                        (f.geografico = c.stato) OR 
                                        (f.geografico = c.regione) OR 
                                        (f.geografico = c.provincia) OR 
                                        (f.geografico = c.comune)) 
                                  )
                                AND 
                                    f.nominativo LIKE CONCAT('%',@Nominativo,'%')
                                AND 
                                    f.codice LIKE CONCAT('%',@Codice,'%')
                                AND
                                    ft.figura LIKE CONCAT('%',@Figura,'%') 
                                AND 
                                    f.dt_abilitato LIKE CONCAT('%',@DtAbilitato,'%') 
                               AND 
                                   (f.id_utente,f.id_azienda) IN ".$strUtentiAziende."
                               AND f.abilitato=1        
                                GROUP BY f.id_figura
                                ORDER BY 
                                    CASE WHEN @Filtro='nominativo' THEN f.nominativo END ASC ,
                                    CASE WHEN @Filtro='figura' THEN ft.figura END ASC,
                                    CASE WHEN @Filtro='gruppo' THEN f.gruppo END ASC,
                                    CASE WHEN @Filtro='geografico' THEN f.geografico END ASC,
                                    CASE WHEN @Filtro='codice' THEN f.codice END ASC,
                                    CASE WHEN @Filtro='dt_abilitato' THEN f.dt_abilitato END ASC";
  
  
  
  
//  $sql = mysql_query("CALL serverdb.SELECT_FIGURE(@Nominativo,
//                                            @Codice,
//                                            @Figura,
//                                            @Gruppo,
//                                            @Geografico,
//                                            @DtAbilitato,
//                                            @Filtro);") 
//          or die("ERROR IN script_figura - FUNCTION selectFigureSp - CALL serverdb.figura3 : " . mysql_error());
$sql=mysql_query($stringSql) or die("ERROR IN script_figura - FUNCTION selectFigureSp -  " .$stringSql." ". mysql_error());
  return $sql;
}



function selectFromFigura($campoOrdine,$campoGroupBy,$stringUtentiAziende) {
 $stringSql="SELECT * FROM serverdb.figura f JOIN figura_tipo ft ON ft.id_figura_tipo=f.id_figura_tipo
                    WHERE f.abilitato=1 
                    AND 
                        (id_utente,id_azienda) IN ".$stringUtentiAziende."
                    GROUP BY ".$campoGroupBy." 
                    ORDER BY ".$campoOrdine;
  $sql = mysql_query($stringSql) 
          or die("ERROR IN script_figura - FUNCTION selectGruppiFromFigura - " .$stringSql ."  ". mysql_error());

  return $sql;
}



function selectUtenteFigura($idUtente) {

  $sql = mysql_query("SELECT f.gruppo,f.geografico FROM figura f 
                        INNER JOIN utente_figura u
                        ON f.id_figura=u.id_figura 
                        WHERE u.id_utente=".$idUtente) 
          or die("ERROR IN script_figura - FUNCTION selectUtenteFigura - SELECT FROM serverdb.utente_figura : " . mysql_error());

  return $sql;
}



/**
 * Seleziona tutte le figure di un dato tipo,gruppo e riferimento geografico
 * @param type $Gruppo
 * @param type $RifGeo
 * @return type
 */
function selectFigureByGruppoGeoTipo($Gruppo, $RifGeo, $tipoFigura) {
  mysql_query("SET @Gruppo='" . $Gruppo . "', @Geografico='" . $RifGeo . "',@TipoOperatore=".$tipoFigura);
  $sql = mysql_query("SELECT f.id_figura,f.codice,f.nominativo                           
                         FROM  gruppo g JOIN comune c JOIN figura f
                         WHERE 
                           f.id_figura_tipo=@TipoOperatore
                             AND 
                             (
                                            CASE 
                                                WHEN (f.gruppo = g.livello_6) THEN 64 
                                                WHEN (f.gruppo = g.livello_5) THEN 32 
                                                WHEN (f.gruppo = g.livello_4) THEN 16 
                                                WHEN (f.gruppo = g.livello_3) THEN 8 
                                                WHEN (f.gruppo = g.livello_2) THEN 4 
                                                WHEN (f.gruppo = g.livello_1) THEN 2 
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
                                                ((f.gruppo = g.livello_1) OR 
                                                (f.gruppo = g.livello_2) OR 
                                                (f.gruppo = g.livello_3) OR 
                                                (f.gruppo = g.livello_4) OR 
                                                (f.gruppo = g.livello_5) OR 
                                                (f.gruppo = g.livello_6)) 
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
                                       WHEN (f.geografico = c.mondo) THEN 64 
                                       WHEN (f.geografico = c.continente) THEN 32 
                                       WHEN (f.geografico = c.stato) THEN 16 
                                       WHEN (f.geografico = c.regione) THEN 8 
                                       WHEN (f.geografico = c.provincia) THEN 4 
                                       WHEN (f.geografico = c.comune) THEN 2 
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
                                       ((f.geografico = c.mondo) OR 
                                        (f.geografico = c.continente) OR 
                                        (f.geografico = c.stato) OR 
                                        (f.geografico = c.regione) OR 
                                        (f.geografico = c.provincia) OR 
                                        (f.geografico = c.comune)) 
                                  )
                                GROUP BY f.id_figura
                                ORDER BY f.nominativo;");
//          or die("ERROR IN script_figura - FUNCTION selectOperatoriByGruppoGeoFromFigura - SELECT FROM serverdb.figura : " . mysql_error());


  return $sql;
}

/**
 * Seleziona le figure di un dato tipo appartenenti ad un dato rif geografico e gruppo visibili
 * @param type $Gruppo
 * @param type $RifGeo
 * @param type $tipoFigura
 * @return type
 */
function selectFigureByGruppoGeoTipoVis($Gruppo, $RifGeo, $tipoFigura,$strUtentiAziende) {
  mysql_query("SET @Gruppo='" . $Gruppo . "', @Geografico='" . $RifGeo . "',@TipoOperatore=".$tipoFigura);
  $sql = mysql_query("SELECT f.id_figura,f.codice,f.nominativo                           
                         FROM  gruppo g JOIN comune c JOIN figura f
                         WHERE 
                           f.id_figura_tipo=@TipoOperatore
                             AND 
                             (
                                            CASE 
                                                WHEN (f.gruppo = g.livello_6) THEN 64 
                                                WHEN (f.gruppo = g.livello_5) THEN 32 
                                                WHEN (f.gruppo = g.livello_4) THEN 16 
                                                WHEN (f.gruppo = g.livello_3) THEN 8 
                                                WHEN (f.gruppo = g.livello_2) THEN 4 
                                                WHEN (f.gruppo = g.livello_1) THEN 2 
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
                                                ((f.gruppo = g.livello_1) OR 
                                                (f.gruppo = g.livello_2) OR 
                                                (f.gruppo = g.livello_3) OR 
                                                (f.gruppo = g.livello_4) OR 
                                                (f.gruppo = g.livello_5) OR 
                                                (f.gruppo = g.livello_6)) 
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
                                       WHEN (f.geografico = c.mondo) THEN 64 
                                       WHEN (f.geografico = c.continente) THEN 32 
                                       WHEN (f.geografico = c.stato) THEN 16 
                                       WHEN (f.geografico = c.regione) THEN 8 
                                       WHEN (f.geografico = c.provincia) THEN 4 
                                       WHEN (f.geografico = c.comune) THEN 2 
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
                                       ((f.geografico = c.mondo) OR 
                                        (f.geografico = c.continente) OR 
                                        (f.geografico = c.stato) OR 
                                        (f.geografico = c.regione) OR 
                                        (f.geografico = c.provincia) OR 
                                        (f.geografico = c.comune)) 
                                  )
                                AND
                                (f.id_utente,f.id_azienda) IN ".$strUtentiAziende."
                                AND f.abilitato=1    
                                GROUP BY f.id_figura
                                ORDER BY f.nominativo;");
//          or die("ERROR IN script_figura - FUNCTION selectOperatoriByGruppoGeoFromFigura - SELECT FROM serverdb.figura : " . mysql_error());


  return $sql;
}




/**
 * Seleziona tutte le figure di un dato gruppo e riferimento geografico e diverse dal tipo di figura passato come parametro
 * @param type $Gruppo
 * @param type $RifGeo
 * @return type
 */
function selectFigureByGruppoGeoDiverseDaTipo($Gruppo, $RifGeo, $tipoFigura) {
  mysql_query("SET @Gruppo='" . $Gruppo . "', @Geografico='" . $RifGeo . "',@TipoOperatore=".$tipoFigura);
  $sql = mysql_query("SELECT f.id_figura,f.codice,f.nominativo                           
                         FROM  gruppo g JOIN comune c JOIN figura f
                         WHERE 
                           f.id_figura_tipo<>@TipoOperatore
                             AND 
                             (                        
                              CASE 
                                                WHEN (f.gruppo = g.livello_6) THEN 64 
                                                WHEN (f.gruppo = g.livello_5) THEN 32 
                                                WHEN (f.gruppo = g.livello_4) THEN 16 
                                                WHEN (f.gruppo = g.livello_3) THEN 8 
                                                WHEN (f.gruppo = g.livello_2) THEN 4 
                                                WHEN (f.gruppo = g.livello_1) THEN 2 
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
                                                ((f.gruppo = g.livello_1) OR 
                                                (f.gruppo = g.livello_2) OR 
                                                (f.gruppo = g.livello_3) OR 
                                                (f.gruppo = g.livello_4) OR 
                                                (f.gruppo = g.livello_5) OR 
                                                (f.gruppo = g.livello_6)) 
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
                                       WHEN (f.geografico = c.mondo) THEN 64 
                                       WHEN (f.geografico = c.continente) THEN 32 
                                       WHEN (f.geografico = c.stato) THEN 16 
                                       WHEN (f.geografico = c.regione) THEN 8 
                                       WHEN (f.geografico = c.provincia) THEN 4 
                                       WHEN (f.geografico = c.comune) THEN 2 
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
                                       ((f.geografico = c.mondo) OR 
                                        (f.geografico = c.continente) OR 
                                        (f.geografico = c.stato) OR 
                                        (f.geografico = c.regione) OR 
                                        (f.geografico = c.provincia) OR 
                                        (f.geografico = c.comune)) 
                                  )
                                GROUP BY f.id_figura
                                ORDER BY f.nominativo;");
//          or die("ERROR IN script_figura - FUNCTION selectOperatoriByGruppoGeoFromFigura - SELECT FROM serverdb.figura : " . mysql_error());


  return $sql;
}

/**
 * Seleziona tutte le figure diverse da un dato tipo, appartenenti 
 * ad un dato rif geografico e gruppo visibili
 * @param type $Gruppo
 * @param type $RifGeo
 * @param type $tipoFigura
 * @param type $strUtentiAziende
 * @return type
 */
function selectFigureByGruppoGeoDiverseDaTipo2($Gruppo, $RifGeo, $tipoFigura,$strUtentiAziende) {
  mysql_query("SET @Gruppo='" . $Gruppo . "', @Geografico='" . $RifGeo . "',@TipoOperatore=".$tipoFigura);
  $sql = mysql_query("SELECT f.id_figura,f.codice,f.nominativo                           
                         FROM  gruppo g JOIN comune c JOIN figura f
                         WHERE 
                           f.id_figura_tipo<>@TipoOperatore
                             AND 
                             (                        
                              CASE 
                                                WHEN (f.gruppo = g.livello_6) THEN 64 
                                                WHEN (f.gruppo = g.livello_5) THEN 32 
                                                WHEN (f.gruppo = g.livello_4) THEN 16 
                                                WHEN (f.gruppo = g.livello_3) THEN 8 
                                                WHEN (f.gruppo = g.livello_2) THEN 4 
                                                WHEN (f.gruppo = g.livello_1) THEN 2 
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
                                                ((f.gruppo = g.livello_1) OR 
                                                (f.gruppo = g.livello_2) OR 
                                                (f.gruppo = g.livello_3) OR 
                                                (f.gruppo = g.livello_4) OR 
                                                (f.gruppo = g.livello_5) OR 
                                                (f.gruppo = g.livello_6)) 
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
                                       WHEN (f.geografico = c.mondo) THEN 64 
                                       WHEN (f.geografico = c.continente) THEN 32 
                                       WHEN (f.geografico = c.stato) THEN 16 
                                       WHEN (f.geografico = c.regione) THEN 8 
                                       WHEN (f.geografico = c.provincia) THEN 4 
                                       WHEN (f.geografico = c.comune) THEN 2 
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
                                       ((f.geografico = c.mondo) OR 
                                        (f.geografico = c.continente) OR 
                                        (f.geografico = c.stato) OR 
                                        (f.geografico = c.regione) OR 
                                        (f.geografico = c.provincia) OR 
                                        (f.geografico = c.comune)) 
                                  )
                                  AND
                                  (f.id_utente,f.id_azienda) IN ".$strUtentiAziende."
                                  AND
                                    f.abilitato=1
                                GROUP BY f.id_figura
                                ORDER BY f.nominativo ;");
//          or die("ERROR IN script_figura - FUNCTION selectOperatoriByGruppoGeoFromFigura - SELECT FROM serverdb.figura : " . mysql_error());


  return $sql;
}





/**
 * Genera in maniera random un codice alfanumerico di 16 cifre utilizzando
 *  l'algoritmo crittografico MD5
 * @return type
 */

function generaCodice() {

  $sql = mysql_query("SELECT SUBSTRING(MD5(RAND()) FROM 1 FOR 16) AS codice") 
          or die("ERROR IN script_figura - FUNCTION generaCodice - SELECT SUBSTRING(MD5(RAND()) FROM 1 FOR 16)" . mysql_error());

  return $sql;
}


/**
 * Verifca se il codice è già presente nell tabella figura 
 * @param type $codice
 * @return type
 */
function findFiguraByCodice($codice){
    
    $stringSql="SELECT * FROM serverdb.figura WHERE codice='" . $codice . "'";
  
    $sql=mysql_query($stringSql) 
          or die("ERROR IN script_figura - FUNCTION findFiguraByCodice -  " .$stringSql." ". mysql_error());
  
  return $sql;
}


function insertNuovaFigura($figuraTipo,$nome,$cognome,$codice,$geografico,$tipoRiferimento,$gruppo,$livelloGruppo,$idUtente,$idAzienda){
  
   $sql = mysql_query("INSERT INTO serverdb.figura (id_figura_tipo,
                                           nominativo,
                                           codice,
                                           geografico,
                                           tipo_riferimento,
                                           gruppo,
                                           livello_gruppo,
                                           abilitato,id_utente,id_azienda) 
                        VALUES ( " . $figuraTipo . ",
                                 '" . $nome . " " . $cognome . "',
                                 '" . $codice . "',
                                 '" . $geografico . "',
                                 '" . $tipoRiferimento . "',
                                 '" . $gruppo . "',
                                 '" . $livelloGruppo . "',
                                 1,
                                 ".$idUtente.",
                                 ".$idAzienda.") ") ;
//          or die("ERROR IN script_figura - FUNCTION insertNuovaFigura - " . mysql_error());
  
  
  return $sql;
}



function selectMaxIdFiguraFromFigura(){
  
   $sql = mysql_query("SELECT MAX(id_figura) AS id_figura FROM serverdb.figura") 
           or die("ERROR IN script_figura - FUNCTION insertNuovUtenteFigura - INSERT INTO utente_figura" . mysql_error());
  
  
  return $sql;
}


?>
