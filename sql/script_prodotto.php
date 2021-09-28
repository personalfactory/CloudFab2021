<?php

//Tabelle coinvolte:
//prodotto
//anagrafe_prodotto
//categoria
//mazzetta
//codice

/**
 * Seleziona tutte le informazioni di un prodotto dalle tabelle prodotto,
 * anagrafe_prodotto, mazzetta, categoria
 * @param type $idProdotto
 * @return type
 */
function findAllDatiProdottoById($idProdotto) {

    $stringSql = "SELECT 
                                p.cod_prodotto,
                                p.nome_prodotto,
                                a.colorato,
                                a.lim_colore,
                                a.fattore_div,
                                a.fascia,
                                m.id_mazzetta,
                                m.cod_mazzetta,
                                m.nome_mazzetta,
                                a.geografico,
                                a.tipo_riferimento,
                                a.gruppo,
                                a.livello_gruppo,
                                c.id_cat,
                                c.nome_categoria,
                                a.abilitato,
                                p.dt_abilitato,
                                p.id_azienda,
                                p.id_utente,
                                p.serie_colore,
                                p.serie_additivo
                                
                        FROM
                                serverdb.prodotto p 
                        INNER JOIN serverdb.anagrafe_prodotto a
                        ON 
                                p.id_prodotto = a.id_prodotto
                        INNER JOIN serverdb.categoria c
                        ON 
                                a.id_cat = c.id_cat
                        INNER JOIN serverdb.mazzetta m
                        ON 
                                a.id_mazzetta = m.id_mazzetta
                        WHERE 
                                p.id_prodotto=" . $idProdotto;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_prodotto.php - FUNCTION findAllDatiProdottoById - " . $stringSql . " - " . mysql_error());
    return $sql;
}

/**
 * Seleziona un prodotto dalla tabella prodotto tramite il suo id_prodotto
 * @param type $idProdotto
 * @return type
 */
function findProdottoById($idProdotto) {

    $strinSql = "SELECT * FROM serverdb.prodotto WHERE id_prodotto=" . $idProdotto;
    $sql = mysql_query($strinSql) or die("ERROR IN script_prodotto.php - FUNCTION findProdottoById - " . $strinSql . " - " . mysql_error());
    return $sql;
}

/**
 * Seleziona un prodotto per codice
 * @param type $codProdotto
 * @return type
 */
function findProdottoByCodice($codProdotto) {
    $sql = mysql_query("SELECT * FROM serverdb.prodotto WHERE cod_prodotto='" . $codProdotto . "'");
//or die("ERROR IN script_prodotto.php - FUNCTION findProdottoByCodice - SELECT FROM serverdb.prodotto: " . mysql_error());
    return $sql;
}

/**
 * Seleziona un prodotto per codice e nome
 * @param type $codProdotto
 * @param type $nomeProdotto
 * @return type
 */
function findProdottoByCodiceNome($codProdotto, $nomeProdotto) {
    $sql = mysql_query("SELECT * FROM serverdb.prodotto WHERE cod_prodotto='" . $codProdotto . "' OR nome_prodotto='" . $nomeProdotto . "'");
//or die("ERROR IN script_prodotto.php - FUNCTION findProdottoByCodiceNome - SELECT FROM serverdb.prodotto: " . mysql_error());
    return $sql;
}

/**
 * Seleziona il numero massimo del codice avente come prefisso l'argomento
 * @param type $prefissoCodice
 * @return type
 */
