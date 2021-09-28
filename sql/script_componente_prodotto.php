<?php
//Tabelle coinvolte 
//componente
//componente_prodotto

/**
 * Seleziona tutti i componenti associati ad un prodotto, abilitati e non
 * @param type $idProdotto
 * @return type
 */
function selectComponentiByIdProdotto($idProdotto){
$sql = mysql_query("SELECT *,cp.abilitato AS comp_abilitato	
                                FROM 
                                    serverdb.componente_prodotto cp
                                INNER JOIN  serverdb.componente c
                                ON
                                    cp.id_comp=c.id_comp
                                WHERE
                                    cp.id_prodotto=" . $idProdotto . "
                                ORDER BY 
                                    c.descri_componente") ;
//        or die("ERROR IN script_componente_prodotto - FUNCTION selectComponentiByIdProdotto " . mysql_error());

return $sql;
}
/**
 * Seleziona tutti i componenti associati ad un prodotto, abilitati 
 * o non abilitati
 * @param type $idProdotto
 * @param type $abilitato
 * @return type
 */
function selectComponentiByIdProdAbil($idProdotto,$abilitato){
$stringSql="SELECT *,cp.abilitato AS comp_abilitato	
                                FROM 
                                    serverdb.componente_prodotto cp
                                INNER JOIN  serverdb.componente c
                                ON
                                    cp.id_comp=c.id_comp
                                WHERE
                                    cp.id_prodotto=" . $idProdotto . "
                                    AND
                                    cp.abilitato=" . $abilitato . "
                                ORDER BY 
                                    c.descri_componente";
    $sql = mysql_query($stringSql) 
        or die("ERROR IN script_componente_prodotto - FUNCTION selectComponentiByIdProdAbil " .$stringSql ." - ".mysql_error());

return $sql;
}

/**
 * Inserisce un nuovo record nella tabella componente_prodotto
 * @param type $idProdotto
 * @param type $idComp
 * @param type $quantita
 * @param type $abilitato
 * @param type $dtAbilitato
 * @return type
 */
function insertNuovoComponenteProd($idProdotto,$idComp,$quantita,$abilitato,$dtAbilitato){
    
     $stringSql = "INSERT INTO componente_prodotto (
                                            id_prodotto,
                                            id_comp,
                                            quantita,
                                            abilitato,
                                            dt_abilitato)
                                        VALUES(
                                            " . $idProdotto . ",
                                            " . $idComp . ",
                                            " . $quantita . ",
                                            " . $abilitato . ",
                                            '".$dtAbilitato."')";
    
     $sql = mysql_query($stringSql); 
//        or die("ERROR IN script_componente_prodotto - FUNCTION insertNuovoComponenteProd " .$stringSql ." - ".mysql_error());
     return $sql;
}

/**
 * Seleziona le informazioni relative ad un componente in un dato prodotto
 * @param type $idComponente
 * @param type $idProdotto
 * @return type
 */
function findCompProdByIdProdIdComp($idComponente,$idProdotto){ 
                    
              $stringSql="SELECT * FROM componente_prodotto 
				WHERE 
					id_comp = " . $IdComponente . "
				AND
				 	id_prodotto= " . $IdProdotto;

            $sql = mysql_query($stringSql) 
        or die("ERROR IN script_componente_prodotto - FUNCTION findCompProdByIdProdIdComp " .$stringSql ." - ".mysql_error());
     return $sql;
}

/**
 * Sostituisce in un prodotto un componente il vecchio componente con un nuovo componente
 * @param type $idCompOld
 * @param type $idCompNew
 * @param type $quantita
 * @param type $idProdotto
 * @param type $data
 * @return type
 */
function sostituisciComponenteInProdotto($idCompOld,$idCompNew,$quantita,$idProdotto,$data){
  
                $stringSql="UPDATE componente_prodotto  SET id_comp= " . $idCompNew . ",
							 quantita=" . $quantita . ",
							 abilitato=1,
							 dt_abilitato='" . $data . "'
                            WHERE 
                                id_comp=" . $idCompOld . "
                            AND 
                                id_prodotto=" . $idProdotto;
 $sql = mysql_query($stringSql) ;
       // or die("ERROR IN script_componente_prodotto - FUNCTION sostituisciComponenteInProdotto " .$stringSql ." - ".mysql_error());
     return $sql;
                
}

/**
 * Modifica componente prodotto
 * @return type
 */
