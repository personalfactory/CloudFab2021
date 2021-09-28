<?php
//Tabelle coinvolte
//gaz_movmag
//macchina
//lotto
//bolla

/**
 * Seleziona i ddt di vendita dalla tabella gaz_movmag e gli eventuali 
 * codici lotto associati
 * @param type $numDoc
 * @param type $dtDoc
 * @return type
 */
function findMovLottoAssociati($numDoc, $dtDoc,$groupBy){
    $stringSql = "SELECT * FROM gaz_movmag g
                        INNER JOIN 
                            macchina m ON 
                            g.clfoco=m.cod_stab
                        JOIN lotto l 
                        WHERE                          
                            l.num_bolla=g.num_doc 
			AND
                            l.dt_bolla=g.dt_doc
			AND 
                            SUBSTRING(cod_lotto,1,6) =g.artico
                        AND
                            num_doc=" . $numDoc . "
                         AND
                            dt_doc='" . $dtDoc . "'"
            . "GROUP BY ".$groupBy;
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_gaz_movmag.php - FUNCTION findMovLottoAssociati -  " . $stringSql . " - " . mysql_error());
    return $sql;
}

/**
 * Inserisce un movimento di magazzino
 * @param type $operazione
 * @param type $causale
 * @param type $tipDoc
 * @param type $numDoc
 * @param type $desDoc
 * @param type $dtDoc
 * @param type $clfoco
 * @param type $artico
 * @param type $descriArtico
 * @param type $quanti
 * @param type $prezzo
 * @param type $fornitore
 * @param type $codArticoFornitore
 * @param type $uniMis
 * @param type $dtArrivoMerce
 * @param type $valutazioneMerce
 * @param type $verificaStabilita
 * @param type $proceduraAdottata
 * @param type $operatore
 * @param type $respProd
 * @param type $respQualita
 * @param type $consulenteTecnico
 * @param type $note
 * @param type $destNomeFileDdt
 * @param type $numOrdine
 * @param type $dtOrdine
 * @return type
 */
function inserisciMovimento($dtMovimento,$operazione, $causale, $tipDoc, $numDoc, $desDoc, $dtDoc, 
        $clfoco, $artico, $descriArtico, $catMer, $quanti, $prezzo, $fornitore, 
        $codArticoFornitore, $uniMis, $dtArrivoMerce, $valutazioneMerce, $verificaStabilita, 
        $proceduraAdottata, $operatore, $respProd, $respQualita, $consulenteTecnico, 
        $note, $destNomeFileDdt, $numOrdine, $dtOrdine) {
    $stringSql = "INSERT INTO serverdb.gaz_movmag ( dt_mov,operazione,
                                                         causale,
                                                         tip_doc,
                                                         num_doc,
                                                         des_doc,
                                                         dt_doc,
                                                         clfoco,
                                                         artico,
                                                         descri_artico,
                                                         cat_mer,
                                                         quanti,
                                                         prezzo,
                                                         fornitore,
                                                         cod_artico_fornitore,
                                                         uni_mis,
                                                         dt_arrivo_merce,
                                                         valutazione_merce,
                                                         verifica_stabilita,
                                                         procedura_adottata,
                                                         operatore,
                                                         resp_produzione,
                                                         resp_qualita,
                                                         consulente_tecnico,
                                                         note,
                                                         doc_link,
                                                         num_ordine,
                                                         dt_ordine)
        VALUES('" . $dtMovimento . "','" . $operazione . "',
               '" . $causale . "',
               '" . $tipDoc . "',
               '" . $numDoc . "',
               '" . $desDoc . "',
               '" . $dtDoc . "',
               '" . $clfoco . "',
               '" . $artico . "',
               '" . $descriArtico . "',
               '" . $catMer . "',
               '" . $quanti . "',
               '" . $prezzo . "',
               '" . $fornitore . "',
               '" . $codArticoFornitore . "',
               '" . $uniMis . "',
               '" . $dtArrivoMerce . "',
               '" . $valutazioneMerce . "',
               '" . $verificaStabilita . "',
               '" . $proceduraAdottata . "',    
               '" . $operatore . "',
               '" . $respProd . "',
               '" . $respQualita . "',
               '" . $consulenteTecnico . "',
               '" . $note . "',
               '" . $destNomeFileDdt . "',
               '" . $numOrdine . "',
                '" . $dtOrdine . "')";
    $sql = mysql_query($stringSql) ;
