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
function selectFigureSp($Nominativo, $Codice, $Figura, $Gruppo, $Geografico, $DtAbilitato, $Filtro) {

  mysql_query("SET  @Nominativo='" . $Nominativo . "', 
                    @Codice='" . $Codice . "',
                    @Figura='" . $Figura . "',
                    @Gruppo='" . $Gruppo . "',
                    @Geografico='" . $Geografico . "',
                    @DtAbilitato='" . $DtAbilitato . "',
                    @Filtro='" . $Filtro . "'");

  $sql = mysql_query("CALL serverdb.SELECT_FIGURE(@Nominativo,
                                            @Codice,
                                            @Figura,
                                            @Gruppo,
                                            @Geografico,
                                            @DtAbilitato,
                                            @Filtro);") or die("ERROR IN script_figura - FUNCTION selectFigureSp - CALL serverdb.figura3 : " . mysql_error());

  return $sql;
}

function selectGruppiFromFigura() {

  $sql = mysql_query("SELECT gruppo FROM figura WHERE abilitato=1 GROUP BY gruppo ORDER BY gruppo") or die("ERROR IN script_figura - FUNCTION selectGruppiFromFigura - SELECT gruppo FROM serverdb.figura : " . mysql_error());

  return $sql;
}

function selectGeoFromFigura() {

  $sql = mysql_query("SELECT geografico FROM figura WHERE abilitato=1 GROUP BY geografico ORDER BY geografico") or die("ERROR IN script_figura - FUNCTION selectGeoFromFigura - SELECT geografico FROM serverdb.figura : " . mysql_error());

  return $sql;
}

function selectNomiFromFigura() {

  $sql = mysql_query("SELECT nominativo FROM figura WHERE abilitato=1 GROUP BY nominativo ORDER BY nominativo") or die("ERROR IN script_figura - FUNCTION selectNomiFromFigura - SELECT nominativo FROM serverdb.figura : " . mysql_error());

  return $sql;
}

function selectFiguraFromFigura() {

  $sql = mysql_query("SELECT ft.figura FROM figura f
                         INNER JOIN figura_tipo ft ON ft.id_figura_tipo=f.id_figura_tipo
                         WHERE f.abilitato=1 GROUP BY figura ORDER BY figura") or die("ERROR IN script_figura - FUNCTION selectFiguraFromFigura - SELECT ft.figura FROM serverdb.figura : " . mysql_error());

  return $sql;
}

function selectCodiceFromFigura() {
  $sql = mysql_query("SELECT codice FROM figura f WHERE f.abilitato=1 GROUP BY codice ORDER BY codice") or die("ERROR IN script_figura - FUNCTION selectCodiceFromFigura - SELECT codice FROM serverdb.figura : " . mysql_error());

  return $sql;
}

function selectDtAbilitatoFromFigura() {
  $sql = mysql_query("SELECT dt_abilitato FROM figura f WHERE f.abilitato=1 GROUP BY dt_abilitato ORDER BY dt_abilitato") or die("ERROR IN script_figura - FUNCTION selectDtAbilitatoFromFigura - SELECT dt_abilitato FROM serverdb.figura : " . mysql_error());

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
function verificaEsistenzaCodice($codice){
    
  $sql=mysql_query("SELECT codice FROM figura WHERE codice='" . $codice . "'") ;
          //or die("ERROR IN script_figura - FUNCTION verificaEsistenzaCodice - SELECT codice FROM figura " . mysql_error());
  
  return $sql;
}


function insertNuovaFigura($figuraTipo,$nome,$cognome,$codice,$geografico,$tipoRiferimento,$gruppo,$livelloGruppo){
  
   $sql = mysql_query("INSERT INTO figura (id_figura_tipo,
                                           nominativo,
                                           codice,
                                           geografico,
                                           tipo_riferimento,
                                           gruppo,
                                           livello_gruppo,
                                           abilitato) 
                        VALUES ( " . $figuraTipo . ",
                                 '" . $nome . " " . $cognome . "',
                                 '" . $codice . "',
                                 '" . $geografico . "',
                                 '" . $tipoRiferimento . "',
                                 '" . $gruppo . "',
                                 '" . $livelloGruppo . "',
                                  1) ") ;
//          or die("ERROR IN script_figura - FUNCTION insertNuovaFigura - INSERT INTO figura" . mysql_error());
  
  
  return $sql;
}



function selectMaxIdFiguraFromFigura(){
  
   $sql = mysql_query("SELECT MAX(id_figura) AS id_figura FROM figura") 
           or die("ERROR IN script_figura - FUNCTION insertNuovUtenteFigura - INSERT INTO utente_figura" . mysql_error());
  
  
  return $sql;
}


?>