function selectMaxNumCodProd($prefissoCodice) {
    $sql = mysql_query("SELECT SUBSTR(MAX(cod_prodotto),4) AS num_max_cod_prod
                    FROM 
                            serverdb.prodotto
                    WHERE 
                            MID(cod_prodotto,1,3 )='" . $prefissoCodice . "'")
            or die("ERROR IN script_prodotto.php - FUNCTION selectMaxNumCodProd - SELECT SUBSTR(MAX(cod_formula),4) FROM serverdb.prodotto " . mysql_error());
    return $sql;
}

/**
 * Seleziona id_prodotto e nome_prodotto di tutti i prodotti (per aggiornamento dizionario)
 * @return resource
 */
function selectIDNomeProdotto() {
    $stringSql = "SELECT 
                            id_prodotto,
                            nome_prodotto
                        FROM 
                            serverdb.prodotto";
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_prodotto.php - selectIDNomeProdotto - " . $stringSql . " " . mysql_error());
    return $sql;
}

/**
 * Seleziona il massimo codice di un prodotto di una data famiglia
 * @param type $tipoCodice
 * @return type
 */
function selectMaxCodByTipo($tipoCodice) {
    $stringSql = "SELECT MAX(cod_prodotto) AS cod_max
                FROM 
                    serverdb.prodotto
                WHERE 
                    MID(cod_prodotto,1,3)='" . $tipoCodice . "'";

    $sql = mysql_query($stringSql)
            or die("ERROR IN script_prodotto.php - selectMaxCodByTipo - " . $stringSql . " " . mysql_error());
    return $sql;
}

/**
 * Inserisce un nuovo prodotto nella tabella prodotto
 * @param type $codice
 * @param type $nome
 * @param type $abilitato
 * @param type $dtAbilitato
 * @param type $tipo
 * @param type $serieColore
 * @param type $serieAdditivo
 * @return type
 */
function insertNuovoProdotto($codice, $nome, $abilitato, $dtAbilitato, $idUtente, $idAzienda, $tipo, $serieColore, $serieAdditivo) {

    $stringSql = "INSERT INTO serverdb.prodotto (cod_prodotto,
                                           nome_prodotto,
                                           abilitato,
                                           dt_abilitato,
                                           id_utente,
                                           id_azienda,
                                           tipo,
                                           serie_colore,
                                           serie_additivo)
                                           VALUES ( 
                                               '" . $codice . "',
                                               '" . $nome . "',
                                               " . $abilitato . ",
                                               '" . $dtAbilitato . "',
                                                " . $idUtente . ",
                                                    " . $idAzienda . ","
            . "'" . $tipo . "',"
            . "'" . $serieColore . "',"
            . "'" . $serieAdditivo . "')";

    $sql = mysql_query($stringSql);
    //or die("ERROR IN script_prodotto.php - insertNuovoProdotto - ".$stringSql." - " . mysql_error());
    return $sql;
}

function findProdottiByFiltri($campoOrdine, $campoGroupBy, $idProdotto, $codProdotto, $nomeProdotto, $prodPadre, $famiglia, $nomeCategoria, $abilitato, $dtAbilitato, $gruppo, $condizioneSelect, $strUtentiAziende) {


    $stringSql = "SELECT 
                        p.id_prodotto AS id_prodotto,
                        p.cod_prodotto AS cod_prodotto,
                        p.nome_prodotto AS nome_prodotto,
                        a.colorato AS colorato,
                        cod.descrizione AS descrizione,
                        c.nome_categoria AS nome_categoria,
                        a.abilitato AS abilitato,
                        a.dt_abilitato,
                        a.gruppo AS gruppo

                    FROM serverdb.prodotto p
                INNER JOIN serverdb.anagrafe_prodotto a
                ON 
                        p.id_prodotto = a.id_prodotto
                  
                INNER JOIN serverdb.categoria c
                ON 
                     a.id_cat = c.id_cat
                INNER JOIN serverdb.codice cod
                ON 
                    a.id_codice = cod.id_codice
                WHERE 
                    p.id_prodotto LIKE '%" . $idProdotto . "%'
                  AND
                    cod_prodotto LIKE '%" . $codProdotto . "%'
                  AND
                    nome_prodotto LIKE '%" . $nomeProdotto . "%'
                  AND
                    colorato LIKE '%" . $prodPadre . "%'   
                  AND
                    cod.descrizione LIKE '%" . $famiglia . "%'      
                  AND
                    nome_categoria LIKE '%" . $nomeCategoria . "%'
                  AND
                    a.abilitato LIKE '%" . $abilitato . "%'
                  AND
                    p.dt_abilitato LIKE '%" . $dtAbilitato . "%'
                  AND
                    gruppo LIKE '%" . $gruppo . "%'      
                  AND
                    " . $condizioneSelect . "
                  AND
                    (p.id_utente,p.id_azienda) IN " . $strUtentiAziende . "                
                GROUP BY " . $campoGroupBy . "
                ORDER BY " . $campoOrdine;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_prodotto.php - findProdottiByFiltri - " . $stringSql . " - " . mysql_error());
    return $sql;
}