//            or die("ERROR IN script_gaz_movmag - FUNCTION inserisciMovimento  : " . $stringSql . " - " . mysql_error());

    return $sql;
}

/**
 * Seleziona tutti i moviment di magazzino dalla tabella gaz_movmag in base ai filtri
 * @param type $Causale
 * @param type $TipDoc
 * @param type $NumDoc
 * @param type $DtDoc
 * @param type $Artico
 * @param type $dtMov
 * @param type $catMer
 * @param type $Filtro
 * @return type
 */
function selectGazMovMagByFiltri($campoOrdine, $campoGroupBy, $causale, $tipDoc, $numDoc, $dtDoc, $artico, $descriArtico, $catMer, $quantita, $dtMov) {

    $sql = mysql_query("SELECT * FROM serverdb.gaz_movmag 
         WHERE 
            causale LIKE '%" . $causale . "%'
         AND 
            tip_doc LIKE '%" . $tipDoc . "%'
         AND
            num_doc LIKE '%" . $numDoc . "%'
         AND 
            dt_doc LIKE '%" . $dtDoc . "%'
         AND 
            artico LIKE '%" . $artico . "%'
         AND 
            descri_artico LIKE '%" . $descriArtico . "%'
         AND 
            quanti LIKE '%" . $quantita . "%'
         AND 
            dt_mov LIKE '%" . $dtMov . "%'
         AND
            cat_mer LIKE '%" . $catMer . "%'
         GROUP BY " . $campoGroupBy . "       
         ORDER BY " . $campoOrdine) or die("ERROR IN script_gaz_movmag - FUNCTION selectGazMovMagByFiltri - SELECT * serverdb.gaz_movmag : " . mysql_error());

    return $sql;
}

/**
 * Cerca un movimento con un determinato id_mov 
 * @param type $idMov
 */
function findMovimentoById($idMov) {

    $sql = mysql_query("SELECT * FROM serverdb.gaz_movmag 
         WHERE 
            id_mov=" . $idMov) or die("ERROR IN script_gaz_movmag - FUNCTION findMovimentoById - SELECT * serverdb.gaz_movmag : " . mysql_error());

    return $sql;
}

/**
 * Modfica un movimento di magazzino esistente nella tabella gaz_mov_magazzino
 * @param type $idMov
 * @param type $operazione
 * @param type $causale
 * @param type $tipDoc
 * @param type $numDoc
 * @param type $desDoc
 * @param type $dtDoc
 * @param type $clfoco
 * @param type $artico
 * @param type $descriArtico
 * @param type $quanti
 * @param type $prezzo
 * @param type $fornitore
 * @param type $codArticoFornitore
 * @param type $uniMis
 * @param type $dtArrivoMerce
 * @param type $valutazioneMerce
 * @param type $verificaStabilita
 * @param type $proceduraAdottata
 * @param type $operatore
 * @param type $respProd
 * @param type $respQualita
 * @param type $consulenteTecnico
 * @param type $note
 * @return type
 */
function modificaMovimento($idMov, $operazione, $causale, $tipDoc, $numDoc, $desDoc, $dtDoc, $clfoco, $artico, $descriArtico, $quanti, $prezzo, $fornitore, $codArticoFornitore, $uniMis, $dtArrivoMerce, $valutazioneMerce, $verificaStabilita, $proceduraAdottata, $operatore, $respProd, $respQualita, $consulenteTecnico, $note, $docLink) {

    $sql = mysql_query("UPDATE serverdb.gaz_movmag SET operazione='" . $operazione . "',
                                                         causale='" . $causale . "',
                                                         tip_doc='" . $tipDoc . "',
                                                         num_doc='" . $numDoc . "',
                                                         des_doc='" . $desDoc . "',
                                                         dt_doc='" . $dtDoc . "',
                                                         clfoco='" . $clfoco . "',
                                                         artico='" . $artico . "',
                                                         descri_artico='" . $descriArtico . "',
                                                         quanti='" . $quanti . "',
                                                         prezzo='" . $prezzo . "',
                                                         fornitore='" . $fornitore . "',
                                                         cod_artico_fornitore='" . $codArticoFornitore . "',
                                                         uni_mis='" . $uniMis . "',
                                                         dt_arrivo_merce='" . $dtArrivoMerce . "',
                                                         valutazione_merce='" . $valutazioneMerce . "',
                                                         verifica_stabilita='" . $verificaStabilita . "',
                                                         procedura_adottata='" . $proceduraAdottata . "',
                                                         operatore='" . $operatore . "',
                                                         resp_produzione='" . $respProd . "',
                                                         resp_qualita='" . $respQualita . "',
                                                         consulente_tecnico='" . $consulenteTecnico . "',
                                                         note='" . $note . "',
                                                         doc_link='" . $docLink . "'    
                                             WHERE id_mov=" . $idMov);
//            or die("ERROR IN script_gaz_movmag - FUNCTION modificaMovimento - UPDATE serverdb.gaz_movmag : " . mysql_error());

    return $sql;
}

/**
 * Seleziona tutti i movimenti di un certo tipo (carico o scarico) di un dato articolo
 * @param type $operazione
 * @param type $artico
 * @return type
 */
function   findMovimentiByArtico($operazione, $artico) {

    $sql = mysql_query("SELECT * FROM serverdb.gaz_movmag 
        WHERE operazione='" . $operazione . "'
            AND
            artico='" . $artico . "'") or die("ERROR IN script_gaz_movmag - FUNCTION findMovimentiByArtico - SELECT * serverdb.gaz_movmag : " . mysql_error());
    return $sql;
}

/**
 * Aggiorna il campo pre_acq nella tabella gaz_movmag 
 * di una data materia prima con un dato prezzo
 * @param type $codice
 */
function aggiornaPrezzoMovimenti($codice, $prezzo, $defaultPrezzo) {

    $sql = mysql_query("UPDATE serverdb.gaz_movmag SET prezzo='" . $prezzo . "' 
                            WHERE 
                                artico='" . $codice . "'
                            AND
                                prezzo=" . $defaultPrezzo) or die("ERROR IN script_gaz_movmag - FUNCTION aggiornaPrezzoMovimenti - UPDATE serverdb.gaz_movmag : " . mysql_error());
    return $sql;
}

/**
 * Calcola la giacenza attuale di una data materia prima
 * come differenza tra il carico e lo scarico
 * @param type $artico
 */
function calcolaGiacenzaAttuale($artico, $valCarico, $valScarico) {

   $stringSql="SELECT SUM(quanti) - 
                            (SELECT SUM(quanti) FROM serverdb.gaz_movmag 
                            WHERE artico='" . $artico . "' AND operazione=" . $valScarico . ") AS giacenza
                        FROM serverdb.gaz_movmag WHERE artico='" . $artico . "' AND operazione=" . $valCarico;

    
     $sql = mysql_query($stringSql) or die("ERROR IN script_gaz_movmag - FUNCTION calcolaGiacenzaAttuale - " .$stringSql." - ". mysql_error());
    return $sql;
}


/**
 * Calcola il totale delle quantita caricate o scaricate (a seconda del parametro usato)
 * di una data materia prima considerando tutti i movimenti con dt_mov successiva
 * alla dt dell'ultimo inventario
 * @param type $artico
 * @param type $operazione
 * @param type $dtInventario
 */
function calcolaQtaOperTot($artico, $operazione, $dtInventario){

  $stringSql="SELECT SUM(quanti) AS qta_tot
                    FROM serverdb.gaz_movmag 
                    WHERE 
                        artico='".$artico."' 
                     AND 
                        operazione='".$operazione."'
                     AND 
                        dt_mov>'".$dtInventario."'";
    
     $sql = mysql_query($stringSql) or die("ERROR IN script_gaz_movmag - FUNCTION calcolaQtaOperTot - " .$stringSql." - ". mysql_error());
    return $sql;
}


/**
 * Elimina un movimento di magazzino
 * @param type $idMovimento
 */
function eliminaMovimento($idMovimento) {

  $stringSql="DELETE FROM serverdb.gaz_movmag
                    WHERE 
                        id_mov=".$idMovimento;                     
    
     $sql = mysql_query($stringSql) 
     or die("ERROR IN script_gaz_movmag - FUNCTION eliminaMovimento - " .$stringSql." - ". mysql_error());
    return $sql;
}




/**
 * Seleziona i movimenti relativi ad una catmer facendo il join con le tabelle macchina e bolla
 * utilizzando i vari filtri sui campi
 * @param type $campoOrdine
 * @param type $campoGroupBy
 * @param type $catMerLotti
 * @param type $tipoDocDdtVen
 * @param type $numDoc
 * @param type $dtDoc
 * @param type $descriStab
 * @param type $artico
 * @param type $descriArtico
 * @param type $quantita
 * @param type $dtMov
 * @return type
 */
function findMovJoinBollaByFiltri($campoOrdine, $campoGroupBy, $catMerLotti, $tipoDocDdtVen, $numDoc, $dtDoc, $descriStab, $artico, $descriArtico, $quantita, $dtMov) {

    $stringSql = "SELECT *
                FROM 
                    serverdb.gaz_movmag
                LEFT JOIN 
                    macchina ON gaz_movmag.clfoco=macchina.cod_stab
                LEFT JOIN 
                    bolla ON 
                            bolla.num_bolla=gaz_movmag.num_doc 
                            AND 
                            bolla.dt_bolla=gaz_movmag.dt_doc
                WHERE  
                    cat_mer='" . $catMerLotti . "' 
                AND 
                    tip_doc='" . $tipoDocDdtVen . "'
                AND
                    num_doc LIKE '%" . $numDoc . "%'
                AND 
                    dt_doc LIKE '%" . $dtDoc . "%'
                AND                     
                    descri_stab LIKE '%" . $descriStab . "%' 
                AND 
                    artico LIKE '%" . $artico . "%'
                AND 
                    descri_artico LIKE '%" . $descriArtico . "%'
                AND 
                    dt_mov LIKE '%" . $dtMov . "%'
                GROUP BY " . $campoGroupBy . "
                ORDER BY " . $campoOrdine;

    $sql = mysql_query($stringSql) or die("ERROR IN script_gaz_movmag - FUNCTION findMovJoinBollaByFiltri - " . $stringSql . " - " . mysql_error());
    return $sql;
}

/**
 * Seleziona tutti i movimenti di un certo ddt
 * @param type $numDoc
 * @param type $dtDoc
 * @return type
 */
function findMovimentiByDdt($numDoc, $dtDoc) {

    $stringSql ="SELECT * FROM serverdb.gaz_movmag 
                WHERE 
                        num_doc='" . $numDoc . "'
                    AND
                        dt_doc='" . $dtDoc . "'"; 
            
    $sql= mysql_query($stringSql) or die("ERROR IN script_gaz_movmag - FUNCTION findMovimentiByDdt 
                -  ".$stringSql ." - ". mysql_error());;
    return $sql;
}

/**
 * Calcola il totale della quantità movimentata di un dato articolo
 * @param type $artico
 * @param type $operazione
 * @param type $dtMov
 * @return type
 */
function trovaConsumoByArtico($arrayArtico,$operazione,$dtMov){
    
       $stringSql ="SELECT SUM(quanti), SUM(quanti*prezzo) FROM serverdb.gaz_movmag
                WHERE 
                        artico IN (";
    
    for ($i = 0; $i < count($arrayArtico); $i++) {
        $stringSql .= "'";
        
        $stringSql .= $arrayArtico[$i]."'";
        if ($i <(count($arrayArtico)-1)){
            $stringSql .= ",";        } 
     }
     $stringSql.=")  AND 
                        operazione='".$operazione."'
                     AND 
                        dt_mov LIKE '%".$dtMov."%'"; 
//     echo $stringSql;        
    $sql= mysql_query($stringSql) or die("ERROR IN script_gaz_movmag - FUNCTION trovaConsumoByArtico 
                -  ".$stringSql ." - ". mysql_error());;
    return $sql;
    
    
}

 
function selectDataDdtByNumDoc($numDdt,$catMerLotti){
    
    
    $stringSql ="SELECT * FROM serverdb.gaz_movmag
                                                WHERE 
                                                   num_doc='" . $numDdt . "'
                                                AND
                                                   cat_mer='" . $catMerLotti . "'
                                                GROUP BY 
                                                    dt_doc 
                                                ORDER BY 
                                                  dt_doc DESC"; 
            
    $sql= mysql_query($stringSql) or die("ERROR IN script_gaz_movmag - FUNCTION selectDataDdtByNumDoc - ".$stringSql ." - ". mysql_error());
    return $sql;
    


}


function findInfoMovByDdtCatMer($numDdt,$dataEmi,$catMer){
$stringSql = "SELECT * FROM serverdb.gaz_movmag 
                                  WHERE 
                                      num_doc='" . $numDdt . "' 
                                    AND 
                                      dt_doc='" . $dataEmi . "'
                                    AND 
                                      cat_mer='" . $catMer . "'";
             $sql= mysql_query($stringSql) or die("ERROR IN script_gaz_movmag - FUNCTION findInfoMovByDdtCatMer - ".$stringSql ." - ". mysql_error());
    return $sql;
    
}

function findTotLottiInDdtGazmovmag($numDdt,$dataEmi,$catMer){
    $stringSql = "SELECT SUM(quanti) as numlotti, artico 
                                        FROM 
                                          serverdb.gaz_movmag	
                                        WHERE 
                                          num_doc=" . $numDdt . "
                                        AND 
                                          dt_doc='" . $dataEmi . "'
                                        AND 
                                            cat_mer='" . $catMer . "'";
    $sql= mysql_query($stringSql) or die("ERROR IN script_gaz_movmag - FUNCTION findTotLottiInDdt - ".$stringSql ." - ". mysql_error());
    return $sql;
}


function verificaPrefissoCodLottoDdt($numDdt,$dataEmi,$prefCodLotto,$catMer){

 $stringSql = "SELECT artico FROM serverdb.gaz_movmag	
                                        WHERE 
					num_doc ='" . $numDdt . "'
                                         AND 
                                          dt_doc='" . $dataEmi . "'
                                        AND 
                                           artico='" . $prefCodLotto . "'
                                        AND 
                                            cat_mer='" . $catMer . "'";
                 
        $sql= mysql_query($stringSql) 
         or die("ERROR IN script_gaz_movmag - FUNCTION verificaPrefissoCodLottoDdt - ".$stringSql ." - ". mysql_error());
    return $sql;
}



function findLastIdMov(){
    
    
   $stringSql=" SELECT LAST_INSERT_ID();";
   
    $sql= mysql_query($stringSql) 
         or die("ERROR IN script_gaz_movmag - FUNCTION findLastIdMov - ".$stringSql ." - ". mysql_error());
    return $sql;
   
}


function findMovByDdtArtico($numDoc, $dtDoc,$artico){
    $stringSql = "SELECT * FROM gaz_movmag g
                        INNER JOIN 
                            macchina m ON 
                            g.clfoco=m.cod_stab
                        JOIN lotto l 
                        WHERE                          
                            l.num_bolla=g.num_doc 
			AND
                            l.dt_bolla=g.dt_doc
			AND 
                            SUBSTRING(cod_lotto,1,6)=g.artico
                        AND 
                            SUBSTRING(cod_lotto,1,6)='".$artico."'
                        AND
                            num_doc=" . $numDoc . "
                         AND
                            dt_doc='" . $dtDoc . "'";
            
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_gaz_movmag.php - FUNCTION findMovByDdtArtico -  " . $stringSql . " - " . mysql_error());
    return $sql;
}

?>