function modificaComponenteProdotto($idComp,$idProdotto,$quantitaDaInserire,$compAbilitato){
 
    $stringSql = "UPDATE serverdb.componente_prodotto 
                    SET 
                        quantita=if(quantita!=" . $quantitaDaInserire . "," . $quantitaDaInserire . ",quantita),
                        abilitato=if(abilitato!=" . $compAbilitato . "," . $compAbilitato . ",abilitato),
                        dt_abilitato=NOW()    
                    WHERE
                            id_prodotto=" . $idProdotto . "
                    AND
                            id_comp=" . $idComp;
     $sql = mysql_query($stringSql) ;
//        or die("ERROR IN script_componente_prodotto - FUNCTION modificaComponenteProdotto " .$stringSql ." - ".mysql_error());
     return $sql;
}
//##############################################################################
//#################### STORICO #################################################
//##############################################################################

/**
 * Inserisce nello storico di componente_prodotto
 * @param type $idCompProd
 * @param type $idComp
 * @param type $idProdotto
 * @param type $quantita
 * @param type $abilitato
 * @param type $dtAbilitato
 */
function inserisciInStoricoCompProd($idCompProd,$idComp,$idProdotto,$quantita,$abilitato,$dtAbilitato){

$stringSql = "INSERT INTO storico.componente_prodotto 	
                     (id_comp_prod,id_comp,id_prodotto,quantita,abilitato,dt_abilitato)
                VALUES(
                                " . $idCompProd . ",
                                " . $idComp . ",
                                " . $idProdotto . ",
                                " . $quantita . ",
                                " . $abilitato . ",
                                '" . $dtAbilitato . "')";

$sql = mysql_query($stringSql) 
        or die("ERROR IN script_componente_prodotto - FUNCTION inserisciInStoricoCompProd - " .$stringSql ." - ".mysql_error());
     return $sql;
}

/**
 * NEW
 */
function selectComponentiPrezzoByIdProdotto($idProdotto,$idLingua,$valAbilitato){
//echo "SELECT * FROM 
//                                    serverdb.componente_prodotto cp
//                                JOIN  serverdb.componente c ON
//                                    cp.id_comp=c.id_comp
//                                JOIN  serverdb.materia_prima m ON
//                                    m.cod_mat=c.cod_componente
//                                WHERE
//                                    cp.id_prodotto=" . $idProdotto;
   $stringSql= "SELECT *,prezzo_bs AS pre_acq FROM 
                                    serverdb.componente_prodotto cp
                                JOIN  serverdb.componente c ON
                                    cp.id_comp=c.id_comp
                                JOIN  serverdb.lab_materie_prime m ON
                                    m.cod_mat=c.cod_componente
                                JOIN serverdb.dizionario d
                                WHERE
                                    d.id_diz_tipo=4
                                  AND 
                                    d.id_vocabolo=c.id_comp
                                  AND 
                                    d.id_lingua=".$idLingua."   
                                  AND
                                   cp.id_prodotto=" . $idProdotto."
                                  AND
                                    m.cod_mat like 'comp%'
                                  AND 
                                  cp.abilitato=".$valAbilitato;
    $sql = mysql_query($stringSql) 
        or die("ERROR IN script_componente_prodotto - FUNCTION selectComponentiPrezzoByIdProdotto " . mysql_error());

return $sql;
}



/**
 * Recupera tutti i componenti dei prodotti visibili ad una macchina in base al gruppo
 * @param type $idMacchina
 * @return type
 */