/**
 * Seleziona l'elenco dei prodotti dalla tabella prodotto in base 
 * a tutti i filtri dati
 * @param type $campoOrdine
 * @param type $campoGroupBy
 * @param type $idProdotto
 * @param type $codProdotto
 * @param type $nomeProdotto
 * @param type $prodPadre
 * @param type $famiglia
 * @param type $nomeCategoria
 * @param type $abilitato
 * @param type $dtAbilitato
 * @param type $strUtenti
 * @param type $strAziende
 * @return type
 */
//function findProdottiByFiltriTest($campoOrdine,$campoGroupBy,$idProdotto,$codProdotto,$nomeProdotto,$prodPadre,
//        $famiglia,$nomeCategoria,$abilitato,$dtAbilitato,$strUtentiAziende){
//    
//    
//       $stringSql="SELECT 
//                        p.id_prodotto AS id_prodotto,
//                        p.cod_prodotto AS cod_prodotto,
//                        p.nome_prodotto AS nome_prodotto,
//                        a.colorato AS colorato,
//                        cod.descrizione AS descrizione,
//                        c.nome_categoria AS nome_categoria,
//                        a.abilitato AS abilitato,
//                        a.dt_abilitato
//
//                    FROM serverdb.prodotto p
//                INNER JOIN serverdb.anagrafe_prodotto a
//                ON 
//                        p.id_prodotto = a.id_prodotto
//                  
//                INNER JOIN serverdb.categoria c
//                ON 
//                     a.id_cat = c.id_cat
//                INNER JOIN serverdb.codice cod
//                ON 
//                    a.id_codice = cod.id_codice
//                WHERE 
//                    p.id_prodotto LIKE '%".$idProdotto."%'
//                  AND
//                    cod_prodotto LIKE '%".$codProdotto."%'
//                  AND
//                    nome_prodotto LIKE '%".$nomeProdotto."%'
//                  AND
//                    colorato LIKE '%".$prodPadre."%'   
//                  AND
//                    cod.descrizione LIKE '%".$famiglia."%'      
//                  AND
//                    nome_categoria LIKE '%".$nomeCategoria."%'
//                  AND
//                    p.abilitato LIKE '%".$abilitato."%'
//                  AND
//                    p.dt_abilitato LIKE '%".$dtAbilitato."%'
//                  AND
//                    (".$strUtentiAziende.")
//                GROUP BY " . $campoGroupBy . "
//                ORDER BY " . $campoOrdine;
//           $sql = mysql_query($stringSql)
//    or die("ERROR IN script_prodotto.php - findProdottiByFiltri - ".$stringSql." - " . mysql_error());
//	return $sql;
//    
//}

/**
 * Seleziona l'elenco dei prodotti filgi di un dato prodotto
 * dalla tabella prodotto in base a tutti i filtri dati
 * @param type $campoOrdine
 * @param type $campoGroupBy
 * @param type $idProdotto
 * @param type $codProdotto
 * @param type $nomeProdotto
 * @param type $prodPadre
 * @param type $famiglia
 * @param type $nomeCategoria
 * @param type $abilitato
 * @param type $dtAbilitato
 * @return type
 */
