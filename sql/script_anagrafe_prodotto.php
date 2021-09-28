<?php
//Tabelle coinvolte
//anagrafe_prodotto

//############# VERIFICA PERMESSO VISUALIZZAZIONE ##########################
//verificaPermessoVisualizzazione($_SESSION['objPermessiVis'], 'anagrafe_prodotto');
/*
//Stringa contenente l'elenco degli id degli utenti prop visibili dall'utente loggato
echo "</br>Utenti proprietari  visibili : ".
        $_SESSION['strUtentiVis']=getUtentiPropVisib($_SESSION['objPermessiVis'], 'anagrafe_prodotto');
        
//Stringa contenente l'elenco degli id delle aziende visibili dall'utente loggato
echo "</br>Aziende visibili  : ". 
        $_SESSION['strAziendeVis']=getAziendeVisib($_SESSION['objPermessiVis'], 'anagrafe_prodotto');
//#############################################################################
*/
/**
 * Seleziona il prodotto padre di un dato prodotto dalla tabella anagrafe_prodotto
 * tramite l' id_prodotto del figlio.
 * Il campo colorato della tabella contiene l'informazione  prodotto padre, 
 * se ha valore 0 vuol dire che si tratta di un prodotto padre, 
 * se ha valore > 0 allora contiene l'id del suo prodotto padre
 * @param type $idProdotto
 * @return type
 */
function findProdottoPadreById($idProdotto){
    
    $strinSql="SELECT colorato FROM serverdb.prodotto WHERE id_prodotto=" . $idProdotto;
    $sql=mysql_query($strinSql) 
            or die("ERROR IN script_anagrafe_prodotto.php - FUNCTION findProdottoPadreById - " .$strinSql." - " . mysql_error());
    return $sql;
}

/**
 * Recupero le informazioni di un prodotto nella tabella prodotto
 * @param type $idProdotto
 * @return type
 */
function findAnagrafeProdottoById($idProdotto){
    
    $strinSql="SELECT * FROM serverdb.anagrafe_prodotto WHERE id_prodotto=" . $idProdotto;
    $sql=mysql_query($strinSql) 
            or die("ERROR IN script_anagrafe_prodotto.php - FUNCTION findAnProdottoById - " .$strinSql." - " . mysql_error());
    return $sql;
}


/**
 * Seleziona alcuni campi della tabella anagrafe_prodotto d
 * el db server con primo_livello selezionato
 * @param unknown $gruppo
 * @param unknown $livelloGruppo
 * @param unknown $connessione
 * @return resource
 */
function selectAnProdByLivAndGruppo($livelloGruppo,$gruppo){

	$strinSql="SELECT *
                        FROM
                            serverdb.anagrafe_prodotto
                        WHERE 
                            (livello_gruppo='".$livelloGruppo."' 
                         AND 
                            gruppo='".$gruppo."')";
	$sql=mysql_query($strinSql)
	or die("ERROR IN script_anagrafe_prodotto.php - FUNCTION selectAnagrafeProdottoByLiv - " .$strinSql." - " . mysql_error());
	return $sql;
}



function selectAnProdPadreByLivAndGruppo($livelloGruppo,$gruppo){

	$strinSql="SELECT * FROM serverdb.anagrafe_prodotto
                        WHERE 
                            colorato=id_prodotto
                         AND
                            (livello_gruppo='".$livelloGruppo."' 
                         AND 
                            gruppo='".$gruppo."')";
	$sql=mysql_query($strinSql)
	or die("ERROR IN script_anagrafe_prodotto.php - FUNCTION selectAnProdPadreByLivAndGruppo - " .$strinSql." - " . mysql_error());
	return $sql;
}