function findComponentiByGruppoPerMacchina($idMacchina){
 $stringSql="SELECT * FROM serverdb.anagrafe_prodotto p, serverdb.gruppo g, serverdb.anagrafe_macchina m, serverdb.componente_prodotto cp 
                    WHERE 
                            CASE 
                             WHEN (m.gruppo = g.livello_6) THEN 64        
                             WHEN (m.gruppo = g.livello_5) THEN 32 
                             WHEN (m.gruppo = g.livello_4) THEN 16 
                             WHEN (m.gruppo = g.livello_3) THEN 8 
                             WHEN (m.gruppo = g.livello_2) THEN 4 
                             WHEN (m.gruppo = g.livello_1) THEN 2 
                             END 
                             <= 
                             CASE 
                             WHEN (p.gruppo = g.livello_6) THEN 64 
                             WHEN (p.gruppo = g.livello_5) THEN 32 
                             WHEN (p.gruppo = g.livello_4) THEN 16 
                             WHEN (p.gruppo = g.livello_3) THEN 8 
                             WHEN (p.gruppo = g.livello_2) THEN 4 
                             WHEN (p.gruppo = g.livello_1) THEN 2 
                             END 
                         AND 
                             ((m.gruppo = g.livello_1) OR 
                             (m.gruppo = g.livello_2) OR 
                             (m.gruppo = g.livello_3) OR 
                             (m.gruppo = g.livello_4) OR 
                             (m.gruppo = g.livello_5) OR 
                             (m.gruppo = g.livello_6)) 
                         AND 
                             ((p.gruppo = g.livello_1) OR 
                             (p.gruppo = g.livello_2) OR 
                             (p.gruppo = g.livello_3) OR 
                             (p.gruppo = g.livello_4) OR 
                             (p.gruppo = g.livello_5) OR 
                             (p.gruppo = g.livello_6)) 
                         AND 
                             m.id_macchina = ".$idMacchina."
                         AND 
                             p.id_prodotto = cp.id_prodotto 
                     GROUP BY 
                        cp.id_comp 
                    ORDER BY 
                        cp.id_comp";

$sql=mysql_query($stringSql);
//	or die("ERROR IN script_anagrafe_prodotto.php - FUNCTION findComponetiByGruppoPerMacchina - " .$strinSql." - " . mysql_error());
	return $sql;

}


/**
 * Seleziona tutti i componenti dei prodotti visibili ad una macchina in base al riferimento geografico
 * @param type $idMacchina
 * @return type
 */
function findComponentiByRifGeoPerMacchina($idMacchina){
 $stringSql="SELECT * FROM serverdb.anagrafe_prodotto p, serverdb.comune c, serverdb.anagrafe_macchina m, serverdb.componente_prodotto cp 
                    WHERE 
                            CASE                     
                            WHEN (m.geografico = c.mondo) THEN 64
                            WHEN (m.geografico = c.continente) THEN 32 
                            WHEN (m.geografico = c.stato) THEN 16 
                            WHEN (m.geografico = c.regione) THEN 8 
                            WHEN (m.geografico = c.provincia) THEN 4 
                            WHEN (m.geografico = c.comune) THEN 2 
                            END 
                            <= 
                            CASE 
                            WHEN (p.geografico = c.mondo) THEN 64 
                            WHEN (p.geografico = c.continente) THEN 32 
                            WHEN (p.geografico = c.stato) THEN 16 
                            WHEN (p.geografico = c.regione) THEN 8 
                            WHEN (p.geografico = c.provincia) THEN 4 
                            WHEN (p.geografico = c.comune) THEN 2 
                            END 
                        AND
                            ((m.geografico = c.mondo) OR 
                            (m.geografico = c.continente) OR 
                            (m.geografico = c.stato) OR 
                            (m.geografico = c.regione) OR 
                            (m.geografico = c.provincia) OR 
                            (m.geografico = c.comune)) 
                        AND 
                            ((p.geografico = c.mondo) OR 
                            (p.geografico = c.continente) OR 
                            (p.geografico = c.stato) OR 
                            (p.geografico = c.regione) OR 
                            (p.geografico = c.provincia) OR 
                            (p.geografico = c.comune)) 
                        AND 
                            m.id_macchina = ".$idMacchina."
                        AND 
                            p.id_prodotto = cp.id_prodotto        
                        GROUP BY 
                          cp.id_comp
                    ORDER BY 
                        cp.id_comp";

$sql=mysql_query($stringSql);
//	or die("ERROR IN script_anagrafe_prodotto.php - FUNCTION findComponentiByRifGeoPerMacchina - " .$strinSql." - " . mysql_error());
	return $sql;

}

function disabilitaCompProd($idProdotto,$idComponente){
    $stringSql = "UPDATE serverdb.componente_prodotto SET abilitato=0 WHERE id_prodotto=" . $idProdotto." AND id_comp=".$idComponente;
    $sql = mysql_query($stringSql)
	or die("ERROR IN script_componente_prodotto.php - FUNCTION disabilitaCompProd - ".$stringSql ." ". mysql_error());
return $sql;
}


function abilitaCompProd($idProdotto,$idComponente){
    $stringSql = "UPDATE serverdb.componente_prodotto SET abilitato=1 WHERE id_prodotto=" . $idProdotto." AND id_comp=".$idComponente;
    $sql = mysql_query($stringSql)
	or die("ERROR IN script_componente_prodotto.php - FUNCTION abilitaCompProd - ".$stringSql ." ". mysql_error());
return $sql;
}

?>