function findProdottiFigliByFiltri($campoOrdine, $campoGroupBy, $idProdotto, $codProdotto, $nomeProdotto, $prodPadre, $famiglia, $nomeCategoria, $abilitato, $dtAbilitato, $gruppo, $strUtentiAziende) {


    $stringSql = "SELECT 
                        p.id_prodotto AS id_prodotto,
                        p.cod_prodotto AS cod_prodotto,
                        p.nome_prodotto AS nome_prodotto,
                        a.colorato AS colorato,
                        cod.descrizione AS descrizione,
                        c.nome_categoria AS nome_categoria,
                        a.abilitato AS abilitato,
                        a.dt_abilitato,
                        a.gruppo AS gruppo
                FROM serverdb.prodotto p
                INNER JOIN serverdb.anagrafe_prodotto a
                ON 
                        p.id_prodotto = a.id_prodotto
                  
                INNER JOIN serverdb.categoria c
                ON 
                     a.id_cat = c.id_cat
                INNER JOIN serverdb.codice cod
                ON 
                    a.id_codice = cod.id_codice
                WHERE 
                    colorato = '" . $prodPadre . "'   
                  AND
                    p.id_prodotto LIKE '%" . $idProdotto . "%'
                  AND
                    cod_prodotto LIKE '%" . $codProdotto . "%'
                  AND
                    nome_prodotto LIKE '%" . $nomeProdotto . "%'                  
                  AND
                    cod.descrizione LIKE '%" . $famiglia . "%'      
                  AND
                    nome_categoria LIKE '%" . $nomeCategoria . "%'
                  AND
                    a.abilitato LIKE '%" . $abilitato . "%'
                  AND
                    p.dt_abilitato LIKE '%" . $dtAbilitato . "%'
                  AND
                    gruppo LIKE '%" . $gruppo . "%'      
                  AND
                    (p.id_utente,p.id_azienda) IN " . $strUtentiAziende . "     
                GROUP BY " . $campoGroupBy . "
                ORDER BY " . $campoOrdine;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_prodotto.php - findProdottiByFiltri - " . $stringSql . " - " . mysql_error());
    return $sql;
}

/**
 * Verifica se nella tabella prodotto c'è un prodotto con id diverso da quello dato
 * e stesso codice o nome
 * @param type $idProdotto
 * @param type $codProdotto
 * @param type $nomeProdotto
 * @return type
 */
function findProdottoDiversoDaId($idProdotto, $codProdotto, $nomeProdotto) {

    $strinSql = "SELECT * FROM serverdb.prodotto WHERE 
                id_prodotto<>" . $idProdotto . " 
            AND 
                (cod_prodotto = '" . $codProdotto . "' OR nome_prodotto='" . $nomeProdotto . "')";
    $sql = mysql_query($strinSql) or die("ERROR IN script_prodotto.php - FUNCTION findProdottoByIdCod - " . $strinSql . " - " . mysql_error());
    return $sql;
}

//function findProdottiPadreByFiltri($campoOrdine,$campoGroupBy,$idProdotto,$codProdotto,$nomeProdotto,$prodPadre,$nomeCategoria,$abilitato,$dtAbilitato,$strProdPadre){
//    
//    
//    $stringSql="SELECT * FROM serverdb.prodotto p
//                INNER JOIN serverdb.anagrafe_prodotto a
//                ON 
//                        p.id_prodotto = a.id_prodotto
//                INNER JOIN serverdb.categoria c
//                ON 
//                     a.id_cat = c.id_cat
//                INNER JOIN serverdb.mazzetta m
//                ON 
//                    a.id_mazzetta = m.id_mazzetta
//                WHERE 
//                    p.id_prodotto LIKE '%".$idProdotto."%'
//                  AND
//                    cod_prodotto LIKE '%".$codProdotto."%'
//                  AND
//                    nome_prodotto LIKE '%".$nomeProdotto."%'
//                  AND
//                    colorato LIKE '%".$prodPadre."%'      
//                  AND
//                    nome_categoria LIKE '%".$nomeCategoria."%'
//                  AND
//                    p.abilitato LIKE '%".$abilitato."%'
//                  AND
//                    p.dt_abilitato LIKE '%".$dtAbilitato."%'
//                  AND 
//                    (p.id_prodotto IN ".$strProdPadre." )
//                GROUP BY " . $campoGroupBy . "
//                ORDER BY " . $campoOrdine;
//           $sql = mysql_query($stringSql)
//    or die("ERROR IN script_prodotto.php - findProdottiPadreByFiltri - ".$stringSql." - " . mysql_error());
//	return $sql;
//    
//}

/**
 * Modifica un prodotto nella tabella prodotto solo se realmente modificato
 * @param type $IdProdotto
 * @param type $CodiceProdotto
 * @param type $NomeProdotto
 * @param type $IdAzienda
 * @return type
 */