//function selectProdFiglioByPadreGruppo($idProdottoPadre,$livelloGruppo,$gruppo){
//
//	$strinSql="SELECT * FROM
//                            serverdb.anagrafe_prodotto a JOIN serverdb.prodotto p ON a.id_prodotto=p.id_prodotto
//                        WHERE 
//                            colorato=".$idProdottoPadre."
//                         AND 
//                            a.id_prodotto<>$idProdottoPadre
//                         AND
//                            (livello_gruppo='".$livelloGruppo."' 
//                         AND 
//                            gruppo='".$gruppo."')";
//	$sql=mysql_query($strinSql)
//	or die("ERROR IN script_anagrafe_prodotto.php - FUNCTION selectProdFiglioByPadreGruppo - " .$strinSql." - " . mysql_error());
//	return $sql;
//}

function selectProdFiglioByPadre($idProdottoPadre){

	$strinSql="SELECT * FROM
                            serverdb.anagrafe_prodotto a JOIN serverdb.prodotto p ON a.id_prodotto=p.id_prodotto
                        WHERE 
                            colorato=".$idProdottoPadre."
                         AND 
                            a.id_prodotto<>$idProdottoPadre";
	$sql=mysql_query($strinSql)
	or die("ERROR IN script_anagrafe_prodotto.php - FUNCTION selectProdFiglioByPadre - " .$strinSql." - " . mysql_error());
	return $sql;
        
}


/**
 * Aggiorna gruppo e dt_abilitato 
 * nella tabella anagrafe_prodotto di serverdb
 * @param unknown $gruppo
 * @param unknown $gruppoOld
 * @param unknown $livelloGruppo
 * @param unknown $dataCorrente
 * @return resource
 */
function updateGruppoAnagrafeProdotto($gruppo, $gruppoOld,$livelloGruppo, $dataCorrente){

	$strinSql="UPDATE serverdb.anagrafe_prodotto
                        SET 
                                gruppo ='".$gruppo."',
                                dt_abilitato='".$dataCorrente."'
                        WHERE 
                                livello_gruppo='".$livelloGruppo."' 
                        AND 
                                gruppo='".$gruppoOld."'";
	$sql=mysql_query($strinSql);
//	or die("ERROR IN script_anagrafe_prodotto.php - FUNCTION updateServerDBAnagrafeProdotto - " .$strinSql." - " . mysql_error());
	return $sql;
}



/**
 * Seleziona alcuni campi della tabella anagrafe_prodotto del db server per rif geografico
 * @param unknown $tipoRifer
 * @param unknown $tipoRifer
 * @param unknown $connessione
 * @return resource
 */
function selectAnProdByTipoRifAndGeo($tipoRifer,$geografico){

        $strinSql= "SELECT *
                        FROM
                                serverdb.anagrafe_prodotto
                        WHERE 
                                (tipo_riferimento='".$tipoRifer."' AND geografico='".$geografico."')";
	$sql=mysql_query($strinSql)
	or die("ERROR IN script_anagrafe_prodotto.php - FUNCTION selectAnProdByTipoRifAndGeo - " .$strinSql." - " . mysql_error());
	return $sql;
}


/**
 * Seleziona alcuni campi della tabella anagrafe_prodotto del 
 * db server per livelli superiori al primo
 * @param unknown $gruppo2
 * @param unknown $gruppo3
 * @param unknown $gruppo4
 * @param unknown $gruppo5
 * @param unknown $gruppo6
 * @param unknown $connessione
 * @return resource
 */
function selectAnagrafeProdottoByLivelliSuperiori($gruppo2, $gruppo3, $gruppo4, $gruppo5, $gruppo6, $connessione){

	$strinSql="SELECT * FROM
                            serverdb.anagrafe_prodotto
                    WHERE 
                                    (livello_gruppo='SecondoLivello' AND gruppo='".$gruppo2."')
                            OR
                                    (livello_gruppo='TerzoLivello' AND gruppo='".$gruppo3."')
                            OR
                                    (livello_gruppo='QuartoLivello' AND gruppo='".$gruppo4."')
                            OR
                                    (livello_gruppo='QuintoLivello' AND gruppo='".$gruppo5."')
                            OR
                                    (livello_gruppo='SestoLivello' AND gruppo='".$gruppo6."')";

	$sql=mysql_query($strinSql, $connessione)
	or die("ERROR IN script_anagrafe_prodotto.php - FUNCTION selectAnagrafeProdottoByLivelliSuperiori - " .$strinSql." - " . mysql_error());
	return $sql;
}

