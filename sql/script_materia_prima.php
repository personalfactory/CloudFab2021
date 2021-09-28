<?php

//Tabelle coinvolte
//materia_prima
//lab_materie_prime
//componente

/**
 * Aggiorna il campo scorta_minima di una materia prima nella tabella materia_prima
 * @param type $codice
 * @param type $qtaScortaMinima
 * @return type
 */
function aggiornaScortaMinimaMat($codArtico, $qtaScortaMinima) {
    $stringSql = "UPDATE serverdb.materia_prima 
                SET                  
                    scorta_minima = if(scorta_minima!=" . $qtaScortaMinima . "," . $qtaScortaMinima . ",scorta_minima)                    
                WHERE 
                    cod_mat = '" . $codArtico . "'";
    $sql = mysql_query($stringSql) or die("ERROR IN script_materia_prima - FUNCTION aggiornaScortaMinimaMat - : " . $stringSql . " " . mysql_error());

    return $sql;
}

/**
 * To DO spostare nello script_lab_materie_prime
 * Seleziona tutte le materie prime ed i componenti presenti nella tabella 
 * lab_materie_prime ordinandoli per codice e descrizione che non sono presenti 
 * nella tabella materia_prima
 * @return type
 */
function findAllLabMatNotInProd($prefCodComp, $strUtentiAziende,$codice,$descrizione) {
    $stringSql = "SELECT	*
			FROM
                            serverdb.lab_materie_prime l
                        WHERE
                            cod_mat NOT IN (SELECT cod_mat FROM serverdb.materia_prima)
                         AND 
                            cod_mat NOT LIKE '" . $prefCodComp . "'
                        AND 
                            (l.id_utente,l.id_azienda) IN " . $strUtentiAziende . "  
                        AND 
                            cod_mat like '%".$codice."%'
                        AND 
                            descri_materia like '%".$descrizione."%'
			ORDER BY 
                            l.cod_mat,
                            l.descri_materia";
    $sql = mysql_query($stringSql) or die("ERROR IN script_materia_prima - FUNCTION findAllLabMatNotInProd - : " . $stringSql . " " . mysql_error());
    return $sql;
}

/**
 * Seleziona dalla tabella materia_prima 
 * il numero massimo dei codici del tipo 'comp..'
 * relativo ai componenti
 * @param type $prefissoCodice
 * @return type
 */