function modificaProdotto($idProdotto, $codiceProdotto, $nomeProdotto, $serieColore, $serieAdditivo, $abilitato, $idAzienda) {
    $strinSql = "UPDATE serverdb.prodotto 
            SET 
                    cod_prodotto=if(cod_prodotto!='" . $codiceProdotto . "','" . $codiceProdotto . "',cod_prodotto),
                    nome_prodotto=if(nome_prodotto!='" . $nomeProdotto . "','" . $nomeProdotto . "',nome_prodotto),
                    serie_colore=if(serie_colore!='" . $serieColore . "','" . $serieColore . "',serie_colore),
                    serie_additivo=if(serie_additivo!='" . $serieAdditivo . "','" . $serieAdditivo . "',serie_additivo),
                    id_azienda=if(id_azienda!='" . $idAzienda . "','" . $idAzienda . "',id_azienda),
                    abilitato=if(abilitato!='" . $abilitato . "','" . $abilitato . "',abilitato),
                    dt_abilitato=NOW()    
            WHERE 
                    id_prodotto='" . $idProdotto . "'";
    $sql = mysql_query($strinSql) or die("ERROR IN script_prodotto.php - FUNCTION modificaProdotto - " . $strinSql . " - " . mysql_error());
    return $sql;
}

//##############################################################################
//######################## STORICO #############################################
//##############################################################################

/**
 * Inserisce un prodotto nel db storico
 * @param type $idProdotto
 * @param type $codProdotto
 * @param type $nomeProdotto
 * @param type $abilitato
 * @param type $dtAbilitato
 * @return type
 */
function insertProdottoInStorico($idProdotto, $codProdotto, $nomeProdotto, $abilitato, $dtAbilitato) {

    $strinSql = "INSERT INTO storico.prodotto 	
            (id_prodotto,cod_prodotto,nome_prodotto,abilitato,dt_abilitato)
            VALUES(
                       " . $idProdotto . ",
                       '" . $codProdotto . "',
                       '" . $nomeProdotto . "',
                        " . $abilitato . ",
                       '" . $dtAbilitato . "')";
    $sql = mysql_query($strinSql);
    //or die("ERROR IN script_prodotto.php - FUNCTION insertProdottoInStorico - " .$strinSql." - " . mysql_error());
    return $sql;
}

//mettere 
function findAllProdottiByFiltri($campoOrdine, $campoGroupBy, $idProdotto, $codProdotto, $nomeProdotto, $strUtentiAziende) {


    $stringSql = "SELECT 
                        p.id_prodotto AS id_prodotto,
                        p.cod_prodotto AS cod_prodotto,
                        p.nome_prodotto AS nome_prodotto,                       
                        a.id_mazzetta,
                        a.dt_abilitato,
                        a.id_cat

                FROM serverdb.prodotto p
                JOIN serverdb.anagrafe_prodotto a
                ON 
                        p.id_prodotto = a.id_prodotto
                                               
                WHERE 
                    p.id_prodotto LIKE '%" . $idProdotto . "%'
                  AND
                    cod_prodotto LIKE '%" . $codProdotto . "%'
                  AND
                    nome_prodotto LIKE '%" . $nomeProdotto . "%'
                  
                  AND
                    (p.id_utente,p.id_azienda) IN " . $strUtentiAziende . "  
                  AND (a.abilitato=1 AND p.abilitato=1)      
                GROUP BY " . $campoGroupBy . "
                ORDER BY " . $campoOrdine;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_prodotto.php - findAllProdottiByFiltri - " . $stringSql . " - " . mysql_error());
    return $sql;
}

 
function findProdottiAssegnatiByFiltri($campoOrdine, $campoGroupBy, $idProdotto, $codProdotto, $nomeProdotto,$arrayProdPerMac, $tipo, $strUtentiAziende) {

    
    $stringaProdottiAss="";
   for ($i = 0; $i < count($arrayProdPerMac)-1; $i++) {

                    $stringaProdottiAss=$stringaProdottiAss. $arrayProdPerMac[$i] . ",";
                }
    $stringaProdottiAss=$stringaProdottiAss. $arrayProdPerMac[count($arrayProdPerMac)-1] ;
    

    $stringSql = "SELECT 
                        p.id_prodotto AS id_prodotto,
                        p.cod_prodotto AS cod_prodotto,
                        p.nome_prodotto AS nome_prodotto,                       
                        a.id_mazzetta,
                        a.dt_abilitato,
                        a.id_cat,
                        colorato,
                        geografico,
                        tipo_riferimento,
                        gruppo,
                        livello_gruppo,
                        serie_colore,
                        serie_additivo

                FROM serverdb.prodotto p
                JOIN serverdb.anagrafe_prodotto a
                ON 
                        p.id_prodotto = a.id_prodotto                                               
                WHERE 
                    p.id_prodotto LIKE '%" . $idProdotto . "%'
                  AND
                    cod_prodotto LIKE '%" . $codProdotto . "%'
                  AND
                    nome_prodotto LIKE '%" . $nomeProdotto . "%'
                  AND 
                    tipo='".$tipo."'
                  AND
                    (p.id_utente,p.id_azienda) IN " . $strUtentiAziende . "  
                  AND (a.abilitato=1 AND p.abilitato=1)      
                  AND p.id_prodotto IN (".$stringaProdottiAss.")
                GROUP BY " . $campoGroupBy . "
                ORDER BY " . $campoOrdine;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_prodotto.php - findProdottiAssegnatiByFiltri - " . $stringSql . " - " . mysql_error());
    return $sql;
}