/**
 * Seleziona alcuni campi del record della tabella anagrafe_prodotto del db server 
 * con filtro su provincia,regione,stato,continente,mondo
 * @param unknown $provincia_old
 * @param unknown $regione_old
 * @param unknown $stato_old
 * @param unknown $continente_old
 * @param unknown $mondo_old
 * @param unknown $connessione
 * @return resource
 * @author FR
 */
function selectAnagrafeProdottoByRiferimentiSuperiori($provincia, $regione, $stato,
		$continente, $mondo){
						
	$strinSql="SELECT * FROM
                                    serverdb.anagrafe_prodotto
                            WHERE 
                                            (tipo_riferimento='Provincia' AND geografico='".$provincia."')
                                    OR
                                            (tipo_riferimento='Regione' AND geografico='".$regione."')
                                    OR
                                            (tipo_riferimento='Stato' AND geografico='".$stato."')
                                    OR
                                            (tipo_riferimento='Continente' AND geografico='".$continente."')
                                    OR
                                            (tipo_riferimento='Mondo' AND geografico='".$mondo."')";

	$sql=mysql_query($strinSql)
	or die("ERROR IN script_anagrafe_prodotto.php - FUNCTION selectAnagrafeProdottoByRiferimentiSuperiori - " .$strinSql." - " . mysql_error());
	return $sql;
}



/**
 * Aggiorna il campo geografico  della tabella anagrafe_prodotto del db server
 * @param unknown $comune
 * @param unknown $comune_old
 * @param unknown $dataCorrente
 */
function updateGeograficoAnagrafeProdotto($geografico, $geograficoOld, $tipoRifer,  $dataCorrente ){

	$stringSql = "UPDATE serverdb.anagrafe_prodotto
                        SET 
                                geografico ='".$geografico."',
                                dt_abilitato='".$dataCorrente."'
                        WHERE 
                                tipo_riferimento='".$tipoRifer."' 
                        AND 
                                geografico='".$geograficoOld."'";
	$sql = mysql_query($stringSql);
	//or die("ERROR IN script_anagrafe_prodotto.php - FUNCTION updateGeograficoAnagrafeProdotto - ".$stringSql ." ". mysql_error());
        return $sql;

}



/** 
 * Inserisce un nuovo record nella tabella anagrafe_prodotto
 * @param type $codice
 * @param type $idProdottoPadre
 * @param type $limiteColore
 * @param type $fattoreDivisore
 * @param type $fascia
 * @param type $mazzetta
 * @param type $idCodice
 * @param type $geografico
 * @param type $tipoRiferimento
 * @param type $gruppo
 * @param type $gruppo
 * @param type $idCategoria
 * @param type $abilitato
 * @param type $dtAbilitato
 */
