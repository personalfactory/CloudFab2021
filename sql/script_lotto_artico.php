<?php
//Tabelle coinvolte
//lotto_artico


/**
 * Seleziona tutti i lotti
 * @param type $campoOrdine
 * @return type
 */
function findAllLottoArtico($campoOrdine){
    
    $sql= mysql_query("SELECT * FROM serverdb.lotto_artico 
        ORDER BY ".$campoOrdine);
//    or  die("ERROR IN script_lotto_artico - FUNCTION findAllLottoArtico - SELECT * FROM serverdb.lotto_artico : " . mysql_error());
    
    return $sql; 
    
}

/**
 * Seleziona un lotto dal codice
 * @param type $campoOrdine
 * @return type
 */
function findLottoArticoByCodice($codice){
    $stringSql="SELECT * FROM serverdb.lotto_artico WHERE codice='".$codice."'";
    $sql= mysql_query($stringSql)
    or  die("ERROR IN script_lotto_artico - FUNCTION findLottoArticoByCodice : ".$stringSql." - " . mysql_error());
    
    return $sql; 
    
}


/**
 * Verifica l'esistenza di un lotto nella tabella lotto_artico
 * facendo una select by codice o descri
 * @param type $codice
 * @param type $descri
 * @return type
 */
function verificaEsistenzaLottoArtico($codice,$descri){
    
    $sql= mysql_query("SELECT * FROM serverdb.lotto_artico 
        WHERE codice = '" . $codice . "' OR descri ='".$descri."' ");
//    or  die("ERROR IN script_lotto_artico - FUNCTION verificaEsistenzaLottoArtico - SELECT * FROM serverdb.lotto_artico : " . mysql_error());
    
    return $sql;
}

/**
 * Aggiorna la giacenza del lotto nella tabella lotto_artico
 * @param type $codice
 * @param type $giacAttuale
 * @return type
 */
function aggiornaGiacLotto($codice,$giacAttuale){
  $stringSql= "UPDATE serverdb.lotto_artico SET 
                 
                giacenza_attuale =  '" . $giacAttuale . "'
          WHERE 
                codice = '" . $codice . "'";
  $sql= mysql_query($stringSql);
//    or  die("ERROR IN script_lotto_artico - FUNCTION aggiornaGiacLotto - : " .$stringSql." ". mysql_error());   
    
    return $sql;
}



/**
 * Aggiorna il costo del lotto nella tabella lotto_artico
 * @param type $codice
 * @param type $costo
 * @return type
 */
function aggiornaCostoLotto($codice,$costo){
  $stringSql= "UPDATE serverdb.lotto_artico SET 
                 costo =  '" . $costo . "'
            WHERE 
                codice = '" . $codice . "'";
  $sql= mysql_query($stringSql)
    or  die("ERROR IN script_lotto_artico - FUNCTION aggiornaCostoLotto - : " .$stringSql." ". mysql_error());   
    
    return $sql;
}



/**
 * Aggiorna i campi giacenza_attuale,inventario e dt_inventario di un lotto nella tabella lotto_artico
 * @param type $codice
 * @param type $qtaInventario
 * @param type $dtInventario
 * @return type
 */
function aggiornaInventarioLotto($codArtico,$qtaInventario,$dtInventario){
//  $stringSql= "UPDATE serverdb.lotto_artico 
//                SET          
//                    giacenza_attuale = if(giacenza_attuale!=".$qtaInventario."," . $qtaInventario . ",giacenza_attuale),
//                    dt_inventario = if(inventario!=".$qtaInventario.",'" . $dtInventario . "',dt_inventario),
//                    inventario =if(inventario!=".$qtaInventario."," . $qtaInventario . ",inventario)
//                WHERE 
//                    codice = '" . $codArtico . "'";
    $stringSql= "UPDATE serverdb.lotto_artico 
                SET          
                    giacenza_attuale = ".$qtaInventario.",
                    dt_inventario = '" . $dtInventario . "',
                    inventario =" . $qtaInventario . "
                WHERE 
                    codice = '" . $codArtico . "'";
  $sql= mysql_query($stringSql)
    or  die("ERROR IN script_lotto_artico - FUNCTION aggiornaInventarioLotto - : " .$stringSql." ". mysql_error());   
    
    return $sql;
}
/**
 * Aggiorna il campo listino di un lotto nella tabella lotto_artico
 * @param type $codice
 * @param type $qtaListino
 * @return type
 */
function aggiornaListinoLotto($codArtico,$qtaListino){
  $stringSql= "UPDATE serverdb.lotto_artico 
                SET                  
                    listino = if(listino!=".$qtaListino."," . $qtaListino . ",listino)                    
                WHERE 
                    codice = '" . $codArtico . "'";
  $sql= mysql_query($stringSql)
    or  die("ERROR IN script_lotto_artico - FUNCTION aggiornaListinoLotto - : " .$stringSql." ". mysql_error());   
    
    return $sql;
}

function modificaCatalogoLottoArtico($codArtico,$valCatalogo){
  $stringSql= "UPDATE serverdb.lotto_artico 
                SET                  
                    catalogo = if(catalogo!='".$valCatalogo."','" . $valCatalogo . "',catalogo)                    
                WHERE 
                    codice = '" . $codArtico . "'";
  $sql= mysql_query($stringSql)
    or  die("ERROR IN script_lotto_artico - FUNCTION modificaCatalogoLottoArtico - : " .$stringSql." ". mysql_error());   
    
    return $sql;
}



/**
 * Aggiorna il campo scorta_minima di un lotto nella tabella lotto_artico
 * @param type $codice
 * @param type $qtaScortaMinima
 * @return type
 */
function aggiornaScortaMinimaLotto($codArtico,$qtaScortaMinima){
  $stringSql= "UPDATE serverdb.lotto_artico 
                SET                  
                    scorta_minima = if(scorta_minima!=".$qtaScortaMinima."," . $qtaScortaMinima . ",scorta_minima)                    
                WHERE 
                    codice = '" . $codArtico . "'";
  $sql= mysql_query($stringSql)
    or  die("ERROR IN script_lotto_artico - FUNCTION aggiornaScortaMinimaLotto - : " .$stringSql." ". mysql_error());   
    
    return $sql;
}


/**
 * Aggiorna il campo listino di tutti i record nella tabella lotto_artico
 * aumentando di una data percentuale
 * @param type $percAumentoListino
 * @return type
 */
function aumentaListinoLotto($percAumentoListino){
  $stringSql= "UPDATE serverdb.lotto_artico 
                SET                  
                    listino =  listino+(listino*".$percAumentoListino."/100)";
  $sql= mysql_query($stringSql)
    or  die("ERROR IN script_lotto_artico - FUNCTION aggiornaInventarioLotto - : " .$stringSql." ". mysql_error());   
    
    return $sql;
}




/**
 * Inserisce un nuovo lotto nella tabella lotto_artico
 * @param type $codice
 * @param type $descri
 * @param type $unitaMisura
 * @param type $costo
 * @param type $inventario
 * @param type $giacenzaAttuale
 * @param type $dtInventario
 * @return type
 */
function insertLottoArtico($codice,$descri,       
                                            $unitaMisura, 
                                            $costo, 
                                            $scortaMinima,
                                            $inventario,
                                            $giacenzaAttuale,
                                            $dtInventario){
   
    $stringSql=  "INSERT INTO serverdb.lotto_artico (
                            codice,
                            descri,
                            uni_mis,
                            costo,
                            scorta_minima,
                            inventario,                            
                            giacenza_attuale,dt_inventario)
               VALUES ( '" . $codice . "',
                        '" . $descri . "',                       
                        '" . $unitaMisura . "',
                        " . $costo . ",
                        " . $scortaMinima. ",
                        " . $inventario. ",
                        " . $giacenzaAttuale. ",
                        '" . $dtInventario. "')"; 
    $sql=mysql_query($stringSql);
//     or  die("ERROR IN script_lotto_artico - FUNCTION insertLottoArtico -  " .$stringSql ." - ".mysql_error());
    return $sql;
}


/**
 * Seleziona tutti i lotti dalla tabella lotto_artico in base ai filtri
 * @param type $campoOrdine
 * @param type $campoGroupBy
 * @param type $codice
 * @param type $descri
 * @param type $listino
 * @param type $costo
 * @param type $giacenza
 * @param type $scortaMinima
 * @param type $dtAbilitato
 * @return type
 */
function selectLottoArticoByFiltri($campoOrdine,
        $campoGroupBy,$codice, $descri, $listino, $costo, 
        $giacenza,$scortaMinima,$numKit,$qtaSac,$pesoLotto,$dtAbilitato) {

    $stringSql = "SELECT *,l.dt_abilitato FROM serverdb.lotto_artico l JOIN serverdb.formula f  
         WHERE 
            SUBSTRING(l.codice,2,6)=SUBSTRING(f.cod_formula,2,6)
         AND
            codice LIKE '%" . $codice . "%'
         AND 
            descri LIKE '%" . $descri . "%'
         AND
            listino LIKE '%" . $listino . "%'
         AND 
            costo LIKE '%" . $costo . "%'
         AND 
            giacenza_attuale LIKE '%" . $giacenza . "%'
         AND 
            scorta_minima LIKE '%" . $scortaMinima . "%'
         AND 
            num_sac_in_lotto LIKE '%" . $numKit . "%'
         AND 
            qta_sac LIKE '%" . $qtaSac . "%'
         AND 
            qta_lotto LIKE '%" . $pesoLotto . "%'
         AND 
            l.dt_abilitato LIKE '%" . $dtAbilitato . "%'
         GROUP BY ". $campoGroupBy."       
         ORDER BY " . $campoOrdine;
            
            
            $sql = mysql_query($stringSql) 
                    or die("ERROR IN script_lotto_artico - FUNCTION selectLottoArticoByFiltri - " .$stringSql." - ". mysql_error());

    return $sql;
}

/*function selectLottoArticoByFiltri($campoOrdine,
        $campoGroupBy,$codice, $descri, $listino, $costo, 
        $giacenza,$scortaMinima,$dtAbilitato) {

    $stringSql = "SELECT *,SUM(quanti) AS venduti FROM serverdb.lotto_artico l
        INNER JOIN serverdb.gaz_movmag g ON l.codice=g.artico
         WHERE 
            codice LIKE '%" . $codice . "%'
         AND 
            descri LIKE '%" . $descri . "%'
         AND
            listino LIKE '%" . $listino . "%'
         AND 
            costo LIKE '%" . $costo . "%'
         AND 
            giacenza_attuale LIKE '%" . $giacenza . "%'
         AND 
            scorta_minima LIKE '%" . $scortaMinima . "%'
         AND 
            l.dt_abilitato LIKE '%" . $dtAbilitato . "%'
         AND 
            g.dt_abilitato LIKE '%" . $dtAbilitato . "%'
         AND 
            tip_doc='DDT'
         GROUP BY l.". $campoGroupBy."       
         ORDER BY l." . $campoOrdine;
            
            
            $sql = mysql_query($stringSql) 
                    or die("ERROR IN script_lotto_artico - FUNCTION selectLottoArticoByFiltri - " .$stringSql." - ". mysql_error());

    return $sql;
}*/
?>