function findProdottiColoriAdditiviAssegnatiByFiltri($campoOrdine, $campoGroupBy, $idProdotto, $codProdotto, $nomeProdotto,$arrayProdPerMac, $strUtentiAziende) {

    
    $stringaProdottiAss="";
   for ($i = 0; $i < count($arrayProdPerMac)-1; $i++) {

                    $stringaProdottiAss=$stringaProdottiAss. $arrayProdPerMac[$i] . ",";
                }
    $stringaProdottiAss=$stringaProdottiAss. $arrayProdPerMac[count($arrayProdPerMac)-1] ;
    

    $stringSql = "SELECT 
                        p.id_prodotto AS id_prodotto,
                        p.cod_prodotto AS cod_prodotto,
                        p.nome_prodotto AS nome_prodotto,                       
                        a.id_mazzetta,
                        a.dt_abilitato,
                        a.id_cat,
                        colorato,
                        geografico,
                        tipo_riferimento,
                        gruppo,
                        livello_gruppo,
                        serie_colore,
                        serie_additivo

                FROM serverdb.prodotto p
                JOIN serverdb.anagrafe_prodotto a
                ON 
                        p.id_prodotto = a.id_prodotto                                               
                WHERE 
                    p.id_prodotto LIKE '%" . $idProdotto . "%'
                  AND
                    cod_prodotto LIKE '%" . $codProdotto . "%'
                  AND
                    nome_prodotto LIKE '%" . $nomeProdotto . "%'
                  
                  AND
                    (p.id_utente,p.id_azienda) IN " . $strUtentiAziende . "  
                  AND (a.abilitato=1 AND p.abilitato=1)      
                  AND p.id_prodotto IN (".$stringaProdottiAss.")
                GROUP BY " . $campoGroupBy . "
                ORDER BY " . $campoOrdine;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_prodotto.php - findProdottiColoriAdditiviAssegnatiByFiltri - " . $stringSql . " - " . mysql_error());
    return $sql;
}




function findAllProdottiAbilitati($campoOrdine) {


    $stringSql = "SELECT 
                        p.id_prodotto AS id_prodotto,
                        p.cod_prodotto AS cod_prodotto,
                        p.nome_prodotto AS nome_prodotto                
                 FROM serverdb.prodotto p  
                          
                 WHERE 
                    p.abilitato = '1' 
                
                ORDER BY " . $campoOrdine;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_prodotto.php - findAllProdottiAbilitati - " . $stringSql . " - " . mysql_error());
    return $sql;
}

//##############################################################################
//####################### QUERY PER GESTIONE COLORI ############################
//##############################################################################