function insertNuovoAnProd($codice,$idProdottoPadre,$limiteColore,$fattoreDivisore,
        $fascia,$mazzetta,$idCodice,$geografico,$tipoRiferimento,$gruppo,$livelloGruppo,
        $idCategoria,$abilitato,$dtAbilitato){
 $stringSql = "INSERT INTO serverdb.anagrafe_prodotto 
                    (id_prodotto,
                    colorato,
                    lim_colore,
                    fattore_div,
                    fascia,
                    id_mazzetta,
                    id_codice,
                    geografico,
                    tipo_riferimento,
                    gruppo,
                    livello_gruppo,
                    id_cat,
                    abilitato,
                    dt_abilitato) 
            SELECT 
                    prodotto.id_prodotto, 	
                    '" . $idProdottoPadre . "',
                    '" . $limiteColore . "',
                    '" . $fattoreDivisore . "',
                    '" . $fascia . "',
                    '" . $mazzetta . "',
                    '" . $idCodice . "',
                    '" . $geografico . "',
                    '" . $tipoRiferimento . "',
                    '" . $gruppo . "',
                    '" . $livelloGruppo . "',
                    '" . $idCategoria . "',
                    " . $abilitato . ",
                    '" . $dtAbilitato . "'
        FROM
                serverdb.prodotto
        WHERE 
                prodotto.cod_prodotto='" . $codice . "'";


$sql = mysql_query($stringSql);
	//or die("ERROR IN script_anagrafe_prodotto.php - FUNCTION insertNuovoAnProd - ".$stringSql ." ". mysql_error());
return $sql;
}


/**
 * Modifica il campo abilitato della tabella anagrafe prodotto di serverdb
 * @param type $idProdotto
 * @param type $abilitato
 * @return type
 */
function modificaAbilitatoAnProd($idProdotto,$abilitato){
    $stringSql = "UPDATE serverdb.anagrafe_prodotto SET abilitato=".$abilitato." 
        WHERE id_prodotto=" . $idProdotto;
    $sql = mysql_query($stringSql);
	//or die("ERROR IN script_anagrafe_prodotto.php - FUNCTION disabilitaProdottoInAnProd - ".$stringSql ." ". mysql_error());
return $sql;
}


/**
 * Modifica un prodotto dentro la tabella anagrafe_prodotto
 * @param type $idProdotto
 * @param type $idProdottoPadre
 * @param type $abilitato
 * @param type $limiteColore
 * @param type $fattoreDivisore
 * @param type $fascia
 * @param type $mazzetta
 * @param type $idCodice
 * @param type $geografico
 * @param type $tipoRiferimento
 * @param type $gruppo
 * @param type $livelloGruppo
 * @param type $categoria
 * @param type $prodAbilitato
 * @return type
 */
function modificaAnagrafeProd($idProdotto,$idProdottoPadre,$limiteColore,$fattoreDivisore,$fascia,$mazzetta,$idCodice,$geografico,$tipoRiferimento,
        $gruppo,$livelloGruppo,$categoria,$prodAbilitato){
    $stringSql = "UPDATE serverdb.anagrafe_prodotto 
                                SET 
                                        colorato=if(colorato!='" . $idProdottoPadre . "','" . $idProdottoPadre . "',colorato),
                                        lim_colore=if(lim_colore!='" . $limiteColore . "','" . $limiteColore . "',lim_colore),
                                        fattore_div=if(fattore_div!='" . $fattoreDivisore . "','" . $fattoreDivisore . "',fattore_div),
                                        fascia=if(fascia!='" . $fascia . "','" . $fascia . "',fascia),
                                        id_mazzetta=if(id_mazzetta!=" . $mazzetta . "," . $mazzetta . ",id_mazzetta),
                                        id_codice = if(id_codice!='" . $idCodice . "','" . $idCodice . "',id_codice),
                                        geografico=if(geografico!='" . $geografico . "','" . $geografico . "',geografico),
                                        tipo_riferimento=if(tipo_riferimento!='" . $tipoRiferimento . "','" . $tipoRiferimento . "',tipo_riferimento),
                                        gruppo=if(gruppo!='" . $gruppo . "','" . $gruppo . "',gruppo),
                                        livello_gruppo=if(livello_gruppo!='" . $livelloGruppo . "','" . $livelloGruppo . "',livello_gruppo),
                                        id_cat=if(id_cat!=" . $categoria . "," . $categoria . ",id_cat),
                                        abilitato=if(abilitato!=" . $prodAbilitato . "," . $prodAbilitato . ",abilitato),
                                        dt_abilitato=NOW()    
                               WHERE 
                                        id_prodotto=" . $idProdotto;
    $sql = mysql_query($stringSql);
	//or die("ERROR IN script_anagrafe_prodotto.php - FUNCTION modificaAnagrafeProd - ".$stringSql ." ". mysql_error());
return $sql;
}