function selectMaxNumCodComp($prefissoCodice) {
    $sql = mysql_query("SELECT SUBSTRING(MAX(cod_mat),5) AS max_num_cod
                            FROM 
                                serverdb.materia_prima 
                            WHERE 
                                cod_mat like '" . $prefissoCodice . "%';");
//     or  die("ERROR IN script_materia_prima - FUNCTION selectMaxNumCodComp - SELECT  serverdb.materia_prima  : " . mysql_error());
    return $sql;
}

/**
 * Seleziona una materia prima per codice dalla tabella materia_prima
 * @param type $codice
 * @return type
 */
function findMatPrimaByCodice($codice) {

    $sql = mysql_query("SELECT * FROM serverdb.materia_prima WHERE cod_mat='" . $codice . "'") or die("ERROR IN script_materia_prima - FUNCTION findMatPrimaByCodice - SELECT * FROM serverdb.materia_prima : " . mysql_error());
    return $sql;
}

/**
 * Seleziona tutte le materie prime dalla tabella materia_prima
 * @param type $camoOrdine
 */
function findAllMatPrime($camoOrdine, $strUtentiAziende) {

    $stringSql="SELECT * FROM serverdb.materia_prima 
                        WHERE
                        (id_utente,id_azienda) IN " . $strUtentiAziende . " ORDER BY " . $camoOrdine;
    
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_materia_prima - FUNCTION findAllMatPrime - " .$stringSql . mysql_error());
    return $sql;
}

/**
 * Seleziona tutte le materie prime dalla tabella materia_prima
 * che hanno codice diverso da $tipoCodice
 * @param type $tipoCodice
 * @param type $campoOrdine
 */
function findAllMatPrimeByTipoCod($tipoCodice, $camoOrdine, $strUtentiAziende) {
    $stringSql = "SELECT * FROM serverdb.materia_prima 
                        WHERE 
                            cod_mat NOT LIKE '" . $tipoCodice . "%' 
                        AND
                            (id_utente,id_azienda) IN " . $strUtentiAziende . "                        
                        ORDER BY " . $camoOrdine;
    $sql = mysql_query($stringSql)
            or die("ERROR IN script_materia_prima - FUNCTION findAllMatPrimeByTipoCod - " . $stringSql . " - " . mysql_error());
    return $sql;
}

/**
 * Verifica l'esistenza di una materia prima nella tabella materia_prima
 * facendo una select by codice o nome
 * @param type $codMat
 * @param type $nomeMat
 * @return type
 */
function verificaEsistenzaMatPri($codMat) {

    $sql = mysql_query("SELECT * FROM serverdb.materia_prima 
        WHERE cod_mat = '" . $codMat . "'");
//    or  die("ERROR IN script_materia_prima - FUNCTION verificaEsistenzaMatPri - SELECT * FROM serverdb.materia_prima : " . mysql_error());

    return $sql;
}

/**
 * Modifica tutti i campi di una materia prima nella tabella materia_prima
 * @param type $codMat
 * @param type $descri
 * @param type $uniMis
 * @param type $preAcq
 * @param type $preMed
 * @param type $fornitore
 * @param type $scortaMinima
 * @param type $inventario
 * @param type $dtInventario
 * @param type $giacAttuale
 * @param type $note
 * @return type
 */
function modificaMateriaPrima($codMat, $descri, $uniMis, $preAcq, $preMed, $fornitore, $scortaMinima, $inventario, $dtInventario, $giacAttuale, $note) {

    $stringSql = "UPDATE serverdb.materia_prima SET 
        descri_mat = if(descri_mat != '" . $descri . "','" . $descri . "',descri_mat),
        uni_mis =  if(uni_mis != '" . $uniMis . "','" . $uniMis . "',uni_mis),
        pre_acq =  if(pre_acq != '" . $preAcq . "','" . $preAcq . "',pre_acq),
        pre_med_pon =  if(pre_med_pon != '" . $preMed . "','" . $preMed . "',pre_med_pon),
        fornitore =  if(fornitore != '" . $fornitore . "','" . $fornitore . "',fornitore),
        scorta_minima =  if(scorta_minima != '" . $scortaMinima . "','" . $scortaMinima . "',scorta_minima),
        dt_inventario =  if(inventario != '" . $inventario . "','" . $dtInventario . "',dt_inventario),
        inventario =  if(inventario != '" . $inventario . "','" . $inventario . "',inventario),
        giacenza_attuale =  if(giacenza_attuale != '" . $giacAttuale . "','" . $giacAttuale . "',giacenza_attuale),
        note =  if(note != '" . $note . "','" . $note . "',note)
        WHERE 
            cod_mat = '" . $codMat . "'";
    $sql = mysql_query($stringSql);
    //or die("ERROR IN script_materia_prima - FUNCTION modificaMateriaPrima - " . $stringSql . " - " . mysql_error());

    return $sql;
}

/**
 * Inserisce una nuova materia prima nella tabella materia_prima
 * @param type $famiglia
 * @param type $codice
 * @param type $descri
 * @param type $unitaMisura
 * @param type $prezzoAcq
 * @param type $prezzoMedPon
 * @param type $fornitore
 * @param type $scortaMinima
 * @param type $giacenzaAttuale
 * @param type $note
 * @return type
 */
function insertMatPrima($famiglia, $codice, $descri, $unitaMisura, $prezzoAcq, $prezzoMedPon, $fornitore, $scortaMinima, $giacenzaAttuale, $note, $inventario, $dtInventario, $idUtente, $idAzienda) {

    $sql = mysql_query("INSERT INTO serverdb.materia_prima (
                            famiglia,
                            cod_mat,
                            descri_mat,
                            uni_mis,
                            pre_acq,
                            pre_med_pon,
                            fornitore,
                            scorta_minima,
                            giacenza_attuale,
                            note,
                            inventario,
                            dt_inventario,
                            id_utente,
                            id_azienda)
               VALUES ( '" . $famiglia . "',
                        '" . $codice . "',
                        '" . $descri . "',                       
                        '" . $unitaMisura . "',
                        " . $prezzoAcq . ",
                        " . $prezzoMedPon . ",
                        '" . $fornitore . "',
                        " . $scortaMinima . ",
                        " . $giacenzaAttuale . ",
                        '" . $note . "',
                        " . $inventario . ",
                        '" . $dtInventario . "',
                        " . $idUtente . ",
                        " . $idAzienda . ")")
            or die("ERROR IN script_materia_prima - FUNCTION insertMateriaPrima - INSERT INTO serverdb.materia_prima  : " . mysql_error());
    return $sql;
}

/**
 * Aggiorna il prezzo, prezzo medio ed il fornitore della materia prima 
 * nella tabella materia_prima
 * @param type $codMat
 * @param type $preAcq
 * @param type $preMed
 * @param type $fornitore
 *  * @return type
 */
function aggiornaPrezzoMatPrima($codMat, $preAcq, $preMed, $fornitore) {

    $sql = mysql_query("UPDATE serverdb.materia_prima SET 
                        pre_acq = '" . $preAcq . "',
                        pre_med_pon = '" . $preMed . "',
                        fornitore = '" . $fornitore . "'  
                      WHERE 
                        cod_mat = '" . $codMat . "'");
//    or  die("ERROR IN script_materia_prima - FUNCTION aggiornaPrezzoMatPrima - UPDATE serverdb.materia_prima : " . mysql_error());   

    return $sql;
}

/**
 * Aggiorna i campi giacenza_attuale,inventario e 
 * dt_inventario di una materia_prima
 * @param type $codice
 * @param type $qtaInventario
 * @param type $dtInventario
 * @return type
 */
function aggiornaInvGiacMatPri($codArtico, $qtaInventario, $dtInventario) {
//    $stringSql = "UPDATE serverdb.materia_prima
//                SET                   
//                    giacenza_attuale = if(giacenza_attuale!=" . $qtaInventario . "," . $qtaInventario . ",giacenza_attuale),
//                    dt_inventario = if(inventario!=" . $qtaInventario . ",'" . $dtInventario . "',dt_inventario),
//                    inventario =if(inventario!=" . $qtaInventario . "," . $qtaInventario . ",inventario)
//                WHERE 
//                    cod_mat = '" . $codArtico . "'";
    $stringSql = "UPDATE serverdb.materia_prima
                SET                   
                    giacenza_attuale = " . $qtaInventario . ",
                    dt_inventario = '" . $dtInventario . "',
                    inventario =" . $qtaInventario . "
                WHERE 
                    cod_mat = '" . $codArtico . "'";
    $sql = mysql_query($stringSql) or die("ERROR IN script_materia_prima - FUNCTION aggiornaInvGiacMatPri - : " . $stringSql . " " . mysql_error());

    return $sql;
}

/**
 * Aggiorna la giacenza ed il fornitore della materia prima nella tabella materia_prima
 * @param type $codMat
 * @param type $fornitore
 * @param type $giacAttuale
 * @param type $note
 * @return type
 */
function aggiornaGiacMatPrima($codMat, $fornitore, $giacAttuale) {

    $sql = mysql_query("UPDATE serverdb.materia_prima SET 
                fornitore = '" . $fornitore . "',        
                giacenza_attuale =  '" . $giacAttuale . "'
          WHERE 
                cod_mat = '" . $codMat . "'");
//    or  die("ERROR IN script_materia_prima - FUNCTION aggiornaGiacMatPrima - UPDATE serverdb.materia_prima : " . mysql_error());   

    return $sql;
}

/**
 * Aggiorna il campo prezzo medio della tabella materia prima
 * @param type $codice
 * @param type $prezzoMedio
 */
function aggiornaPrezzoMedioMat($codice, $prezzoMedio) {

    $sql = mysql_query("UPDATE serverdb.materia_prima SET 
                pre_med_pon = '" . $prezzoMedio . "'
          WHERE 
                cod_mat = '" . $codice . "'");
//    or  die("ERROR IN script_materia_prima - FUNCTION aggiornaPrezzoMedioMat - UPDATE serverdb.materia_prima : " . mysql_error());   

    return $sql;
}

/**
 * Aggiorna il campo descrizione della tabella materia prima se è stato modificato
 * @param type $codice
 * @param type $prezzoMedio
 */
function aggiornaDescriMat($codice, $descrizione) {

    $stringSql = "UPDATE serverdb.materia_prima SET 
                    descri_mat = if(descri_mat != '" . $descrizione . "','" . $descrizione . "',descri_mat)
                WHERE 
                    cod_mat = '" . $codice . "'";

    $sql = mysql_query($stringSql);
    //or  die("ERROR IN script_materia_prima - FUNCTION aggiornaDescriMat - " .$stringSql." - ". mysql_error());   

    return $sql;
}

/**
 * Seleziona tutte le materie prime dalla tabella materia_prima in base ai filtri
 * @param type $campoOrdine
 * @param type $campoGroupBy
 * @param type $codice
 * @param type $descri
 * @param type $famiglia
 * @param type $preMed
 * @param type $fornitore
 * @param type $giacenza
 * @param type $dtAbilitato
 * @param type $strUtentiAziende
 * @return type
 */
function selectMatPrimeByFiltri($campoOrdine, $campoGroupBy, $codice, $descri, $famiglia, $scortaMinima, $preAcq, $giacenza, $dtAbilitato, $strUtentiAziende,$condizioneSelect) {

     $stringSql = "SELECT * FROM serverdb.materia_prima
         WHERE 
            cod_mat LIKE '%" . $codice . "%'
         AND 
            descri_mat LIKE '%" . $descri . "%'
         AND
            famiglia LIKE '%" . $famiglia . "%'
         AND 
            scorta_minima LIKE '%" . $scortaMinima . "%'
         AND 
            pre_acq LIKE '%" . $preAcq . "%'
         AND 
            giacenza_attuale LIKE '%" . $giacenza . "%'
         AND 
            dt_abilitato LIKE '%" . $dtAbilitato . "%'
         AND 
            (id_utente,id_azienda) IN " . $strUtentiAziende . "     
         AND
            ".$condizioneSelect."
          GROUP BY " . $campoGroupBy . "       
         ORDER BY " . $campoOrdine;

    $sql = mysql_query($stringSql) or die("ERROR IN script_materia_prima - FUNCTION selectMatPrimeByFiltri -  " . $stringSql . " - " . mysql_error());

    return $sql;
}

//function selectMatPrimeByFiltri($campoOrdine, $campoGroupBy, $codice, $descri, $famiglia, $scortaMinima, $preAcq, $giacenza, $dtAbilitato) {
//
//    $sql = mysql_query("SELECT *,SUM(quanti) AS consumo FROM serverdb.materia_prima m
//            INNER JOIN serverdb.gaz_movmag g ON m.cod_mat=g.artico
//         WHERE 
//            m.cod_mat LIKE '%" . $codice . "%'
//         AND 
//            m.descri_mat LIKE '%" . $descri . "%'
//         AND
//            m.famiglia LIKE '%" . $famiglia . "%'
//         AND 
//            m.scorta_minima LIKE '%" . $scortaMinima . "%'
//         AND 
//            m.pre_acq LIKE '%" . $preAcq . "%'
//         AND 
//            m.giacenza_attuale LIKE '%" . $giacenza . "%'
//         AND 
//            m.dt_abilitato LIKE '%" . $dtAbilitato . "%'
//         AND
//            g.operazione='-1'
//         AND
//            g.dt_mov LIKE '%" . $dtAbilitato . "%'
//         GROUP BY m." . $campoGroupBy . "       
//         ORDER BY m." . $campoOrdine) 
//            or die("ERROR IN script_materia_prima - FUNCTION selectMatPrimeByFiltri - SELECT * serverdb.gaz_movmag : " . mysql_error());
//
//    return $sql;
//}

/**
 * Seleziona il prezzo di tutti i componenti drymix di un prodotto
 * @param type $idProdotto
 * @return type
 */
function findPrezzoCompProdotto($idProdotto) {

    $stringSql = "SELECT pre_acq, componente_prodotto.quantita 
                    FROM 
                            serverdb.materia_prima
                    INNER JOIN serverdb.componente 
                            ON 
                            materia_prima.cod_mat=componente.cod_componente
                    INNER JOIN 
                            serverdb.componente_prodotto 
                            ON
                            componente.id_comp=componente_prodotto.id_comp
                    WHERE 
                            componente_prodotto.id_prodotto='" . $idProdotto . "'";
    $sql = mysql_query($stringSql) or die("ERROR IN script_materia_prima - FUNCTION findPrezzoCompProdotto - " . $stringSql . " : " . mysql_error());

    return $sql;
}

function calcolaConsumo($dataInf, $dataSup, $stringaUtAz) {

    $stringSql1 = "DELETE FROM serverdb.chimica_giacenza";
    $stringSql2 = "DELETE FROM serverdb.chimica_acquisti";
    $stringSql3 = "DELETE FROM serverdb.chimica_consumi";

    $stringSql4 = "INSERT INTO serverdb.chimica_giacenza (artico,descri_artico,inventario,somma_movimenti,giacenza_attuale)
SELECT 
artico,
descri_artico,
ROUND(inventario), 
ROUND(SUM(quanti*operazione)),
inventario+ROUND(SUM(quanti*operazione))
FROM serverdb.gaz_movmag g 
JOIN serverdb.materia_prima m ON g.artico=m.cod_mat 
WHERE 
(dt_doc>'" . $dataInf . "' AND dt_doc<'" . $dataSup . "') 
AND cat_mer=2 
GROUP BY artico
ORDER BY artico";

    $stringSql5 = "INSERT INTO serverdb.chimica_consumi (artico,descri_artico,inventario,consumi) 
SELECT 
artico,
descri_artico,
ROUND(inventario), 
ROUND(SUM(quanti)) 
FROM serverdb.gaz_movmag g 
JOIN serverdb.materia_prima m ON g.artico=m.cod_mat 
WHERE 
(dt_doc>'" . $dataInf . "' AND dt_doc<'" . $dataSup . "') 
AND cat_mer=2 
AND operazione=-1
GROUP BY artico
ORDER BY artico";

    $stringSql6 = "INSERT INTO serverdb.chimica_acquisti (artico,descri_artico,inventario,acquisti)
SELECT 
artico,
descri_artico,
ROUND(inventario), 
ROUND(SUM(quanti)) 
FROM serverdb.gaz_movmag g 
JOIN serverdb.materia_prima m ON g.artico=m.cod_mat 
WHERE 
(dt_doc>'" . $dataInf . "' AND dt_doc<'" . $dataSup . "') 
AND cat_mer=2 
AND operazione=1
GROUP BY artico
ORDER BY artico";

    $stringSql7 = "INSERT INTO serverdb.chimica_acquisti (artico,descri_artico,inventario,acquisti)
SELECT 
artico,
descri_artico,
ROUND(inventario), 
ROUND(SUM(quanti)) 
FROM serverdb.gaz_movmag g 
JOIN serverdb.materia_prima m ON g.artico=m.cod_mat 
WHERE 
(dt_doc>'$dataInf' AND dt_doc<'$dataSup')  
AND cat_mer=2 
AND operazione=1
GROUP BY artico
ORDER BY artico";


    $stringSql8 = "SELECT g.artico,g.descri_artico,g.inventario, IF(c.consumi IS NULL,0,c.consumi) AS consumi, 
IF(a.acquisti IS NULL,0,a.acquisti) AS acquisti, ROUND(g.giacenza_attuale) AS giacenza
FROM serverdb.chimica_giacenza g
LEFT JOIN serverdb.chimica_consumi c ON g.artico=c.artico
LEFT JOIN serverdb.chimica_acquisti a ON g.artico=a.artico";

    $sql1 = true;
    $sql2 = true;
    $sql3 = true;
    $sql4 = true;
    $sql5 = true;
    $sql6 = true;
    $sql7 = true;
    $sql8 = true;

    $sql1 = mysql_query($stringSql1) or die("ERROR IN script_materia_prima - FUNCTION calcolaConsumo stringSql1 - : " . $stringSql1 . " " . mysql_error());
    $sql2 = mysql_query($stringSql2) or die("ERROR IN script_materia_prima - FUNCTION calcolaConsumo stringSql2 - : " . $stringSql2 . " " . mysql_error());
    $sql3 = mysql_query($stringSql3) or die("ERROR IN script_materia_prima - FUNCTION calcolaConsumo stringSql3 - : " . $stringSql3 . " " . mysql_error());
    $sql4 = mysql_query($stringSql4) or die("ERROR IN script_materia_prima - FUNCTION calcolaConsumo stringSql4 - : " . $stringSql4 . " " . mysql_error());
    $sql5 = mysql_query($stringSql5) or die("ERROR IN script_materia_prima - FUNCTION calcolaConsumo stringSql5 - : " . $stringSql5 . " " . mysql_error());
    $sql6 = mysql_query($stringSql6) or die("ERROR IN script_materia_prima - FUNCTION calcolaConsumo stringSql6 - : " . $stringSql6 . " " . mysql_error());
    $sql7 = mysql_query($stringSql7) or die("ERROR IN script_materia_prima - FUNCTION calcolaConsumo stringSql7 - : " . $stringSql7 . " " . mysql_error());
    $sql8 = mysql_query($stringSql8) or die("ERROR IN script_materia_prima - FUNCTION calcolaConsumo stringSql8 - : " . $stringSql8 . " " . mysql_error());

    if (!$sql1 OR ! $sql2 OR ! $sql3 OR ! $sql4 OR ! $sql5 OR ! $sql6 OR ! $sql7)
        $sql8 = false;

    return $sql8;
}

function sommaMovimentiTotMat($codMat,$dataInf, $dataSup, $catMer, $operazione) {

    $stringSql = "SELECT ROUND(SUM(quanti)) AS somma_mov
                FROM serverdb.gaz_movmag g                 
                WHERE 
                (dt_doc>'" . $dataInf . "' AND dt_doc<'" . $dataSup . "') 
                AND artico='".$codMat."'
                AND cat_mer=" . $catMer . "
                AND operazione=" . $operazione ;
                


    $sql = mysql_query($stringSql) or die("ERROR IN script_materia_prima - FUNCTION sommaMovimentiTotMat stringSql - : " . $stringSql . " " . mysql_error());


    return $sql;
}


?>