function findColoriByFiltri($campoOrdine, $campoGroupBy, $idProdotto, $codProdotto, $nomeProdotto, $serieColore, $geografico, $abilitato, $dtAbilitato, $gruppo, $tipo, $strUtentiAziende) {


    $stringSql = "SELECT 
                        p.id_prodotto AS id_prodotto,
                        p.cod_prodotto AS cod_prodotto,
                        p.nome_prodotto AS nome_prodotto,
                        p.serie_colore AS serie_colore,
                        a.geografico AS geografico,
                        a.abilitato AS abilitato,
                        a.dt_abilitato AS dt_abilitato,
                        a.gruppo AS gruppo

                    FROM serverdb.prodotto p
                JOIN serverdb.anagrafe_prodotto a
                ON 
                        p.id_prodotto = a.id_prodotto                 
               
                WHERE 
                    p.id_prodotto LIKE '%" . $idProdotto . "%'
                  AND
                    cod_prodotto LIKE '%" . $codProdotto . "%'
                  AND
                    nome_prodotto LIKE '%" . $nomeProdotto . "%'
                  AND
                    serie_colore LIKE '%" . $serieColore . "%'                   
                  AND
                    geografico LIKE '%" . $geografico . "%'
                  AND
                    a.abilitato LIKE '%" . $abilitato . "%'
                  AND
                    a.dt_abilitato LIKE '%" . $dtAbilitato . "%'
                  AND
                    gruppo LIKE '%" . $gruppo . "%'      
                  AND 
                    tipo='" . $tipo . "' 
                  AND
                    (p.id_utente,p.id_azienda) IN " . $strUtentiAziende . "                
                GROUP BY " . $campoGroupBy . "
                ORDER BY " . $campoOrdine;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_prodotto.php - findColoriByFiltri - " . $stringSql . " - " . mysql_error());
    return $sql;
}


//Seleziona tutti i campi della tabella prodotto, raggruppando e ordinando per serie
function findAllSerieVisibiliAbilitati($campogroupby, $campoOrdine, $strUtentiAziende) {


    $stringSql = "SELECT *         
                 FROM serverdb.prodotto p                            
                 WHERE 
                    p.abilitato = '1' 
                AND
                    (p.id_utente,p.id_azienda) IN " . $strUtentiAziende . "
                GROUP BY " . $campogroupby . " 
                ORDER BY " . $campoOrdine;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_prodotto.php - findAllSerieVisibiliAbilitati - " . $stringSql . " - " . mysql_error());
    return $sql;
}

function findAllSerieColoreVisAbilDiverseDa($serieColore, $strUtentiAziende) {


    $stringSql = "SELECT *         
                 FROM serverdb.prodotto p  
                          
                 WHERE 
                    p.abilitato = '1' 
                AND
                    (p.id_utente,p.id_azienda) IN " . $strUtentiAziende . "
                AND 
                    p.serie_colore <>'" . $serieColore . "'                            
                GROUP BY serie_colore
                ORDER BY serie_colore";
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_prodotto.php - findAllSerieColoreVisAbilDiverseDa - " . $stringSql . " - " . mysql_error());
    return $sql;
}

function findAllSerieAdditivoVisAbilDiverseDa($serieAdditivo, $strUtentiAziende) {


    $stringSql = "SELECT *         
                 FROM serverdb.prodotto p  
                          
                 WHERE 
                    p.abilitato = '1' 
                AND
                    (p.id_utente,p.id_azienda) IN " . $strUtentiAziende . "
                AND 
                    p.serie_additivo <>'" . $serieAdditivo . "'                            
                GROUP BY serie_additivo
                ORDER BY serie_additivo";
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_prodotto.php - findAllSerieAdditivoVisAbilDiverseDa - " . $stringSql . " - " . mysql_error());
    return $sql;
}