//##############################################################################
//########################## STORICO ###########################################
//##############################################################################


/**
 * Inserisce un record nella tabella anagrafe_prodotto del db storico
 * @param unknown $idProdotto
 * @param unknown $colorato
 * @param unknown $lim_colore
 * @param unknown $fattore_div
 * @param unknown $fascia
 * @param unknown $id_mazzetta
 * @param unknown $geografico
 * @param unknown $tipo_riferimento
 * @param unknown $gruppo
 * @param unknown $livello_gruppo
 * @param unknown $id_cat
 * @param unknown $abilitato
 * @param unknown $dt_abilitato
 * @return resource
 * @author FR
 */
function insertStoricoAnagrafeProdotto($idProdotto, $colorato, $lim_colore, $fattore_div,
		 $fascia, $id_mazzetta, $id_codice,$geografico, $tipo_riferimento, $gruppo, $livello_gruppo, $id_cat, $abilitato, $dt_abilitato ){

	$strinSql="INSERT INTO storico.anagrafe_prodotto
                    (id_prodotto,colorato,lim_colore,fattore_div,fascia,id_mazzetta,id_codice,
                     geografico,tipo_riferimento,gruppo,livello_gruppo,
                     id_cat,abilitato,dt_abilitato) 
                VALUES(
                                   ".$idProdotto.",
                                   '".$colorato."',
                                   ".$lim_colore.",
                                   ".$fattore_div.",
                                   ".$fascia.",
                                   ".$id_mazzetta.",
                                   ".$id_codice.",
                                   '".$geografico."',
                                   '".$tipo_riferimento."',
                                   '".$gruppo."',
                                   '".$livello_gruppo."',
                                   ".$id_cat.",
                                   ".$abilitato.",
                                   '".$dt_abilitato."')";
	$sql=mysql_query($strinSql);
//	or die("ERROR IN script_anagrafe_prodotto.php - FUNCTION insertStoricoAnagrafeProdotto - " .$strinSql." - " . mysql_error());
	return $sql;
}


/**
 * Recupera tutti i prodotti visibili ad una macchina in base al gruppo
 * @param type $idMacchina
 * @return type
 */
function findProdottiByGruppoPerMacchina($idMacchina){
 $stringSql="SELECT * FROM serverdb.anagrafe_prodotto p, serverdb.gruppo g, serverdb.anagrafe_macchina m 
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
                     GROUP BY 
                        p.id_prodotto, 
                        m.id_macchina, 
                        p.gruppo, 
                        m.gruppo 
                    ORDER BY 
                        p.id_prodotto";

$sql=mysql_query($stringSql);
//	or die("ERROR IN script_anagrafe_prodotto.php - FUNCTION findProdottiByGruppoGeoPerMacchina - " .$strinSql." - " . mysql_error());
	return $sql;

}


/**
 * Seleziona tutti i prodotti visibili ad una macchina in base al riferimento geografico
 * @param type $idMacchina
 * @return type
 */
function findProdottiByRifGeoPerMacchina($idMacchina){
 $stringSql="SELECT * FROM serverdb.anagrafe_prodotto p, serverdb.comune c, serverdb.anagrafe_macchina m 
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
                        GROUP BY 
                          p.id_prodotto, 
                          m.id_macchina, 
                          p.geografico, 
                          m.geografico 
                    ORDER BY 
                        p.id_prodotto";

$sql=mysql_query($stringSql);
//	or die("ERROR IN script_anagrafe_prodotto.php - FUNCTION findProdottiByRifGeoPerMacchina - " .$strinSql." - " . mysql_error());
	return $sql;

}

?>