function findAdditiviByFiltri($campoOrdine, $campoGroupBy, $idProdotto, $codProdotto, $nomeProdotto, $serieAdditivo, $geografico, $abilitato, $dtAbilitato, $gruppo, $tipo, $strUtentiAziende) {


    $stringSql = "SELECT 
                        p.id_prodotto AS id_prodotto,
                        p.cod_prodotto AS cod_prodotto,
                        p.nome_prodotto AS nome_prodotto,
                        p.serie_additivo AS serie_additivo,
                        a.geografico AS geografico,
                        a.abilitato AS abilitato,
                        a.dt_abilitato AS dt_abilitato,
                        a.gruppo AS gruppo

                    FROM serverdb.prodotto p
                JOIN serverdb.anagrafe_prodotto a
                ON 
                        p.id_prodotto = a.id_prodotto                 
               
                WHERE 
                    p.id_prodotto LIKE '%" . $idProdotto . "%'
                  AND
                    cod_prodotto LIKE '%" . $codProdotto . "%'
                  AND
                    nome_prodotto LIKE '%" . $nomeProdotto . "%'
                  AND
                    serie_additivo LIKE '%" . $serieAdditivo . "%'                   
                  AND
                    geografico LIKE '%" . $geografico . "%'
                  AND
                    a.abilitato LIKE '%" . $abilitato . "%'
                  AND
                    a.dt_abilitato LIKE '%" . $dtAbilitato . "%'
                  AND
                    gruppo LIKE '%" . $gruppo . "%'      
                  AND 
                    tipo='" . $tipo . "' 
                  AND
                    (p.id_utente,p.id_azienda) IN " . $strUtentiAziende . "                
                GROUP BY " . $campoGroupBy . "
                ORDER BY " . $campoOrdine;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_prodotto.php - findAdditiviByFiltri - " . $stringSql . " - " . mysql_error());
    return $sql;
}

/**
 * Seleziona tutte le ricette colore di una serie
 * @param type $serieColore
 * @return type
 */
function findColoriBySerieAbil($serieColore,$tipo) {

    $strinSql = "SELECT * FROM serverdb.prodotto p JOIN serverdb.anagrafe_prodotto a ON p.id_prodotto=a.id_prodotto"
            . " WHERE serie_colore='". $serieColore."' AND tipo='".$tipo."' AND a.abilitato=1";
    $sql = mysql_query($strinSql) 
            or die("ERROR IN script_prodotto.php - FUNCTION findColoriBySerieAbil - " . $strinSql . " - " . mysql_error());
    return $sql;
        
}


/**
 * Seleziona tutte le ricette additivo di una serie
 * @param type $serieAdditivo
 * @return type
 */
function findAdditiviBySerieAbil($serieAdditivo,$tipo) {

    $strinSql = "SELECT * FROM serverdb.prodotto p JOIN serverdb.anagrafe_prodotto a ON p.id_prodotto=a.id_prodotto"
            . " WHERE serie_additivo='". $serieAdditivo."' AND tipo='".$tipo."' AND a.abilitato=1";
    $sql = mysql_query($strinSql) 
            or die("ERROR IN script_prodotto.php - FUNCTION findAdditiviBySerieAbil - " . $strinSql . " - " . mysql_error());
    return $sql;
        
}


/**function findProdottiAssegnatiAMacchina($campoOrdine, $arrayProdPerMac, $strUtentiAziende) {

    
    $stringaProdottiAss="";
   for ($i = 0; $i < count($arrayProdPerMac)-1; $i++) {

                    $stringaProdottiAss=$stringaProdottiAss. $arrayProdPerMac[$i] . ",";
                }
    $stringaProdottiAss=$stringaProdottiAss. $arrayProdPerMac[count($arrayProdPerMac)-1] ;
    

    $stringSql = "SELECT 
                        p.id_prodotto AS id_prodotto,
                        p.cod_prodotto AS cod_prodotto,
                        p.nome_prodotto AS nome_prodotto,                       
                        a.id_mazzetta,
                        a.dt_abilitato,
                        colorato,
                        geografico,
                        tipo_riferimento,
                        gruppo,
                        livello_gruppo,
                       
                        

                FROM serverdb.prodotto p
                JOIN serverdb.anagrafe_prodotto a
                ON 
                        p.id_prodotto = a.id_prodotto
                JOIN serverdb.categoria c
                ON  a.id_cat=c.id_cat
                WHERE 
                   
                    (p.id_utente,p.id_azienda) IN " . $strUtentiAziende . "  
                  AND (a.abilitato=1 AND p.abilitato=1)      
                  AND p.id_prodotto IN (".$stringaProdottiAss.")
                
                ORDER BY " . $campoOrdine;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_prodotto.php - findProdottiAssegnatiByFiltri - " . $stringSql . " - " . mysql_error());
    return $sql;
}
 **/
 


?>